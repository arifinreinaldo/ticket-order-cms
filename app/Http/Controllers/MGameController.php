<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\MGame;
use DataTables;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MGameController extends Controller
{
    public function index()
    {
        $mgames = MGame::latest()->get();

        return response()->json($mgames);
    }

    public function store(MGameRequest $request)
    {
        $mgame = MGame::create($request->all());

        return response()->json($mgame, 201);
    }

    public function show($id)
    {
        $mgame = MGame::findOrFail($id);

        return response()->json($mgame);
    }

    public function update(MGameRequest $request, $id)
    {
        $mgame = MGame::findOrFail($id);
        $mgame->update($request->all());

        return response()->json($mgame, 200);
    }

    public function destroy($id)
    {
        MGame::destroy($id);

        return response()->json(null, 204);
    }

    //web function
    public function webIndex()
    {
        return view('master.mgame');
    }

    public function webCreate()
    {
        $size = MGame::all()->count() + 1;
        return view('master.mgame_create', compact('size'));
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([
            'title' => 'required|unique:games',
            'order' => 'required',
            'link' => 'required|url',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:1024'
        ]);
        //|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000
        $imagePath = UtilHelper::store(request('image'), 'constant.game_image');
//        $imagePath = request('image')->store(config('constant.game_image'), 'public');
        unset($data['image']);
        $data['image'] = $imagePath;
        $data['status'] = '1';
        try {
            MGame::where('order', '>=', $data['order'])
                ->update(['order' => DB::raw('"order" + 1')]);
        } catch (QueryException $ex) {
            report($ex);
        }
        try {
            $mgames = MGame::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/mgame")->with('failed', 'Failed insert data.');
        }
        return redirect("/mgame")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mgames = MGame::findOrFail($id);

        return response()->json($mgames);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'title' => 'required',
            'link' => 'required|url',
            'order' => 'required',
        ]);

        try {
            $oldData = MGame::findOrFail($data['id']);
            $oldData->title = $data['title'];
            $oldData->link = $data['link'];

//            $imagePath = request('image')->store(config('constant.game_image'), 'public');
//            unset($data['image']);
//            $data['image'] = $imagePath;
            if ($request['image']) {
                Storage::delete("public/" . $oldData->image);
                $imagePath = request('image')->store(config('constant.game_image'), 'public');
                unset($data['image']);
                $oldData->image = $imagePath;
            }
            if ($data['order'] != $oldData->order) {
                try {
                    MGame::where('order', '>', $oldData->order)
                        ->update(['order' => DB::raw('"order" - 1')]);
                    MGame::where('order', '>=', $data['order'])
                        ->update(['order' => DB::raw('"order" + 1')]);
                } catch (QueryException $ex) {
                    report($ex);
                }
                $oldData->order = $data['order'];
            }
            $oldData->save();
        } catch (Exception $e) {
            return redirect("/mgame")->with('failed', 'Failed update data.');
        }
        return redirect("/mgame")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
//        $results = DB::table('games AS u')
//            ->join('status AS s', 'u.status', '=', 's.id');
        $results = MGame::select('u.id as id_game', 'title', 'image', 'order', 'name')->from('games as u')->join('status AS s', 'u.status', '=', 's.id');

        if ($request->ajax()) {
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn("checkbox", function ($row) {
                    $btn = "";
                    $btn .= "<input type='checkbox' class='check-control' userid='$row->id_game'/>";
                    return $btn;
                })
                ->escapeColumns('checkbox')
                ->editColumn("title", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id_game'>$row->title</span>";
                })
                ->escapeColumns('title')
                ->editColumn("image", function ($row) {
                    $url = $row->getImage();
                    return "<img class='img-fluid img-thumbnail' src='$url'/>";
                })
                ->escapeColumns('image')
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MGame::findOrFail($id);
            $size = MGame::all()->count();
            return view('master.mgame_create', compact('data', 'size'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mgame")->with('failed', 'Data Not found');
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
            $rst = MGame::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mgame")->with('success', 'Game(s) has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mgame")->with('success', 'Game(s) has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mgame")->with('failed', 'Failed to update role user(s)');
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
                $data = MGame::findOrFail($id);
                try {
                    MGame::destroy($id);
                    MGame::where('order', '>=', $data->order)
                        ->update(['order' => DB::raw('"order" - 1')]);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/mgame")->with('success', 'Game(s) has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mgame")->with('failed', 'Failed to delete role(s)');
        }
    }
}
