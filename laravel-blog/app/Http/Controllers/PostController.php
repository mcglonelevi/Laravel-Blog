<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Kris\LaravelFormBuilder\FormBuilder;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at')->get();
        return view('posts.index', compact('posts'));
    }

    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\PostCreateForm::class, [
          'method' => 'POST',
          'url' => 'posts'
        ]);
        return view('posts.create', compact('form'));
    }

    public function store(Request $request)
    {
        $post = new Post();
        $post->fill($request->input());
        $post->user_id = $request->input('user_id');
        $post->save();
        return redirect()->route('posts.show', ['id' => $post->id]);
    }

    public function show(FormBuilder $formBuilder, Request $request, $id)
    {
        $form = $formBuilder->create(\App\Forms\PostDeleteForm::class, [
          'method' => 'delete',
          'url' => 'posts/' . $id,
          'class' => 'pull-right'
        ]);
        $post = Post::where('id', $id)->first();
        return view('posts.show', compact('post', 'form'));
    }

    public function edit(FormBuilder $formBuilder, $id)
    {
        $post = Post::where('id', $id)->first();
        $form = $formBuilder->create(\App\Forms\PostEditForm::class, [
          'method' => 'PUT',
          'url' => 'posts/' . $id,
          'model' => $post
        ]);

        return view('posts.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)->first();
        $post->fill($request->input());
        $post->save();
        return view('posts.show', compact('post'));
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::where('id', $id)->first();
        Post::destroy($id);
        return redirect('/');
    }
}
