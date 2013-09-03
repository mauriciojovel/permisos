<?php
class Empleadopuesto extends ValidatorEloquent {
	protected $table = 'empleado_puesto';
	//protected $guarded = array('id', 'nombre','descripcion','activa');
	protected $fillable = array('id', 'usuario_id','puesto_id');
	protected $rules = array(
		'usuario_id'=>'required|integer',
		'puesto_id'=>'required|integer',
	);

	public function usuario() {
		return $this->belongsTo('Usuario');
	}

	public function puesto() {
		return $this->belongsTo('Puesto');
	}
}