<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <tr><td>Dear {{ $name }}</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Please click on below link to confirm your account :-</td></tr>
    <tr><td>
        <a href="{{ url('user/confirm/'.$code) }}" class="btn btn-dark text-white text-decoration-none">Verify your email</a>
    </td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Thanks & Regards,</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Building Business</td></tr>

</body>
</html>
