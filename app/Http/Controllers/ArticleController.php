<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Article;

class ArticleController extends Controller
{
  public function index()
  {
      return Article::all();
  }

  public function show($id)
  {
      return Article::find($id);
  }

  public function store(Request $request)
  {

      $data=json_decode($request->getContent(), true);

      foreach ($data as $key => $value) {
        Article::create($data[$key]);
      }
      

      return 201;//Article::create($data);
  }

  public function update(Request $request, $id)
  {
      $article = Article::findOrFail($id);
      $article->update($request->all());

      return $article;
  }

  public function delete(Request $request, $id)
  {
      $article = Article::findOrFail($id);
      $article->delete();

      return 204;
  }
}
