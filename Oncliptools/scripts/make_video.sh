#!/bin/bash
PROCESS_START=$(date +%s)
echo "[[ S:PROCESANDO VOD:$(date +%s) ]]"

# -----------------------------------------------------
# Directorios y programas
# -----------------------------------------------------
DIRECTORY_MEDIA=/c00nt/vcms/media/
DIRECTORY_MASTER=/c00nt/vcms/master/
HLS_PROGRAM=/c00nt/vcms/software/Akamai/HLSDownloader.exe
OUTPUT_DIRECTORY=/c00nt/vcms/Akamai/outputs/
MOOV_DIRECTORY=/c00nt/vcms/software/moovrelocator/
FFMPEG=/c00nt/vcms/software/ffmpeg
PHP_EXEC=/usr/bin/php
MOOV_PHP=/c00nt/vcms/software/moovrelocator/index.php

# -----------------------------------------------------
# Configuracion BRIGHTCOVE
# -----------------------------------------------------
XML_PATH=/c00nt/vcms/bash/
BRIGHTCOVE_XML=/c00nt/vcms/software/bash_scripts/xml/brightcove_xml_v1.xml
EMAIL_APP=apps@esmas.com
PUBLISHER_ID=74091787001
PREPARER=Oncliptools
#http:\/\/galaxy.esmas.com\/AJAX\/api_bright.php
CALLBACK_URL="http:\/\/beta.oncliptools.com\/api\/1\/brightcove"
# AKAMAI_URL="http:\/\/m4vhds.tvolucion.com\/z\/m4v\/boh\/"
#AKAMAI_URL="http:\/\/apps.tvolucion.com\/m4v\/tst\/"
#AKAMAI_URL_CLEAN="http://apps.tvolucion.com/m4v/tst/"
AKAMAI_URL="http:\/\/m4vhds.tvolucion.com\/z\/m4v\/tst\/"
AKAMAI_URL_CLEAN="http://m4vhds.tvolucion.com/z/m4v/tst/"
IMAGE_PATH="http:\/\/m4v.tvolucion.com\/m4v\/tst\/"
IMAGE_PATH_CLEAN="http://m4v.tvolucion.com/m4v/tst/"
BRIGHTCOVE_USR=televisa
BRIGHTCOVE_PSW=z60cEI7E
BRIGHTCOVE_URL="upload.brightcove.com"

# -----------------------------------------------------
# Configuracion GALAXY
# -----------------------------------------------------
GALAXYURL="http://galaxy.esmas.com/AJAX/api_video.php"
GALAXYEXTRAS="http://galaxy.esmas.com/AJAX/api_video_extras.php"


# -----------------------------------------------------
# Opciones para el bash
# -----------------------------------------------------
while getopts d:s:i:e:n:p:f:k:l:m:b:g:z:t:o:y: option
do
		case "${option}"
		in
				d) DIRECTORY_NAME=${OPTARG};;
				s) SIGNAL=${OPTARG};;
				i) INITIAL_POINT=${OPTARG};;
				e) END_POINT=$OPTARG;;
				n) FILE_NAME=$OPTARG;;
				p) PROGRAM_NAME=$OPTARG;;
				f) VIDEO_TYPE=$OPTARG;;
				k) SECONDS_START=$OPTARG;;
				l) SECONDS_END=$OPTARG;;
				m) MASTER=$OPTARG;;
				b) BRIGHTCOVE=$OPTARG;;
				g) GALAXY=$OPTARG;;
				t) TITLE=$OPTARG;;
				o) GEOFILTER=$OPTARG;;
				y) GALAXYNODE=$OPTARG;;
				z) DEBUG=$OPTARG;;
		esac
done

