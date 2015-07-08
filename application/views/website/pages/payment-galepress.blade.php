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
	<?php if(false) {
		$paymentAccount = new PaymentAccount();	
	}
	?>
    <img src="/website/img/shop/paymentBack.jpg" id="bodyBackground">
    <div class="demo-container">
        <div class="card-wrapper"></div>

        <div class="form-container active">

            <form action="https://iyziconnect.com/post/v1/" method="post" id="paymentForm" class="form-horizontal">
				<input type="hidden" name="api" value="im0322080005c70f195bca1434712720" />
				<input type="hidden" name="secret" value="im0339018007d7a8f10f1c1434712720" />
				<input type="hidden" name="response_mode" value="ASYNC" />
				<input type="hidden" name="mode" value="<?php echo Config::get("custom.payment_environment");?>" />
				<input type="hidden" name="type" value="DB" />
				<input type="hidden" name="amount" value="10000" />
				<input type="hidden" name="installment" value="false" />
				<input type="hidden" name="installment_count" value="1" />
				<input type="hidden" name="currency" value="TRY" />
				
				<!--<input type="hidden" name="card_brand" value="VISA" />-->
				
				<input type="hidden" name="descriptor" value="<?php echo 'GalepressAylikOdeme_' . date('YmdHisu');?>" />
				<input type="hidden" name="customer_first_name" value="<?php echo $paymentAccount->title;?>" />
				<input type="hidden" name="customer_last_name" value="<?php echo $paymentAccount->title;?>" />
				<input type="hidden" name="customer_company_name" value="<?php echo $paymentAccount->title;?>" />
				
				<input type="hidden" name="customer_shipping_address_line_1" value="<?php echo $paymentAccount->address;?>" />
				<input type="hidden" name="customer_shipping_address_line_2" value="" />
				<input type="hidden" name="customer_shipping_address_zip" value="" />
				<input type="hidden" name="customer_shipping_address_city" value="" />
				<input type="hidden" name="customer_shipping_address_state" value="state" />
				<input type="hidden" name="customer_shipping_address_country" value="Türkiye" />
				
				<input type="hidden" name="customer_billing_address_line_1" value="<?php echo $paymentAccount->address;?>" />
				<input type="hidden" name="customer_billing_address_line_2" value="" />
				<input type="hidden" name="customer_billing_address_zip" value="" />
				<input type="hidden" name="customer_billing_address_city" value="" />
				<input type="hidden" name="customer_billing_address_state" value="state" />
				<input type="hidden" name="customer_billing_address_country" value="Türkiye" />
				
				<input type="hidden" name="customer_contact_email" value="<?php echo $paymentAccount->email;?>" />
				<input type="hidden" name="customer_contact_phone" value="" />
				<input type="hidden" name="customer_contact_mobile" value="<?php echo $paymentAccount->phone;?>" />
				<input type="hidden" name="customer_contact_ip" value="<?php echo Request::ip();?>" />
				
				<input type="hidden" name="item_id_1" value="1" />
				<input type="hidden" name="item_name_1" value="GalePress - Dijital Yayın Platformu" />
				<input type="hidden" name="item_unit_quantity_1" value="1" />
				<input type="hidden" name="item_unit_amount_1" value="1200" />
				<input type="hidden" name="external_id" value="<?php echo $paymentAccount->CustomerID;?>" />
				
				
				
				<input type="hidden" name="return_url" value="<?php echo Config::get("custom.payment_url") . '/payment-response';?>" />
				<input type="hidden" name="customer_language" value="tr" />
				<input type="hidden" name="customer_presentation_usage" value="<?php echo 'GalepressAylikOdeme_' . date('YmdHisu');?>" />
                <div class="form-group">
                    <label for="card_number" class="control-label col-md-3">Kart Numarası</label>
                    <div class="col-xs-9">
                        <input class="form-control required" placeholder="Kart Numarası" type="text" name="card_number" id="card_number" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="card_holder_name" class="control-label col-md-3">Ad Soyad</label>
                    <div class="col-xs-9">
                        <input class="form-control required" placeholder="Ad Soyad" type="text" name="card_holder_name" id="card_holder_name" required>
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
                    <label for="card_verification" class="control-label col-md-3">CVC</label>
                    <div class="col-md-9">
                        <input class="form-control required" placeholder="CVC" type="text" name="card_verification" id="card_verification" maxlength="3" required>
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
            $('select#card_expiry_month').on('change', function(){
               selectedMonth = $('select#card_expiry_month option:selected').val();
               $('.jp-card-expiry').css('opacity',1);
               $('.jp-card-expiry').text(selectedMonth + '/' + selectedYear);
            });

            $('select#card_expiry_year').on('change', function(){
               selectedYear = $('select#card_expiry_year option:selected').val();
               $('.jp-card-expiry').css('opacity',1);
               $('.jp-card-expiry').text(selectedMonth + '/' + selectedYear);
            });

            $("#paymentForm").bind("submit", function() {

                var card_expiry_month = $("#card_expiry_month").val();
                var card_expiry_year = $("#card_expiry_year").val();

                if($('#card_number').val().length<16){

                    $('.errorMsg').removeClass('hide').text('Lütfen 16 haneli kart numaranızı girin.');
                    $('#card_number').focus();
                    return false;
                }

                else if($('#card_holder_name').val().length==0){

                    $('.errorMsg').removeClass('hide').text('Lütfen adınızı girin.');
                    $('#card_holder_name').focus();
                    return false;
                }

                else if(card_expiry_month==null || card_expiry_year==null){

                    $('.errorMsg').removeClass('hide').text('Lütfen geçerlilik tarihini eksiksiz girin.');
                    $('#card_expiry_month').focus();
                    return false;
                }
                else if($('#card_verification').val().length<3){

                    $('.errorMsg').removeClass('hide').text('Lütfen kartın arkasındaki 3 haneli güvenlik numaranızı girin.');
                    $('#card_verification').focus();
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

    </script>
</body>
</html>
