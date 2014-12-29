FLIPBOOK.Page = function (options, width, height, index, book) {


    this.wrapper = document.createElement('div');
    jQuery(this.wrapper).addClass('flipbook-page');
    this.s = this.wrapper.style;
    this.s.width = String(width) + 'px';
    this.s.height = String(height) + 'px';
    this.index = index;
    this.book = book;
    this.width = width;
    this.height = height;

    this.invisible = false;

    this.image = new Image();
    /**
     * lightweight preloader for the page - shows until the page is loaded
     */
    this.image.src = book.options.assets.preloader;
    this.imageSrc = options.src;
    this.wrapper.appendChild(this.image);

    this.imageLoader = new Image();

    //shadow only on left page
//    if (this.index % 2 != 0) {
//        this.shadow = new Image();
//        this.wrapper.appendChild(this.shadow);
//    }

    //black overlay that will be used for shadow in 3d flip
    this.overlay = new Image();
    this.overlay.src = book.options.assets.overlay;
    this.wrapper.appendChild(this.overlay);
    this.overlay.style.opacity = '0';

    this.expanded = true;



//    this.clickArea = document.createElement('div');
//    this.clickArea.classList.add('flipbook-page-clickArea');

    this.htmlContent = options.htmlContent;



    //left pages (indexes 1,3,5,...)
    if (this.index % 2 == 0) {
        this.s.zIndex = String(100 - this.index);
        this.s.left = '50%';
        this.right(this.image);
        this.right(this.overlay);
    }
    //right pages (indexes 0,2,4,...)
    else {

//        shadow on left page
        this.shadow = new Image();
        this.wrapper.appendChild(this.shadow);
        this.shadow.src = book.options.assets.left;
        this.left(this.shadow);

        this.s.zIndex = String(100 + this.index);
        this.s.right = '50%';
        this.left(this.image);
        this.left(this.overlay);
    }

    if(typeof  this.htmlContent !== 'undefined'){
        this.htmlContainer = document.createElement('div');
        jQuery(this.htmlContainer).addClass('flipbook-page-htmlContainer');
        this.wrapper.appendChild(this.htmlContainer);
        this.index % 2 == 0 ? this.right(this.htmlContainer) : this.left(this.htmlContainer);
    }

//    this.wrapper.appendChild(this.clickArea);

    this.image.style[this.book.transform] = 'translateZ(0)';

    this.overlay.style[this.book.transform] = 'translateZ(0)';
    this.overlay.style['pointer-events'] = 'none';

    if(this.shadow){
        this.shadow.style[this.book.transform] = 'translateZ(0)';
        this.shadow.style['pointer-events'] = 'none';
    }

    this.s.top = '0px';

    if (this.book.flipType == '3d') {
        this.wrapper.style[this.book.transformOrigin] = (this.index % 2 != 0) ? '100% 50%' : '0% 50%';
    }

    //links

    if(options.links)
    {
        var self = this;
        for(var i= 0; i<options.links.length;i++){

            var link = options.links[i];



            function createLink(link){
                var l = document.createElement('div');
                self.wrapper.appendChild(l);
                l.classList.add("flipbook-page-link");
                l.style.position = 'absolute';
                l.style.left = String(link.x)+'px';
                l.style.top = String(link.y)+'px';
                l.style.width = String(link.width)+'px';
                l.style.height = String(link.height)+'px';
                l.style.backgroundColor = link.color;
                l.style.opacity = link.alpha;
                l.style.cursor = 'pointer';
                jQuery(l)
                    .click(function(e){
                        if(Number(link.page)>0 ){
                            book.goToPage(Number(link.page))
                        }else if(String(link.url) != ''){
                            window.open(link.url);
                        }
                    })
                    .mouseenter(function(){
                        l.style.backgroundColor = link.hoverColor;
                        l.style.opacity = link.hoverAlpha;
                    })
                    .mouseleave(function(){
                        l.style.backgroundColor = link.color;
                        l.style.opacity = link.alpha;
                    })

                ;
            }
            createLink(link);

        }
    }

};

/**
 * prototype
 * @type {Object}
 */
FLIPBOOK.Page.prototype = {
    loadPage:function () {
        if(this.loaded == true)
            return;
        this.loaded = true;
        var self = this;
        self.imageLoader.src =     this.imageSrc;
        jQuery(self.imageLoader).load(function () {
            self.image.src = self.imageSrc;
        });
        if(typeof  this.htmlContent !== 'undefined'){
            this.htmlContainer.innerHTML = this.htmlContent;
        }
    },

    flipView:function () {

    },
    /**
     * expand page to full width
     */
    expand:function () {
        if(!this.expanded)
            this.s.width = String(this.width) + 'px';
        this.expanded = true;
    },
    /**
     * contract page to width 0
     */
    contract:function () {
        if(this.expanded)
            this.s.width = '0px';
        this.expanded = false;
    },
    show:function () {
        if(this.hidden){
//            this.invisible = false;
//            this.s.visibility = 'visible';
            this.s.display = 'block';
        }
        this.hidden = false;
    },
    hide:function () {
        if(!this.hidden){
            this.s.display = 'none';
        }
//            this.s.visibility = 'hidden';
        this.hidden = true;
    },
    hideVisibility:function () {
        if(!this.invisible)
            this.s.visibility = 'hidden';
        this.invisible = true;
    },
    /**
     * init left page image
     * @param image
     */
    left:function (image) {
        var s= image.style;
        s.width = String(this.width) + 'px';
        s.height = String(this.height) + 'px';
        s.position = 'absolute';
        s.top = '0px';
        s.right = '0px';
    },
    /**
     * init right page image
     * @param image
     */
    right:function (image) {
        var s= image.style;
        s.width = String(this.width) + 'px';
        s.height = String(this.height) + 'px';
        s.position = 'absolute';
        s.top = '0px';
        s.left = '0px';
    }
};
