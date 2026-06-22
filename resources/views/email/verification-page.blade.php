<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Email Verification Page</title>
</head>
<body style="background: grey">

<div class="container" style="margin-top: 100px">
    <div class="row">
        <div class="col-md-6 offset-md-3">
        <div class="card card-body">
            <span>We are send verification code <span style="color: #1eda2e">{{ $tutor_email }}</span></span>
            <span>Please Verify this email.</span>
            <form action="{{ route('verified.email') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" name="email_otp" placeholder="Type Your OTP" required maxlength="4">
                    @if(session()->has('error'))
                      <span class="text-danger"> {{ session()->get('error') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Click Verify</button>
            </form>


        </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
