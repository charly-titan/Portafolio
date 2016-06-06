<?php

class ProgramUrl extends Eloquent {

    protected $table = 'programs_url';
    protected $primaryKey = 'id_url';
    public $timestamps = false;
    
       public function temas(){
        return $this->hasMany('channels', 'id');
    }

}
?>


