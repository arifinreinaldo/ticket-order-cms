<?php

namespace App\Http\Controllers;

use App\Http\Requests\MRoleRequest;
use App\MMenuRole;
use App\MRole;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MRoleController extends Controller
{
    public function index()
    {
        $mroles = MRole::latest()->get();

        return response()->json($mroles);
    }

    public function store(MRoleRequest $request)
    {
        $mrole = MRole::create($request->all());

        return response()->json($mrole, 201);
    }

    public function show($id)
    {
        $mrole = MRole::findOrFail($id);

        return response()->json($mrole);
    }

    public function update(MRoleRequest $request, $id)
    {
        $mrole = MRole::findOrFail($id);
        $mrole->update($request->all());

        return response()->json($mrole, 200);
    }

    public function destroy($id)
    {
        MRole::destroy($id);

        return response()->json(null, 204);
    }

    //web function
    public function webIndex()
    {
        return view('master.mrole');
    }

    public function webCreate()
    {
        $access = DB::table('menu as m')
            ->selectRaw('m.id,m.menu,0 as read_access,0 as create_access,0 as update_access,0 as delete_access')
            ->get();
        return view('master.mrole_create', compact('access'));
    }

    public function webEdit($id)
    {
        try {
            $role = MRole::findOrFail($id);
            $access = DB::table('menu as m')
                ->leftJoin('menu_role as mr', 'm.id', '=', 'mr.menu_id')
                ->select('m.id', 'm.menu', 'mr.read_access', 'mr.create_access', 'mr.update_access', 'mr.delete_access')
                ->where('mr.user_role_id', '=', $id)->get();
            return view('master.mrole_create', compact('access', 'role'));
        } catch (ModelNotFoundException $ex) {
            return redirect("/mrole")->with('failed', 'Data Not found');
        }
    }


    public function webStore(Request $request)
    {
        $data = request()->validate([
            'role_name' => 'required'
        ]);
        try {
            $data['status'] = '1';
            $mrole = MRole::create($data);
            $idRole = $mrole->id;
            try {
                $menu = DB::table('menu')->select('id', 'menu')->get();
                foreach ($menu as $item) {
                    $menu_role['user_role_id'] = $idRole;
                    $menu_role['menu_id'] = $item->id;
                    $menu_role['read_access'] = $request['read_' . $item->id];
                    $menu_role['create_access'] = $request['create_' . $item->id];
                    $menu_role['update_access'] = $request['update_' . $item->id];
                    $menu_role['delete_access'] = $request['delete_' . $item->id];
                    if ($menu_role['read_access'] == null) {
                        $menu_role['read_access'] = "";
                    }
                    if ($menu_role['create_access'] == null) {
                        $menu_role['create_access'] = "";
                    }
                    if ($menu_role['update_access'] == null) {
                        $menu_role['update_access'] = "";
                    }
                    if ($menu_role['delete_access'] == null) {
                        $menu_role['delete_access'] = "";
                    }
                    MMenuRole::create($menu_role);
                }
                return redirect("/mrole")->with('success', 'Success create role data.');

            } catch (\Exception $ex) {
                MRole::destroy($idRole);
                return redirect("/mrole/create")->with('failed', 'Failed create access data.');
            }
        } catch (\Exception $e) {
            return redirect("/mrole/create")->with('failed', 'Failed create role data.');
        }
    }

    public function webShow($id)
    {

        $mroles = MRole::findOrFail($id);

        return response()->json($mroles);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'role_name' => 'required'
        ]);

        try {
            $mrole = MRole::findOrFail($data['id']);
            $mrole->role_name = $data['role_name'];
            $mrole->save();

            $idRole = $mrole->id;
            DB::table('menu_role')->where('user_role_id', '=', $idRole)->delete();
            try {
                $menu = DB::table('menu')->select('id', 'menu')->get();
                foreach ($menu as $item) {
                    $menu_role['user_role_id'] = $idRole;
                    $menu_role['menu_id'] = $item->id;
                    $menu_role['read_access'] = $request['read_' . $item->id];
                    $menu_role['create_access'] = $request['create_' . $item->id];
                    $menu_role['update_access'] = $request['update_' . $item->id];
                    $menu_role['delete_access'] = $request['delete_' . $item->id];
                    if ($menu_role['read_access'] == null) {
                        $menu_role['read_access'] = "";
                    }
                    if ($menu_role['create_access'] == null) {
                        $menu_role['create_access'] = "";
                    }
                    if ($menu_role['update_access'] == null) {
                        $menu_role['update_access'] = "";
                    }
                    if ($menu_role['delete_access'] == null) {
                        $menu_role['delete_access'] = "";
                    }
                    MMenuRole::create($menu_role);
                }
                return redirect("/mrole")->with('success', 'Success update role data.');

            } catch (\Exception $ex) {
                return redirect("/mrole/create")->with('failed', 'Failed update access data.');
            }
        } catch (\Exception $e) {
            return redirect("/mrole")->with('failed', 'Failed update role data.');
        }
    }

    public function webDestroy($id)
    {
        try {
            MRole::destroy($id);
        } catch (Exception $e) {
            return redirect("/mrole")->with('failed', 'Failed delete data.');
        }
        return redirect("/mrole")->with('success', 'Success delete data.');
    }

    public function ajaxData(Request $request)
    {
        $results = DB::table('user_role AS u')
            ->selectRaw("u.id,u.role_name,u.status,s.name as status_name")
            ->join('status AS s', 'u.status', '=', 's.id')
            ->orderBy('u.id', 'ASC');
        if ($request->ajax()) {
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn("checkbox", function ($row) {
                    $btn = "";
                    $btn .= "<input type='checkbox' class='check-control' userid='$row->id'/>";
                    return $btn;
                })
                ->escapeColumns('checkbox')
                ->editColumn("role_name", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id'>$row->role_name</span>";
                })
                ->escapeColumns('role_name')
                ->addColumn("action", function ($row) {
                    $btn = "";
                    $btn .= "<button class='btn btn-success btn-edit' title='Edit User' userid='$row->id'>
                                            <span class='fa fa-fw fa-user-edit'></span>
                                        </button>";
                    if ($row->status == '1') {
                        $btn .= "<button class='btn btn-light btn-activate' title='Deactivate User' userid='$row->id'>
                                            <span class='fa fa-fw fa-toggle-on'></span>
                                        </button>";
                    } else {
                        $btn .= "<button class='btn btn-light btn-activate' title='Activate User' userid='$row->id'>
                                            <span class='fa fa-fw fa-toggle-off'></span>
                                        </button>";
                    }

                    return $btn;
                })
                ->make(true);
        }
    }

    public function webToggle(Request $request)
    {
        $data = request()->validate([
            'userid' => 'required'
        ]);
        try {
            $message = 'activated';
            $muser = MRole::findOrFail($data['userid']);
            if ($muser->status == '1') {
                $muser->status = '2';
                $message = 'deactivated';
            } else if ($muser->status == '2') {
                $muser->status = '1';
            }
            $muser->save();
            return redirect("/mrole")->with('success', 'Role has been ' . $message);
        } catch (ModelNotFoundException $ex) {
            return redirect("/mrole")->with('failed', 'Data Not found');
        } catch (Exception$ex) {
            dd($ex);
        }
    }
}
