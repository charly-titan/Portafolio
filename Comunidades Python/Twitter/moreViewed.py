import urllib2
from datetime import datetime
from time import localtime, strftime
import time
import ftplib

start_time = localtime()

import urllib2
#import libxml2
import re, string
import htmlentitydefs

class JSONViews:
    
    global entity_map,pattern
    
    def __init__(self):
        self.pattern = re.compile(r"[&<>\"\x80-\xff]+")
        self.entity_map = {}

        for i in range(256):
            self.entity_map[chr(i)] = "&#%d;" % i

        for entity, char in htmlentitydefs.entitydefs.items():
            if self.entity_map.has_key(char):
                self.entity_map[char] = "&%s;" % entity

  
    def get_html(self,url):
        #response = urllib2.urlopen(url)
        request = urllib2.Request(url, headers={"User-Agent" : "facebookexternalhit/1.1 (+https://www.facebook.com/externalhit_uatext.php)"})
        html = urllib2.urlopen(request).read()
        #html = response.read()
        return html

    
    def get_urls(self,html):
        urls=[]
        urls1 = re.findall(r'http://[\w\d:#@%/;$~_?\+-=\\\.&]*', html)
        return  urls1

        print "--------------**********"

        mainxml = libxml2.parseDoc(html)
        nodes=mainxml.xpathEval('/notes/url/text()')
        for n in  nodes:
            urls.append(str(n).strip())
        return urls

    
    def escape_entity(self,m):
        return string.join(map(self.entity_map.get, m.group()), "")

    
    def escape(self,string):
        return self.pattern.sub(self.escape_entity, string)

    
    def dictionary(self,texto):
        description = re.compile('<(.*)>', re.IGNORECASE)
        result = description.findall(texto)
        for d in result[0]:
            texto=texto.replace(d,"")
        return texto


    def find_meta(self,type,texto):
        try:
        #<link rel="image_src" href="http://i2.esmas.com/2012/06/27/389186/helicoptero-panther-de-la-marina--120x90.jpg" />
            description = re.compile('<(meta|link) (name|rel|property|itemprop)([ ])?=([ ])?"'+type+'" (content|href)([ ]=4>)?= *([ ])?"(.*)"([ ])?([/])?([ ])?>', re.IGNORECASE)
            result = description.findall(texto)
            
            #print "----------------"
            #print type
            #print result
            #print "----------------"
            if(result):
                for d in result[0]:
                    if(d!="meta" and d!="link" and d!="name" and d!="rel" and d!="content" and d!="href" and d!="" and d!="property" and d!="itemprop" ):
                        #print self.escape(d.replace('\'','"')), "**"
                        #return self.escape(d.replace('\'','"'))
                        #return d.replace('\'','"').decode('utf8').encode('iso-8859-1')
                        return d.replace('\'','"')
            return ""
        except():
            return ""

    def get_class(self, url):
        if url.find('/foro-tv')!=-1 or (url.find('/programas')!=-1 and url.find('/fotos')==-1) or url.find('/opinion')!=-1 or url.find('/videos')!=-1:
            return "video-corner"
        elif url.find('/fotos')!=-1 or url.find('/galerias')!=-1 :
            return "photo-corner"
        else: 
            return ""

    def get_channel(self, url):
        tmp=url.split('/')
        try:
            return tmp[3]
        except:
            return ""
       

config_mxm={"arrive_path":"./arrive/",
            "working_path":"./working/",
            "storage_path":"./storage/",
            "error_path":"./error_log/",
            #"ftp_server":'ftp.impactando.net',
            #"ftp_user":'impactan',
            #"ftp_pass":'3wlwiz65izke',
            #"ftp_path":'/public_html/pruebas/',
            "ftp_server":'storagemas.upload.akamai.com',
            "ftp_user":'galaxstg',
            "ftp_pass":'h96f79uE',
            "ftp_path":'/124199/comunidades/twitter/',
            "log_file":"mxm.log",
            "control_file":"control.json",
            "mxm_file":"mxm.json",
            "length_array":30,
            "cycle_time":3,
            "debug":1,
            "sed_path":""}
            #"sed_path":"/usr/local/bin/"}

