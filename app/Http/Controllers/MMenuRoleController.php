<?php

namespace App\Http\Controllers;

use App\Http\Requests\MMenuRoleRequest;
use App\MMenuRole;
use DataTables;

class MMenuRoleController extends Controller
{
    public function index()
    {
        $mmenuroles = MMenuRole::latest()->get();

        return response()->json($mmenuroles);
    }

    public function store(MMenuRoleRequest $request)
    {
        $mmenurole = MMenuRole::create($request->all());

        return response()->json($mmenurole, 201);
    }

    public function show($id)
    {
        $mmenurole = MMenuRole::findOrFail($id);

        return response()->json($mmenurole);
    }

    public function update(MMenuRoleRequest $request, $id)
    {
        $mmenurole = MMenuRole::findOrFail($id);
        $mmenurole->update($request->all());

        return response()->json($mmenurole, 200);
    }

    public function destroy($id)
    {
        MMenuRole::destroy($id);

        return response()->json(null, 204);
    }

    //web function
    public function webIndex()
    {
        $user = auth()->user();
        $mmenuroles = MMenuRole::where('id', '>', '0')->paginate(10);
        return view('master.mmenurole', compact('mmenuroles', 'user'));
    }

    public function webStore(MMenuRoleRequest $request)
    {
        $data = request()->validate([

        ]);

        try {
            $mmenuroles = MMenuRole::create($request->all());
        } catch (Exception $e) {
            return redirect("/mmenurole")->with('failed', 'Failed insert data.');
        }
        return redirect("/mmenurole")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mmenuroles = MMenuRole::findOrFail($id);

        return response()->json($mmenuroles);
    }

    public function webUpdate(MMenuRoleRequest $request, $id)
    {
        $data = request()->validate([

        ]);

        try {
            $mmenuroles = MMenuRole::findOrFail($id);
            $mmenuroles->update($request->all());
        } catch (Exception $e) {
            return redirect("/mmenurole")->with('failed', 'Failed update data.');
        }
        return redirect("/mmenurole")->with('success', 'Success update data.');
    }

    public function webDestroy($id)
    {
        try {
            MMenuRole::destroy($id);
        } catch (Exception $e) {
            return redirect("/mmenurole")->with('failed', 'Failed delete data.');
        }
        return redirect("/mmenurole")->with('success', 'Success delete data.');
    }
}
