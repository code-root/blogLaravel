@extends('layouts.app')
    @section('content')
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div class="container">
        <div class="card">
            <div class="card-header text-center font-weight-bold">
            Add Post Blog
            </div>
            <div class="card-body">
                <form action="{{ route('add-post-blog') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <input type="text" id="title" name="title" class="form-control" required=""></div>
                <div class="form-group">
                <label for="exampleInputEmail1">content</label>
                <textarea name="content" class="form-control" required=""></textarea></div>
                <div class="col-md-6"><input type="file" name="image" class="form-control"></div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            </div>
        </div>
    </div>
@endsection
