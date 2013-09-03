<?php
class TipoPermiso extends ValidatorEloquent {
	protected $table = 'tipo_permiso';
	//protected $guarded = array('id', 'nombre','descripcion','activa');
	protected $fillable = array('id', 'nombre','uso_administrativo','active');
	protected $rules = array(
		'nombre'=>'required|min:5|max:60',
		'uso_administrativo'=>'required|integer|min:0|max:1',
		'active'=>'required|integer|min:0|max:1',
	);

	public function permisos() {
		return $this->hasMany('Permiso');
	}
}