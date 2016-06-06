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
import pycurl
#from BeautifulSoup import BeautifulSoup
##from bs4 import BeautifulSoup
from HTMLParser import HTMLParser
import xml.etree.ElementTree as ET


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
if int(t.strftime("%H"))>8:
    log_date=t.strftime("%Y-%m-%d")
else:
    log_date=(datetime.now()-timedelta(days=1)).strftime("%Y-%m-%d")

generic = Generic()

NOTIN=" object_id NOT IN ("
for url in generic.notin:
    NOTIN+="'"+hashlib.md5(url).hexdigest()+"',"

NOTIN=NOTIN[:-1]
NOTIN+=")"


def chopUrl(s):
    s=s.replace('http://www.esmas.com/', '')
    s=s.replace('http://www2.esmas.com/', '')
    s=s.replace('http://www.televisadeportes.com/', '')
    s=s.replace('http://www.tvolucion.com/', '')
    s=s.replace('http://televisa.esmas.com/', '')
    return s

def channel_replace(s):
    s=s.replace('-', '_')
    return s

def getInitialDate(n):
    initial_date=datetime.now() - timedelta(n)
    return str(initial_date.year)+"-"+str(initial_date.month)+"-"+str(initial_date.day)

##Nombre del Servico
##Tabla en donde buscar
##Tabal se summary vieja (comemnts)
##sub_chanel1
##sub_channel2
##sub_channel3
##sub_channel2 NOT IN
##Nombre clave del archivo flateado
##Numero de urls regresadas
##Rango Maximo de dias para vistas
##Rango Maximo de dias para votos
##Rango Maximo de dias para comentarios
services=[
#['Noticieros Televisa','esmas_noticierostelevisa','summary_news_comments',[],[],[],[],[],'noticierostelevisa',10,1,15,3],
['Noticieros2','noticieros2','summary_micro_comments',[],[],[],[],[],'noticieros2',8,2,15,3],
['Noticieros Mexico','noticieros2','summary_micro_comments',['mexico'],[],[],[],[],'NT_mexico',5,1,15,3],
['Noticieros DF','noticieros2','summary_micro_comments',['mexico-df'],[],[],[],[],'NT_DF',5,1,15,3],
['Noticieros Estados','noticieros2','summary_micro_comments',['mexico-estados'],[],[],[],[],'NT_estados',5,1,15,3],
['Noticieros Mundo','noticieros2','summary_micro_comments',['mundo'],[],[],[],[],'NT_mundo',5,1,15,3],
['Deportes RGA','televisa','summary_micro_comments',['futbol-mexicano','boxeo','futbol','seleccion-mexicana','beisbol','nfl-futbol-americano'],[],[],[],[],'TD',8,1,5,2],
#['Noticieros Especiales','noticieros2','summary_micro_comments',['ee-uu','mundo'],[],[],[],[],'NT_especiales',5,1,15,3],
#['Noticieros Glitter','noticieros2','summary_micro_comments',['mundo'],['1402'],[],[],[],'NT_glitter',10,5,15,3],
#['Noticieros Opinion','noticieros2','summary_micro_comments',['opinion-leon-garcia-soler','opinion-jorge-santibanez','opinion-gabriel-guerra','opinion-javier-aranda','opinion-leon-garcia-soler','opinion-elena-poniatowska','opinion-jorge-chabat','opinion-rossana-fuentes-berain'],[],[],[],[],'NT_opinion',10,5,15,3],
#['Noticieros Ciencia y Tecnologia','noticieros2','summary_micro_comments',['mundo'],['1402'],[],[],[],'NT_ciencia',10,3,15,3],
#['Brazil 2014','televisadeportes','summary_micro_comments',['copa-mundial-fifa-brasil-'],[],[],[],[],'brazil2014',10,2,15,3],
#['Noticieros Cultura','noticieros2','summary_micro_comments',['mexico'],['1402'],[],[],[],'NT_cultura',10,3,15,3],
#['Bailando por un Sueno Noticias','televisa','summary_micro_comments',['bailando-por-un-sueno'],['noticias'],[],[],[],'bailando_noticias',15,7,15,3],
#['Bailando por un Sueno Videos','televisa','summary_micro_comments',['bailando-por-un-sueno'],['videos'],[],[],[],'bailando_videos',15,7,15,3],
#['Bailando por un Sueno Fotos','televisa','summary_micro_comments',['bailando-por-un-sueno'],['galerias'],[],[],[],'bailando_galerias',15,7,15,3],
['Entretenimiento','esmas_entretenimiento','summary_TVprograms_comments',['entretenimiento'],['farandula'],[],[],[],'entretenimiento',12,2,5,2],
['Estilo de vida 2','televisa','summary_micro_comments',['estilo','salud','hogar','pareja','maternidad'],[],[],[],[],'estilo',12,4,5,2],
['Estilo Salud','televisa','summary_micro_comments',['salud'],[],[],[],[],'estilo_salud',10,4,5,2],
['Estilo Estilo','televisa','summary_micro_comments',['estilo'],[],[],[],[],'estilo_estilo',10,4,5,2],
['Estilo Hogar','televisa','summary_micro_comments',['hogar'],[],[],[],[],'estilo_hogar',10,4,5,2],
['Estilo Pareja','televisa','summary_micro_comments',['pareja'],[],[],[],[],'estilo_pareja',10,4,5,2],
#['Estilo de vida','esmas','summary_micro_comments',['mujer','salud'],[],[],[],[],'estilo',12,2,5,2],
['Entretenimeinto Cine','televisa','summary_micro_comments',['cine'],[],[],[],[],'entretenimiento_cine',12,3,5,2],
['Entretenimeinto Musica','televisa','summary_micro_comments',['musica'],[],[],[],[],'entretenimiento_musica',12,3,5,2],
['Entretenimeinto Series','televisa','summary_micro_comments',['series'],[],[],[],[],'entretenimiento_series',12,3,5,2],
['Entretenimeinto Farandula','televisa','summary_micro_comments',['farandula'],[],[],[],[],'entretenimiento_farandula',12,3,5,2],
['Entretenimeinto V_Cine','televisa','summary_micro_comments',['cine'],[],['videos'],[],[],'entretenimiento_v_cine',12,3,5,2],
['Entretenimeinto V_Musica','televisa','summary_micro_comments',['musica'],[],['videos'],[],[],'entretenimiento_v_musica',12,3,5,2],
['Entretenimeinto V_Series','televisa','summary_micro_comments',['series'],[],['videos'],[],[],'entretenimiento_v_series',12,3,5,2],
['Entretenimeinto V_Farandula','televisa','summary_micro_comments',['farandula'],[],['videos'],[],[],'entretenimiento_v_farandula',12,3,5,2],
['Me Pongo de Pie','televisa','summary_micro_comments',['me-pongo-de-pie'],['videos'],[],[],[],'me_pongo_v',12,3,5,2],
['Me Pongo de Pie','televisa','summary_micro_comments',['me-pongo-de-pie'],['noticias'],[],[],[],'me_pongo',12,3,5,2],
['Estilo Maternidad','televisa','summary_micro_comments',['maternidad'],[],[],[],[],'estilo_maternidad',10,4,5,2],
['Estilo Hombre','televisa','summary_micro_comments',['hombre'],[],[],[],[],'estilo_hombre',10,4,5,2],
['Estilo Tendencias','televisa','summary_micro_comments',['tendencias'],[],[],[],[],'estilo_tendencias',10,4,5,2],
['Salud','esmas','summary_health_comments',['salud'],[],[],[],[],'salud',4,3,10,10],
['Cine','esmas_entretenimiento','summary_TVprograms_comments',['entretenimiento'],['cine'],[],[],[],'cine',4,3,15,5],
['Telenovelas','esmas_entretenimiento','summary_TVprograms_comments',['entretenimiento'],['telenovelas'],[],[],[],'telenovelas',12,3,5,2],
['Televisa Deportes','televisadeportes','summary_teams_comments',[],[],[],[],[],'deportes',8,5,5,2],
['Mujer','esmas','summary_woman_comments',['mujer'],[],[],[],[],'mujer',4,5,15,6],
['Noticieros Economia','noticieros2','summary_micro_comments',['economia'],[],[],[],[],'NT_economia',5,1,15,3],
##['Ritmoson','esmas','summary_ritmoson_comments',['ritmoson-latino'],[],[],[],[],'ritmoson',4,12,15,30],
##['Telehit','esmas','summary_telehit_comments',['telehit'],[],[],[],[],'telehit',4,5,30,20],
#['Cuentamelove','esmas','summary_telehit_comments',['telehit'],['cuentamelove'],[],[],[],'cuentamelove',4,5,30,20],
#['Platanito','esmas','summary_telehit_comments',['telehit'],['platanito'],[],[],[],'platanito',4,5,30,20],
#['Kristoff','esmas','summary_telehit_comments',['telehit'],['kristoff'],[],[],[],'kristoff',4,5,30,20],
#['Guerra de chistes','esmas','summary_telehit_comments',['telehit'],['guerra-de-chistes'],[],[],[],'guerra-de-chistes',4,5,30,20],
#['TVyNovelas','tvynovelas','summary_micro_comments',['noticias'],[],[],[],[],'tvynovelas',10,30,30,20],
#['Galerias','esmas','summary_micro_comments',['galeria'],[],[],[],[],'galleries',200,30,1,30]

['DeportesV Televisa','televisa_video','summary_televisa_video',['video'],[],[],[],['vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'deportes_televisa_global',12,1,2,2],
['DeportesV Futbol Internacional','televisa_video','summary_televisa_video',['video'],[],[],[],['futbol-internacional','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'futbol_internacional',12,1,2,2],
['DeportesV Futbol Mexicano','televisa_video','summary_televisa_video',['video'],[],[],[],['futbol-mexicano','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'futbol_mexicano',12,1,2,2],
['DeportesV Coleccion Privada','televisa_video','summary_televisa_video',['video'],[],[],[],['coleccion-privada','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'coleccion_privada',12,1,2,2],
['DeportesV Futbol Retro','televisa_video','summary_televisa_video',['video'],[],[],[],['futbol-retro','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'retro',12,1,2,2],
['DeportesV Seleccion Mexicana','televisa_video','summary_televisa_video',['video'],[],[],[],['seleccion-mexicana','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'seleccion_mexicana',12,1,2,2],
['DeportesV Boxeo','televisa_video','summary_televisa_video',['video'],[],[],[],['boxeo','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'boxeo',12,1,2,2],
['DeportesV Martes Knock Out','televisa_video','summary_televisa_video',['video'],[],[],[],['martes-knock-out','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'martes_knock_out',12,1,2,2],
['DeportesV Programas Tv','televisa_video','summary_televisa_video',['video'],[],[],[],['programas-tv','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'programas_tv',12,1,2,2],
['DeportesV Deporte','televisa_video','summary_televisa_video',['video'],[],[],[],['deporte','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'deporte',12,1,2,2],
['DeportesV Noticiero TD','televisa_video','summary_televisa_video',['video'],[],[],[],['noticiero-td','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'noticiero_td',12,1,2,2],
['DeportesV Tribunal TD','televisa_video','summary_televisa_video',['video'],[],[],[],['tribunal-td','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'tribunal_td',12,1,2,2],
['DeportesV Accion','televisa_video','summary_televisa_video',['video'],[],[],[],['accion','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'accion',12,1,2,2],
['DeportesV Jugada','televisa_video','summary_televisa_video',['video'],[],[],[],['jugada','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'jugada',12,1,2,2],
['DeportesV Latitudes','televisa_video','summary_televisa_video',['video'],[],[],[],['latitudes','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'latitudes',12,1,2,2],
['DeportesV Conecta TD','televisa_video','summary_televisa_video',['video'],[],[],[],['conecta-td','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'conecta_td',12,1,2,2],
['DeportesV TD Style','televisa_video','summary_televisa_video',['video'],[],[],[],['td-style','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'td_style',12,1,2,2],
['DeportesV Cuerpo Perfecto','televisa_video','summary_televisa_video',['video'],[],[],[],['cuerpo-perfecto','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'cuerpo_perfecto',12,1,2,2],
['DeportesV TDN','televisa_video','summary_televisa_video',['video'],['tdn'],[],[],['tdn','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'tdn',12,1,2,2],
['DeportesV Videoblogs','televisa_video','summary_televisa_video',['video'],[],[],[],['videoblogs','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'videoblogs',12,1,2,2],
['DeportesV Noticias','televisa_video','summary_televisa_video',['video'],[],[],[],['noticias','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'noticias',12,1,2,2],
['DeportesV Web TD','televisa_video','summary_televisa_video',['video'],[],[],[],['web-td','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'web_td',12,1,2,2],
['DeportesV Piojometeme','televisa_video','summary_televisa_video',['video'],[],[],[],['-piojometeme','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'piojometeme',12,1,2,2],
['DeportesV Copa America','televisa_video','summary_televisa_video',['video'],[],[],[],['copa-america','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'copa_america',12,1,2,2],
['DeportesV Copa Oro','televisa_video','summary_televisa_video',['video'],[],[],[],['copa-oro','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'copa_oro',12,1,2,2],
['DeportesV Mas Deporte','televisa_video','summary_televisa_video',['video'],[],[],[],['mas-deporte','vivo','video-chat','prueba2','indice-video','indice-torneo','prueba-chat-home','tag','tag.*'],'mas_deporte',12,1,2,2],


['Noticieros Televisa General','noticieros2','summary_micro_comments',[],[],[],[],[],'noticieros_televisa_general',12,1,2,2],
['Noticieros Televisa Fotos General','noticieros2_fotos','summary_teams_comments',[],[],[],[],[],'noticieros_televisa_fotos_general',12,1,2,2],
['Noticieros Televisa Videos General','noticieros2_video','summary_teams_comments',[],[],[],[],[],'noticieros_televisa_videos_general',12,1,2,2],

['Televisa Deportes Espectaculos Estilo General','televisa','summary_micro_comments',[],[],[],[],[],'televisa_deportes_espectaculo_estilo_general',12,1,2,2],
['Televisa Deportes Espectaculos Estilo Videos General','televisa_video','summary_micro_comments',[],[],[],[],[],'televisa_deportes_espectaculo_estilo_videos_general',12,1,2,2],
['Televisa Deportes Espectaculos Estilo Fotos General','televisa_fotos','summary_micro_comments',[],[],[],[],[],'televisa_deportes_espectaculo_estilo_fotos_general',12,1,2,2],

['Televisa Deportes US','televisa_video','summary_televisa_video',['us'],['video'],[],[],[],'televisa_deportes_us',12,1,2,2],
['Televisa Deportes US Futbol','televisa_video','summary_televisa_video',['us'],['video'],[],[],['futbol'],'televisa_deportes_us_futbol',12,1,2,2],
['Televisa Deportes US Goles Semana','televisa_video','summary_televisa_video',['us'],['video'],[],[],['goles-de-la-semana'],'televisa_deportes_us_goles_semana',12,1,2,2],
['Televisa Deportes US Box','televisa_video','summary_televisa_video',['us'],['video'],[],[],['box'],'televisa_deportes_us_box',12,1,2,2],
['Televisa Deportes US Otros Deportes','televisa_video','summary_televisa_video',['us'],['video'],[],[],['otros-deportes'],'televisa_deportes_us_otros_deportes',12,1,2,2],
['Televisa Deportes US Luchas','televisa_video','summary_televisa_video',['us'],['video'],[],[],['luchas'],'televisa_deportes_us_luchas',12,1,2,2],

['Pasion y Poder','televisa','summary_micro_comments',['telenovelas'],['pasion_y_poder'],['videos'],[],[],'pasion_y_poder',12,1,2,2],

['Bandamax General','bandamax','summary_micro_comments',[],[],[],[],[],'bandamax_general',12,1,2,2],
['Bandamax Fotos General','bandamax_fotos','summary_micro_comments',['programas'],['bandamax_tv','con_mas_alma_grupera','contrabandeando','kiubo_kien_anda_ay','la_cantina_del_tunco_maclovich','la_reina_del_norte','las_mas_picudas','mas_alla_de_la_fama','el_naucalpan_son_machin','pa_la_banda_night_show','pidesela_a_sergio','que_rollo','vamonos_recio','xe_bandamax'],['fotos'],[],[],'f_bandamax_general',12,1,2,2],
['Bandamax Videos General','bandamax_video','summary_micro_comments',['programas'],['bandamax_tv','con_mas_alma_grupera','contrabandeando','kiubo_kien_anda_ay','la_cantina_del_tunco_maclovich','la_reina_del_norte','las_mas_picudas','mas_alla_de_la_fama','el_naucalpan_son_machin','pa_la_banda_night_show','pidesela_a_sergio','que_rollo','vamonos_recio','xe_bandamax'],['video'],[],[],'v_bandamax_general',12,1,2,2],

['Unicable General','unicable','summary_micro_comments',[],[],[],[],[],'unicable_general',12,1,2,2],
['Unicable Fotos General','unicable_fotos','summary_micro_comments',['programas'],['netas_divina','esta_canon','mojoe','amordidas','es_de_noche_y_ya_llegue','la_cocina_de_gibaja','la_cocina_de_victoria','la_cocina_en_los_pueblos_magicos','miembros_al_aire','mexico_de_mil_sabores','plan_b','susana_adiccion','vive_en_equilibrio','yoga_con_luz'],['fotos'],[],[],'f_unicable_general',12,1,2,2],
['Unicable Videos General','unicable_video','summary_micro_comments',['programas'],['netas_divina','esta_canon','mojoe','amordidas','es_de_noche_y_ya_llegue','la_cocina_de_gibaja','la_cocina_de_victoria','la_cocina_en_los_pueblos_magicos','miembros_al_aire','mexico_de_mil_sabores','plan_b','susana_adiccion','vive_en_equilibrio','yoga_con_luz'],['video'],[],[],'v_unicable_general',12,1,2,2],

['Golden canal','canalgolden_video','summary_micro_comments',['video'],['golden','golden_edge','golden_hd','golden_latam','golden_news','golden_premier'],[],[],[],'canalgolden',12,1,2,2],



]

con = ConnectDB(generic.config["server_db_ip"],generic.config["server_db_user"],generic.config["server_db_pass"],generic.config["server_db_schema"])
#con3 = ConnectDB(generic.config["server_db_ip"],generic.config["server_db_user"],generic.config["server_db_pass"],generic.config["server_db_schema_comm"])

class MLStripper(HTMLParser):
    def __init__(self):
        self.reset()
        self.fed = []
    def handle_data(self, d):
        self.fed.append(d)
    def get_data(self):
        return ''.join(self.fed)

def strip_tags(html):
    s = MLStripper()
    s.feed(html)
    return s.get_data()

class Test:
    def __init__(self):
        self.contents = ''
    def body_callback(self, buf):
        self.contents = self.contents + buf

t = Test()
c = pycurl.Curl()


def getPageInfo(url):
    global t, c
    title=''
    description=''
    image=''
    arreglo=[]
    t.contents=''
    c.setopt(c.URL, url)
    c.setopt(c.WRITEFUNCTION, t.body_callback)
    c.perform()
##    try:
##        soup = BeautifulSoup(t.contents)
##    except:
##        print "NO cargado por BeautifulSoup en "+url
##        soup=False
    title_search = re.search('<\n*\r* *title\n*\r* *>\n*\r*(.*?)\n*\r*<\n*\r* */\n*\r* *title\n*\r* *>', t.contents, re.IGNORECASE | re.DOTALL)
    image_search = re.search('<\n*\r* *link +rel\n*\r* *=\n*\r* *["|\']\n*\r* *image_src\n*\r* *["|\']\n*\r* *href\n*\r* *=\n*\r* *["|\']\n*\r*(.*?)\n*\r* *["|\'] *\n*\r* */* *>', t.contents, re.IGNORECASE )
    description_search = re.search('<\n*\r* *meta +name\n*\r* *=\n*\r* *["|\']\n*\r* *description\n*\r* *["|\']\n*\r* *content\n*\r* *= *["|\']\n*\r*(.*?)\n*\r*["|\'] *\n*\r* */* *>', t.contents, re.IGNORECASE  )
    if title_search and title_search.group(1)!='':
        title=title_search.group(1).replace('\n', '').strip()
    if image_search and image_search.group(1)!='':
        image=image_search.group(1).replace('\n', '').strip()
    else:
        image_search = re.search('<\n*\r* *meta +name\n*\r* *=\n*\r* *["|\']\n*\r* *imagen\n*\r* *["|\']\n*\r* *content\n*\r* *=\n*\r* *["|\']\n*\r*(.*?)\n*\r*["|\']\n*\r* *>', t.contents, re.IGNORECASE )
        if image_search and image_search.group(1)!='':
            image=image_search.group(1).replace('\n', '').strip()
    if description_search and description_search.group(1)!='':
        description=description_search.group(1).replace('\n', '').strip()
##    title_search = re.search('<title>(.*)</title>', t.contents, re.IGNORECASE | re.DOTALL)
##
##    if title_search and title_search.group(1)!='':
##        title = title_search.group(1).replace('\n', '').strip()
##    else:
##        try:
##            title=soup.findAll("meta",{'name':re.compile("^title$", re.I)})[0]['content']
##            title=title.encode('iso-8859-1')
##        except:
##            print "Titulo no encontrado en :"+url
##            title=''
##    try:
##        image=soup.findAll("link",{'rel':re.compile("^image_src$", re.I)})[0]['href']
##        image=image.encode('iso-8859-1')
##    except:
##        try:
##            image=soup.findAll("meta",{'name':re.compile("^imagen$", re.I)})[0]['content']
##            image=image.encode('iso-8859-1')
##        except:
##            try:
##                image=soup.findAll("img",{'width':"^120$",'height':"^90$"})[0]['src']
##                image=image.encode('iso-8859-1')
##                if (image.find('/spacer.')):
##                    image=''
##            except:
##                print "Imagen no encoentrada en : "+url
##                image=''
##
##    try:
##        description=soup.findAll("meta", {'name':re.compile("^description$", re.I)})[0]['content']
##        description=description.encode('iso-8859-1')
##    except:
##        print "Descripcion no encoentrada en : "+url
##        description=''
    title = title.split(' ::', 1)[0]
    title = title.split(' |', 1)[0]
    title=strip_tags(title)
    title=title.replace('"',"")
    title=title.replace("'","")
    image=strip_tags(image)
    image=image.replace('"',"")
    image=image.replace("'","")
    description=strip_tags(description)
    description=description.replace('"',"")
    description=description.replace("'","")
    description=description.replace('\r'," ")
    description=description.replace('\n'," ")
    ##print title
    ##print description
    arreglo.append(url)
    arreglo.append(title)
    arreglo.append(image)
    arreglo.append(description)
    ##print arreglo
    return arreglo

def makeJson(arreglo):
    json_chain='['
    for items in arreglo:
        json_chain+='{"url":"'+items[0]+'",'
        json_chain+='"url_href":" href=\''+items[0]+'\' ",'
        json_chain+='"title":"'+items[1]+'",'
        json_chain+='"image":"'+items[2]+'",'
        json_chain+='"image_src":" src=\''+items[2]+'\' ",'
        json_chain+='"description":"'+items[3]+'"},'
    json_chain=json_chain[:-1]
    json_chain+=']'
    return json_chain

for service in services:
    where='WHERE '
    if len(service[3]):
        where+='channel IN ('
        for channels in service[3]:
            where+="'"+channel_replace(channels)+"',"
        where=where[:-1]
        where+=") "
    if len(service[4]):
        where+='AND sub_channel1 IN ('
        for channels in service[4]:
            where+="'"+channel_replace(channels)+"',"
        where=where[:-1]
        where+=") "
    if len(service[5]):
        where+='AND sub_channel2 IN ('
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
            if(service[1]=='televisa_video' and service[0].find('US') < 0):
                where+='AND sub_channel1 NOT IN ('
            else:
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
    sql2=""

    ##views
    flat_files_dir=flat_files_dir_views
    ul_id='fotogalmasvis'
    order_by=' ORDER BY total DESC '
    group_by=' GROUP BY object_id '
    total='SUM(views) total'
    table='views_day_'+service[1]
    
    day_1=getInitialDate(service[10])
    day_2=str(datetime.now().year)+"-"+str(datetime.now().month)+"-"+str(datetime.now().day)
    hour_1=str((datetime.now() - timedelta(hours=6)).hour)
    hour_2=str(datetime.now().hour)
    if where!='WHERE ':
        #where2=where+' AND DATEDIFF(CURDATE(),log_date)<='+str(service[10])
        where2=where+" AND log_date between '"+day_1+"' AND '"+day_2+"' "
        if service[10]==1:
            #where2=where+"AND log_date='"+log_date+"' AND time_hr BETWEEN HOUR(CURTIME())-6 AND HOUR(CURTIME())"
            where2=where+"AND log_date='"+log_date+"' AND time_hr BETWEEN "+hour_1+" AND "+hour_2+ " "
            table='views_hr_'+service[1]
    else:
        #where2=where+'DATEDIFF(CURDATE(),log_date)<='+str(service[10])
        where2=where+" log_date between '"+day_1+"' AND '"+day_2+"' "
        if service[10]==1:
            #where2=where+" log_date='"+log_date+"' AND time_hr BETWEEN HOUR(CURTIME())-6 AND  HOUR(CURTIME())"
            where2=where+" log_date='"+log_date+"' AND time_hr BETWEEN "+hour_1+" AND "+hour_2+ " "
            table='views_hr_'+service[1]
    try:
        print "++"+str(service[8])+"++"
        sql="SELECT object_id,"+total+" FROM "+table+" "+where2+group_by+order_by+ "LIMIT "+str(service[9]*3)
        
        try:
            datos=con.select(sql)
        except MySQLdb.Error, e:
            print "MySQL Error %d: %s" % (e.args[0], e.args[1])
            continue
        
        print "--"+str(service[8])+"--"
        print sql
        num_mached=0
        for dato in datos:
            ##Obtenr total de vistas de la nota
            sql2="SELECT object_url url, views FROM summary_"+service[1]+" WHERE object_id='"+dato[0]+"'"
            ##print sql2
            try:
                datos2=con.select(sql2)
            except:
                continue
            tmp_datos2=datos2[0][0]

            if service[8]=="TD" or service[0].find('Deportes US')!=-1 or service[0].find('DeportesV')!=-1 or service[0].find('Bandamax')!=-1 or service[0].find('Unicable')!=-1 or service[0].find('Golden')!=-1:
                #print tmp_datos2
                if re.search("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",tmp_datos2):
                    if tmp_datos2[-1]=="/":
                        tmp_datos2=tmp_datos2[:-1]
                    if any(tmp_datos2 in s for s in urls1):
                        continue
                    #urls1.append(datos2[0][0])
                    urls1.append([datos2[0][0],datos2[0][1]])
                    num_mached=num_mached+1

            else:
                if re.search("/[0-9]{4,}/",tmp_datos2):
                    if tmp_datos2[-1]=="/":
                        tmp_datos2=tmp_datos2[:-1]
                    if any(tmp_datos2 in s for s in urls1):
                        continue
                    #urls1.append(datos2[0][0])
                    urls1.append([datos2[0][0],datos2[0][1]])
                    num_mached=num_mached+1
            
            if num_mached>=service[9]:
                break
            ##urls1.append(datos2[0][0])
        ##print sql
        ##print urls1
        if len(urls1)<3:
            print "No regenerado: 2_0_notes_week_"+service[8]+"_views.xml "+str(datetime.now())
            # doc = Document()
            # videos=doc.createElement("notes")
            # doc.appendChild(videos)
            # f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_views.xml",'w+')
            # f.write(doc.toprettyxml(indent="  "))
            # f.close()
        else:
            doc = Document()
            videos=doc.createElement("notes")
            doc.appendChild(videos)
            for url in urls1:
                url_tag=doc.createElement("url")
                url_tag.appendChild(doc.createTextNode(url[0]))
                if( service[0].find('General')!=-1 ):
                    url_tag.setAttribute('numViews', str(url[1]))
                videos.appendChild(url_tag)
            ##Guardar en Memcache
            mc.set("xml_2_0_notes_week_"+service[8]+"_views", doc.toprettyxml(indent="  "))
            f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_views.xml",'w+')
            f.write(doc.toprettyxml(indent="  "))
            f.close()
            # try:
            #     ##Guardar Datos de Pagina
            #     all_data=[]
            #     for url in urls1:
            #         resultado=getPageInfo(url)
            #         all_data.append(resultado)
            #     final_json=makeJson(all_data)
            #     #print final_json
            #     ##Guardar en Memcache
            #     mc.set("json_2_0_notes_week_"+service[8]+"_views", final_json)
            #     f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_views.json",'w+')
            #     f.write(final_json)
            #     f.close()
            # except:
            #     print "EE:"+sql
            #     print "EE:"+sql2
            #     continue
    except:
        #doc = Document()
        #videos=doc.createElement("notes")
        #doc.appendChild(videos)
        #f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_views.xml",'w+')
        #f.write(doc.toprettyxml(indent="  "))
        #f.close()
        print "EEEE:"+sql
        print "EEEE:"+sql2



    # ##votes
    # flat_files_dir=flat_files_dir_votes
    # ul_id='fotogalmasvot'

    # order_by=' ORDER BY total DESC '
    # group_by=' GROUP BY object_id '
    # total='SUM(positive_votes) total'
    # table='votes_day_'+service[1]
    # day_1=getInitialDate(service[11])

    # if where!='WHERE ':
    #     #where2=where+' AND DATEDIFF(CURDATE(),log_date)<='+str(service[11])+ ' AND '+NOTIN
    #     where2=where+" AND log_date between '"+day_1+"' AND '"+day_2+"' AND "+NOTIN
    # else:
    #     #where2=where+'DATEDIFF(CURDATE(),log_date)<='+str(service[11])+ ' AND '+NOTIN
    #     where2=where+" log_date between '"+day_1+"' AND '"+day_2+"' AND "+NOTIN
    # sql="SELECT object_id,"+total+" FROM "+table+" "+where2+group_by+order_by+ "LIMIT "+str(service[9]*2)
    # #print sql

    # try:

    #     datos=con.select(sql)

    #     num_mached=0
    #     for dato in datos:

    #         ##Obtenr total de vistas de la nota
    #         sql2="SELECT object_url url, views FROM summary_"+service[1]+" WHERE object_id='"+dato[0]+"'"
    #         ##print sql2
    #         try:
    #             datos2=con.select(sql2)
    #         except:
    #             continue

    #         tmp_datos2=datos2[0][0]
    #         if re.search("/[0-9]{4,}/",tmp_datos2):

    #             if tmp_datos2[-1]=="/":
    #                 tmp_datos2=tmp_datos2[:-1]
    #             if any(tmp_datos2 in s for s in urls2):
    #                 continue

    #             urls2.append(datos2[0][0])
    #             num_mached=num_mached+1

    #         if num_mached>=service[9]:
    #             break


    #     ##print sql
    #     ##print urls2

    #     if len(urls2)<3:
    #         ##print "No regenerado: 2_0_notes_week_"+service[8]+"_votes.xml "+str(datetime.now())
    #         doc = Document()
    #         videos=doc.createElement("notes")
    #         doc.appendChild(videos)

    #         f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_votes.xml",'w+')
    #         f.write(doc.toprettyxml(indent="  "))
    #         f.close()

    #     else:

    #         doc = Document()
    #         videos=doc.createElement("notes")
    #         doc.appendChild(videos)

    #         for url in urls2:
    #             url_tag=doc.createElement("url")
    #             url_tag.appendChild(doc.createTextNode(url))
    #             videos.appendChild(url_tag)

    #         ##Guardar en Memcache
    #         mc.set("xml_2_0_notes_week_"+service[8]+"_votes", doc.toprettyxml(indent="  "))

    #         f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_votes.xml",'w+')
    #         f.write(doc.toprettyxml(indent="  "))
    #         f.close()

    #         try:
    #             ##Guardar Datos de Pagina
    #             all_data=[]
    #             for url in urls2:
    #                 resultado=getPageInfo(url)
    #                 all_data.append(resultado)

    #             final_json=makeJson(all_data)

    #             ##Guardar en Memcache
    #             mc.set("json_2_0_notes_week_"+service[8]+"_votes", final_json)

    #             f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_votes.json",'w+')
    #             f.write(final_json)
    #             f.close()
    #         except:
    #             continue


    # except:

    #     doc = Document()
    #     videos=doc.createElement("notes")
    #     doc.appendChild(videos)

    #     f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_votes.xml",'w+')
    #     f.write(doc.toprettyxml(indent="  "))
    #     f.close()








    ##Comments
    # flat_files_dir=flat_files_dir_comments
    # ul_id='fotogalmascomen'

    # order_by=' ORDER BY total DESC '
    # total='comments total'
    # table=service[2]
    # day_1=getInitialDate(service[12])

    # if len(service[3]):
    #     if len(service[4]):
    #         #where2="WHERE object_url LIKE '%/"+service[3][0]+"/"+service[4][0]+"/%' AND object_url  NOT LIKE '%/fotos/%' AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])+ ' AND '+NOTIN
    #         where2="WHERE object_url LIKE '%/"+service[3][0]+"/"+service[4][0]+"/%' AND object_url  NOT LIKE '%/fotos/%' AND creation_date between '"+day_1+"' AND '"+day_2+"' AND "+NOTIN

    #     else:
    #         if service[8]=='tvynovelas':
    #             #where2="WHERE object_url LIKE 'http://www.tvynovelas.com/%' AND object_url  NOT LIKE '%/fotos/%' AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])+ ' AND '+NOTIN
    #             where2="WHERE object_url LIKE 'http://www.tvynovelas.com/%' AND object_url  NOT LIKE '%/fotos/%' AND creation_date between '"+day_1+"' AND '"+day_2+"' AND "+NOTIN
    #         elif service[8]=='galleries':
    #             #where2="WHERE object_url LIKE 'http://galeriausuario.esmas.com/%' AND object_url  NOT LIKE '%/fotos/%' AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])+ ' AND '+NOTIN
    #             where2="WHERE object_url LIKE 'http://galeriausuario.esmas.com/%' AND object_url  NOT LIKE '%/fotos/%' AND creation_date between '"+day_1+"' AND '"+day_2+"' AND "+NOTIN
    #         else:
    #             #where2="WHERE object_url LIKE '%/"+service[3][0]+"/%' AND object_url  NOT LIKE '%/fotos/%' AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])+ ' AND '+NOTIN
    #             where2="WHERE object_url LIKE '%/"+service[3][0]+"/%' AND object_url  NOT LIKE '%/fotos/%' AND creation_date between '"+day_1+"' AND '"+day_2+"' AND "+NOTIN
    # else:
    #     #where2="WHERE object_url NOT LIKE '%/fotos/%' AND DATEDIFF(CURDATE(),creation_date)<="+str(service[12])+ ' AND '+NOTIN
    #     where2="WHERE object_url  NOT LIKE '%/fotos/%' AND creation_date between '"+day_1+"' AND '"+day_2+"' AND "+NOTIN

    # sql="SELECT object_id,object_url,"+total+" FROM "+table+" "+where2+order_by+ "LIMIT "+str(service[9]*2)
    # #print sql
    # try:
    #     datos=con3.select(sql)
    # except:
    #     doc = Document()
    #     videos=doc.createElement("notes")
    #     doc.appendChild(videos)

    #     f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_comments.xml",'w+')
    #     f.write(doc.toprettyxml(indent="  "))
    #     f.close()

    #     continue

    # num_mached=0
    # for dato in datos:

    #     if num_mached>=service[9]:
    #         break

    #     tmp_datos2=dato[1]

    #     if tmp_datos2[-1]=="/":
    #         tmp_datos2=tmp_datos2[:-1]
    #     if any(tmp_datos2 in s for s in urls3):
    #         continue
    #     else:
    #         num_mached=num_mached+1
    #         urls3.append(dato[1])


    # ##print sql
    # ##print urls3

    # if len(urls3)<3:
    #     doc = Document()
    #     videos=doc.createElement("notes")
    #     doc.appendChild(videos)

    #     f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_comments.xml",'w+')
    #     f.write(doc.toprettyxml(indent="  "))
    #     f.close()
    #     ##print "No regenerado: 2_0_notes_week_"+service[8]+"_comments.xml "+str(datetime.now())

    # else:

    #     doc = Document()
    #     videos=doc.createElement("notes")
    #     doc.appendChild(videos)

    #     for url in urls3:
    #         url_tag=doc.createElement("url")
    #         url_tag.appendChild(doc.createTextNode(url))
    #         videos.appendChild(url_tag)

    #     ##Guardar en Memcache
    #     mc.set("xml_2_0_notes_week_"+service[8]+"_comments", doc.toprettyxml(indent="  "))

    #     f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_comments.xml",'w+')
    #     f.write(doc.toprettyxml(indent="  "))
    #     f.close()

    #     try:
    #         ##Guardar Datos de Pagina
    #         all_data=[]
    #         for url in urls3:
    #             resultado=getPageInfo(url)
    #             all_data.append(resultado)

    #         final_json=makeJson(all_data)

    #         ##Guardar en Memcache
    #         mc.set("json_2_0_notes_week_"+service[8]+"_comments", final_json)

    #         f = open(flat_files_dir+"2_0_notes_week_"+service[8]+"_comments.json",'w+')
    #         f.write(final_json)
    #         f.close()
    #     except:
    #         continue

# Genera un Xml general de los nuevos que solicitan unir con los nuevos dominios
try:

    listFileXml = os.listdir(flat_files_dir)

    newXml = []

    for fileXml in listFileXml:
        if( fileXml.find('general')!=-1 and fileXml.find('week_televisa_general')<0):
            tree = ET.parse(flat_files_dir+fileXml)
            root = tree.getroot()

            for xmlGeneral in root.findall('url'):
                numViews = xmlGeneral.get('numViews')
                url = xmlGeneral.text
                newXml.append([numViews,url])
        
            listXmlOrder = sorted(newXml,reverse=True)

            doc = Document()
            videos=doc.createElement("notes")
            doc.appendChild(videos)

            i = 0
            numMaxUrls = 35

            for listXml in listXmlOrder:
                i = i+1
                if( i <= numMaxUrls ):
                    url_tag=doc.createElement("url")
                    url_tag.appendChild(doc.createTextNode(listXml[1]) )
                    videos.appendChild(url_tag)

            f = open(flat_files_dir+"2_0_notes_week_televisa_general_views.xml",'w+')
            f.write(doc.toprettyxml(indent="  "))
            f.close()

except:
    print "no existe directorio"
    pass


def xml_general(name_search):

    try:

        listFileXml = os.listdir(flat_files_dir)

        newXml = []

        for fileXml in listFileXml:
            
            if( fileXml.find(name_search)!=-1 ):
                
                tree = ET.parse(flat_files_dir+fileXml)
                root = tree.getroot()
                for xmlGeneral in root.findall('url'):
                    numViews = xmlGeneral.get('numViews')
                    url = xmlGeneral.text
                    newXml.append([numViews,url])
            
                listXmlOrder = sorted(newXml,reverse=True)

                doc = Document()
                videos=doc.createElement("notes")
                doc.appendChild(videos)

                i = 0
                numMaxUrls = 35

                for listXml in listXmlOrder:
                    i = i+1
                    if( i <= numMaxUrls ):
                        url_tag=doc.createElement("url")
                        url_tag.appendChild(doc.createTextNode(listXml[1]) )
                        videos.appendChild(url_tag)
        
                namefile = name_search.split('_')

                f = open(flat_files_dir+"2_0_notes_week_"+namefile[0]+"_views.xml",'w+')
                f.write(doc.toprettyxml(indent="  "))
                f.close()

    except:
        print "no existe directorio"
        pass

xml_general('bandamax_general')
xml_general('unicable_general')

