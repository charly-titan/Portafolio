# #########################################################
# Creado: 11 de Mayo 2011
# Autor: Roberto Bautista roberto.bautista@esmas.net
# #########################################################


# #########################################################
#       Importo librerias y dependencias

import os
import sys
import hashlib
import re
from class_generic import Generic
from conexion import ConnectDB
from xml.dom.minidom import Document
from datetime import datetime, timedelta
import memcache

memcaserver1='memcache1:7777'
memcaserver2='memcache2:7777'
mc = memcache.Client([memcaserver1,memcaserver2], debug=1)


min_urls=5
ul_id=''

##flat_files_dir_views='./flat_files/views/'
##flat_files_dir_votes='./flat_files/votes/'
##flat_files_dir_comments='./flat_files/comments/'

flat_files_dir_views='/nfs/nfs2/mediaservice/views/'
flat_files_dir_votes='/nfs/nfs2/mediaservice/votes/'
flat_files_dir_comments='/nfs/nfs2/mediaservice/comments/'

t = datetime.now()
if int(t.strftime("%H"))>9:
    log_date=t.strftime("%Y-%m-%d")
else:
    log_date=(datetime.now()-timedelta(days=1)).strftime("%Y-%m-%d")

def chopUrl(s):
    s=s.replace('http://www.esmas.com/', '')
    s=s.replace('http://www2.esmas.com/', '')
    s=s.replace('http://www.televisadeportes.com/', '')
    s=s.replace('http://www.tvolucion.com/', '')
    s=s.replace('http://televisa.esmas.com/', '')
    s=s.replace('http://www.comerico.com/', '')
    return s

def channel_replace(s):
    s=s.replace('-', '_')
    return s

def getInitialDate(n):
    initial_date=datetime.now() - timedelta(n)
    return str(initial_date.year)+"-"+str(initial_date.month)+"-"+str(initial_date.day)

notin=[
'http://www2.esmas.com/salud/fotos/'
]

NOTIN=" object_id NOT IN ("
for url in notin:
    NOTIN+="'"+hashlib.md5(url).hexdigest()+"',"
NOTIN=NOTIN[:-1]
NOTIN+=")"

