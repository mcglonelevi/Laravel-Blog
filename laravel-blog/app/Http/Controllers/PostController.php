<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\PostTag;
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
        $this->middleware('auth')->except('show', 'index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('created_at');
        if ($request->input('search')) {
            $posts->where('content', 'LIKE', '%' . $request->input('search') . '%');
        }
        if ($request->input('tag')) {
            $posts->with('tags')->whereHas('tags', function ($q) use ($request) {
              $q->where('title', $request->input('tag'));
            });
        }
        $posts = $posts->get();
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

        //logic to sync tags
        $tags = $request->input('tags');
        $tags = explode(",", $tags);
        $tags = array_map(function ($t) {
            return trim($t);
        }, $tags);

        foreach ($tags as $t) {
            $tagRow = Tag::firstOrCreate(['title' => $t]);
            if (!PostTag::where('tag_id', $tagRow->id)->where('post_id', $post->id)->first()) {
                $postTag = new PostTag();
                $postTag->post_id = $post->id;
                $postTag->tag_id = $tagRow->id;
                $postTag->save();
            }
        }
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

    public function update(FormBuilder $formBuilder, Request $request, $id)
    {

        $form = $formBuilder->create(\App\Forms\PostDeleteForm::class, [
          'method' => 'delete',
          'url' => 'posts/' . $id,
          'class' => 'pull-right'
        ]);

        $post = Post::where('id', $id)->first();
        $post->content = $request->input('content');
        $post->title = $request->input('title');

        //logic to sync tags
        $tags = $request->input('tags');
        $tags = explode(",", $tags);
        $tags = array_map(function ($t) {
            return trim($t);
        }, $tags);

        $currTags = $post->tags->pluck('title')->toArray();

        $diffTags = array_diff($currTags, $tags);

        foreach ($diffTags as $dt) {
            $dtf = Tag::where('title', $dt)->first();
            $pt = PostTag::where('post_id', $id)->where('tag_id', $dtf->id)->first();
            PostTag::destroy($pt->id);
        }

        foreach ($tags as $t) {
            $tagRow = Tag::firstOrCreate(['title' => $t]);
            if (!PostTag::where('tag_id', $tagRow->id)->where('post_id', $id)->first()) {
                $postTag = new PostTag();
                $postTag->post_id = $id;
                $postTag->tag_id = $tagRow->id;
                $postTag->save();
            }
        }

        $post->save();
        $post = Post::find($id);
        return view('posts.show', compact('post', 'form'));
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::where('id', $id)->first();
        $postTags = PostTag::where('post_id', $id)->get();
        PostTag::destroy($postTags->pluck('id')->toArray());
        Post::destroy($id);
        return redirect('/');
    }
}
