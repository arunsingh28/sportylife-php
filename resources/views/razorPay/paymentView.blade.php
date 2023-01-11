<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sportylife - Payment</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .close {
            display: none !important;
        }
    </style>
</head>

<body>
</body>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": '{{ config('payments.razorpay_test_key') }}',
        "amount": '<?php echo $order['amount']; ?>',
        "currency": "INR",
        "name": "SportyLife",
        "description": "Payment",
        "image": "{{asset('/uploads/images/finallogo.png')}}",
        "order_id": '<?php echo $order['id']; ?>',
        "callback_url": '<?php echo url("/razorpay-callback"); ?>',
        "prefill": {
            "name": '<?php echo $user['name']; ?>',
            "email": '<?php echo $user['email']; ?>',
            "contact": '<?php echo $user['phone']; ?>'
        },
        "theme": {
            "color": "#212121"
        },
        "modal": {
            "escape": false,
            "ondismiss": function(response) {
                window.location.href = '{{ route("razorpay-payment-url") }}?status=0';
            }
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.on('payment.failed', function(response) {
        var oid = response.error.metadata.order_id;
        var pid = response.error.metadata.payment_id;
        window.location.href = '{{ route("razorpay-payment-url") }}?status=0&orderid=' + oid + '&payid=' + pid;
    });
    window.onload = function(e) {
        rzp1.open();
        e.preventDefault();
    }
</script>

</html>