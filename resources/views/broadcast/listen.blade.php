<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    {{-- @vite(['resources/js/app.js', 'resources/css/app.css']) --}}
  {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
  <script>

     // Enable pusher logging - don't include this in production
     Pusher.logToConsole = true;

    var pusher = new Pusher('003a8955d5f57070a7b6', {
    cluster: 'eu'
    });

    var channel = pusher.subscribe('message.notification');
    channel.bind('search-product', function(data) {
    document.querySelector('.content').innerHTML = data.product.product;
    console.table(JSON.stringify(data.product));
    });


  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p class="content">
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>