# # -----------------------------------------------------
# # Diccionario de calidades
# # -----------------------------------------------------
case "$SIGNAL" in
		2) echo "Canal 2"
				DVRSTREAMURL="http://tvsawpdvr-lh.akamaihd.net/i/stch02wp_1@119660/master.m3u8"
				#declare -A BITRATE=( ["150"]="354000" ["235"]="446000" ["480"]="710000" ["600"]="840000" )
				declare -A BITRATE=( ["150"]="354000"  ["480"]="446000" ["600"]="840000" )
				MASTERQUALITY=1240000
				MAXQUALITY=600
			;;
		ForoTV) echo "Canal ForoTV"
				DVRSTREAMURL="http://tvsawpdvr-lh.akamaihd.net/i/stch04wp_1@119661/master.m3u8"
				#declare -A BITRATE=( ["150"]="354000" ["235"]="446000" ["480"]="710000" ["600"]="840000" )
				declare -A BITRATE=( ["150"]="354000"  ["480"]="710000" ["600"]="840000" )
				MASTERQUALITY=4384000
				MAXQUALITY=600
			;;
		5) echo "Canal 5"
				DVRSTREAMURL="http://tvsawpdvr-lh.akamaihd.net/i/stch05wp_1@119663/master.m3u8"
				#declare -A BITRATE=( ["150"]="354000" ["235"]="446000" ["480"]="710000" ["600"]="840000" ["970"]="1240000")
				declare -A BITRATE=( ["150"]="354000" ["480"]="710000" ["600"]="840000" )
				MASTERQUALITY=4384000
				#MAXQUALITY=970
				MAXQUALITY=600
			;;
		9) echo "Canal 9"
				DVRSTREAMURL="http://tvsawpdvr-lh.akamaihd.net/i/stch09wp_1@119664/master.m3u8"
				#declare -A BITRATE=( ["150"]="258000" ["235"]="350000" ["480"]="354000" ["600"]="614000" ["970"]="744000")
				declare -A BITRATE=( ["150"]="258000" ["480"]="350000" ["600"]="614000")
				MASTERQUALITY=1144000
				#MAXQUALITY=970
				MAXQUALITY=600
			;;
		Quantel) echo "Canal Quantel"
				DVRSTREAMURL="http://tvsawpdvr-lh.akamaihd.net/i/1dvrqu4nt3l_1@197427/master.m3u8"
				#declare -A BITRATE=( ["150"]="214000" ["235"]="299000" ["480"]="544000" ["600"]="664000" )
				declare -A BITRATE=( ["150"]="226000" ["480"]="582000" ["600"]="712000" )
				MASTERQUALITY=1112000
				MAXQUALITY=600
			;;
		*) echo "El canal no esta registrado"
				exit 0
			;;
esac


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
		exit 0
	fi
if [ -z "$VIDEO_TYPE" ]
	then
		VIDEO_TYPE="SHORT"
	else
		VIDEO_TYPE="FULL"
	fi
if [ -z "$DEBUG" ]
	then
		DEBUG=false
	else
		DEBUG=true
	fi

if [ $VIDEO_TYPE = "FULL" ]
	then
		if [ -z "$TITLE" ]
		then
			echo "El parametro -t 'TITLE' es obligatorio"
			exit 0
		fi

		if [ -z "$GEOFILTER" ]
		then
			echo "El parametro -geo 'GEOFILTER' es obligatorio"
			exit 0
		fi
	fi

# MASTER
# BRIGHTCOVE
# GALAXY

