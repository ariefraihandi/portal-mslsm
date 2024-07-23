<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check OneSignal Subscription</title>
</head>
<body>
    <div id="result"></div>

    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize OneSignal
            var OneSignal = window.OneSignal || [];
            OneSignal.push(function () {
                OneSignal.init({
                    appId: "YOUR-APP-ID", // Ganti dengan App ID OneSignal Anda
                });

                // Get Player ID
                OneSignal.getUserId().then(function(playerId) {
                    if (playerId) {
                        document.getElementById('result').innerText = 'Player ID: ' + playerId;
                    } else {
                        document.getElementById('result').innerText = 'No Player ID found';
                    }
                });
            });
        });
    </script>
</body>
</html>