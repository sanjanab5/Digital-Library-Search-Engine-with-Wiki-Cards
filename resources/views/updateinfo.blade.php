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
<div class = "container">
    <form action = "{{ route('update_profile') }}"id="edit_profile_form" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" class="form-control" name="firstname" value="{{ (old('firstname'))?old('firstname'):$user->firstname }}" placeholder="Enter First Name" autofocus>
            @if ($errors->any('firstname'))
                <span class="text-danger">{{ $errors->first('firstname') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" name="lastname" value="{{ (old('lastname'))?old('lastname'):$user->lastname }}" placeholder="Enter Last Name" autofocus>
            @if ($errors->any('lastname'))
                <span class="text-danger">{{ $errors->first('lastname') }}</span>
            @endif
        </div>
        <div class="form-group">
            <input type="submit" name="update" class="btn btn-primary" value="Update" />
        </div>
        <a href="{{ url('/index') }}">Go back to homepage</a>
</div>

</body>
</html>