class Upload_Mxm:
    
    global start_time,info_time,debug,config, ftp,entity_map,pattern

    def __init__(self,config):
        self.config=config


    def connect_ftp(self):
        self.ftp = ftplib.FTP(self.config["ftp_server"],self.config["ftp_user"],self.config["ftp_pass"])
        self.move_to_dir(self.config["ftp_path"])
        return 1


    def upload_file(self,fname):
        tname=fname.split("/")
        if(tname[len(tname)-1]!=""):
            f = open(fname,'rb')
            self.ftp.storbinary('STOR '+tname[len(tname)-1], f)         # Send the file
            f.close()
            return 1
        return 0


    def move_to_dir(self,path):
        try:
            self.ftp.cwd(path)
            return 1
        except:
            if(self.debug):
                print "El directorio "+path+" no existia, se procede a crearlo"

        tpath=path.split("/")
        rpath="/"
        for p in tpath:
            if(p!=""):
                rpath+=p+"/"
                try:
                    self.ftp.cwd(rpath)
                except:
                    self.ftp.mkd(rpath)
                    self.ftp.cwd(rpath)
        return 1


services=[
['Bailando por un Sueno Noticias','bailando_noticias.json',9,'bailando_noticias','bailando_noticias',6],
['Bailando por un Sueno Videos','bailando_videos.json',9,'bailando_videos','bailando_videos',6],
['Bailando por un Sueno Fotos','bailando_galerias.json',9,'bailando_galerias','bailando_galerias',6],
#['Mundial Brazil 2014','brazil2014.json',5,'brazil2014','masleido',3],
['TD','deportes.json',5,'deportes','masleido',3],
['TDRGA','TD.json',5,'TD','masleido',3],
#['Entretenimiento','entretenimiento.json',9,'entretenimiento','masleido',5],
['Fotos Deportes','gall_td.json',9,'TD','masleido',7],
['Fotos Noticieros','gall_noticieros.json',9,'noticieros2','masleido',7],
#
['Fotos Entretenimiento','gall_entretenimiento.json',9,'entretenimiento','masleido',7],
['Fotos Entretenimiento F','gall_entretenimiento_f.json',9,'entretenimiento_f','masleido',7],
['Fotos Entretenimiento Cine','gall_entretenimiento_cine.json',9,'entretenimiento_cine','masleido',7],
['Fotos Entretenimiento Musica','gall_entretenimiento_musica.json',9,'entretenimiento_musica','masleido',7],
['Fotos Entretenimiento Series','gall_entretenimiento_series.json',9,'entretenimiento_series','masleido',7],
['Fotos Entretenimiento Farandula','gall_entretenimiento_farandula.json',9,'entretenimiento_farandula','masleido',7],
#
#['Entretenimiento','entretenimeinto_v_cine.json',9,'entretenimiento_v_cine','masleido',7],
#['Entretenimiento','entretenimeinto_v_musica.json',9,'entretenimeinto_v_musica','masleido',7],
#['Entretenimiento','entretenimeinto_v_series.json',9,'entretenimeinto_v_series','masleido',7],
#['Entretenimiento','entretenimeinto_v_farandula.json',9,'entretenimeinto_v_farandula','masleido',7],
#
#['Entretenimiento','entretenimeinto_cine.json',9,'entretenimiento_cine','masleido',7],
#['Entretenimiento','entretenimeinto_musica.json',9,'entretenimeinto_musica','masleido',7],
#['Entretenimiento','entretenimeinto_series.json',9,'entretenimeinto_series','masleido',7],
#['Entretenimiento','entretenimeinto_farandula.json',9,'entretenimeinto_farandula','masleido',7],
#
['Fotos Estilo','gall_estilo.json',9,'estilo','masleido',7],
['Fotos Estilo Salud','gall_estilo_salud.json',9,'estilo_salud','masleido',7],
['Fotos Estilo Estilo','gall_estilo_estilo.json',9,'estilo_estilo','masleido',7],
['Fotos Estilo Maternidad','gall_estilo_maternidad.json',9,'estilo_maternidad','masleido',7],
['Fotos Estilo Hombre','gall_estilo_hombre.json',9,'estilo_hombre','masleido',7],
['Fotos Estilo Tendencias','gall_estilo_tendencias.json',9,'estilo_tendencias','masleido',7],
['Fotos Estilo Hogar','gall_estilo_hogar.json',9,'estilo_hogar','masleido',7],
['Fotos Estilo Pareja','gall_estilo_pareja.json',9,'estilo_pareja','masleido',7],

['Fotos Entretenimiento P','gall_entretenimiento2.json',9,'entretenimiento2_p','masleido',7],
['Fotos Estilo P','gall_estilo2.json',9,'estilo_p','masleido',7],
['Estilo de vida','estilo.json',9,'estilo','masleido',6],
['Estilo de vida 2','estilo2.json',9,'estilo2','masleido',6],
['Fotos Television','gall_television.json',9,'television','masleido',7],
['Fotos TV Muchacha','gall_tv_muchacha.json',9,'tv_muchacha','masleido',7],
['Fotos No Creo','gall_tv_no_creo.json',9,'tv_no_creo','masleido',7],
['Fotos La Sombra','gall_tv_la_sombra.json',9,'tv_la_sombra','masleido',7],
['Fotos Mi Corazon','gall_tv_mi_corazon.json',9,'tv_mi_corazon','masleido',7],
['Fotos Hasta el Fin','gall_tv_hasta_el_fin.json',9,'tv_hasta_el_fin','masleido',7],
['Fotos Los Miserables','gall_tv_los_miserables.json',9,'tv_los_miserables','masleido',7],
['Fotos Acero','gall_tv_acero.json',9,'tv_acero','masleido',7],
['Fotos Otra Piel','gall_tv_otra_piel.json',9,'tv_otra_piel','masleido',7],
['Fotos Aurora','gall_tv_aurora.json',9,'tv_aurora','masleido',7],
['Fotos Que te Perdone','gall_tv_perdone_dios.json',9,'tv_perdone_dios','masleido',7],
['Fotos Con Trampa','gall_tv_con_trampa.json',9,'tv_con_trampa','masleido',7],
['Fotos Hoy','gall_tv_hoy.json',9,'tv_hoy','masleido',7],
['Fotos La Rosa','gall_tv_la_rosa.json',9,'tv_la_rosa','masleido',7],
['Fotos Como Dice','gall_tv_como_dice.json',9,'tv_como_dice','masleido',7],
['Fotos Laura','gall_tv_laura.json',9,'tv_laura','masleido',7],
['Fotos Estrella2','gall_tv_estrella2.json',9,'tv_estrella2','masleido',7],
['Fotos Sabadazo','gall_tv_sabadazo.json',9,'tv_sabadazo','masleido',7],
['Fotos Esperanza','gall_tv_esperanza.json',9,'tv_esperanza','masleido',7],
['Fotos Series','gall_tv_series.json',9,'tv_series','masleido',7],
['Fotos Television USA','gall_tv_usa.json',9,'tv_usa','masleido',7],

#['Estilo Salud','estilo_salud.json',9,'estilo_salud','masleido',6],
#['Estilo Estilo','estilo_estilo.json',9,'estilo_estilo','masleido',6],
#['Estilo Maternidad','estilo_maternidad.json',9,'estilo_maternidad','masleido',6],
#['Estilo Hombre','estilo_hombre.json',9,'estilo_hombre','masleido',6],
#['Estilo Tendencias','estilo_tendencias.json',9,'estilo_tendencias','masleido',6],
#['Estilo Hogar','estilo_hogar.json',9,'estilo_hogar','masleido',6],
#['Estilo Pareja','estilo_pareja.json',9,'estilo_pareja','masleido',6],
['Me Pongo Noticias','me_pongo.json',5,'me_pongo','masleido',4],
['Me Pongo Videos','me_pongo_v.json',5,'me_pongo_v','masleido',4],
['Fotos Me Pongo','gall_me_pongo.json',5,'me_pongo','masleido',4],
['Videos Deportes','deportes_videos.json',9,'videos2','masleido',7],

['Videos Deportes videos','deportes_v.json',9,'deportes_televisa_global','masleido',7],
['Videos Futbol Internacional','futbol_internacional_v.json',9,'futbol_internacional','masleido',7],
['Videos Futbol Mexicano','futbol_mexicano_v.json',9,'futbol_mexicano','masleido',7],
['Videos Coleccion Privada','coleccion_privada_v.json',9,'coleccion_privada','masleido',7],
['Videos Futbol Retro','futbol_retro_v.json',9,'retro','masleido',7],
['Videos Seleccion Mexicana','seleccion_mexicana_v.json',9,'seleccion_mexicana','masleido',7],
['Videos Boxeo','boxeo_v.json',9,'boxeo','masleido',7],
['Videos Martes Knock Out','martes_knock_out_v.json',9,'martes_knock_out','masleido',7],
['Videos Programas Tv','programas_tv_v.json',9,'programas_tv','masleido',7],
['Videos Deporte','deporte_v.json',9,'deporte','masleido',7],
['Videos Noticiero TD','noticiero_td_v.json',9,'noticiero_td','masleido',7],
['Videos Tribunal TD','tribunal_td_v.json',9,'tribunal_td','masleido',7],
['Videos Accion','accion_v.json',9,'accion','masleido',7],
['Videos Jugada','jugada_v.json',9,'jugada','masleido',7],
['Videos Latitudes','latitudes_v.json',9,'latitudes','masleido',7],
['Videos Conecta TD','conecta_td_v.json',9,'conecta_td','masleido',7],
['Videos TD Style','td_style_v.json',9,'td_style','masleido',7],
['Videos Cuerpo Perfecto','cuerpo_perfecto_v.json',9,'cuerpo_perfecto','masleido',7],
['Videos TDN','tdn_v.json',9,'tdn','masleido',7],
['Videos Videoblogs','videoblogs_v.json',9,'videoblogs','masleido',7],
['Videos Noticias','noticias_v.json',9,'noticias','masleido',7],
['Videos Web TD','web_td_v.json',9,'web_td','masleido',7],
['Videos Piojometeme','_piojometeme_v.json',9,'piojometeme','masleido',7],
['Videos Copa America','copa_america_v.json','copa_america','masleido',7],
['Videos Copa Oro','copa_oro_v.json',9,'copa_oro','masleido',7],
['Videos Mas Deporte','mas_deporte_v.json',9,'mas_deporte','masleido',7],

['Televisa General','televisa_general.json',35,'televisa_general','masleido',7],

['Videos Televisa Deportes US','televisa_deportes_us_v.json',9,'televisa_deportes_us','masleido',7],
['Videos Televisa Deportes US Futbol','televisa_deportes_us_futbol_v.json',9,'televisa_deportes_us_futbol','masleido',7],
['Videos Televisa Deportes US Goles Semana','televisa_deportes_us_goles_semana_v.json',9,'televisa_deportes_us_goles_semana','masleido',7],
['Videos Televisa Deportes US Box','televisa_deportes_us_box_v.json',9,'televisa_deportes_us_box','masleido',7],
['Videos Televisa Deportes US Otros Deportes','televisa_deportes_us_otros_deportes_v.json',9,'televisa_deportes_us_otros_deportes','masleido',7],
['Videos Televisa Deportes US Luchas','televisa_deportes_us_luchas_v.json',9,'televisa_deportes_us_luchas','masleido',7],

['Pasion y Poder','pasion_y_poder_v.json',9,'pasion_y_poder','masleido',7],
['Fotos Pasion y Poder','gall_pasion_y_poder.json',9,'pasion_y_poder_f','masleido',7],

['Bandamax','bandamax.json',9,'bandamax','masleido',7],
['Fotos Bandamax','f_bandamax.json',6,'f_bandamax_general','masleido',3],
['Videos Bandamax','v_bandamax.json',9,'v_bandamax_general','masleido',3],

['Unicable','unicable.json',9,'unicable','masleido',7],
['Fotos Unicable','f_unicable.json',6,'f_unicable_general','masleido',3],
['Videos unicable','v_unicable.json',9,'v_unicable_general','masleido',3],

['Videos canalgolden','v_canalgolden.json',9,'canalgolden','masleido',7],

]

