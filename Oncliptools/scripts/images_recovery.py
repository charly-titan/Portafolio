#!/usr/bin/python
# -*- coding: utf-8 -*-

import os, time, video_config, sys
from conexion import ConnectDB
from oncliptools import Oncliptools
import datetime
import glob
import json
from boto.s3.key import Key
from boto.s3.connection import S3Connection

oncliptools = Oncliptools(video_config.database_config, video_config.video_config, video_config.brightcove_config, video_config.akamai_config, video_config.galaxy_config)

#conexion a S3
conn = S3Connection(video_config.s3_config["access_key"],video_config.s3_config["secret_key"])
bucket = conn.get_bucket(video_config.s3_config["bucket"])
k = Key(bucket)

#se obtiene el tiempo actual
actime=time.strftime("%d/%m/%Y %H:%M")
actual_time=int(time.mktime(datetime.datetime.strptime(actime,"%d/%m/%Y %H:%M").timetuple()))
#Se empieza a revisar 7 dias antes (604800) o un día antes(86400) por si hay huecos, configurable
make_time=actual_time-86400
if (oncliptools.debug): #************Solo para pruebas locales***********#
        make_time=actual_time-3600#(1hr) 
try:
        while make_time<actual_time:
                #se generan imagenes del min por cada señal en la bd
                signals=oncliptools.getSignalsInfo()
                for signal in signals:
                        #Saltamos las señales de Quantel y tricaster
                        if (signal[2]=="Quantel" or signal[2]=="tricaster"):
                                continue
                        #Revisar si no se han generado las imagenes en este min, ya sea en la señal primaria o secundaria
                        signals_search=oncliptools.getSignalsInfo(signal[2])
                        #print signals_search
                        createImg=1
                        for data in signals_search:
                                signal_id=data[2]
                                images=oncliptools.searchImagesGenerated(signal_id,make_time)
                                if (len(images)>0):
                                        createImg=0
                                        break

                        if (oncliptools.debug) and (createImg==0):
                                        print "No genera del min: "+str(make_time)+" de la señal "+signal[2]
                                        continue
                        if createImg:
                                infoSignal={}
                                infoSignal["signal_id"]=signal[3]
                                infoSignal["signal"]=signal[0]
                                infoSignal["start"]=make_time
                                infoSignal["end"]=make_time+60
                                infoSignal["fileName"]=signal[2]+"_"+str(make_time)
                                infoSignal["directory"]=signal[2]+"/"+str(make_time)
                                quality="-b 150-500"
                                if (oncliptools.debug):
                                        print "Genera imagenes del min: "+str(infoSignal["start"])+" con la señal "+signal[2]
                                        continue
                                
                                #DESCARGANDO SENAL
                                output=oncliptools.downloadVideoBitrates(infoSignal,quality)
                                #Verifica que si se descargo la señal
                                signals_down=glob.glob(video_config.video_config["OUTPUT_DIRECTORY"]+infoSignal["fileName"]+"_*.mp4")
                                
                                if (len(signals_down)==0):
                                        #fallo la señal primaria
                                        if (len(signals_search)==1):
                                                #No se tiene una señal secundaria, se hace el registro en la db con estatus de error
                                                infoSignal["error"]=1
                                                infoSignal["info"]="Fallo signal primaria y no se tiene una signal secundaria de respaldo"
                                                output=oncliptools.insertImagesInfo(infoSignal)
                                                #print output
                                                #Elimina archivos .ts si existen
                                                arch_down=glob.glob(video_config.video_config["OUTPUT_DIRECTORY"]+infoSignal["fileName"]+"_*.*")
                                                for arch in arch_down:
                                                        tem_arch=arch.split("/")
                                                        name_ext=tem_arch[-1].split(".")
                                                        dir_remove=oncliptools.removeTs(name_ext[0],"."+name_ext[1])
                                                        #print dir_remove
                                                continue
                                        else:
                                                infoSignal["signal_id"]=signals_search[1][2]
                                                infoSignal["signal"]=signals_search[1][0]
                                                #DESCARGANDO SENAL SECUNDARIA
                                                output=oncliptools.downloadVideoBitrates(infoSignal,quality)
                                                #Verifica que si se descargo la señal secundaria
                                                signals_down=glob.glob(video_config.video_config["OUTPUT_DIRECTORY"]+infoSignal["fileName"]+"_*.mp4")
                                                if (len(signals_down)==0):
                                                        #Fallo señal secundaria, se hace el registro en la db con estatus de error
                                                        infoSignal["error"]=1
                                                        infoSignal["info"]="Fallo signal secundaria"
                                                        output=oncliptools.insertImagesInfo(infoSignal)
                                                        #print output
                                                        #Elimina archivos .ts si existen
                                                        arch_down=glob.glob(video_config.video_config["OUTPUT_DIRECTORY"]+infoSignal["fileName"]+"_*.*")
                                                        for arch in arch_down:
                                                                tem_arch=arch.split("/")
                                                                name_ext=tem_arch[-1].split(".")
                                                                dir_remove=oncliptools.removeTs(name_ext[0],"."+name_ext[1])
                                                                #print dir_remove
                                                        continue
                                                
                                #Como si descargo señal se continua con el proceso
                                dirCreate=oncliptools.createDir(infoSignal['directory'],1)
                                #print dirCreate

                                for sigdown in signals_down:
                                        #Crea imagenes
                                        output=oncliptools.generateImages(infoSignal,sigdown)
                                        #print output
                                        #verifica las imagenes generadas
                                        images_generated=glob.glob(video_config.video_config["DIRECTORY_MEDIA"]+infoSignal["directory"]+"/"+str(infoSignal["start"])+"_*.png")
                                        if (len(images_generated)>0):
                                                break

                                if (len(images_generated)==0):
                                        #No genero imagenes
                                        infoSignal["error"]=1
                                        infoSignal["info"]="No se generaron las imagenes"
                                        output=oncliptools.insertImagesInfo(infoSignal)
                                        #print output
                                        #Elimina archivos descargados (.mp4 y .ts)
                                        arch_down=glob.glob(video_config.video_config["OUTPUT_DIRECTORY"]+infoSignal["fileName"]+"_*.*")
                                        for arch in arch_down:
                                                tem_arch=arch.split("/")
                                                name_ext=tem_arch[-1].split(".")
                                                dir_remove=oncliptools.removeTs(name_ext[0],"."+name_ext[1])
                                                #print dir_remove
                                        continue
                                else:
                                        #subimos imagenes a S3
                                        infoSignal["thumb_num"]=len(images_generated)
                                        urls=[]
                                        for img in images_generated:
                                                img_list = img.split("/")
                                                img_name = img_list[-1]
                                                #### Solo para pruebas en win
                                                if (oncliptools.debug):
                                                        img_list = img.split("\\")
                                                        img_name = img_list[-1]
                                                #####
                                                #creamos la ruta en el bucket y subimos la img
                                                img_path = "/oncliptools/"+infoSignal["directory"]+"/"+img_name
                                                k.key = img_path
                                                k.set_contents_from_filename(img)
                                                k.set_acl('public-read')
                                                #creamos url
                                                index_key=bucket.get_key(img_path)
                                                index_url=index_key.generate_url(0,query_auth=False, force_http=True)
                                                #print index_url
                                                imagen={}
                                                imagen['name']=img_name
                                                imagen['url']=index_url
                                                urls.append(imagen)

                                        infoSignal["thumb_urls"]=json.dumps(urls,ensure_ascii=False).encode('utf-8')
                                        infoSignal["info"]="Imagenes generadas y enviadas a S3"
                                        output=oncliptools.insertImagesInfo(infoSignal)
                                        #rint output
                                                
                                #borrar imagenes generadas en server y archivos descargados
                                dir_remove=oncliptools.removeVideos(infoSignal["directory"],"")
                                #print dir_remove
                                arch_down=glob.glob(video_config.video_config["OUTPUT_DIRECTORY"]+infoSignal["fileName"]+"_*.*")
                                for arch in arch_down:
                                        tem_arch=arch.split("/")
                                        name_ext=tem_arch[-1].split(".")
                                        dir_remove=oncliptools.removeTs(name_ext[0],"."+name_ext[1])
                                        #print dir_remove

                #endfor                        
                make_time+=60
        #endwhile
        
except Exception as detail:
    print "Unexpected error:", detail
        
