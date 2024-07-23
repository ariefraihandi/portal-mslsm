<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <p>Hi {{ $name }},</p>
    <p>Klik Tautan di bawah ini untuk melakukan verifikasi email:</p>
    <a href="{{ $url }}">Verify Email</a>
    <p>If you did not create an account, no further action is required.</p>
</body>
</html>
