<?php

		return array(	
		"base_url"   => url('instagram/auth', $parameters = array(), $secure = false),
		"providers"  => array (
			"Google"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"id" => "5608212899-*.apps.googleusercontent.com",
								 "secret" => "*-2Rr7pnUOz78WM6" )
				),
			"Facebook"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"id" => "*",
								 "secret" => "*" ),
				"scope"   => "offline_access,read_stream, publish_stream,publish_pages", // optional

				),

			"Instagram" =>   array ( 
					   "enabled"   => true,
					   "keys"   => array ( 
					   					"id" => "*" ,
					   					"secret" => "*" )
					) 

		),
	);