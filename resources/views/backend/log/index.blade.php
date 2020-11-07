@extends('layouts.base')

@section('content')
<div class="container mt-5">
    <table class="table table-bordered mb-5">
        <thead>
            <tr class="table-success">
                <th scope="col">#</th>
                <th scope="col">Action</th>
                <th scope="col">User</th>
                <th scope="col">Target</th>
                <th scope="col">Target Id</th>
                <th scope="col">IP</th>
                <th scope="col">User Agent</th>
                <th scope="col">Header</th>
                <th scope="col">Created at</th>

            </tr>
        </thead>
        <tbody>
            @foreach($logs as $data)
            <tr>
                <th scope="row">{{ $data->id }}</th>
                <td>{{ $data->action }}</td>
                <td>{{ $data->user->email ?: '' }}</td>
                <td>{{ $data->target }}</td>
                <td>{{ $data->loggable_id }}</td>
                <td>{{ $data->ip }}</td>
                <td>{{ $data->user_agent }}</td>
                <td>{{ $data->header }}</td>
                <td>{{ $data->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {!! $logs->links() !!}
    </div>
</div>
@endsection