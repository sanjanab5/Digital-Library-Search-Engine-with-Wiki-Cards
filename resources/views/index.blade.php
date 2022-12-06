<!DOCTYPE html>
<html>
 <head>
  <title>Homepage</title>
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

  <style type="text/css">
  
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

    body {
      background-color: #D3E2EC;
      
    }

    form {
    width: 400px;
    margin: auto;
    }

    input {
    padding: 4px 10px;
    border: 0;
    font-size: 16px;
    }

    .search {
    width: 75%;
    }

    
    h3{
      font-size: 30px;
    }

    input[type=submit]:hover {
        background-color: #3498DB;
        }

    input[type=submit] {
        width: 70px;
        background-color: #1c87c9;
        color: #ffffff;
        
        }

      .alert{
        color: black;
        border-radius: 5px;
        background-color: #89C873;
        padding: 20px;
        width:500px;
        margin:0 auto;
        border:1px solid #ccc;
      }
    
  </style>
 </head>
 <body>
  <div class="topnav">
      <a href="{{ url('/logout') }}">Logout</a>
      <a href="{{ route('change_password') }}">Update Password</a>
      <a href="{{ route('edit_profile') }}">Update Info</a>
      <a href="{{ route('upload_etd') }}">Upload New ETD</a>
      <a href="{{ url('/profile') }}">My Profile</a>
      <a href="{{ url('/index') }}" class="active">Home</a>

      
  </div>
  
  <div>

   @if(isset(Auth::user()->email))
   <div>
    <br/></br></br>
     <p style="text-align:center; font-size: 25px">Hello {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}!</p>
     <br />
    </div>
   @else
    <script>window.location = "/index";</script>
   @endif
   <br/>
   
   <form action = "{{ route('lsearch') }}" method = "GET">
        @csrf
      <input type="text" name="search" class="search" placeholder="Search here!">
      <input type="submit" name="submit" class="submit" value="Search">
    </form>
    <br/><br/>
      
     @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <strong>{{ $message }}</strong>
        </div>
      @endif
    
   <br />
  </div>
  <br/><br/><br/><br/><br/><br/>
  @include('footer')
 </body>
</html>