##Nombre del Servico
##Tabla en donde buscar
##Tabal de summary vieja (comemnts)
##sub_chanel1
##sub_channel2
##sub_channel3
##sub_channel2 NOT IN
##Nombre clave del archivo flateado
##Numero de urls regresadas
##Rango Maximo de dias para vistas
##Rango Maximo de dias para votos
##Rango Maximo de dias para comentarios
##Liga del home de fotogalerias
services=[
['Televisa Deportes','televisadeportes_fotos','summary_teams_comments',[],[],[],[],[],'deportes',9,12,5,25,'http://televisadeportes.esmas.com/fotogalerias/'],
['Mujer','esmas_fotos','summary_woman_comments',['mujer'],[],[],[],[],'mujer',5,7,15,25,'http://www2.esmas.com/mujer/fotogalerias/'],
##['Salud','esmas_fotos','summary_health_comments',['salud'],[],[],[],['kamasutra-de-pie','kamasutra-el-arriba','kamasutra-acostados','kamasutra-ella-arriba','kamasutra-de-rodillas'],'salud',6,3,10,40,'http://www2.esmas.com/salud/fotos/'],
['Salud','esmas_fotos','summary_health_comments',['salud'],[],[],[],[],'salud',6,7,10,40,'http://www2.esmas.com/salud/fotos/'],
##['ComeRico','esmas_fotos','summary_woman_comments',['mujer'],[],[],[],[],'comerico',10,10,15,25,'http://www.comerico.com/fotos/'],
['ComeRico','comerico_fotos','summary_micro_comments',[],[],[],[],[],'comerico',10,30,25,25,'http://www.comerico.com/fotos/'],
['TD','televisa','summary_micro_comments',['fotogalerias'],['super_clic','futbol_mexicano','boxeo','futbol'],[],[],[],'TD',19,7,5,5,'http://deportes.televisa.com/fotogalerias/'],
['Noticieros','noticieros2_fotos','summary_micro_comments',[],[],[],[],[],'noticieros2',15,7,5,5,'http://noticieros.televisa.com/fotos/'],
['Entretenimiento','televisa_fotos','summary_micro_comments',['farandula','cine','musica','series'],[],[],[],[],'entretenimiento',15,4,5,5,'http://entretenimiento.televisa.com/fotos/'],
['Entretenimiento Fast','televisa_fotos','summary_micro_comments',['farandula','cine','musica','series'],[],[],[],[],'entretenimiento_f',18,1,5,5,'http://entretenimiento.televisa.com/fotos/'],
['Entretenimiento Cine','televisa_fotos','summary_micro_comments',['cine'],[],[],[],[],'entretenimiento_cine',18,5,5,5,'http://entretenimiento.televisa.com/fotos/'],
['Entretenimiento Musica','televisa_fotos','summary_micro_comments',['musica'],[],[],[],[],'entretenimiento_musica',18,5,5,5,'http://entretenimiento.televisa.com/fotos/'],
['Entretenimiento Series','televisa_fotos','summary_micro_comments',['series'],[],[],[],[],'entretenimiento_series',18,5,5,5,'http://entretenimiento.televisa.com/fotos/'],
['Entretenimiento Farandula','televisa_fotos','summary_micro_comments',['farandula'],[],[],[],[],'entretenimiento_farandula',18,5,5,5,'http://entretenimiento.televisa.com/fotos/'],
['Estilo','televisa_fotos','summary_micro_comments',['pareja','salud','maternidad','hogar'],[],[],[],[],'estilo',20,1,5,5,'http://estilodevida.comerico.com/fotos/'],

['Estilo Salud','televisa_fotos','summary_micro_comments',['salud'],[],[],[],[],'estilo_salud',20,1,5,5,'http://estilodevida.comerico.com/fotos/'],
['Estilo Estilo','televisa_fotos','summary_micro_comments',['estilo'],[],[],[],[],'estilo_estilo',20,1,5,5,'http://estilodevida.comerico.com/fotos/'],
['Estilo Maternidad','televisa_fotos','summary_micro_comments',['maternidad'],[],[],[],[],'estilo_maternidad',20,1,5,5,'http://estilodevida.comerico.com/fotos/'],
['Estilo Hombre','televisa_fotos','summary_micro_comments',['hombre'],[],[],[],[],'estilo_hombre',20,1,5,5,'http://estilodevida.comerico.com/fotos/'],
['Estilo Tendencias','televisa_fotos','summary_micro_comments',['tendencias'],[],[],[],[],'estilo_tendencias',20,1,5,5,'http://estilodevida.comerico.com/fotos/'],
['Estilo Hogar','televisa_fotos','summary_micro_comments',['hogar'],[],[],[],[],'estilo_hogar',20,1,5,5,'http://estilodevida.comerico.com/fotos/'],
['Estilo Pareja','televisa_fotos','summary_micro_comments',['pareja'],[],[],[],[],'estilo_pareja',20,1,5,5,'http://estilodevida.comerico.com/fotos/'],

['Entretenimiento_p','esmas_fotos','summary_micro_comments',['entretenimiento'],[],[],[],[],'entretenimiento2_p',15,7,5,5,'http://www.comerico.com/fotos/'],
['Estilo_p','esmas_fotos','summary_micro_comments',['salud','mujer'],[],[],[],[],'estilo_p',15,15,5,5,'http://www.comerico.com/fotos/'],
#['Espectaculos','esmas_fotos','summary_TVprograms_comments',['entretenimiento'],['farandula'],[],[],[],'entretenimiento',9,12,5,30,'http://www2.esmas.com/entretenimiento/fotogalerias/index.php'],
['Noticieros Televisa','esmas_fotos_noticierostelevisa','summary_news_comments',[],[],[],[],[],'noticieros',12,7,15,30,''],
['Telenovelas','esmas_fotos','summary_TVprograms_comments',['entretenimiento'],['telenovelas'],[],[],[],'telenovelas',12,7,5,30,'http://www2.esmas.com/entretenimiento/fotogalerias/index.php'],
['Cine','esmas_fotos','summary_TVprograms_comments',['entretenimiento'],['cine'],[],[],[],'cine',6,12,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television','televisa_fotos','summary_TVprograms_comments',['telenovelas','programas-tv'],[],['fotos'],[],[],'television',15,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],

['Me Pongo de Pie','televisa_fotos','summary_TVprograms_comments',['me-pongo-de-pie'],[],[],[],[],'me_pongo',17,7,15,15,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],

['Television USA','televisa_fotos','summary_TVprograms_comments',['us'],['telenovelas'],[],[],[],'tv_usa',20,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Muchacha','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['muchacha-italiana-viene-a-casarse'],['fotos'],[],[],'tv_muchacha',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Yo No Creo','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['yo-no-creo-en-los-hombres'],['fotos'],[],[],'tv_no_creo',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television La Sombra','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['la-sombra-del-pasado'],['fotos'],[],[],'tv_la_sombra',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Mi Corazon','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['mi-corazon-es-tuyo'],['fotos'],[],[],'tv_mi_corazon',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Hasta el Fin','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['hasta-el-fin-del-mundo'],['fotos'],[],[],'tv_hasta_el_fin',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Los Miserables','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['telemundo'],['los-miserables'],['fotos'],[],'tv_los_miserables',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Acero','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['telemundo'],['senora-acero'],['fotos'],[],'tv_acero',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television En Otra Piel','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['telemundo'],['en-otra-piel'],['fotos'],[],'tv_otra_piel',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Aurora','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['telemundo'],['aurora'],['fotos'],[],'tv_aurora',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Que te Perdone','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['que-te-perdone-dios'],['fotos'],[],[],'tv_perdone_dios',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Amores con Trampa','televisa_fotos','summary_TVprograms_comments',['telenovelas'],['amores-con-trampa'],['fotos'],[],[],'tv_con_trampa',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Hoy','televisa_fotos','summary_TVprograms_comments',['programas-tv'],['hoy'],['fotos'],[],[],'tv_hoy',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television La Rosa','televisa_fotos','summary_TVprograms_comments',['programas-tv'],['la-rosa-de-guadalupe'],['fotos'],[],[],'tv_la_rosa',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Como Dice','televisa_fotos','summary_TVprograms_comments',['programas-tv'],['como-dice-el-dicho'],['fotos'],[],[],'tv_como_dice',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Laura','televisa_fotos','summary_TVprograms_comments',['programas-tv'],['laura'],['fotos'],[],[],'tv_laura',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Estrella2','televisa_fotos','summary_TVprograms_comments',['programas-tv'],['estrella2'],['fotos'],[],[],'tv_estrella2',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Sabadazo','televisa_fotos','summary_TVprograms_comments',['programas-tv'],['sabadazo'],['fotos'],[],[],'tv_sabadazo',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Hermosa Esperanza','televisa_fotos','summary_TVprograms_comments',['programas-tv'],['hermosa-esperanza'],['fotos'],[],[],'tv_esperanza',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],
['Television Series y Mas','televisa_fotos','summary_TVprograms_comments',['programas-tv'],['programas-series-y-mas'],['fotos'],[],[],'tv_series',17,7,15,40,'http://www2.esmas.com/entretenimiento/cine/fotogalerias/'],

['Pasion y Poder','televisa_fotos','summary_micro_comments',['telenovelas'],['pasion_y_poder'],[],[],[],'pasion_y_poder_f',18,1,5,5,'http://television.televisa.com/telenovelas/pasion-y-poder/fotos/'],





#['Telehit','esmas_fotos','summary_telehit_comments',['telehit'],[],[],[],[],'telehit',9,15,30,30,''],
#['Cuentamelove','esmas_fotos','summary_telehit_comments',['telehit'],['cuentamelove'],[],[],[],'cuentamelove',9,5,30,30,''],
#['Platanito','esmas_fotos','summary_telehit_comments',['telehit'],['platanito'],[],[],[],'platanito',9,5,30,30,''],
#['Kristoff','esmas_fotos','summary_telehit_comments',['telehit'],['kristoff'],[],[],[],'kristoff',9,5,30,30,'http://www2.esmas.com/telehit/kristoff/fotogaleria/'],
#['Guerra de chistes','esmas_fotos','summary_telehit_comments',['telehit'],['guerra-de-chistes'],[],[],[],'guerra-de-chistes',9,5,30,30,''],
#['Ritmoson','esmas_fotos','summary_ritmoson_comments',['ritmoson-latino'],[],[],[],[],'ritmoson',6,2,15,30,'http://www2.esmas.com/ritmoson-latino/fotos/']
]


generic = Generic()
con = ConnectDB(generic.config["server_db_ip"],generic.config["server_db_user"],generic.config["server_db_pass"],generic.config["server_db_schema"])
con2 = ConnectDB(generic.config["server_db_ip_gall"],generic.config["server_db_user_gall"],generic.config["server_db_pass_gall"],generic.config["server_db_schema_gall"])
#con3 = ConnectDB(generic.config["server_db_ip"],generic.config["server_db_user"],generic.config["server_db_pass"],generic.config["server_db_schema_comm"])


for service in services:

    where='WHERE '

    if len(service[3]):
        where+='channel IN ('
        for channels in service[3]:
            where+="'"+channel_replace(channels)+"',"

        where=where[:-1]
        where+=") "

    if len(service[4]):
        if len(service[3]):
            where+='AND sub_channel1 IN ('
        else:
            where+=' sub_channel1 IN ('   
        for channels in service[4]:
            where+="'"+channel_replace(channels)+"',"

        where=where[:-1]
        where+=") "

    if len(service[5]):
        if len(service[3]) or len(service[4]):
            where+='AND sub_channel2 IN ('
        else:
            where+=' sub_channel2 IN ('    
        for channels in service[5]:
            where+="'"+channel_replace(channels)+"',"

        where=where[:-1]
        where+=")"

    if len(service[6]):
        where+='AND sub_channel3 IN ('
        for channels in service[6]:
            where+="'"+channel_replace(channels)+"',"

        where=where[:-1]
        where+=") "

    if len(service[7]):
        if where!='WHERE ':
            where+='AND sub_channel2 NOT IN ('
        else:
            where+='sub_channel2 NOT IN ('
        for channels in service[7]:
            where+="'"+channel_replace(channels)+"',"

        where=where[:-1]
        where+=") "


    urls1=[]
    urls2=[]
    urls3=[]

    ##views

    flat_files_dir=flat_files_dir_views
    ul_id='fotogalmasvis'

    order_by=' ORDER BY total DESC '
    group_by=' GROUP BY object_id '
    total='SUM(views) total'

    day_1=getInitialDate(service[10])
    day_2=str(datetime.now().year)+"-"+str(datetime.now().month)+"-"+str(datetime.now().day)
    hour_1=str((datetime.now() - timedelta(hours=6)).hour)
    hour_2=str(datetime.now().hour)

    table='views_day_'+service[1]

    if where!='WHERE ':
        #where2=where+' AND DATEDIFF(CURDATE(),log_date)<='+str(service[10])+ " AND "+NOTIN+""
        where2=where+" AND log_date between '"+day_1+"' AND '"+day_2+"' AND "+NOTIN+" "

        if service[10]==1:
            #where2=where+"AND log_date='"+log_date+"' AND time_hr BETWEEN HOUR(CURTIME())-6 AND HOUR(CURTIME())"
            where2=where+"AND log_date='"+log_date+"' AND time_hr BETWEEN "+hour_1+" AND "+hour_2+ " "
            table='views_hr_'+service[1]

    else:
        #where2=where+'DATEDIFF(CURDATE(),log_date)<='+str(service[10])+ " AND "+NOTIN+""
        where2=where+" log_date between '"+day_1+"' AND '"+day_2+"' AND "+NOTIN+" "
        if service[10]==1:
            where2=where+" log_date='"+log_date+"' AND time_hr BETWEEN "+hour_1+" AND "+hour_2+ " "
            table='views_hr_'+service[1]

    sql="SELECT object_id,"+total+" FROM "+table+" "+where2+group_by+order_by+ "LIMIT "+str(service[9]*2)
    print sql

    try:
        datos=con.select(sql)
        tmp_count=0
        for dato in datos:

            if tmp_count>=service[9]:
                break
            ##Obtenr total de vistas de la nota
            sql2="SELECT object_url url, views FROM summary_"+service[1]+" WHERE object_id='"+dato[0]+"'"
            #print sql2

            try:
                datos2=con.select(sql2)
            except:
                continue

            tmp_datos2=datos2[0][0]

            #if tmp_datos2[-1]=="/":
            #    tmp_datos2=tmp_datos2[:-1]
            
            if tmp_datos2 in urls1:
                continue
            else:
                if service[8]=="TD" or service[8]=="television" or service[8].find("tv_")!=-1 :
                    print tmp_datos2
                    if re.search("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",tmp_datos2):
                        urls1.append(tmp_datos2)
                        tmp_count=tmp_count+1
                    else:
                        continue
                elif service[8]=="entretenimiento_f" or service[8].find("entretenimiento_")!=-1 or service[8].find("estilo")!=-1:
                    print tmp_datos2
                    if re.search("/[0-9]{4,}/",tmp_datos2):
                        urls1.append(tmp_datos2)
                        tmp_count=tmp_count+1
                    else:
                        continue
                else:
                    tmp_count=tmp_count+1
                    urls1.append(tmp_datos2)

        ##print sql
        #print urls1

        if len(urls1)<3:
            print "No regenerado: 2_0_photos_week_"+service[8]+"_views.xml "+str(datetime.now())
            # doc = Document()
            # videos=doc.createElement("photos")
            # doc.appendChild(videos)

            # f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_views.xml",'w+')
            # f.write(doc.toprettyxml(indent="  "))
            # f.close()

            # txt='<ul class="womanGallery rightText galleryCmpUL">'
            # txt+='</ul>'
            # f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_views.html",'w+')
            # f.write(txt)
            # f.close()

        else:

            doc = Document()
            videos=doc.createElement("photos")
            doc.appendChild(videos)

            for url in urls1:
                url_tag=doc.createElement("url")
                url_tag.appendChild(doc.createTextNode(url))
                videos.appendChild(url_tag)

            ##Guardar en Memcache
            mc.set("xml_2_0_photos_week_"+service[8]+"_views", doc.toprettyxml(indent="  "))

            f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_views.xml",'w+')
            f.write(doc.toprettyxml(indent="  "))
            f.close()

            if service[8]=='mujer' or service[8]=='comerico' or service[8]=='salud' or service[8]=='cine'  or service[8]=='entretenimiento' or service[8]=='telenovelas':

                IN="IN ("
                datos=[]
                for tmp in urls1:
                    tmp2=chopUrl(tmp)

                    if tmp2[-1:]!="/":

                        if tmp2[:1]!="/":
                            IN+="'/"+tmp2+"/',"
                            datos.append({'url':tmp,'url2':"/"+tmp2+"/",'title':''})

                            IN+="'"+tmp2+"/',"
                            datos.append({'url':tmp,'url2':tmp2+"/",'title':''})

                            IN+="'/"+tmp2+"',"
                            datos.append({'url':tmp,'url2':"/"+tmp2,'title':''})

                            IN+="'"+tmp2+"',"
                            datos.append({'url':tmp,'url2':tmp2,'title':''})

                        else:
                            IN+="'"+tmp2[1:]+"/',"
                            datos.append({'url':tmp,'url2':tmp2[1:]+"/",'title':''})

                            IN+="'"+tmp2+"/',"
                            datos.append({'url':tmp,'url2':tmp2+"/",'title':''})

                            IN+="'"+tmp2[1:]+"',"
                            datos.append({'url':tmp,'url2':tmp2[1:],'title':''})

                            IN+="'"+tmp2+"',"
                            datos.append({'url':tmp,'url2':tmp2,'title':''})

                    else:

                        if tmp2[:1]!="/":
                            IN+="'/"+tmp2[:-1]+"',"
                            datos.append({'url':tmp,'url2':"/"+tmp2[:-1],'title':''})

                            IN+="'"+tmp2[:-1]+"',"
                            datos.append({'url':tmp,'url2':tmp2[:-1],'title':''})

                            IN+="'/"+tmp2+"',"
                            datos.append({'url':tmp,'url2':"/"+tmp2,'title':''})

                            IN+="'"+tmp2+"',"
                            datos.append({'url':tmp,'url2':tmp2,'title':''})
                        else:
                            IN+="'"+tmp2[1:-1]+"',"
                            datos.append({'url':tmp,'url2':tmp2[1:-1],'title':''})

                            IN+="'"+tmp2[:-1]+"',"
                            datos.append({'url':tmp,'url2':tmp2[:-1],'title':''})

                            IN+="'"+tmp2[1:]+"',"
                            datos.append({'url':tmp,'url2':tmp2[1:],'title':''})

                            IN+="'"+tmp2+"',"
                            datos.append({'url':tmp,'url2':tmp2,'title':''})


                IN=IN[:-1]
                IN+=")"


                if service[8]=='mujer':
                    gal_title='titulo_largo'
                    gal_thumb='thumbnail_top'
                else:
                    gal_title='titulo_galeria'
                    gal_thumb='thumbnail_url'

                SQL_PHOTOS="SELECT "+gal_title+", "+gal_thumb+", url_galeria  FROM galerias WHERE url_galeria "+IN+" limit 9";
                photos=con2.select(SQL_PHOTOS)

                for foto in photos:
                    for i in range(len(datos)):

                        if foto[2]==datos[i]['url2']:
                            datos[i]['title']=foto[0];
                            datos[i]['thumb']=foto[1];

                if service[8]=="mujer":
                    i=0
                    txt='<ul class="womanGallery rightText">'

                    for tmp in datos:
                        if tmp['title']!="":
                            class_even=''
                            if (i%2==1):
                               class_even=' class="even" '
                            txt+='<li'+class_even+'><h5><a href="'+tmp["url"]+'" target="_blank">'+tmp["title"]+'</a></h5><span><a href="'+tmp["url"]+'" target="_blank"><img src="'+tmp["thumb"]+'" width="90" height="120"></a></span></li>'
                            i=i+1
                    txt+='<li class="moreGalleries"><a href='+service[13]+'">Ver m&aacute;s Fotogaler&iacute;as</a></li>'
                    txt+='</ul>'

                elif service[8]=="comerico":
                    i=0

                    txt='<div class="cocina_thumbs" id="tab-1">'
                    txt2='<div id="tabs-1"><div class="container"><div class="wt-gallery"><div class="cpanel"><div id="thumbs-back"></div><div class="thumbnails"><ul>'

                    for tmp in datos:
                        if tmp['title']!="":
                            i=i+1
                            if i<5:
                                txt+='<a href="'+tmp["url"]+'"><img src="'+tmp["thumb"]+'" /><span>'+tmp["title"]+'</span></a>'

                            txt2+='<li><div><a href="'+tmp["url"]+'"><img src="'+tmp["thumb"]+'" alt="'+tmp["title"]+'" /></a></div><p>'+tmp["title"]+'</p></li>'

                    txt+='</div>'
                    txt2+='</ul></div><div id="thumbs-fwd"></div></div></div></div></div>'

                else:
                    txt='<ul id="'+ul_id+'"  class="galleryCmpUL">'
                    for tmp in datos:
                        if tmp['title']!="":
                            txt+='<li><a href="'+tmp["url"]+'" target="_blank"><span style="background-image: url('+tmp["thumb"]+');\"></span></a>'+tmp["title"]+'</li>'
                    txt+='</ul>'
                    ##print txt

                #print info

                ##Guardar en Memcache
                mc.set("html_2_0_photos_week_"+service[8]+"_views", txt)

                f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_views.html",'w+')
                f.write(txt)
                f.close()

                if service[8]=="comerico":
                    ##Guardar en Memcache
                    mc.set("html_2_0_photos_week_"+service[8]+"_views_2", txt)

                    f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_views_2.html",'w+')
                    f.write(txt2)
                    f.close()

    except:

        doc = Document()
        videos=doc.createElement("photos")
        doc.appendChild(videos)

        f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_views.xml",'w+')
        f.write(doc.toprettyxml(indent="  "))
        f.close()

        txt='<ul class="womanGallery rightText galleryCmpUL">'
        txt+='</ul>'
        f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_views.html",'w+')
        f.write(txt)
        f.close()



    ##votes
    # flat_files_dir=flat_files_dir_votes
    # ul_id='fotogalmasvot'

    # order_by=' ORDER BY total DESC '
    # group_by=' GROUP BY object_id '
    # total='SUM(positive_votes) total'
    # table='votes_day_'+service[1]

    # day_1=getInitialDate(service[11])

    # if where!='WHERE ':
    #     #where2=where+' AND DATEDIFF(CURDATE(),log_date)<='+str(service[11])
    #     where2=where+" AND log_date between '"+day_1+"' AND '"+day_2+"' "
    # else:
    #     #where2=where+'DATEDIFF(CURDATE(),log_date)<='+str(service[11])
    #     where2=where+" log_date between '"+day_1+"' AND '"+day_2+"' "

    # sql="SELECT object_id,"+total+" FROM "+table+" "+where2+group_by+order_by+ "LIMIT "+str(service[9]*2)
    # print sql

    # try:
    #     datos=con.select(sql)
    #     tmp_count=0

    #     for dato in datos:

    #         if tmp_count>=service[9]:
    #             break

    #         ##Obtenr total de vistas de la nota
    #         sql2="SELECT object_url url, views FROM summary_"+service[1]+" WHERE object_id='"+dato[0]+"'"
    #         ##print sql2
    #         try:
    #             datos2=con.select(sql2)
    #         except:
    #             continue

    #         tmp_datos2=datos2[0][0]

    #         if tmp_datos2[-1]=="/":
    #             tmp_datos2=tmp_datos2[:-1]
    #         if any(tmp_datos2 in s for s in urls2):
    #             continue
    #         else:
    #             tmp_count=tmp_count+1
    #             urls2.append(datos2[0][0])

    #     ##print sql
    #     ##print urls2

    #     if len(urls2)<3:
    #         ##print "No regenerado: 2_0_photos_week_"+service[8]+"_votes.xml "+str(datetime.now())
    #         doc = Document()
    #         videos=doc.createElement("photos")
    #         doc.appendChild(videos)
    #         f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_votes.xml",'w+')
    #         f.write(doc.toprettyxml(indent="  "))
    #         f.close()

    #         txt='<ul class="womanGallery rightText galleryCmpUL">'
    #         txt+='</ul>'
    #         f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_votes.html",'w+')
    #         f.write(txt)
    #         f.close()

    #     else:

    #         doc = Document()
    #         videos=doc.createElement("photos")
    #         doc.appendChild(videos)

    #         for url in urls2:
    #             url_tag=doc.createElement("url")
    #             url_tag.appendChild(doc.createTextNode(url))
    #             videos.appendChild(url_tag)

    #         ##Guardar en Memcache
    #         mc.set("xml_2_0_photos_week_"+service[8]+"_votes", doc.toprettyxml(indent="  "))

    #         f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_votes.xml",'w+')
    #         f.write(doc.toprettyxml(indent="  "))
    #         f.close()

    #         IN="IN ("


    #         datos=[]
    #         for tmp in urls2:
    #             tmp2=chopUrl(tmp)
    #             IN+="'"+tmp2+"',"
    #             datos.append({'url':tmp,'url2':tmp2,'title':''})

    #             if tmp2[-1:]!="/":
    #                 IN+="'"+tmp2+"/',"
    #                 datos.append({'url':tmp,'url2':tmp2+"/",'title':''})
    #             else:
    #                 IN+="'"+tmp2[:-1]+"',"
    #                 datos.append({'url':tmp,'url2':tmp2[:-1],'title':''})

    #         IN=IN[:-1]
    #         IN+=")"

    #         if service[8]=='mujer':
    #             gal_title='titulo_largo'
    #             gal_thumb='thumbnail_top'
    #         else:
    #             gal_title='titulo_galeria'
    #             gal_thumb='thumbnail_url'

    #         SQL_PHOTOS="SELECT "+gal_title+", "+gal_thumb+", url_galeria  FROM galerias WHERE url_galeria "+IN+" limit 9";
    #         photos=con2.select(SQL_PHOTOS)


    #         for foto in photos:
    #             for i in range(len(datos)):
    #                 if foto[2]==datos[i]['url2']:
    #                     datos[i]['title']=foto[0];
    #                     datos[i]['thumb']=foto[1];

    #         if service[8]=="mujer":
    #             i=0
    #             txt='<ul class="womanGallery rightText">'

    #             for tmp in datos:
    #                 if tmp['title']!="":
    #                     class_even=''
    #                     if (i%2==1):
    #                      class_even=' class="even" '
    #                     txt+='<li'+class_even+'><h5><a href="'+tmp["url"]+'" target="_blank">'+tmp["title"]+'</a></h5><span><a href="'+tmp["url"]+'" target="_blank"><img src="'+tmp["thumb"]+'" width="90" height="120"></a></span></li>'
    #                     i=i+1
    #             txt+='<li class="moreGalleries"><a href='+service[13]+'">Ver m&aacute;s Fotogaler&iacute;as</a></li>'
    #             txt+='</ul>'

    #         elif service[8]=="comerico":
    #             i=0

    #             txt='<div class="cocina_thumbs" id="tab-1">'
    #             txt2='<div id="tabs-1"><div class="container"><div class="wt-gallery"><div class="cpanel"><div id="thumbs-back"></div><div class="thumbnails"><ul>'

    #             for tmp in datos:
    #                 if tmp['title']!="":
    #                     i=i+1
    #                     if i<5:
    #                         txt+='<a href="'+tmp["url"]+'"><img src="'+tmp["thumb"]+'" /><span>'+tmp["title"]+'</span></a>'

    #                     txt2+='<li><div><a href="'+tmp["url"]+'"><img src="'+tmp["thumb"]+'" alt="'+tmp["title"]+'" /></a></div><p>'+tmp["title"]+'</p></li>'

    #             txt+='</div>'
    #             txt2+='</ul></div><div id="thumbs-fwd"></div></div></div></div></div>'


    #         else:

    #             txt='<ul id="'+ul_id+'" class="galleryCmpUL">'
    #             for tmp in datos:
    #                 if tmp['title']!="":
    #                     txt+='<li><a href="'+tmp["url"]+'" target="_blank"><span style="background-image: url('+tmp["thumb"]+');\"></span></a>'+tmp["title"]+'</li>'
    #             txt+='</ul>'
    #             ##print txt

    #         #print info

    #         ##Guardar en Memcache
    #         mc.set("html_2_0_photos_week_"+service[8]+"_votes", txt)

    #         f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_votes.html",'w+')
    #         f.write(txt)
    #         f.close()

    #         if service[8]=="comerico":
    #             ##Guardar en Memcache
    #             mc.set("html_2_0_photos_week_"+service[8]+"_votes_2", txt)

    #             f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_votes_2.html",'w+')
    #             f.write(txt2)
    #             f.close()

    # except:

    #     doc = Document()
    #     videos=doc.createElement("photos")
    #     doc.appendChild(videos)
    #     f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_votes.xml",'w+')
    #     f.write(doc.toprettyxml(indent="  "))
    #     f.close()

    #     txt='<ul class="womanGallery rightText galleryCmpUL">'
    #     txt+='</ul>'
    #     f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_votes.html",'w+')
    #     f.write(txt)
    #     f.close()




    ##Comments
    flat_files_dir=flat_files_dir_comments
    ul_id='fotogalmascomen'

    order_by=' ORDER BY total DESC '
    total='comments total'
    #table=service[2]
    table="summary_"+service[1]
    day_1=getInitialDate(service[12])

    if len(service[4]):
        #where2="WHERE object_url LIKE '%/"+service[4][0]+"/fotos/%'  AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])
        #where2="WHERE object_url LIKE '%/"+service[4][0]+"/%'  AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])
        where2="WHERE object_url LIKE '%/"+service[4][0]+"/%'  AND creation_date between '"+day_1+"' AND '"+day_2+"' "
    elif len(service[3]):
        #where2="WHERE object_url LIKE '%/"+service[3][0]+"/fotos/%'  AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])
        #where2="WHERE object_url LIKE '%/"+service[3][0]+"/%'  AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])
        where2="WHERE object_url LIKE '%/"+service[3][0]+"/%'  AND creation_date between '"+day_1+"' AND '"+day_2+"' "
    else:
        #where2="WHERE object_url LIKE '%/fotos/%' AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])
        #where2="WHERE DATEDIFF(CURDATE(),creation_date)<="+str(service[12])
        where2="WHERE creation_date between '"+day_1+"' AND '"+day_2+"' "


    sql="SELECT object_id,object_url,"+total+" FROM "+table+" "+where2+order_by+ "LIMIT "+str(service[9]*2)
    print sql

    try:
        datos=con.select(sql)
    except:
        print "No regenerado: 2_0_photos_week_"+service[8]+"_comments.xml "+str(datetime.now())
        # doc = Document()
        # videos=doc.createElement("photos")
        # doc.appendChild(videos)

        # f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_comments.xml",'w+')
        # f.write(doc.toprettyxml(indent="  "))
        # f.close()

        # txt='<ul class="womanGallery rightText">'
        # txt+='</ul>'
        # f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_comments.html",'w+')
        # f.write(txt)
        # f.close()

        continue

    tmp_count=0

    for dato in datos:

        if tmp_count>=service[9]:
            break

        tmp_datos2=dato[1]

        if tmp_datos2[-1]=="/":
            tmp_datos2=tmp_datos2[:-1]
        if any(tmp_datos2 in s for s in urls3):
            continue
        else:
            tmp_count=tmp_count+1
            urls3.append(dato[1])

    ##print sql
    #print urls3

    if len(urls3)<3:
        print "No regenerado 2: 2_0_photos_week_"+service[8]+"_comments.xml "+str(datetime.now())
        # doc = Document()
        # videos=doc.createElement("photos")
        # doc.appendChild(videos)

        # f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_comments.xml",'w+')
        # f.write(doc.toprettyxml(indent="  "))
        # f.close()

    else:

        doc = Document()
        videos=doc.createElement("photos")
        doc.appendChild(videos)

        for url in urls3:
            url_tag=doc.createElement("url")
            url_tag.appendChild(doc.createTextNode(url))
            videos.appendChild(url_tag)

        ##Guardar en Memcache
        mc.set("xml_2_0_photos_week_"+service[8]+"_comments", doc.toprettyxml(indent="  "))

        f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_comments.xml",'w+')
        f.write(doc.toprettyxml(indent="  "))
        f.close()

        IN="IN ("


        datos=[]
        for tmp in urls3:
            tmp2=chopUrl(tmp)
            IN+="'"+tmp2+"',"
            datos.append({'url':tmp,'url2':tmp2,'title':''})

            if tmp2[-1:]!="/":
                IN+="'"+tmp2+"/',"
                datos.append({'url':tmp,'url2':tmp2+"/",'title':''})
            else:
                IN+="'"+tmp2[:-1]+"',"
                datos.append({'url':tmp,'url2':tmp2[:-1],'title':''})

        IN=IN[:-1]
        IN+=")"

        if service[8]=='mujer':
            gal_title='titulo_largo'
            gal_thumb='thumbnail_top'
        else:
            gal_title='titulo_galeria'
            gal_thumb='thumbnail_url'

        SQL_PHOTOS="SELECT "+gal_title+", "+gal_thumb+", url_galeria  FROM galerias WHERE url_galeria "+IN+" limit 9";

        photos=con2.select(SQL_PHOTOS)


        for foto in photos:
            for i in range(len(datos)):
                if foto[2]==datos[i]['url2']:
                    datos[i]['title']=foto[0];
                    datos[i]['thumb']=foto[1];

        if service[8]=="mujer":
            i=0
            txt='<ul class="womanGallery rightText">'

            for tmp in datos:
                if tmp['title']!="":
                    class_even=''
                    if (i%2==1):
                       class_even=' class="even" '
                    txt+='<li'+class_even+'><h5><a href="'+tmp["url"]+'" target="_blank">'+tmp["title"]+'</a></h5><span><a href="'+tmp["url"]+'" target="_blank"><img src="'+tmp["thumb"]+'" width="90" height="120"></a></span></li>'
                    i=i+1
            txt+='<li class="moreGalleries"><a href='+service[13]+'">Ver m&aacute;s Fotogaler&iacute;as</a></li>'
            txt+='</ul>'

        elif service[8]=="comerico":
            i=0

            txt='<div class="cocina_thumbs" id="tab-1">'
            txt2='<div id="tabs-1"><div class="container"><div class="wt-gallery"><div class="cpanel"><div id="thumbs-back"></div><div class="thumbnails"><ul>'

            for tmp in datos:
                if tmp['title']!="":
                    i=i+1
                    if i<5:
                        txt+='<a href="'+tmp["url"]+'"><img src="'+tmp["thumb"]+'" /><span>'+tmp["title"]+'</span></a>'

                    txt2+='<li><div><a href="'+tmp["url"]+'"><img src="'+tmp["thumb"]+'" alt="'+tmp["title"]+'" /></a></div><p>'+tmp["title"]+'</p></li>'

            txt+='</div>'
            txt2+='</ul></div><div id="thumbs-fwd"></div></div></div></div></div>'

        else:
            txt='<ul id="'+ul_id+'" class="galleryCmpUL">'
            for tmp in datos:
                if tmp['title']!="":
                    txt+='<li><a href="'+tmp["url"]+'" target="_blank"><span style="background-image: url('+tmp["thumb"]+');\"></span></a>'+tmp["title"]+'</li>'
            txt+='</ul>'
            ##print txt

        #print info

        ##Guardar en Memcache
        mc.set("html_2_0_photos_week_"+service[8]+"_comments", txt)

        f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_comments.html",'w+')
        f.write(txt)
        f.close()

        if service[8]=="comerico":
            ##Guardar en Memcache
            mc.set("html_2_0_photos_week_"+service[8]+"_comments_2", txt)

            f = open(flat_files_dir+"2_0_photos_week_"+service[8]+"_comments_2.html",'w+')
            f.write(txt2)
            f.close()


