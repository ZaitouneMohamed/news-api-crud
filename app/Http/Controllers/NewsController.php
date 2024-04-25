<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsColection;
use App\Http\Resources\NewsResource;
use App\Models\Categorie;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::GetData();
        return response()->json($news);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'date_start' => 'required|date',
            'date_expiration' => 'required|date|after:date_start|after:today',
        ]);

        $new = News::create($validatedData);
        return response()->json([
            'message' => "data added with success",
            'news' => $new
        ], 201);
    }
    public function show(News $news)
    {
        if ($news->date_expiration <= now()) {
            return response()->json([
                "message" => "this news is expired",
                "status" => 404
            ]);
        }
        return response()->json($news, 200);
    }
    public function update(Request $request, News $news)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'date_start' => 'required|date',
            'date_expiration' => 'required|date|after_or_equal:date_start',
        ]);

        $news->update($validatedData);
        return response()->json([
            'message' => "data update with success",
            'news' => $news
        ], 201);
    }

    public function destroy(News $news)
    {
        $news->delete();
        return response()->json([
            'message' => "the selected new delete with success",
        ], 204);
    }

    public function searchByCategory($category_name)
    {

        $news = Categorie::getNewsByCategory($category_name);

        if (!$news) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json($news);
    }
}
