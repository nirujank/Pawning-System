<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Yajra\DataTables\DataTables;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $articles = Article::all();
        return view('article.index', compact('articles'));


    }

    public function fetchArticles()
    {
        $articles = Article::all();
        return response()->json([
            'articles' => $articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $article = new Article();
            $article->name = $request->name;
            $article->description = $request->description;
            $article->save();
            return response()->json([
                'status' => 200,
                'message' => 'Article Added Succesfully',
                'data' => $article,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::find($id);
        if ($article) {
            return response()->json([
                'status' => 200,
                'message' => 'Article Edited Succesfully',
                'data' => $article,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Error',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $article->name = $request->name;
        $article->description = $request->description;
        $article->save();
        return response()->json([
            'status' => 200,
            'message' => 'Article Updated Succesfully',
            'data' => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Article Deleted Succesfully',
            'data' => $article,
        ]);
    }
}
