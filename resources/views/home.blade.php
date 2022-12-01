<!DOCTYPE html>
<html>
 <head>
  <title>Digital Library</title>

  <link rel="icon" type="image/x-icon" sizes= "72x72" href="/favicon.ico">
  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>


  <style type="text/css">
  
   /* Add a black background color to the top navigation */
    .topnav {
    background-color: #333;
    overflow: hidden;
    }

    /* Style the links inside the navigation bar */
    .topnav a {
    float: right;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    }

    /* Change the color of links on hover */
    .topnav a:hover {
    background-color: #ddd;
    color: black;
    }

    /* Add a color to the active/current link */
    .topnav a.active {
    background-color: #04AA6D;
    color: white;
    }
    
    body {
    background-color: #D3E2EC;
    }
    
    h3{
      font-size: 30px;
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

    input[type=submit]:hover {
        background-color: #3498DB;
        }

    input[type=submit] {
        width: 70px;
        background-color: #1c87c9;
        color: #ffffff;
        
        }

</style>
</head>
<body>
  <div class="topnav">
      <a href="{{ url('/login') }}">Login</a>
      <a href="{{ url('/register') }}">Register</a>
  </div>
  <br/><br/>
  <h3 align="center">Digital Library Search Engine</h3><br />
  <br/><br/>
  <form action = "{{ route('search') }}" method = "GET">
        @csrf
      <input type="text" name="search" class="search" placeholder="Search here!">
      <input type="submit" name="submit" class="submit" value="Search">
  </form>
<br/>
</div>
@include('footer2')
</body>
</html>
