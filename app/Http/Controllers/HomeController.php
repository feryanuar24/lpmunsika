<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render("Home/Index", [
            "categories" => Category::get(),
            "articles" => Article::where("is_active", 1)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(3),
            "berita" => Article::where("category_id", 1)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(3),
            "buletin" => Article::where("category_id", 2)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(3),
            "karyaMahasiswa" => Article::where("category_id", 3)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(3),
            "opini" => Article::where("category_id", 4)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(3),
            'canLogin' => Route::has('login'),
            // 'canRegister' => Route::has('register'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $search = $request->search;

        Article::where("slug", $slug)->increment("views", 1);

        return Inertia::render("Home/Show", [
            "slug" => $slug,
            "categories" => Category::get(),
            "article" => Article::where("slug", $slug)->with(["user:id,name", "category:id,slug,category_name"])->first(),
            "articles" => Article::with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "berita" => Article::where("category_id", 1)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "buletin" => Article::where("category_id", 2)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "karyaMahasiswa" => Article::where("category_id", 3)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "gayaMahasiswa" => Article::where("category_id", 4)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "resensiBuku" => Article::where("category_id", 5)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "reviewFilm" => Article::where("category_id", 6)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "opini" => Article::where("category_id", 7)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "esai" => Article::where("category_id", 8)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "puisi" => Article::where("category_id", 9)->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->paginate(10),
            "search" => Article::where("body", "like", "%" . $search . "%")->with(["user:id,name", "category:id,slug,category_name"])->orderBy("id", "DESC")->get(),
            "request" => $search

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        //
    }
}
