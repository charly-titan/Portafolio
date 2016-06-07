<?php 


class Contest extends Eloquent { 

   protected $table='contest';
   protected $primaryKey='id_contest';
   protected $connection = 'mysql2';


   public function groups(){

    	return $this -> belongsTo('groups');
   }

   
    
}



 


?>