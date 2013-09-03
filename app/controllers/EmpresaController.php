<?php
class EmpresaController extends AutheticatedController {

	public function getIndex()
    {
        //
        $field = Request::get('field',$this->orderBy);
        $order = Request::get('order','desc');
        $empresas = Empresa::orderBy($field, $order)->paginate($this->pageSize);
        return View::make('modulos.catalogos.empresa.list')
                   ->with('empresas', $empresas)
                   ->with('field', $field)
                   ->with('order', $order);
    }

    public function createViewForm($fields) {
        return View::make('modulos.catalogos.empresa.form')
                ->with('empresa', $fields);
    }

    public function getNew()
    {
        return $this->createViewForm(null);
    }

    public function getShow($id)
    {
        return $this->createViewForm(Empresa::find($id));
    }

    public function getDelete($id)
    {
    	Empresa::destroy($id);
        return $this->getIndex();
    }

    public function getActivar($id, $activo) {
    	$plantilla = Empresa::find($id);
    	$plantilla->activa=$activo;
    	$plantilla->save();
    	return $this->getIndex();
    }

    public function postSave() {
    	$input = Input::all();
        $empresa = new Empresa();
    	if($input['id'] > 0) {
    		$empresa = Empresa::find($input['id']);
    	}

        $empresa->fill($input);

        if($empresa->validate($input)) {
            $empresa->save();
            return $this->getIndex();
        } else {
            return $this->createViewForm($empresa)
                    ->with('errors',$empresa->errors());
        }
    	
    }
}