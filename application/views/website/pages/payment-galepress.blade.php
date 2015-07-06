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
        /*input {
            width: 200px;
            margin: 10px auto;
            display: block;
        }*/
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
            <!-- <form action="/payment-galepress" method="post" id="paymentForm">
                <input placeholder="Kart Numarası" type="text" name="number" required>
                <input placeholder="Ad Soyad" type="text" name="name" required>
                <input placeholder="AA/YY" type="text" name="expiry" required>
                <input placeholder="CVC" type="text" name="cvc" maxlength="3" required>
                <input type="submit" value="Gönder" name="payBtn" id="payBtn">
            </form> -->


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
                    <!-- <input class="form-control required" placeholder="fake" type="text" name="expiry" id="expiry" required> -->
                    <div class="col-md-4">
                        <!-- <input class="form-control required" placeholder="AA" type="text" name="expiryMonth" required> -->
                        <!-- <div class="dropdown">
                          <button class="btn btn-default dropdown-toggle" type="button" id="expiryMonth" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            AA
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="expiryMonth" style="min-width:61px;">
                            <li><a href="#">01</a></li>
                            <li><a href="#">02</a></li>
                            <li><a href="#">03</a></li>
                            <li><a href="#">04</a></li>
                            <li><a href="#">05</a></li>
                            <li><a href="#">06</a></li>
                            <li><a href="#">07</a></li>
                            <li><a href="#">08</a></li>
                            <li><a href="#">09</a></li>
                            <li><a href="#">10</a></li>
                            <li><a href="#">11</a></li>
                            <li><a href="#">12</a></li>
                          </ul>
                        </div> -->
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
                        <!-- <input class="form-control required" placeholder="YYYY" type="text" name="expiryYear" required> -->
                        <!-- <div class="dropdown">
                          <button class="btn btn-default dropdown-toggle" type="button" id="expiryYear" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            AA
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="expiryYear" style="min-width:61px;">
                            <li><a href="#">2015</a></li>
                            <li><a href="#">2016</a></li>
                            <li><a href="#">2017</a></li>
                            <li><a href="#">2018</a></li>
                            <li><a href="#">2019</a></li>
                            <li><a href="#">2020</a></li>
                            <li><a href="#">2021</a></li>
                            <li><a href="#">2022</a></li>
                            <li><a href="#">2023</a></li>
                            <li><a href="#">2024</a></li>
                            <li><a href="#">2025</a></li>
                            <li><a href="#">2026</a></li>
                          </ul>
                        </div> -->
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
                        <input class="form-control required" placeholder="CVC" type="text" name="cvc" id="cvc" maxlength="3" style="max-width: 181px;" required>
                    </div>
                </div>
            </form>

            <!-- <form action="/payment-galepress" method="post" id="paymentForm" class="form-horizontal">
                <div class="form-group">
                    <label class="col-xs-3 control-label">Kart No:</label>
                    <div class="col-xs-4">
                        <input placeholder="Kart Numarası" type="text" name="number" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Ad Soyad:</label>
                    <div class="col-xs-4">
                        <input placeholder="Ad Soyad" type="text" name="name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Ay:</label>
                    <div class="col-xs-4">
                        <input type="text" class="form-control" placeholder="Month" name="expMonth" />
                    </div>
                    <label class="col-xs-2 control-label">Yıl:</label>
                    <div class="col-xs-4">
                        <input type="text" class="form-control" placeholder="Year" name="expYear" />
                    </div>
                </div>
            </form> -->
        </div>
    </div>

    <script src="/website/scripts/shop/payment-galepress/card.js"></script>

    <script>


        $(function(){
            $('select#expiryMonth').on('change', function(){
               var selected = $('select#expiryMonth option:selected').val();
               $('input#expiry').val(selected);
               $('input#expiry').text(selected);
               // $("input#expiry").focus().trigger("keypress");
               $("input#expiry").trigger("focus");
                // var e = jQuery.Event("keypress");
                // e.which = '97';
                // $("input#expiry").trigger(e);
    //             $("input#expiry").trigger("keypress") // you can trigger keypress like this if you need to..
    // .val(function(i,val){return val + ' ';});
    // $("input#expiry").trigger("keydown") // you can trigger keypress like this if you need to..
    // .val(function(i,val){return val + ' ';});
    //     $("input#expiry").trigger("keydown") // you can trigger keypress like this if you need to..
    // .val(function(i,val){return val + ' ';});

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


        // setTimeout(function(){
        //     // alert("asd");
        //     $('body').css('background','red url(/website/img/shop/paymentBack1.jpg) no-repeat center center');
        //     // $('body').css('background','red url(/website/img/shop/paymentBack.jpg) no-repeat center center');
        // },2000);
    </script>
</body>
</html>
