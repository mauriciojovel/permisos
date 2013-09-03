<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends ValidatorEloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usuario';

	protected $fillable = array('id','name','active','admin');

	protected $rules = array(
		'name'=>'required|min:5|max:60',
		'active'=>'required|integer|min:0|max:1',
		'admin'=>'required|integer|min:0|max:1'
	);

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function empleadoProyecto() {
		return $this->hasMany('Empleadoproyecto','usuario_id');
	}

	public function empleadoPuesto() {
		return $this->hasMany('Empleadopuesto', 'usuario_id');
	}

}