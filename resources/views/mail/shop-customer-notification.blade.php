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
                <h3>Order Confirmation</h3>
                <!-- Thank You -->
                <div>
                    <p>Your support helps us book more concerts which keeps artists working and creates revenue for venues!</p>
                </div>
            </div>
            <!-- Details -->
            <div class="mb-4">
                <h3 class="text-capitalize">About Your Purchase</h3>

                @foreach ($notification['products'] as $product)
                    <div style="border-bottom: 1px solid #eeeeee; padding-bottom:5px;" class="mb-2">
                        <p>
                            <a href="https://tower74concerts.com/product/{{ $product['id'] }}">
                                <img src="https://tower74concerts.com{{$product['image']}}" style="max-width:280px;" width="100%" />
                            </a>
                        </p>
                        <p style="margin-top:5px;" class="text-capitalize">
                            <strong><a href="https://tower74concerts.com/product/{{ $product['id'] }}">{{ $product['name'] }}</a></strong> 
                            {{ $product['color'] }} ({{ $product['quantity'] }})
                            <br>Size: {{ $product['size'] }} 
                        </p>
                    </div>
                @endforeach
            </div>
            <!-- Tickets -->
            <div class="mb-4">
                <h3>Total</h3>
                <p>${{$notification['total']}}</p>
            </div>
            
            <!-- Tickets -->
            <div class="mb-4">
                <h3>Shipping</h3>
                <p>
                    If your products are in stock they ship within two business days of receiving the order. If you purchased an item that is out of stock it will ship within two weeks. 
                </p>
            </div>
            <!-- Tickets -->
            <div class="mb-4">
                <h3>Customer Details</h3>
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
            </div>
            <!-- Contact -->
            <div class="mb-4">
                <h3 class="text-capitalize">Contact</h3>
                <p>
                    If you have questions about your order, please do not reply to this email. 
                </p>
                <p><a href="https://tower74concerts.com/contact">Click here to contact us</a></p>
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