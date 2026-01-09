@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
    body {
        color: #566787;
        background: #f5f5f5;
        font-family: 'Varela Round', sans-serif;
        font-size: 13px;
    }
    .form-wrapper {
        background: #fff;
        padding: 20px 25px;
        margin: 50px auto;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
        max-width: 500px;
    }
    h2 {
        color: #435d7d;
        font-size: 24px;
        margin-bottom: 20px;
    }
    .btn {
        border-radius: 2px;
        min-width: 100px;
    }
    .btn-success { background-color: #03A9F4; border-color: #03A9F4; }
    .btn-success:hover { background-color: #0397d6; border-color: #0397d6; }
    .btn-secondary { background-color: #566787; border-color: #566787; color: #fff; }
    .btn-secondary:hover { background-color: #435d7d; border-color: #435d7d; }
    .form-control {
        border-radius: 2px;
        box-shadow: none;
        border-color: #dddddd;
    }
    label {
        font-weight: normal;
    }
</style>

<div class="form-wrapper">
    <h2 class="text-center">Add New Song</h2>
    <form method="POST" action="{{ route('songs.store') }}">
        @csrf
        <div class="form-group">
            <label>Song Name</label>
            <input type="text" name="songname" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Genre</label>
            <input type="text" name="genre" class="form-control" required>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Add Song</button>
            <a href="{{ route('playlists.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
