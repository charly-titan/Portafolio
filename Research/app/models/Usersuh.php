<?php

class Usersuh extends Eloquent{
    protected $table = 'users_uh';
    protected $fillable = array('user_id', 'sites');

    public function touser()
	{
		return $this->hasOne('\User', 'id', 'user_id');

	}

}
