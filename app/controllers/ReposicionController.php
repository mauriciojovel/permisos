<?php
class ReposicionController extends AutheticatedController {

    public function getIndex() {
        return Redirect::to('permiso');
    }

	public function getReposhow($id) {
        //
        $field = Request::get('field','usuario'.$this->orderBy);
        $order = Request::get('order','desc');
        $reposiciones = Reposicion::where('permiso_id','=',$id)->paginate($this->pageSize);
        $permiso = Permiso::find($id);

        return View::make('modulos.empleados.reposicion.list')
                   ->with('reposiciones', $reposiciones)
                   ->with('permiso', $permiso)
                   ->with('field', $field)
                   ->with('order', $order);
    }

    public function createViewForm($reposicion,$id) {
        $permiso = Permiso::find($id);
        $horas = array(
             '' => ''
            ,'1'=>'01'
            ,'2'=>'02'
            ,'3'=>'03'
            ,'4'=>'04'
            ,'5'=>'05'
            ,'6'=>'06'
            ,'7'=>'07'
            ,'8'=>'08'
            ,'9'=>'09'
            ,'10'=>'10'
            ,'11'=>'11'
            ,'12'=>'12'
            ,'13'=>'13'
            ,'14'=>'14'
            ,'15'=>'15'
            ,'16'=>'16'
            ,'17'=>'17'
            ,'18'=>'18'
            ,'19'=>'19'
            ,'20'=>'20'
            ,'21'=>'21'
            ,'22'=>'22'
            ,'23'=>'23'
            ,'24'=>'24'
        );
        $minutos = array(
             '' => ''
            ,'0' => '00'
            ,'10' => '10'
            ,'20' => '20'
            ,'30' => '30'
            ,'40' => '40'
            ,'50' => '50'
        );
        return View::make('modulos.empleados.reposicion.form')
                ->with('reposicion', $reposicion)
                ->with('permiso',$permiso)
                ->with('horas',$horas)
                ->with('minutos',$minutos);
    }

    public function getNew($id)
    {
        return $this->createViewForm(new Reposicion(),$id);
    }

    public function getShow($permiso,$idReposicion)
    {
        return $this->createViewForm(Reposicion::find($idReposicion), $permiso);
    }

    public function getDelete($permiso, $id)
    {
    	Reposicion::destroy($id);
        return $this->getReposhow($permiso);
    }

    public function postSave() {
    	$input = Input::all();
        $reposicion = new Reposicion();
    	if($input['id'] > 0) {
    		$reposicion = Reposicion::find($input['id']);
    	}

        // conversion de los campos de hora
        if($input['hora_inicio_hora'] != '' && $input['hora_inicio_minuto'] != '') {
            $input['hora_inicio'] = $input['hora_inicio_hora'].':'.$input['hora_inicio_minuto'];
        }
        if($input['hora_fin_hora'] != '' && $input['hora_fin_minuto'] != '') {
            $input['hora_fin'] = $input['hora_fin_hora'].':'.$input['hora_fin_minuto'];
        }

        $reposicion->fill($input);

        if($reposicion->validate($input)) {
            $reposicion->save();
            return $this->getReposhow($reposicion->permiso_id);
        } else {
            return $this->createViewForm($reposicion, $reposicion->permiso_id)
                    ->with('errors',($reposicion->errors()));
        }
    }
}