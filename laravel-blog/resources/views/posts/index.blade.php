@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/" method="get" style="margin-bottom: 10px;">
        <input class="col-xs-6" type="text" name="search" placeholder="Search by content..." value="{{app('request')->input('search')}}">
        <input class="col-xs-6" type="text" name="tag" placeholder="Search by tag..." value="{{app('request')->input('tag')}}">
        <input type="submit" style="margin-top:10px;" class="btn btn-primary">
    </form>
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
