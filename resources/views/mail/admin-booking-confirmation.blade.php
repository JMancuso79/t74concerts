<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
        .bg-white {
            background: #ffffff;
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-white">
    <div>
        <h1>Booking Request</h1>
        <!-- Details -->
        <p>Name: {{$notification->name}}</p>
        <p>Contact: {{$notification->contact_name}}</p>
        <p>Email: {{$notification->email}}</p>
        <p>Phone: {{$notification->phone}}</p>
        <p>Type: {{$notification->type}}</p>
        @if($notification->type == 'venue')
            <p>{{$notification->address}}</p>
        @endif
        <p>{{$notification->city}}</p>
        <p>{{$notification->state}}, {{$notification->zip}}</p>
        <p>URL: {{$notification->url}}</p>
        <p>Genres: {{$notification->genres}}</p>
        <p>Dates: {{$notification->dates}}</p>
        @if($notification->type == 'artist')
            @if($notification->gig_swap == 1)
                <p>Can book:<br>{{$notification->gig_swap_home}}</p>
                <p>Can Play:<br>{{$notification->gig_swap_away}}</p>
            @endif
        @endif
        <p>Message:<br>{{$notification->message}}</p>
    </div>            
</body>
</html>