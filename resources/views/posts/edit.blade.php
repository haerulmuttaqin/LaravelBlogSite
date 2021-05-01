@extends('layouts.app', ['title' => 'Update post'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Update post : {{ $post->title }}</div>
                    <div class="card-body">
                        <form action="/posts/{{ $post->slug }}/edit" method="post" autocomplete="off" enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            @include('posts.partials.form-contol')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
