@extends('layouts.app')
@section('title')
  Register
@endsection
@section('content')
{{-- {{ dd($_SESSION['errors']) }} --}}
@error('firstname')
$message
@enderror
@error('lastname')
$message
@enderror
<h1>Create an account</h1>
<form method="POST">
  <div class="row mb-3">
    <div class="col">
      <div class="form-group">
        <label for="firstname" class="form-label">Firstname</label>
        <input type="text" class="form-control" id="firstname" name="firstname">
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="lastname" class="form-label">Lastname</label>
        <input type="text" class="form-control" id="lastname" name="lastname">
      </div>
    </div>
        
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
    <label for="password_confirmation" class="form-label">Password Confirmation</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection