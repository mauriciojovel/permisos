<?php
class PermisoController extends AutheticatedController {

	public function getIndex()
    {
        //
        $field = Request::get('field','usuario'.$this->orderBy);
        $order = Request::get('order','desc');
        $query = DB::table('permiso')
            ->join('usuario', 'permiso.usuario_id', '=', 'usuario.id')
            ->join('proyecto', 'permiso.proyecto_id', '=', 'proyecto.id')
            ->join('empleado_puesto','empleado_puesto.usuario_id','=','usuario.id')
            ->join('puesto', 'puesto.id', '=', 'empleado_puesto.puesto_id')
            ->join('tipo_permiso','tipo_permiso.id','=','permiso.tipo_permiso_id')
            ->select(
                  'usuario.id as usuario_id'
                , 'usuario.name as nombre_usuario'
                , 'usuario.active as usuario_active'
                , 'puesto.nombre as nombre_puesto'
                , 'proyecto.nombre as nombre_proyecto'
                , 'permiso.id'
                , 'permiso.detalle'
                , 'permiso.fecha'
                , 'tipo_permiso.nombre as tipo_permiso'
                );
        $permisos = null;

        if(!($this->getCurrentUser()->admin===1)) {
            // Si no es un usuario admin solo podra ver sus permisos
            $query->where('usuario.id','=',$this->getCurrentUser()->id);
        }

        $permisos = $query->paginate($this->pageSize);

        return View::make('modulos.empleados.permiso.list')
                   ->with('permisos', $permisos)
                   ->with('field', $field)
                   ->with('order', $order);
    }

    public function createViewForm($permiso) {
        $emptyArray = array(''=>'');
        $tipoPermisos = Tipopermiso::orderBy('nombre','asc')->lists('nombre','id');
        $tipoPermisos = $emptyArray + $tipoPermisos;
        $usuarios = null;
        if(!($this->getCurrentUser()->admin===1)) {
            $usuarios = User::where('name','=',Auth::user()->username)->orderBy('name','asc')->lists('name','id');
        } else {
            $usuarios = User::orderBy('name','asc')->lists('name','id');
            $usuarios = $emptyArray + $usuarios;
        }
        return View::make('modulos.empleados.permiso.form')
                ->with('permiso', $permiso)
                ->with('tipoPermisos',$tipoPermisos)
                ->with('usuarios',$usuarios);
    }

    public function getNew()
    {
        return $this->createViewForm(new Permiso());
    }

    public function getShow($id)
    {
        return $this->createViewForm(Permiso::find($id));
    }

    public function getDelete($id)
    {
    	Permiso::destroy($id);
        return $this->getIndex();
    }

    public function postSave() {
    	$input = Input::all();
        $permiso = new Permiso();
    	if($input['id'] > 0) {
    		$permiso = Permiso::find($input['id']);
            $input['proyecto_id'] = $permiso->proyecto_id;
    	} else {
            // Obtenemos el usuario al cual se le pondra el permiso
            $usuario = User::find($input['usuario_id']);
            foreach ($usuario->empleadoProyecto as $empro) {
                $empleadoProyecto = $empro;
            }

            $input['proyecto_id'] = $empleadoProyecto->proyecto_id;
        }

        $permiso->fill($input);

        if($permiso->validate($input)) {
            $permiso->save();
            return $this->getIndex();
        } else {
            return $this->createViewForm($permiso)
                    ->with('errors',($permiso->errors()));
        }
    	
    }
}