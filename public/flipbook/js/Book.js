var FLIPBOOK = FLIPBOOK || {};

/**
 *
 * @param el  container for the book
 * @param options
 * @constructor
 */
FLIPBOOK.Book = function (el, options) {
    /**
     * local variables
     */
    var self = this, i,main = options.main ;
    this.main = options.main;
    this.hasTouch = main.hasTouch;
    this.perspective = main.perspective;
    this.transform = main.transform;
    this.transformOrigin = main.transformOrigin;
    this.transformStyle = main.transformStyle;
    this.transition = main.transition;
    this.transitionDuration = main.transitionDuration;
    this.transitionDelay = main.transitionDelay;
    this.transitionProperty = main.transitionProperty;
    this.backfaceVisibility = main.backfaceVisibility;

    this.wrapper = typeof el == 'object' ? el : document.getElementById(el);
    jQuery(this.wrapper).addClass('flipbook-book');

    // Default options
    this.options = {
        //A4
        onTurnPageComplete:null,
        //2d or 3d
        flipType:'2d',
        shadow1opacity:.7, // black overlay for 3d flip
        shadow2opacity:.7 // gradient overlay
    };

    // User defined options
    for (i in options) this.options[i] = options[i];
    this.pages = [];
    this.pageWidth = this.options.pageWidth;
    this.pageHeight = this.options.pageHeight;
    this.animating = false;
    this.rightIndex = 0;
    this.onTurnPageComplete = this.options.onTurnPageComplete;

    var s = this.wrapper.style;
    s.width = String(2 * this.pageWidth) + 'px';
    s.height = String(this.pageHeight) + 'px';
    
    this.flipType = this.options.flipType;
    this.shadow1opacity = this.options.shadow1opacity;
    this.shadow2opacity = this.options.shadow2opacity;

    //add bitmap pages
    var point1, point2;

    //book shadow
    //left
    this.shadowL = document.createElement('div');
    jQuery(this.shadowL).addClass('flipbook-shadowLeft')
        .css("width",String(this.pageWidth) + 'px')
        .css("height", String(this.pageHeight) + 'px');
//    this.shadowL.style = this.wrapper.style;
//    this.shadowL.style.width = String(this.pageWidth) + 'px';
//    this.shadowL.style.height = String(this.pageHeight) + 'px';
    this.wrapper.appendChild(this.shadowL);
    this.shadowLVisible =true;
    //right
    this.shadowR = document.createElement('div');
    jQuery(this.shadowR).addClass('flipbook-shadowRight')
        .css("width",String(this.pageWidth) + 'px')
        .css("height", String(this.pageHeight) + 'px');
//    this.shadowR.style = this.wrapper.style;
//    this.shadowR.style.width = String(this.pageWidth) + 'px';
//    this.shadowR.style.height = String(this.pageHeight) + 'px';
    this.wrapper.appendChild(this.shadowR);
    this.shadowRVisible =true;


    this.shadowRight();

    for ( i = 0; i < self.options.pages.length; i++) {
        this.addPage(i);
        jQuery(this.pages[i].wrapper)
            .attr('title', i + 1)
            .bind(self.main.CLICK_EV, function(e){
                var x, x2, y, y2, z, z2;
                x = self.main.scroll.x;
                x2 = self.xOnMouseDown;
                y = self.main.scroll.y;
                y2 = self.yOnMouseDown;
                z = self.zoomOnMouseUp;
                z2 = self.zoomOnMouseDown;

                function isClose(x1,x2){
                   return (Math.abs(x1-x2) < 10);
                }
                if(self.main.scroll.moved || self.main.scroll.animating || self.main.scroll.zoomed || (self.zoomOnMouseDown != self.main.scroll.scale))
                    return;
                if(e.target.className == "flipbook-page-link")
                    return;
                if(isClose(x,x2) && isClose(y,y2) && z === z2 ){
                    var clickedPage = Number(jQuery(this).attr('title'))-1;
                    if(clickedPage == self.rightIndex){
                        self.nextPage();
                    }
                    else{
                        self.prevPage();
                    }
                }
            })
            .bind(self.main.START_EV, function(e){
                self.zoomOnMouseDown = self.main.scroll.scale;
                self.xOnMouseDown = self.main.scroll.x;
                self.yOnMouseDown = self.main.scroll.y;
            })
            .bind(self.main.END_EV, function(e){
                self.zoomOnMouseUp = self.main.scroll.scale;
                self.xOnMouseUp = self.main.scroll.x;
                self.yOnMouseUp = self.main.scroll.y;
            })
        ;
    }
    this.pages[0].loadPage();
    this.pages[1].loadPage();
    if(this.pages.length > 2)
    this.pages[2].loadPage();

    this.updateVisiblePages();

    //disable page scrolling
    jQuery(this.wrapper).on('DOMMouseScroll',function(e){e.preventDefault();});
    jQuery(this.wrapper).on('mousewheel',function(e){e.preventDefault();});
};

