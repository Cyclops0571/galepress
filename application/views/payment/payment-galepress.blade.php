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
                border-radius: 4px;
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
        <?php
        if (false) {
            $paymentAccount = new PaymentAccount();
        }
        ?>
        <img src="/website/img/shop/paymentBack.jpg" id="bodyBackground">
        <div class="demo-container">
            <div class="header">
                <h3>
                    Fiyat: <?php echo (int) (Config::get("custom.payment_amount") * 1.18) ?> TL (<?php echo Config::get("custom.payment_amount"); ?> TL + KDV)
                </h3>
            </div>
            <div class="card-wrapper"></div>

            <div class="form-container active">
                <form action="/odeme-onay" method="post" id="paymentForm" class="form-horizontal">
                    <input type="hidden" name="card_brand" id="card_brand" value="" />
                    <div class="form-group">
                        <label for="card_number" class="control-label col-md-3">Kart Numarası</label>
                        <div class="col-xs-9">
                            <input class="form-control required" placeholder="Kart Numarası" type="text" name="card_number" id="card_number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="card_holder_name" class="control-label col-md-3">Ad Soyad</label>
                        <div class="col-xs-9">
                            <input class="form-control required" placeholder="Ad Soyad" type="text" name="card_holder_name" id="card_holder_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="card_expiry_month" class="control-label col-md-3">Geçerlilik Tarihi</label>
                        <div class="col-md-4">
                            <select name="card_expiry_month" id="card_expiry_month" class="form-control" runat="server" style="max-width: 181px;">
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
                            <select name="card_expiry_year" id="card_expiry_year" class="form-control" runat="server" style="max-width: 181px;">
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
                        <label for="card_verification" class="control-label col-md-3">CVC2</label>
                        <div class="col-md-9">
                            <input class="form-control required" placeholder="CVC2" type="text" name="card_verification" id="card_verification" maxlength="3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="3d_secure" class="control-label col-md-3">3D Secure</label>
                        <div class="col-md-9">
                            <input type="checkbox" name="3d_secure" id="3d_secure" value="1"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">Ödeme Yap</button>
                    </div>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Ödeme Onay</h4>
                                </div>          
                                <div class="modal-body">
                                    <label class="control-label"><p>Hesabınızdan <?php echo (int) (Config::get("custom.payment_amount") * 1.18); ?> TL çekilecektir. Onaylıyor musunuz ?</p></label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
                                    <input type="submit" value="Onaylıyorum" name="payBtn" id="payBtn" class="pull-right">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group errorMsg hide" style="color:#CA0101; text-align:center; font-size:18px;">
                        <span>Lütfen bilgilerinizi kontrol edin...</span>
                    </div>
                </form>
            </div>

        </div>

        <script src="/website/scripts/shop/payment-galepress/card.js"></script>

        <script>

new Card({
    form: document.querySelector('form'),
    container: '.card-wrapper',
    formSelectors: {
        numberInput: 'input#card_number', // optional — default input[name="number"]
        expiryInput: 'input#expiry', // optional — default input[name="expiry"]
        cvcInput: 'input#card_verification', // optional — default input[name="cvc"]
        nameInput: 'input#card_holder_name' // optional - defaults input[name="name"]
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

$(function () {
    
    $('#card_number').keyup(function () {
        cardType = $('.jp-card').attr('class').split(' ')[1];
        cardType = cardType.split('-')[2];
        $('#card_brand').val(cardType);
    });

    var selectedMonth = "";
    var selectedYear = "";
    $('select#card_expiry_month').on('change', function () {
        selectedMonth = $('select#card_expiry_month option:selected').val();
        $('.jp-card-expiry').css('opacity', 1);
        $('.jp-card-expiry').text(selectedMonth + '/' + selectedYear);
    });

    $('select#card_expiry_year').on('change', function () {
        selectedYear = $('select#card_expiry_year option:selected').val();
        $('.jp-card-expiry').css('opacity', 1);
        $('.jp-card-expiry').text(selectedMonth + '/' + selectedYear);
    });

    $("#paymentForm").bind("submit", function () {
        var card_expiry_month = $("#card_expiry_month").val();
        var card_expiry_year = $("#card_expiry_year").val();
        $('#myModal').modal('hide');
        if ($('#card_number').val().length < 16) {

            $('.errorMsg').removeClass('hide').text('Lütfen 16 haneli kart numaranızı girin.');
            $('#card_number').focus();
            return false;
        }

        else if ($('#card_holder_name').val().length == 0) {

            $('.errorMsg').removeClass('hide').text('Lütfen adınızı girin.');
            $('#card_holder_name').focus();
            return false;
        }

        else if (card_expiry_month == null || card_expiry_year == null) {

            $('.errorMsg').removeClass('hide').text('Lütfen geçerlilik tarihini eksiksiz girin.');
            $('#card_expiry_month').focus();
            return false;
        }
        else if ($('#card_verification').val().length < 3) {

            $('.errorMsg').removeClass('hide').text('Lütfen kartın arkasındaki 3 haneli güvenlik numaranızı girin.');
            $('#card_verification').focus();
            return false;
        }
        else {
            $('.errorMsg').addClass('hide');
            // return false;
        }
    });
});
        </script>
    </body>
</html>
