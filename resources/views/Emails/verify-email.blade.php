<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <p>Hi {{ $name }},</p>
    <p>Click the link below to verify your email address:</p>
    <a href="{{ $url }}">Verify Email</a>
    <p>If you did not create an account, no further action is required.</p>
</body>
</html>
