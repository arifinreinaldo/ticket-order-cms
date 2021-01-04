<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\MConfiguration;
use App\MSmtpConfig;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MConfigurationController extends Controller
{
    //web function
    public function webIndex()
    {
        $data = MSmtpConfig::all()->first();
        return view('master.mconfiguration', compact('data'));
    }

    public function webCreate()
    {
        $size = MConfiguration::all()->count() + 1;
        return view('master.mconfiguration_create', compact('size'));
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'link' => 'required|url',
            'icon' => 'required|image|mimes:jpg,png,jpeg|max:1024',
            'order' => 'required'
        ]);

        try {
            $imagePath = Util::storeFile(request('icon'), 'social_icon_image');
            unset($data['icon']);
            $data['icon'] = $imagePath;
            $mconfigurations = MConfiguration::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/mconfiguration")->with('failed', 'Failed insert data.');
        }
        return redirect("/mconfiguration")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mconfigurations = MConfiguration::findOrFail($id);

        return response()->json($mconfigurations);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'name' => 'required',
            'link' => 'required|url',
            'icon' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
            'order' => 'required'
        ]);

        try {
            $oldData = MConfiguration::findOrFail($data['id']);
            $oldData->name = $data['name'];
            $oldData->link = $data['link'];

            if ($request['icon']) {
                $imagePath = Util::updateFile($oldData->image, request('icon'), 'social_icon_image');
                unset($data['icon']);
                $oldData->icon = $imagePath;
            }
            if ($data['order'] != $oldData->order) {
                try {
                    MConfiguration::where('order', '>', $oldData->order)
                        ->update(['order' => DB::raw('"order" - 1')]);
                    MConfiguration::where('order', '>=', $data['order'])
                        ->update(['order' => DB::raw('"order" + 1')]);
                } catch (QueryException $ex) {
                    report($ex);
                }
                $oldData->order = $data['order'];
            }
            $oldData->save();
        } catch (Exception $e) {
            report($e);
            return redirect("/mconfiguration")->with('failed', 'Failed update data.');
        }
        return redirect("/mconfiguration")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MConfiguration::select("u.id as id_data", 'u.name', 'u.icon', 'u.order')
            ->from('social_media as u');
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
                ->editColumn("icon", function ($row) {
                    $url = $row->getImage();
                    return "<img class='img-fluid img-thumbnail' src='$url'/>";
                })
                ->escapeColumns('icon')
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MConfiguration::findOrFail($id);
            $size = MConfiguration::all()->count();
            return view('master.mconfiguration_create', compact('data', 'size'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mconfiguration")->with('failed', 'Data Not found');
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
            $rst = MConfiguration::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mconfiguration")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mconfiguration")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mconfiguration")->with('failed', 'Failed to update role user(s)');
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
                $data = MConfiguration::findOrFail($id);
                try {
                    Util::deleteFile($data->image);
                    MConfiguration::destroy($id);
                    MConfiguration::where('order', '>=', $data->order)
                        ->update(['order' => DB::raw('"order" - 1')]);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/mconfiguration")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mconfiguration")->with('failed', 'Failed to delete role(s)');
        }
    }

    public function webStoreSmtp(Request $request)
    {
        $data = request()->validate([
            'id' => 'sometimes',
            'smtp_host' => 'required',
            'smtp_username' => 'required',
            'smtp_password' => 'required',
            'smtp_port' => 'required',
            'smtp_from' => 'required',
        ]);
        try {
            $oldData = MSmtpConfig::all()->first();
            if ($oldData != null) {
                $oldData->id = $data['id'];
                $oldData->smtp_host = $data['smtp_host'];
                $oldData->smtp_username = $data['smtp_username'];
                $oldData->smtp_password = $data['smtp_password'];
                $oldData->smtp_port = $data['smtp_port'];
                $oldData->smtp_from = $data['smtp_from'];
                $oldData->save();
            } else {
                $mconfigurations = MSmtpConfig::updateOrCreate($data);
            }
        } catch (Exception $e) {
            report($e);
            return redirect("/mconfiguration")->with('failed', 'Failed save data.');
        }
        return redirect("/mconfiguration")->with('success', 'Success save data.');
    }
}
