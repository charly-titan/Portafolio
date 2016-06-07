<?php 

class Groups extends Eloquent { 

   protected $table='groups';

   public function sites(){

    	 //return $this->hasmany('Sites');
    	 return $this->belongsToMany('Sites');
    }

   
}


    

?>



