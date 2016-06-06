import tweepy
import rethinkdb as r
from class_generic import Generic # Importo la clase general
import boto
import boto.s3.connection



class Service_Settings:
	
	def __init__(self):
		#Inicializo la clase y la asigno a una variable
		self.generic = Generic()
		self.db = r.db(self.generic.config["name_db"])
		self.name_table_profiles = self.generic.config["table_profiles"]
		self.name_table_hashtags = self.generic.config["table_hashtags"]
		self.name_table_lists = self.generic.config["table_lists"]
		self.name_table_configured_services_social_hub = self.generic.config["table_configured_services_social_hub"]
		self.name_table_tweets_service = self.generic.config["table_tweets_service"]
		self.name_table_update_social_hub = self.generic.config["table_update_social_hub"]
		self.name_table_instagrams = self.generic.config["table_instagrams"]
		self.name_table_configured_services_social_hub_versus = self.generic.config["table_configured_services_social_hub_versus"]
		

		self.index_tables = [
								{self.name_table_profiles : ["screen_name","tweets"]},
								{self.name_table_hashtags : ["hashtag","tweets"]},
								{self.name_table_lists : ["name_list","tweets","screen_name"]},
								{self.name_table_configured_services_social_hub : ["status-service"]},
								{self.name_table_tweets_service: ["id_service"]},
								{self.name_table_instagrams : ["screen_name","tweets"]},
							]


		self.aws_access_key_id = self.generic.config["aws_access_key_id"]
		self.aws_secret_access_key = self.generic.config["aws_secret_access_key"]
		self.bucketname = self.generic.config["bucketname"]

		self.client_id 	= self.generic.config['client_id']
		self.client_secret	= self.generic.config['client_secret']



	def conexion_db(self):
		#conexion a rethinkdb
		r.connect(self.generic.config["server_db_ip"], self.generic.config["server_db_port"]).repl()

	#API Twitter
	def auth_twitter(self,num):

		auth = tweepy.OAuthHandler(self.generic.config['consumer_key_'+str(num)], self.generic.config['consumer_secret_'+str(num)])
		auth.set_access_token(self.generic.config['access_token_'+str(num)], self.generic.config['access_token_secret_'+str(num)])
		return auth

	def add_secondary_index(table,name_index):

		index_exist = table.index_list().contains(name_index).run()

		if index_exist is False:
			table.index_create(name_index).run()
		
	def create_tables(self):

		exist_db = r.db_list().contains(self.generic.config['name_db']).run()

		if exist_db == 0:
			r.db_create(self.generic.config['name_db']).run()

		tables = [self.name_table_profiles,self.name_table_hashtags,self.name_table_lists,self.name_table_tweets_service,self.name_table_configured_services_social_hub,self.name_table_instagrams]

		for name_table in tables:
			exist_table = self.db.table_list().contains(name_table).run()

			if exist_table is False :
				self.db.table_create(name_table).run()

		try:
			for index_name in self.index_tables:
				for table_name in index_name:
					for index in index_name[table_name]:
						index_exist = self.db.table(table_name).index_list().contains(index).run()

						if index_exist is False:
							self.db.table(table_name).index_create(index).run()
		except Exception, e:
			print e

	

	def table_profiles(self):
		return self.db.table(self.name_table_profiles)

	def table_hashtags(self):
		return self.db.table(self.name_table_hashtags)

	def table_lists(self):
		return self.db.table(self.name_table_lists)

	def table_tweets_service(self):
		return self.db.table(self.name_table_tweets_service)

	def table_configured_services_social_hub(self):
		return self.db.table(self.name_table_configured_services_social_hub)

	def table_update_social_hub(self):
		return self.db.table(self.name_table_update_social_hub)

	def table_instagrams(self):
		return self.db.table(self.name_table_instagrams)

	def table_configured_services_social_hub_versus(self):
		return self.db.table(self.name_table_configured_services_social_hub_versus)


	def conexion_bucket(self):

		conn = boto.s3.connect_to_region('us-east-1',
		       aws_access_key_id = self.aws_access_key_id,
		       aws_secret_access_key = self.aws_secret_access_key,
		       is_secure=True               # uncommmnt if you are not using ssl
		       )
		bucket = conn.get_bucket(self.bucketname)

		return bucket

	def client_id(self):
		return self.client_id

	def client_secret(self):
		return self.client_secret