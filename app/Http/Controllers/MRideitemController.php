<?php

namespace App\Http\Controllers;

use App\MRideitem;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MRideitemController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.mrideitem');
    }

    public function webCreate()
    {
        return view('master.mrideitem_create');
    }
    public function webStore(Request $request)
    {
        $data = request()->validate([

        ]);

        try{
            $mrideitems = MRideitem::create($data);
        }catch(Exception $e){
            report($e);
            return redirect("/mrideitem")->with('failed','Failed insert data.');
        }
        return redirect("/mrideitem")->with('success','Success insert data.');
    }

    public function webShow($id)
    {

        $mrideitems = MRideitem::findOrFail($id);

        return response()->json($mrideitems);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id'=>'required',
        ]);

        try{
            $mrideitems = MRideitem::findOrFail($data['id']);
            $mrideitems->update($request->all());
        }catch(Exception $e){
            report($e);
            return redirect("/mrideitem")->with('failed','Failed update data.');
        }
        return redirect("/mrideitem")->with('success','Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MRideitem::select("u.id as id_data", 'u.title')
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
        try {
            $data = MRideitem::findOrFail($id);
            $size = MRideitem::all()->count();
            return view('master.mrideitem_create', compact('data', 'size'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mrideitem")->with('failed', 'Data Not found');
        }
    }

    public function webToggle(Request $request)
    {
        $data = request()->validate([
            'userid' => 'required'
        ]);
        $ids = collect(explode(",", $data['userid']))->filter(function ($value, $key) {
            return $value != "";
        });
        try {
            $rst = MRideitem::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mrideitem")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mrideitem")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mrideitem")->with('failed', 'Failed to update role user(s)');
        }
    }

    public function webDestroy(Request $request)
    {
        $data = request()->validate([
            'userid' => 'required'
        ]);
        $ids = collect(explode(",", $data['userid']))->filter(function ($value, $key) {
            return $value != "";
        });
        try {
            foreach ($ids as $id) {
                $data = MRideitem::findOrFail($id);
                try {
                    Util::deleteFile($data->image);
                    MRideitem::destroy($id);
                    MRideitem::where('order', '>=', $data->order)
                        ->update(['order' => DB::raw('"order" - 1')]);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/mrideitem")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mrideitem")->with('failed', 'Failed to delete role(s)');
        }
    }
}
