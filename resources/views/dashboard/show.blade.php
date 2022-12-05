@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                @if($errors->any())
                <h4 style="color: green">{{$errors->first()}}</h4>
                @endif
                @if ($post->active == 0)
                <h1 class="display-one">{{ ucfirst($post->title) }}</h1>
                <p>{!! $post->content !!}</p>
                <img src="/storage/images/{{ $post->image }}" height="360px">
                <hr>
                <br><br>
                <div class="container">
                    <div class="row">
                        <div class="panel panel-default widget">
                            <div class="panel-heading">
                                <span class="glyphicon glyphicon-comment"></span>
                                <h3 class="panel-title">Recent Comments <span style="color: green">{{ count($comment) }}</span> </h3>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                    @forelse($comment as $comments)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-xs-10 col-md-11">
                                                <div>
                                                    <h5 href="">{{ $comments->comment }}</h5>
                                                    <div class="mic-info">
                                                        By:  <a href="#">{{ $comments->name }}</a> {{ $comments->created_comments }}
                                                    </div>
                                                </div>
                                                <div class="action">
                                                    <form id="add-comment" class="" action="{{ route('delete-comment') }}" method="POST">
                                                        @csrf
                                                        <input name="comment_id" value="{{ $comments->commentId}}" hidden>
                                                    <button  class="btn btn-danger btn-xs" title="Delete"> Delete </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @empty
                                        <p class="text-warning">No comment Posts available</p>
                                    @endforelse

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="add-comment" class="" action="{{ route('add-comment') }}" method="POST">
                    @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">comment</label>
                    <input name="user_id" value="{{ Auth::user()->id}}" hidden>
                    <input name="post_id" value="{{ $post->id}}" hidden>
                    <textarea name="comment" class="form-control" placeholder="plasse enter Comment" required=""></textarea>
                    <button class="btn btn-primary" style="margin-bottom: 3%; margin-top:3%">add comment</button>
                    </div>
                </form>

                <form id="delete-post" class="" action="{{ route('delete-post') }}" method="POST">
                    @csrf
                    <input name="post_id" value="{{ $post->id}}" hidden>
                    <button class="btn btn-danger">Delete Post</button>
                </form>
            </div>
            @endif
            <div class="col-12 pt-2">
                @if ($post->active == 1)
                <p class="text-warning">Posts Not available</p>
                @endif
                <a href="/blog/post" class="btn btn-outline-primary btn-sm">Go back</a>
           </div>
        </div>
    </div>
@endsection
