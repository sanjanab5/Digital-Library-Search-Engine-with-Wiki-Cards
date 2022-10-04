<!DOCTYPE html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
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
        
    </style>
</head>
<body>
<br/>
<div>

@if(isset(Auth::user()->email))
<div class = "container">
 <br/>

    @if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

  <p style="text-align:center; font-size: 25px">First Name: {{ Auth::user()->firstname }}</p>
  <p style="text-align:center; font-size: 25px">Last Name: {{ Auth::user()->lastname }}</p>
  <p style="text-align:center; font-size: 25px">Email: {{ Auth::user()->email }}</p>
  <br />
  <a href="{{ url('/index') }}">Go back to Homepage</a>
 </div>
@else
 <script>window.location = "/index";</script>
@endif
<br/>
</div>

</body>
</html>