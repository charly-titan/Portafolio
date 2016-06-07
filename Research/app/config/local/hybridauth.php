<?php

		return array(	
		"base_url"   => url('social/auth', $parameters = array(), $secure = false),
		"providers"  => array (
			"Google"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"id" => "*********-***************.apps.googleusercontent.com",
								 "secret" => "************-************" )
				),
			"Facebook"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"id" => "***********",
								 "secret" => "*****************" ),
				"scope"   => "offline_access,read_stream, publish_stream,publish_pages", // optional

				),

			"Instagram" =>   array ( 
					   "enabled"   => true,
					   "keys"   => array ( 
					   					"id" => "***************" ,
					   					"secret" => "*************" )
					) 

		),
	);