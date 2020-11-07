@extends('layouts.base')

@section('content')
<div class="container mt-5">
    <table class="table table-bordered mb-5">
        <thead>
            <tr class="table-success">
                <th scope="col">#</th>
                <th scope="col">Author</th>
                <th scope="col">Title</th>
                <th scope="col">Counts</th>
                <th scope="col">Updated at</th>
                <th scope="col">Created at</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach($posts as $data)
            <tr>
                <th scope="row">{{ $data->id }}</th>
                <td>{{ $data->user->name }}</td>
                <td>{{ $data->title }}</td>
                <td>{{ $data->counts ?? 0 }}</td>
                <td>{{ $data->updated_at }}</td>
                <td>{{ $data->created_at }}</td>
                <td>
                    <div class="btn-group pull-right">
                        <a href="{{ route('post.show', $data->id) }}" class="btn btn-primary show mr-2">Read</a>
                        <a href="{{ route('post.edit', $data->id) }}" class="btn btn-warning edit">Edit</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {!! $posts->links() !!}
    </div>
</div>
@endsection