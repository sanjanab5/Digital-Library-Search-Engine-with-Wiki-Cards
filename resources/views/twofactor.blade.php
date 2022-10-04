<!DOCTYPE html>
<html lang="en">
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
    @if(session()->has('message'))
        <p class="alert alert-info">
            {{ session()->get('message') }}
        </p>
    @endif
    <div class ="container">
    <form method="POST" action="{{ route('verify.store') }}">
        {{ csrf_field() }}
        <h1>Two Factor Verification</h1>
        <p class="text-muted">
            You have received an email which contains two factor login code.
            If you haven't received it, press <a href="{{ route('verify.resend') }}">here</a>.
        </p>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
            </div>
            <input name="two_factor_code" type="text" 
                class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}" 
                required autofocus placeholder="Two Factor Code">
            @if($errors->has('two_factor_code'))
                <div class="invalid-feedback">
                    {{ $errors->first('two_factor_code') }}
                </div>
            @endif
        </div>
        <br/>
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-primary px-4">
                    Verify
                </button>
            </div>
        </div>
    </form>
    </div>
</body>
</html>