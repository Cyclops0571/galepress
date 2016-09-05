<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>
<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>GalePress Shop</title>
    <meta name="keywords" content="GalePress, Paketler"/>
    <meta name="description" content="GalePress paket bilgilerinin bulunduğu sayfa.">
    <meta name="author" content="GalePress">
    <link type="text/css" media="all" href="/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
    <div class="col-md-12">
        <form method="post">
            <input type="hidden" name="callback" value="<?php echo $cb; ?>"/>
            <input type="hidden" name="qrCodeClientId" value="<?php echo $id; ?>"/>
            <input type="hidden" name="price" value="<?php echo $price; ?>"/>
            <h3 class="col-xs-12">Fatura Bilgileri</h3>
            <div class="form-group">
                <label><h4>Fiyat: <?php echo $price; ?> </h4></label>
            </div>
            <div class="form-group">
                <input id="nameSurname" class="form-control" maxlength="50" name="name" size="50"
                       type="text" tabindex="1" placeholder="İsim Soyisim" required/>
            </div>
            <div class="form-group">
                <input id="email" class="form-control" maxlength="50" name="email" size="50"
                       type="email" tabindex="2" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input id="phone" maxlength="14" name="phone" size="20" type="text"
                       class="form-control" tabindex="3" placeholder="Telefon" required>
            </div>
            <div class="form-group">
                <input class="form-control" id="tc" name="tc" type="text" maxlength="11"
                       tabindex="3" placeholder="T. C. Kimlik Numarası" required/>
            </div>
            <div class="form-group">
                <select id="city" class="form-control required" name="city" tabindex="6" required>
                    <option selected="selected" disabled="disabled">Lütfen Şehir Seçin</option>
                    <?php foreach ($city as $c): ?>
                        <option value="<?php echo $c->CityName; ?>">
                            <?php echo $c->CityName; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
            <textarea id="address" class="form-control" maxlength="100" name="address" rows="4"
                      tabindex="6" placeholder="Adres Bilgisi (Sok. No, Konut No)" required ></textarea>
            </div>
            <button class="btn btn-primary" id="payBtn" type="submit">Devam Et</button>
        </form>
    </div>
</div>
</body>
</html>