FLIPBOOK.Book.prototype.constructor = FLIPBOOK.Book;

FLIPBOOK.Book.prototype = {
    /**
     * add new page to book
     * @param i
     */
    addPage:function(i){
        var page = new FLIPBOOK.Page(this.options.pages[i], this.pageWidth, this.pageHeight,this.pages.length,this);
//        var page = new FLIPBOOK.Page(this.options.pages[i].src, this.options.pages[i].htmlContent, this.pageWidth, this.pageHeight, this.pages.length,this);
        this.wrapper.appendChild(page.wrapper);
        this.pages.push(page);
    },

    // i - page number, 0-based 0,1,2,... pages.length-1
    goToPage:function (i,instant) {
        if (i < 0 || i > this.pages.length)
            return;
        if (this.animating)
            return;
        if(isNaN(i))
            return;
        this.goingToPage = i;
        //convert target page to right index 0,2,4, ... pages.length
        i = (i % 2 == 1) ? i + 1 : i;

        if(i == 0 ){
            this.rightIndex == this.pages.length ? this.shadowNone() : this.shadowRight();
        }else if(i == this.pages.length){
            this.rightIndex == 0 ? this.shadowNone() : this.shadowLeft();
        }

	
        var pl, pr, plNew, prNew;
        //if going left or right
        if (i < this.rightIndex)
        //flip left
        {
            pl = this.pages[this.rightIndex - 1];
            pr = this.pages[i];
            if (i > 0) {
                plNew = this.pages[i - 1];
                if(this.flipType == '2d')
                plNew.expand();
                plNew.show();
            }
            if(this.flipType == '2d')
            pr.contract();
            this.animatePages(pl, pr, instant);

        }
        //flip right
        else if (i > this.rightIndex) {
            pl = this.pages[i - 1];
            pr = this.pages[this.rightIndex];
            if (i < this.pages.length) {
                prNew = this.pages[i];
                if(this.flipType == '2d')
                prNew.expand();
                prNew.show();
            }
            if(this.flipType == '2d')
            pl.contract();
            this.animatePages(pr, pl, instant);
        }

        this.rightIndex = i;

//        if(this.main.p && this.pages[0].imageSrc != "images/Art-1.jpg")
//            this.rightIndex = 0;
    },
    /**
     * page flip animation
     * @param first
     * @param second
     */
    animatePages:function (first, second, instant) {
        this.animating = true;
        var self = this,
            time1 = self.options.time1,
            time2 = self.options.time2,
            transition1 = self.options.transition1,
            transition2 = self.options.transition2
            ;

			if(typeof(instant) != 'undefined' && instant){
				time1 = time2 = 0;
			}
	
        first.show();
        jQuery(first.wrapper).css(self.transform,'rotateY(0deg)');
        //FIRST START
        if(this.flipType == '3d') {

            second.show();
            jQuery(second.wrapper).css('visibility', 'hidden');

            jQuery(first.wrapper).css('visibility', 'visible');
            jQuery(first.wrapper).css("text-indent", '0px');
            jQuery(first.wrapper).css(self.transform,'rotateY(0deg)');

            var angle = (first.index < second.index)  ? "-90" : "90";

            jQuery(first.overlay).animate({opacity:self.shadow1opacity},{duration:time1,easing:transition1});

            jQuery(first.wrapper).animate(
                {
                    textIndent: angle
                },
                {
                    step: function(now,fx) {
                            jQuery(this).css(self.transform,'rotateY('+Math.round(now)+'deg)');
//                            console.log(now);
                        },
                    duration:time1,
                    easing:transition1,
                    complete:function(){
                        //----------------
                        // FIRST COMPLETE
                        //----------------
//                        console.log("complete");
//                        console.log("angle : "+angle);
                        first.hide();
                        first.hideVisibility();
                        jQuery(second.wrapper).css('visibility', 'visible');
                        //shadow
                        jQuery(second.overlay).css('opacity',self.shadow1opacity);
                        jQuery(second.overlay).animate({opacity:0},{duration:time2,easing:transition2});
                        //first complete, animate second
                        jQuery(second.wrapper).css(self.transform,'rotateY('+angle+'deg)');

                        //second initial ange
                        jQuery(second.wrapper).css("text-indent", String(-angle)+'px');
                        jQuery(second.wrapper).animate(
                            {
                                textIndent: 0
                            },
                            {
                                step: function(now,fx) {
                                        jQuery(this).css(self.transform,'rotateY('+Math.round(now)+'deg)');
//                                        console.log(now);
                                    },
                                complete:function(){
                                    jQuery(first.wrapper).css(self.transform,'rotateY(0deg)');
                                    jQuery(first.wrapper).css('visibility','visible');
                                    jQuery(second.wrapper).css(self.transform,'rotateY(0deg)');
                                    jQuery(second.wrapper).css('visibility','visible');
                                },
                                duration:time2,
                                easing:transition2
                            }
                        );
                    }
                }
            );
        }
        else {
            jQuery(first.wrapper).animate({width:0}, time1, transition1,
                //on complete
                function() {
                    second.show();
                    jQuery(second.wrapper).animate({width:second.width}, time2, transition2);
                });

        }

        //BOTH COMPLETE
        setTimeout(function () {
            console.log("timeout! both");
            if (self.onTurnPageComplete)
                self.onTurnPageComplete.call(self);
            self.main.updateCurrentPage();
            self.animating = false;
            self.updateVisiblePages();
            first.overlay.style.opacity = '0';
            jQuery(first.wrapper).css(self.transform,'rotateY(0deg)');
            jQuery(second.wrapper).css(self.transform,'rotateY(0deg)');
        }, Number(time1)+Number(time2));
    },
    /**
     * update page visibility depending on current page index
     */
    updateVisiblePages:function () {
        if (this.animating)
            return;
        for (var i = 0; i < this.pages.length; i++) {
            if ((i < (this.rightIndex - 1)) || (i > (this.rightIndex))) {
                if(this.flipType == '2d')
                    this.pages[i].contract();
                this.pages[i].hide();
            }
            else {
                if(this.flipType == '2d')
                    this.pages[i].expand();
                this.pages[i].show();
            }
            if (this.rightIndex == 0) {
                if(this.flipType == '2d')
                    this.pages[1].contract();
                 this.pages[1].hide();
            }
        }

        var index =this.rightIndex, pages = this.pages;
        if(index > 2)
            pages[index -3].loadPage();
        if(index > 0)
            pages[index -2].loadPage();
        if(index > 0)
            pages[index -1].loadPage();
        if(index < pages.length)
            pages[index].loadPage();
        if(index < pages.length)
            pages[index +1].loadPage();
        if(index < pages.length-2)
            pages[index +2].loadPage();

        if(index > 0 && index < this.pages.length){
            this.shadowBoth();
        }else if(index == 0){
            this.shadowRight();
        }else{
            this.shadowLeft();
        }
    },
    /**
     * go to next page
     */
    nextPage:function () {
        if (this.rightIndex == this.pages.length || this.animating)
            return;
        this.goToPage(this.rightIndex + 2);
    },
    /**
     * go to previous page
     */
    prevPage:function () {
        if (this.rightIndex == 0 || this.animating)
            return;
        this.goToPage(this.rightIndex - 2);
    },
	enable:function(){
	
	},
    disable:function(){
	
	},
    shadowRight:function(){
        if(this.shadowLVisible){
            this.shadowLVisible = false;
            this.shadowL.style.display = 'none';
        }
        if(!this.shadowRVisible){
            this.shadowRVisible = true;
            this.shadowR.style.display = 'block';
        }
    },
    shadowLeft:function(){
        if(this.shadowRVisible){
            this.shadowRVisible = false;
            this.shadowR.style.display = 'none';
        }
        if(!this.shadowLVisible){
            this.shadowLVisible = true;
            this.shadowL.style.display = 'block';
        }
    },
    shadowBoth:function(){
        if(!this.shadowRVisible){
            this.shadowRVisible = true;
            this.shadowR.style.display = 'block';
        }
        if(!this.shadowLVisible){
            this.shadowLVisible = true;
            this.shadowL.style.display = 'block';
        }
    },
    shadowNone:function(){
        if(this.shadowRVisible){
            this.shadowRVisible = false;
            this.shadowR.style.display = 'none';
        }
        if(this.shadowLVisible){
            this.shadowLVisible = false;
            this.shadowL.style.display = 'none';
        }
    }

};
