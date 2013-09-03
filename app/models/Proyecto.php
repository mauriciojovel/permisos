<?php
class Proyecto extends ValidatorEloquent {
	protected $table = 'proyecto';
	//protected $guarded = array('id', 'nombre','descripcion','activa');
	protected $fillable = array('id','empresa_id', 'nombre','fecha_inicio','fecha_fin','active');
	protected $rules = array(
		'empresa_id'=>'required|integer',
		'nombre'=>'required|min:5|max:80',
		'fecha_inicio'=>'required|date',
		'fecha_fin'=>'date',
		'active'=>'required|integer|min:0|max:1',
	);

	public function empleados() {
		return $this->hasMany('Empleadoproyecto');
	}

	public function permisos() {
		return $this->hasMany('Permiso');
	}

	public function empresa() {
		return $this->belongsTo('Empresa');
	}
}