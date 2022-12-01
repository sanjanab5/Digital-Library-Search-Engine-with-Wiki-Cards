<!DOCTYPE html>
<html>
 <head>
  <title>Login</title>
  <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style type="text/css">
        
        body {
        background-color: #D3E2EC;
        }
        .container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        width:500px;
        margin:0 auto;
        border:1px solid #ccc;
        }
        input {
        width: 100%;
        border: 2px #2874A6;
        padding: 12px 20px;
        border-radius: 4px;
        }

        input[type=submit]:hover {
        background-color: #3498DB;
        }

        input[type=submit] {
        background-color: #2874A6;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;
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
      <a href="{{ url('/login') }}" class="active">Login</a>
      <a href="{{ url('/register') }}">Register</a>
      <a href="{{ url('/') }}">Home</a>

  </div>
  <br />
  <div class="container">
   <h3 align="center">Login Now!</h3><br />

   @if(isset(Auth::user()->email))
    <script>window.location="/index";</script>
   @endif

   @if ($message = Session::get('error'))
   <div class="alert alert-danger" role = "alert">
    <strong>{{ $message }}</strong>
   </div>
   @endif

   @if (count($errors) > 0)
    <div class="alert alert-danger">
     <ul>
     @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
     @endforeach
     </ul>
    </div>
   @endif

   @if ($message = Session::get('success'))
   <div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>{{ $message }}</strong>
   </div>
   @endif

   <form method="post" action="{{ url('/login_auth') }}">
       
        {{ csrf_field()  }}
        
        <div class="form-group">
            <label>Email Address:</label>
            <input type="email" name="email" class="form-control" />
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" />
        </div>
        
        <div class="form-group">
        <div class="g-recaptcha" data-sitekey="6Lc7jUAjAAAAADyDWGaKXmJY_gRRjIResjoALLHN"></div>
        <!-- @if ($errors->has('g-recaptcha-response'))
            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
        @endif -->
        </div>

        <br/>

        <div class="form-group">
            <input type="submit" name="login" class="btn btn-primary" value="Login" />
        </div>
        <br/><br/><br/>

        <a href="{{ url('/email') }}">Forgot Password</a>
        <br/>
        <a href="{{ url('/register') }}">Don't have an account? Sign up here</a>
        <br/>
   </form>
  </div>
  @include('footer2')

 </body>
</html>

