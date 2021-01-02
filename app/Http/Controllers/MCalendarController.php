<?php

namespace App\Http\Controllers;

use App\Helpers\Util;
use App\MCalendar;
use Carbon\Carbon;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MCalendarController extends Controller
{
    //web function
    public function webIndex()
    {
        return view('master.mcalendar');
    }

    public function webCreate()
    {
        return view('master.mcalendar_create');
    }

    public function webStore(Request $request)
    {
        $data = request()->validate([
            'event_title' => 'required',
            'event_cover_image' => 'required|image|mimes:jpg,png,jpeg|max:1024',
            'event_banner_image' => 'required|image|mimes:jpg,png,jpeg|max:1024',
            'event_content' => 'required|max:3000',
        ]);

        $imagePath = Util::storeFile(request('event_cover_image'), 'event_cover_image');
        unset($data['event_cover_image']);
        $data['event_cover_image'] = $imagePath;

        $imageBanner = Util::storeFile(request('event_banner_image'), 'event_banner_image');
        unset($data['event_banner_image']);
        $data['event_banner_image'] = $imageBanner;

        $data['status'] = '1';
        try {
            $mcalendars = MCalendar::create($data);
        } catch (Exception $e) {
            report($e);
            return redirect("/mcalendar")->with('failed', 'Failed insert data.');
        }
        return redirect("/mcalendar")->with('success', 'Success insert data.');
    }

    public function webShow($id)
    {

        $mcalendars = MCalendar::findOrFail($id);

        return response()->json($mcalendars);
    }

    public function webUpdate(Request $request)
    {
        $data = request()->validate([
            'id' => 'required',
            'event_title' => 'required',
            'event_content' => 'required|max:3000',
        ]);
        try {
            $oldData = MCalendar::findOrFail($data['id']);
            $oldData->event_title = $data['event_title'];
            $oldData->event_content = $data['event_content'];
            if ($request['event_cover_image']) {
                $imagePath = Util::updateFile($oldData->event_cover_image, request('event_cover_image'), 'event_cover_image');
                unset($data['event_cover_image']);
                $oldData->event_cover_image = $imagePath;
            }
            if ($request['event_banner_image']) {
                $imagePath = Util::updateFile($oldData->event_banner_image, request('event_banner_image'), 'event_banner_image');
                unset($data['event_banner_image']);
                $oldData->event_banner_image = $imagePath;
            }
            $oldData->save();
        } catch (Exception $e) {
            report($e);
            dd($e);
            return redirect("/mcalendar")->with('failed', 'Failed update data.');
        }
        return redirect("/mcalendar")->with('success', 'Success update data.');
    }

    public function ajaxData(Request $request)
    {
        $results = MCalendar::select("u.id as id_data", 'u.event_title', 'u.event_cover_image', 'u.event_banner_image', 'u.updated_at', 's.name')
            ->from('events as u')
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
                ->editColumn("event_title", function ($row) {
                    return "<span class='btn-edit text-c-blue pointer' userid='$row->id_data'>$row->event_title</span>";
                })
                ->escapeColumns('event_title')
                ->editColumn("updated_at", function ($row) {
                    return Carbon::parse($row->updated_at)->format('d / m / y');
                })
                ->make(true);
        }
    }

    public function webEdit($id)
    {
        try {
            $data = MCalendar::findOrFail($id);
            $size = MCalendar::all()->count();
            return view('master.mcalendar_create', compact('data'));
        } catch (ModelNotFoundException $ex) {
            report($ex);
            return redirect("/mcalendar")->with('failed', 'Data Not found');
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
            $rst = MCalendar::whereIn('id', $ids)->get();
            foreach ($rst as $item) {
                $item->status = $request['state'];
                $item->save();
            }
            if ($request['state'] == '1') {
                return redirect("/mcalendar")->with('success', 'Data has been activated');
            } else if ($request['state'] == '2') {
                return redirect("/mcalendar")->with('success', 'Data has been deactivated');
            }

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mcalendar")->with('failed', 'Failed to update role user(s)');
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
                $data = MCalendar::findOrFail($id);
                try {
                    Util::deleteFile($data->event_cover_image);
                    Util::deleteFile($data->event_banner_image);
                    MCalendar::destroy($id);
                } catch (QueryException $ex) {
                    report($ex);
                }
            }
            return redirect("/mcalendar")->with('success', 'Data has been deleted');

        } catch (\Exception $exception) {
            report($exception);
            return redirect("/mcalendar")->with('failed', 'Failed to delete data');
        }
    }
}
