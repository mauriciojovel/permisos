<?php
class EmpleadoController extends AutheticatedController {

	public function getIndex()
    {
        //
        $field = Request::get('field','usuario'.$this->orderBy);
        $order = Request::get('order','desc');
        $empleados = DB::table('usuario')
            ->join('empleado_puesto', 'empleado_puesto.usuario_id', '=', 'usuario.id')
            ->join('puesto', 'puesto.id', '=', 'empleado_puesto.puesto_id')
            ->select('usuario.id', 'usuario.name','usuario.active', 'puesto.nombre')
            ->paginate($this->pageSize);
        return View::make('modulos.empleados.empleado.list')
                   ->with('empleados', $empleados)
                   ->with('field', $field)
                   ->with('order', $order);
    }

    public function createViewForm($usuario, $empleado_puesto, $empleado_proyecto) {
        $puestos = Puesto::orderBy('nombre','asc')->lists('nombre','id');
        $puestos = array(''=>'')+$puestos;
        $proyectos = Proyecto::orderBy('nombre','asc')->lists('nombre','id');
        $proyectos = array(''=>'')+$proyectos;
        return View::make('modulos.empleados.empleado.form')
                ->with('usuario', $usuario)
                ->with('empleado', $empleado_puesto)
                ->with('proyecto', $empleado_puesto)
                ->with('puestos',$puestos)
                ->with('proyectos',$proyectos);
    }

    public function getNew()
    {
        return $this->createViewForm(new User(), new Empleadopuesto(), new empleadoproyecto());
    }

    public function getShow($id)
    {
        return $this->createViewForm(User::find($id),Empleadopuesto::where('usuario_id','=',$id)->first()
            ,Empleadoproyecto::where('usuario_id','=',$id)->first());
    }

    public function getDelete($id)
    {
        $empleado = Empleadopuesto::where('usuario_id','=',$id)->first();
        $empleado->delete();
        $proyecto = Empleadoproyecto::where('usuario_id','=',$id)->first();
        $proyecto->delete();
    	User::destroy($id);
        return $this->getIndex();
    }

    public function postSave() {
    	$input = Input::all();
        $usuario = new User();
        $empleado = new Empleadopuesto();
        $proyecto = new Empleadoproyecto();
    	if($input['id'] > 0) {
    		//$usuario = User::find($input['id']);
            $empleado = Empleadopuesto::where('usuario_id','=',$input['id'])->first();
            $empleado->fill($input);
            $empleado->usuario_id=$input['id'];
            $input['usuario_id']=$empleado->usuario_id;
            if($empleado->validate($input)&&$proyecto->validate($input)) {
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
            $proyecto->fill($input);
            if($usuario->validate($input)) {
                $usuario->save();
                $empleado->usuario_id = $usuario->id;
                $input['usuario_id'] = $empleado->usuario_id;
                if($empleado->validate($input)) {
                    $empleado->save();
                    if($proyecto->validate($input)) {
                        $proyecto->usuario_id = $usuario->id;
                        $proyecto->save();
                        return $this->getIndex();
                    } else {
                        $empleado->delete();
                        $usuario->delete();
                        $usuario->id = null;
                        return $this->createViewForm($usuario, $empleado, $proyecto)
                        ->with('errors',($proyecto->errors()));
                    }
                } else {
                    $usuario->delete();
                    $usuario->id = null;
                    return $this->createViewForm($usuario, $empleado,$proyecto)
                        ->with('errors',($empleado->errors()));
                }
            } else {
                return $this->createViewForm($usuario, $empleado,$proyecto)
                        ->with('errors',($usuario->errors()));
            }
        }
    	
    }
}