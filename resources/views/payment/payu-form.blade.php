<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to PayU...</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #000;
            color: white;
        }
        .loader {
            text-align: center;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #dc3545;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="loader">
        <div class="spinner"></div>
        <h3>Redirecting to PayU Secure Payment...</h3>
        <p>Please do not refresh the page</p>
    </div>

    <form method="POST" action="{{ $action }}" name="payuForm" style="display: none;">
        <input type="hidden" name="key" value="{{ $key }}">
        <input type="hidden" name="txnid" value="{{ $txnid }}">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="productinfo" value="{{ $productinfo }}">
        <input type="hidden" name="firstname" value="{{ $firstname }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="phone" value="{{ $phone }}">
        <input type="hidden" name="surl" value="{{ $surl }}">
        <input type="hidden" name="furl" value="{{ $furl }}">
        <input type="hidden" name="hash" value="{{ $hash }}">
        <input type="hidden" name="service_provider" value="payu_paisa">
        <input type="hidden" name="udf1" value="">
        <input type="hidden" name="udf2" value="">
        <input type="hidden" name="udf3" value="">
        <input type="hidden" name="udf4" value="">
        <input type="hidden" name="udf5" value="">
    </form>

    <script>
        document.payuForm.submit();
    </script>
</body>
</html>