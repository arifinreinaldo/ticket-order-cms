<?php

namespace App\Http\Controllers;

use App\MGamecenter;
use App\MRidecategory;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MRidecategoryController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.mridecategory');
    }

    public function webCreate()
    {
        return view('master.mridecategory_create');
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([

        ]);

        try {
            $mridecategories = MRidecategory::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/mridecategory")->with('failed', 'Failed insert data.');
        }
        return redirect("/mridecategory")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mridecategories = MRidecategory::findOrFail($id);

        return response()->json($mridecategories);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'game_center_id' => 'required',
        ]);
        $gcId = $data['game_center_id'];
        try {
            foreach ($request['category_name'] as $key => $value) {
                $rId = $request['category_id'][$key];
                if ($rId == -1) {
                    $category['game_center_id'] = $gcId;
                    $category['name'] = $value;
                    MRidecategory::create($category);
                }
            }
        } catch (Exception $e) {
            report($e);
            return redirect("/mridecategory")->with('failed', 'Failed update data.');
        }
        return redirect("/mridecategory")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MGamecenter::select("u.id as id_data", 'u.name')
            ->from('game_centers as u');
        if ($request->ajax()) {
            return Datatables::of($results)
                ->editColumn("name", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id_data'>$row->name</span>";
                })
                ->escapeColumns('name')
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MRidecategory::where('game_center_id', '=', $id)->get();
            return view('master.mridecategory_create', compact('data', 'id'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mridecategory")->with('failed', 'Data Not found');
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
            $rst = MRidecategory::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mridecategory")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mridecategory")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mridecategory")->with('failed', 'Failed to update role user(s)');
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
                $data = MRidecategory::findOrFail($id);
                try {
                    Util::deleteFile($data->image);
                    MRidecategory::destroy($id);
                    MRidecategory::where('order', '>=', $data->order)
                        ->update(['order' => DB::raw('"order" - 1')]);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/mridecategory")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mridecategory")->with('failed', 'Failed to delete role(s)');
        }
    }
}
