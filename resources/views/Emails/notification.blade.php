<!DOCTYPE html>
<html>
<head>
    <title>Unread Notification Reminder</title>
</head>
<body>
    <h2>Unread Notification Reminder</h2>
    <p>{!! nl2br(e($emailMessage)) !!}</p> <!-- Menampilkan pesan dengan aman -->
    <p>To view the details, please click the link below:</p>
    <p><a href="{{ $url }}" target="_blank">{{ $url }}</a></p>
    <p>Thank you.</p>
</body>
</html>
