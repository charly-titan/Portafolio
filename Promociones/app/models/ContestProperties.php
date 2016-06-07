<?php 

class ContestProperties extends Eloquent { 

   protected $table='contest_properties';
   protected $connection = 'mysql2';

   public function groups(){

    	return $this -> belongsTo('groups');
   }


}


?>
