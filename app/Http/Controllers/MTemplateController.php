<?php

namespace App\Http\Controllers;

use App\MTemplate;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MTemplateController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.mtemplate');
    }

    public function webCreate()
    {
        return view('master.mtemplate_create');
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([
            'title' => 'required',
            'head' => 'required',
            'body' => 'required',
            'footer' => 'required',
        ]);

        try {
            $mtemplates = MTemplate::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/mtemplate")->with('failed', 'Failed insert data.');
        }
        return redirect("/mtemplate")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mtemplates = MTemplate::findOrFail($id);

        return response()->json($mtemplates);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'title' => 'required',
            'head' => 'required',
            'body' => 'required',
            'footer' => 'required',
        ]);

        try {
            $mtemplates = MTemplate::findOrFail($data['id']);
            $mtemplates->update($request->all());
        } catch (Exception $e) {
            report($e);
            return redirect("/mtemplate")->with('failed', 'Failed update data.');
        }
        return redirect("/mtemplate")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MTemplate::select("u.id as id_data", 'u.title')
            ->from('template_emails as u');
        if ($request->ajax()) {
            return Datatables::of($results)
                ->addIndexColumn()
                ->editColumn("name", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id_data'>$row->name</span>";
                })
                ->escapeColumns('name')
                ->addColumn("action", function ($row) {
                    $btn = "<a class='btn btn-primary btn-show' href='" . url('/mtemplate') . "/edit/$row->id_data' title ='Edit'> <span class='fa fa-fw fa-edit'></span></a>";
                    return $btn;
                })
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MTemplate::findOrFail($id);
            return view('master.mtemplate_create', compact('data'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mtemplate")->with('failed', 'Data Not found');
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
            $rst = MTemplate::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mtemplate")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mtemplate")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mtemplate")->with('failed', 'Failed to update role user(s)');
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
                $data = MTemplate::findOrFail($id);
                try {
                    Util::deleteFile($data->image);
                    MTemplate::destroy($id);
                    MTemplate::where('order', '>=', $data->order)
                        ->update(['order' => DB::raw('"order" - 1')]);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/mtemplate")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mtemplate")->with('failed', 'Failed to delete role(s)');
        }
    }
}
