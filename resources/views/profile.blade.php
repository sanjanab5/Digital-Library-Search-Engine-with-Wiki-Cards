<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
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
      <a href="{{ route('edit_profile') }}">Update Info</a>
      <a href="{{ route('upload_etd') }}">Upload New ETD</a>
      <a href="{{ url('/profile') }}" class="active">My Profile</a>
      <a href="{{ url('/index') }}">Home</a>

      
  </div>
<br/>
<div>

@if(isset(Auth::user()->email))
<div class = "container">
 <br/>

    @if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <strong>{{ $message }}</strong>
    </div>
    @endif

  <p style="text-align:center; font-size: 25px">First Name: {{ Auth::user()->firstname }}</p>
  <p style="text-align:center; font-size: 25px">Last Name: {{ Auth::user()->lastname }}</p>
  <p style="text-align:center; font-size: 25px">Email: {{ Auth::user()->email }}</p>
  <br />
 </div>
@else
 <script>window.location = "/index";</script>
@endif
<br/>
</div>
<br/><br/><br/><br/><br/>
@include('footer')
</body>
</html>