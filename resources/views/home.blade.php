@extends('layouts.main')

@section('content')
    {{ dump(Auth::user()) }}
@endsection