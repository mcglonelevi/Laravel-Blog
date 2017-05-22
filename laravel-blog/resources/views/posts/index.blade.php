@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            @foreach ($posts as $post)
            <div class="panel panel-default">
                <div class="panel-heading">
                  <a href="/posts/{{$post->id}}">
                    {{$post->title}}
                  </a>
                </div>
                <div class="panel-body">
                    {{$post->content}}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
