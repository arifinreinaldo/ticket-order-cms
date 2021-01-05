<?php

namespace App\Http\Controllers;

use App\MFaq;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MFaqController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.mfaq');
    }

    public function webCreate()
    {
        return view('master.mfaq_create');
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);
        $data['status'] = 1;
        $data['order'] = 1;

        try {
            $mfaqs = MFaq::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/mfaq")->with('failed', 'Failed insert data.');
        }
        return redirect("/mfaq")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mfaqs = MFaq::findOrFail($id);

        return response()->json($mfaqs);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'question' => 'required',
            'answer' => 'required'
        ]);

        try {
            $mfaqs = MFaq::findOrFail($data['id']);
            $mfaqs->update($request->all());
        } catch (Exception $e) {
            report($e);
            return redirect("/mfaq")->with('failed', 'Failed update data.');
        }
        return redirect("/mfaq")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MFaq::select("u.id as id_data", 'u.question')
            ->from('faqs as u')
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
                ->editColumn("question", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id_data'>$row->question</span>";
                })
                ->escapeColumns('question')
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MFaq::findOrFail($id);
            $size = MFaq::all()->count();
            return view('master.mfaq_create', compact('data', 'size'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mfaq")->with('failed', 'Data Not found');
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
            $rst = MFaq::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mfaq")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mfaq")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mfaq")->with('failed', 'Failed to update role user(s)');
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
            $data = MFaq::destroy($ids);
            return redirect("/mfaq")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mfaq")->with('failed', 'Failed to delete role(s)');
        }
    }
}
