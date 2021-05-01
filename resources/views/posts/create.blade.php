@extends('layouts.app', ['title' => 'New post'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">New post</div>
                    <div class="card-body">
                        <form action="/posts/store" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('posts.partials.form-contol', ['submit' => 'Create'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
