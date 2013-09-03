<?php
class PuestoController extends AutheticatedController {

	public function getIndex()
    {
        //
        $field = Request::get('field',$this->orderBy);
        $order = Request::get('order','desc');
        $puestos = Puesto::orderBy($field, $order)->paginate($this->pageSize);
        return View::make('modulos.catalogos.puesto.list')
                   ->with('puestos', $puestos)
                   ->with('field', $field)
                   ->with('order', $order);
    }

    public function createViewForm($fields) {
        $puestos = Puesto::orderBy('nombre','asc')->lists('nombre','id');
        $puestos = array(''=>'')+$puestos;
        return View::make('modulos.catalogos.puesto.form')
                ->with('puesto', $fields)
                ->with('puestos',$puestos);
    }

    public function getNew()
    {
        return $this->createViewForm(null);
    }

    public function getShow($id)
    {
        return $this->createViewForm(Puesto::find($id));
    }

    public function getDelete($id)
    {
    	Puesto::destroy($id);
        return $this->getIndex();
    }

    public function getActivar($id, $activo) {
    	$puesto = Puesto::find($id);
    	$puesto->activa=$activo;
    	$puesto->save();
    	return $this->getIndex();
    }

    public function postSave() {
    	$input = Input::all();
        $puesto = new Puesto();
    	if($input['id'] > 0) {
    		$puesto = Puesto::find($input['id']);
    	}

        $puesto->fill($input);

        if($puesto->validate($input)) {
            if($puesto->puesto_id === '') {
                $puesto->puesto_id = null;
            }
            $puesto->save();
            return $this->getIndex();
        } else {
            return $this->createViewForm($puesto)
                    ->with('errors',$puesto->errors());
        }
    	
    }
}