<?php
class ProyectoController extends AutheticatedController {

	public function getIndex()
    {
        //
        $field = Request::get('field',$this->orderBy);
        $order = Request::get('order','desc');
        $proyectos = Proyecto::orderBy($field, $order)->paginate($this->pageSize);
        return View::make('modulos.catalogos.proyecto.list')
                   ->with('proyectos', $proyectos)
                   ->with('field', $field)
                   ->with('order', $order);
    }

    public function createViewForm($fields) {
        $empresas = Empresa::orderBy('nombre','asc')->lists('nombre','id');
        $empresas = array(''=>'')+$empresas;
        return View::make('modulos.catalogos.proyecto.form')
                ->with('proyecto', $fields)
                ->with('empresas',$empresas);
    }

    public function getNew()
    {
        return $this->createViewForm(null);
    }

    public function getShow($id)
    {
        return $this->createViewForm(Proyecto::find($id));
    }

    public function getDelete($id)
    {
    	Proyecto::destroy($id);
        return $this->getIndex();
    }

    public function getActivar($id, $activo) {
    	$proyecto = Proyecto::find($id);
    	$proyecto->activa=$activo;
    	$proyecto->save();
    	return $this->getIndex();
    }

    public function postSave() {
    	$input = Input::all();
        $proyecto = new Proyecto();
    	if($input['id'] > 0) {
    		$proyecto = Proyecto::find($input['id']);
    	}

        $proyecto->fill($input);

        if($proyecto->validate($input)) {
            $proyecto->save();
            return $this->getIndex();
        } else {
            return $this->createViewForm($proyecto)
                    ->with('errors',$proyecto->errors());
        }
    	
    }
}