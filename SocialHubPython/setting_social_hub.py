#!/usr/bin/env python
# -*- coding: utf-8 -*-
import sys
import tweepy
import rethinkdb as r
from service_settings_social_hub import Service_Settings
import time
import calendar
from datetime import datetime, timedelta
import boto
import boto.s3.connection
from boto.s3.key import Key
import pytz
from class_generic import Generic # Importo la clase general
import urllib, json

#libs instagram
from instagram.client import InstagramAPI
import httplib2
import simplejson
import six



serviceTwitter = Service_Settings()

serviceTwitter.conexion_db()
serviceTwitter.create_tables()

bucket = serviceTwitter.conexion_bucket()
############# Tables ###############

profiles = serviceTwitter.table_profiles()
hashtags = serviceTwitter.table_hashtags()
lists = serviceTwitter.table_lists()
configured_services_social_hub = serviceTwitter.table_configured_services_social_hub()
tweets_service = serviceTwitter.table_tweets_service()
update_social_hub = serviceTwitter.table_update_social_hub()
instagrams = serviceTwitter.table_instagrams()
configured_services_social_hub_versus = serviceTwitter.table_configured_services_social_hub_versus()

client_id 		= serviceTwitter.client_id
client_secret 	= serviceTwitter.client_secret


generic = Generic()
name_list_profile = generic.config["list_profile"]


gmt = pytz.timezone('GMT')	
tz = pytz.timezone('US/Central')


def authTwitter(num = 0):
	auth = serviceTwitter.auth_twitter(num)
	api = tweepy.API(auth)
	return api

def find_register_option(type_service,name):
	
	if type_service == 'profile':
		count_register = profiles.filter({"screen_name": name}).count().run()
	elif type_service == 'hashtag':
		count_register = hashtags.filter({"hashtag": name}).count().run()
	
	return count_register


def info_type_service(service_name,name_search,type_info):

	if service_name == 'profile':
		
		table = profiles
		name_index = 'screen_name'
		
	elif service_name == 'hashtag':
		
		table = hashtags
		name_index = 'hashtag'

	elif service_name == 'list':
		table = lists
		name_index = 'name_list'


	data_info = table.get_all( name_search, index = name_index ).map(lambda info:
		    { "id": info["id"] }
	).get_field('id').coerce_to('array').run()

	

	last_id_tweet = table.get(data_info[0]).get_field('data').order_by(r.desc('id_item')).get_field('id_item').limit(1).run()

	if type_info == 'id':
		return data_info[0]
	elif type_info == 'last_id_tweet':
		return last_id_tweet[0]


'''def utc_to_local(utc_dt):

	gmt_date = gmt.localize(utc_dt)
	fmt_center = gmt_date.astimezone(tz)

	return fmt_center.strftime("%Y-%m-%d %H:%M:%S")'''

def utc_to_local(utc_dt):

	gmt_date = gmt.localize(utc_dt)
	fmt_center = gmt_date.astimezone(tz)
	dtc = fmt_center.strftime("%Y-%m-%d %H:%M:%S")
	dt = datetime.strptime(dtc, "%Y-%m-%d %H:%M:%S")
	return time.mktime(dt.timetuple()) + (dt.microsecond / 1000000.0)


def services_settings(type_list):
	
	my_list = []
	my_lists = []
	
	list_settings = configured_services_social_hub.filter({'status-service':1}).get_field('type_services').get_field(type_list).distinct().run()

	if type_list == 'profiles':

		for list_profile in list_settings:
		    for name_profile in list_profile:
		    	edit_name_profile = name_profile.lstrip("@")
		    	if edit_name_profile not in my_list:
		        	my_list.append(edit_name_profile)

		for lists_profiles in my_list:
			try:
				tweets_profile(lists_profiles)
			except Exception, e:
				print e.message, 'error profiles', lists_profiles
	
	if type_list == 'hashtags':

		for list_hashtag in list_settings:
			for name_hashtag in list_hashtag:
				if name_hashtag not in my_list:
					my_list.append(name_hashtag)

		for lists_hashtags in my_list:
			try:
				tweets_hashtag(lists_hashtags)
			except Exception, e:
				print e.message, 'error hashtags'


	if  type_list == 'lists':

		for (i, item) in enumerate(list_settings):
			for (idx, name_profile) in enumerate(item):
				for list in item[name_profile]:
					if list not in my_list:
						my_list.append(list)
						my_lists.append([name_profile,list])

		for name_list in my_lists:
			profile = name_list[0]
			list = name_list[1]
			
			try:
				tweets_lists(profile,list)
			except Exception, e:
				print e.message, 'error lists'


##########  PROFILES  ###########
#################################

