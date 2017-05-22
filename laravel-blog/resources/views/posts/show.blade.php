@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                  {{$post->title}}
                  {!! form($form) !!}
                  <a class="btn btn-primary pull-right" href="/posts/{{$post->id}}/edit">
                    Edit
                  </a>
                </div>
                <div class="panel-body">
                    <p>
                        {{$post->content}}
                    </p>
                    <p>
                        Written by {{$post->user->name}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
