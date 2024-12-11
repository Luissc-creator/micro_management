<!DOCTYPE html>

<head>
    <title>Pusher Test</title>
    <!-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.js"></script>

    <script>
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        // var pusher = new Pusher('050e38dcbcd82e7ec970', {
        //     cluster: 'us2'
        // });

        // var channel = pusher.subscribe('chat');
        // channel.bind('example', function(data) {
        //     alert(JSON.stringify(data));
        // });
        // window.Pusher = Pusher;
        // window.Echo = new Echo({
        //     broadcaster: 'pusher',
        //     key: "050e38dcbcd82e7ec970",
        //     cluster: "us2",
        //     forceTLS: true
        // });

        //         Echo.channel('chat')
        //             .listen('NewMessage', (e) => {
        //             console.log(e.message);
        //         });


        const echo = new window.Echo({
            broadcaster: 'pusher',
            key: '050e38dcbcd82e7ec970',
            cluster: 'us2', // Example: 'mt1'
            forceTLS: true,
        });

        // Subscribe to a channel and listen for an event
        echo.channel('chat')
            .listen('example', (data, data2) => {
                console.log('New event received:', data);
                // You can add your logic to handle the data
                alert('new message ' + data);
            });
    </script>
</head>

<body>
    <h1>Pusher Test</h1>
    <p>
        Try publishing an event to channel <code>my-channel</code>
        with event name <code>my-event</code>.
    </p>
</body>
