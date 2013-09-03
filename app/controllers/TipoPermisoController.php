<?php
class TipoPermisoController extends AutheticatedController {

	public function getIndex()
    {
        //
        $field = Request::get('field',$this->orderBy);
        $order = Request::get('order','desc');
        $plantillas = Tipopermiso::orderBy($field, $order)->paginate($this->pageSize);
        return View::make('modulos.catalogos.tipoPermiso.list')
                   ->with('tipoPermisos', $plantillas)
                   ->with('field', $field)
                   ->with('order', $order);
    }

    public function createViewForm($fields) {
        return View::make('modulos.catalogos.tipoPermiso.form')
                ->with('tipoPermiso', $fields);
    }

    public function getNew()
    {
        return $this->createViewForm(null);
    }

    public function getShow($id)
    {
        return $this->createViewForm(Tipopermiso::find($id));
    }

    public function getDelete($id)
    {
    	Tipopermiso::destroy($id);
        return $this->getIndex();
    }

    public function getActivar($id, $activo) {
    	$plantilla = Tipopermiso::find($id);
    	$plantilla->activa=$activo;
    	$plantilla->save();
    	return $this->getIndex();
    }

    public function postSave() {
    	$input = Input::all();
        $tipoPermiso = new Tipopermiso();
    	if($input['id'] > 0) {
    		$tipoPermiso = Tipopermiso::find($input['id']);
    	}

        $tipoPermiso->fill($input);

        if($tipoPermiso->validate($input)) {
            $tipoPermiso->save();
            return $this->getIndex();
        } else {
            return $this->createViewForm($tipoPermiso)
                    ->with('errors',$tipoPermiso->errors());
        }
    	
    }
}