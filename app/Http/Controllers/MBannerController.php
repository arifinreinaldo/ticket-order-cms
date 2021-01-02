<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\MBanner;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MBannerController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.mbanner');
    }

    public function webCreate()
    {
        $size = MBanner::all()->count() + 1;
        return view('master.mbanner_create', compact('size'));
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([
            'title' => 'required|unique:games',
            'order' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:1024'
        ]);
        $data['link'] = '1';
        try {
            $imagePath = Util::storeFile(request('image'), 'banner_image');
            unset($data['image']);
            $data['image'] = $imagePath;
            $data['status'] = '1';
            $mbanners = MBanner::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/mbanner")->with('failed', 'Failed insert data.');
        }
        return redirect("/mbanner")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mbanners = MBanner::findOrFail($id);

        return response()->json($mbanners);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
        ]);

        try {
            $mbanners = MBanner::findOrFail($data['id']);
            $mbanners->update($request->all());
        } catch (Exception $e) {
            report($e);
            return redirect("/mbanner")->with('failed', 'Failed update data.');
        }
        return redirect("/mbanner")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MBanner::select("u.id as id_data", 'u.title', 'u.status', 'u.updated_at', 's.name', 'u.image','u.order')
            ->from('banners as u')
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
                ->editColumn("title", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id_data'>$row->title</span>";
                })
                ->escapeColumns('title')
                ->editColumn("image", function ($row) {
                    $url = $row->getImage();
                    return "<img class='img-fluid img-thumbnail' src='$url'/>";
                })
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MBanner::findOrFail($id);
            $size = MBanner::all()->count();
            return view('master.mbanner_create', compact('data', 'size'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mbanner")->with('failed', 'Data Not found');
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
            $rst = MBanner::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mbanner")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mbanner")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mbanner")->with('failed', 'Failed to update role user(s)');
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
                $data = MBanner::findOrFail($id);
                try {
                    Util::deleteFile($data->image);
                    MBanner::destroy($id);
                    MBanner::where('order', '>=', $data->order)
                        ->update(['order' => DB::raw('"order" - 1')]);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/mbanner")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mbanner")->with('failed', 'Failed to delete role(s)');
        }
    }
}
