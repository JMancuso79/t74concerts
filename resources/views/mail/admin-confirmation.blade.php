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
    <div class="bg-light p-2">
        <div class="pb-2">
            <h1>Ticket Purchase</h1>
        </div>
        <!-- Details -->
        <div class="row mb-2">
            <div class="col-12 bg-white text-dark p-2">
                <h3>{{$notification['concertTitle']}} @ {{$notification['venueName']}}</h3>
                <p>Concert ID: #{{$notification['concertId']}}</p>
                <p>Total Sale: {{$notification['ticketNumber']}} Ticket(s) | ${{$notification['ticketTotal']}}.00</p>
                <p>Primary Ticket Holder<br>{{$notification['ticketHolder']}}</p>
            </div>
        </div>
        <!-- Customer -->
        <div class="row">
            <div class="col-12 bg-white text-dark p-2">
                <h3>Customer</h3>
                <p>Name: {{$notification['customerName']}}</p>
                <p>Email: {{$notification['customerEmail']}}</p>
                <p>
                    Zip: {{$notification['customerZipCode']}}
                </p>
            </div>
        </div>
    </div>            
</body>
</html>