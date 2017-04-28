<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Laravel</title>
    </head>
    <body>
        <h1>Welcome</h1>
        <ul id="users">
            <li v-repeat="user: users">@{{ user.name }}</li>
        </ul>

        <!-- Pull in pusher library -->
        <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.0/vue.js"></script>
        <script>
        // (function() {
        //     //* Encript data
            // var pusher = new Pusher('709e11775ee24077f79e', {
            //     encrypted: true
        //     });
        //     //* If we want to get the event we need to be on the same "channel" as that event.
        //     var channel = pusher.subscribe('test'); //* "announce" this event on UserHasRegister.php
        //     //* Listen for the event
        //     channel.bind('App\\Events\\UserHasRegistered', function(data) {
        //           console.log(data.name + ' should be visible');
        //         });
        // })();
        new Vue({
            el: '#users',
            data: {
                users: []
            },
            ready: function() {
                var pusher = new Pusher('709e11775ee24077f79e', {
                    encrypted: true
                });
                pusher.subscribe('test').bind('App\\Events\\UserHasRegistered', this.addUser);
            },
            methods: {
                addUser: function(user) {
                    this.users.push(user);
                }
            }
        });
        </script>
    </body>
</html>
