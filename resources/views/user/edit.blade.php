<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit User Form </title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
<div class="container mt-2">
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="pull-left">
<h2>Edit User</h2>
</div>
<div class="pull-right">
<a class="btn btn-primary" href="{{ route('editnew') }}" enctype="multipart/form-data"> Back</a>
</div>
</div>
</div>
@if(session('status'))
<div class="alert alert-success mb-1 mt-1">
{{ session('status') }}
</div>
@endif
<form action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>First Name:</strong>
<input type="text" name="first_name" value="{{ $user->first_name }}" class="form-control" placeholder="First_Name">
@error('first_name')
<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
@enderror
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Last_Name:</strong>
    <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control" placeholder="Last_Name">
    @error('last_name')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
    </div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>User Email:</strong>
<input type="email" name="email" class="form-control" placeholder="User Email" value="{{ $user->email }}">
@error('email')
<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
@enderror
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Phone Number:</strong>
<input type="number" name="phone_number" value="{{ $user->phone_number }}" class="form-control" placeholder="Phone_Number">
@error('phone number')
<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
@enderror
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Password:</strong>
    <input type="text" name="password" value="{{ $user->passwoed }}" class="form-control" placeholder="Password">
    @error('password')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
    </div>
    </div>
<button type="submit" class="btn btn-primary ml-3">Submit</button>
</div>
</form>
</div>
</body>
</html>