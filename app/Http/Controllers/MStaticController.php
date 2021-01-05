<?php

namespace App\Http\Controllers;

use App\MStatic;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MStaticController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.mstatic');
    }

    public function webCreate()
    {
        return view('master.mstatic_create');
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([

        ]);

        try {
            $mstatics = MStatic::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/mstatic")->with('failed', 'Failed insert data.');
        }
        return redirect("/mstatic")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mstatics = MStatic::findOrFail($id);

        return response()->json($mstatics);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'content' => 'required',
        ]);

        try {
            $mstatics = MStatic::findOrFail($data['id']);
            $mstatics->update($request->all());
        } catch (Exception $e) {
            report($e);
            return redirect("/mstatic")->with('failed', 'Failed update data.');
        }
        return redirect("/mstatic")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MStatic::select("u.id as id_data", 'u.title')
            ->from('data as u')
            ->join('status AS s', 'u.status', '=', 's.id');
        if ($request->ajax()) {
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn("checkbox", function ($row) {
                    $btn = "";
                    $btn .= "<input type='checkbox' class='check-control' userid='$row->id_data'/>";
                    return $btn;
                })
                ->escapeColumns('checkbox')
                ->editColumn("name", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id_data'>$row->name</span>";
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

    public function webEdit($id)
    {
        if ($id == '1' || $id == '2') {
            try {
                $data = MStatic::find($id);

                return view('master.mstatic_create', compact('data'));
            } catch (ModelNotFoundException $ex) {
                report($ex);
                return redirect("/mstatic")->with('failed', 'Data Not found');
            }
        }
    }

    public
    function webToggle(Request $request)
    {
        $data = request()->validate([
            'userid' => 'required'
        ]);
        $ids = collect(explode(",", $data['userid']))->filter(function ($value, $key) {
            return $value != "";
        });
        try {
            $rst = MStatic::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mstatic")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mstatic")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mstatic")->with('failed', 'Failed to update role user(s)');
        }
    }

    public
    function webDestroy(Request $request)
    {
        $data = request()->validate([
            'userid' => 'required'
        ]);
        $ids = collect(explode(",", $data['userid']))->filter(function ($value, $key) {
            return $value != "";
        });
        try {
            foreach ($ids as $id) {
                $data = MStatic::findOrFail($id);
                try {
                    Util::deleteFile($data->image);
                    MStatic::destroy($id);
                    MStatic::where('order', '>=', $data->order)
                        ->update(['order' => DB::raw('"order" - 1')]);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/mstatic")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mstatic")->with('failed', 'Failed to delete role(s)');
        }
    }
}
