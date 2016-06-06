#!/usr/bin/env python
# -*- coding: utf-8 -*-
import tweepy
import rethinkdb as r
from service_settings_social_hub import Service_Settings
from datetime import datetime
from boto.s3.key import Key
import operator
import time
import json
from pytz import timezone


serviceTwitter = Service_Settings()

serviceTwitter.conexion_db()
serviceTwitter.create_tables()

############# Tables ###############

profiles = serviceTwitter.table_profiles()
hashtags = serviceTwitter.table_hashtags()
lists = serviceTwitter.table_lists()
tweets_service = serviceTwitter.table_tweets_service()
configured_services_social_hub = serviceTwitter.table_configured_services_social_hub()
instagrams = serviceTwitter.table_instagrams()

def addServiceTable(idService):
	# Agrega servicio
	existService = tweets_service.filter({'id_service':str(idService)}).count().run()

	if existService == 0:
		tweets_service.insert([ { "id_service": str(idService) ,"data":[] }]).run()


def addItem(idService,items):

	print 'Se agrega nuevo item '+items['id_item']
	tweets_service.filter({'id_service':idService}).update({"data": r.row["data"].append(items)}).run()
	


############ Bucket ################

bucket = serviceTwitter.conexion_bucket()


AllServices = configured_services_social_hub.pluck('id','status-service','active_date','inactive_date').run()

for service in AllServices:
	try:
		formatDate = '%d/%m/%Y'
		idService = service['id']
		active_date = int(datetime.strptime(service['active_date'], formatDate).strftime("%s"))
		inactive_date = int(datetime.strptime(service['inactive_date'], formatDate).strftime("%s"))
		status_service = service['status-service']
		now     = datetime.now().strftime(formatDate)
		now_date = int(datetime.strptime(now, formatDate).strftime("%s"))

		if status_service or ( active_date <= now_date and  inactive_date >= now_date):

			#print "#############  ACTIVADO  ###############"
			#print idService,'02/03/2016',active_date,inactive_date,status_service

			type_services = configured_services_social_hub.get(idService).pluck('num_tweets','type_services').run()

			NumTweets = int(type_services['num_tweets'])*2

			# Agrega servicio
			addServiceTable(idService)

			for name_service in type_services['type_services']:

				for name_search_settings in type_services['type_services'][name_service]:

					if name_service == 'profiles':
						InfoProfiles = profiles.filter({'screen_name':name_search_settings.lstrip("@")}).pluck('id','id_user','screen_name','photo','name').run()
						for profile in InfoProfiles:

							dataProfile = profiles.filter({'id':profile['id']}).map(lambda doc: doc['data'].filter({'item_upd':0}).order_by(r.desc("created_at"))).nth(0).run()
				
							if dataProfile:
								for data in dataProfile:

									text = data['text']
									text_encode = text.encode('utf-8')
									
									if text_encode[0] == '@':
										status_tweet = 0
									else:
										status_tweet = 1

									data.update(dict(id_user=profile['id_user']))
									data.update(dict(screen_name=profile['screen_name']))
									data.update(dict(photo=profile['photo']))
									data.update(dict(name=profile['name']))
									data.update(dict(status_tweet=status_tweet))

									addItem(idService,data)
									profiles.get(profile['id']).update({'data': r.row['data'].map(lambda new_item: r.branch( new_item['id_item'].eq(data['id_item']), new_item.merge({'item_upd':1}), new_item))}).run()

					if name_service == 'lists':

						for name_list in type_services['type_services'][name_service][name_search_settings]:
							InfoLists = lists.filter({'screen_name':name_search_settings.lstrip("@")}).filter({'name_list':name_list}).pluck('id','id_user').run()
							for lis in InfoLists:
								dataLists =lists.filter({'id':lis['id']}).map(lambda doc: doc['data'].filter({'item_upd':0}).order_by(r.desc("created_at")).limit(NumTweets)).nth(0).run()
								
								if dataLists:
									for data in dataLists:
										#print 'lista',lis['id'],idService,data['id_item']
										data.update(dict(id_user=lis['id_user']))
										data.update(dict(status_tweet=1))
										
										addItem(idService,data)
										lists.get(lis['id']).update({'data': r.row['data'].map(lambda new_item: r.branch( new_item['id_item'].eq(data['id_item']), new_item.merge({'item_upd':1}), new_item))}).run()


					if name_service == 'hashtags':
						InfoHashtags = hashtags.filter({'hashtag':name_search_settings}).pluck('id').run()
						for hashtag in InfoHashtags:

							dataHashtag = hashtags.filter({'id':hashtag['id']}).map(lambda doc: doc['data'].filter({'item_upd':0}).order_by(r.desc("created_at")).limit(NumTweets)).nth(0).run()
								
							for data in dataHashtag:
								#print 'hashtag',hashtag['id'],idService,data['id_item']
								data.update(dict(status_tweet=1))

								addItem(idService,data)
								hashtags.get(hashtag['id']).update({'data': r.row['data'].map(lambda new_item: r.branch( new_item['id_item'].eq(data['id_item']), new_item.merge({'item_upd':1}), new_item))}).run()
			
					
					if name_service == 'instagrams':

						InfoUsers = instagrams.filter({'screen_name':name_search_settings}).pluck('id','id_user','screen_name','photo','name').run()
						
						for user in InfoUsers:

							dataInstagram =instagrams.filter({'id':user['id']}).map(lambda doc: doc['data'].filter({'item_upd':0}).order_by(r.desc("created_at")).limit(NumTweets)).nth(0).run()
							
							if dataInstagram:
								for data in dataInstagram:
									#print 'instagram',user['id'],idService,data['id_tweet']
									
									try:
										data.update(dict(id_user=user['id_user']))
										data.update(dict(name=user['name']))
										data.update(dict(screen_name=user['screen_name']))
										data.update(dict(status_tweet=1))
										data.update(dict(link=user['link']))
									except Exception, e:
										pass
									
									addItem(idService,data)
									instagrams.get(user['id']).update({'data': r.row['data'].map(lambda new_item: r.branch( new_item['id_item'].eq(data['id_item']), new_item.merge({'item_upd':1}), new_item))}).run()
			# Genera Json
			
			tweetJson = tweets_service.filter({'id_service':idService}).map( lambda doc: 
			    doc["data"].filter({'status_tweet' : 1}).order_by(r.desc("created_at")).limit(int(type_services['num_tweets'])).to_json()
			).run()


			try:
				for json in tweetJson:

					dataTime = datetime.now(timezone('America/Mexico_City')).strftime('%Y-%m-%d %H:%M:%S')		
					configured_services_social_hub.get(idService).update({'last_update': dataTime}).run()

					print 'twitter_services/'+idService+'.json'
					k = Key(bucket)
					k.key = 'twitter_services/'+idService+'.json'
					k.content_type = 'text/html'
					k.set_contents_from_string(json , policy='public-read' )
				

			except Exception, e:
				print e
			
		
	except Exception, e:
		pass
	

