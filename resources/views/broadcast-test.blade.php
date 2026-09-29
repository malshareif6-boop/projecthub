<!DOCTYPE html>
<html>

<head>
    <title>Broadcast Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="p-8">
    <h1 class="text-xl font-bold mb-4">Broadcast Test</h1>
    <p>Open DevTools → Console. Waiting for events...</p>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.Echo === 'undefined') {
                console.error('Echo is not loaded');
                return;
            }

            window.Echo.channel('test')
                .listen('.TestPing', (e) => {
                    console.log('Received TestPing:', e);
                    alert('Received: ' + (e.message ?? JSON.stringify(e)));
                });

            console.log('Listening on public channel: test');
        });
    </script>
</body>

</html>
