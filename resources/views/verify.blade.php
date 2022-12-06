<html>
    <head>
        <title>Password Reset</title>
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
    </head>
    <body>
        <p>Click on the link below to reset your password.</p>
            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif
                <a href="http://localhost:8000/{{$token}}/reset-password">Click Here</a>.
            </div>
        </div>
@include('footer')
</body>
</html>
