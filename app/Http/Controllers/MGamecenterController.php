<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\MGamecenter;
use App\MGamecenterbranch;
use App\MGamecenterlocation;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MGamecenterController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.mgamecenter');
    }

    public function webCreate()
    {
        return view('master.mgamecenter_create');
    }

    public function webStore(Request $request)
    {

        $data = request()->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:1024'
        ]);
        $data['status'] = 1;
        try {
            $imagePath = Util::storeFile(request('image'), 'game_center_banner_image');
            unset($data['image']);
            $data['image'] = $imagePath;
            $mgamecenters = MGamecenter::create($data);
            $gcId = $mgamecenters->id;
            foreach ($request['branch_name'] as $key => $value) {
                $location['name'] = $value;
                $location['game_center_id'] = $gcId;
                $gameLoc = MGamecenterlocation::create($location);
                $gcLId = $gameLoc->id;
                $idx = $request['branch_index'][$key];
                foreach ($request['subbranch_location'][$idx] as $keyBranch => $value) {
                    $branch['name'] = $value;
                    $branch['game_center_id'] = $gcId;
                    $branch['game_center_location_id'] = $gcLId;
                    $branch['title'] = $request['subbranch_name'][$idx][$keyBranch];
                    $branch['content'] = $request['subbranch_content'][$idx][$keyBranch];
                    $branchPath = Util::storeFile($request['subbranch_image'][$idx][$keyBranch], 'game_center_branch_image');
                    $branch['image'] = $branchPath;
                    MGamecenterbranch::create($branch);
                }
            }
        } catch (Exception $e) {
            report($e);
            return redirect("/mgcenter")->with('failed', 'Failed insert data.');
        }
        return redirect("/mgcenter")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mgamecenters = MGamecenter::findOrFail($id);

        return response()->json($mgamecenters);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:1024'
        ]);

        try {
            $oldData = MGamecenter::findOrFail($data['id']);
            $oldData->name = $data['name'];

            if ($request['image']) {
                $imagePath = Util::updateFile($oldData->image, request('image'), 'game_center_banner_image');
                unset($data['image']);
                $oldData->image = $imagePath;
            }
            $oldData->save();

            foreach ($request['branch_name'] as $key => $value) {
                $gcLId = $request['location_id'][$key];
                if ($gcLId != -1) {
                    $oldLocation = MGamecenterlocation::findOrFail($gcLId);
                    $oldLocation->name = $value;
                    $oldLocation->save();
                } else {
                    $location['name'] = $value;
                    $location['game_center_id'] = $data['id'];
                    $gameLoc = MGamecenterlocation::create($location);
                    $gcLId = $gameLoc->id;
                }
                $idx = $request['branch_index'][$key];
                foreach ($request['subbranch_location'][$idx] as $keyBranch => $value) {
                    $gcBranchId = $request['branch_id'][$idx][$keyBranch];
                    if ($gcBranchId != -1) {
                        $oldBranch = MGamecenterbranch::findOrFail($gcBranchId);
                        $oldBranch->name = $value;
                        $oldBranch->title = $request['subbranch_name'][$idx][$keyBranch];
                        $oldBranch->content = $request['subbranch_content'][$idx][$keyBranch];
                        if (isset($request['subbranch_image'][$idx][$keyBranch])) {
                            $branchPath = Util::updateFile($oldBranch->image, $request['subbranch_image'][$idx][$keyBranch], 'game_center_branch_image');
                            $oldBranch->image = $branchPath;
                        }
                        $oldBranch->save();
                    } else {
                        $branch['name'] = $value;
                        $branch['game_center_id'] = $data['id'];
                        $branch['game_center_location_id'] = $gcLId;
                        $branch['title'] = $request['subbranch_name'][$idx][$keyBranch];
                        $branch['content'] = $request['subbranch_content'][$idx][$keyBranch];
                        $branchPath = Util::storeFile($request['subbranch_image'][$idx][$keyBranch], 'game_center_branch_image');
                        $branch['image'] = $branchPath;
                        MGamecenterbranch::create($branch);
                    }
                }
            }
            if (isset($request['branch_id_delete'])) {
                foreach ($request['branch_id_delete'] as $id) {
                    MGamecenterbranch::destroy($id);
                }
            }
            if (isset($request['location_id_delete'])) {
                foreach ($request['location_id_delete'] as $id) {
                    MGamecenterlocation::destroy($id);
                }
            }
        } catch (Exception $e) {
            dd($e);
            report($e);
            return redirect("/mgcenter")->with('failed', 'Failed update data.');
        }
        return redirect("/mgcenter")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MGamecenter::select("u.id as id_data", 'u.name', 's.name as status_name')
            ->from('game_centers as u')
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
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MGamecenter::findOrFail($id);
            return view('master.mgamecenter_create', compact('data'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mgcenter")->with('failed', 'Data Not found');
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
            $rst = MGamecenter::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mgcenter")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mgcenter")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mgcenter")->with('failed', 'Failed to update role user(s)');
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
            $data = MGamecenter::destroy($ids);
            return redirect("/mgcenter")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mgcenter")->with('failed', 'Failed to delete role(s)');
        }
    }
}
