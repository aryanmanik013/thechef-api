<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>The Chef - Make Payment</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>
<body>
    <form id="paymentForm" action="{{ $paymentUrl }}" name="paymentForm" method="post">
        <p>Please wait.......</p>
        <input type="hidden" name="signature" value="{{ $signature }}"/>
        <input type="hidden" name="orderNote" value="{{ $paymentData['orderNote'] }}"/>
        <input type="hidden" name="orderCurrency" value="{{ $paymentData['orderCurrency'] }}" />
        <input type="hidden" name="customerName" value="{{ $paymentData['customerName'] }}" />
        <input type="hidden" name="customerEmail" value="{{ $paymentData['customerEmail'] }}" />
        <input type="hidden" name="customerPhone" value="{{ $paymentData['customerPhone'] }}" />
        <input type="hidden" name="orderAmount" value="{{ $paymentData['orderAmount'] }}" />
        <input type ="hidden" name="notifyUrl" value="{{ $paymentData['notifyUrl'] }}" />
        <input type ="hidden" name="returnUrl" value="{{ $paymentData['returnUrl'] }}" />
        <input type="hidden" name="appId" value="{{ $paymentData['appId'] }}" />
        <input type="hidden" name="orderId" value="{{ $paymentData['orderId'] }}" />
    </form>
    <script>document.getElementById("paymentForm").submit();</script>
</body>
</html>
