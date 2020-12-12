<?php

namespace App\Http\Controllers;

use App\Http\Requests\MActivityRequest;
use App\MActivity;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MActivityController extends Controller
{
    public function index()
    {
        $mactivities = MActivity::latest()->get();

        return response()->json($mactivities);
    }

    public function store(MActivityRequest $request)
    {
        $mactivity = MActivity::create($request->all());

        return response()->json($mactivity, 201);
    }

    public function show($id)
    {
        $mactivity = MActivity::findOrFail($id);

        return response()->json($mactivity);
    }

    public function update(MActivityRequest $request, $id)
    {
        $mactivity = MActivity::findOrFail($id);
        $mactivity->update($request->all());

        return response()->json($mactivity, 200);
    }

    public function destroy($id)
    {
        MActivity::destroy($id);

        return response()->json(null, 204);
    }

    //web function
    public function webIndex()
    {
        $activities = DB::table('activity_log AS a')
            ->select('log_name', 'description', 'subject_id', 'u.name', 'a.updated_at')
            ->leftJoin('users as u', 'a.causer_id', '=', 'u.id')
            ->orderBy('a.updated_at', 'DESC')->paginate(2);
        $activity = "active";
        $error = "";
        return view('master.mactivity', compact('activities', 'activity', 'error'));
    }

    public function webError()
    {
        $activities = DB::table('activity_log AS a')
            ->select('log_name', 'description', 'subject_id', 'u.name', 'a.updated_at')
            ->leftJoin('users as u', 'a.causer_id', '=', 'u.id')
            ->orderBy('a.updated_at', 'DESC')->paginate(2);
        $activity = "";
        $error = "active";
        return view('master.mactivity', compact('activities', 'activity', 'error'));
    }

    public function webStore(MActivityRequest $request)
    {
        $data = request()->validate([

        ]);

        try {
            $mactivities = MActivity::create($request->all());
        } catch (Exception $e) {
            return redirect("/mactivity")->with('failed', 'Failed insert data.');
        }
        return redirect("/mactivity")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mactivities = MActivity::findOrFail($id);

        return response()->json($mactivities);
    }

    public function webUpdate(MActivityRequest $request, $id)
    {
        $data = request()->validate([

        ]);

        try {
            $mactivities = MActivity::findOrFail($id);
            $mactivities->update($request->all());
        } catch (Exception $e) {
            return redirect("/mactivity")->with('failed', 'Failed update data.');
        }
        return redirect("/mactivity")->with('success', 'Success update data.');
    }

    public function webDestroy($id)
    {
        try {
            MActivity::destroy($id);
        } catch (Exception $e) {
            return redirect("/mactivity")->with('failed', 'Failed delete data.');
        }
        return redirect("/mactivity")->with('success', 'Success delete data.');
    }

    public function ajaxData(Request $request)
    {
        $results = DB::table('activity_log AS a')
            ->select('log_name', 'description', 'subject_id', 'u.name', 'a.updated_at')
            ->leftJoin('users as u', 'a.causer_id', '=', 'u.id')
            ->orderBy('a.updated_at', 'DESC');

        if ($request->ajax()) {
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn("display", function ($row) {
                    $diff = Carbon::parse($row->updated_at)->diffForHumans();
                    return "<span class='fa fa-fw fa-clock'></span> $row->name $row->description on $row->log_name $diff";
                })
                ->escapeColumns('display')
//                ->addColumn("checkbox", function ($row) {
//                    $btn = "";
//                    $btn .= "<input type='checkbox' class='check-control' userid='$row->id'/>";
//                    return $btn;
//                })
//                ->escapeColumns('checkbox')
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
//                ->editColumn("name", function ($row) {
//                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id'>$row->name</span>";
//                })
//                ->escapeColumns('name')
//                ->addColumn("action", function ($row) {
//                    $btn = "";
//                    $btn .= "<button class='btn btn-success btn-edit' title='Edit User' userid='$row->id'>
//                                            <span class='fa fa-fw fa-user-edit'></span>
//                                        </button>";
//                    if ($row->status == '1') {
//                        $btn .= "<button class='btn btn-light btn-activate' title='Deactivate User' userid='$row->id'>
//                                            <span class='fa fa-fw fa-toggle-on'></span>
//                                        </button>";
//                    } else {
//                        $btn .= "<button class='btn btn-light btn-activate' title='Activate User' userid='$row->id'>
//                                            <span class='fa fa-fw fa-toggle-off'></span>
//                                        </button>";
//                    }
//
//                    return $btn;
//                })
                ->make(true);
        }
    }
}
