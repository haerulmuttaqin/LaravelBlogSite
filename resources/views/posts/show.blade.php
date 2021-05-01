@extends('layouts.app')
@section('title', 'The post')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if ($post->thumbnail)
                    <a href="{{ route('posts.show', $post->slug) }}">
                        <img style="height: 450px; object-fit: cover; object-position: center;"
                            src="{{ asset($post->thumbnailUrl) }}" alt="" class="card-img-top rounded w-100">
                    </a>
                @endif
                <div class="">
                    <h2>{{ $post->title }}</h2>
                </div>
                <div class="text-secondary mb-3">
                    <a href="/categories/{{ $post->category->slug }}">
                        {{ $post->category->name }}
                    </a>
                    &middot; {{ $post->created_at->format('d F, Y') }}
                    &middot;
                    @foreach ($post->tags as $tag)
                        <a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
                    @endforeach
                    <div class="media my-3">
                        <img width="60" src="{{ $post->author->gravatar() }}" class="rounded-circle mr-3">
                        <div class="media-body">
                            <div>{{ $post->author->name }}</div>
                            {{ '@' . $post->author->username }}
                        </div>
                    </div>
                </div>
                <p>{!! nl2br($post->body) !!}</p>
                <div class="mt-3">
                    @can('delete', $post)
                        <!-- Button trigger modal -->
                        <a href="/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-success">Edit</a>
                        <a type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Delete</a>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete this data?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <div>{{ $post->title }}</div>
                                            <small>
                                                <div class="text-muted">Published:
                                                    {{ $post->created_at->format('d F, Y') }}
                                                </div>
                                            </small>
                                        </div>
                                        <form action="/posts/{{ $post->slug }}/delete" method="post">
                                            @csrf
                                            @method('delete')
                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="col-md-4">
                @foreach ($posts as $post)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div>
                                <a href="{{ route('categories.show', $post->category->slug) }}" class="text-secondary">
                                    <small>{{ $post->category->name }} - </small>
                                </a>

                                @foreach ($post->tags as $tag)
                                    <a href="{{ route('tags.show', $tag->slug) }}" class="text-secondary">
                                        <small>{{ $tag->name }}</small>
                                    </a>
                                @endforeach
                            </div>

                            <h5>
                                <a class="card-title text-dark" href="{{ route('posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h5>

                            <div class="my-3">
                                {{ Str::limit($post->body, 100, '') }}
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="media align-items-center mt-3">
                                    <img width="30" src="{{ $post->author->gravatar() }}" class="rounded-circle mr-3">
                                    <div class="media-body">
                                        <div>{{ $post->author->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
