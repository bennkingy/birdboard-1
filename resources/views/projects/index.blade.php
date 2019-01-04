@extends('layouts.app')

@section('content')

        <div class="flex itens-center">
            <h1 class="mr-auto mb-3">Projects</h1>
            <a href="/projects/create">Create new</a>
        </div>
        <ul>
            @forelse($projects as $project)
                <li><a href="{{ $project->path() }}">{{ $project->title }}</a></li>
            @empty
                <li>No projects</li>
            @endforelse
        </ul>

    </div>

@endsection