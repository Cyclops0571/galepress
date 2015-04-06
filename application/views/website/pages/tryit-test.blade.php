@layout('website.html')

@section('body-content')

<style type="text/css">

.centered-form{
  margin-top: 60px;
}
.centered-form .panel{
  /*background: rgba(255, 255, 255, 0.8);
  box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;*/
  background: transparent;
}
.btn-info{
  background-color: #608FE0;
  border-color: black;
}
.tryit-form .reset {
  background-color: transparent;
}
.tryit-form .panel-transparent-row{
  background: transparent;
  height: 10px;
}
.tryit-form .panel-heading{
  background-color: rgba(222,222,222,0.80);
}
.tryit-form .panel-footing{
  background-color: rgba(222,222,222,0.80);
}
.tryit-form .panel-body{
  background-color: rgba(222,222,222,0.80);
}
.tryit-form .panel-title{
  font-size: 25px;
  text-align: center;
}
#tryit-form label{
  color: dimgrey;
}
.tryit-form .form-control{
  color: #555;
}
.tryit-form .formError{
  background-color: #F7B7BA;
}
.tryit-form .ng-dirty.ng-invalid {
  background-color: #F7B7BA;
}
.tryit-form .ng-valid {
  background-color: #86E091;
}
.tryit-form em{
  color:#CF1A1A;
}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.13/angular.min.js"></script>

    <section id="tryit" class="sep-top-3x sep-bottom-3x" style="background-image: url(/website/img/sectors/backgroundBlur.jpg);" class="header-section">
      <div class="container">
        <div class="row centered-form">
          <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" ng-app="websiteApp">
              <form name="form" ng-submit="submitForm()" ng-controller="FormController" class="tryit-form" novalidate>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">{{__('website.tryit_form_title')}} <small>{{__('website.tryit_form_subtitle')}}</small></h3>
                  </div>
                  <div class="panel-transparent-row"></div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                          <label for="name">Facebook Hesabınız ile Uygulama Oluşturun}</label>
                          <script>
                          // This is called with the results from from FB.getLoginStatus().
                          function statusChangeCallback(response) {
                            console.log('statusChangeCallback');
                            console.log(response);
                            // The response object is returned with a status field that lets the
                            // app know the current login status of the person.
                            // Full docs on the response object can be found in the documentation
                            // for FB.getLoginStatus().
                            if (response.status === 'connected') {
                              // Logged into your app and Facebook.
                              testAPI();
                            } else if (response.status === 'not_authorized') {
                              // The person is logged into Facebook, but not your app.
                              document.getElementById('status').innerHTML = 'Please log ' +
                                'into this app.';
                            } else {
                              // The person is not logged into Facebook, so we're not sure if
                              // they are logged into this app or not.
                              document.getElementById('status').innerHTML = 'Please log ' +
                                'into Facebook.';
                            }
                          }

                          // This function is called when someone finishes with the Login
                          // Button.  See the onlogin handler attached to it in the sample
                          // code below.
                          function checkLoginState() {
                            FB.getLoginStatus(function(response) {
                              statusChangeCallback(response);
                            });
                          }

                          window.fbAsyncInit = function() {
                          FB.init({
                            appId      : '583822921756369',
                            cookie     : true,  // enable cookies to allow the server to access 
                                                // the session
                            xfbml      : true,  // parse social plugins on this page
                            version    : 'v2.2' // use version 2.2
                          });

                          // Now that we've initialized the JavaScript SDK, we call 
                          // FB.getLoginStatus().  This function gets the state of the
                          // person visiting this page and can return one of three states to
                          // the callback you provide.  They can be:
                          //
                          // 1. Logged into your app ('connected')
                          // 2. Logged into Facebook, but not your app ('not_authorized')
                          // 3. Not logged into Facebook and can't tell if they are logged into
                          //    your app or not.
                          //
                          // These three cases are handled in the callback function.

                          FB.getLoginStatus(function(response) {
                            statusChangeCallback(response);
                          });

                          };

                          // Load the SDK asynchronously
                          (function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "//connect.facebook.net/en_US/sdk.js";
                            fjs.parentNode.insertBefore(js, fjs);
                          }(document, 'script', 'facebook-jssdk'));

                          // Here we run a very simple test of the Graph API after login is
                          // successful.  See statusChangeCallback() for when this call is made.
                          function testAPI() {
                            console.log('Welcome!  Fetching your information.... ');
                            FB.api('/me', function(response) {
                              console.log('Successful login for: ' + response.name);
                              document.getElementById('status').innerHTML =
                                'Thanks for logging in, ' + response.name + '!';
                                console.log(JSON.stringify(response));

                                    $.ajax({
                                        type: "POST",
                                        url: "appcreatewithface",
                                        data: {
                                            formData: JSON.stringify(response)
                                        }
                                    }).success(function(msg) {
                                        
                                        console.log(msg)
                                        //alert('Mail Başarıyla Gönderildi!');
                                        //location.reload();
                                    }).fail(function(msg) {
                                        //console.log(f);
                                        console.log(msg)
                                    })
                            });
                          }
                        </script>

                        <!--
                          Below we include the Login Button social plugin. This button uses
                          the JavaScript SDK to present a graphical Login button that triggers
                          the FB.login() function when clicked.
                        -->

                        <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                        </fb:login-button>

                        <div id="status">
                        </div>
                        <div id="fb-root"></div>
                        </div>
                      </div>               
                      <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                          <label for="name">{{__('website.tryit_form_name')}}</label>
                          <input type="text" id="name" name="name" ng-model="formData.name" ng-class="{'ng-invalid ng-invalid-required formError' : errorName}" required class="form-control input-sm" placeholder="{{__('website.tryit_form_name_placeholder')}}">
                          <div ng-show="form.$submitted || form.name.$touched">
                            <em ng-show="form.name.$error.required">{{__('website.tryit_form_name_placeholder')}}</em>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                          <label for="last_name">{{__('website.tryit_form_lastname')}}</label>
                          <input type="text" id="last_name" name="last_name" ng-model="formData.last_name" ng-class="{'ng-invalid ng-invalid-required formError' : errorLastName}" required class="form-control input-sm" placeholder="{{__('website.tryit_form_lastname_placeholder')}}">
                          <div ng-show="form.$submitted || form.last_name.$touched">
                            <em ng-show="form.last_name.$error.required">{{__('website.tryit_form_lastname_placeholder')}}</em>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputEmail">{{__('website.tryit_form_email')}}</label>
                      <input id="inputEmail" type="email" name="email" ng-model="formData.email" ng-class="{'ng-invalid ng-invalid-required formError' : errorEmail}" required class="form-control input-sm" placeholder="{{__('website.tryit_form_email_placeholder')}}">
                      <div ng-show="form.$submitted || form.email.$touched">
                        <em ng-show="form.email.$error.required">{{__('website.tryit_form_email_placeholder')}}</em>
                        <em ng-show="form.email.$error.email">{{__('website.tryit_form_error_email')}}</em>
                        <em ng-show="emailExist">{{__('website.tryit_form_error2_email')}}</em>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="app_name">{{__('website.tryit_form_appname')}}</label>
                      <input type="text" id="app_name" name="app_name" ng-model="formData.app_name" ng-class="{'ng-invalid ng-invalid-required formError' : errorAppName}" required class="form-control input-sm" placeholder="{{__('website.tryit_form_appname_placeholder')}}">
                      <div ng-show="form.$submitted || form.app_name.$touched">
                        <em ng-show="form.app_name.$error.required">{{__('website.tryit_form_appname_placeholder')}}</em>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="user_name">{{__('website.tryit_form_username')}}</label>
                      <input type="text"id="user_name" name="user_name" ng-model="formData.user_name" ng-class="{'ng-invalid ng-invalid-required formError' : errorUserName}" required class="form-control input-sm" placeholder="{{__('website.tryit_form_username_placeholder')}}">
                      <div ng-show="form.$submitted || form.user_name.$touched">
                        <em ng-show="form.user_name.$error.required">{{__('website.tryit_form_username_placeholder')}}</em>
                      </div>
                      <div ng-show="userExist">
                        <em>{{__('website.tryit_form_error_user')}}</em>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                          <label for="password">{{__('website.tryit_form_pass')}}</label>
                          <input type="password" id="password" name="password" ng-model="formData.password" ng-class="{'ng-invalid ng-invalid-required formError' : errorPassword}" required class="form-control input-sm" placeholder="{{__('website.tryit_form_pass_placeholder')}}">
                          <em class="col-xs-12 col-sm-12 col-md-12" ng-show="errorPasswordVerify">{{__('website.tryit_form_error_pass')}}</em>
                        </div>
                      </div>
                      <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                          <label for="password_verify">{{__('website.tryit_form_pass2')}}</label>
                          <input type="password" id="password_verify" name="password_verify" ng-model="formData.password_verify" nx-equal="formData.password" ng-class="{'ng-invalid ng-invalid-required formError' : errorPasswordVerify}" required class="form-control input-sm" placeholder="{{__('website.tryit_form_pass2_placeholder')}}">
                          <em class="col-xs-12 col-sm-12 col-md-12" ng-show="errorPasswordVerify">{{__('website.tryit_form_error_pass')}}</em>
                          <span ng-show="form.password_verify.$error.nxEqual">{{__('website.tryit_form_error_pass')}}</span>
                        </div>
                      </div> 
                    </div>
                    <div class="row">
                      <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                          <label for="captcha">{{__('website.tryit_form_securitycode')}}</label>
                          <input class="captchainput form-control input-sm" placeholder="{{__('website.tryit_form_securitycode_placeholder')}}" id="captcha" name="captcha" ng-model="formData.captcha" ng-class="{'ng-invalid ng-invalid-required formError' : errorCaptcha}" required type="text">
                          <div ng-show="form.$submitted || form.captcha.$touched">
                            <em ng-show="form.captcha.$error.required">{{__('website.tryit_form_securitycode_placeholder')}}</em>
                            <em ng-show="errorCaptchaInvalid">{{__('website.tryit_form_error_securitycode')}}</em>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group" onclick="changeCaptcha()" style="cursor:pointer">
                          <input class="captchaimg noTouch" src="{{MeCaptcha\Captcha::img()}}" name="captcha" id="captcha" type="image" style="margin-top:26.05px;">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel-transparent-row"></div>
                  <!-- <div class="row panel-footing">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <input type="submit" value="Create account" class="btn btn-primary btn-block">
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <a class="btn btn-primary btn-block">Return to sign in</a>
                      </div>
                    </div>
                  </div> -->
                  <div class="panel-heading" style="display:-webkit-box !important; min-height:80px;">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <input type="submit" value="{{__('website.tryit_form_submit')}}" class="btn btn-primary btn-block" style="outline:none;">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <a href="/{{ Session::get('language') }}/{{__('route.login')}}" class="btn btn-bordered btn-block">{{__('website.tryit_form_return')}}</a>
                    </div>
                  </div>
                </div>
              </form>
          </div>
        </div>
      </div>
    </section>

    <script>
    function changeCaptcha() {
      // var captchaUrl=document.getElementById("captcha").src;
      // var captchaPrevParam=captchaUrl.substr(0,captchaUrl.indexOf("?"));
      // captchaNextParam = parseInt(captchaUrl.substr(captchaUrl.indexOf("?")+1))+1;
      // document.getElementById("captcha").src = captchaPrevParam+"?"+captchaNextParam;
      location.reload();
    }
    // creating Angular Module
    var websiteApp = angular.module('websiteApp', []);
    // create angular controller and pass in $scope and $http

    //FOR PASSWORDS MATCH
    websiteApp.directive('nxEqual', function() {
        return {
            require: 'ngModel',
            link: function (scope, elem, attrs, model) {
                if (!attrs.nxEqual) {
                    //console.error('nxEqual expects a model as an argument!');
                    return;
                }
                scope.$watch(attrs.nxEqual, function (value) {
                    model.$setValidity('nxEqual', value === model.$viewValue);
                });
                model.$parsers.push(function (value) {
                    var isValid = value === scope.$eval(attrs.nxEqual);
                    model.$setValidity('nxEqual', isValid);
                    return isValid ? value : undefined;
                });
            }
        };
    });
    websiteApp.controller('FormController',function($scope, $http) {
      //$scope will allow this to pass between controller and view
      $scope.master = {};

      $scope.reset = function(form) {
        if (form) {
          form.$setPristine();
          form.$setUntouched();
        }
        $scope.formData = angular.copy($scope.master);
      };



      var param = function(data) {
            var returnString = '';
            for (d in data){
                if (data.hasOwnProperty(d))
                   returnString += d + '=' + data[d] + '&';
            }
            // Remove last ampersand and return
            return returnString.slice( 0, returnString.length - 1 );
      };
      $scope.submitForm = function() {
        $http({
        method : 'POST',
        url : "asd",//{{__('route.website_tryit_test')}}
        data : param($scope.formData), // pass in data as strings
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' } // set the headers so angular passing info as form data (not request payload)
      })
        .success(function(data) {
          if (!data.success) {
           // if not successful, bind errors to error variables
           //console.log("hakan",data.errors.name);
          $scope.errorName = data.errors.name;
          $scope.errorLastName = data.errors.last_name;
          $scope.errorEmail = data.errors.email;
          $scope.errorUserName = data.errors.user_name
          $scope.errorAppName = data.errors.app_name;
          $scope.userExist = data.errors.user_name_exist;
          $scope.emailExist = data.errors.email_exist;
          $scope.errorPassword = data.errors.password;
          $scope.errorPasswordVerify = data.errors.password_verify;
          $scope.errorCaptcha = data.errors.captcha;
          $scope.errorCaptchaInvalid = data.errors.captcha_invalid;

          //console.log(data);

          }else {
            $scope.userExist=false;
            //$scope.reset($scope.form);

            setTimeout(function(){
              //window.location.href = '/tr/giris';
              //alert("Mail adresinize iletilen linke tıklayarak hesabınızı aktifleştiriniz.");
            },750);
            alert("{{__('website.tryit_form_message_mail')}}");


            /*Google Code for Website Conversion Galepress Conversion*/
            /* <![CDATA[ */
            var google_conversion_id = 980149592;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "vsCnCMHg-VoQ2Mqv0wM";
            var google_conversion_value = 50.00;
            var google_conversion_currency = "TRY";
            var google_remarketing_only = false;
            /* ]]> */

          }
        });
      };
    });
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
    <noscript>
    <div style="display:inline;">
      <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/980149592/?value=50.00&amp;currency_code=TRY&amp;label=vsCnCMHg-VoQ2Mqv0wM&amp;guid=ON&amp;script=0"/>
    </div>
    </noscript>

@endsection