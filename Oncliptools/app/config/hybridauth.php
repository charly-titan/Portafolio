<?php

	return array(	
		"base_url"   => url('social/auth', $parameters = array(), $secure = false),
		"providers"  => array (
			"Google"     => array (
				"enabled"    => true,
				"keys"       => array ( "id" => "**************", "secret" => "**************" )
				)
		),
	);