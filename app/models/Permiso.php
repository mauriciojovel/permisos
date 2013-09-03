<?php
class Permiso extends ValidatorEloquent {
	protected $table = 'permiso';
	//protected $guarded = array('id', 'nombre','descripcion','activa');
	protected $fillable = array('id', 'usuario_id','proyecto_id','tipo_permiso_id','detalle','fecha');
	protected $rules = array(
		'usuario_id'=>'required|integer',
		'proyecto_id'=>'required|integer',
		'tipo_permiso_id'=>'required|integer',
		'detalle'=>'required|min:5|max:500',
		'fecha'=>'required'
	);

	public function usuario() {
		return $this->belongsTo('Usuario');
	}

	public function proyecto() {
		return $this->belongsTo('Proyecto');
	}

	public function tipoPermiso() {
		return $this->belongsTo('Tipopermiso');
	}
}