<?php

namespace App\Http\Controllers;

use App\MArticle;
use DataTables;
use Exception;

class MArticleController extends Controller
{
    public function index()
    {
        $marticles = MArticle::latest()->get();

        return response()->json($marticles);
    }

    public function store(MArticleRequest $request)
    {
        $marticle = MArticle::create($request->all());

        return response()->json($marticle, 201);
    }

    public function show($id)
    {
        $marticle = MArticle::findOrFail($id);

        return response()->json($marticle);
    }

    public function update(MArticleRequest $request, $id)
    {
        $marticle = MArticle::findOrFail($id);
        $marticle->update($request->all());

        return response()->json($marticle, 200);
    }

    public function destroy($id)
    {
        MArticle::destroy($id);

        return response()->json(null, 204);
    }

    //web function
    public function webIndex()
    {
        $user = auth()->user();
        $marticles = MArticle::where('id', '>', '0')->paginate(10);
        return view('master.marticle', compact('marticles','user'));
    }

    public function webStore(MArticleRequest $request)
    {
        $data = request()->validate([

        ]);

        try{
            $marticles = MArticle::create($request->all());
        }catch(Exception $e){
            report($e);
            return redirect("/marticle")->with('failed','Failed insert data.');
        }
        return redirect("/marticle")->with('success','Success insert data.');
    }

    public function webShow($id)
    {

        $marticles = MArticle::findOrFail($id);

        return response()->json($marticles);
    }

    public function webUpdate(MArticleRequest $request, $id)
    {
        $data = request()->validate([

        ]);

        try{
            $marticles = MArticle::findOrFail($id);
            $marticles->update($request->all());
        }catch(Exception $e){
            report($e);
            return redirect("/marticle")->with('failed','Failed update data.');
        }
        return redirect("/marticle")->with('success','Success update data.');
    }

    public function webDestroy($id)
    {
        try{
            MArticle::destroy($id);
        }catch(Exception $e){
            report($e);
            return redirect("/marticle")->with('failed','Failed delete data.');
        }
        return redirect("/marticle")->with('success','Success delete data.');
    }
}
