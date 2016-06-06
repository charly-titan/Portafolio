# -*- coding: utf-8 -*-
# #########################################################
# Creado: 12 de Abril 2012
# Autor: Gabriel Mancera gabriel.mancera@esmas.net
# Descripcion: Se agrega json de forma nativa para leer y escribir
# #########################################################


# #########################################################
#       Importo librerias y dependencias

import os
import time
import subprocess


daemon_active=1

while daemon_active:
	bashCommand = "wget -qO- http://vcms2.oncliptools.com/checkProgress &> /dev/null"
	
	process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
	output = process.communicate()[0]

	bashCommand = "wget -qO- http://vcms2.oncliptools.com/checkProgress &> /dev/null"
	process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
	output = process.communicate()[0]

	#Esperamos unos segundos para volver a iniciar el ciclo
	time.sleep(10)