# # -----------------------------------------------------
# # Operaciones a Ejecutar
# # -----------------------------------------------------
echo "[[ S:CREANDO DIRECTORIO:$(date +%s) ]]"
echo "##**# mkdir -p $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME ##**#"
#mkdir -p "$DIRECTORY_MEDIA$VIDEO_TYPE/$PROGRAM_NAME/$DIRECTORY_NAME"
mkdir -p "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME"
echo "[[ E:CREANDO DIRECTORIO:$(date +%s) ]]"

 echo "[[ S:DESCARGANDO SENAL DE AKAMAI:$(date +%s) ]]"
 if [ $VIDEO_TYPE = "SHORT" ]
	then
		if [ -f "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4" ];
		then
			echo "File $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4 exists."
			echo "<!-- FILE_EXIST -->"
   			exit 0
		else
			echo "File $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4 does not exist."
			echo "##**# mono $HLS_PROGRAM -s $DVRSTREAMURL --ignore 'a-p' --ignore 'a-b' -b 299-400 -v --start $INITIAL_POINT --end $END_POINT -o $OUTPUT_DIRECTORY$FILE_NAME ##**#"
 			mono "$HLS_PROGRAM" -s "$DVRSTREAMURL" --ignore 'a-p' --ignore 'a-b' -b 199-400 -v --start "$INITIAL_POINT" --end "$END_POINT" -o "$OUTPUT_DIRECTORY$FILE_NAME"
		fi
 	else
 		echo "##**# mono $HLS_PROGRAM -s $DVRSTREAMURL --ignore 'a-p' --ignore 'a-b' -v --start $INITIAL_POINT --end $END_POINT -o $OUTPUT_DIRECTORY$FILE_NAME ##**#"
 		mono "$HLS_PROGRAM" -s "$DVRSTREAMURL" --ignore 'a-p' --ignore 'a-b' -v --start "$INITIAL_POINT" --end "$END_POINT" -o "$OUTPUT_DIRECTORY$FILE_NAME"
 	fi	
 echo "[[ E:DESCARGANDO SENAL DE AKAMAI:$(date +%s) ]]"

 echo "[[ S:MOVIENDO ARCHIVO A DIRECTORIO PARA PROCESAR:$(date +%s) ]]"
 if [ $VIDEO_TYPE = "SHORT" ]
 	then
 		if [ -f "$OUTPUT_DIRECTORY$FILE_NAME"_350000.mp4 ];
 		then
 			echo "##**# mv $OUTPUT_DIRECTORY$FILE_NAME"_350000.mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4 ##**#"
 			mv "$OUTPUT_DIRECTORY$FILE_NAME"_350000.mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4"
 		elif [ -f "$OUTPUT_DIRECTORY$FILE_NAME"_226000.mp4 ];
 		then
 			echo "##**# mv $OUTPUT_DIRECTORY$FILE_NAME"_226000.mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4 ##**#"
 			mv "$OUTPUT_DIRECTORY$FILE_NAME"_226000.mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4"		
 		elif [ -f "$OUTPUT_DIRECTORY$FILE_NAME"_214000.mp4 ];
 		then
 			echo "##**# mv $OUTPUT_DIRECTORY$FILE_NAME"_214000.mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4 ##**#"
 			mv "$OUTPUT_DIRECTORY$FILE_NAME"_214000.mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4"
 		else
 			echo "##**# mv $OUTPUT_DIRECTORY$FILE_NAME"_354000.mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4 ##**#"
 			mv "$OUTPUT_DIRECTORY$FILE_NAME"_354000.mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4"
 		fi
 	else
 		for QUALITY in "${!BITRATE[@]}"
		do 
 		echo "##**# mv $OUTPUT_DIRECTORY$FILE_NAME"_"${BITRATE["$QUALITY"]}".mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip-g.mp4 ##**#"
 		mv "$OUTPUT_DIRECTORY$FILE_NAME"_"${BITRATE["$QUALITY"]}".mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip-g.mp4" 
 		done
 	fi
 echo "[[ E:MOVIENDO ARCHIVO A DIRECTORIO PARA PROCESAR:$(date +%s) ]]"

 echo "[[ S:Eliminando TS:$(date +%s) ]]"
 if [ $VIDEO_TYPE = "SHORT" ]
 	then
 		echo "##**# rm $OUTPUT_DIRECTORY$FILE_NAME"_354000.ts "##**#"
 		rm "$OUTPUT_DIRECTORY$FILE_NAME"_354000.ts
 	else
 		for QUALITY in "${!BITRATE[@]}"
		do
 		echo "##**# rm $OUTPUT_DIRECTORY$FILE_NAME"_"${BITRATE["$QUALITY"]}".ts "##**#"
 		rm "$OUTPUT_DIRECTORY$FILE_NAME"_"${BITRATE["$QUALITY"]}".ts
 		done
 	fi
 echo "[[ E:Eliminando TS:$(date +%s) ]]"


