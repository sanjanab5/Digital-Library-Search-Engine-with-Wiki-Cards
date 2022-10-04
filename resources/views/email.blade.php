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

    </style>
</head>
    <body>
    <br/>
    <div class="container">
                    @if (session('status'))
                         <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                  
        <form method="POST" action="/forgot-password">
            @csrf
            <div class="form-group">
                <label for="email">E-Mail Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
            </div>
            <div>
                <input type="submit" name="submit" value="Submit" /></p>
            </div>
            <br/><br/><br/>
            <p><a href="{{ url('/login') }}">Login</a> &nbsp; &nbsp; <a href="{{ url('/register') }}">Register</a></p>
        </form> 
    </div>
    </body>
</html>
