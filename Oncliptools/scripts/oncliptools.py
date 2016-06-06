import os, time, subprocess, hashlib, video_config, random
from conexion import ConnectDB
from upload_class import *
from os import listdir
from os.path import isfile, join
from datetime import datetime
import shutil
import re
import logging
import json
import socket


class Oncliptools:
	global con, video_config, brightcove_config, akamai_config, galaxy_config, debug
	
	def __init__(self,database_config,video_config, brightcove_config, akamai_config, galaxy_config):
		self.con = ConnectDB(database_config["server"],database_config["user"],database_config["password"],database_config["schema"])
		self.video_config = video_config
		self.brightcove_config = brightcove_config
		self.akamai_config = akamai_config
		self.galaxy_config = galaxy_config
		self.debug=0
		

	def md5Checksum(self,filePath):
		with open(filePath, 'rb') as fh:
			m = hashlib.md5()
			while True:
				data = fh.read(8192)
				if not data:
					break
				m.update(data)
			return m.hexdigest()

	def getVideoPending(self):
		sql = " select video_id from progress_video where step_current=0 and host='' and process_end=0 order by video_id desc limit 1"
		video = self.con.select(sql)
		return video

	def getVideoInfo(self,video_id=0):
		sql = " select reference_guid, short_name, pid, title from videos where id= " + video_id
		video_info = self.con.select(sql)
		return video_info

	def getVideoProperties(self,video_id=0):
		sql = " select property_name, property_value from videos_properties where video_id= " + video_id
		videos_properties = self.con.select(sql)
		return videos_properties

	def getValueProperty(self,propertiesVideo,property_name):
		for propertie in propertiesVideo:
                        if property_name in propertie:
                                return propertie[1]

                return ""
		
	def resetVideoQualities(self):
		signals = self.getSignalsInfo()
		for signal in signals:
			video = self.getVideoSignalInfo(signal)
			output = self.downloadVideoBitrates(video)
			log_bitrates = output
			bitrates = self.getBitRates("signaltest" + signal[2])
			bitrate_quality_relationship = self.processBitRates(bitrates)
			log_bitrates += self.saveBitratesRelationship(bitrate_quality_relationship,signal[3])
			log_bitrates += self.removeTs("signaltest" + signal[2])
			log_bitrates += self.removeVideos("signaltest" + signal[2])
		
	def createDir(self,prefix,dst):
		if self.debug:
			directorio = "mkdir -p " + self.video_config["DIRECTORY_MEDIA"] + prefix
		else:
			if dst:
				directorio=self.video_config["DIRECTORY_MEDIA"] + prefix
			else:
				directorio=self.video_config["DIRECTORY_MASTER"] + prefix
			if not os.path.isdir(directorio):
				os.makedirs(directorio)

		return directorio			

	def removeTs(self,prefix,ext=""):
		if self.debug:
                        if ext=="":
                                directorio = "rm -f " + self.video_config["OUTPUT_DIRECTORY"] + prefix +".ts"
                        else:
                                directorio = "rm -f " + self.video_config["OUTPUT_DIRECTORY"] + prefix + ext
		else:
                        if ext=="":
                                directorio = self.video_config["OUTPUT_DIRECTORY"] + prefix +".ts"
                        else:
                                directorio = self.video_config["OUTPUT_DIRECTORY"] + prefix + ext
			if os.path.exists(directorio):
				os.remove(directorio)

		return directorio

	def removeVideos(self,prefix,ext=".mp4"):
		if self.debug:
			directorio = "rm " + self.video_config["DIRECTORY_MEDIA"] + prefix +ext
		else:
			directorio = self.video_config["DIRECTORY_MEDIA"] + prefix +ext
			if os.path.exists(directorio):
                                if os.path.isdir(directorio):
                                        shutil.rmtree(directorio)
                                else:
                                        os.remove(directorio)

		return directorio

	def copyVideos(self,source,dest,opt):
		if self.debug:
			if opt:
				output = "cp " + self.video_config["DIRECTORY_MEDIA"] + source + " " + self.video_config["DIRECTORY_MEDIA"] + dest
			else:
				output = "cp " + self.video_config["DIRECTORY_MEDIA"] + source + " " + self.video_config["DIRECTORY_MASTER"] + dest
		else:
			if opt:
				output = shutil.copy(self.video_config["DIRECTORY_MEDIA"] + source, self.video_config["DIRECTORY_MEDIA"] + dest)
			else:
				output = shutil.copy(self.video_config["DIRECTORY_MEDIA"] + source, self.video_config["DIRECTORY_MASTER"] + dest)

		return output

	def saveProgressVideo(self,video_id,step=0,status=""):
		log = ""
		sql="select id from progress_video where video_id=" + video_id
		progress_id = self.con.select(sql)
		i = datetime.now()
		if len(progress_id)==0:#MODIFICAR PARA QUE SOLO ACTUALICE EL NOMBRE DEL EQUIPO QUE LO PROCESA
			sql_insert = "insert into progress_video (video_id, step_current, host, process_start, process_end, created_at, updated_at) values ("+video_id+",1,"+socket.gethostname()+","+str(time.time())+",0,'"+i.strftime('%Y/%m/%d %H:%M:%S')+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"')"
			log += sql_insert + "\n"
			self.con.insert(sql_insert)
			self.con.commit()
		else:
			if status=="fin":
				sql_update = "update progress_video set step_current="+ str(step) +", process_end="+ str(time.time())+", updated_at ='"+i.strftime('%Y/%m/%d %H:%M:%S')+"'  where video_id = " + video_id
			elif step==0:
                                sql_update = "update progress_video set step_current="+ str(step) +", host ='"+socket.gethostname()+"', updated_at ='"+i.strftime('%Y/%m/%d %H:%M:%S')+"'  where video_id = " + video_id
                        else:
				sql_update = "update progress_video set step_current="+ str(step) +", updated_at ='"+i.strftime('%Y/%m/%d %H:%M:%S')+"'  where video_id = " + video_id
			log += sql_update + "\n"
			self.con.insert(sql_update)
			self.con.commit()
		return log

	def saveBitratesRelationship(self,bitrate_quality_relationship,signal_id):
		for bitrate_quality in bitrate_quality_relationship:
			sql="select id from bitrates where quality=" + str(bitrate_quality) + " and signal_id = " + str(signal_id)
			bitrates = self.con.select(sql)
			log = ""
			i = datetime.now()
			if len(bitrates)==0:
				sql_insert = "insert into bitrates (signal_id, quality, bitrate, created_at, updated_at) values ("+str(signal_id)+","+str(bitrate_quality)+","+str(bitrate_quality_relationship[bitrate_quality])+",'"+i.strftime('%Y/%m/%d %H:%M:%S')+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"')"
				log += sql_insert + "\n"
				self.con.insert(sql_insert)
				self.con.commit()
			else:
				sql_update = "update bitrates set bitrate="+ str(bitrate_quality_relationship[bitrate_quality]) + ", updated_at ='"+i.strftime('%Y/%m/%d %H:%M:%S')+"'  where id = " + str(bitrates[0][0])
				log += sql_update + "\n"
				self.con.insert(sql_update)
				self.con.commit()
		return log

	def saveVideosBitratesRelationship(self,bitrate_quality_relationship,video_id):
		for bitrate_quality in bitrate_quality_relationship:
			sql="select id from videos_qualities_bitrates_relationship where quality=" + str(bitrate_quality) + " and video_id = " + str(video_id)
			bitrates = self.con.select(sql)
			log = ""
			i = datetime.now()
			if len(bitrates)==0:
				sql_insert = "insert into videos_qualities_bitrates_relationship (video_id, quality, bitrate, pid, akamai, quaity_akamai, created_at, updated_at) values ("+str(video_id)+","+str(bitrate_quality)+","+str(bitrate_quality_relationship[bitrate_quality])+", '', 0, '','"+i.strftime('%Y/%m/%d %H:%M:%S')+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"')"
				log += sql_insert + "\n"
				self.con.insert(sql_insert)
				self.con.commit()
			else:
				sql_update = "update videos_qualities_bitrates_relationship set bitrate="+ str(bitrate_quality_relationship[bitrate_quality]) + ", updated_at ='"+i.strftime('%Y/%m/%d %H:%M:%S')+"'  where id = " + str(bitrates[0][0])
				log += sql_update + "\n"
				self.con.insert(sql_update)
				self.con.commit()
		return log

	def updateVideosBitratesRelationship(self,video_id,quality,pid):
		log = ""
		i = datetime.now()
		sql_update = "update videos_qualities_bitrates_relationship set pid="+ str(pid) + ", updated_at ='"+i.strftime('%Y/%m/%d %H:%M:%S')+"'  where video_id = " + video_id + " and quality = " + quality
		log += sql_update + "\n"
		self.con.insert(sql_update)
		self.con.commit()
		return log

	def updateQualityAkamai(self,video_id=0,quality=0,qualityAkamai=0):
		log = ""
		i = datetime.now()
		sql_update = "update videos_qualities_bitrates_relationship set akamai=1, quaity_akamai="+ str(qualityAkamai) +", updated_at ='"+i.strftime('%Y/%m/%d %H:%M:%S')+"'  where video_id = " + video_id + " and quality = " + quality
		log += sql_update + "\n"
		self.con.insert(sql_update)
		self.con.commit()
		return log


	def processBitRates(self,bitrates):
		qualities = self.getQualities()
		bitrate_quality_relationship = {}
		if  len(bitrates) == (len(qualities) + 1) and bitrates[0] > 199000:
			for num in range(0,len(qualities)):
				bitrate_quality_relationship[qualities[num][0]]=bitrates[num]
		else:
			if bitrates[0]<=199000:
				bitrate=bitrates[1]
			else:
				bitrate=bitrates[0]
			for num_quality in range(0,len(qualities)):
				for num in range(0,len(bitrates)):	
					if(int(qualities[num_quality][0])==150 and bitrates[num] > 199000 and bitrates[num] <= 299000):
						bitrate=bitrates[num]
					if(int(qualities[num_quality][0])==235 and bitrates[num] > 299000 and bitrates[num] <= 499000):
						bitrate=bitrates[num]
					if(int(qualities[num_quality][0])==480 and bitrates[num] > 499000 and bitrates[num] <= 599000):
						bitrate=bitrates[num]
					if(int(qualities[num_quality][0])==600 and bitrates[num] > 599000 and bitrates[num] <= 799000):
						bitrate=bitrates[num]
					if(int(qualities[num_quality][0])==970 and bitrates[num] > 799000 and bitrates[num] <= 1000000):
						bitrate=bitrates[num]
					bitrate_quality_relationship[qualities[num_quality][0]]=bitrate
		bitrate_quality_relationship['0']=bitrates[len(bitrates)-1]#maxquality
		return bitrate_quality_relationship

	def getQualities(self):
		sql = " select quality from qualities "
		qualities = self.con.select(sql)
		return qualities

	def getQualitiesBitRates(self,video_id=0,quality="all",bitrate=""):
		if quality=="all_except_0":
			sql = " select quality, bitrate from videos_qualities_bitrates_relationship where video_id= " +video_id+" and quality!='0' group by bitrate order by quality"
		if quality=="0":
			sql = " select quality, bitrate from videos_qualities_bitrates_relationship where video_id= " +video_id+" and quality='0'"
		if quality=="all":
			sql = " select quality, bitrate from videos_qualities_bitrates_relationship where video_id= " +video_id

		if bitrate!="":
			sql = " select quality from videos_qualities_bitrates_relationship where video_id= " + video_id + " and bitrate= " + bitrate

		qualitiesBit = self.con.select(sql)
		return qualitiesBit

	def getQualitiesAkamai(self,video_id=0):
		sql = " select quality from videos_qualities_bitrates_relationship where video_id= " + video_id + " and quality!=0 and akamai=0"
		qualitiesAka = self.con.select(sql)
		return qualitiesAka


	def getSignalsInfo(self, name=""):
		if name=="":
				sql = " select url_signal_hds, quality_range, short_name, id from signals group by short_name "
		else:
				sql = " select url_signal_hds, quality_range, id from signals where short_name='" + name + "'"		
		signals = self.con.select(sql)
		return signals

	def insertPropertyVideo(self,video_id=0,reference_guid="",pname="",pvalue=""):
		i = datetime.now()
		if video_id:
                        sql_insert = "insert into videos_properties (video_id, reference_guid, property_name, property_value, created_at, updated_at) values ("+video_id+",'"+reference_guid+"','"+pname+"','"+pvalue+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"')"
			self.con.insert(sql_insert)
			self.con.commit()
		return sql_insert

	def insertNotificationVideo(self,video_id=0):
		i = datetime.now()
		if video_id:
                        sql_insert = "insert into notification (video_id, mail, msg, created_at, updated_at) values ("+video_id+",0,0,'"+i.strftime('%Y/%m/%d %H:%M:%S')+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"')"
			self.con.insert(sql_insert)
			self.con.commit()
		return sql_insert

        def searchImagesGenerated(self, signal_id=0,time_created=0):
		sql = " select * from images where time_created=" + str(time_created) + " and signal_id=" + str(signal_id)		
		images = self.con.select(sql)
		return images

        def insertImagesInfo(self,infoImg):
		i = datetime.now()
		if "error" in infoImg:
                        sql_insert = "insert into images (time_created, signal_id, thumb_num, thumb_urls, status, info, created_at, updated_at) values ("+str(infoImg['start'])+","+str(infoImg['signal_id'])+",0,'',0,'"+infoImg['info']+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"')"
                else:
                        sql_insert = "insert into images (time_created, signal_id, thumb_num, thumb_urls, status, info, created_at, updated_at) values ("+str(infoImg['start'])+","+str(infoImg['signal_id'])+","+str(infoImg['thumb_num'])+",'"+infoImg['thumb_urls']+"',1,'"+infoImg['info']+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"','"+i.strftime('%Y/%m/%d %H:%M:%S')+"')"
		self.con.insert(sql_insert)
		self.con.commit()
		return sql_insert
        
	def getVideoSignalInfo(self,signal,video_id=0):
		video = {}
		video["signal"] = signal[0]
		if video_id>0:
			propertiesVideo=self.getVideoProperties(video_id)
			video["start"] = self.getValueProperty(propertiesVideo,"trimStartTimestamp")
			video["end"] = self.getValueProperty(propertiesVideo,"trimEndTimestamp")
			videoInfo=self.getVideoInfo(video_id)
			video["reference_guid"]=videoInfo[0][0]
			video["fileName"] = videoInfo[0][1] 
			video["program"] = self.getValueProperty(propertiesVideo,"program")
			video["title"] = self.getValueProperty(propertiesVideo,"title")
			video["time_start"] = self.getValueProperty(propertiesVideo,"time_start")
			video["time_end"] = self.getValueProperty(propertiesVideo,"time_end")
			video["geoblocking"] = self.getValueProperty(propertiesVideo,"geoblocking")
			if (self.getValueProperty(propertiesVideo,"galaxy")=="on"):
                                video["galaxy_node"] = self.getValueProperty(propertiesVideo,"galaxy_node")
                        if (self.getValueProperty(propertiesVideo,"cq5")=="on"):
                                video["cq5_node"] = self.getValueProperty(propertiesVideo,"cq5_node")
                        if (self.getValueProperty(propertiesVideo,"cq5deportes")=="on"):
                                video["cq5deportes_node"] = self.getValueProperty(propertiesVideo,"cq5deportes_node")
                        if (self.getValueProperty(propertiesVideo,"master")=="on"):
                                video["master"] = "on"
                        if (self.getValueProperty(propertiesVideo,"onlyMaster")=="on"):
                                video["onlyMaster"] = "on"
                        if (self.getValueProperty(propertiesVideo,"generateMaster")=="on"):
                                video["generateMaster"] = "on"
                        if (self.getValueProperty(propertiesVideo,"cuts")=="on"):
                                video["cuts"] = self.getValueProperty(propertiesVideo,"cuts_values")
			video["directory"] =video['program']+"/"+video["reference_guid"]
		else:
			video["start"] = int(time.time()) - self.video_config["adjust_time"] - 600
			video["end"] = video["start"] + 11
			video["directory"] = self.video_config["OUTPUT_DIRECTORY"] + "signaltest" + str(signal[2])
		return video

	def getBitRates(self,prefix):
		bitrates = []
		onlyfiles = [ f for f in listdir(self.video_config["OUTPUT_DIRECTORY"]) if isfile(join(self.video_config["OUTPUT_DIRECTORY"],f)) ]
		for fileName in onlyfiles:
			if(fileName.find(prefix)>=0 and fileName.find(".ts")==-1):
				fileName = fileName.replace(prefix + "_", "")
				fileName = fileName.replace(".mp4", "")
				bitrate = int(fileName)
				bitrates.append(bitrate)
		return sorted(bitrates)

	def downloadVideoBitrates(self,video,quality = ""):
		if "short" in video:
			quality = "-b 199-400"
		if quality=="":
			bashCommand = "mono " + self.video_config["HLS_PROGRAM"] + " -s " + video["signal"] + " --ignore 'a-p' --ignore 'a-b' "+ quality +" -v --start " + str(video["start"]) + " --end " + str(video["end"]) + " -o " + video["directory"] 
		if quality=="0":
			bashCommand = "mono " + self.video_config["HLS_PROGRAM"] + " -s " + video["signal"] + " --ignore 'a-p' --ignore 'a-b' -v --start " + str(video["start"]) + " --end " + str(video["end"]) + " -o " + self.video_config["OUTPUT_DIRECTORY"]+video["fileName"] 
		else:
			bashCommand = "mono " + self.video_config["HLS_PROGRAM"] + " -s " + video["signal"] + " --ignore 'a-p' --ignore 'a-b' "+ quality +" -v --start " + str(video["start"]) + " --end " + str(video["end"]) + " -o " + self.video_config["OUTPUT_DIRECTORY"]+video["fileName"] 		
		if self.debug:
			output=bashCommand
		else:
			process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
			output = process.communicate()[0]

		return output

	def moveFilesProcess(self,video,quality):
		if self.debug:
			output="mv " + self.video_config["OUTPUT_DIRECTORY"] + video["fileName"] + "_" + quality[1] +".mp4 " + self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + "-" + quality[0] + "-lip-g.mp4"
		else:
			output = shutil.move(self.video_config["OUTPUT_DIRECTORY"] + video["fileName"] + "_" + quality[1] +".mp4", self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + "-" + quality[0] + "-lip-g.mp4")
		
		return output

	def changeKeyInterval(self,video,quality):
		bashCommand = self.video_config["FFMPEG"]+" -i " + self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + "-" + quality[0] + "-lip-g.mp4  -g 2 -vcodec copy -acodec copy " +self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + "-" + quality[0] + "-lip.mp4"
		if self.debug:
			output=bashCommand
		else:
			process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
			output = process.communicate()[0]

		return output

	def lipSyncCutVideo(self,video,quality,tstart,tend,prefix = ""):
		if "short" in video:
			bashCommand = self.video_config["FFMPEG"] + " -async 2 -i " + self.video_config["DIRECTORY_MEDIA"] + video["directory"] + "/" + video["fileName"] + "-" + quality[0] + "-orig.mp4 -g 2 " +self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + "-" + quality[0] + "-edit.mp4"
		else:
                        #finalcut=float(video["time_end"])-float(video["time_start"])
			bashCommand = self.video_config["FFMPEG"] + " -async 2 -i " + self.video_config["DIRECTORY_MEDIA"] + video["directory"] + "/" + video["fileName"] + "-" + quality[0] + "-lip.mp4 -g 2 -ss "+ str(tstart) + " -t " + str(tend) + " " +self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + "-" + quality[0] + prefix + ".mp4"

		if self.debug:
			output=bashCommand
		else:
			process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
			output = process.communicate()[0]

		return output

	def generateTS(self,video,quality,prefix = ""):
		bashCommand = self.video_config["FFMPEG"] + " -i " + self.video_config["DIRECTORY_MEDIA"] + video["directory"] + "/" + video["fileName"] + "-" + quality[0] + prefix + ".mp4 -c copy -bsf:v h264_mp4toannexb -f mpegts " + self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + "-" + quality[0] + prefix + ".ts"
		if self.debug:
			output=bashCommand
		else:
			process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
			output = process.communicate()[0]

		return output

	def concatTS(self,video,quality,concatString):
		bashCommand = self.video_config["FFMPEG"] + " -i concat:" + concatString + " -c copy -bsf:a aac_adtstoasc " + self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + "-" + quality[0] + ".mp4"
		if self.debug:
			output=bashCommand
		else:
			process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
			output = process.communicate()[0]
		return output

	def generateThumbnails(self,video,size,sufijo=""):
                imgVideo="-970.mp4"
                bashCommand = self.video_config["FFMPEG"] + " -i " + self.video_config["DIRECTORY_MEDIA"] + video["directory"] + "/" + video["fileName"] +imgVideo+" -vcodec mjpeg -vframes 1 -an -f rawvideo -s "+ size + " -ss 00:00:10 "+self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + sufijo + ".jpg"
		if self.debug:
			output=bashCommand
		else:
			process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
			output = process.communicate()[0]

		return output

	def generateImages(self,video,filesDown):
                #genera imganes de un video 1 cada 10 seg "-vf fps=fps=1/10"
                bashCommand = self.video_config["FFMPEG"]+" -i " + filesDown + " -sameq -vf fps=fps=1/10 " + self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + str(video["start"]) + "_%03d.png"
                if self.debug:
			output=bashCommand
		else:
			process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
			output = process.communicate()[0]

		return output

	def searchSameVideo(self,video,video_id=0,bitrate=""):
		sameVideos=self.getQualitiesBitRates(video_id,"all",bitrate)
		for quality in sameVideos:
			pathVideo=self.video_config['DIRECTORY_MEDIA']+video['directory']+"/"+video['fileName']+"-"+ quality[0]+".mp4"
			if (os.path.exists(pathVideo)):
				return quality[0]

	def uploadAkamaiVideo(self,video_id,video,quality):
		upFile=video['fileName']+"-"+quality+".mp4"
		if self.debug:
			output="Directorio a crear: "+video["directory"]
			output+="Archivo a subir: "+self.video_config["DIRECTORY_MEDIA"]+video["directory"]+"/"+upFile
			sqlUpdate=self.updateQualityAkamai(video_id,quality,quality)
			#si es el primer video que termina se sube para todos
			qualitiesAka=self.getQualitiesAkamai(video_id)
			for upQuality in qualitiesAka:
				other=video['fileName']+"-"+upQuality[0]+".mp4"
				sqlUpdate=self.updateQualityAkamai(video_id,upQuality[0],quality)
		else:
			output=""
			upAkamai=Uploads(self.akamai_config)
			output=upAkamai.move_to_dir(video["directory"])
			output=upAkamai.upload_file(self.video_config["DIRECTORY_MEDIA"]+video["directory"]+"/"+upFile,upFile)
			sqlUpdate=self.updateQualityAkamai(video_id,quality,quality)
			#si es el primer video que termina se sube para todos
			qualitiesAka=self.getQualitiesAkamai(video_id)
			for upQuality in qualitiesAka:
				other=video['fileName']+"-"+upQuality[0]+".mp4"
				output=upAkamai.upload_file(self.video_config["DIRECTORY_MEDIA"]+video["directory"]+"/"+upFile,other)
				sqlUpdate=self.updateQualityAkamai(video_id,upQuality[0],quality)
				
		return output

	def uploadAkamaiThumb(self,video,upFile):
		if self.debug:
			output="Directorio a crear: "+video["directory"]
			output+="Archivo a subir: "+self.video_config["DIRECTORY_MEDIA"]+video["directory"]+"/"+upFile
		else:
			output=""
			upAkamai=Uploads(self.akamai_config)
			output=upAkamai.move_to_dir(video["directory"])
			output=upAkamai.upload_file(self.video_config["DIRECTORY_MEDIA"]+video["directory"]+"/"+upFile,upFile)
		return output

	def uploadGalaxy(self,video,profile=""):
		if profile=="":
                        duration = 0
                        if "cuts" in video:
                                jdata=json.loads(video["cuts"])
                                for cut in jdata:
                                        duration += (float(cut['time_end'])-float(cut['time_start']))*1000
                        else:
                                duration=(float(video["time_end"])-float(video["time_start"]))*1000
                        GALAXYPUSH=self.galaxy_config["GALAXYURL"]+"?node="+video["galaxy_node"]+"&url="+self.brightcove_config["AKAMAI_URL_CLEAN"]+video["directory"] + "/" + video["fileName"] + "-600.mp4&title="+video["program"]+"-"+video["title"]+"&thumb="+self.brightcove_config["IMAGE_PATH_CLEAN"]+video["directory"]+"/"+video["fileName"]+".jpg&geo_filter="+video["geoblocking"]+"&mmedia="+ video["program"]+"-"+video["title"]+"&site=CHA&duration="+str(int(duration))+"&origin=14"
                if profile=="iphone":
			GALAXYPUSH=self.galaxy_config["GALAXYEXTRAS"]+"?mmedia="+"-"+video["title"]+"&profile=iphone&url_stream="+self.brightcove_config["AKAMAI_URL_CLEAN"]+video["directory"] + "/" + video["fileName"] + "-235.mp4&format=mp4&geo_filter="+video["geoblocking"]+"&site=CHA"		
		if profile=="ipad":
			GALAXYPUSH=self.galaxy_config["GALAXYEXTRAS"]+"?mmedia="+"-"+video["title"]+"&profile=ipad&url_stream="+self.brightcove_config["AKAMAI_URL_CLEAN"]+video["directory"] + "/" + video["fileName"] + "-970.mp4&format=mp4&geo_filter="+video["geoblocking"]+"&site=CHA"		
		if profile=="m3u8":
			GALAXYPUSH=self.galaxy_config["GALAXYEXTRAS"]+"?mmedia="+"-"+video["title"]+"&profile=m3u8&url_stream="+self.galaxy_config["AKAMAI_m3u8"]+video["directory"] + "/" + video["fileName"] + "-,150,235,480,600,970,.mp4.csmil/master.m3u8&format=m3u8&geo_filter="+video["geoblocking"]+"&site=CHA"		
		if profile=="hds":
			GALAXYPUSH=self.galaxy_config["GALAXYEXTRAS"]+"?mmedia="+"-"+video["title"]+"&profile=hds&url_stream="+self.brightcove_config["AKAMAI_URL_CLEAN"]+video["directory"] + "/" + video["fileName"] + "-,150,235,480,600,970,.mp4.csmil/manifest.f4m&format=f4m&geo_filter="+video["geoblocking"]+"&site=CHA"
		#if profile=="cq5deportes":
                        #GALAXYPUSH=self.galaxy_config["AKAMAI_CQ5"]+"?node="+video["cq5deportes_node"]+"&url="+self.brightcove_config["AKAMAI_URL_CLEAN"]+video["directory"] + "/" + video["fileName"] + "-600.mp4&title="+video["program"]+"-"+video["title"]+"&thumb="+self.brightcove_config["IMAGE_PATH_CLEAN"]+video["directory"]+"/"+video["fileName"]+".jpg&geo_filter="+video["geoblocking"]+"&mmedia="+ video["program"]+"-"+video["title"]+"&site=CHA&duration=0&origin=14"
                        #GALAXYPUSH="--post-data 'modification_datetime="+fechaUp+"&referenceId="+video["reference_guid"]+video["title"]+":"+video["cq5deportes_node"]+"&id="+IdBrightcove+"&entity=VIDEO&action=CREATE&status=SUCCESS' "+self.galaxy_config["AKAMAI_CQ5"]

		bashCommand = "wget -qO - "+GALAXYPUSH
		
		if self.debug:
			output=bashCommand
		else:
			process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
			output = process.communicate()[0]

		return output

	def createXML(self,video):
		try:
			fileXML=self.brightcove_config["XML_PATH"]+video["fileName"]+".xml"
			filebckup=self.brightcove_config["XML_PATH"]+video["fileName"]+"_bckup.xml"
			filebcmnfst=self.brightcove_config["XML_PATH"]+video["fileName"]+"-bcmnfst.xml"
			webpath=os.path.dirname(os.path.realpath("__file__"))
			if "/public" in webpath:
				webpath=webpath.replace("/public","/scripts")
			pathXML=webpath+"/"+self.brightcove_config["BRIGHTCOVE_XML"]
                        shutil.copy(pathXML,fileXML)
			shutil.copy(fileXML,filebckup)
			shutil.copy(fileXML,filebcmnfst)

			pathVideo=self.video_config['DIRECTORY_MEDIA']+video['directory']+"/"+video['fileName']
			callback_url=self.brightcove_config["CALLBACK_URL"]
			#ref_id=video["directory"]
			#if ("cq5_node" in video) or ("cq5deportes_node" in video):
                        #        callback_url="http://vcms2.oncliptools.com/api/1/brightcove"
                        ref_id=video["reference_guid"]
                        duration = 0
                        if "cuts" in video:
                                jdata=json.loads(video["cuts"])
                                for cut in jdata:
                                        duration += (float(cut['time_end'])-float(cut['time_start']))*1000
                        else:
                                duration=(float(video["time_end"])-float(video["time_start"]))*1000
			configVideos={
			 "{{program-name}}": video["program"],
			 "{{short-name}}":   video["fileName"],
			 "{{short-name}}-":  video["fileName"]+"-",
			 "{{email}}":        self.brightcove_config["EMAIL_APP"],
			 "{{publisher-id}}": self.brightcove_config["PUBLISHER_ID"],
			 "{{preparer}}":     self.brightcove_config["PREPARER"],
			 "{{callback-url}}": callback_url,
			 "{{akamai-url}}":   self.brightcove_config["AKAMAI_URL"]+video["directory"]+"/"+video["fileName"],
			 "{{image-url}}":    self.brightcove_config["IMAGE_PATH"]+video["directory"]+"/"+video["fileName"],
			 "{{asset-path}}":   "m4v/boh/"+video["directory"]+"/"+video["fileName"],
			 "{{ref-id}}":       ref_id,
			 "{{size-150}}":     os.path.getsize(pathVideo+"-150.mp4"),
			 "{{size-480}}":     os.path.getsize(pathVideo+"-480.mp4"),
			 "{{size-600}}":     os.path.getsize(pathVideo+"-600.mp4"),
			 "{{size-thumb}}":   os.path.getsize(pathVideo+".jpg"),
			 "{{size-still}}":   os.path.getsize(pathVideo+"-STILL.jpg"),
			 "{{title}}":		 video["title"],
			 "{{geofilter}}":    video["geoblocking"],
			 "{{release-date}}": time.strftime("%Y-%m-%d 00:00:00"),
			 "{{short-date}}":   time.strftime("%Y%m%d"),
                         "{{duration}}":   int(duration)
			}
			regex = re.compile("(%s)" % "|".join(map(re.escape, configVideos.keys())))
			filer = open(filebckup, "r")
			filew = open(filebcmnfst, "w")
			buff = filer.read()
			rbuff = regex.sub(lambda x: str(configVideos[x.string[x.start() :x.end()]]), buff)
			filew.write(rbuff)
			filer.close()
			filew.close()
			return filebcmnfst
		except Exception, e:
			logging.error("Error ocurrido al generar XML: %s ", e)
		
	def uploadBrightcove(self,upXML):
		tname=upXML.split("/")
		if self.debug:
			output="Archivo a subir: "+tname[len(tname)-1]
		else:
			output="Archivo a subir: "+tname[len(tname)-1]
			upAkamai=Uploads(self.brightcove_config)
			output=upAkamai.upload_file(upXML,tname[len(tname)-1])
		return output

	def pushBrightcove(self,video,video_id=0):

                duration = 0
                if "cuts" in video:
                        jdata=json.loads(video["cuts"])
                        for cut in jdata:
                                duration += (float(cut['time_end'])-float(cut['time_start']))*1000
                else:
                        duration=(float(video["time_end"])-float(video["time_start"]))*1000

                
                ren=[]
                qualitiesBit=self.getQualitiesBitRates(video_id,"all_except_0")
                logging.debug("%s",qualitiesBit)
                for quality in qualitiesBit:
                        cal={}
                        cal["encodingRate"]=quality[0]+"000"
                        cal["url"]=self.brightcove_config["AKAMAI_URL"]+video["directory"]+"/"+video["fileName"]+"-"+quality[0]+".mp4"
                        cal["videoContainer"]="MP4"
                        ren.append(cal)
                        
                paramBrigh={
                        "direct_qc5": 1,
                        "entity": "VIDEO",
                        "action": "CREATE",
                        "status": "SUCCESS",
                        "id":"",
                        "referenceId":video["reference_guid"]+":"+video["cq5deportes_node"],
                        "data__bright": {
                                "id": "",
                                "name": video["title"],
                                "shortDescription": video["title"],
                                "thumbnailURL": self.brightcove_config["IMAGE_PATH"]+video["directory"]+"/"+video["fileName"]+".jpg",
                                "videoStillURL": self.brightcove_config["IMAGE_PATH"]+video["directory"]+"/"+video["fileName"]+"-STILL.jpg",
                                "FLVURL": self.brightcove_config["AKAMAI_URL"]+video["directory"]+"/"+video["fileName"]+"-480.mp4",
                                "videoFullLength":{
                                        "videoDuration": int(duration)
                                        },
                                "customFields":{
                                        "geofilter": video["geoblocking"]
                                        },
                                "renditions":ren
                        }
                }
                #json_text=json.dumps(paramBrigh,ensure_ascii=False).encode('utf-8')
                param=""
                for k,v in paramBrigh.iteritems():
                        if(type(v) is dict):
                                for ke, va in v.iteritems():
                                        if (type(va) is dict):
                                                for key, val in va.iteritems():
                                                        if(type(val) is str):
                                                                param+=k+'["'+ke+'"]'+'["'+key+'"]='+val+'&'
                                                        else:
                                                                param+=k+'["'+ke+'"]'+'["'+key+'"]='+str(val)+'&'
                                        elif (type(va) is list):
                                                for i, video in enumerate(va):
                                                        if(type(video) is dict):
                                                                for clave,valor in video.iteritems():
                                                                        param+=k+'["'+ke+'"]'+'['+str(i)+']'+'["'+clave+'"]='+valor+'&'
                                        elif (type(va) is str):
                                                param+=k+'["'+ke+'"]='+va+'&'
                                        else:
                                                param+=k+'["'+ke+'"]='+str(va)+'&'
                        elif (type(v) is str):
                                param+=k+'='+v+'&'
                        else:
                                param+=k+'='+str(v)+'&'

                parametros=param.replace('"','')
                logging.debug("%s",parametros)
		
                bashCommand = 'wget -qO - --post-data="'+parametros[:-1]+'"  "http://galaxy.esmas.com/AJAX/api_bright.php"'
                
		logging.debug("%s",bashCommand)
		if self.debug:
			output=bashCommand
		else:
			process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
			output = process.communicate()[0]

		return output

		
	def processQualityVideo(self,video,quality):
		logging.debug("[[ S:PROCESANDO VIDEO DE LA CALIDAD %s: %s ]]",quality[0],time.time())
		logging.debug("[[ S:MOVIENDO ARCHIVO A DIRECTORIO PARA PROCESAR: %s ]]",time.time())
		moveVideo = self.moveFilesProcess(video,quality)
		logging.debug("%s",moveVideo)
                logging.debug("[[ E:MOVIENDO ARCHIVO A DIRECTORIO PARA PROCESAR: %s ]]",time.time())
        
                logging.debug("[[ S:ELIMINANDO TS: %s ]]",time.time())
                log_bitrate=self.removeTs(video['fileName']+"_"+quality[1])
                logging.debug("%s",log_bitrate)
                logging.debug("[[ E:ELIMINANDO TS: %s ]]",time.time())
                
                logging.debug("[[ S:CAMBIANDO EL KEYINTERVAL: %s ]]",time.time())
                sync=self.changeKeyInterval(video,quality)
                logging.debug("%s",sync)
                logging.debug("[[ E:CAMBIANDO EL KEYINTERVAL: %s ]]",time.time())
                
                logging.debug("[[ S:ELIMINANDO RESIDUOS KEYINTERVAL: %s ]]",time.time())
                log_bitrate=self.removeVideos(video['directory']+"/"+video['fileName']+"-"+ quality[0]+"-lip-g")
                logging.debug("%s",log_bitrate)
                logging.debug("[[ E:ELIMINANDO RESIDUOS KEYINTERVAL: %s ]]",time.time())
                
                logging.debug("[[ S:CORRIGIENDO LIPSYNC Y RECORTANDO: %s ]]",time.time())
                if "cuts" in video:
                        logging.debug("***************************************************************")
                        print "***************************************************************"
                        jdata=json.loads(video["cuts"])
                        jdata.sort(key=lambda x:float(x['time_start']))
                        i = 0
                        for cut in jdata:
                                i += 1
                                finalcut=float(cut['time_end'])-float(cut['time_start'])
                                prefix="_"+str(i)
                                log_bitrate=self.lipSyncCutVideo(video,quality,float(cut['time_start']),finalcut,prefix)
                                logging.debug("%s",log_bitrate)

                        print "***************************************************************"
                        logging.debug("***************************************************************")           
                else:
                        finalcut=float(video["time_end"])-float(video["time_start"])
                        log_bitrate=self.lipSyncCutVideo(video,quality,float(video["time_start"]),finalcut)
                        logging.debug("%s",log_bitrate)
                logging.debug("[[ E:CORRIGIENDO LIPSYNC Y RECORTANDO: %s ]]",time.time())

                if "cuts" in video:
                        logging.debug("[[ S:CONVIRTIENDO A TS PARA HACER EL SWITCH: %s ]]",time.time())
                        logging.debug("***************************************************************")
                        print "***************************************************************"
                        jdata=json.loads(video["cuts"])
                        i = 0
                        for cut in jdata:
                                i += 1
                                prefix="_"+str(i)
                                log_ts=self.generateTS(video,quality,prefix)
                                logging.debug("%s",log_ts)
                        print "***************************************************************"
                        logging.debug("***************************************************************")   
                        logging.debug("[[ E:CONVIRTIENDO A TS PARA HACER EL SWITCH: %s ]]",time.time())

                        logging.debug("[[ S:CONCATENANDO LOS CORTES DE VIDEO: %s ]]",time.time())
                        logging.debug("***************************************************************")
                        print "***************************************************************"
                        i = 0
                        concatString = ""
                        for cut in jdata:
                                i += 1
                                concatString +=self.video_config["DIRECTORY_MEDIA"]+ video["directory"] + "/" + video["fileName"] + "-" + quality[0] + "_" + str(i) + ".ts"
                                if (i<len(jdata)):
                                        concatString += '|'
                        log_concat=self.concatTS(video,quality,concatString)
                        logging.debug("%s",log_concat)
                        print "***************************************************************"
                        logging.debug("***************************************************************")   
                        logging.debug("[[ E:CONCATENANDO LOS CORTES DE VIDEO: %s ]]",time.time())

                        logging.debug("[[ S:ELIMINANDO ARCHIVOS TEMPORALES: %s ]]",time.time())
                        logging.debug("***************************************************************")
                        print "***************************************************************"
                        i = 0
                        for cut in jdata:
                                i += 1
                                prefix="_"+str(i)
                                log_ts=self.removeVideos(video['directory']+"/"+video['fileName']+"-"+ quality[0]+prefix)
                                logging.debug("%s",log_ts)
                                log_ts=self.removeVideos(video['directory']+"/"+video['fileName']+"-"+ quality[0]+prefix,".ts")
                                logging.debug("%s",log_ts)
                        print "***************************************************************"
                        logging.debug("***************************************************************")   
                        logging.debug("[[ E:ELIMINANDO ARCHIVOS TEMPORALES: %s ]]",time.time())
                
                
                
                logging.debug("[[ S:ELIMINANDO RESIDUOS LIPSYNC: %s ]]",time.time())
                log_bitrate=self.removeVideos(video['directory']+"/"+video['fileName']+"-"+ quality[0]+"-lip")
                logging.debug("%s",log_bitrate)
                logging.debug("[[ E:ELIMINANDO RESIDUOS LIPSYNC: %s ]]",time.time())
                
                logging.debug("[[ E:PROCESANDO VIDEO DE LA CALIDAD %s: %s ]]",quality[0],time.time())
                
