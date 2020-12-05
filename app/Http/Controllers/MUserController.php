<?php

namespace App\Http\Controllers;

use App\Http\Requests\MUserRequest;
use App\MUser;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class MUserController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.muser');
    }

    public function webCreate()
    {
        return view('master.muser_create');
    }

    public function webEdit($id)
    {
        try {
            $muser = MUser::findOrFail($id);
            return view('master.muser_create', compact('muser'));
        } catch (ModelNotFoundException $ex) {
            return redirect("/muser")->with('failed', 'Data Not found');
        }
    }


    public function webStore(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required | email | unique:users',
            'password' => 'required| min:7 | confirmed'
        ]);
        $data['role'] = '1';
        $data['status'] = '1';
        $data['username'] = $data['name'];
        $data['password'] = bcrypt($data['password']);
        try {
            $musers = MUser::create($data);
        } catch (Exception $e) {
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
            'password' => 'nullable|confirmed|min:7'
        ]);

        try {
            $musers = MUser::findOrFail($data['id']);
            $musers->name = $data['name'];
            $musers->username = $data['name'];
            $musers->email = $data['email'];
            if ($data['password'] != "") {
                $musers->password = bcrypt($data['password']);
            }
            $musers->save();
        } catch (Exception $e) {
            return redirect("/muser")->with('failed', 'Failed update data.');
        }
        return redirect("/muser")->with('success', 'Success update data.');
    }

    public function webDestroy($id)
    {
        try {
            MUser::destroy($id);
        } catch (Exception $e) {
            return redirect("/muser")->with('failed', 'Failed delete data.');
        }
        return redirect("/muser")->with('success', 'Success delete data.');
    }

    public function ajaxData(Request $request)
    {
        $results = DB::table('users AS u')
            ->selectRaw("u.id,u.name,u.email,u.role,s.name as status_name,u.status")
            ->join('status_user AS s', 'u.status', '=', 's.id')
            ->orderBy('u.id', 'ASC');
        if ($request->ajax()) {
            return Datatables::of($results)
                ->addIndexColumn()
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
            dd($ex);
        }
    }
}
