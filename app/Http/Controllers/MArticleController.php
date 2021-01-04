<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\MArticle;
use Carbon\Carbon;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MArticleController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.marticle');
    }

    public function webCreate()
    {
        $size = MArticle::all()->count() + 1;
        return view('master.marticle_create', compact('size'));
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:1024',
            'banner' => 'required|image|mimes:jpg,png,jpeg|max:1024',
            'content' => 'required|max:3000',
        ]);

        try {
            $data['status'] = '1';
            $imagePath = Util::storeFile(request('image'), 'article_image');
            $bannerPath = Util::storeFile(request('banner'), 'article_banner_image');
            unset($data['image']);
            unset($data['banner']);
            $data['banner'] = $bannerPath;
            $data['image'] = $imagePath;
            $marticles = MArticle::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/marticle")->with('failed', 'Failed insert data . ');
        }
        return redirect("/marticle")->with('success', 'Success insert data . ');
    }

    public function webShow($id)
    {

        $marticles = MArticle::findOrFail($id);

        return response()->json($marticles);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
            'content' => 'required|max:3000',
        ]);

        try {
            $oldData = MArticle::findOrFail($data['id']);
            $oldData->title = $data['title'];
            $oldData->content = $data['content'];
            if ($request['image']) {
                $imagePath = Util::updateFile($oldData->image, request('image'), 'article_image');
                unset($data['image']);
                $oldData->image = $imagePath;
            }
            if ($request['banner']) {
                $bannerPath = Util::updateFile($oldData->image, request('banner'), 'article_banner_image');
                unset($data['banner']);
                $oldData->banner = $bannerPath;
            }
            $oldData->save();
        } catch (Exception $e) {
            report($e);
            return redirect("/marticle")->with('failed', 'Failed update data . ');
        }
        return redirect("/marticle")->with('success', 'Success update data . ');
    }

    public function ajaxData(Request $request)
    {
        $results = MArticle::select("u.id as id_data", 'u.title', 'u.status', 'u.updated_at', 's.name')
            ->from('articles as u')
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
                ->editColumn("updated_at", function ($row) {
                    return Carbon::parse($row->updated_at)->format('d / m / y');
                })
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MArticle::findOrFail($id);
            $size = MArticle::all()->count();
            return view('master.marticle_create', compact('data', 'size'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/marticle")->with('failed', 'Data Not found');
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
            $rst = MArticle::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/marticle")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/marticle")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/marticle")->with('failed', 'Failed to update role user(s)');
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
                $data = MArticle::findOrFail($id);
                try {
                    Util::deleteFile($data->image);
                    Util::deleteFile($data->banner);
                    MArticle::destroy($id);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/marticle")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/marticle")->with('failed', 'Failed to delete role(s)');
        }
    }
}
