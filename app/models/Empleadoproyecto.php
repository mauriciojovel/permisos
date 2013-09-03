<?php
class Empleadoproyecto extends ValidatorEloquent {
	protected $table = 'empleado_proyecto';
	//protected $guarded = array('id', 'nombre','descripcion','activa');
	//protected $fillable = array('id', 'nombre','descripcion','activa');
	protected $rules = array(
		'usuario_id'=>'required|integer',
		'proyecto_id'=>'required|integer',
	);

	public function usuario() {
		return $this->belongsTo('Usuario');
	}

	public function proyecto() {
		return $this->belongsTo('Proyecto');
	}
}