def tweets_profile(screen_name):
	num = 0
	while True:		
		try:
			api = authTwitter(num)
			user = api.get_user(screen_name)
			
			tweets = []
			edit_tweet = dict()
			service_name = 'profile'
			media_url = []
			

			if find_register_option('profile',user.screen_name):#existe usuario en tabla(update)
				try:
					tweet_timeline = api.user_timeline( screen_name = user.screen_name , since_id = info_type_service(service_name,user.screen_name,'last_id_tweet'),include_rts=False  ) 
				except Exception, e:
					print e.message
			else:#no existe usuario (Insert)
				tweet_timeline = api.user_timeline( screen_name = user.screen_name,include_rts=False )


			for tweet in tweet_timeline:

				try:
					for media in tweet.extended_entities['media']:
						media_url.append(media['media_url'])
				except Exception, e:
					pass

				
				if len(media_url) >= 1:
					edit_tweet.update({'media_url':media_url})

				edit_tweet.update({'id_item': str(tweet.id), 'text':tweet.text,'created_at':int(utc_to_local(tweet.created_at)),'item_upd':0})
				tweets.append(dict(edit_tweet))

				media_url = []
				edit_tweet = dict()
				

			if find_register_option('profile',user.screen_name):

				if len(tweets) :
					
					for new_tweet in tweets:
						profiles.get(info_type_service('profile',tweet.author.screen_name,'id')).update(lambda post: { "data" :post['data'].append( new_tweet ) }).run()																																	
					
					print "Se agregaron nuevos tweets del usuario", user.screen_name
				else:
					print "No hay tweets nuevos de usuario", user.screen_name
			else:
				
				name = user.name
				name_profile_encode = name.encode('utf-8')
				
				try:

					profiles.insert([
							{ "id_user": str(user.id), "screen_name": str(user.screen_name),'name':unicode(name_profile_encode, "utf-8"), "photo" : str(user.profile_image_url_https),
							    'data': tweets },
					]).run()


					print "Se agrego nuevo usuario",user.screen_name

				except Exception, e:
					print e.message
						
			break
		except tweepy.TweepError, e:
			if e.message.find("Rate limit") != -1 :
				if num <=4:
					num = num+1
				else:
					num = 0
				continue




########################### Agrega la lista si no existe y agrega los nuevos perfiles a la lista ##################################

def add_lists_profiles(screen_name_list):

	num = 0
	name_list_profile = 'Profiles'

	while True:		
		try:
			api = authTwitter(num)
			user = api.get_user(screen_name_list)
			
			##### verifica que este la lista donde se agregaran los perfiles si no lo crea 

			lists_names = api.lists_all(screen_name= screen_name_list)
			
			for list_name in lists_names:
				if list_name.name != name_list_profile:
					api.create_list(name=name_list_profile,description='Lists Profiles')

			
			#### lista los perfiles de la lista si existe si no agrega los nuevos
			try:

				list_all_profiles = configured_services_social_hub.filter({'status-service':1}).get_field('type_services').get_field('profiles').distinct().run()
				
				listProfiles = []
				
				for list_member in tweepy.Cursor(api.list_members, screen_name_list, name_list_profile).items():
					listProfiles.append("@"+list_member.screen_name)

				for list_profile in list_all_profiles:
					for name_profile in list_profile:
						
						try:
							existProfile = profiles.filter(lambda user: user["screen_name"].eq( str(name_profile.lstrip("@")) )).count().run()

							if not existProfile:
								tweets_profile(name_profile.lstrip("@"))
							
							if name_profile in listProfiles:
								pass
							else:
								api.add_list_member(screen_name=name_profile, slug=name_list_profile, owner_screen_name=screen_name_list)
						
						except Exception, e:
							print "error ",name_profile, e
							


			except Exception, e:
				print e.message			
			
			break

		except tweepy.TweepError, e:
			if e.message.find("Rate limit") != -1 :
				if num <=4:
					num = num+1
				else:
					num = 0
				continue



###########################  Agrega nuevos tweets a profiles #################################

