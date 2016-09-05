<!DOCTYPE html>
<?php
/** @var Iyzipay\Model\CheckoutFormInitialize $checkoutFormInitialize */
?>
<html>
<head>
    <style type="text/css">
        html {
            height: 100%
        }

        body {
            height: 100%;
            margin: 0;
            padding: 0
        }
    </style>
</head>
<body>
<div id="iyzipay-checkout-form" class="popup">
    <?php echo $checkoutFormInitialize->getCheckoutFormContent(); ?>
</div>
</body>
</html>