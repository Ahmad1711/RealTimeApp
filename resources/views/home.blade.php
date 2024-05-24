@extends('layouts.app')

@section('content')
<div class="container">
    @if(Session::has('success'))
    <div class="col-6 alert alert-success">
        {{Session::get('success')}}
    </div>
    @endif
    <div class="row justify-content-center">
        @php
        $posts=App\Models\Post::all();
        @endphp
        @foreach($posts as $post)
        <div class="col-md-8 mt-1">
            <div class="card">
                <div class="card-header">
                    <h1>{{$post->title}}</h1>
                </div>
                <div class="card-body">
                    {{$post->content}}
                </div>
                <div class="card-footer">
                    @if($post->user_id!=Auth::user()->id)
                    <form method="post" action="{{route('comment.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <input type="text" class="form-control" name="content" placeholder="Write Comment">
                                @error('comment')
                                <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                    @else
                    @foreach($post->comments as $comment)
                    <div class="card-header">
                        <h4>{{$comment->user->name}}</h4>
                    </div>
                    <div class="card-body">
                        <p>{{$comment->content}}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection