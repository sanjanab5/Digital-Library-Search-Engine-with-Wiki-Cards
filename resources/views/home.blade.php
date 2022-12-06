<!DOCTYPE html>
<html>
 <head>
  <title>Digital Library</title>
  @include('css')
  
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
<br/><br/><br/><br/><br/><br/><br/><br/>
</div>
@include('footer')
</body>
</html>