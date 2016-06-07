<?php 


class Sites extends Eloquent { 

	protected $table='sites';

    protected $primaryKey='id_site';



    public function groups(){

    	return $this -> belongsTo('groups');
    }
    
}



 


?>