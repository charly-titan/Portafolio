<?php

	return array(	
		"base_url"   => url('social/auth', $parameters = array(), $secure = false),
		"providers"  => array (
			"Google"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"id" => "*-*.apps.googleusercontent.com",
								 "secret" => "*" )
				),
			"Twitter"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"key" => "*",
								 "secret" => "*" )
				),
			"Facebook"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"id" => "*",
								 "secret" => "**" ),
				"scope"   => "email, user_about_me, user_birthday, user_hometown", // optional

				)
		),
	);