@extends('layouts.app')

@section('content')
    <h1>Create a project</h1>
    <form method="POST" action="/projects">
        @csrf
        <div class="form-group">
            <label for="title" class="col-sm-1-12 col-form-label">Title</label>
            <div class="col-sm-1-12">
                <input type="text"
                       class="form-control" name="title" id="title" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-primary">Add</button>
                <a href="/projects">Cancel</a>
            </div>
        </div>
    </form>


@endsection