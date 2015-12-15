/**
 * Created by Serdar Saygili on 15.12.2015.
 */
var cManagement = new function () {
    var _self = this;
    this.objectName = "cManagement";

    this.settingSave = function () {
        cCommon.save('banners_setting', undefined, 'bannerForm');
    };

    this.createNewBanner = function (applicationID) {
        cCommon.save(
            this.objectName,
            function () {
                cNotification.success();
                window.location = '/' + currentLanguage + '/' + route[_self.objectName] + '?applicationID=' + applicationID;
            },
            undefined,
            "&newBanner=1"
        );
    };

    this.delete = function (id) {
        var url = "/banners/delete";
        var rowIDPrefix = "bannerIDSet_";
        cCommon.delete(url, id, rowIDPrefix);
    };

    //this.saveFromList = function (id) {
    //
    //};

    // this.targetContent = function () {
    //  var selectedIndex = $('#TargetContent option:selected').index();
    //  console.log(selectedIndex);
    //  if(selectedIndex==0){
    //  	$('#TargetUrl, #TargetUrl + *').removeClass('noTouch').css('opacity',1);
    //  }
    //  else {
    //  	$('#TargetUrl, #TargetUrl + *').addClass('noTouch').css('opacity',0.5);
    //  }
    // };
};