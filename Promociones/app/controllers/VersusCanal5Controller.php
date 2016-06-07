<?php

class VersusCanal5Controller extends VersusController {


	public function getIndex($short_name="")
	{
		Session::put('user.contest', 'versus-canal-5'); 

		return View::make(Config::get( 'app.main_template' ).'.test.versus2')->with(array('questionAll'=>$this->questionAll(1)));

	}

	public function getMovieSelected($option){
		Session::put('user.contest', 'versus-canal-5'); 
		Session::put('user.versus', $option); 
		return View::make(Config::get( 'app.main_template' ).'.test.versus2')->with(array("promo_info"=>"0",'movieSelected'=>$option,'questionAll'=>$this->questionAll(1)));
	}

	

}	