def add_tweets_profiles(screen_name):

	num = 0
	name_list = 'Profiles'

	while True:	
		try:
			api = authTwitter(num)
			user = api.get_user(screen_name)
			tweets = []
			media_url = []
			
			try:
				tweet_timeline = api.user_timeline( screen_name = user.screen_name,include_rts=False )

				for tweet in tweet_timeline:

					try:
						
						existTweet = profiles.filter({'screen_name':tweet.author.screen_name}).map(lambda doc : doc['data']['id_item']).filter(lambda doc :doc.contains( str(tweet.id)) ).count().run()

						if not existTweet:

							try:
								for media in tweet.extended_entities['media']:
									media_url.append(media['media_url'])
							except Exception, e:
								pass

							try:

								data_item = {'created_at': int(utc_to_local(tweet.created_at)), 'id_item': str(tweet.id),'text':tweet.text,'item_upd':0}

								if len(media_url) >= 1:
									data_item.update({'media_url':media_url})
	
								profiles.get(info_type_service('profile',tweet.author.screen_name,'id')).update(lambda post: { "data" :post['data'].append( data_item ) }).run()	

								media_url = []
								print "Se agrega nuevo tweet del usuario", tweet.author.screen_name
							except Exception, e:
								print "error",e

					except Exception, e:
						tweets_profile(tweet.author.screen_name)
					
			except Exception, e:
				print e.message,"error"
			
			break
		except tweepy.TweepError, e:
			if e.message.find("Rate limit") != -1 :
				if num <=4:
					num = num+1
				else:
					num = 0
				continue

##########  HASHTAGS  ###########
#################################

def tweets_hashtag(name_hashtag):
	num = 4
	while True:	
		try:
			api = authTwitter(num)

			tweets = []
			edit_tweet = dict()
			service_name = 'hashtag'
			items = 10
			media_url = []

			if find_register_option('hashtag',name_hashtag):#existe usuario en tabla(update)
				tweet_timeline = tweepy.Cursor(api.search, q = name_hashtag, since_id = info_type_service(service_name,name_hashtag,'last_id_tweet') ,result_type='recent',include_rts=False ).items(items)
			else:#no existe usuario (Insert)
				tweet_timeline = tweepy.Cursor(api.search, q = name_hashtag ,result_type='recent',include_rts=False ).items(items)

		
			for tweet in tweet_timeline:
				
				try:
					for media in tweet.entities['media']:
						media_url.append(media['media_url'])
				except Exception, e:
					pass

				if len(media_url) >= 1:
					edit_tweet.update({'media_url':media_url})

				edit_tweet.update({'id_item': str(tweet.id), 'text':tweet.text,'created_at':int(utc_to_local(tweet.created_at)),'item_upd':0})
				tweets.append(dict(edit_tweet))

				media_url = []
				edit_tweet = dict()
				

			if find_register_option('hashtag',name_hashtag):
				
				if len(tweets):

					for new_tweet in tweets:
						hashtags.get( info_type_service(service_name,name_hashtag,'id') ).update(lambda post: { "data" :post['data'].append( new_tweet ) }).run()	
					
					print "Se agregaron nuevos tweets en hashtag", name_hashtag
				else:
					print "No hay tweets nuevos en hashtag", name_hashtag																																

			else:

				hashtags.insert([
							{ "data": tweets,"hashtag":name_hashtag},
				]).run()

				print "Se agrego nuevo hashtag ",name_hashtag

			break
		except tweepy.TweepError, e:
			if e.message.find("Rate limit") != -1 :
				if num <=4:
					num = num+1
				else:
					num = 0
				continue



##########  LISTS  ###########
################################


def tweets_lists(screen_name,name_list):

	num = 0
	while True:	
		try:
			api = authTwitter(num)
			user = api.get_user(screen_name)

			tweets = []
			edit_tweet = dict()
			service_name = 'list'
			media_url = []

			if find_perfil_lists(user.screen_name,name_list):#existe usuario en tabla(update)
				tweet_timeline = api.list_timeline( user.screen_name, name_list, since_id = info_type_service(service_name,name_list,'last_id_tweet'),include_rts=False)
			else:#no existe usuario (Insert)
				tweet_timeline = api.list_timeline( user.screen_name, name_list,include_rts=False )


			for tweet in tweet_timeline:

				try:
					for media in tweet.entities['media']:
						media_url.append(media['media_url'])
				except Exception, e:
					pass

				if len(media_url) >= 1:
					edit_tweet.update({'media_url':media_url})

				edit_tweet.update({'id_item':str(tweet.id), 'screen_name':tweet.author.screen_name,'name':tweet.author.name,'text': tweet.text, 'photo':tweet.author.profile_image_url,'created_at':int(utc_to_local(tweet.created_at)),'item_upd':0})
				tweets.append(dict(edit_tweet))

				media_url = []
				edit_tweet = dict()
			
			if find_perfil_lists(user.screen_name,name_list) :

				if len(tweets):

					for new_tweet in tweets:
						lists.get( info_type_service(service_name,name_list,'id') ).update(lambda post: { "data" :post['data'].append( new_tweet ) }).run()
					
					print "Se agregaron nuevos tweets de lista", user.screen_name, name_list

				else:
					print "No hay tweets nuevos de lista ", user.screen_name, name_list
			else:

				lists.insert([
			    	{ "id_user": str(user.id) ,"data": tweets,"name_list":name_list,"screen_name":user.screen_name,'name':user.name },
				]).run()

				print "Se agrego nuevo usuario en lista",user.screen_name,name_list
			break
		except tweepy.TweepError, e:
			if e.message.find("Rate limit") != -1 :
				if num <=4:
					num = num+1
				else:
					num = 0
				continue

