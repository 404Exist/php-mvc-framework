@extends('layouts.app')

@section('title')
  Login
@endsection
@section('content')
<form method="POST">
  <div class="mb-3">
    <label for="firstname" class="form-label lasd">Firstname</label>
    <input type="text" class="form-control" id="firstname" name="first_name">
    
  </div>
  <div class="mb-3">
    <label for="lastname" class="form-label">Lastname</label>
    <input type="text" class="form-control" id="lastname" name="lastname">
    @error('lastname')
        $message
    @enderror
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection