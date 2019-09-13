<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
//        getting all articles
        $articles = Article::paginate(15);

//        returning all articles as a collection
        return  ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Article $article
     * @return ArticleResource
     */
    public function store(Request $request, Article $article)
    {
//        validating the request
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:5'
        ]);

//        setting the article model fields
        $article->title = $attributes['title'];
        $article->body = $attributes['body'];

        if ($article->save()) {
            return new ArticleResource($article);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ArticleResource
     */
    public function show($id)
    {
//        getting the article
        $article = Article::findOrFail($id);

//        returning the article as a resource
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Article $article
     * @return ArticleResource
     */
    public function update(Request $request, $id)
    {
//        validating the request
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:5'
        ]);

//        finding the model
        $article = Article::findOrFail($id);

//      updating the article model
        $article->title = $attributes['title'];
        $article->body = $attributes['body'];

//        saving and returning the model as a resource
        if ( $article->save() ) {
            return new ArticleResource($article);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
