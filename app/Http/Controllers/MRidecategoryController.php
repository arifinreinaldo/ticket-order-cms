<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\MGamecenter;
use App\MRidecategory;
use App\MRideitem;
use App\MRideitemDetail;
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
                $idxCategory = $request['branch_index'][$key];
                $rId = $request['category_id'][$key];
                if ($rId == -1) {
                    $category['game_center_id'] = $gcId;
                    $category['name'] = $value;
                    $rId = MRidecategory::create($category)->id;
                } else {
                    $oldCategory = MRidecategory::findOrFail($rId);
                    $oldCategory->name = $value;
                    $oldCategory->save();
                }
                foreach ($request['subbranch_name'][$idxCategory] as $keyBranch => $valueBranch) {
                    $branchId = $request['branch_id'][$idxCategory][$keyBranch];
                    $type = 1;
                    if ($branchId == -1) {
                        $branch['game_center_id'] = $gcId;
                        $branch['gcr_category_id'] = $rId;
                        $branch['name'] = $valueBranch;
                        $branch['type'] = $request['subbranch_type'][$idxCategory][$keyBranch];
                        $type = $branch['type'];
                        $imagePath = Util::storeFile($request['subbranch_cover'][$idxCategory][$keyBranch], 'game_center_category_cover_image');
                        $branch['cover'] = $imagePath;
                        if ($branch['type'] == 1) {
                            $bannerPath = Util::storeFile($request['subbranch_banner'][$idxCategory][$keyBranch], 'game_center_category_banner_image');
                            $branch['banner'] = $bannerPath;
                            $branch['content'] = $request['subbranch_content'][$idxCategory][$keyBranch];
                        } else {
                            $branch['banner'] = '';
                            $branch['content'] = '';
                        }
                        $branchId = MRideitem::create($branch)->id;
                    } else {
                        $oldBranch = MRideitem::findOrFail($branchId);
                        $oldBranch->name = $valueBranch;
                        if ($oldBranch->type != $request['subbranch_type'][$idxCategory][$keyBranch]) {
                            $oldBranch->type = $request['subbranch_type'][$idxCategory][$keyBranch];
                            if ($request['subbranch_type'][$idxCategory][$keyBranch] == 2) {
                                $oldBranch->banner = '';
                                $oldBranch->content = '';
                            } else {
                                //delete item
                                MRideitemDetail::where('gcr_category_item_id', $branchId)->delete();
                            }
                        }
                        if (isset($request['subbranch_cover'][$idxCategory][$keyBranch])) {
                            $newCoverPath = Util::updateFile($oldBranch->cover, $request['subbranch_cover'][$idxCategory][$keyBranch], 'game_center_category_cover_image');
                            $oldBranch->cover = $newCoverPath;
                        }
                        if ($oldBranch->type == 1) {
                            $oldBranch->content = $request['subbranch_content'][$idxCategory][$keyBranch];
                            if (isset($request['subbranch_banner'][$idxCategory][$keyBranch])) {
                                $branchPath = Util::updateFile($oldBranch->banner, $request['subbranch_banner'][$idxCategory][$keyBranch], 'game_center_category_banner_image');
                                $oldBranch->banner = $branchPath;
                            }
                        }
                        $type = $oldBranch->type;
                        $oldBranch->save();
                    }
                    if ($type == 2) {
                        $idxItem = $request['key_id'][$idxCategory][$keyBranch];
                        foreach ($request['sub_category_multi_title'][$idxCategory][$idxItem] as $keyItem => $titleItem) {
                            $itemId = $request['sub_category_multi_id'][$idxCategory][$idxItem][$keyItem];
                            if ($itemId == -1) {
                                $item['game_center_id'] = $gcId;
                                $item['gcr_category_id'] = $rId;
                                $item['gcr_category_item_id'] = $branchId;
                                $item['name'] = $titleItem;
                                $itemImagePath = Util::storeFile($request['sub_category_multi_banner'][$idxCategory][$idxItem][$keyItem], 'game_center_category_item_image');
                                $item['image'] = $itemImagePath;
                                $item['content'] = $request['sub_category_multi_content'][$idxCategory][$idxItem][$keyItem];
                                MRideitemDetail::create($item);
                            } else {
                                $oldItem = MRideitemDetail::findOrFail($itemId);
                                $oldItem->name = $titleItem;
                                if (isset($request['sub_category_multi_banner'][$idxCategory][$idxItem][$keyItem])) {
                                    $branchPath = Util::updateFile($oldItem->image, $request['sub_category_multi_banner'][$idxCategory][$idxItem][$keyItem], 'game_center_category_item_image');
                                    $oldItem->image = $branchPath;
                                }
                                $oldItem->content = $request['sub_category_multi_content'][$idxCategory][$idxItem][$keyItem];
                                $oldItem->save();
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            dd($e);
            report($e);
            return redirect("/mridecategory")->with('failed', 'Failed update data.');
        }

        return redirect("/mridecategory")->with('success', 'Success update data.');
    }

    public
    function ajaxData(Request $request)
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

    public
    function webEdit($id)
    {
        try {
            $data = MGamecenter::findOrFail($id);
            return view('master.mridecategory_create', compact('data'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mridecategory")->with('failed', 'Data Not found');
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
