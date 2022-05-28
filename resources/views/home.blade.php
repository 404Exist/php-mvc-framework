@extends('layouts.app')
@section('title')
    Home
@endsection

@section('content')
    <h1>{{ session()->get('success') }}</h1>
@endsection
