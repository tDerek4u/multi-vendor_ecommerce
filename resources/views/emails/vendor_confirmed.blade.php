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
    <tr><td>Yout Vendor Account is confirmed. Please login and add your personal, business and bank details so that your qaccount will get approved. :-</td></tr>
    <tr><td><a href="{{ url('vendor/confirm/'.$code) }}">{{ url('vendor/confirm/'.$code) }}</a></td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Your Vendor Account Details are as below :</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Name: {{ $name }}</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    {{--  <tr><td>Mobile: {{ $mobile }}</td></tr>  --}}
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>EMail: {{ $email }}</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Password: ***** (as chosen by you)</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Thanks & Regards,</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Building Business</td></tr>

</body>
</html>