if [ $VIDEO_TYPE = "SHORT" ]
	then
		echo "[[ S:SINCRONIZANDO AUDIO Y VIDEO:$(date +%s) ]]"
		echo "##**# $FFMPEG -async 2 -i $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4 -g 2 $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4 ##**#"
		$FFMPEG -async 2 -i "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4" -g 2 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4"
		echo "[[ E:SINCRONIZANDO AUDIO Y VIDEO:$(date +%s) ]]"		
	else
		echo "[[ S:CAMBIANDO EL KEYINTERVAL:$(date +%s) ]]"
		for QUALITY in "${!BITRATE[@]}"
		do
			echo "##**# $FFMPEG -i $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip-g.mp4 -g 2 -vcodec copy -acodec copy $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip.mp4 ##**#"
			$FFMPEG -i "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip-g.mp4" -g 2 -vcodec copy -acodec copy "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip.mp4"
		done
		echo "[[ E:CAMBIANDO EL KEYINTERVAL:$(date +%s) ]]"
	fi	

if [ $VIDEO_TYPE = "FULL" ]
	then
		echo "[[ S:ELIMINANDO RESIDUOS KEYINTERVAL:$(date +%s) ]]"
		for QUALITY in "${!BITRATE[@]}"
		do
		echo "##**# rm $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip-g.mp4 ##**#"
		rm "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip-g.mp4"
		done
		echo "[[ E:ELIMINANDO RESIDUOS KEYINTERVAL:$(date +%s) ]]"

		echo "[[ S:CORRIGIENDO LIPSYNC Y RECORTANDO:$(date +%s) ]]"
		for QUALITY in "${!BITRATE[@]}"
		do
			echo "##**# $FFMPEG -async 2 -i $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip.mp4 -g 2 -ss $SECONDS_START -t $SECONDS_END $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY.mp4 ##**#"
			$FFMPEG -async 2 -i "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip.mp4" -g 2 -ss "$SECONDS_START" -t "$SECONDS_END" "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY.mp4"
		done
		echo "[[ E:CORRIGIENDO LIPSYNC Y RECORTANDO:$(date +%s) ]]"

		echo "[[ S:ELIMINANDO RESIDUOS LIPSYNC:$(date +%s) ]]"
		for QUALITY in "${!BITRATE[@]}"
		do
		echo "##**# rm $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip.mp4 ##**#"
		rm "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$QUALITY-lip.mp4"
		done
		echo "[[ S:ELIMINANDO RESIDUOS LIPSYNC:$(date +%s) ]]"

		echo "[[ S:GENERANDO THUMBNAILS:$(date +%s) ]]"
		echo "##**# $FFMPEG" -i "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$MAXQUALITY.mp4" -vcodec mjpeg -vframes 1 -an -f rawvideo -s 160x90 -ss 00:00:10 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME.jpg ##**#"
		$FFMPEG -i "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$MAXQUALITY.mp4" -vcodec mjpeg -vframes 1 -an -f rawvideo -s 160x90 -ss 00:00:10 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME.jpg"
		echo "##**# $FFMPEG" -i "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$MAXQUALITY.mp4" -vcodec mjpeg -vframes 1 -an -f rawvideo -s 854x480 -ss 00:00:10 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-STILL.jpg ##**#"
		$FFMPEG -i "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-$MAXQUALITY.mp4" -vcodec mjpeg -vframes 1 -an -f rawvideo -s 854x480 -ss 00:00:10 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-STILL.jpg"
		echo "[[ E:GENERANDO THUMBNAILS:$(date +%s) ]]"

		echo "[[ S:SUBIENDO A AKAMAI:$(date +%s) ]]"
		if [ -f "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-600.mp4" ];
			then
				echo "El archivo 600 existe"
			else
				echo "No se genero el archivo de 600 se procede a copiar 480"
				cp "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-480.mp4" "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-600.mp4"
		fi
		echo "##**# ncftpput -u uptvvid -p zHJX1jXA.. -v -R -B 6291456 cmflash.upload.akamai.com /tst/ $DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME ##**#"
		ncftpput -u uptvvid -p zHJX1jXA.. -v -R -B 6291456 cmflash.upload.akamai.com /tst/ "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME"
		echo "[[ E:SUBIENDO A AKAMAI:$(date +%s) ]]"

		echo "[[ S:GENERANDO MASTER:$(date +%s) ]]"
		# mv "$OUTPUT_DIRECTORY$FILE_NAME"_"$MASTERQUALITY".mp4 "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-4000-lip-g.mp4"
		# $FFMPEG -i "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-4000-lip-g.mp4" -g 2 -vcodec copy -acodec copy "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-4000-lip.mp4"
		# rm "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-4000-lip-g.mp4"
		# $FFMPEG -async 2 -i "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-4000-lip.mp4" -g 2 -ss "$SECONDS_START" -t "$SECONDS_END" "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-4000.mp4"
		# rm "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-4000-lip.mp4"
		# mv "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-4000.mp4" "$DIRECTORY_MASTER$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-4000.mp4" 
		echo "[[ S:GENERANDO MASTER:$(date +%s) ]]"

		echo "[[ S:SUBIENDO VIDEO A GALAXY:$(date +%s) ]]"
		GALAXYPUSH="$GALAXYURL?node=$GALAXYNODE&url=$AKAMAI_URL_CLEAN$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-600.mp4&title=$PROGRAM_NAME-$TITLE&thumb=$IMAGE_PATH_CLEAN$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME.jpg&geo_filter=$GEOFILTER&mmedia=$PROGRAM_NAME-$TITLE&site=CHA&duration=0&origin=14"
		echo "##**# wget -qO - $GALAXYPUSH ##**#"
		wget -qO - "$GALAXYPUSH"
		GALAXYPUSH="$GALAXYEXTRAS?mmedia=$PROGRAM_NAME-$TITLE&profile=iphone&url_stream=$AKAMAI_URL_CLEAN$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235.mp4&format=mp4&geo_filter=$GEOFILTER&site=CHA"
		echo "##**# wget -qO - $GALAXYPUSH ##**#"
		wget -qO - "$GALAXYPUSH"
		GALAXYPUSH="$GALAXYEXTRAS?mmedia=$PROGRAM_NAME-$TITLE&profile=ipad&url_stream=$AKAMAI_URL_CLEAN$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-970.mp4&format=mp4&geo_filter=$GEOFILTER&site=CHA"
		echo "##**# wget -qO - $GALAXYPUSH ##**#"
		wget -qO - "$GALAXYPUSH"
		#GALAXYPUSH="$GALAXYEXTRAS?mmedia=$PROGRAM_NAME-$TITLE&profile=m3u8&url_stream=$AKAMAI_URL_CLEAN$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-,150,235,480,600,970,.mp4.csmil/master.m3u8&format=m3u8&geo_filter=$GEOFILTER&site=CHA"
		GALAXYPUSH="$GALAXYEXTRAS?mmedia=$PROGRAM_NAME-$TITLE&profile=m3u8&url_stream=http://m4vhds.tvolucion.com/i/m4v/tst/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-,150,480,600,.mp4.csmil/master.m3u8&format=m3u8&geo_filter=$GEOFILTER&site=CHA"
		echo "##**# wget -qO - $GALAXYPUSH ##**#"
		wget -qO - "$GALAXYPUSH"
		#GALAXYPUSH="$GALAXYEXTRAS?mmedia=$PROGRAM_NAME-$TITLE&profile=hls&url_stream=$AKAMAI_URL_CLEAN$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-,150,235,480,600,970,.mp4.csmil/manifest.f4m&format=f4m&geo_filter=$GEOFILTER&site=CHA"
		GALAXYPUSH="$GALAXYEXTRAS?mmedia=$PROGRAM_NAME-$TITLE&profile=hds&url_stream=$AKAMAI_URL_CLEAN$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-,150,480,600,.mp4.csmil/manifest.f4m&format=f4m&geo_filter=$GEOFILTER&site=CHA"
		echo "##**# wget -qO - $GALAXYPUSH ##**#"
		wget -qO - "$GALAXYPUSH"
		echo "[[ E:SUBIENDO VIDEO A GALAXY:$(date +%s) ]]"


		echo "[[ S:SUBIENDO XML A BRIGHTCOVE:$(date +%s) ]]"
		echo "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-150.mp4"
		SIZE_150=$(cat "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-150.mp4" | wc -c | tr -d ' ' )
		SIZE_480=$(cat "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-480.mp4" | wc -c | tr -d ' ' )
		SIZE_600=$(cat "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-600.mp4" | wc -c | tr -d ' ' )
		SIZE_THB=$(cat "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME.jpg" | wc -c | tr -d ' ' )
		SIZE_STL=$(cat "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-STILL.jpg" | wc -c | tr -d ' ' )

		RELEASE_DATE=$(date +"%Y-%m-%d 00:00:00")
		SHORT_DATE=$(date +"%Y%m%d")
		
		cp "$BRIGHTCOVE_XML" "$XML_PATH$FILE_NAME.xml"
		echo "$BRIGHTCOVE_XML" "$XML_PATH$FILE_NAME.xml"
		cp "$XML_PATH$FILE_NAME.xml" "$XML_PATH$FILE_NAME_bckup.xml"
		echo "$XML_PATH$FILE_NAME.xml" "$XML_PATH$FILE_NAME_bckup.xml"
		cp "$XML_PATH$FILE_NAME.xml" "$XML_PATH$FILE_NAME-bcmnfst.xml"
		echo "$XML_PATH$FILE_NAME.xml" "$XML_PATH$FILE_NAME-bcmnfst.xml"

		sed -i "$XML_PATH$FILE_NAME_bckup.xml" \
		-e "s/{{program-name}}/$PROGRAM_NAME/" \
		-e "s/{{short-name}}/$FILE_NAME/" \
		-e "s/{{short-name}}-/$FILE_NAME-/" \
		-e "s/{{email}}/$EMAIL_APP/" \
		-e "s/{{publisher-id}}/$PUBLISHER_ID/" \
		-e "s/{{preparer}}/$PREPARER/" \
		-e "s/{{callback-url}}/$CALLBACK_URL/" \
		-e "s/{{akamai-url}}/$AKAMAI_URL$PROGRAM_NAME\/$DIRECTORY_NAME\/$FILE_NAME/" \
		-e "s/{{image-url}}/$IMAGE_PATH$PROGRAM_NAME\/$DIRECTORY_NAME\/$FILE_NAME/" \
		-e "s/{{asset-path}}/m4v\/boh\/$PROGRAM_NAME\/$DIRECTORY_NAME\/$FILE_NAME/" \
		-e "s/{{ref-id}}/$DIRECTORY_NAME/" \
		-e "s/{{size-150}}/$SIZE_150/" \
		-e "s/{{size-480}}/$SIZE_480/" \
		-e "s/{{size-600}}/$SIZE_600/" \
		-e "s/{{size-thumb}}/$SIZE_THB/" \
		-e "s/{{size-still}}/$SIZE_STL/" \
		-e "s/{{title}}/$TITLE/" \
		-e "s/{{geofilter}}/$GEOFILTER/" \
		-e "s/{{release-date}}/$RELEASE_DATE/" \
		-e "s/{{short-date}}/$SHORT_DATE/" \
		"$XML_PATH$FILE_NAME-bcmnfst.xml"
		more "$XML_PATH$FILE_NAME-bcmnfst.xml"
		ncftpput -u "$BRIGHTCOVE_USR" -p "$BRIGHTCOVE_PSW" -v -B 3145728 "$BRIGHTCOVE_URL" "/" "$XML_PATH$FILE_NAME-bcmnfst.xml"
		echo  "$XML_PATH$FILE_NAME-bcmnfst.xml"
		echo "[[ E:SUBIENDO XML A BRIGHTCOVE:$(date +%s) ]]"

	fi

if [ $VIDEO_TYPE = "SHORT" ]
	then
		echo "[[ S:REALIZANDO FIX A METADATA DEL VIDEO:$(date +%s) ]]"
		cd $MOOV_DIRECTORY
		$PHP_EXEC "$MOOV_PHP" "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4"
		echo "[[ E:REALIZANDO FIX A METADATA DEL VIDEO:$(date +%s) ]]"

		echo "[[ S:ELIMINANDO INFORMACION TEMPORAL:$(date +%s) ]]"
		rm "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-orig.mp4"
		rm "$DIRECTORY_MEDIA$VIDEO_TYPE/$FILE_NAME/$PROGRAM_NAME/$DIRECTORY_NAME/$FILE_NAME-235-edit.mp4"
		echo "[[ E:ELIMINANDO INFORMACION TEMPORAL:$(date +%s) ]]"
	fi

PROCESS_END=$(date +%s)
echo "[[ E:PROCESANDO VOD:$(date +%s) ]]"
echo $PROCESS_END - $PROCESS_START
