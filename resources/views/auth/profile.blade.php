@extends('layouts.app')

@section('title')
  {{auth()->user()->firstname}} Profile
@endsection
@section('content')
<h1>{{ session()->get('success') }}</h1>
<h1>{{auth()->user()->firstname}} Profile</h1>
@endsection