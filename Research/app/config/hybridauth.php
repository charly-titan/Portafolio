<?php

	return array(	
		"base_url"   => url('social/auth', $parameters = array(), $secure = false),
		"providers"  => array (
			"Google"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"id" => "5608212899-*.apps.googleusercontent.com",
								 "secret" => "*" )
				),
			"Twitter"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"id" => "TLz8DH6IxFhP1UkW2KgTg",
								 "secret" => "*" )
				),
			"Facebook"     => array (
				"enabled"    => true,
				"keys"       => array ( 
								"id" => "122079244481169",
								 "secret" => "*" ),
				"scope"   => "email, user_about_me, user_birthday, user_hometown", // optional

				),

			"Instagram" =>   array ( 
					   "enabled"   => true,
					   "keys"   => array ( 
					   					"id" => "*" ,
					   					"secret" => "*" )
					) 
		),
	);