<!DOCTYPE html>
<html>
<head>
    <title>Update Info</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <style>
        body {
        background-color: #D3E2EC;
        }
        .container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        width:600px;
        margin:0 auto;
        border:1px solid #ccc;
        }
        .topnav {
        background-color: #333;
        overflow: hidden;
        }

        .topnav a {
        float: right;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        }

        .topnav a:hover {
        background-color: #ddd;
        color: black;
        }

        .topnav a.active {
        background-color: #ddd;
        color: black;
        }

        
    </style>
</head>
<body>
<div class="topnav">
      <a href="{{ url('/logout') }}">Logout</a>
      <a href="{{ route('change_password') }}">Update Password</a>
      <a href="{{ route('edit_profile') }}" class="active">Update Info</a>
      <a href="{{ route('upload_etd') }}">Upload New ETD</a>
      <a href="{{ url('/profile') }}">My Profile</a>
      <a href="{{ url('/index') }}">Home</a>
  </div>
<br/>
<div class = "container">
    <form action = "{{ route('update_profile') }}"id="edit_profile_form" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" class="form-control" name="firstname" value="{{ (old('firstname'))?old('firstname'):$user->firstname }}" placeholder="Enter First Name" autofocus>
            @if ($errors->any('firstname'))
                <span class="text-danger">{{ $errors->first('firstname') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" name="lastname" value="{{ (old('lastname'))?old('lastname'):$user->lastname }}" placeholder="Enter Last Name" autofocus>
            @if ($errors->any('lastname'))
                <span class="text-danger">{{ $errors->first('lastname') }}</span>
            @endif
        </div>
        <div class="form-group">
            <input type="submit" name="update" class="btn btn-primary" value="Update" />
        </div>
</div>
<br/><br/><br/><br/><br/>
@include('footer')
</body>
</html>