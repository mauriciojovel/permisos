<?php
class Reposicion extends ValidatorEloquent {
	protected $table = 'reposicion';
	//protected $guarded = array('id', 'nombre','descripcion','activa');
	protected $fillable = array('id', 'permiso_id','fecha','hora_inicio','hora_fin');
	protected $rules = array(
		'permiso_id'=>'required|integer',
		'fecha'=>'required|date',
		'hora_inicio'=>'required|date_format:H:i',
		'hora_fin'=>'required|date_format:H:i'
	);

	/*public function getDates() {
	    return array('fecha','hora_inicio','hora_fin');
	}*/

	public function permiso() {
		return $this->belongsTo('Permiso');
	}

	public function getHoraInicioHoraAttribute($value) {
		$pieces = explode(":", $this->hora_inicio);
		return $pieces[0];
	}

	public function getHoraInicioMinutoAttribute($value) {
		$pieces = explode(":", $this->hora_inicio);
		return $pieces[1];
	}

	public function getHoraFinHoraAttribute($value) {
		$pieces = explode(":", $this->hora_fin);
		return $pieces[0];
	}

	public function getHoraFinMinutoAttribute($value) {
		$pieces = explode(":", $this->hora_fin);
		return $pieces[1];
	}
}