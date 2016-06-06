#!/usr/bin/python
# -*- coding: utf-8 -*-

# #########################################################
#       Importo librerias y dependencias

import os, time, subprocess, hashlib, video_config, sys, random
from conexion import ConnectDB
from oncliptools import Oncliptools
from datetime import datetime
import logging
# #########################################################
#       Importo librerias y dependencias
daemon_active=1
#fingerPrint = oncliptools.md5Checksum('video.py')

while daemon_active:
        
        #Esperamos unos segundos para volver a iniciar el ciclo
        #if( fingerPrint != oncliptools.md5Checksum('video.py') ):
        #        print "Se cierra el proceso para iniciar en la nueva version"
        #        daemon_active=0
        #else:
        #        time.sleep(10)

        
        #procesa el id_video que se le pasa como parametro
        oncliptools = Oncliptools(video_config.database_config, video_config.video_config, video_config.brightcove_config, video_config.akamai_config, video_config.galaxy_config)
        video_id=0;
        if len(sys.argv) >= 2:
                video_id=sys.argv[1]
        else:
                #Si solo esta corriendo el proceso, leer la bd para saber que video esta pendiente
                videos=oncliptools.getVideoPending()
                for vid in videos:
                        video_id=str(vid[0])

        if video_id:
                
                PROCESS_START=time.time()
                log=oncliptools.saveProgressVideo(video_id)
                infoVideo=oncliptools.getVideoInfo(video_id)
                propertiesVideo=oncliptools.getVideoProperties(video_id)
                signal=oncliptools.getValueProperty(propertiesVideo,"channel")                
                infoSignal =oncliptools.getSignalsInfo(signal)
                infoVideoSignal=oncliptools.getVideoSignalInfo(infoSignal[0],video_id)

                file_log=video_config.brightcove_config["XML_PATH"]+infoVideoSignal["fileName"]+"_"+str(time.time())+".log"
                
                logging.basicConfig(filename=file_log,level=logging.DEBUG,format='%(asctime)s %(message)s')
                logging.debug("[[ S:PROCESANDO VOD ID %s: %s ]]",video_id,PROCESS_START)
                #print "[[ S:PROCESANDO VOD ID ",video_id,":",time.time()," ]]"
                

                logging.debug("[[ S:CREANDO DIRECTORIO: %s ]]",time.time())
                dirCreate=oncliptools.createDir(infoVideoSignal['directory'],1)
                logging.debug("%s",dirCreate)
                logging.debug("[[ E:CREANDO DIRECTORIO: %s ]]",time.time())
                
                logging.debug("[[ S:DESCARGANDO SENALES DE AKAMAI: %s ]]",time.time())
                log=oncliptools.saveProgressVideo(video_id,1)
                outputVideo=oncliptools.downloadVideoBitrates(infoVideoSignal,"0")
                logging.debug("%s",outputVideo)
                logging.debug("[[ E:DESCARGANDO SENALES DE AKAMAI: %s ]]",time.time())
                
        
                logging.debug("[[ S:GUARDANDO BITRATES EN BD: %s ]]",time.time())
                #log=oncliptools.saveProgressVideo(video_id,2)
                bitrates = oncliptools.getBitRates(infoVideoSignal['fileName'])
                logging.debug("%s",bitrates)
                if not(len(bitrates)):
                        logging.debug("Error en la señal primaria, obteniendo señales de la secundaria")
                        infoSignal =oncliptools.getSignalsInfo(signal)
                        if len(infoSignal)==1:
                                logging.warning("[[ No hay archivos descargados y solo se tiene configurada 1 señal, favor de verificar. PROCESO TERMINADO: %s]]",time.time())
                                #print "No hay archivos descargados, favor de verificar los datos"
                                log=oncliptools.saveProgressVideo(video_id,11,"fin")
                                break
                        else:
                                infoVideoSignal["signal"] = signal[1][0]
                                logging.debug("[[ S:DESCARGANDO SENALES DE AKAMAI --Señal secundaria--: %s ]]",time.time())
                                log=oncliptools.saveProgressVideo(video_id,1)
                                outputVideo=oncliptools.downloadVideoBitrates(infoVideoSignal,"0")
                                logging.debug("%s",outputVideo)
                                logging.debug("[[ E:DESCARGANDO SENALES DE AKAMAI --Señal secundaria--: %s ]]",time.time())
                                logging.debug("[[ S:GUARDANDO BITRATES EN BD --Señal secundaria--: %s ]]",time.time())
                                bitrates = oncliptools.getBitRates(infoVideoSignal['fileName'])
                                logging.debug("%s",bitrates)
                                if not(len(bitrates)):
                                        logging.warning("[[ Fallo señal secundaria, favor de verificar. PROCESO TERMINADO: %s]]",time.time())
                                        log=oncliptools.saveProgressVideo(video_id,11,"fin")
                                        break
                                
                                
                bitrate_quality_relationship = oncliptools.processBitRates(bitrates)
                logging.debug("%s",bitrate_quality_relationship)
                log_bitrates = oncliptools.saveVideosBitratesRelationship(bitrate_quality_relationship,video_id)
                logging.debug("[[ E:GUARDANDO BITRATES EN BD: %s ]]",time.time())
                
                if ("onlyMaster" in infoVideoSignal) or ("generateMaster" in infoVideoSignal): 
                        logging.debug("[[ S:GENERANDO SOLAMENTE MASTER: %s ]]",time.time())
                        qualitiesBit=oncliptools.getQualitiesBitRates(video_id,"0")
                        log=oncliptools.saveProgressVideo(video_id,7)
                        log=oncliptools.updateVideosBitratesRelationship(video_id,qualitiesBit[0][0],0)
                        oncliptools.processQualityVideo(infoVideoSignal,qualitiesBit[0])
                        logging.debug("[[ E:GENERANDO SOLAMENTE MASTER: %s ]]",time.time())
                        logging.debug("[[ S:CREANDO DIRECTORIO EN MASTER: %s ]]",time.time())
                        dirCreate=oncliptools.createDir(infoVideoSignal['directory'],0)
                        logging.debug("%s",dirCreate)
                        logging.debug("[[ E:CREANDO DIRECTORIO EN MASTER: %s ]]",time.time())
                        logging.debug("[[ S:MOVIENDO MASTER: %s ]]",time.time())
                        copy_master=oncliptools.copyVideos(infoVideoSignal['directory']+"/"+infoVideoSignal['fileName']+"-"+qualitiesBit[0][0]+".mp4", infoVideoSignal['directory']+"/"+infoVideoSignal['fileName']+"-"+qualitiesBit[0][0]+".mp4",0)
                        logging.debug(" %s ",copy_master)
                        logging.debug("[[ E:MOVIENDO MASTER: %s ]]",time.time())
                        
                        
                        if "generateMaster" in infoVideoSignal:
                                logging.debug("[[ S:INSERTANDO PROPIEDAD MASTER: %s ]]",time.time())
                                insert_master=oncliptools.insertPropertyVideo(video_id,infoVideoSignal['reference_guid'],'master','on')
                                logging.debug(" %s ",insert_master)
                                logging.debug("[[ E:INSERTANDO PROPIEDAD MASTER: %s ]]",time.time())
                                
                        logging.debug("[[ S:ELIMINANDO VIDEOS PROCESADOS: %s ]]",time.time())
                        bitratesDelete = oncliptools.getBitRates(infoVideoSignal['fileName'])
                        logging.debug("%s",bitratesDelete)
                        for bitDel in bitratesDelete:
                                log=oncliptools.removeTs(infoVideoSignal['fileName']+"_"+str(bitDel))
                                logging.debug("%s",log)
                                log=oncliptools.removeTs(infoVideoSignal['fileName']+"_"+str(bitDel),"mp4")
                                logging.debug("%s",log)

                        dir_remove=oncliptools.removeVideos(infoVideoSignal['directory'],"")
                        logging.debug("%s",dir_remove)
                        logging.debug("[[ E:ELIMINANDO VIDEOS PROCESADOS: %s ]]",time.time())

                        PROCESS_END=time.time()
                        log=oncliptools.saveProgressVideo(video_id,11,"fin")
                        log=oncliptools.insertNotificationVideo(video_id)
                        logging.debug("%s",log)
                        logging.debug("[[E:PROCESANDO VOD ID %s: %s ]]",video_id,PROCESS_END)
                        #print "[[ E:PROCESANDO VOD:",time.time()," ]]"
                        logging.debug(" %s - %s",PROCESS_END, PROCESS_START)
                        break
                
                qualitiesBit=oncliptools.getQualitiesBitRates(video_id,"all_except_0")
                logging.debug("%s",qualitiesBit)
                for quality in qualitiesBit:
                        pid=random.randint(1000,10000)#para el caso que se ejecute un hilo por cada quality se guarda el nombre del hilo
                        paso=2 if quality[0]=="150" else 3 if quality[0]=="235" else 4 if quality[0]=="480" else 5 if quality[0]=="600" else 6 if quality[0]=="970" else 7;
                        log=oncliptools.saveProgressVideo(video_id,paso)
                        log=oncliptools.updateVideosBitratesRelationship(video_id,quality[0],pid)
                        oncliptools.processQualityVideo(infoVideoSignal,quality)
                        #verificar videos de bitrates iguales y crear sus copias
                        videoCopy=oncliptools.getQualitiesBitRates(video_id,1,quality[1])
                        for qualitySame in videoCopy:
                                if quality[0]!=qualitySame[0]:
                                        logging.debug("[[ S:COPIANDO VIDEOS DE BITRATES IGUALES: %s ]]",time.time())
                                        log_bitrate=oncliptools.copyVideos(infoVideoSignal['directory']+"/"+infoVideoSignal['fileName']+"-"+quality[0]+".mp4", infoVideoSignal['directory']+"/"+infoVideoSignal['fileName']+"-"+qualitySame[0]+".mp4",1)
                                        log=oncliptools.updateVideosBitratesRelationship(video_id,qualitySame[0],pid)
                                        logging.debug("%s",log_bitrate)
                                        logging.debug("[[ E:COPIANDO VIDEOS DE BITRATES IGUALES: %s ]]",time.time())
                                        
                        for qualitySame in videoCopy:
                                if qualitySame[0]!='0':
                                        logging.debug("[[ S:SUBIENDO A AKAMAI: %s ]]",time.time())
                                        log=oncliptools.saveProgressVideo(video_id,paso+0.1)
                                        log_bitrate=oncliptools.uploadAkamaiVideo(video_id,infoVideoSignal,qualitySame[0])
                                        logging.debug(" %s ",log_bitrate)
                                        logging.debug("[[ E:SUBIENDO A AKAMAI: %s ]]",time.time())
                                
                                        
                logging.debug("[[ S:GENERANDO THUMBNAILS: %s ]]",time.time())
                log=oncliptools.saveProgressVideo(video_id,8)
                thumnail=oncliptools.generateThumbnails(infoVideoSignal,"160x90")
                logging.debug("%s ",thumnail)
                thumnail_still=oncliptools.generateThumbnails(infoVideoSignal,"854x480","-STILL")
                logging.debug("%s ",thumnail_still)
                logging.debug("[[ E:GENERANDO THUMBNAILS: %s ]]",time.time())
                

                logging.debug("[[ S:SUBIENDO THUMBNAILS A AKAMAI: %s ]]",time.time())
                #log=oncliptools.saveProgressVideo(video_id,5.1)
                logUpload=oncliptools.uploadAkamaiThumb(infoVideoSignal,infoVideoSignal['fileName']+".jpg")
                logging.debug("%s ",logUpload)
                logUpload=oncliptools.uploadAkamaiThumb(infoVideoSignal,infoVideoSignal['fileName']+"-STILL.jpg")
                logging.debug("%s ",logUpload)
                logging.debug("[[ E:SUBIENDO THUMBNAILS A AKAMAI: %s ]]",time.time())
                


                if "galaxy_node" in infoVideoSignal:
                        logging.debug("[[ S:SUBIENDO VIDEO A GALAXY: %s ]]",time.time())
                        log=oncliptools.saveProgressVideo(video_id,9)
                        log_galaxy=oncliptools.uploadGalaxy(infoVideoSignal)
                        logging.debug("%s ",log_galaxy)
                #if "cq5deportes_node" in infoVideoSignal:
                #        log_galaxy=oncliptools.uploadGalaxy(infoVideoSignal,"cq5deportes")
                #        logging.debug("%s ",log_galaxy)
                #if ("galaxy_node" in infoVideoSignal) or ("cq5deportes_node" in infoVideoSignal):
                        log_galaxy=oncliptools.uploadGalaxy(infoVideoSignal,"iphone")
                        logging.debug("%s ",log_galaxy)
                        log_galaxy=oncliptools.uploadGalaxy(infoVideoSignal,"ipad")
                        logging.debug("%s ",log_galaxy)
                        log_galaxy=oncliptools.uploadGalaxy(infoVideoSignal,"m3u8")
                        logging.debug("%s ",log_galaxy)
                        log_galaxy=oncliptools.uploadGalaxy(infoVideoSignal,"hds")
                        logging.debug("%s ",log_galaxy)
                        logging.debug("[[ E:SUBIENDO VIDEO A GALAXY: %s ]]",time.time())

                logging.debug("[[ S:SUBIENDO XML A BRIGHTCOVE: %s ]]",time.time())
                log=oncliptools.saveProgressVideo(video_id,10)
                log_xml=oncliptools.createXML(infoVideoSignal)
                output=oncliptools.uploadBrightcove(log_xml)
                logging.debug("%s ",output)
                logging.debug("[[ E:SUBIENDO XML A BRIGHTCOVE: %s ]]",time.time())

                if "cq5deportes_node" in infoVideoSignal:
                        logging.debug("[[ S:PUSH BRIGHTCOVE: %s ]]",time.time())
                        log_galaxy=oncliptools.pushBrightcove(infoVideoSignal,video_id)
                        logging.debug("%s ",log_galaxy)
                        logging.debug("[[ E:PUSH BRIGHTCOVE: %s ]]",time.time())

                if "master" in infoVideoSignal:
                        logging.debug("[[ S:GENERANDO MASTER: %s ]]",time.time())
                        qualitiesBit=oncliptools.getQualitiesBitRates(video_id,"0")
                        log=oncliptools.saveProgressVideo(video_id,7)
                        log=oncliptools.updateVideosBitratesRelationship(video_id,qualitiesBit[0][0],0)
                        #si ya existe master ya no lo procesa
                        pathVideo=video_config.video_config['DIRECTORY_MEDIA']+infoVideoSignal['directory']+"/"+infoVideoSignal['fileName']+"-0.mp4"
                        if not(os.path.exists(pathVideo)):
                                oncliptools.processQualityVideo(infoVideoSignal,qualitiesBit[0])
                        logging.debug("[[ E:GENERANDO MASTER: %s ]]",time.time())
                        logging.debug("[[ S:CREANDO DIRECTORIO EN MASTER: %s ]]",time.time())
                        dirCreate=oncliptools.createDir(infoVideoSignal['directory'],0)
                        logging.debug("%s",dirCreate)
                        logging.debug("[[ E:CREANDO DIRECTORIO EN MASTER: %s ]]",time.time())
                        logging.debug("[[ S:MOVIENDO MASTER: %s ]]",time.time())
                        copy_master=oncliptools.copyVideos(infoVideoSignal['directory']+"/"+infoVideoSignal['fileName']+"-"+qualitiesBit[0][0]+".mp4", infoVideoSignal['directory']+"/"+infoVideoSignal['fileName']+"-"+qualitiesBit[0][0]+".mp4",0)
                        logging.debug(" %s ",copy_master)
                        logging.debug("[[ E:MOVIENDO MASTER: %s ]]",time.time())
                        
                logging.debug("[[ S:ELIMINANDO VIDEOS PROCESADOS: %s ]]",time.time())
                bitratesDelete = oncliptools.getBitRates(infoVideoSignal['fileName'])
                logging.debug("%s",bitratesDelete)
                for bitDel in bitratesDelete:
                        log=oncliptools.removeTs(infoVideoSignal['fileName']+"_"+str(bitDel))
                        logging.debug("%s",log)
                        log=oncliptools.removeTs(infoVideoSignal['fileName']+"_"+str(bitDel),".mp4")
                        logging.debug("%s",log)

                dir_remove=oncliptools.removeVideos(infoVideoSignal['directory'],"")
                logging.debug("%s",dir_remove)
                logging.debug("[[ E:ELIMINANDO VIDEOS PROCESADOS: %s ]]",time.time())
                

                PROCESS_END=time.time()
                log=oncliptools.saveProgressVideo(video_id,11,"fin")
                log=oncliptools.insertNotificationVideo(video_id)
                logging.debug("%s",log)
                logging.debug("[[E:PROCESANDO VOD ID %s: %s ]]",video_id,PROCESS_END)
                #print "[[ E:PROCESANDO VOD:",time.time()," ]]"
                logging.debug(" %s - %s",PROCESS_END, PROCESS_START)
                break
                                
        else:
                print "Sin videos que procesar"
                time.sleep(10)
                break

                
