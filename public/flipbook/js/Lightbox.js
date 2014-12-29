var FLIPBOOK = FLIPBOOK || {};

FLIPBOOK.Lightbox = function(context,content,options){

    var self = this;
    this.context = context;
    this.options = options;
    // var image = (context.elem.nodeName.toLowerCase() === 'img') ? context.$elem : context.$elem.find('img');
    // image
        // .css('cursor','pointer')
        // .bind(context.START_EV, function(){
            // self.openLightbox();
        // });
		
		
	$(context.elem)
		.css('cursor','pointer')
        .bind(context.START_EV, function(){
            self.openLightbox();
        });
		
	var overlay = $('<div/>')
		.addClass('flipbook-lightbox-thumb-overlay')
		.appendTo($(context.elem));
	var iconHolder = $('<div/>')
		.addClass('flipbook-lightbox-thumb-icon-holder')
		.appendTo(overlay);
	//add boverlay to elem
	var icon = $('<span/>')
		// .attr('aria-hidden', 'true')
		.addClass('fa fa-book fa-4x')
		// .addClass('flipbook-icon-general')
		.addClass('flipbook-lightbox-thumb-icon')
		.appendTo(iconHolder);
	
    self.overlay = jQuery(document.createElement('div'))
        .attr('class', 'flipbook-overlay')
        .css('visibility', 'hidden')
        .css('z-index', '999999')      // on top of everything ! wordpress menu bar has z-index 99999
        .bind(context.START_EV, function(e){
            if (jQuery(e.target).hasClass('flipbook-overlay')) {
                self.closeLightbox();
            }
        })
        .appendTo('body')
//                .appendTo(self.$elem)
    ;

    self.wrapper = jQuery(document.createElement('div'))
        .css('width', self.options.lightboxWidth)
        .css('height', 'auto')
        .appendTo(self.overlay)
    ;
    if(self.options.lightboxTransparent == true){
        self.wrapper
            .attr('class', 'flipbook-wrapper-transparent')
            .css('margin', '0px auto' )
            .css('padding', '0px')
            .css('height', '100%')
            .css('width', '100%')
        ;
    }else{
        self.wrapper
            .attr('class', 'flipbook-wrapper')
            .css('margin', String(self.options.lightboxMargin)+'px auto' )
            .css('padding', String(self.options.lightboxPadding)+'px')
        ;
        content
        .css('margin', String(self.options.lightboxPadding)+'px')
    }

    content
//        .css('margin', String(self.options.lightboxPadding)+'px')
        .appendTo(self.wrapper)
    ;

    // close button
        jQuery(document.createElement('span'))
            .attr('aria-hidden', 'true')
            .appendTo(self.wrapper)
            .addClass('fa fa-times')
            .addClass('flipbook-icon-general')
            .addClass('skin-color')
            .css('right','0')
            .css('top','0')
            .css('height','20px')
            .css('position','absolute')
            .css('cursor','pointer')
			.addClass('skin-color-bg')
            .bind(self.context.START_EV, function(e){
                self.closeLightbox();
            });

    self.resize();
    jQuery(window).resize(function () {
        self.resize();
    });
    self.resize();

//    this.overlay.css('display','none');

};

FLIPBOOK.Lightbox.prototype = {

    openLightbox:function(){
        var self = this;
        this.overlay.css('visibility','visible');
        this.overlay.css('display','none');
        this.wrapper.css('display','none');
        this.overlay.fadeIn("fast", function(){
            self.wrapper.css('display','block');
			self.context.lightboxStart();
        });
        jQuery('body').css('overflow', 'hidden');
		// self.context.resize();
        
    },
    closeLightbox:function(){
        var self = this;
        this.overlay.fadeOut("fast");
//        this.overlay.css('visibility','hidden');
        jQuery('body').css('overflow', 'auto');

        self.context.lightboxEnd();
    },
    resize:function(){
        var self = this;
        var $window = jQuery(window), ww = $window.width(), wh = $window.height();
        if(self.options.lightboxTransparent == true) {
//        if(self.options.lightboxTransparent == true || (THREEx.FullScreen.available() && THREEx.FullScreen.activated())) {
            self.wrapper
                .css('width', '100%')
            ;
        } else {
            self.wrapper.css('width', self.options.lightboxWidth);

            if((self.wrapper.width() + 2*self.options.lightboxMargin + 2*self.options.lightboxPadding) < self.options.lightboxMinWidth){
                self.wrapper.css('width', String(ww - 2*self.options.lightboxMargin -2*self.options.lightboxPadding)+'px');
            }

        }
    }
};