<!DOCTYPE html>
<html>
<head>
    <title>GalePress Ödeme</title>
    <meta name="viewport" content="initial-scale=1">
</head>
<body>
    <style>
        body {
            background: transparent url(/website/img/shop/paymentBack.jpg) no-repeat center center !important;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .demo-container {
            width: 100%;
            max-width: 350px;
            margin: 50px auto;
        }

        form {
            margin: 30px;
        }
        input {
            width: 200px;
            margin: 10px auto;
            display: block;
        }
        .jp-card .jp-card-front{
            background-color: #41A2FF !important;
            background-image:url(/website/img/galepress.png) !important; 
        }
        .jp-card-back{
            background-color: #41A2FF !important;
        }
        #payBtn{
            height: 35px;
            width: 100px;
            background: #41A2FF;
            border: 1px solid white;
            color: white;
            cursor: pointer;
        }
    </style>
    <div class="demo-container">
        <div class="card-wrapper"></div>

        <div class="form-container active">
            <form action="/payment-galepress" method="post">
                <input placeholder="Kart Numarası" type="text" name="number" required>
                <input placeholder="Ad Soyad" type="text" name="name" required>
                <input placeholder="AA/YY" type="text" name="expiry" required>
                <input placeholder="CVC" type="text" name="cvc" required>
                <input type="submit" name="payBtn" id="payBtn">
            </form>
        </div>
    </div>

    <script src="/website/scripts/shop/payment-galepress/card.js"></script>
    <script>
        new Card({
            form: document.querySelector('form'),
            container: '.card-wrapper',
            values: {
                number: '•••• •••• •••• ••••',
                name: 'Ad Soyad',
                expiry: '••/••',
                cvc: '•••'
            },
            messages: {
                validDate: 'geçerlilik\ntarihi', // optional - default 'valid\nthru'
                monthYear: 'Ay / Yıl', // optional - default 'month/year'
            },
        });
    </script>
</body>
</html>
