<?php

namespace App\Http\Controllers;

use App\Http\Requests\MUserRequest;
use App\MUser;
use DataTables;
use Illuminate\Http\Request;

class MUserController extends Controller
{
    public function index()
    {
        $musers = MUser::latest()->get();

        return response()->json($musers);
    }

    public function store(MUserRequest $request)
    {
        $muser = MUser::create($request->all());

        return response()->json($muser, 201);
    }

    public function show($id)
    {
        $muser = MUser::findOrFail($id);

        return response()->json($muser);
    }

    public function update(MUserRequest $request, $id)
    {
        $muser = MUser::findOrFail($id);
        $muser->update($request->all());

        return response()->json($muser, 200);
    }

    public function destroy($id)
    {
        MUser::destroy($id);

        return response()->json(null, 204);
    }

    //web function
    public function webIndex()
    {
        return view('master.muser');
    }

    public function webCreate()
    {
        return view('master.muser_create');
    }

    public function webStore(MUserRequest $request)
    {
        $data = request()->validate([

        ]);

        try {
            $musers = MUser::create($request->all());
        } catch (Exception $e) {
            return redirect("/muser")->with('failed', 'Failed insert data.');
        }
        return redirect("/muser")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {
        $musers = MUser::findOrFail($id);

        return response()->json($musers);
    }

    public function webUpdate(MUserRequest $request, $id)
    {
        $data = request()->validate([

        ]);

        try {
            $musers = MUser::findOrFail($id);
            $musers->update($request->all());
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
        $mreward = MUser::where('id', '>', '0');
        if ($request->ajax()) {
            return Datatables::of($mreward)
                ->addIndexColumn()
                ->addColumn("action", function ($row) {
                    $btn = "<button class='btn btn-success btn-approve' title='Redeem'
                                        >
                                            <span class='fa fa-shopping-cart'></span>
                                        </button>";
                    return $btn;
                })
                ->make(true);
        }
    }
}
