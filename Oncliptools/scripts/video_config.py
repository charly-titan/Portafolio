# #!/bin/bash
import socket

# # -----------------------------------------------------
# # Directorios y programas
# # -----------------------------------------------------
# DIRECTORY_MEDIA=/c00nt/vcms/media/
# DIRECTORY_MASTER=/c00nt/vcms/master/
# HLS_PROGRAM=/c00nt/vcms/software/Akamai/HLSDownloader.exe
# OUTPUT_DIRECTORY=/c00nt/vcms/Akamai/outputs/
# MOOV_DIRECTORY=/c00nt/vcms/software/moovrelocator/
# FFMPEG=/c00nt/vcms/software/ffmpeg
# PHP_EXEC=/usr/bin/php
# MOOV_PHP=/c00nt/vcms/software/moovrelocator/index.php

# # -----------------------------------------------------
# # Configuracion BRIGHTCOVE
# # -----------------------------------------------------
# XML_PATH=/c00nt/vcms/bash/
# BRIGHTCOVE_XML=/c00nt/vcms/software/bash_scripts/xml/brightcove_xml_v1.xml
# EMAIL_APP=apps@esmas.com
# PUBLISHER_ID=74091787001
# PREPARER=Oncliptools
# #http:\/\/galaxy.esmas.com\/AJAX\/api_bright.php
# CALLBACK_URL="http:\/\/beta.oncliptools.com\/api\/1\/brightcove"
# # AKAMAI_URL="http:\/\/m4vhds.tvolucion.com\/z\/m4v\/boh\/"
# #AKAMAI_URL="http:\/\/apps.tvolucion.com\/m4v\/tst\/"
# #AKAMAI_URL_CLEAN="http://apps.tvolucion.com/m4v/tst/"
# AKAMAI_URL="http:\/\/m4vhds.tvolucion.com\/z\/m4v\/tst\/"
# AKAMAI_URL_CLEAN="http://m4vhds.tvolucion.com/z/m4v/tst/"
# IMAGE_PATH="http:\/\/m4v.tvolucion.com\/m4v\/tst\/"
# IMAGE_PATH_CLEAN="http://m4v.tvolucion.com/m4v/tst/"
# BRIGHTCOVE_USR=televisa
# BRIGHTCOVE_PSW=z60cEI7E
# BRIGHTCOVE_URL="upload.brightcove.com"

# # -----------------------------------------------------
# # Configuracion GALAXY
# # -----------------------------------------------------
# GALAXYURL="http://galaxy.esmas.com/AJAX/api_video.php"
# GALAXYEXTRAS="http://galaxy.esmas.com/AJAX/api_video_extras.php"
# adjust_time : 7200 produccion 

video_config = {'DIRECTORY_MEDIA': "/c00nt/vcms/media/", 
'DIRECTORY_MASTER': "/c00nt/vcms/master/", 
'HLS_PROGRAM': "/c00nt/vcms/software/Akamai/HLSDownloader.exe",
'OUTPUT_DIRECTORY':"/c00nt/vcms/Akamai/outputs/", #/Users/gmancera/vcms/Akamai/outputs/
'MOOV_DIRECTORY':"/c00nt/vcms/software/moovrelocator/",
'FFMPEG':"/c00nt/vcms/software/ffmpeg",
'PHP_EXEC':"/usr/bin/php",
'MOOV_PHP':"/c00nt/vcms/software/moovrelocator/index.php",
'adjust_time':0
}


# video_config = {'DIRECTORY_MEDIA': "/c00nt/vcms/media/", 'DIRECTORY_MASTER': "/c00nt/vcms/master/", 
# 'HLS_PROGRAM': "/c00nt/vcms/software/Akamai/HLSDownloader.exe",
# 'OUTPUT_DIRECTORY':"/c00nt/vcms/Akamai/outputs/",
# 'MOOV_DIRECTORY':"/c00nt/vcms/software/moovrelocator/",
# 'FFMPEG':"/c00nt/vcms/software/ffmpeg",
# 'PHP_EXEC':"/usr/bin/php",
# 'MOOV_PHP':"/c00nt/vcms/software/moovrelocator/index.php",
# 'adjust_time':7200
# }



brightcove_config ={
'XML_PATH' : "/c00nt/vcms/bash/",
'BRIGHTCOVE_XML' : "xml/brightcove_xml_v1.xml",
'EMAIL_APP' : "apps@esmas.com",
'PUBLISHER_ID' : "74091787001",
'PREPARER' : "Oncliptools",
'CALLBACK_URL' : "http://beta.oncliptools.com/api/1/brightcove",
'AKAMAI_URL' : "http://m4vhds.tvolucion.com/z/m4v/tst/",
'AKAMAI_URL_CLEAN' : "http://m4vhds.tvolucion.com/z/m4v/tst/",
'IMAGE_PATH' : "http://m4v.tvolucion.com/m4v/tst/",
'IMAGE_PATH_CLEAN' : "http://m4v.tvolucion.com/m4v/tst/",
'USR' : "televisa",
'PSW' : "z60cEI7E",
'SERVER' : "upload.brightcove.com",
'PATH' : "/"
}

akamai_config ={
'USR' : "uptvvid",
'PSW' : "zHJX1jXA..",
'SERVER' : "cmflash.upload.akamai.com",
'PATH' : "/tst/"
}

galaxy_config ={
'GALAXYURL' : "http://galaxy.esmas.com/AJAX/api_video.php",
'GALAXYEXTRAS' : "http://galaxy.esmas.com/AJAX/api_video_extras.php",
'AKAMAI_m3u8' : "http://m4vhds.tvolucion.com/i/m4v/tst/"
}

database_config = {
	 'server' : "laravel-devtim.cjczjvx3sd7d.us-west-1.rds.amazonaws.com",
	 'schema' : "oncliptools",
	 'user' : "laravel",
	 'password' : "Televisa2010.."
	}

s3_config = {
	 'access_key' : 'AKIAINTYMKST2PDRU3OA',
	 'secret_key' : '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',
	 'bucket' : 'mxm-v2'
	}

if(socket.gethostname()=="ip-10-252-9-7"):
	database_config = {
	 'server' : "laravel-devtim.cjczjvx3sd7d.us-west-1.rds.amazonaws.com",
	 'schema' : "vcms2",
	 'user' : "laravel",
	 'password' : "Televisa2010.."
	}

