 INSTALL package

 ================================================


- sys
- tweepy
- rethinkdb
- boto
- import pytz
- urllib
- json

== Instagram 

	1. Install Python setuptools

		apt-get install python-setuptools

	2. Now using pip install

		- InstagramAPI
			pip install python-instagram
		- httplib2
			pip install simplejson or easy_install simplejson
		- simplejson
			pip install simplejson
		- six
			pip install six


== Firebase

	-Firebase
		sudo pip install python-firebase


== Error Instagram 
	
	- line 99, for comment in entry['comments']['data']: KeyError: 'data'

		Se soluciona agregando una linea antes del for comment in entry['comments']['data']:

		La linea a agregar es la siguiente: if 'data' in entry['comments']:
