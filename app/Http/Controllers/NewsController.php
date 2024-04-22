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
        $news = News::paginate(15);
        return NewsColection::collection($news);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'date_start' => 'required|date',
            'date_expiration' => 'required|date|after_or_equal:date_start',
        ]);

        $new = News::create($validatedData);
        return response()->json([
            'message' => "data added with success",
            'news' => new NewsResource($new)
        ], 201);
    }
    public function show(News $news)
    {
        // try {
            // return response()->json(new NewsResource($news), 200);
            return response()->json($news, 200);
        // } catch (ModelNotFoundException $e) {
        //     $message = $e->getMessage();

        //     if (str_contains($message, 'No query results')) {
        //         return response()->json(['error' => 'News not found or has expired'], 404);
        //     }

        //     return response()->json(['error' => 'News not found'], 404);
        // }
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
            'news' => new NewsResource($news)
        ], 201);
    }

    public function destroy(News $news)
    {
        $news->delete();
        return response()->json("new delete with success", 204);
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
