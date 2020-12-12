<?php

namespace App\Http\Controllers;

use App\MRole;
use App\MUser;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MUserController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.muser');
    }

    public function webCreate()
    {
        $mrole = MRole::where('status', '=', '1')->get();
        return view('master.muser_create', compact('mrole'));
    }

    public function webEdit($id)
    {
        try {
            $mrole = MRole::where('status', '=', '1')->get();
            $muser = MUser::findOrFail($id);
            return view('master.muser_create', compact('muser', 'mrole'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/muser")->with('failed', 'Data Not found');
        }
    }


    public function webStore(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required | email | unique:users',
            'password' => 'required| min:7 | confirmed',
            'role' => 'required',
        ]);
//        $data['status'] = '1';
        $data['username'] = $data['name'];
        $data['password'] = bcrypt($data['password']);
        try {
            $musers = MUser::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/muser/create")->with('failed', 'Failed insert data.');
        }
        return redirect("/muser")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {
        $musers = MUser::findOrFail($id);

        return response()->json($musers);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable|confirmed|min:7',
            'role' => 'required',
        ]);

        try {
            $musers = MUser::findOrFail($data['id']);
            $musers->name = $data['name'];
            $musers->username = $data['name'];
            $musers->email = $data['email'];
            if ($data['password'] != "") {
                $musers->password = bcrypt($data['password']);
            }
            $musers->role = $data['role'];
            $musers->save();
        } catch (Exception $e) {
            report($e);
            return redirect("/muser")->with('failed', 'Failed update data.');
        }
        return redirect("/muser")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = DB::table('users AS u')
            ->selectRaw("u.id,u.name,u.email,u.role,s.name as status_name,u.status,ur.role_name")
            ->join('status AS s', 'u.status', '=', 's.id')
            ->join('user_role AS ur', 'u.role', '=', 'ur.id')
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
//                ->editColumn("status_name", function ($row) {
//                    $btn = "";
//                    if ($row->status == '1') {
//                        $btn .= "<a class='label theme-bg2 text-white f-12'>Active</a>";
//                    } else {
//                        $btn .= "<a class='label theme-bg text-white f-12'>Inactive</a>";
//                    }
//                    return $btn;
//                })
//                ->escapeColumns('status_name')
                ->editColumn("name", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id'>$row->name</span>";
                })
                ->escapeColumns('name')
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
        if ($request['state'] == null) {
            try {
                $message = 'activated';
                $muser = MUser::findOrFail($data['userid']);
                if ($muser->status == '1') {
                    $muser->status = '2';
                    $message = 'deactivated';
                } else if ($muser->status == '2') {
                    $muser->status = '1';
                }
                $muser->save();
                return redirect("/muser")->with('success', 'User has been ' . $message);
            } catch (ModelNotFoundException $ex) {
                return redirect("/muser")->with('failed', 'Data Not found');
            } catch (Exception$ex) {
                report($ex);
                dd($ex);
            }
        } else {
            $ids = collect(explode(",", $data['userid']))->filter(function ($value, $key) {
                return $value != "";
            });
            try {
                $rst = MUser::whereIn('id', $ids)->get();
                foreach ($rst as $item) {
                    $item->status = $request['state'];
                    $item->save();
                }
                if ($request['state'] == '1') {
                    return redirect("/muser")->with('success', 'User(s) has been activated');
                } else if ($request['state'] == '2') {
                    return redirect("/muser")->with('success', 'User(s) has been deactivated');
                }

            } catch (\Exception $exception) {
                report($exception);
                return redirect("/muser")->with('failed', 'Failed to update user(s)');
            }
        }
    }

    public function webDestroy(Request $request)
    {
        $data = request()->validate([
            'userid' => 'required'
        ]);
        $ids = explode(",", $data['userid']);
        try {
            $rst = MUser::destroy($ids);
            return redirect("/muser")->with('success', 'User(s) has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/muser")->with('failed', 'Failed to delete user(s)');
        }
    }
}
