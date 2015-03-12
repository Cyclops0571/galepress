@layout('website.html')

@section('body-content')

      <section class="sep-bottom-2x">
        <div class="container">
          <div class="row">
            <div class="col-md-6 sep-top-2x">
              <h4 class="upper">İLETİŞİM</h4>
              <div class="contact-form">
                <div id="successMessage" style="display:none" class="alert alert-success text-center">
                  <p><i class="fa fa-check-circle fa-2x"></i></p>
                  <p>Teşekkür ederiz. Mesajınız tarafımıza iletilmiştir.</p>
                </div>
                <div id="failureMessage" style="display:none" class="alert alert-danger text-center">
                  <p><i class="fa fa-times-circle fa-2x"></i></p>
                  <p>Bir problem oluştu. Lütfen daha sonra tekrar deneyiniz.</p>
                </div>
                <div id="incompleteMessage" style="display:none" class="alert alert-warning text-center">
                  <p><i class="fa fa-exclamation-triangle fa-2x"></i></p>
                  <p>Lütfen tüm alanları doldurunuz.</p>
                </div>
                <form id="contactForm" action="/website/php/contact.php" method="post" class="form-gray-fields validate">
                  <div class="row">
                    <div class="col-md-6 sep-top-xs">
                      <div class="form-group">
                        <label for="name">İsim</label>
                        <input id="name" type="text" name="senderName" class="form-control input-lg required" placeholder="İsminizi girin...">
                      </div>
                    </div>
                    <div class="col-md-6 sep-top-xs">
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="senderEmail" class="form-control input-lg required email" placeholder="Email adresinizi girin...">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 sep-top-xs">
                      <div class="form-group">
                        <label for="phone">Telefon</label>
                        <input id="phone" type="text" name="phone" class="form-control input-lg required" placeholder="Telefon bilgisi girin...">
                      </div>
                    </div>
                    <div class="col-md-6 sep-top-xs">
                      <div class="form-group">
                        <label for="phone">Şirket</label>
                        <input id="company" type="text" name="company" class="form-control input-lg required" placeholder="Şirketinizi belirtin...">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 sep-top-xs">
                      <div class="form-group">
                        <label for="comment">Yorumunuz</label>
                        <textarea id="comment" rows="9" name="comment" class="form-control input-lg required" placeholder="Yorumunuzu ekleyin..."></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 sep-top-xs">
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i>&nbsp;Gönder</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-6 sep-top-2x">
              <h4 class="upper">Lokasyon</h4>
              <div class="sep-top-xs">
                <div id="map-canvas" style="height:500px">
                  <script>
                    var
                      lat = 41.024272,
                      lon = 29.083097,
                      infoText = [
                        '<div style="white-space:nowrap">',, 
                          '<h5>Detaysoft</h5>',
                          'Alemdağ Cad. No: 109<br>',
                          'Üsküdar / İstanbul / Türkiye<br>',
                          '34692, Turkey',
                        '</div>'
                      ],
                      mapOptions = {
                        scrollwheel: false,
                        markers: [
                          { latitude: lat, longitude: lon, html: infoText.join('') }
                        ],
                        icon: {
                          image: '/website/img/themes/royalblue/marker.png',
                          iconsize: [72, 65],
                          iconanchor: [12, 65],
                        },
                        latitude: lat,
                        longitude: lon,
                        zoom: 16
                      };
                  </script>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection