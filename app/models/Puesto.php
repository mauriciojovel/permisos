<?php
class Puesto extends ValidatorEloquent {
	protected $table = 'puesto';
	//protected $guarded = array('id', 'nombre','descripcion','activa');
	protected $fillable = array('id','puesto_id', 'nombre','fecha_inicio','fecha_fin','active');
	protected $rules = array(
		'puesto_id'=>'integer',
		'nombre'=>'required|min:3|max:80',
		'fecha_inicio'=>'required|date',
		'fecha_fin'=>'date',
		'active'=>'required|integer|min:0|max:1',
	);

	public function puestos() {
		return $this->hasMany('Puesto');
	}

	public function superior() {
		return $this->belongsTo('Puesto', 'puesto_id');
	}
}