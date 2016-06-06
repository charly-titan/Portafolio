#!/usr/bin/python

# #########################################################
#       Importo librerias y dependencias

import os, time, subprocess, thread, simplejson, boto, threading, Queue, hashlib, video_config
from conexion import ConnectDB
from oncliptools import Oncliptools
from os import listdir
from os.path import isfile, join
from datetime import datetime


# #########################################################
#       Importo librerias y dependencias
daemon_active=1
oncliptools = Oncliptools(video_config.database_config, video_config.video_config, video_config.brightcove_config)
fingerPrint = oncliptools.md5Checksum('video.py')

while daemon_active:
	
	#oncliptools.resetVideoQualities()

	print "esperamos 10 segundos para correr el siguiente ciclo"
	#Esperamos unos segundos para volver a iniciar el ciclo
	if( fingerPrint != oncliptools.md5Checksum('video.py') ):
		print "Se cierra el proceso para iniciar en la nueva version"
		daemon_active=0
	else:
		time.sleep(10)




