@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="table-wrapper">
        <div class="table-title mb-3">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Songs</b></h2>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="/songs/create" class="btn btn-success">
                        Add New Song
                    </a>
                </div>
            </div>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Song Name</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($songs as $song)
                    <tr>
                        <td>{{ $song->songname }}</td>
                        <td>{{ $song->genre }}</td>
                        <td>
                            <button class="btn btn-info btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Your playlist is empty. Add your first song 
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