j=JSONViews()

for service in services:

    mfile=service[1]
    max_items=5
    #xml_url='http://comentarios.esmas.com/apis/readNotes.php?type='+service[3]+'&orderby=views'
    #html = j.get_html(xml_url)
    
    file_name='/nfs/nfs2/mediaservice/views/2_0_notes_week_'+service[3]+'_views.xml';
    if service[1].find("gall_")!=-1:
        file_name='/nfs/nfs2/mediaservice/views/2_0_photos_week_'+service[3]+'_views.xml';
    #file_name='2_0_photos_week_'+service[3]+'_views.xml';
    #print file_name
    try:
        f = open(file_name, 'r')
    except:
        print "No existe archivo -"+file_name+"- en NFS"
        continue

    html=f.read()
    
    urls=j.get_urls(html)

    items=[]
    items2=[]
    for u in urls:
        item={}

        if(u.find('</url')!=-1):
            u = u.replace('</url','')
        
        try:
            page_info=j.get_html(u)
        except:
            print "prohibido"
            continue
        
        page_info = re.sub('<!--(.*?)-->','', page_info)
        #print page_info

        item["description"]=""
        item["title"]=""
        item["thumbnail"]=""
        item["url"]=""
        item["topico"]=""
        item["icon_class2"]="hidden"
        item["channel"]=""
        item["duration"]=""
        item["release_date"]=""

        try:
            
            if(service[0].find("Videos ")!=-1):
                item["description"]=j.find_meta("[dD]escription",page_info).decode('utf8').encode('iso-8859-1')
            else:
                item["description"]=j.find_meta("[dD]escription",page_info)

            
            if(service[0].find("Videos ")!=-1):
                duration= int(j.find_meta("video:duration",page_info))
                item['duration'] = str(time.strftime("%M:%S", time.gmtime(duration)).lstrip('0')).zfill(4)

                release_date = j.find_meta("video:release_date",page_info)
                r_d = datetime.strptime(release_date.replace("T"," "), '%Y-%m-%d %H:%M:%S')
                item['release_date'] = r_d.strftime('%d/%m/%Y')

            #print item["description"]
            if item["description"]=="":
                tmp_description = re.search('<\n*\r* *div\n*\r* *class=["|\']art_bullet_01["|\']\n*\r* *>\n*\r* *<\n*\r* *div\n*\r* *class=["|\']articles["|\']\n*\r* *>\n*\r* *<\n*\r* *ul\n*\r* *>\n*\r* *<\n*\r* *li\n*\r* *>(.*?)\n*\r* *<\n*\r* */li\n*\r* *>\n*\r* *<\n*\r* */ul\n*\r* *>\n*\r* *<\n*\r* */div\n*\r* *>\n*\r* *<\n*\r* */div\n*\r* *>', page_info, re.IGNORECASE | re.DOTALL)
                if tmp_description and  tmp_description.group(1)!='':
                    tmp_description=tmp_description.group(1).replace('\n', '').strip()
                    try:
                        #print tmp_description
                        tmp_description=tmp_description.decode('utf8').encode('iso-8859-1')
                    except:
                        pass
                    item["description"]=tmp_description
            
            if(service[0].find("Videos ")!=-1):
                item["title"]=j.find_meta("title",page_info).decode('utf8').encode('iso-8859-1')
            else:
                item["title"]=j.find_meta("title",page_info)

            if service[0]=="TDRGA" or service[0]=="Fotos Deportes" or service[0]=="Fotos Noticieros" or service[0]=="Fotos Television" or service[1].find("gall_tv_")!=-1 or service[0]=="Fotos Bandamax" or service[0]=="Fotos Unicable" or service[0]=="Unicable" or service[0]=="Bandamax" :
                item["title"]=item["title"].decode('utf8').encode('iso-8859-1')
            
            if item["title"]=="":
                tmp_title = re.search('<\n*\r* *title\n*\r* *>\n*\r*(.*?)\n*\r*<\n*\r* */\n*\r* *title\n*\r* *>', page_info, re.IGNORECASE | re.DOTALL)
                if tmp_title and tmp_title.group(1)!='':
                    tmp_title=tmp_title.group(1).replace('\n', '').strip()
                    try:
                        tmp_title=tmp_title.decode('utf8').encode('iso-8859-1')
                        #print tmp_title+"---"
                    except:
                        try:
                            #tmp_title=tmp_title.decode('utf8').encode('ascii','ignore')
                            tmp_title=tmp_title.replace('\xe2\x80\x98',"")
                            tmp_title=tmp_title.replace('\xe2\x80\x99',"")
                            tmp_title=tmp_title.replace('"',"")
                            tmp_title=tmp_title.replace("'","")
                            tmp_title=tmp_title.decode('utf8').encode('iso-8859-1')
                            #print tmp_title+"+++"
                        except:
                            pass
                    item["title"]=tmp_title 
                    #print item["title"]

            item["thumbnail"]=j.find_meta("image_src_masleido",page_info)
            item["thumbnail"]=item["thumbnail"].strip()
            
            
            if item["thumbnail"]=="":
                if(service[0].find("Videos ")!=-1):
                    item["thumbnail"]=j.find_meta("og:image",page_info).replace('624.351','300.169')
                    item["thumbnail"]=item["thumbnail"].strip()
                else:
                    item["thumbnail"]=j.find_meta("og:image",page_info)
                    item["thumbnail"]=item["thumbnail"].strip()

            
            if item["thumbnail"]=="":
            
                if service[3]!="estilo":    
                    tmp_thumbnail = re.search('<\n*\r* *img\n*\r* *src=["|\'](.*?)["|\']\n*\r*.*width="6[0-9]{2}".*/* *>', page_info, re.IGNORECASE )  
                    if tmp_thumbnail and tmp_thumbnail.group(1)!='':
                        tmp_thumbnail=tmp_thumbnail.group(1).replace('\n', '').strip()
                        item["thumbnail"]=tmp_thumbnail.strip()
                        print "**"
                else:
                    tmp_thumbnail = re.search('<\n*\r* *img\n*\r*.* *src=["|\'](.*?)["|\']\n*\r*.*width="300".*>', page_info, re.IGNORECASE )
                    if tmp_thumbnail and tmp_thumbnail.group(1)!='':
                        tmp_thumbnail=tmp_thumbnail.group(1).replace('\n', '').strip()
                        item["thumbnail"]=tmp_thumbnail.strip()
                        print "**-"
            

            if item["thumbnail"]=="":
                tmp_thumbnail = re.search('<\n*\r* *img\n*\r* *src=["|\'](.*?)["|\']\n*\r* *alt="?" *id=["|\']img_stage_01_IMG["|\'] */* *>', page_info, re.IGNORECASE )  
                if tmp_thumbnail and tmp_thumbnail.group(1)!='':
                    tmp_thumbnail=tmp_thumbnail.group(1).replace('\n', '').strip()
                    # try:
                    #     tmp_thumbnail=tmp_thumbnail.decode('utf8').encode('iso-8859-1')

                    # except:
                    #     pass
                    item["thumbnail"]=tmp_thumbnail.strip()
                    print "***"

            if item["thumbnail"]=="":

                if(service[0].find("Videos ")!=-1):
                    item["thumbnail"]=j.find_meta("image_src",page_info).replace('624.351','300.169')
                    item["thumbnail"]=item["thumbnail"].strip()
                else:
                    item["thumbnail"]=j.find_meta("image_src",page_info)
                    item["thumbnail"]=item["thumbnail"].strip()

            if item["thumbnail"]=="":

                if(service[0].find("Videos ")!=-1):
                    item["thumbnail"]=j.find_meta("image",page_info).replace('624.351','300.169')
                    item["thumbnail"]=item["thumbnail"].strip()
                else:
                    item["thumbnail"]=j.find_meta("image",page_info)
                    item["thumbnail"]=item["thumbnail"].strip()

            item["topico"]=j.find_meta("topico",page_info) 
                    
            item["url"]=u
            
            print item["title"]
            temporal=item["thumbnail"].split('"')
            item["thumbnail"]=temporal[0]
            print item["thumbnail"]
            print item["url"]
            item["url"]=item["url"].replace('noticieros2.',"noticieros.")


            item["title"]=str(item["title"]).replace("None","")
            item["description"]=str(item["description"]).replace("None","")
            item["thumbnail"]=str(item["thumbnail"]).replace("None","")

            item["title"]=str(item["title"]).replace('"',"")
            item["description"]=str(item["description"]).replace('"',"")
            
            item["title"]=str(item["title"]).replace('\xe2\x80\x98',"")
            item["description"]=str(item["description"]).replace('\xe2\x80\x98',"")

            item["title"]=str(item["title"]).replace('\xe2\x80\x99',"")
            item["description"]=str(item["description"]).replace('\xe2\x80\x99',"")

            item["title"]=str(item["title"]).replace('"',"")
            item["title"]=str(item["title"]).replace("'","")
            item["icon_class"]=j.get_class(u)

            if item["icon_class"]=="video-corner":
                item["icon_class2"]="tvsagui-video"
            elif item["icon_class"]=="photo-corner":
                item["icon_class2"]="tvsagui-foto"   
            
            #item["channel"]=j.get_channel(u).upper()
            if item["topico"]!="":
                if service[0]=="TDRGA" or service[0]=="Fotos Deportes" or service[0]=="Fotos Noticieros":
                    item["topico"]=item["topico"].decode('utf8').encode('iso-8859-1')
                item["channel"]=item["topico"]
            else:
                item["channel"]=j.get_channel(u).capitalize()

            if item["title"]=="Error | Deportes" or re.search("/no_clean_url/",item["url"]) or item["title"]=="Estilo de vida - Error 404":
                print item["title"] +" -- "+item["url"]
                continue
            
            #print item["title"]
            #print item["description"]
            #print item["thumbnail"]
            #print " "
            tmp_url=item["url"].split(".foto-")
            item["url"]=tmp_url[0]
            tmp_url2=item["url"].split(".photo-")
            item["url"]=tmp_url2[0]
            if item["url"][-1]!="/":
                item["url"]+="/"
            if(item["url"]!="" and item["title"].strip()!="" and item["thumbnail"]!=""):
                if(len(items)<service[2]):
                    if item["url"] not in items2:
                        items.append(item)
                        items2.append(item["url"])

        except:
            continue
    
    if len(items)<service[5]:
        print "***NO actualizado el servicio: "+service[1]+"***"
        continue

    #print unicode(items,ignore)
    #masleido_text="Tempo.prepare(\""+str(service[4])+"\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items).replace("'",'"')+");"
    
    if service[1].find("gall_estilo")!=-1 or service[1].find("gall_entretenimiento")!=-1 or service[1].find("gall_pasion_y_poder.json")!=-1 :
        masleido_text_1="Tempo.prepare(\"masleido_top\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[0]).replace("'",'"')+");"
        masleido_text_1+="Tempo.prepare(\"masleido_bottom1\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[1:5]).replace("'",'"')+");"
        masleido_text_1+="Tempo.prepare(\"masleido_bottom2\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[5:9]).replace("'",'"')+");try{mv.init();}catch(e){}"
        masleido_text_1+='try{ for(var i=0; i<$("#masleido img").length; i++){ $("#masleido img:eq("+i+")").attr("src", $("#masleido img:eq("+i+")").attr("data-src"));} }catch(e){}'

        masleido_text_2="Tempo.prepare(\"masleido_1\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[0:3]).replace("'",'"')+");"
        masleido_text_2+="Tempo.prepare(\"masleido_2\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[3:6]).replace("'",'"')+");"
        masleido_text_2+="try{Tempo.prepare(\"masleido_3\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[6:9]).replace("'",'"')+");}catch(e){};"
        masleido_text_2+='try{ for(var i=0; i<$("#masleido img").length; i++){ $("#masleido img:eq("+i+")").attr("src", $("#masleido img:eq("+i+")").attr("data-src"));} }catch(e){}'


        try:
            f = open(mfile, 'w')
            f.write(masleido_text_2)
            f.close()

            f = open("n_"+mfile, 'w')
            f.write(masleido_text_1)
            f.close()
        except:
            pass

        u=Upload_Mxm(config_mxm)
        u.connect_ftp()
        u.move_to_dir("/124199/comunidades/views/")
        u.upload_file(mfile)
        u.upload_file("n_"+mfile)

        continue

    elif service[0]=="Entretenimiento" or service[0]=="Entretenimiento2" or service[0]=="Estilo de vida" or service[1].find("estilo_")!=-1 or service[0]=="Fotos Entretenimiento F" or service[0]=="Pasion y Poder" or service[0]=="Fotos Bandamax" or service[0]=="Fotos Unicable" or service[0]=="Unicable" or service[0]=="Bandamax" :
        masleido_text="Tempo.prepare(\"masleido_top\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[0]).replace("'",'"')+");"
        masleido_text+="Tempo.prepare(\"masleido_bottom1\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[1:5]).replace("'",'"')+");"
        #masleido_text+="Tempo.prepare(\"masleido_bottom2\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[5:9]).replace("'",'"')+");try{$('.mv-relacionado-container').owlCarousel({items:1,navigation:true,customNavigation:true,lazyLoad:true,controlClass:\"owl-nav\",navClass:[\"mv-prev\",\"mv-next\"],responsive:true,singleItem:true,mouseDrag:false,touchDrag:false});}catch(e){}"
        masleido_text+="Tempo.prepare(\"masleido_bottom2\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[5:9]).replace("'",'"')+");try{mv.init();}catch(e){}"
        masleido_text+='try{ for(var i=0; i<$("#masleido img").length; i++){ $("#masleido img:eq("+i+")").attr("src", $("#masleido img:eq("+i+")").attr("data-src"));} }catch(e){}'
    elif service[1].find("gall_")!=-1 and service[0]!="Fotos Me Pongo" :
        masleido_text="Tempo.prepare(\"masleido_1\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[0:3]).replace("'",'"')+");"
        masleido_text+="Tempo.prepare(\"masleido_2\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[3:6]).replace("'",'"')+");"
        masleido_text+="try{Tempo.prepare(\"masleido_3\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items[6:9]).replace("'",'"')+");}catch(e){};"
        masleido_text+='try{ for(var i=0; i<$("#masleido img").length; i++){ $("#masleido img:eq("+i+")").attr("src", $("#masleido img:eq("+i+")").attr("data-src"));} }catch(e){}'
    ###############################################################################################
    ###################################### FUTOBOL INTERNACIONAL ##################################
    elif service[0]=="Videos Futbol Internacional" or service[0].find("Videos ")!=-1:
        masleido_text="Tempo.prepare(\""+str(service[4])+"\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'})"
        masleido_text+=".when(TempoEvent.Types.RENDER_STARTING, function (event) {viewEvents.loadingJson('start');})"
        masleido_text+=".when(TempoEvent.Types.RENDER_COMPLETE, function (event) {viewEvents.loadingJson('end');viewEvents.scroll_carousel();})"
        masleido_text+=".prepend("+str(items).replace("'",'"')+");"
    ###############################################################################################
    ###############################################################################################
    else:
        masleido_text="Tempo.prepare(\""+str(service[4])+"\", {'var_braces' : '\\\\[\\\\[\\\\]\\\\]', 'tag_braces' : '\\\\[\\\\?\\\\?\\\\]'}).prepend("+str(items).replace("'",'"')+");"
    
    print masleido_text
   
    try:
        f = open(mfile, 'w')
        f.write(masleido_text)
        f.close()
    
    except:
        pass
    u=Upload_Mxm(config_mxm)
    u.connect_ftp()
    u.move_to_dir("/124199/comunidades/views/")
    u.upload_file(mfile)