def find_perfil_lists(screen_name,name_list):

	count_user = lists.filter({"screen_name": screen_name,'name_list':name_list}).count().run()
	return count_user

def remove_duplicate_profiles():
	
	id_only = profiles.pluck('id','screen_name').group('screen_name').pluck('id').distinct().limit(1).run()
	all_ids = profiles.get_field('id').distinct().run()

	idUnicos = []

	for y in id_only:
		idUnicos.append(id_only[y][0]['id'])

	for id_remove in all_ids:
		if id_remove not in idUnicos:
			print id_remove
			profiles.get(id_remove).delete().run()

def update_config_social():

	try:
		idUpdateProfile = update_social_hub.get_field('id').limit(1).run()
		idUpdate = list(idUpdateProfile)

		data_list = update_social_hub.get(idUpdate[0]).run()

		for name_service in data_list:
			try:
				
				idUpdate =  data_list['id']

				for user_name in data_list[name_service]:
					if name_service != 'id':
						#print name_service,user_name
						status_upd = update_social_hub.filter({'id':idUpdate}).map(lambda d: {"status_upd" : d[name_service][user_name]['status_upd']}).run()

						for status in status_upd:
							if status['status_upd'] == 1:
							
								if name_service == 'profiles':
								
									tweets_profile(user_name)
							
								if name_service == 'instagrams':
								
									instagrams.filter({"screen_name":user_name}).update({"status_upd":1}).run()
									services_instagram()

								update_social_hub.get( idUpdate ).update({name_service: { user_name: r.literal({"status_upd": 0})}}).run()
					
			except Exception, e:
				e.message
		
	except Exception, e:
		pass

def services_instagram():

	users = instagrams.run()

	data = {}
	data_instagram = []

	for user in users:

		access_token = user['token']

		api = InstagramAPI(access_token=access_token,client_secret=client_secret)

		user_id = user['id_user']  

		recent_media, next_ = api.user_recent_media(user_id=user_id)

		for media in recent_media:
			try:
				try:
					text = media.caption.text
				except Exception, e:
					text = ''
				
				data.update({ 'text': text})
				data.update({ 'id_item': media.id })
				data.update({ 'created_at': int(utc_to_local(media.created_time)) })
				data.update({ 'item_upd': 0 })
				data.update({ 'photo_low':media.images['low_resolution'].url })
				data.update({ 'thumbnail':media.images['thumbnail'].url })
				data.update({ 'photo':media.images['standard_resolution'].url })
				data.update({ 'link':media.link })
				data_instagram.append(dict(data))
				
				existTweet = instagrams.filter({'id':user['id']}).map(lambda doc : doc['data']['id_item']).filter(lambda doc :doc.contains( str(media.id)) ).count().run()

				if not existTweet:
					instagrams.filter({'id':user['id']}).update({"data": r.row["data"].append(data)}).run()

			except Exception, e:
				e.message

		instagrams.filter({'id':user['id']}).update({"status_upd":0}).run()

def services_twitter_versus():

	from firebase import firebase

	firebase = firebase.FirebaseApplication('https://versus-twitter.firebaseio.com/', None)

	try:

		idConfiguredService = configured_services_social_hub_versus.filter({'status':1}).run();

		data = {}
		data_hashtags = []

		for service in idConfiguredService:

			try:
				list_hastags = configured_services_social_hub.get(service['id_service']).get_field('type_services').get_field('hashtags').distinct().run()

				for name_hashtag in list_hastags:

					count_tweets = hashtags.filter({'hashtag':name_hashtag}).map(lambda doc : doc['data'].count()).run()
				
					for count in count_tweets:
						data.update({'hashtag': name_hashtag})
						data.update({'data': count})
						data_hashtags.append(dict(data))

			except Exception, e:
				pass
				#print e.message	

			idService = service['id_service']

			register = firebase.get(idService,None)

			if register != None:
				firebase.delete(idService, None)
				result = firebase.post(idService, data_hashtags)
			else:
				#print "no existe"
				result = firebase.post(idService, data_hashtags)

	except Exception, e:
		print e.message


services_twitter_versus()
update_config_social()
#remove_duplicate_profiles()
#services_settings('profiles')
add_lists_profiles(name_list_profile)
add_tweets_profiles(name_list_profile)
services_settings('hashtags')
services_settings('lists')
services_instagram()
