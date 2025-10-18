<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DashboardElement;
use App\Models\Role;
use App\Models\Module;
use App\Models\RoleModule;
use App\Models\RoleElement;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(){
       $this->middleware('admin');
    }

   /**
        * Role list
        *
        * @param mixed $roles
        *
        * @return to roles listing page
    **/
    public function roleList(){

        $roles = Role::where('is_delete',0)->get();

        return view('admin.role.role_list', compact('roles'));
    }

    /**
        * Add role
        *
        * @param mixed $modules, $elements
        *
        * @return to add role page
    **/
    public function addRole(){

        $modules = Module::all();

        $elements = DashboardElement::all();

        return view('admin.role.add_role', compact('modules', 'elements'));   
    }

    /**
        * Save role 
        *
        * @param $name field save in Role database
        *        $role_id, $module_id fields save in RoleDefinedModule database
        *        $role_id, $elements_id fields save in RoleDefinedDashboardElement database
        *
        * @return to role listing page with data store in Role, RoleDefinedModule & RoleDefinedDashboardElement database
    **/
    public function saveRole(Request $request){

        $data = new Role;
        $data->name = $request->name;
        $data->save();

        if(!is_null($request->modules)){
            foreach ($request->modules as $mk => $mv) {
                $modules = new RoleModule;
                $modules->role_id = $data->id;
                $modules->module_id = $mv;
                $modules->action = implode(',',$request->role[$mv]);
                $modules->save();
            }
        }

        if(!is_null($request->elements)){
            foreach ($request->elements as $ek => $ev) {
                $elements = new RoleElement;
                $elements->role_id = $data->id;
                $elements->element_id = $ev;
                $elements->save();
            }
        }

        $route = $request->btn_submit == 'save_and_update' ? 'admin.addRole' : 'admin.roleList';

        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Role',
                'message' => 'Role successfully added',
            ],
        ]);
    }

    /**
        * Edit role 
        *
        * @param mixed $modules, $elements, $role, $moduleId, $elementsId
        *
        * @return to edit role page
    **/
    public function editRole($id){

        $modules = Module::all();

        $elements = DashboardElement::all();

        $role = Role::where('id',base64_decode($id))
                    ->where('is_delete',0)
                    ->where('is_active',1)
                    ->with(['module','element'])
                    ->first();
        
        $moduleId = array();
        $elementsId = array();
        $selected = array();

        if(!is_null($role->module)){
            foreach ($role->module as $mk => $mv) {
                $moduleId[] = $mv->module_id;
                $selected[$mv->module_id] = explode(',',$mv->action);
            }
        }
        if(!is_null($role->element)){
            foreach ($role->element as $ek => $ev) {
                $elementsId[] = $ev->element_id;
            }
        }

        return view('admin.role.edit_role', compact('modules', 'elements', 'role', 'moduleId', 'elementsId','selected'));   
    }

    /**
        * Update role 
        *
        * @param $name field save in Role database
        *        $role_id, $module_id fields save in RoleDefinedModule database
        *        $role_id, $elements_id fields save in RoleDefinedDashboardElement database
        *        RoleDefinedModule delete row of role_id wise
        *        RoleDefinedDashboardElement delete row of role_id wise
        *
        * @return to role listing page with data store in Role, RoleDefinedModule & RoleDefinedDashboardElement option
        *         database
    **/
    public function updateRole(Request $request){

        $role = Role::findOrFail($request->id);
        $role->name = $request->name;
        $role->save();

        RoleModule::where('role_id',$role->id)->delete();
        if(!is_null($request->modules)){
            foreach ($request->modules as $mk => $mv) {
                $modules = new RoleModule;
                $modules->role_id = $role->id;
                $modules->module_id = $mv;
                $modules->action = implode(',',$request->role[$mv]);
                $modules->save();
            }
        }

        RoleElement::where('role_id',$role->id)->delete();
        if(!is_null($request->elements)){
            foreach ($request->elements as $ek => $ev) {
                $elements = new RoleElement;
                $elements->role_id = $role->id;
                $elements->element_id = $ev;
                $elements->save();
            }
        }

        return redirect(route('admin.roleList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Role',
                'message' => 'Role successfully updated',
            ],
        ]);
    }

    /**
        * Delete role 
        *
        * @param $id
        *
        * @return to role listing page with data delete from role database
    **/
    public function deleteRole($id){

        $delete = Role::where('id',base64_decode($id))->update(['is_delete' => 1]);

        if($delete){
            return redirect(route('admin.roleList'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Role',
                    'message' => 'Role successfully deleted',
                ],
            ]);     
        }
    }

    /**
        * Role status change
        *
        * @param $id, $option
        *
        * @return to role listing page change on toggle role active & deactive
    **/
    public function changeRoleStatus(Request $request){

        $status = Role::where('id',$request->id)->update(['is_active' => $request->option]);

        return $status ? 'true' : 'false';
    }

    /**
        * Check role exist
        *
        * @param $id, $name
        *
        * @return to role add & edit page with if role name exist or not
    **/
    public function checkRoleExist(Request $request){

        $query = Role::where('is_delete',0)->where('name', $request->name);
        if(isset($request->id)) {
            $query->where('id','!=',$request->id);
        }
        $name = $query->first();

        return $name ? 'false' : 'true';
    }

    public function getRoleAction(Request $request){

        $action = view('admin.role.action',compact('request'))->render();

        return \Response::json(['html' => $action]);
    }
}
