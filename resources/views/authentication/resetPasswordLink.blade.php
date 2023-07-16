<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html: charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        * {
            text-decoration: none;
        }

        body {
            background: #ecf0f1;
        }

        #btn-reset {
            color: white;
            background: #3b82f6;
            padding: 14px;
            font-size: 14px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <p>Reset Password Link</p>
    <hr>

    <center>
        <a href="{{ route('resetPasswordForm', $token) }}" id="btn-reset">Reset your password</a>
    </center>

    <hr>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>
