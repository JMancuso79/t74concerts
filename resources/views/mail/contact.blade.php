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
            <h1 class="text-capitalize">Website Contact</h1>
        </div>
        <!-- Details -->
        <div class="bg-white p-5 mb-5">
            <p>Name: {{$data['name']}}</p>
            <p>Email: {{$data['email']}}</p>
            <p>Phone: {{$data['phone']}}</p>
            <p>Message:</p>
            <p>{{$data['message']}}</p>
        </div>
    </div>            
</body>
</html>