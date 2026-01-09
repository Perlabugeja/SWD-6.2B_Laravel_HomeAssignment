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
    .table-wrapper {
        background: #fff;
        padding: 20px 25px;
        margin: 30px 0;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {        
        padding-bottom: 15px;
        background: #435d7d;
        color: #fff;
        padding: 16px 30px;
        margin: -20px -25px 10px;
        border-radius: 3px 3px 0 0;
    }
    .table-title h2 { font-size: 24px; margin: 5px 0 0; }
    .table-title .btn { color: #fff; font-size: 13px; border: none; min-width: 50px; border-radius: 2px; margin-left: 10px; }
    table.table tr th, table.table tr td { border-color: #e9e9e9; padding: 12px 15px; vertical-align: middle; }
    table.table-striped tbody tr:nth-of-type(odd) { background-color: #fcfcfc; }
    table.table-striped.table-hover tbody tr:hover { background: #f5f5f5; }
    table.table td a.edit { color: #FFC107; }
    table.table td a.delete { color: #F44336; }
</style>

<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Songs</b></h2>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('songs.create') }}" class="btn btn-success">
                        <i class="material-icons">&#xE147;</i> Add New Song
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
                            <a href="#" class="edit"><i class="material-icons">&#xE254;</i></a>
                            <a href="#" class="delete"><i class="material-icons">&#xE872;</i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Your playlist is empty. Add your first song 🎵</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
