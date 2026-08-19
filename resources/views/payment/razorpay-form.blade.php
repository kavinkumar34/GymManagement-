<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Razorpay Payment</title>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .payment-container {
            text-align: center;
            padding: 40px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #333;
            border-top: 4px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 25px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        h3 {
            margin-bottom: 10px;
        }

        p {
            color: #bbb;
        }

        .pay-button {
            display: none;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            background: #3399cc;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="payment-container">

    <div class="spinner" id="loader"></div>

    <h3 id="payment-title">
        Opening Razorpay Secure Payment...
    </h3>

    <p id="payment-message">
        Please do not refresh or close this page.
    </p>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const orderId = @json($orderId);

    const options = {

        key: @json($razorpayKey),

        amount: @json($amount),

        currency: @json($currency),

        name: "Gym E-Commerce",

        description: @json($productInfo),

        order_id: @json($razorpayOrderId),

        prefill: {
            name: @json($name),
            email: @json($email),
            contact: @json($phone)
        },

        theme: {
            color: "#3399cc"
        },

        handler: function (response) {

            console.log("Razorpay Success Response:", response);

            document.getElementById('loader').style.display = 'block';

            document.getElementById('payment-title').innerText =
                'Verifying Payment...';

            document.getElementById('payment-message').innerText =
                'Please wait while we confirm your payment.';

            fetch("{{ route('razorpay.payment.verify') }}", {

                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },

                body: JSON.stringify({

                    razorpay_payment_id:
                        response.razorpay_payment_id,

                    razorpay_order_id:
                        response.razorpay_order_id,

                    razorpay_signature:
                        response.razorpay_signature,

                    order_id: orderId
                })

            })

            .then(response => response.json())

            .then(data => {

                console.log("Verification Response:", data);

                if (data.success) {

                    window.location.href =
                        "{{ route('order.success', ['id' => $orderId]) }}?clear_cart=1";

                } else {

                    window.location.href =
                        "{{ route('razorpay.payment.failure') }}?order_id=" + orderId;

                }

            })

            .catch(error => {

                console.error(
                    "Payment verification error:",
                    error
                );

                window.location.href =
                    "{{ route('razorpay.payment.failure') }}?order_id=" + orderId;

            });

        },

        modal: {

            ondismiss: function () {

                console.log(
                    "Razorpay payment popup closed"
                );

                window.location.href =
                    "{{ route('razorpay.payment.failure') }}?order_id=" + orderId;

            }

        }

    };

    const razorpay = new Razorpay(options);

    razorpay.on('payment.failed', function (response) {

        console.error(
            "Razorpay Payment Failed:",
            response.error
        );

        window.location.href =
            "{{ route('razorpay.payment.failure') }}?order_id=" + orderId;

    });

    razorpay.open();

});
</script>

</body>
</html>