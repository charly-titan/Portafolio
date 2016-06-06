#!/bin/bash
PROCESS_START=$(date +%s)
echo "[[ S:PROCESANDO VOD:$(date +%s) ]]"

# -----------------------------------------------------
# Directorios y programas
# -----------------------------------------------------
DIRECTORY_MEDIA=/c00nt/vcms/media/short/
HLS_PROGRAM=/c00nt/vcms/software/Akamai/HLSDownloader.exe
OUTPUT_DIRECTORY=/c00nt/vcms/Akamai/outputs/
MOOV_DIRECTORY=/c00nt/vcms/software/moovrelocator/
FFMPEG=/c00nt/vcms/software/ffmpeg
PHP_EXEC=/usr/bin/php
MOOV_PHP=/c00nt/vcms/software/moovrelocator/index.php


# -----------------------------------------------------
# Opciones para el bash
# -----------------------------------------------------
while getopts d:s:i:e:n:p: option
do
        case "${option}"
        in
                d) DIRECTORY_NAME=${OPTARG};;
                s) SIGNAL=${OPTARG};;
                i) INITIAL_POINT=${OPTARG};;
                e) END_POINT=$OPTARG;;
                n) FILE_NAME=$OPTARG;;
                p) PROGRAM_NAME=$OPTARG;;
        esac
done




# -----------------------------------------------------
# Validaciones de error en los parametros del script
# -----------------------------------------------------
if [ -z "$DIRECTORY_NAME" ]
	then
		echo "El parametro -d 'NOMBRE-DIRECTORIO' es obligatorio"
		exit 0
	fi
if [ -z "$SIGNAL" ]
	then
		echo "El parametro -s 'URL-SENAL' es obligatorio"
		exit 0
	fi
if [ -z "$INITIAL_POINT" ]
	then
		echo "El parametro -i 'START_TIME' es obligatorio"
		exit 0
	fi
if [ -z "$END_POINT" ]
	then
		echo "El parametro -e 'END_TIME'  es obligatorio"
		exit 0
	fi
if [ -z "$FILE_NAME" ]
	then
		echo "El parametro -n 'NOMBRE-ARCHIVO' es obligatorio"
		exit 0
	fi
if [ -z "$PROGRAM_NAME" ]
	then
		echo "El parametro -p 'NOMBRE-PROGRAMA' es obligatorio"
		exi	t 0
	fi


# -----------------------------------------------------
# Operaciones a Ejecutar
# -----------------------------------------------------
echo "[[ S:CREANDO DIRECTORIO:$(date +%s) ]]"
mkdir -p "$DIRECTORY_MEDIA$PROGRAM_NAME/$DIRECTORY_NAME"
echo "[[ E:CREANDO DIRECTORIO:$(date +%s) ]]"

echo "[[ S:DESCARGANDO SENAL DE AKAMAI:$(date +%s) ]]"
mono "$HLS_PROGRAM" -s "$SIGNAL" --ignore 'a-p' --ignore 'a-b' -b 300-400 -v --start "$INITIAL_POINT" --end "$END_POINT" -o "$OUTPUT_DIRECTORY$FILE_NAME"
echo "[[ E:DESCARGANDO SENAL DE AKAMAI:$(date +%s) ]]"

echo "[[ S:MOVIENDO ARCHIVO A DIRECTORIO PARA PROCESAR:$(date +%s) ]]"
mv "$OUTPUT_DIRECTORY$FILE_NAME"_354000.mp4 "$DIRECTORY_MEDIA$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4"
echo "[[ E:MOVIENDO ARCHIVO A DIRECTORIO PARA PROCESAR:$(date +%s) ]]"

echo "[[ S:SINCRONIZANDO AUDIO Y VIDEO:$(date +%s) ]]"
$FFMPEG -async 2 -i "$DIRECTORY_MEDIA$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4" -g 2 "$DIRECTORY_MEDIA$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4"
echo "[[ E:SINCRONIZANDO AUDIO Y VIDEO:$(date +%s) ]]"

echo "[[ S:REALIZANDO FIX A METADATA DEL VIDEO:$(date +%s) ]]"
cd $MOOV_DIRECTORY
$PHP_EXEC "$MOOV_PHP" "$DIRECTORY_MEDIA$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4"
echo "[[ E:REALIZANDO FIX A METADATA DEL VIDEO:$(date +%s) ]]"

echo "[[ S:ELIMINANDO INFORMACION TEMPORAL:$(date +%s) ]]"
rm "$DIRECTORY_MEDIA$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4"
rm "$DIRECTORY_MEDIA$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4"
echo "[[ E:ELIMINANDO INFORMACION TEMPORAL:$(date +%s) ]]"


PROCESS_END=$(date +%s)
echo "[[ E:PROCESANDO VOD:$(date +%s) ]]"
echo $PROCESS_END - $PROCESS_START
