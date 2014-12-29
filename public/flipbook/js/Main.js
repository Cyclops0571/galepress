
(function init($, window, document, undefined) {
    /**
     * Plugin constructor method
     * @param options Object containing options, overrides default options
     * @return {*}
     */
    $.fn.flipBook = function (options) {
        //entry point
        return this.each(function () {
            var flipBook = new Main();
            flipBook.init(options, this);
        });
    };

//    $.fn.flipBook.goToPage = function (page) {
//        if(this.FlipBook.Book)
//            this.FlipBook.Book.goToPage(page);
//    };

    // DEFAULT OPTIONS
    $.fn.flipBook.options = {
        //pdf file  - not supported
        // pdfUrl:"pdf/away3d.pdf",
        pdfUrl:"",

		rightToLeft:false,
        //array of page objects - this must be passed to plugin constructor
        // {
        // src:"page url",
        // thumb:"thumb url",
        // title:"page title for table of contents"
        // }
        pages:[],
		
		rootFolder:"",

        assets:{
            preloader:"images/preloader.jpg",
            left:"images/left.png",
            overlay:"images/overlay.jpg"
        },

        //page that will be displayed when the book starts
        startPage:1,

        //book default settings
        pageWidth:1000,
        pageHeight:1414,
        thumbnailWidth:100,
        thumbnailHeight:141,

        //menu buttons
        currentPage:true,
        btnNext:true,
        btnPrev:true,
        btnZoomIn:true,
        btnZoomOut:true,
        btnToc:true,
        btnThumbs:true,
        btnShare:true,
        btnExpand:true,
        btnDownloadPages:true,
        btnDownloadPdf:true,
		
		downloadPagesUrl:"images/pages.zip",
		downloadPdfUrl:"images/pages.pdf",

        //flip animation type; can be "2d" or "3d"
        flipType:'3d',

        zoom:.8,
        zoomMin:.7,
        zoomMax:6,

        //flip animation parameters
        time1:500,
        transition1:'easeInQuad',
        time2:600,
        transition2:'easeOutQuad',

        //social share buttons -  if value is "" the button will not be displayed
        social:[
            {name:"facebook", icon:"fa-facebook", url:"http://codecanyon.net"},
            {name:"twitter", icon:"fa-twitter", url:"http://codecanyon.net"},
            {name:"googleplus", icon:"fa-google-plus", url:"http://codecanyon.net"},
            {name:"linkedin", icon:"fa-linkedin", url:"http://codecanyon.net"},
            {name:"youtube", icon:"fa-youtube", url:"http://codecanyon.net"}
        ],
		
        //lightbox settings
        lightBox : false,
        lightboxTransparent:true,
        lightboxPadding : 0,
        lightboxMargin  : 20,

        lightboxWidth     : '75%',  //width of the lightbox in pixels or percent, for example '1000px' or '75%'
        lightboxHeight    : 600,
        lightboxMinWidth  : 400,   //minimum width of lightbox before it starts to resize to fit the screen
        lightboxMinHeight : 100,
        lightboxMaxWidth  : 9999,
        lightboxMaxHeight : 9999,

        lightboxAutoSize   : true,
        lightboxAutoHeight : false,
        lightboxAutoWidth  : false,


        //WebGL settings
        webgl:true,
		renderer:"webgl",  // "webgl" or "canvas"
        //web gl 3d settings
        cameraDistance:2500,

        pan:0,
        panMax:20,
        panMin:-20,
        tilt:0,
        tiltMax:0,
        tiltMin:-60,

        //book
        bookX:0,
        bookY:0,
        bookZ:0,

        //pages
        pageMaterial:'phong',                     // page material, 'phong', 'lambert' or 'basic'
        pageShadow:true,
        pageHardness:2,
        coverHardness:4,
        pageSegmentsW:10,
        pageSegmentsH:1,
        pageShininess:25,
        pageFlipDuration:2,

        //point light
        pointLight:true,                            // point light enabled
        pointLightX:0,                              // point light x position
        pointLightY:200,                              // point light y position
        pointLightZ:1500,                           // point light z position
        pointLightColor:0xffffff,                   // point light color
        pointLightIntensity:0.04,                    // point light intensity

        //directional light
        directionalLight:false,                     // directional light enabled
        directionalLightX:0,                        // directional light x position
        directionalLightY:0,                        // directional light y position
        directionalLightZ:2000,                     // directional light z position
        directionalLightColor:0xffffff,             // directional light color
        directionalLightIntensity:0.01,              // directional light intensity

        //ambient light
        ambientLight:true,                          // ambient light enabled
        ambientLightColor:0xffffff,                 // ambient light color
        ambientLightIntensity:1,                  // ambient light intensity

        //spot light
        spotLight:false,                             // spot light enabled
        spotLightX:0,                               // spot light x position
        spotLightY:0,                               // spot light y position
        spotLightZ:5000,                            // spot light z position
        spotLightColor:0xffffff,                    // spot light color
        spotLightIntensity:0.2,                     // spot light intensity
        spotLightShadowCameraNear:0.1,              // spot light shadow near limit
        spotLightShadowCameraFar:10000,             // spot light shadow far limit
        spotLightCastShadow:true,                   // spot light casting shadows
        spotLightShadowDarkness:0.5,                 // spot light shadow darkness
		
		skin:"light", 								//dark, light
		
		contentOnStart:false,
		thumbnailsOnStart:false
    };

	
    /**
     *
     * @constructor
     */
    var Main = function (){};
    /**
     * Object prototype
     * @type {Object}
     */
    Main.prototype = {

        init:function(options,elem){
            /**
             * local variables
             */
            var self = this;
            self.elem = elem;
            self.$elem = $(elem);
            self.options = {};

            //stats for debug
//            var
//                stats,
//                createStats = function () {
//                    stats = new Stats();
//                    stats.domElement.style.position = 'absolute';
//                    stats.domElement.style.top = '0px';
//                    self.$elem.append($(stats.domElement));
//                }();
//
//
//            function animate() {
//                requestAnimationFrame(animate);
//                stats.update();
//            }
//            animate();

            var dummyStyle = document.createElement('div').style,
                vendor = (function () {
                    var vendors = 't,webkitT,MozT,msT,OT'.split(','),
                        t,
                        i = 0,
                        l = vendors.length;

                    for (; i < l; i++) {
                        t = vendors[i] + 'ransform';
                        if (t in dummyStyle) {
                            return vendors[i].substr(0, vendors[i].length - 1);
                        }
                    }
                    return false;
                })(),
                prefixStyle = function (style) {
                    if (vendor === '') return style;

                    style = style.charAt(0).toUpperCase() + style.substr(1);
                    return vendor + style;
                },

                isAndroid = (/android/gi).test(navigator.appVersion),
                isIDevice = (/iphone|ipad/gi).test(navigator.appVersion),
                isTouchPad = (/hp-tablet/gi).test(navigator.appVersion),
                has3d = prefixStyle('perspective') in dummyStyle,
                hasTouch = 'ontouchstart' in window && !isTouchPad,
                RESIZE_EV = 'onorientationchange' in window ? 'orientationchange' : 'resize',
                CLICK_EV = hasTouch ? 'touchend' : 'click',
                START_EV = hasTouch ? 'touchstart' : 'mousedown',
                MOVE_EV = hasTouch ? 'touchmove' : 'mousemove',
                END_EV = hasTouch ? 'touchend' : 'mouseup',
                CANCEL_EV = hasTouch ? 'touchcancel' : 'mouseup',
                transform = prefixStyle('transform'),
                perspective = prefixStyle('perspective'),
                transition = prefixStyle('transition'),
                transitionProperty = prefixStyle('transitionProperty'),
                transitionDuration = prefixStyle('transitionDuration'),
                transformOrigin = prefixStyle('transformOrigin'),
                transformStyle = prefixStyle('transformStyle'),
                transitionTimingFunction = prefixStyle('transitionTimingFunction'),
                transitionDelay = prefixStyle('transitionDelay'),
                backfaceVisibility = prefixStyle('backfaceVisibility')
                ;

            /**
             * Global variables
             */
            self.has3d = has3d;
            self.hasWebGl  = Detector.webgl;
            self.hasTouch = hasTouch;
            self.RESIZE_EV = RESIZE_EV;
            self.CLICK_EV = CLICK_EV;
            self.START_EV = START_EV;
            self.MOVE_EV = MOVE_EV;
            self.END_EV = END_EV;
            self.CANCEL_EV = CANCEL_EV;
            self.transform = transform;
            self.transitionProperty = transitionProperty;
            self.transitionDuration = transitionDuration;
            self.transformOrigin = transformOrigin;
            self.transitionTimingFunction = transitionTimingFunction;
            self.transitionDelay = transitionDelay;
            self.perspective = perspective;
            self.transformStyle = transformStyle;
            self.transition = transition;
            self.backfaceVisibility = backfaceVisibility;

            //default options are overridden by options object passed to plugin constructor
            self.options = $.extend({}, $.fn.flipBook.options, options);
            self.options.main = self;
            self.p = false;

			self.pages = self.options.pages;
			
			self.wrapper = $(document.createElement('div'))
                .addClass('main-wrapper');
			self.bookLayer = $(document.createElement('div'))
                .addClass('flipbook-bookLayer')
                .appendTo(self.wrapper);
            self.bookLayer[0].style[self.transformOrigin] = '100% 100%';

            self.book = $(document.createElement('div'))
                .addClass('book')
                .appendTo(self.bookLayer);
			//if lightbox
            if(self.options.lightBox){
                self.lightbox = new FLIPBOOK.Lightbox(this, self.wrapper,self.options);
                if(self.options.lightboxTransparent == true){
                    self.wrapper.css('background','none');
                    self.bookLayer.css('background','none');
                    self.book.css('background','none');
                }
            }
            else{
                self.wrapper.appendTo(self.$elem);
				self.start();
				if(self.options.contentOnStart)
					self.toggleToc(true);
				if(self.options.thumbnailsOnStart)
					self.toggleThumbs(true);
            }
			
			if(self.options.pdfUrl != ""){
                //load pdf
                PDFJS.disableWorker = true;
                PDFJS.getDocument(self.options.pdfUrl).then(function(pdf){
					self.onPdfOpen(pdf);
                });
            }else{
				// self.start();
			}
			
        },
		
        /**
         * start everything, after we have options
         */
        start:function (){
            this.started = true;
			
			var self = this;
			

			//if rtl reverse pageSegments
			if(self.options.rightToLeft){
				self.pagesReversed = [];
				for(var i=self.options.pages.length-1;i>=0;i--){
					self.pagesReversed.push(self.options.pages[i]);
				}
				self.options.pages = self.pagesReversed;
			}
			
			
            self.options.onTurnPageComplete = self.onTurnPageComplete;
            if(!self.has3d)
                self.options.flipType = '2d';
				
            this.createBook();
            this.Book.updateVisiblePages();
            this.createMenu();
            if(this.options.currentPage){
                this.createCurrentPage();
                this.updateCurrentPage();
            }
            this.createToc();
            this.createThumbs();
            if(this.options.btnShare)
                this.createShareButtons();
            this.resize();
			
			if(self.options.lightBox)
				self.Book.disable();
			else
				self.Book.enable();
			//init skin
	
			$(".skin-color-bg").addClass("flipbook-bg-"+this.options.skin);
			$(".skin-color").addClass("flipbook-color-"+this.options.skin);
        },
		
		onPdfOpen:function (pdf) {
		
			var self = this;
			self.pdfDocument = pdf;
			self.loadPageFromPdf(0, self.start);
			
		},
		
		loadPageFromPdf:function(pageIndex,callback){
			var self = this;
			var pdf = self.pdfDocument;
			var info = pdf.pdfInfo, numPages = info.numPages, context, scale = 1.5;
			var canvas = document.createElement('canvas');
			var context = canvas.getContext('2d');

			var pages = new Array();

			pdf.getPage(pageIndex+1).then(function getPage(page){
				var viewport = page.getViewport(scale);
				canvas.width = viewport.width;
				canvas.height = viewport.height;
				
				var pageRendering = page.render({canvasContext: context, viewport: viewport});
				
				var completeCallback = pageRendering.internalRenderTask.callback;
				pageRendering.internalRenderTask.callback = function (error) {
					//Step 2: what you want to do before calling the complete method                  
					completeCallback.call(this, error);
					getImageFromCanvas(canvas);
					callback.call(self)
					// self.start();
					//Step 3: do some more stuff
				};
				context.clearRect(0, 0, canvas.width, canvas.height);
			});
			
			//save canvas to image
			function getImageFromCanvas(canvas) {
				var url = canvas.toDataURL();
				// var newImg = document.createElement("img"); //create
				// newImg.src = url;
				// document.body.appendChild(newImg); //add to end of your document
				self.pages[0].src = url;
			}
		},

        /**
         * create the book
         */
        createBook : function () {
            var self = this;

            //WebGL mode
            if(self.options.webgl && self.hasWebGl){
//                if(self.options.webgl && self.hasWebGl){
                var bookOptions = self.options;
                bookOptions.pagesArr = self.options.pages;
                bookOptions.scroll = self.scroll;
                bookOptions.parent = self;
                self.Book = new FLIPBOOK.BookWebGL(self.book[0], bookOptions);
                self.webglMode = true;
            }else{
                self.Book = new FLIPBOOK.Book(self.book[0], self.options);

                self.scroll = new iScroll(self.bookLayer[0], {
//                bounce:false,
                    wheelAction:'zoom',
                    zoom:true,
                    zoomMin:self.options.zoomMin,
                    zoomMax:self.options.zoomMax,
                    keepInCenterH:true,
                    keepInCenterV:true,
                    bounce:true
                });
                self.webglMode = false;
            }
//            self.currentPage = $(document.createElement('div'))
//                .attr('id','currentPage');
//            self.updateCurrentPage();
			if(self.options.rightToLeft){
				self.Book.goToPage(Number(self.options.pages.length),true);
			}else{
				self.Book.goToPage(Number(self.options.startPage)-1);
			}
            $(window).resize(function () {
                self.resize();
            });
			
			//keyboard evetns
			document.onkeydown = function (e) {
				e = e || window.event;
				switch(e.keyCode){
					case 37:
						//left
						self.Book.prevPage();
						break;
					case 38:
						//up
						self.zoomIn();
						break;
					case 39:
						//right
						self.Book.nextPage();
						break;
					case 40:
						//down
						self.zoomOut();
						break;
				}
			}
        },

        /**
         * create menu
         */
        createMenu:function(){
			if(this.p && this.options.pages.length != 24 && this.options.pages.length != 8)
                return;
            var self = this;
            this.menuWrapper = $(document.createElement('div'))
                .addClass('flipbook-menuWrapper')
                .appendTo(this.wrapper)
            ;
            this.menu = $(document.createElement('div'))
                    .addClass('flipbook-menu')
                    .addClass('skin-color-bg')
                    .appendTo(this.menuWrapper)
                ;
            if(this.options.lightboxTransparent){

            }

            if(self.options.btnPrev)
            {
                var btnPrev = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){
                        self.Book.prevPage();
                    })
                    .addClass('fa fa-chevron-left')
                    .addClass('flipbook-menu-btn')
                    .addClass('flipbook-icon-general')
                    .addClass('skin-color')
//                    .addClass('prev')
                ;
            }
            if(self.options.btnNext)
            {
                var btnNext = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){
                        self.Book.nextPage();
                    })
                    .addClass('flipbook-menu-btn')
                    .addClass('flipbook-icon-general')
                    .addClass('fa fa-chevron-right')
                    .addClass('skin-color')
            ;
            }
            if(self.options.btnZoomIn)
            {
                var btnZoomIn = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){
                        self.zoomIn();
                    })
                    .addClass('flipbook-menu-btn')
                    .addClass('flipbook-icon-general')
					// .addClass('fa fa-search-plus')
					.addClass('fa fa-plus')
                        .addClass('skin-color')
                    ;
            }
            if(self.options.btnZoomOut)
            {
                var btnZoomOut = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){
                        self.zoomOut();
                    })
                    .addClass('flipbook-menu-btn')
                    .addClass('flipbook-icon-general')
					// .addClass('fa fa-search-minus')
					.addClass('fa fa-minus')
                    .addClass('skin-color')
                    ;
            }
            if(self.options.btnToc)
            {
                var btnToc = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){
                        self.toggleToc();
                    })
                    .addClass('flipbook-menu-btn')
                    .addClass('flipbook-icon-general')
                   .addClass('fa fa-list-ol')
                    .addClass('skin-color')
                    ;
            }
            if(self.options.btnThumbs)
            {
                var btnThumbs = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){
                        self.toggleThumbs();
                    })
                    .addClass('flipbook-menu-btn')
                    .addClass('flipbook-icon-general')
                    .addClass('fa fa-th-large')
                    .addClass('skin-color')
                ;
            }
            if(self.options.btnShare)
            {
                this.btnShare = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){
                        self.toggleShare();
                    })
                    .addClass('flipbook-menu-btn')
                    // .addClass('fa fa-share')
                    .addClass('fa fa-link')
					.addClass('flipbook-icon-general')
                    .addClass('skin-color')
                ;
            }

            if(self.options.btnDownloadPages)
            {
                this.btnDownloadPages = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){
                        window.location=self.options.downloadPagesUrl;
                    })
                    .addClass('flipbook-menu-btn')
                    .addClass('fa fa-download')
					.addClass('flipbook-icon-general')
                    .addClass('skin-color')
                ;
            }

            if(self.options.btnDownloadPdf)
            {
                this.btnDownloadPdf = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){
                        window.location=self.options.downloadPdfUrl;
                    })
                    .addClass('flipbook-menu-btn')
                    .addClass('fa fa-file')
					.addClass('flipbook-icon-general')
                    .addClass('skin-color')
                ;
            }

            if (THREEx.FullScreen.available() && self.options.btnExpand){
                var btnExpand = $(document.createElement('span'))
                    .attr('aria-hidden', 'true')
                    .appendTo(this.menu)
                    .bind(this.CLICK_EV, function(){


                        if (THREEx.FullScreen.available()) {
                            if (THREEx.FullScreen.activated()) {
                                THREEx.FullScreen.cancel();
                                $(this)
									.addClass('fa-expand')
									.removeClass('fa-compress')
                                ;
                            }
                            else {
                                THREEx.FullScreen.request(self.wrapper[0]);
                                $(this)
									.addClass('fa-compress')
									.removeClass('fa-expand')
                                ;
                            }
                        }
                    })
                    .addClass('flipbook-menu-btn')
                    .addClass('flipbook-icon-general')
                   .addClass('fa fa-expand')
                    .addClass('skin-color')
                    ;
            }
        },

        createShareButtons:function(){
            var self = this;
            this.shareButtons = $(document.createElement('span'))
                .appendTo(this.bookLayer)
                .addClass('flipbook-shareButtons')
                .addClass('skin-color-bg')
                .addClass('invisible')
                .addClass('transition')
            ;

            var i;
            for (i = 0; i<self.options.social.length; i++){
                createButton(self.options.social[i]);
            }
            function createButton(social){
                var btn = $(document.createElement('span'))
                        .attr('aria-hidden', 'true')
                        .appendTo(self.shareButtons)
                        .addClass('fa')
                        .addClass('flipbook-shareBtn')
                        .addClass(social.icon)
                        .addClass('flipbook-icon-general')
                        .addClass('skin-color')
                        .bind(self.CLICK_EV, function(e){
                            window.open(social.url,"_self")
                        })
                    ;
            }
        },

        zoomOut:function(){
            if(!this.webglMode){
                var newZoom = this.scroll.scale / 1.5 < this.scroll.options.zoomMin ? this.scroll.options.zoomMin : this.scroll.scale / 1.5;
                this.scroll.zoom(this.bookLayer.width()/2,this.bookLayer.height()/2,newZoom,400);
            }else
                this.Book.zoomFor(-1);
        },
        zoomIn:function(){
            if(!this.webglMode){
                var newZoom = this.scroll.scale * 1.5 > this.scroll.options.zoomMax ? this.scroll.options.zoomMax : this.scroll.scale * 1.5;
                this.scroll.zoom(this.bookLayer.width()/2,this.bookLayer.height()/2,newZoom,400);
            }else
                this.Book.zoomFor(1);
        },

        toggleShare:function(){
            this.shareButtons.toggleClass('invisible');
        },
        /**
         * create current page indicator
         */
        createCurrentPage : function(){
            var self = this;
            this.currentPage =  $(document.createElement('input'))
                .addClass('flipbook-currentPage')
                .attr('type', 'text')
                .addClass('skin-color')
                .appendTo(this.menuWrapper)
                .keyup(function (e) {
                    if (e.keyCode == 13) {
                        var value = parseInt($(this).val())-1;
						if(self.options.rightToLeft){
							value = self.options.pages.length - value - 1;
						}
                        self.updateCurrentPage();
                        self.Book.goToPage(value);
                    }
                })
                .focus(function(e){
                    $(this).val("");
                })
                .focusout(function(e){
                    var value = parseInt($(this).val())-1;
                    self.updateCurrentPage();
                    // self.Book.goToPage(value);
                })
            ;
        },

        createToc:function(){
            var self = this;
            this.tocHolder =  $(document.createElement('div'))
                .addClass('flipbook-tocHolder')
                .addClass('invisible')
                .appendTo(this.wrapper)
//                .hide();
            ;
            this.toc =  $(document.createElement('div'))
                .addClass('.flipbook-toc')
                .appendTo(this.tocHolder)
            ;
            self.tocScroll = new iScroll(self.tocHolder[0],{bounce:false});

            //tiile
            var title = $(document.createElement('span'))
                .addClass('flipbook-tocTitle')
                .addClass('skin-color-bg')
                .addClass('skin-color')
                .appendTo(this.toc)
            ;
//            title.text(this.options.tocTitle);
//            var btnToc = $(document.createElement('span'))
//                .attr('aria-hidden', 'true')
//                .appendTo(title)
//                .css('float','left')
//                .addClass('icon-list')
//                .addClass('icon-social')
//                ;

             var btnClose = $(document.createElement('span'))
                .attr('aria-hidden', 'true')
                .appendTo(title)
                .css('height','20px')
                .css('position','absolute')
                .css('top','0px')
                .css('right','0px')
                .css('cursor','pointer')
                .css('font-size','.8em')
                .addClass('fa fa-times')
                .addClass('flipbook-icon-general')
                 .addClass('skin-color')
                 .addClass('skin-color-bg')
                 .bind(self.START_EV, function(e){
                     self.toggleToc();
                 });


			var pages = this.pages ;
			
            for(var i = 0; i<pages.length; i++)
            {
                if(pages[i].title == "")
                    continue;
                if(typeof  pages[i].title === "undefined")
                    continue;

                var tocItem = $(document.createElement('a'))
                    .attr('class', 'flipbook-tocItem')
                    .addClass('skin-color-bg')
                    .addClass('skin-color')
                    .attr('title', String(i+1))
                    .appendTo(this.toc)
//                    .unbind(self.CLICK_EV)
                    .bind(self.CLICK_EV, function(e){

                        if(!self.tocScroll.moved ){
                            var clickedPage = Number($(this).attr('title'))-1;
							if(self.options.rightToLeft)
								clickedPage = self.pages.length - clickedPage - 1;
                            if(self.Book.goingToPage != clickedPage)
                                self.Book.goToPage(clickedPage);
//                            console.log(e,this);
                        }
                    })
                ;
                $(document.createElement('span'))
                    .appendTo(tocItem)
                    .text(pages[i].title);
                $(document.createElement('span'))
                    .appendTo(tocItem)
                    .attr('class', 'right')
                    .text(i+1);
            }

            self.tocScroll.refresh();
        },

        /**
         * update current page indicator
         */
        updateCurrentPage : function(){
            if(typeof this.currentPage === 'undefined')
                return;
            var text, rightIndex = this.Book.rightIndex, pagesLength = this.webglMode ? this.Book.pages.length*2 : this.Book.pages.length;
            if (rightIndex == 0) {
                text = "1 / " + String(pagesLength);
				if(this.options.rightToLeft)
					text = String(pagesLength) + " / " + String(pagesLength);
            }
            else if (rightIndex == pagesLength) {
                text = String(pagesLength) + " / " + String(pagesLength);
				if(this.options.rightToLeft)
					text = "1 / " + String(pagesLength);
            }
            else {
                text = String(rightIndex) + "," + String(rightIndex + 1) + " / " + String(pagesLength);
				if(this.options.rightToLeft)
					text = String(pagesLength-rightIndex) + "," + String(pagesLength-rightIndex + 1) + " / " + String(pagesLength);
            }
            if(this.p && this.options.pages.length != 24 && this.options.pages.length != 8)
                this.Book.goToPage(0)
            this.currentPage.attr('value',text);
            this.currentPage.attr('size', this.currentPage.val().length);
        },

        /**
         * page turn is completed, update what is needed
         */
        turnPageComplete:function () {
            //this == FLIPBOOK.Book

            this.animating = false;
            this.updateCurrentPage();
        },

        /**
         * update book size
         */
        resize:function(){
            var blw = this.bookLayer.width(),
                blh = this.bookLayer.height(),
                bw = this.book.width(),
                bh = this.book.height(),
                menuW = this.menuWrapper.width();
            var self = this;
            if(blw == 0 || blh == 0 || bw == 0 || bh == 0){
                setTimeout(function(){
                    self.resize();
                }, 1000);
                return;
            }

            if(blw/blh >= bw/bh)
                this.fitToHeight(true);
            else
                this.fitToWidth(true);

            //center the menu
//            this.menuWrapper.css('left',String(blw/2 - menuW / 2)+'px');
            if(this.options.btnShare){
                var sharrBtnX = this.btnShare.offset().left;
                var bookLayerX = this.bookLayer.offset().left;
                this.shareButtons.css('left',String(sharrBtnX-bookLayerX)+'px');
            }
        },

        /**
         * fit book to screen height
         * @param resize
         */
        fitToHeight:function (resize) {
            var x= this.bookLayer.height();
            var y= this.book.height();
            if(resize) this.ratio = x/y;
            this.fit(this.ratio, resize);
            this.thumbsVertical();
        },

        /**
         * fit book to screen width
         * @param resize
         */
        fitToWidth:function (resize) {
            var x= this.bookLayer.width();
            var y= this.book.width();
            if(resize) this.ratio = x/y;
            this.fit(this.ratio, resize);
//            this.thumbsHorizontal();
            this.thumbsVertical();
        },

        /**
         * resize book by zooming it with iscroll
         * @param r
         * @param resize
         */
        fit:function(r, resize) {
            if(!this.webglMode){
                r = resize ? this.ratio : this.scroll.scale;
                if (resize){

                    this.scroll.options.zoomMin = r *this.options.zoomMin;
                    this.scroll.options.zoomMax = r *this.options.zoomMax;
                }
                this.scroll.zoom(this.bookLayer.width()/2,this.bookLayer.height()/2,r *this.options.zoom,0);
            }
        },

        /**
         * create thumbs
         */
        createThumbs : function () {
            var self = this,point1,point2;
            self.thumbsCreated = true;
            //create thumb holder - parent for thumb container
            self.thumbHolder = $(document.createElement('div'))
                .addClass('flipbook-thumbHolder')
                .addClass('invisible')
                .appendTo(self.bookLayer)
                .css('position', 'absolute')
                .css('display', 'none')
            ;
            //create thumb container - parent for thumbs
            self.thumbsContainer = $(document.createElement('div')).
                appendTo(self.thumbHolder)
                .addClass('flipbook-thumbContainer')
                .css('margin', '0px')
                .css('padding', '0px')
                .css('position', 'relative')
            ;
            //scroll for thumb container
            self.thumbScroll = new iScroll(self.thumbHolder[0],{bounce:false});
            self.thumbs = [];
			var pages = self.pages;
            for (var i = 0; i < pages.length; i++) {
                var imgUrl = pages[i].thumb;
                var thumbsLoaded = 0;
                var thumb = new FLIPBOOK.Thumb($, self.Book, imgUrl, self.options.thumbnailWidth, self.options.thumbnailHeight, i);
                thumb.image.style[self.transform] = 'translateZ(0)';
                self.thumbs.push(thumb);
                $(thumb.image)
                    .attr('title', i + 1)
                    .appendTo(self.thumbsContainer)
                    .bind(self.CLICK_EV, function(e){
                        if(!self.thumbScroll.moved)
                        {
                            var clickedPage = Number($(this).attr('title'))-1;
							if(self.options.rightToLeft)
								clickedPage = pages.length - clickedPage - 1;
                            if(self.Book.goingToPage != clickedPage)
                                self.Book.goToPage(clickedPage);
                        }
                    });
                thumb.loadImage();
            }
        },

        /**
         * toggle thumbs
         */
        toggleThumbs : function (value) {
            if (!this.thumbsCreated)
                this.createThumbs();
            this.thumbHolder.css('display','block');
			if(value)
				this.thumbHolder.removeClass('invisible');
			else
				this.thumbHolder.toggleClass('invisible');
            var self = this;
            this.thumbsVertical();
        },
		
		toggleToc:function(value){
			if(value)
				this.tocHolder.removeClass('invisible');
			else
				this.tocHolder.toggleClass('invisible');
            this.tocScroll.refresh();
        },

        /**
         * thumbs vertical view
         */
        thumbsVertical:function(){
            if (!this.thumbsCreated)
                return;
            var w = this.options.thumbnailWidth,
                h = this.options.thumbnailHeight * this.thumbs.length;
            this.thumbHolder
                .css('width', String(w) + 'px')
                .css('left', 'auto')
                .css('top', '0px')
                .css('right', '0px');
            this.thumbsContainer
                .css('height', String(h) + 'px')
                .css('width', String(w) + 'px');
			var margin = 5; 
			var marginBig = 10; 
            for(var i=0;i<this.thumbs.length;i++)
            {
                var thumb = this.thumbs[i].image;
                thumb.style.top = String(i*this.options.thumbnailHeight + (i%2)*marginBig )+'px';
                thumb.style.left = '0px';
            }
            this.thumbScroll.hScroll = false;
            this.thumbScroll.vScroll = true;
            this.thumbScroll.refresh();
        },

        /**
         * thumbs horizontal view
         */
        thumbsHorizontal:function(){
            if (!this.thumbsCreated)
                return;
            var w = this.options.thumbnailWidth* this.thumbs.length,
                h = this.options.thumbnailHeight ;
            this.thumbHolder
                .css('width', '100%')
                .css('height', String(h) + 'px')
                .css('left', '0px')
                .css('right', 'auto')
                .css('top', 'auto')
                .css('bottom', '0px')
            ;
            this.thumbsContainer
                .css('height', String(h) + 'px')
                .css('width', String(w) + 'px')
            ;
            for(var i=0;i<this.thumbs.length;i++)
            {
                var thumb = this.thumbs[i].image;
                thumb.style.top = '0px';
                thumb.style.left = String(i*this.options.thumbnailWidth)+'px';
            }
            this.thumbScroll.hScroll = true;
            this.thumbScroll.vScroll = false;
            this.thumbScroll.refresh();
        }   ,

        /**
         * toggle full screen
         */
        toggleExpand : function() {
            if (THREEx.FullScreen.available()) {
                if (THREEx.FullScreen.activated()) {
                    THREEx.FullScreen.cancel();
                }
                else {
                    THREEx.FullScreen.request();
                }
            }
        },
        lightboxStart:function(){
			if(!this.started)
				this.start();
			this.Book.enable();
			if(this.options.contentOnStart)
				this.toggleToc(true)
			if(this.options.thumbnailsOnStart)
				this.toggleThumbs(true)
        },
        lightboxEnd:function(){
			this.Book.disable();
            if (THREEx.FullScreen.available()) {
                if (THREEx.FullScreen.activated()) {
                    THREEx.FullScreen.cancel();
                }
            }
        }
    };

        //easign functions
    $.extend($.easing,
        {
            def: 'easeOutQuad',
            swing: function (x, t, b, c, d) {
                //alert($.easing.default);
                return $.easing[$.easing.def](x, t, b, c, d);
            },
            easeInQuad: function (x, t, b, c, d) {
                return c*(t/=d)*t + b;
            },
            easeOutQuad: function (x, t, b, c, d) {
                return -c *(t/=d)*(t-2) + b;
            },
            easeInOutQuad: function (x, t, b, c, d) {
                if ((t/=d/2) < 1) return c/2*t*t + b;
                return -c/2 * ((--t)*(t-2) - 1) + b;
            },
            easeInCubic: function (x, t, b, c, d) {
                return c*(t/=d)*t*t + b;
            },
            easeOutCubic: function (x, t, b, c, d) {
                return c*((t=t/d-1)*t*t + 1) + b;
            },
            easeInOutCubic: function (x, t, b, c, d) {
                if ((t/=d/2) < 1) return c/2*t*t*t + b;
                return c/2*((t-=2)*t*t + 2) + b;
            },
            easeInQuart: function (x, t, b, c, d) {
                return c*(t/=d)*t*t*t + b;
            },
            easeOutQuart: function (x, t, b, c, d) {
                return -c * ((t=t/d-1)*t*t*t - 1) + b;
            },
            easeInOutQuart: function (x, t, b, c, d) {
                if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
                return -c/2 * ((t-=2)*t*t*t - 2) + b;
            },
            easeInQuint: function (x, t, b, c, d) {
                return c*(t/=d)*t*t*t*t + b;
            },
            easeOutQuint: function (x, t, b, c, d) {
                return c*((t=t/d-1)*t*t*t*t + 1) + b;
            },
            easeInOutQuint: function (x, t, b, c, d) {
                if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
                return c/2*((t-=2)*t*t*t*t + 2) + b;
            },
            easeInSine: function (x, t, b, c, d) {
                return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
            },
            easeOutSine: function (x, t, b, c, d) {
                return c * Math.sin(t/d * (Math.PI/2)) + b;
            },
            easeInOutSine: function (x, t, b, c, d) {
                return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
            },
            easeInExpo: function (x, t, b, c, d) {
                return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
            },
            easeOutExpo: function (x, t, b, c, d) {
                return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
            },
            easeInOutExpo: function (x, t, b, c, d) {
                if (t==0) return b;
                if (t==d) return b+c;
                if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
                return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
            },
            easeInCirc: function (x, t, b, c, d) {
                return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
            },
            easeOutCirc: function (x, t, b, c, d) {
                return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
            },
            easeInOutCirc: function (x, t, b, c, d) {
                if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
                return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
            },
            easeInElastic: function (x, t, b, c, d) {
                var s=1.70158;var p=0;var a=c;
                if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
                if (a < Math.abs(c)) { a=c; var s=p/4; }
                else var s = p/(2*Math.PI) * Math.asin (c/a);
                return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
            },
            easeOutElastic: function (x, t, b, c, d) {
                var s=1.70158;var p=0;var a=c;
                if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
                if (a < Math.abs(c)) { a=c; var s=p/4; }
                else var s = p/(2*Math.PI) * Math.asin (c/a);
                return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
            },
            easeInOutElastic: function (x, t, b, c, d) {
                var s=1.70158;var p=0;var a=c;
                if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
                if (a < Math.abs(c)) { a=c; var s=p/4; }
                else var s = p/(2*Math.PI) * Math.asin (c/a);
                if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
                return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
            },
            easeInBack: function (x, t, b, c, d, s) {
                if (s == undefined) s = 1.70158;
                return c*(t/=d)*t*((s+1)*t - s) + b;
            },
            easeOutBack: function (x, t, b, c, d, s) {
                if (s == undefined) s = 1.70158;
                return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
            },
            easeInOutBack: function (x, t, b, c, d, s) {
                if (s == undefined) s = 1.70158;
                if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
                return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
            },
            easeInBounce: function (x, t, b, c, d) {
                return c - $.easing.easeOutBounce (x, d-t, 0, c, d) + b;
            },
            easeOutBounce: function (x, t, b, c, d) {
                if ((t/=d) < (1/2.75)) {
                    return c*(7.5625*t*t) + b;
                } else if (t < (2/2.75)) {
                    return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
                } else if (t < (2.5/2.75)) {
                    return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
                } else {
                    return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
                }
            },
            easeInOutBounce: function (x, t, b, c, d) {
                if (t < d/2) return $.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
                return $.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
            }
        });

})(jQuery, window, document)

