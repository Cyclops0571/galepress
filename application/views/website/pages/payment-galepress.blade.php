<!DOCTYPE html>
<html>
<head>
    <title>GalePress Ödeme</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="/website/img/favicon2.ico">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="/website/styles/shop/vendor/jquery.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <meta name="viewport" content="initial-scale=1">
    <style>
        .demo-container {
            width: 100%;
            max-width: 350px;
            margin: 50px auto;
        }

        form {
            margin: 30px;
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
            margin-right: 16px;
            border-radius: 9px;
        }
        #bodyBackground{
            position: fixed;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>
</head>
<body>
    <img src="/website/img/shop/paymentBack.jpg" id="bodyBackground">
    <div class="demo-container">
        <div class="card-wrapper"></div>

        <div class="form-container active">

            <form action="/payment-galepress" method="post" id="paymentForm" class="form-horizontal">
                <div class="form-group">
                    <label for="cardno" class="control-label col-md-3">Kart Numarası</label>
                    <div class="col-xs-9">
                        <input class="form-control required" placeholder="Kart Numarası" type="text" name="cardno" id="cardno" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label col-md-3">Ad Soyad</label>
                    <div class="col-xs-9">
                        <input class="form-control required" placeholder="Ad Soyad" type="text" name="name" id="name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="expiry" class="control-label col-md-3">Geçerlilik Tarihi</label>
                    <div class="col-md-4">
                        <select name="expiryMonth" id="expiryMonth" class="form-control" runat="server" style="max-width: 181px;">
                            <option selected disabled>Ay</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="expiryYear" id="expiryYear" class="form-control" runat="server" style="max-width: 181px;">
                            <option selected disabled>Yıl</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cvc" class="control-label col-md-3">CVC</label>
                    <div class="col-md-9">
                        <input class="form-control required" placeholder="CVC" type="text" name="cvc" id="cvc" maxlength="3" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" value="Gönder" name="payBtn" id="payBtn" class="pull-right">
                </div>
                <div class="form-group errorMsg hide" style="color:#CA0101; text-align:center; font-size:18px;">
                    <span>Lütfen bilgilerinizi kontrol edin...</span>
                </div>
            </form>
        </div>
    </div>

    <script src="/website/scripts/shop/payment-galepress/card.js"></script>

    <script>


        $(function(){
            var selectedMonth="";
            var selectedYear="";
            $('select#expiryMonth').on('change', function(){
               selectedMonth = $('select#expiryMonth option:selected').val();
               $('.jp-card-expiry').css('opacity',1);
               $('.jp-card-expiry').text(selectedMonth + '/' + selectedYear);
            });

            $('select#expiryYear').on('change', function(){
               selectedYear = $('select#expiryYear option:selected').val();
               $('.jp-card-expiry').css('opacity',1);
               $('.jp-card-expiry').text(selectedMonth + '/' + selectedYear);
            });

            $("#paymentForm").bind("submit", function() {

                var expiryMonth = $("#expiryMonth").val();
                var expiryYear = $("#expiryYear").val();

                if($('#cardno').val().length<16){

                    $('.errorMsg').removeClass('hide').text('Lütfen 16 haneli kart numaranızı girin.');
                    $('#cardno').focus();
                    return false;
                }

                else if($('#name').val().length==0){

                    $('.errorMsg').removeClass('hide').text('Lütfen adınızı girin.');
                    $('#name').focus();
                    return false;
                }

                else if(expiryMonth==null || expiryYear==null){

                    $('.errorMsg').removeClass('hide').text('Lütfen geçerlilik tarihini eksiksiz girin.');
                    $('#expiryMonth').focus();
                    return false;
                }
                else if($('#cvc').val().length<3){

                    $('.errorMsg').removeClass('hide').text('Lütfen kartın arkasındaki 3 haneli güvenlik numaranızı girin.');
                    $('#cvc').focus();
                    return false;
                }
                else {
                    $('.errorMsg').addClass('hide');
                    // return false;
                }
            });
        })

        new Card({
            form: document.querySelector('form'),
            container: '.card-wrapper',
            formSelectors: {
                numberInput: 'input#cardno', // optional — default input[name="number"]
                expiryInput: 'input#expiry', // optional — default input[name="expiry"]
                cvcInput: 'input#cvc', // optional — default input[name="cvc"]
                nameInput: 'input#name' // optional - defaults input[name="name"]
            },
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
