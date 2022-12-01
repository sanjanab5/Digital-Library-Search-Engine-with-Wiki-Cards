<!DOCTYPE html>
<html>
    <head>
    <title>Register</title>

        <link rel="icon" type="image/x-icon" href="/favicon.ico">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

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
            
            .button{
            wbackground-color: #2874A6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            }

            .button:hover {
            background-color: #3498DB;
            
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
      <a href="{{ url('/login') }}">Login</a>
      <a href="{{ url('/register') }}"  class="active">Register</a>
      <a href="{{ url('/') }}">Home</a>

  </div>
    <br/>
    <div class="container">
        <h3 align="center">Register here!</h3><br />
      <form method="POST" action="{{ route('register.perform') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="floatingFirstName">First Name</label>
            <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" placeholder="First Name" required="required" autofocus>
            @if ($errors->has('firstname'))
                <span class="text-danger text-left">{{ $errors->first('firstname') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="floatingLastName">Last Name</label>
            <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" placeholder="Last Name" required="required" autofocus>
            @if ($errors->has('lastname'))
                <span class="text-danger text-left">{{ $errors->first('lastname') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="floatingEmail">Email address</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required" autofocus>
            @if ($errors->has('email'))
                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
            @endif
        </div>


        <div class="form-group">
            <label for="floatingPassword">Password</label>
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="floatingConfirmPassword">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" required="required">
            @if ($errors->has('password_confirmation'))
                <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>

        <div class="form-group">
            <input type="submit" name="login" class="btn btn-primary" value="Register" />
        </div>
        <br/><br/><br/>
        <a href="{{ url('/login') }}">Already a user? Click here to login</a>
        <br/>
      </form>
    </div>
    @include('footer2')
    </body>
</html>
