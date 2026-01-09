@extends('layouts.main')

@section('content')
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="mb-4 text-center">Add New Song</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form method="POST" action="/songs">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Song Name</label>
                            <input type="text" name="songname" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Genre</label>
                            <input type="text" name="genre" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Add Song</button>
                            <a href="/playlists" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                    
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
