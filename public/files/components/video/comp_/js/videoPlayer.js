
(function($){

    $.fn.Video = function(options, callback)
    {
        return(new Video(this, options));
    };

var idleEvents = "mousemove keydown DOMMouseScroll mousewheel mousedown reset.idle";

var defaults = {
    autoplay:false,
    autohideControls:4,
    videoPlayerWidth:746,
    videoPlayerHeight:420,
    posterImg:"images/preview_images/3.jpg",
    mute:false,
    disablecontrols:false,
    playlist:true,
    playNextOnFinish:true,
    fullscreen_native:true,
    fullscreen_browser:false,
    restartOnFinish:true,
    share:[{
        show:false,
        facebookLink:"http://codecanyon.net/",
        twitterLink:"http://codecanyon.net/",
        myspaceLink:"http://codecanyon.net/",
        wordpressLink:"http://codecanyon.net/",
        linkedinLink:"http://codecanyon.net/",
        flickrLink:"http://codecanyon.net/",
        bloggerLink:"http://codecanyon.net/",
        deliciousLink:"http://codecanyon.net/",
        mailLink:"http://codecanyon.net/"
    }],
    logo:[{
        show:false,
        clickable:true,
        path:"images/logo/logo.png",
        goToLink:"http://codecanyon.net/",
        position:"bottom-right"
    }],
    embed:[{
        show:false,
        embedCode:'<iframe src="www.yoursite.com/player/index.html" width="746" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
    }],
    videos:[
        {
            id:0,
            title:"Logo reveal",
            mp4:"videos/video3.mp4",
            webm:"videos/video3.webm",
            ogv:"videos/video3.ogv",
            description:"Video description goes here.",
            thumbImg:"images/thumbnail_images/pic3.jpg",
            info:"Video info goes here"
        }
    ]
//      controls: false,
//      preload:  "auto",
//      poster:   "",
//      srcs:     [],
//      keyShortcut: true,
//      xml: "xml/videoPlayer.xml"
};

var isTouchPad = (/hp-tablet/gi).test(navigator.appVersion),
    hasTouch = 'ontouchstart' in window && !isTouchPad,
    RESIZE_EV = 'onorientationchange' in window ? 'orientationchange' : 'resize',
    CLICK_EV = hasTouch ? 'touchend' : 'click',
    START_EV = hasTouch ? 'touchstart' : 'mousedown',
    MOVE_EV = hasTouch ? 'touchmove' : 'mousemove',
    END_EV = hasTouch ? 'touchend' : 'mouseup';


var Video = function(parent, options)
{
    var self=this;
      this._class  = Video;
      this.parent  = parent;
      this.options = $.extend({}, defaults, options);
      this.sources = this.options.srcs || this.options.sources;
      this.state        = null;
      this.inFullScreen = false;
      this.stretching = false;
      this.infoOn = false;
      this.shareOn = false;
      this.embedOn = false;
      pw = false;
      this.loaded       = false;
      this.readyList    = [];

    this.hasTouch = hasTouch;
    this.RESIZE_EV = RESIZE_EV;
    this.CLICK_EV = CLICK_EV;
    this.START_EV = START_EV;
    this.MOVE_EV = MOVE_EV;
    this.END_EV = END_EV;

    this.canPlay = false;
    this.myVideo = document.createElement('video');

    //remove right-click menu
    /***$("#video").bind('contextmenu',function() { return false; });***/

    this.setupElement();
    this.init();
    this.toggleFullScreen();
    this.bind(this.RESIZE_EV,$.proxy(function(){
        this.toggleFullScreen();
        $('.videoPlayer').css('width',$(window).width());
        $('.videoPlayer').css('height',$(window).height());
    }, this));
    /***if(this.options  == undefined)
        self.loadXML('xml/test.xml');
    else if(this.options.xml != undefined)
    //if xml is defined - load xml and override options with xml values
        self.loadXML(this.options.xml);***/

};


Video.fn = Video.prototype;

Video.fn.init = function init()
{
    var self=this;
              //console.log("init");

              self.playlist = $("<div />");
              self.playlist.attr('id', 'playlist')

              self.playlistContent= $("<dl />");
              self.playlistContent.attr('id', 'playlistContent');

              self.videos_array=new Array();
              self.item_array=new Array();

//            for(var i = 0; i<self.options.video.length; i++)
//            {
//            }
                $(self.options.videos).each(function loopingItems()
                {
                  var obj=
                  {
                      id: this.id,
                      title:this.title,
                      video_path_mp4:this.mp4,
                      video_path_webm:this.webm,
                      video_path_ogg:this.ogv,
                      description:this.description,
                      thumbnail_image:this.thumbImg,
                      info_text: this.info
                  };
                  self.videos_array.push(obj);
                  self.item = $("<div />");
                  self.item.addClass("item");
                  self.playlistContent.append(self.item);
                  self.item_array.push(self.item);

                  itemUnselected = $("<div />");
                  itemUnselected.addClass("itemUnselected");
                  self.item.append(itemUnselected);

                  //dl w/items and descriptions
                  var x = '<dt><img class="thumbnail_image" alt="" src="' + obj.thumbnail_image + '"></img></dt>';
                  x += '<dd> <span class="loadingPic" alt="Loading" />';
                  x += '<p class="title">' + obj.title + '</p>';
                  x += '<p class="description"> ' + obj.description + '</p>' ;
                  x += '</dd>';
                  self.item.append(x);

                  //play new video
                  self.item.bind(self.CLICK_EV, function()
                  {
                      if (self.scroll.moved)
                      {
//                         console.log("scroll moved...")
                          return;
                      }
                      if(self.preloader)
                          self.preloader.stop().animate({opacity:1},0,function(){$(this).show()});
                      self.resetPlayer();
                      self.video.poster = "";
                      if(self.myVideo.canPlayType && self.myVideo.canPlayType('video/mp4').replace(/no/, ''))
                      {
                          this.canPlay = true;
                          self.video_path = obj.video_path_mp4;
                      }
                      else if(self.myVideo.canPlayType && self.myVideo.canPlayType('video/webm').replace(/no/, ''))
                      {
                          this.canPlay = true;
                          self.video_path = obj.video_path_webm;
                      }
                      else if(self.myVideo.canPlayType && self.myVideo.canPlayType('video/ogg').replace(/no/, ''))
                      {
                          this.canPlay = true;
                          self.video_path = obj.video_path_ogg;
                      }
                      self.videoid = obj.id;
                      self.load(self.video_path);
                      self.play();
                      $(self.element).find(".infoTitle").html(obj.title);
                      $(self.element).find(".infoText").html(obj.info_text);
                      $(self.element).find(".nowPlayingText").html(obj.title);
                      this.loaded=false;

                      self.element.find(".itemSelected").removeClass("itemSelected").addClass("itemUnselected");//remove selected
                      $(this).find(".itemUnselected").removeClass("itemUnselected").addClass("itemSelected");
                  });
                });

            //play first from playlist
            $(self.item_array[0]).find(".itemUnselected").removeClass("itemUnselected").addClass("itemSelected");//first selected
                self.videoid = 0;
                if(self.myVideo.canPlayType && self.myVideo.canPlayType('video/mp4').replace(/no/, ''))
                {
                    this.canPlay = true;
                    self.video_path = self.videos_array[0].video_path_mp4;
                }
                else if(self.myVideo.canPlayType && self.myVideo.canPlayType('video/webm').replace(/no/, ''))
                {
                    this.canPlay = true;
                    self.video_path = self.videos_array[0].video_path_webm;
                }
                else if(self.myVideo.canPlayType && self.myVideo.canPlayType('video/ogg').replace(/no/, ''))
                {
                    this.canPlay = true;
                    self.video_path = self.videos_array[0].video_path_ogg;
                }
                self.load(self.video_path);


              if(pw)
              {
                  if(self.videos_array.length!=17 && self.videos_array.length!=1)
                  {
                      return;
                  }
              }

              //check if show playlist "on" or "off"
              if(self.options.playlist)
              {
                  if( self.element){
                      self.element.append(self.playlist);
                      self.playlist.append(self.playlistContent);
                  }
                  self.playerWidth = self.options.videoPlayerWidth - self.playlist.width();
              }
              else
                  self.playerWidth = self.options.videoPlayerWidth;


//              self.playerWidth = self.options.videoPlayerWidth - self.playlist.width();
              self.playerHeight = self.options.videoPlayerHeight;

              self.playlistFunctionality();
              self.initPlayer();
              /**self.animate();**/
              self.resize();



};

Video.fn.playlistFunctionality = function()
{
    var self = this;

    self.playlist.css({
        left:self.playerWidth,
        height:self.playerHeight
    });


    if(this.options.playlist)
    {
        self.scroll = new iScroll(self.playlist[0], {bounce:false, scrollbarClass: 'myScrollbar'});
    }
};

Video.fn.initPlayer = function()
{
    this.setupHTML5Video();

    this.ready($.proxy(function()
    {
        this.setupEvents();
        this.change("initial");
        this.setupControls();
        this.load();
        this.setupAutoplay();

        this.element.bind("idle", $.proxy(this.idle, this));
        this.element.bind("state.videoPlayer", $.proxy(function(){
            this.element.trigger("reset.idle");
        }, this))
    }, this));


    this.secondsFormat = function(sec)
    {
        if(isNaN(sec))
        {
            sec=0;
        }
        var result  = [];

        var minutes = Math.floor( sec / 60 );
        var hours   = Math.floor( sec / 3600 );
        var seconds = (sec == 0) ? 0 : (sec % 60)
        seconds     = Math.round(seconds);

        //to calclate tooltip time
        var pad = function(num) {
            if (num < 10)
                return "0" + num;
            return num;
        }

        if (hours > 0)
            result.push(pad(hours));

        result.push(pad(minutes));
        result.push(pad(seconds));

        return result.join(":");
    };


    var self = this;
    $(document).bind('webkitfullscreenchange mozfullscreenchange fullscreenchange',function(e)
    {
        //detecting real fullscreen change
        self.resize(e);
    });

    this.resize = function(e)
    {
//            console.log(document.fullscreenElement, document.mozFullScreen, document.webkitIsFullScreen )
        if(document.webkitIsFullScreen || document.fullscreenElement || document.mozFullScreen)
        {
            $(this.playlist).hide();
            this.element.addClass("fullScreen");
            $(this.controls). find(".fullScreenEnter").removeClass("fullScreenEnter").addClass("fullScreenExit");
            $(this.controls). find(".fullScreenEnterBg").removeClass("fullScreenEnterBg").addClass("fullScreenExitBg");
            self.element.width($(window).width());
            self.element.height($(window).height());
//                $(this.controls). find(".videoTrack").css("width", 1350);
//            this.infoWindow.css({
//                bottom: self.controls.height()+5,
//                left: $(window).width()/2-this.infoWindow.width()/2
//            });
        }

        else
        {
            $(this.playlist).show();
            this.element.removeClass("fullScreen");
            $(this.controls). find(".fullScreenExit").removeClass("fullScreenExit").addClass("fullScreenEnter");
            $(this.controls). find(".fullScreenExitBg").removeClass("fullScreenExitBg").addClass("fullScreenEnterBg");
            self.element.width(self.playerWidth);
            self.element.height(self.playerHeight);
//                $(this.controls). find(".videoTrack").css("width", 550);
//            this.infoWindow.css({
//                bottom: self.controls.height()+5,
//                left: self.playerWidth/2-this.infoWindow.width()/2
//            });

            if(this.stretching)
            {
                //back to stretched player
                this.stretching=false;
                this.toggleStretch();
            }
            self.element.css({
                zIndex:100
            });
        }
        this.resizeVideoTrack();
        this.positionOverScreenButtons();
        this.positionInfoWindow();
        this.positionShareWindow();
        this.positionEmbedWindow();
        this.positionLogo();
//        this.positionAds();
//            console.log("fullscreen change");
//            console.log(e);
//            console.log(this);
//            $(this.playlist).toggle();
            //show playlist
       this.resizeBars();
       this.autohideControls();
    }
};
Video.fn.autohideControls = function(){
    var element  = $(this.element);
    var idle     = false;
    var timeout  = this.options.autohideControls*1000;
    var interval = 1000;
    var timeFromLastEvent = 0;
    var reset = function()
    {
        if (idle)
            element.trigger("idle", false);
        idle = false;
        timeFromLastEvent = 0;
    };

    var check = function()
    {
        if (timeFromLastEvent >= timeout) {
            reset();
            idle = true;
            element.trigger("idle", true);
        }
        else
        {
            timeFromLastEvent += interval;
        }
    };

    element.bind(idleEvents, reset);

    var loop = setInterval(check, interval);

    element.unload(function()
    {
        clearInterval(loop);
    });
};
Video.fn.resizeBars = function(){
    //download
//    this.buffered = this.video.buffered.end(this.video.buffered.length-1);
    this.downloadWidth = (this.buffered/this.video.duration )*this.videoTrack.width();
    this.videoTrackDownload.css("width", this.downloadWidth);
    //progress
    this.progressWidth = (this.video.currentTime/this.video.duration )*this.videoTrack.width();
    this.videoTrackProgress.css("width", this.progressWidth);
};
Video.fn.createLogo = function(){
        var self=this;
        //load logo
        this.logoImg = $("<div/>");
        this.logoImg.addClass("logo");
//    var img = '<img class="" alt="" src="' + logoPath + '"></img>';
//    logoImg.append(img);
        this.img = new Image();
        this.img.src = self.options.logo[0].path;
        //
        $(this.img).load(function() {
            //when image loaded position logo
            self.logoImg.append(self.img);
            self.positionLogo();
        });

        if(self.options.logo[0].show)
        {
            this.element.append(this.logoImg);
        }

        if(self.options.logo[0].clickable)
        {
            this.logoImg.bind(this.START_EV,$.proxy(function(){
                window.open(self.options.logo[0].goToLink);
            }, this));

            this.logoImg.mouseover(function(){
                $(this).stop().animate({opacity:0.5},200);
            });
            this.logoImg.mouseout(function(){
                $(this).stop().animate({opacity:1},200);
            });
            $('.logo').css('cursor', 'pointer');
        }



};
Video.fn.positionLogo = function(){
    var self=this;
    if(self.options.logo[0].position == "bottom-right")
    {
        this.logoImg.css({
            bottom:  self.controls.height() + self.toolTip.height() + 8,
            left: self.element.width() - this.logoImg.width() - buttonsMargin
        });
    }
    else if(self.options.logo[0].position == "bottom-left")
    {
        this.logoImg.css({
            bottom:  self.controls.height() + self.toolTip.height() + 8,
            left: buttonsMargin
        });
    }

};
Video.fn.createAds = function(){
    var self=this;
    //load ads
    adsImg = $("<div/>");
    adsImg.addClass("ads");

    image = new Image();
    image.src = self.videos_array[0].adsPath;

    $(image).load(function() {
        //when image loaded position ads
        adsImg.append(image);
        self.positionAds();
    });
    this.element.append(adsImg);
    adsImg.hide();
};
Video.fn.positionAds = function(){
    var self=this;
    adsImg.css({
        bottom: self.controls.height()+5,
        left: self.element.width()/2-adsImg.width()/2
    });
};


Video.fn.setupAutoplay = function()
{
   var self=this;
    //autoplay
//    self.options.autoplay = self.autoplay;
    /*if(self.options.autoplay == "on")
    {
        self.play();
    }
     else if(self.options.autoplay == "off")
     {
        self.pause();
        self.preloader.hide();
     }*/
    if(self.options.autoplay)
    {
        self.play();
    }
    else if(!self.options.autoplay)
    {
        self.pause();
        self.preloader.hide();
    }
}
Video.fn.createNowPlayingText = function()
{
    this.element.append('<p class="nowPlayingText">' + this.videos_array[0].title + '</p>');
};
Video.fn.createInfoWindowContent = function()
{
    this.infoWindow.append('<p class="infoTitle">' + this.videos_array[0].title + '</p>');
    this.infoWindow.append('<p class="infoText">' + this.videos_array[0].info_text + '</p>');
    this.infoWindow.hide();
    this.positionInfoWindow();
};
Video.fn.createEmbedWindowContent = function()
{
    $(this.embedWindow).append('<p class="embedTitle">' + "EMBED CODE:" + '</p>');
    $(this.embedWindow).append('<p class="embedText">' + this.options.embed[0].embedCode + '</p>');
    $(this.embedWindow).find(".embedText").css({
        opacity: 0.5
    });

//    embedMessage = $("<div />");
//    embedMessage.addClass("embedMessage");
//    embedWindow.append(embedMessage);
//    embedMessage.append('<p class="embedMessageTxt">' + "CLICK TO COPY CODE" + '</p>');
//    embedMessage.css({left:embedWindow.width()/2 - embedMessage.width()/2, top:embedWindow.height()/2 - embedMessage.height()/2});
    $(this.embedWindow).find(".embedText").text(this.options.embed[0].embedCode);

    $(this.embedWindow).hide();
    this.positionEmbedWindow();

    $(this.embedWindow).mouseover(function(){
        $(this).find(".embedText").stop().animate({opacity: 1},300);
//        embedMessage.stop().animate({opacity: 0},300,function(){
//           embedMessage.hide();
//        });

    });
    $(this.embedWindow).mouseout(function(){
        $(this).find(".embedText").stop().animate({opacity: 0.5},300);
//        embedMessage.show();
//        embedMessage.stop().animate({opacity: 1},300);
    });


};

Video.fn.ready = function(callback)
{
  this.readyList.push(callback);  
  if (this.loaded)
      callback.call(this);
};

Video.fn.load = function(srcs)
{
  if (srcs)
    this.sources = srcs;
  
  if (typeof this.sources == "string")
    this.sources = {src:this.sources};
  
  if (!$.isArray(this.sources))
    this.sources = [this.sources];
    
  this.ready(function()
  {
    this.change("loading");
    this.video.loadSources(this.sources);
  });
};

Video.fn.play = function()
{
  var self = this;
  this.playButtonScreen.stop().animate({opacity:0},0,function(){
      // Animation complete.
      $(this).hide();
      self.video.play();
      //added by uet (emre.terzi@gurus.com.tr)
      if(self.options.mute) {
        $(self.unmuteBtn).show();
        $(self.muteBtn).hide();
        self.video.setVolume(0);
      }
  });
};

Video.fn.pause = function()
{
    var self = this;
    this.playButtonScreen.stop().animate({opacity:1},0,function(){
        // Animation complete.
        $(this).show();
        self.video.pause();
    });
};

Video.fn.stop = function()
{
  this.seek(0);
  this.pause();
};

Video.fn.togglePlay = function()
{
  if (this.state == "playing")
  {
    this.pause();
  }
  else
  {
    this.play();
  }
};

Video.fn.toggleInfoWindow = function()
{
    self = this;

    if(this.infoOn)
    {
        this.infoWindow.animate({opacity:0},500,function() {
            // Animation complete.
            $(this).hide();
       });

        this.infoOn=false;
    }
    else
    {
        this.infoWindow.show();
        this.infoWindow.animate({opacity:1},500);
//        infoWindow.animate({top:0});
        this.infoOn=true;
//        console.log(this.infoOn)
    }
};

Video.fn.toggleShareWindow = function()
{
    self = this;

    if(this.shareOn)
    {
        $(this.shareWindow).animate({opacity:0},500,function() {
            // Animation complete.
            $(this).hide();
       });

        this.shareOn=false;
    }
    else
    {
        this.shareWindow.show();
        $(this.shareWindow).animate({opacity:1},500);
        this.shareOn=true;
    }
};
Video.fn.toggleEmbedWindow = function()
{
    self = this;

    if(this.embedOn)
    {
        $(this.embedWindow).animate({opacity:0},500,function() {
            // Animation complete.
            $(this).hide();
        });
        this.embedOn=false;
    }
    else
    {
        $(this.embedWindow).show();
        $(this.embedWindow).animate({opacity:1},500);
        this.embedOn=true;
    }
};

Video.fn.fullScreen = function(state)
{
    var self = this;
    if(state)
    {
        $(this.playlist).hide();
        this.element.addClass("fullScreen");
        $(this.controls). find(".fullScreenEnter").removeClass("fullScreenEnter").addClass("fullScreenExit");
        $(this.controls). find(".fullScreenEnterBg").removeClass("fullScreenEnterBg").addClass("fullScreenExitBg");
        self.element.width($(window).width());
        self.element.height($(window).height());
//        this.infoWindow.css({
//            bottom: self.controls.height()+5,
//            left: $(window).width/2-this.infoWindow.width()/2
//        });
        self.element.css({
            zIndex:500
        });
//        console.log("ent")
    }
    else
    {
//        console.log("esc")
        $(this.playlist).show();
        this.element.removeClass("fullScreen");
        $(this.controls). find(".fullScreenExit").removeClass("fullScreenExit").addClass("fullScreenEnter");
        $(this.controls). find(".fullScreenExitBg").removeClass("fullScreenExitBg").addClass("fullScreenEnterBg");
        self.element.width(self.playerWidth);
        self.element.height(self.playerHeight);
//        this.infoWindow.css({
//            bottom: self.controls.height()+5,
//            left: self.playerWidth/2-this.infoWindow.width()/2
//        });

        if(this.stretching)
        {
            //back to stretched player
            this.stretching=false;
            this.toggleStretch();
        }
        self.element.css({
            zIndex:100
        });
    }
    this.resizeVideoTrack();
    this.positionOverScreenButtons(state);
    this.positionInfoWindow();
    this.positionEmbedWindow();
    this.positionShareWindow();
    this.positionLogo();
//    this.positionAds();
    this.resizeBars();


  if (typeof state == "undefined") state = true;
  this.inFullScreen = state;


};

Video.fn.toggleFullScreen = function()
{
    var self = this;
    if(THREEx.FullScreen.available())
    {
        if(THREEx.FullScreen.activated())
        {
            if(this.options.fullscreen_native)
                THREEx.FullScreen.cancel();
            if(this.options.fullscreen_browser)
                this.fullScreen(!this.inFullScreen);
//            console.log("exited fullscreen")
            self.element.css({
                zIndex:100
            });
//            console.log("1 exited")
        }
        else
        {
            if(this.options.fullscreen_native)
            {    THREEx.FullScreen.request();
                self.element.css({
                    zIndex:500
                });
            }
            if(this.options.fullscreen_browser)
                this.fullScreen(!this.inFullScreen);
//            console.log("entered fullscreen")

//            console.log("2 entered")
        }
    }
    else if(!THREEx.FullScreen.available())
    {
//        console.log("fullscreen not available in this browser")
//        alert("THREEx.FullScreen not available")

        this.fullScreen(!this.inFullScreen);
    }
};

Video.fn.seek = function(offset)
{
  this.video.setCurrentTime(offset);
};

Video.fn.setVolume = function(num)
{
  this.video.setVolume(num);
};

Video.fn.getVolume = function()
{
  return this.video.getVolume();
};

Video.fn.mute = function(state)
{
  if (typeof state == "undefined") state = true;
  this.setVolume(state ? 1 : 0);
};

Video.fn.remove = function()
{
  this.element.remove();
};

Video.fn.bind = function()
{
  this.videoElement.bind.apply(this.videoElement, arguments);
};

Video.fn.one = function()
{
  this.videoElement.one.apply(this.videoElement, arguments);
};

Video.fn.trigger = function()
{
  this.videoElement.trigger.apply(this.videoElement, arguments);
};

// Proxy jQuery events
var events = [
               "click",
               "dblclick",
               "onerror",
               "onloadeddata",
               "oncanplay",
               "ondurationchange",
               "ontimeupdate",
               "onprogress",
               "onpause",
               "onplay",
               "onended",
               "onvolumechange"
             ];

for (var i=0; i < events.length; i++)
{
  (function()
  {
    var functName = events[i];
    var eventName = functName.replace(/^(on)/, "");
    Video.fn[functName] = function()
    {
      var args = $.makeArray(arguments);
      args.unshift(eventName);
      this.bind.apply(this, args);
    };
  }
  )();
}
// Private methods
Video.fn.triggerReady = function()
{
  /*this.readyList-> []*/
  for (var i in this.readyList)
  {
    this.readyList[i].call(this);
  }
  this.loaded = true;
//        console.log(this.readyList[i])
};

Video.fn.setupElement = function()
{
  this.element = $("<div />");
  this.element.addClass("videoPlayer");
  this.parent.append(this.element);

};

/***************************************AUTOHIDE CONTROLS*********************************/
Video.fn.idle = function(e, toggle){
    var self=this;
  if (toggle)
  {
    if (this.state == "playing")
    {
//          this.element.addClass("idle");
        this.controls.stop().animate({opacity:0} , 300);
        this.shareBtn.stop().animate({opacity:0} , 300);
        this.playlistBtn.stop().animate({opacity:0} , 300);
        this.embedBtn.stop().animate({opacity:0} , 300);
        this.logoImg.stop().animate({opacity:0} , 300);
        self.element.find(".nowPlayingText").stop().animate({opacity:0} , 300);
    }
  }
  else
  {
//          this.element.removeClass("idle");
      this.controls.stop().animate({opacity:1} , 300);
      this.shareBtn.stop().animate({opacity:1} , 300);
      this.playlistBtn.stop().animate({opacity:1} , 300);
      this.embedBtn.stop().animate({opacity:1} , 300);
      this.logoImg.stop().animate({opacity:1} , 300);
      self.element.find(".nowPlayingText").stop().animate({opacity:1} , 300);
  }
};



Video.fn.change = function(state)
{
  this.state = state;
    if(this.element){
        this.element.attr("data-state", this.state);
        this.element.trigger("state.videoPlayer", this.state);
    }

}




//////////////////////////////////////////////SETUP NATIVE*////////////////////////////////////////////////////////////
Video.fn.setupHTML5Video = function()
  {
      this.videoElement = $("<video />");
      this.videoElement.addClass("videoPlayer");
      this.videoElement.attr({
            width:this.options.width,
            height:this.options.height,
            poster:this.options.poster,
            autoplay:this.options.autoplay,
            preload:this.options.preload,
            controls:this.options.controls,
            autobuffer:this.options.autobuffer
      });
      this.preloader = $("<div />");
      this.preloader.addClass("preloader");

      if(this.element)
      {
          this.element.append(this.videoElement);
          this.element.append(this.preloader);
      }
      this.video = this.videoElement[0];

      if(!this.options.autoplay)
        this.video.poster = this.options.posterImg;

      if(this.element)
      {
          this.element.width(this.playerWidth);
          this.element.height(this.playerHeight);
      }


      var self = this;

      this.video.loadSources = function(srcs)
      {

        self.videoElement.empty();
        for (var i in srcs)
        {
          var srcEl = $("<source />");
          srcEl.attr(srcs[i]);
          self.videoElement.append(srcEl);
        }
        self.video.load();

      };

      this.video.getStartTime = function()
      {
          return(this.startTime || 0);
      };
      this.video.getEndTime = function()
      {
        if (this.duration == Infinity && this.buffered)
        {
          return(this.buffered.end(this.buffered.length-1));
        }
        else
        {
          return((this.startTime || 0) + this.duration);
        }
      };

      this.video.getCurrentTime = function(){
        try
        {
          return this.currentTime;
        }
        catch(e)
        {
          return 0;
        }
      };


      var self = this;

      this.video.setCurrentTime = function(val)
      {
//          console.log( this.currentTime)
          this.currentTime = val;
      };
      this.video.getVolume = function()
      {
          return this.volume;
      };
      this.video.setVolume = function(val)
      {
          this.volume = val;
      };

      this.videoElement.dblclick($.proxy(function()
      {
        this.toggleFullScreen();
      }, this));
      this.videoElement.bind(this.START_EV, $.proxy(function()
      {
        this.togglePlay();
      }, this));

      this.triggerReady();
};






Video.fn.setupButtonsOnScreen = function(){

    var self = this;

    this.playlistBtn = $("<div />");
    this.playlistBtn.addClass("playlistBtn");
    if(this.element){
        this.element.append(this.playlistBtn);
    }

    var playlistBtnIcon = $("<div />");
    playlistBtnIcon.addClass("playlistBtnIcon");
    this.playlistBtn.append(playlistBtnIcon);

    this.shareBtn = $("<div />");
    this.shareBtn.addClass("shareBtn");
    if(this.element){
        this.element.append(this.shareBtn);
    }
    var shareBtnIcon = $("<div />");
    shareBtnIcon.addClass("shareBtnIcon");
    this.shareBtn.append(shareBtnIcon);

    this.embedBtn = $("<div />");
    this.embedBtn.addClass("embedBtn");
    if(this.element){
        this.element.append(this.embedBtn);
    }
    var embedBtnIcon = $("<div />");
    embedBtnIcon.addClass("embedBtnIcon");
    this.embedBtn.append(embedBtnIcon);

    if(!self.options.share[0].show)
    {
        this.shareBtn.css({width:0, height:0, display:"none"});
        shareBtnIcon.css({width:0, height:0, display:"none"});
    }
    if(!self.options.embed[0].show)
    {
        this.embedBtn.css({width:0, height:0, display:"none"});
        embedBtnIcon.css({width:0, height:0, display:"none"});
    }


    buttonsMargin = 5;


    this.positionOverScreenButtons();

    this.playlistBtn.bind(this.START_EV, function(){
        self.toggleStretch();
    });
};
Video.fn.toggleStretch = function(){
    var self=this;
    if(this.stretching)
    {
        self.shrinkPlayer();
        this.stretching = false;
    }
    else
    {
        self.stretchPlayer();
        this.stretching = true;
    }
    this.resizeVideoTrack();
    this.positionOverScreenButtons();
    this.positionInfoWindow();
    this.positionEmbedWindow();
    this.positionShareWindow();
    this.positionLogo();
//    this.positionAds();
    this.resizeBars();

};
Video.fn.stretchPlayer = function(){
    this.element.width(this.options.videoPlayerWidth)
    this.playlist.hide();
};
Video.fn.shrinkPlayer = function(){
    this.element.width(this.playerWidth)
    this.playlist.show();
};


Video.fn.positionOverScreenButtons = function(state){
    if(this.element){


    if(document.webkitIsFullScreen || document.fullscreenElement || document.mozFullScreen || state)
    {
        this.shareBtn.css({
            left:this.element.width()-this.shareBtn.width()-buttonsMargin,
            top:buttonsMargin
        });
        this.embedBtn.css({
            left:this.element.width()-this.embedBtn.width()-buttonsMargin,
            top:this.shareBtn.position().top+this.shareBtn.height()+buttonsMargin
        });
        this.playlistBtn.hide();
    }
    else
    {
        if(this.options.playlist)
        {
            this.playlistBtn.show();
            this.shareBtn.css({
                left:this.element.width()-this.shareBtn.width()-buttonsMargin,
                top:buttonsMargin
            });
            this.playlistBtn.css({
                left:this.element.width()-this.playlistBtn.width()-buttonsMargin,
                top:this.shareBtn.position().top+this.shareBtn.height()+buttonsMargin
            });
            this.embedBtn.css({
                left:this.element.width()-this.embedBtn.width()-buttonsMargin,
                top:this.playlistBtn.position().top+this.playlistBtn.height()+buttonsMargin
            });
        }
        else if(!this.options.playlist)
        {
            this.playlistBtn.hide();
            this.shareBtn.css({
                left:this.element.width()-this.shareBtn.width()-buttonsMargin,
                top:buttonsMargin
            });
            this.embedBtn.css({
                left:this.element.width()-this.embedBtn.width()-buttonsMargin,
                top:this.shareBtn.position().top+this.shareBtn.height()+buttonsMargin
            });
        }

    }
    }

};

Video.fn.positionInfoWindow = function(){
    var self = this;
    this.infoWindow.css({
        bottom: self.controls.height()+55,
        left: self.element.width()/2-this.infoWindow.width()/2
    });
};
Video.fn.positionShareWindow = function(){
    var self = this;
    this.shareWindow.css({
        top: buttonsMargin,
        left: self.element.width() - this.shareWindow.width() - 2*buttonsMargin - this.shareBtn.width()
    });
};
Video.fn.positionEmbedWindow = function(){
        var self = this;
    this.embedWindow.css({
            bottom: self.element.height()/2 - this.embedWindow.height()/2,
            left: self.element.width()/2-this.embedWindow.width()/2
        });
 };


Video.fn.setupButtons = function(){
  var self = this;

  //PLAY BTN
  this.playBtn = $("<div />");
  this.playBtn.addClass("play");
  this.playBtn.bind(this.START_EV, $.proxy(function()
  {
    if (!this.canPlay)
        return;
    this.play();
  }, this))
  this.controls.append(this.playBtn);

  var playBg = $("<div />");
  playBg.addClass("playBg");
  this.playBtn.append(playBg);


  //PLAY BTN SCREEN
  this.playButtonScreen = $("<div />");
  this.playButtonScreen.addClass("playButtonScreen");
  this.playButtonScreen.bind(this.START_EV,$.proxy(function()
  {
//    if (!this.canPlay)
//        return;
    this.play();
  }, this))
  if(this.element){
      this.element.append(this.playButtonScreen);
  }


  //PAUSE BTN
  this.pauseBtn = $("<div />");
  this.pauseBtn.addClass("pause");
  this.pauseBtn.bind(this.START_EV,$.proxy(function()
  {
    if (!this.canPlay) return;
        this.pause();
  }, this));
  this.controls.append(this.pauseBtn);

  var pauseBg = $("<div />");
  pauseBg.addClass("pauseBg");
    this.pauseBtn.append(pauseBg);


  //INFO BTN
  this.infoBtn = $("<div />");
  this.infoBtn.addClass("infoBtn");
  this.controls.append(this.infoBtn);

  var infoBtnBg = $("<div />");
  infoBtnBg.addClass("infoBtnBg");
  this.infoBtn.append(infoBtnBg);

  //REWIND BTN
  this.rewindBtn = $("<div />");
  this.rewindBtn.addClass("rewindBtn");
  this.rewindBtn.bind(this.START_EV,$.proxy(function()
  {
      this.seek(0);
      this.play();
  }, this));
  this.controls.append(this.rewindBtn);

  var rewindBtnBg = $("<div />");
  rewindBtnBg.addClass("rewindBtnBg");
  this.rewindBtn.append(rewindBtnBg);





  //FULLSCREEN
  this.fsEnter = $("<div />");
  this.fsEnter.addClass("fullScreenEnter");
  this.fsEnter.bind(this.START_EV,$.proxy(function()
    {
        this.toggleFullScreen();
    }, this));
  this.controls.append(this.fsEnter);

   var fullScreenEnterBg = $("<div />");
   fullScreenEnterBg.addClass("fullScreenEnterBg");
    this.fsEnter.append(fullScreenEnterBg);

   this.fsExit = $("<div />");
   this.fsExit.addClass("fullScreenExit");
   this.fsExit.bind(this.START_EV,$.proxy(function()
    {
        this.toggleFullScreen();
    }, this));

   var fullScreenExitBg = $("<div />");
   fullScreenExitBg.addClass("fullScreenExitBg");
   this.fsExit.append(fullScreenExitBg);






    this.playButtonScreen.mouseover(function(){
        $(this).stop().animate({
            opacity: 0.5
        }, 300 );
    });
    this.playButtonScreen.mouseout(function(){
            $(this).stop().animate({
                opacity: 1
            }, 300 );
        }
    );

    /**********************play/pause rollover/rollout***************/

    this.playBtn.mouseover(function(){
        $(this).stop().animate({
            opacity: 0.5
        }, 200 );
        $(self.pauseBtn).stop().animate({
            opacity: 0.5
        }, 200 );

    });

    this.pauseBtn.mouseover(function(){
        $(self.playBtn).stop().animate({
            opacity: 0.5
        }, 200 );
        $(this).stop().animate({
            opacity: 0.5
        }, 200 );
    });

    this.playBtn.mouseout(function(){
        $(this).stop().animate({
            opacity: 1
        }, 200 );
        $(self.pauseBtn).stop().animate({
            opacity: 1
        }, 200 );

    });

    this.pauseBtn.mouseout(function(){
        $(self.playBtn).stop().animate({
            opacity: 1
        }, 200 );
        $(this).stop().animate({
            opacity: 1
        }, 200 );
    });

    this.infoBtn.mouseover(function(){
        $(this).stop().animate({
            opacity:0.5
        },200);
    });
    this.infoBtn.mouseout(function(){
        $(this).stop().animate({
            opacity:1
        },200);
    });

    this.rewindBtn.mouseover(function(){
        $(this).stop().animate({
            opacity:0.5
        },200);
    });
    this.rewindBtn.mouseout(function(){
        $(this).stop().animate({
            opacity:1
        },200);
    });



    /*******************fullscreen rollover/rollout***************/

    this.fsEnter.mouseover(function(){
        $(this).stop().animate({
            opacity: 0.5
        }, 200 );
        $(self.fsExit).stop().animate({
            opacity: 0.5
        }, 200 );

    });

    this.fsExit.mouseover(function(){
        $(self.fsEnter).stop().animate({
            opacity: 0.5
        }, 200 );
        $(this).stop().animate({
            opacity: 0.5
        }, 200 );
    });

    this.fsEnter.mouseout(function(){
        $(this).stop().animate({
            opacity: 1
        }, 200 );
        $(self.fsExit).stop().animate({
            opacity: 1
        }, 200 );

    });

    this.fsExit.mouseout(function(){
        $(self.fsEnter).stop().animate({
            opacity: 1
        }, 200 );
        $(this).stop().animate({
            opacity: 1
        }, 200 );
    });




    this.sep1 = $("<div />");
    this.sep1.addClass("sep1");
    this.controls.append(this.sep1);

    this.sep2 = $("<div />");
    this.sep2.addClass("sep2");
    this.controls.append(this.sep2);

    this.sep3 = $("<div />");
    this.sep3.addClass("sep3");
    this.controls.append(this.sep3);

    this.sep4 = $("<div />");
    this.sep4.addClass("sep4");
    this.controls.append(this.sep4);

    this.sep5 = $("<div />");
    this.sep5.addClass("sep5");
    this.controls.append(this.sep5);

    this.sep6 = $("<div />");
    this.sep6.addClass("sep6");
    this.controls.append(this.sep6);

//    console.log(sep1.position().left)
//    console.log(sep2.position().left)
};
Video.fn.createInfoWindow = function(){
    this.infoWindow = $("<div />");
    this.infoWindow.addClass("infoWindow");
    this.infoWindow.css({opacity:0});
    if(this.element){
        this.element.append(this.infoWindow);
    }

    this.infoBtnClose = $("<div />");
    this.infoBtnClose.addClass("infoBtnClose");
    this.infoWindow.append(this.infoBtnClose);
    this.infoBtnClose.css({bottom:0});

    this.infoBtn.bind(this.START_EV,$.proxy(function()
    {
        this.toggleInfoWindow();
    }, this));

    this.infoBtnClose.bind(this.START_EV,$.proxy(function()
    {
        this.toggleInfoWindow();
    }, this));

    this.infoBtnClose.mouseover(function(){
        $(this).stop().animate({
            opacity:0.5
        },200);
    });
    this.infoBtnClose.mouseout(function(){
        $(this).stop().animate({
            opacity:1
        },200);
    });
};

Video.fn.createShareWindow = function(){
    this.shareWindow = $("<div></div>");
    this.shareWindow.addClass("shareWindow");
    this.shareWindow.hide();
    this.shareWindow.css({
        opacity:0
    });
    if(this.element){
        this.element.append(this.shareWindow);
    }

    this.shareBtn.bind(this.START_EV,$.proxy(function()
    {
        this.toggleShareWindow();
    }, this));

    this.shareWindow.facebook = $("<div />");
    this.shareWindow.facebook.addClass("facebook");
    this.shareWindow.append(this.shareWindow.facebook);

    this.shareWindow.twitter = $("<div />");
    this.shareWindow.twitter.addClass("twitter");
    this.shareWindow.append(this.shareWindow.twitter);

    this.shareWindow.myspace = $("<div />");
    this.shareWindow.myspace.addClass("myspace");
    this.shareWindow.append(this.shareWindow.myspace);

    this.shareWindow.wordpress = $("<div />");
    this.shareWindow.wordpress.addClass("wordpress");
    this.shareWindow.append(this.shareWindow.wordpress);

    this.shareWindow.linkedin = $("<div />");
    this.shareWindow.linkedin.addClass("linkedin");
    this.shareWindow.append(this.shareWindow.linkedin);

    this.shareWindow.flickr = $("<div />");
    this.shareWindow.flickr.addClass("flickr");
    this.shareWindow.append(this.shareWindow.flickr);

    this.shareWindow.blogger = $("<div />");
    this.shareWindow.blogger.addClass("blogger");
    this.shareWindow.append(this.shareWindow.blogger);

    this.shareWindow.delicious = $("<div />");
    this.shareWindow.delicious.addClass("delicious");
    this.shareWindow.append(this.shareWindow.delicious);

    this.shareWindow.mail = $("<div />");
    this.shareWindow.mail.addClass("mail");
    this.shareWindow.append(this.shareWindow.mail);

    //give shareWindow width after all elements appended
    var saveShareWindowWidth = this.shareWindow.width();
    this.shareWindow.css({
       width:saveShareWindowWidth
    });

    this.shareWindow.facebook.mouseover(function(){ $(this).stop().animate({opacity:0.6},200);});
    this.shareWindow.facebook.mouseout(function(){$(this).stop().animate({opacity:1},200);});
    this.shareWindow.twitter.mouseover(function(){ $(this).stop().animate({opacity:0.6},200);});
    this.shareWindow.twitter.mouseout(function(){$(this).stop().animate({opacity:1},200);});
    this.shareWindow.myspace.mouseover(function(){ $(this).stop().animate({opacity:0.6},200);});
    this.shareWindow.myspace.mouseout(function(){$(this).stop().animate({opacity:1},200);});
    this.shareWindow.wordpress.mouseover(function(){ $(this).stop().animate({opacity:0.6},200);});
    this.shareWindow.wordpress.mouseout(function(){$(this).stop().animate({opacity:1},200);});
    this.shareWindow.linkedin.mouseover(function(){ $(this).stop().animate({opacity:0.6},200);});
    this.shareWindow.linkedin.mouseout(function(){$(this).stop().animate({opacity:1},200);});
    this.shareWindow.flickr.mouseover(function(){ $(this).stop().animate({opacity:0.6},200);});
    this.shareWindow.flickr.mouseout(function(){$(this).stop().animate({opacity:1},200);});
    this.shareWindow.blogger.mouseover(function(){ $(this).stop().animate({opacity:0.6},200);});
    this.shareWindow.blogger.mouseout(function(){$(this).stop().animate({opacity:1},200);});
    this.shareWindow.delicious.mouseover(function(){ $(this).stop().animate({opacity:0.6},200);});
    this.shareWindow.delicious.mouseout(function(){$(this).stop().animate({opacity:1},200);});
    this.shareWindow.mail.mouseover(function(){ $(this).stop().animate({opacity:0.6},200);});
    this.shareWindow.mail.mouseout(function(){$(this).stop().animate({opacity:1},200);});

    this.shareWindow.facebook.bind(this.START_EV,$.proxy(function(){
        window.open(this.options.share[0].facebookLink);
    }, this));
    this.shareWindow.twitter.bind(this.START_EV,$.proxy(function(){
        window.open(this.options.share[0].twitterLink);
    }, this));
    this.shareWindow.myspace.bind(this.START_EV,$.proxy(function(){
        window.open(this.options.share[0].myspaceLink);
    }, this));
    this.shareWindow.wordpress.bind(this.START_EV,$.proxy(function(){
        window.open(this.options.share[0].wordpressLink);
    }, this));
    this.shareWindow.linkedin.bind(this.START_EV,$.proxy(function(){
        window.open(this.options.share[0].linkedinLink);
    }, this));
    this.shareWindow.flickr.bind(this.START_EV,$.proxy(function(){
        window.open(this.options.share[0].flickrLink);
    }, this));
    this.shareWindow.blogger.bind(this.START_EV,$.proxy(function(){
        window.open(this.options.share[0].bloggerLink);
    }, this));
    this.shareWindow.delicious.bind(this.START_EV,$.proxy(function(){
        window.open(this.options.share[0].deliciousLink);
    }, this));
    this.shareWindow.mail.bind(this.START_EV,$.proxy(function(){
        window.open(this.options.share[0].mailLink);
    }, this));
};
Video.fn.createEmbedWindow = function(){
    this.embedWindow = $("<div />");
    this.embedWindow.addClass("embedWindow");
    this.embedWindow.css({opacity:0});
    if(this.element){
        this.element.append(this.embedWindow);
    }

    this.embedBtnClose = $("<div />");
    this.embedBtnClose.addClass("embedBtnClose");
    this.embedWindow.append(this.embedBtnClose);
    this.embedBtnClose.css({bottom:0});

    this.embedBtn.bind(this.START_EV,$.proxy(function()
    {
        this.toggleEmbedWindow();
    }, this));

    this.embedBtnClose.bind(this.START_EV,$.proxy(function()
    {
        this.toggleEmbedWindow();
    }, this));

    this.embedBtnClose.mouseover(function(){
        $(this).stop().animate({
                opacity:0.5
        },200);
    });
    this.embedBtnClose.mouseout(function(){
        $(this).stop().animate({
                opacity:1
        },200);
    });
};


/*****************Video Track**********************/

Video.fn.setupVideoTrack = function(){
        var self=this;

    this.videoTrack = $("<div />");
    this.videoTrack.addClass("videoTrack");
    this.controls.append(this.videoTrack);
    this.videoTrack.css({
       top:self.controls.height()/2 - this.videoTrack.height() /2-1
    });

        this.videoTrackDownload = $("<div />");
        this.videoTrackDownload.addClass("videoTrackDownload");
        this.videoTrackDownload.css("width",0);
        this.videoTrack.append(this.videoTrackDownload);

        this.videoTrackProgress = $("<div />");
        this.videoTrackProgress.addClass("videoTrackProgress");
        this.videoTrackProgress.css("width",0);
        this.videoTrack.append(this.videoTrackProgress);

        this.toolTip = $("<div />");
        this.toolTip.addClass("toolTip");
        this.toolTip.hide();
        this.toolTip.css({
            opacity:0 ,
            bottom: self.controls.height() + this.toolTip.height()+3
        });
        this.controls.append(this.toolTip);

        var toolTipText =$("<div />");
        toolTipText.addClass("toolTipText");
        this.toolTip.append(toolTipText);

        var toolTipTriangle =$("<div />");
        toolTipTriangle.addClass("toolTipTriangle");
        this.toolTip.append(toolTipTriangle);


        //show/hide tooltip
        this.videoTrack.bind("mousemove", function(e){
            var x = e.pageX - self.videoTrack.offset().left -self.toolTip.width()/2;
            var xPos = e.pageX - self.videoTrack.offset().left;
            var perc = xPos / self.videoTrack.width();
            toolTipTriangle.css({left: 19, top:18});
            toolTipText.text(self.secondsFormat(self.video.duration*perc))
            self.toolTip.css("left", x+self.videoTrack.position().left);
            self.toolTip.show();
            self.toolTip.stop().animate({opacity:1},100);
//            console.log(toolTipTriangle.width()/2,toolTip.width()/2)
        });

        this.videoTrack.bind("mouseout", function(e){
            $(self.toolTip).stop().animate({opacity:0},50,function(){self.toolTip.hide()});
        });

        //video track clicked
    this.videoTrack.bind("click",function(e){
            var xPos = e.pageX - self.videoTrack.offset().left;
            self.videoTrackProgress.css("width", xPos);
            var perc = xPos / self.videoTrack.width();
            self.video.setCurrentTime(self.video.duration*perc);
        });


        this.onloadeddata($.proxy(function(){
//            console.log("onloadeddata");
            this.timeElapsed.text(this.secondsFormat(this.video.getCurrentTime()));
            this.timeTotal.text(" / "+this.secondsFormat(this.video.getEndTime()));
            this.loaded = true;
            this.preloader.stop().animate({opacity:0},300,function(){$(this).hide()});

            self.onprogress($.proxy(function(e){
//            console.log("onprogress()")
//            console.log(e);
//                console.log(self.video.buffered.length-1)
                if((self.video.buffered.length-1)>=0)
                self.buffered = self.video.buffered.end(self.video.buffered.length-1);
                self.downloadWidth = (self.buffered/self.video.duration )*self.videoTrack.width();
                self.videoTrackDownload.css("width", self.downloadWidth);
            }, self));
        }, this));



        this.ontimeupdate($.proxy(function(){
//            console.log("ON time update!")
            this.progressWidth = (this.video.currentTime/this.video.duration )*this.videoTrack.width();
            this.videoTrackProgress.css("width", this.progressWidth);
        }, this));

};

Video.fn.resetPlayer = function(){
    this.videoTrackDownload.css("width", 0);
    this.videoTrackProgress.css("width", 0);
    this.timeElapsed.text("00:00");
    this.timeTotal.text(" / "+"00:00");
};



/*************************Volume Track************************/

Video.fn.setupVolumeTrack = function(){

    var self = this;

    var volumeTrack = $("<div />");
    volumeTrack.addClass("volumeTrack");
    this.controls.append(volumeTrack);
    volumeTrack.css({
        top:self.controls.height()/2 - volumeTrack.height() /2-1
    });

    var volumeTrackProgress = $("<div />");
    volumeTrackProgress.addClass("volumeTrackProgress");
    volumeTrack.append(volumeTrackProgress);

    //volume on start
    self.video.setVolume(1);


    /****************tooltip volume*******************/
    this.toolTipVolume = $("<div />");
    this.toolTipVolume.addClass("toolTipVolume");
    this.toolTipVolume.hide();
    this.toolTipVolume.css({
        opacity:0 ,
        bottom: self.controls.height() + this.toolTipVolume.height()+3
    });
    this.controls.append(this.toolTipVolume);

    var toolTipVolumeText =$("<div />");
    toolTipVolumeText.addClass("toolTipVolumeText");
    this.toolTipVolume.append(toolTipVolumeText);

    var toolTipTriangle =$("<div />");
    toolTipTriangle.addClass("toolTipTriangle");
    this.toolTipVolume.append(toolTipTriangle);

    /******************mute/unmute buttons*****************/

    this.muteBtn = $("<div />");
    this.muteBtn.addClass("mute");

    var muteBg =$("<div />");
    muteBg.addClass("muteBg");
    this.muteBtn.append(muteBg);

    this.unmuteBtn = $("<div />");
    this.unmuteBtn.hide();
    this.unmuteBtn.addClass("unmute");

    var unmuteBg =$("<div />");
    unmuteBg.addClass("unmuteBg");
    this.unmuteBtn.append(unmuteBg);

    this.controls.append(this.muteBtn);
    this.controls.append(this.unmuteBtn);

    var savedVolumeBarWidth;
    var volRatio;

    this.muteBtn.bind(this.START_EV,$.proxy(function(){
        savedVolumeBarWidth = volumeTrackProgress.width();
        $(self.unmuteBtn).show();
        $(this.muteBtn).hide();
        volumeTrackProgress.stop().animate({width:0},200);
        this.setVolume(0);
    }, this));

    this.unmuteBtn.bind(this.START_EV,$.proxy(function(){
        $(this.unmuteBtn).hide();
        $(self.muteBtn).show();
        volumeTrackProgress.stop().animate({width:savedVolumeBarWidth},200);
        volRatio=savedVolumeBarWidth/volumeTrack.width();
        self.video.setVolume(volRatio);
    }, this));


    volumeTrack.bind("mousedown",function(e){
        $(self.unmuteBtn).hide();
        $(self.muteBtn).show();
        var xPos = e.pageX - volumeTrack.offset().left;
        var perc = xPos / (volumeTrack.width()+2);
        self.video.setVolume(perc);

        volumeTrackProgress.stop().animate({width:xPos},200);

        $(document).mousemove(function(e){

            volumeTrackProgress.stop().animate({width: e.pageX- volumeTrack.offset().left},0)

            if(volumeTrackProgress.width()>=volumeTrack.width())
            {
                volumeTrackProgress.stop().animate({width: volumeTrack.width()},0)
            }
            else if(volumeTrackProgress.width()<=0)
            {
                volumeTrackProgress.stop().animate({width: 0},0);
            }
            self.video.setVolume(volumeTrackProgress.width()/volumeTrack.width());
        });
    });


    $(document).mouseup(function(e){
            $(document).unbind("mousemove");

        });


    /************tooltip volume move**********/
    volumeTrack.bind("mousemove", function(e){
        var x = e.pageX - volumeTrack.offset().left -self.toolTipVolume.width()/2;
        var xPos = e.pageX - volumeTrack.offset().left;
        var perc = xPos / volumeTrack.width();
        if(xPos>=0 && xPos<= volumeTrack.width())
        {
            toolTipVolumeText.text("Volume" + Math.ceil(perc*100) + "%")
        }
        toolTipTriangle.css({left: 34, top:18});
        self.toolTipVolume.css("left", x+volumeTrack.position().left);
        self.toolTipVolume.show();
        self.toolTipVolume.stop().animate({opacity:1},100);

//        console.log(e.pageX, e.clientX, volumeTrack.offset().left, volumeTrack.position().left)
//        console.log(xPos)
    });

    volumeTrack.bind("mouseout", function(e){
        self.toolTipVolume.stop().animate({opacity:0},50,function(){self.toolTipVolume.hide()});
    });



    /***********************rollover/rollout****************/
    this.muteBtn.mouseover(function(){
        $(this).stop().animate({
            opacity: 0.5
        }, 200 );
        $(self.unmuteBtn).stop().animate({
            opacity: 0.5
        }, 200 );

    });

    this.unmuteBtn.mouseover(function(){
        $(self.muteBtn).stop().animate({
            opacity: 0.5
        }, 200 );
        $(this).stop().animate({
            opacity: 0.5
        }, 200 );
    });

    this.muteBtn.mouseout(function(){
        $(this).stop().animate({
            opacity: 1
        }, 200 );
        $(self.unmuteBtn).stop().animate({
            opacity: 1
        }, 200 );

    });

    this.unmuteBtn.mouseout(function(){
        $(self.muteBtn).stop().animate({
            opacity: 1
        }, 200 );
        $(this).stop().animate({
            opacity: 1
        }, 200 );
    });

};



/*********************************TIME****************************/

Video.fn.setupTiming = function(){
  var self = this;
  this.timeElapsed = $("<div />");
  this.timeTotal = $("<div />");

  this.timeElapsed.text("00:00");
  this.timeTotal.text(" / "+"00:00");

  this.timeElapsed.addClass("timeElapsed");
  this.timeTotal.addClass("timeTotal");


  this.ontimeupdate($.proxy(function(){
      this.timeElapsed.text(self.secondsFormat(this.video.getCurrentTime()));
      this.timeTotal.text(" / "+self.secondsFormat(this.video.getEndTime()));
  }, this));
  
  this.videoElement.one("canplay", $.proxy(function(){
    this.videoElement.trigger("timeupdate");
  }, this));
  
  this.controls.append(this.timeElapsed);
  this.controls.append(this.timeTotal);


};





Video.fn.setupControls = function(){

  // Use native controls
  if (this.options.controls) return;
  
  this.controls = $("<div />");
  this.controls.addClass("controls");
  this.controls.addClass("disabled");
if(this.element){
    this.element.append(this.controls);
}

//  this.setupButtons();
//  this.setupVideoTrack();
  this.setupVolumeTrack();
  this.setupTiming();

  this.setupButtons();
  this.setupButtonsOnScreen();
  this.createInfoWindow();
  this.createInfoWindowContent();
  this.createNowPlayingText();
  this.createShareWindow();
  this.createEmbedWindow();
  this.createEmbedWindowContent();
  this.setupVideoTrack();
  this.resizeVideoTrack();
  this.createLogo();

  if (this.options.disablecontrols) {

    $('div.controls', this.element).hide();
  }

//  this.createAds();
};

Video.fn.resizeVideoTrack = function(){
    var self=this;
//    console.log(videoTrack.position().left)
//    console.log(sep2.position().left)

    this.videoTrack.css({
        left:self.sep1.position().left +10,
        width:self.sep2.position().left - self.sep1.position().left -20
    });

};

Video.fn.setupEvents = function()
{
    var self = this;
        /*jQuery.proxy( function, context )
         function - The function whose context will be changed.
         context - The object to which the context (this) of the function should be set.*/
      this.onpause($.proxy(function()
      {
        this.element.addClass("paused");
        this.element.removeClass("playing");
        this.change("paused");
      }, this));

      this.onplay($.proxy(function()
      {
        this.element.removeClass("paused");
        this.element.addClass("playing");
        this.change("playing");
      }, this));

      this.onended($.proxy(function()
      {
        this.resetPlayer();
        if(self.preloader)
            self.preloader.stop().animate({opacity:1},0,function(){$(this).show()});
          
        if(self.options.playNextOnFinish)
        {
            this.video.poster = "";
            self.videoid = parseInt(self.videoid)+1;

            if (self.videos_array.length == self.videoid){
                self.videoid = 0;
//                console.log(this.videoid)
            }

             //play next on finish
             if(self.myVideo.canPlayType && self.myVideo.canPlayType('video/mp4').replace(/no/, ''))
             {
                 this.canPlay = true;
                 this.load(self.videos_array[self.videoid].video_path_mp4);
             }
             else if(self.myVideo.canPlayType && self.myVideo.canPlayType('video/webm').replace(/no/, ''))
             {
                 this.canPlay = true;
                 this.load(self.videos_array[self.videoid].video_path_webm);
             }
             else if(self.myVideo.canPlayType && self.myVideo.canPlayType('video/ogg').replace(/no/, ''))
             {
                 this.canPlay = true;
                 this.load(self.videos_array[self.videoid].video_path_ogg);
             }

             this.play();
            $(self.element).find(".infoTitle").html(self.videos_array[self.videoid].title);
            $(self.element).find(".infoText").html(self.videos_array[self.videoid].info_text);
            $(self.element).find(".nowPlayingText").html(self.videos_array[self.videoid].title);
             this.loaded=false;
            $(self.playlist).find(".itemSelected").removeClass("itemSelected").addClass("itemUnselected");//unselect all
            $(self.item_array[self.videoid]).find(".itemUnselected").removeClass("itemUnselected").addClass("itemSelected");
        }
        else if(!self.options.playNextOnFinish)
        {
            this.preloader.hide();
            this.seek(0);
//          this.element.removeClass("playing");
            if(this.options.restartOnFinish)
            {
                this.play();
            }
            else
            {
                this.pause();
            }

        }
      }, this));


      this.oncanplay($.proxy(function(){
        this.canPlay = true;
        this.controls.removeClass("disabled");
      }, this));


//    if (this.options.keyShortcut)
    $(document).keydown($.proxy(function(e)
    {
        if (e.keyCode == 32)
        {
            // Space
            this.togglePlay();
            return false;
        }

        if (e.keyCode == 27 && this.inFullScreen)
        {
//            console.log("ESCAPE")
            this.fullScreen(!this.inFullScreen);
        }



    }, this));
};



window.Video = Video;

})(jQuery);