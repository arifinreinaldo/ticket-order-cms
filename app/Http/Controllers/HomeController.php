<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $accesses = DB::table('menu_role as mr')
            ->select('mr.menu_id', 'mr.read_access', 'mr.create_access', 'mr.delete_access', 'mr.update_access', 'm.menu', 'm.alias')
            ->join('menu as m', 'mr.menu_id', 'm.id')
            ->where('user_role_id', '=', Auth::user()->role)
            ->get();
        session(['menu' => $accesses]);

//        $api = env('TRANS_API', '');
//        $key = env('INTERFACE_KEY', '');
//        $MerchantCodebekasi = "S2019031810004";
//        $TimeStamp = time();
//        $signatureKeybekasi = strtoupper(md5($MerchantCodebekasi . $key . $TimeStamp));
//
//        $client = new Client(['base_uri' => $api]);
//        $response = $client->request('GET', 'GetProducts',
//            ['query' => ['MerchantCode' => $MerchantCodebekasi, 'TimeStamp' => $TimeStamp, 'Sign' => $signatureKeybekasi]]);
//        $content = $response->getBody()->getContents();
//        $object = json_decode($content);
//        dd($object);
//        if ($object->IsTrue) {
//            $json = json_decode($object->ResultJson);
//            dd($json);
//        }
//
//        $json = "[{\"ShelvesId\":15305,\"ProductId\":3173,\"LineProCode\":\"4092\",\"ProductName\":\"CHILD TICKET\",\"ProductTypeId\":3963,\"ProductTypeName\":\"Demo Product\",\"ProductSellPrice\":2.0,\"ProductIntroduction\":\"\u003cp\u003eChild Ticket\u003cbr/\u003e\u003c/p\u003e\",\"UsageMethod\":\"\u003cp\u003eChild Ticket \u003cbr/\u003e\u003c/p\u003e\u003cp\u003e1x Entry (3-12 Years Old)\u003cbr/\u003e\u003c/p\u003e\"}]";
//
//        dd(json_decode($json));

        return view('home');
    }

    public function noauth()
    {
        return view('noauth');
    }
}
