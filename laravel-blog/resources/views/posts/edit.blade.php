@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Update Post</div>
                <div class="panel-body">
                    {!! form($form) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
