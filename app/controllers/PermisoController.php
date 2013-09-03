<?php
class EmpleadoController extends AutheticatedController {

	public function getIndex()
    {
        //
        $field = Request::get('field','usuario'.$this->orderBy);
        $order = Request::get('order','desc');
        $empleados = DB::table('permiso')
            ->join('usuario', 'permiso.usuario_id', '=', 'usuario.id')
            ->join('proyecto', 'permiso.proyecto_id', '=', 'proyecto.id')
            ->join('empleado_puesto','empleado_puesto.usuario_id','usuario.id')
            ->join('puesto', 'puesto.id', '=', 'empleado_puesto.puesto_id')
            ->join('tipo_permiso','tipo_permiso.id','permiso.tipo_id')
            ->select('usuario.id usuario_id', 'usuario.name','usuario.active'
                , 'puesto.nombre nombre_puesto'
                , 'proyecto.nombre nombre_proyecto'
                , 'permiso.id'
                , 'permiso.detalle'
                , 'permiso.fecha')
            ->paginate($this->pageSize);
        return View::make('modulos.empleados.empleado.list')
                   ->with('empleados', $empleados)
                   ->with('field', $field)
                   ->with('order', $order);
    }

    public function createViewForm($usuario, $empleado_puesto) {
        $puestos = Puesto::orderBy('nombre','asc')->lists('nombre','id');
        $puestos = array(''=>'')+$puestos;
        return View::make('modulos.empleados.empleado.form')
                ->with('usuario', $usuario)
                ->with('empleado', $empleado_puesto)
                ->with('puestos',$puestos);
    }

    public function getNew()
    {
        return $this->createViewForm(new User(), new Empleadopuesto());
    }

    public function getShow($id)
    {
        return $this->createViewForm(User::find($id),Empleadopuesto::where('usuario_id','=',$id)->first());
    }

    public function getDelete($id)
    {
        $empleado = Empleadopuesto::where('usuario_id','=',$id)->first();
        $empleado->delete();
    	User::destroy($id);
        return $this->getIndex();
    }

    public function postSave() {
    	$input = Input::all();
        $usuario = new User();
        $empleado = new Empleadopuesto();
    	if($input['id'] > 0) {
    		//$usuario = User::find($input['id']);
            $empleado = Empleadopuesto::where('usuario_id','=',$input['id'])->first();
            $empleado->fill($input);
            $empleado->usuario_id=$input['id'];
            $input['usuario_id']=$empleado->usuario_id;
            if($empleado->validate($input)) {
                $empleado->save();
                return $this->index();
            } else {
                return $this->createViewForm($usuario, $empleado)
                    ->with('errors',($empleado->errors()));
            }
    	} else {
            // campos automaticos
            $input['admin']=0;
            $input['active']=1;
            $usuario->fill($input);
            $empleado->fill($input);

            if($usuario->validate($input)) {
                $usuario->save();
                $empleado->usuario_id = $usuario->id;
                $input['usuario_id'] = $empleado->usuario_id;
                if($empleado->validate($input)) {
                    $empleado->save();
                    return $this->getIndex();
                } else {
                    $usuario->delete();
                    $usuario->id = null;
                    return $this->createViewForm($usuario, $empleado)
                        ->with('errors',($empleado->errors()));
                }
            } else {
                return $this->createViewForm($usuario, $empleado)
                        ->with('errors',($usuario->errors()));
            }
        }
    	
    }
}