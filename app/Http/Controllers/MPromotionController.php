<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\MPromotion;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MPromotionController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.mpromotion');
    }

    public function webCreate()
    {
        return view('master.mpromotion_create');
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([
            'promo_name' => 'required',
            'promo_image' => 'required|image|mimes:jpg,png,jpeg|max:1024',
        ]);

        $imagePath = Util::storeFile(request('promo_image'), 'promo_image');
        unset($data['promo_image']);
        $data['promo_image'] = $imagePath;
        $data['status'] = '1';
        $data['product_id'] = '1';
        try {
            $mpromotions = MPromotion::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/mpromotion")->with('failed', 'Failed insert data.');
        }
        return redirect("/mpromotion")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mpromotions = MPromotion::findOrFail($id);

        return response()->json($mpromotions);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'promo_name' => 'required',
            'promo_image' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
        ]);

        try {
            $oldData = MPromotion::findOrFail($data['id']);
            $oldData->promo_name = $data['promo_name'];
            if ($request['promo_image']) {
                $imagePath = Util::updateFile($oldData->promo_image, request('promo_image'), 'promo_image');
                unset($data['promo_image']);
                $oldData->promo_image = $imagePath;
            }
            $oldData->save();
        } catch (Exception $e) {
            report($e);
            return redirect("/mpromotion")->with('failed', 'Failed update data.');
        }
        return redirect("/mpromotion")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MPromotion::select('u.id as id_data', 'u.promo_name', 'u.promo_image', 'name', 'u.product_id')
            ->from('promos as u')
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
                ->editColumn("promo_name", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id_data'>$row->promo_name</span>";
                })
                ->escapeColumns('promo_name')
                ->editColumn("promo_image", function ($row) {
                    $url = $row->getImage();
                    return "<img class='img-fluid img-thumbnail' src='$url'/>";
                })
                ->escapeColumns('promo_image')
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MPromotion::findOrFail($id);
            return view('master.mpromotion_create', compact('data'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mpromotion")->with('failed', 'Data Not found');
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
            $rst = MPromotion::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mpromotion")->with('success', 'Data(s) has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mpromotion")->with('success', 'Data(s) has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mpromotion")->with('failed', 'Failed to update role user(s)');
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
                $data = MPromotion::findOrFail($id);
                try {
                    Util::deleteFile($data->image);
                    MPromotion::destroy($id);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/mpromotion")->with('success', 'Data(s) has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mpromotion")->with('failed', 'Failed to delete role(s)');
        }
    }
}
