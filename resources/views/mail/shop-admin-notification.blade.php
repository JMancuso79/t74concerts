<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
    <style>
        body {
            background: #ffffff;
            font-family: 'Open Sans', sans-serif;
            color:#1F2937;
        }
        .bg-white {
            background: #ffffff;  
        }
        .bg-grey {
            background: #1F2937;
        }
        .p-4 {
            padding: 15px;
        }
        .mb-4 {
            margin-bottom:15px;
        }
        .mb-2 {
            margin-bottom:5px;
        }
        .text-capitalize {
            text-transform: capitalize;
        }
        .center {
            text-align:center!important;
        }
    </style>
</head>
<body>
    <div style="width:100%; max-width:640px; margin:0 auto; border: 2px solid #1F2937;">
        <div class="bg-grey" >
            <div class="p-4 center">
                <img src="https://tower74concerts.com/images/t74-white-wp.png" style="max-width:180px;" width="100%" />
            </div>
        </div>
        <div class="bg-white p-4 mb-4 ">
            <div class="center" style="border-bottom: 1px solid #eeeeee;">
                <h3>New Order Confirmation</h3>
            </div>
            <!-- Tickets -->
            <div class="mb-4">
                <h3>Customer</h3>
                <p>
                    {{$notification['customer']['name']}} 
                </p>
                <p>
                    {{$notification['customer']['email']}} 
                </p>
                <p>
                    {{$notification['customer_details']['street_address']}} {{$notification['customer_details']['unit']}} 
                </p>
                <p>
                    {{$notification['customer_details']['city']}}, {{$notification['customer_details']['state']}} {{$notification['customer_details']['zip']}} 
                </p>
                <p><strong>Total: ${{$notification['total']}}</strong></p>
            </div>
            <!-- Details -->
            <div class="mb-4">

                @foreach ($notification['products'] as $product)
                    <div style="border-bottom: 1px solid #eeeeee; padding-bottom:5px;" class="mb-2">
                        <p>

                            <img src="https://tower74concerts.com/storage/images/628d5902e11b8_back-tee-1.jpg" style="max-width:280px;" width="100%" />
                        </p>
                        <p style="margin-top:5px;" class="text-capitalize">
                            <strong>{{ $product['name'] }}</strong> {{ $product['color'] }} ({{ $product['quantity'] }})
                            <br>Size: {{ $product['size'] }} 
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Website -->
            <div class="mb-4">
                <p>
                    <a href="https://tower74concerts.com">https://tower74concerts.com</a>
                </p>
            </div>
        </div> 
    </div>            
</body>
</html>