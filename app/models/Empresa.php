<?php
class Empresa extends ValidatorEloquent {
	protected $table = 'empresa';
	//protected $guarded = array('id', 'nombre','descripcion','activa');
	protected $fillable = array('id', 'nombre','fecha_inicio','active');
	protected $rules = array(
		'nombre'=>'required|min:5|max:80',
		'fecha_inicio'=>'required|date',
		'fecha_fin'=>'date',
		'active'=>'required|integer|min:0|max:1',
	);

	public function proyectos() {
		return $this->hasMany('Proyecto');
	}

	protected function getDateFormat()
    {
        return 'd-m-Y H:i:s';
    }
}