<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
    <style>
        body {
            background: #ffffff;
            font-family: 'Open Sans', sans-serif;
            color:#202020;
        }
        .bg-white {
            background: #ffffff;  
        }
        .bg-grey {
            background: #eeeeee;
        }
        .p-5 {
            padding: 5px;
        }
        .mb-5 {
            margin-bottom:5px;
        }
        .text-capitalize {
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <div class="bg-grey">
        <div class="p-5">
            <h1 class="text-capitalize">Confirmation of Ticket Purchase</h1>
        </div>
        <!-- Thank You -->
        <div class="bg-white p-5 mb-5">
            <h3 class="text-capitalize">Thank you for purchasing a ticket to a Tower74 Concert! </h3>
            <p>
                Your support helps us book more concerts, creates revenue for venues and keeps artists working!
            </p>
        </div>
        <!-- Details -->
        <div class="bg-white p-5 mb-5">
            <h3 class="text-capitalize">About Your Purchase</h3>
            <p>{{$notification['concertTitle']}} @ {{$notification['venueName']}}</p>
            <p>Date: {{$notification['concertDate']}}</p>
            <p>Total Sale: {{$notification['ticketNumber']}} Ticket(s) | ${{$notification['ticketTotal']}}</p>
            <p>Primary Ticket Holder<br>{{$notification['ticketHolder']}}</p>
            <p>Details<br>{{$notification['concertBody']}}</p>
        </div>
        <!-- Tickets -->
        <div class="bg-white p-5 mb-5">
            <h3>Your Ticket(s)</h3>
            <p>
                Your ticket(s) will be at will call the day of the concert. The primary ticket holder will need to present a valid ID to claim the tickets. 
            </p>
        </div>
        <!-- Venue -->
        <div class="bg-white p-5 mb-5">
            <h3 class="text-capitalize">Venue</h3>
            <p>{{$notification['venueName']}}</p>
            <p>
                {{$notification['venueStreetAddress']}}<br>
                {{$notification['venueCity']}} {{$notification['venueState']}}, {{$notification['venueZipCode']}}<br>
            </p>
        </div>
        <!-- Contact -->
        <div class="bg-white p-5">
            <h3 class="text-capitalize">Contact</h3>
            <p>
                If you need to reach Tower74, please do not reply to this email. <a href="https://tower74concerts.com/contact">Click here to email</a> or text 949 205 9629. 
            </p>
        </div>
        <!-- Website -->
        <div class="p-5">
            <p>
                <a href="https://tower74concerts.com">https://tower74concerts.com</a>
            </p>
        </div>
    </div>            
</body>
</html>