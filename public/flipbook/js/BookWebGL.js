var FLIPBOOK = FLIPBOOK || {};

/**
 *
 * @param el  container for the book
 * @param options object containing all options for the book
 * @constructor
 */
 
FLIPBOOK.BookWebGL = function (el, options) {
	this.elementId = $(options.main.elem).attr("id")
    this.wrapper = typeof el == 'object' ? el : document.getElementById(el);
    this.options = options;
    this.pageW = options.pageWidth;
    this.pageH = options.pageHeight;
    this.onTurnPageComplete = null;
    this.scroll = options.scroll;
    this.pagesArr = options.pagesArr;
    this.pages = [];
    this.animating = false;
    this.rightIndex = 0;
    this.sc = 1;

    var s = this.wrapper.style;

    s.width = '100%';
    s.height = '100%';
    s.position = 'absolute';
    s.overflow = 'hidden';

    this.init3d();
    this.createPages();
    this.rendering = false;
	this.enable();
	this.disable();
    this.onResize();

};

FLIPBOOK.BookWebGL.prototype=new THREE.Object3D();

FLIPBOOK.BookWebGL.prototype.constructor=FLIPBOOK.BookWebGL;

FLIPBOOK.BookWebGL.prototype.init3d = function(){
    // WebGL starts here
    var self = this,
        VIEW_ANGLE = 30,
        w = jQuery(self.wrapper).width(),
        h = jQuery(self.wrapper).height(),
        ASPECT = w/h,
        NEAR = 1,
        FAR = 10000,
        o = this.options;

    self.clock = new THREE.Clock();

    //scene
    self.scene = new THREE.Scene();
    self.camera = new THREE.PerspectiveCamera( VIEW_ANGLE, ASPECT, NEAR, FAR);
    self.scene.add(self.camera);
    self.zoom = o.zoom;
    self.pan = o.pan;
    self.tilt = o.tilt;

    this.updateCameraPosition();
	
	// this.stats = new Stats();
	// this.wrapper.appendChild( this.stats.domElement );

    //renderer
    this.canvas = document.createElement('canvas');

    var s = this.canvas.style;
    s.width = '100%';
    s.height = '100%';
    s.position = 'absolute';

    this._bind('DOMMouseScroll',this.canvas);
    this._bind('mousewheel',this.canvas);
    this._bind('mouseout',this.canvas);
    this._bind(this.options.parent.START_EV, this.canvas);
    this._bind(this.options.parent.MOVE_EV, this.canvas);
    this._bind(this.options.parent.END_EV, this.canvas);
    this._bind(this.options.parent.CANCEL_EV, this.canvas);

    //antialias : true makes no difference
	
	if(self.options.renderer == "webgl"){
		self.renderer = new THREE.WebGLRenderer({alpha:true, antialias: true, canvas:this.canvas});
		self.renderer.setClearColor(0x00ffffff, 0);
		self.renderer.setClearColor( 0x000000, 0 ); 
	}else if(self.options.renderer == "canvas"){
		self.renderer = new THREE.CanvasRenderer({antialias: true,canvas:this.canvas});
	}else if(self.options.renderer == "css3d"){
		// self.renderer = new THREE.CSS3DRenderer();
		// self.renderer = new THREE.SoftwareRenderer();
	}
    self.renderer.setSize( w, h );

    if(o.pageShadow){
        // self.renderer.shadowMapEnabled = true;
//        renderer.sortObjects = true;
        // self.renderer.shadowMapWidth = 1024;
        // self.renderer.shadowMapHeight = 1024;
    }

    // bind the resize event
    jQuery(window).resize(function () {
        self.onResize();
    });

    // point light
    if(o.pointLight == true){
        var pl= new THREE.PointLight(o.pointLightColor);
        pl.position.set(o.pointLightX,o.pointLightY,o.pointLightZ);
        pl.intensity = o.pointLightIntensity;
        self.scene.add(pl);
    }

    // directional light
    if(o.directionalLight == true){
        var dl	= new THREE.DirectionalLight( o.directionalLightColor );
        dl.position.set(o.directionalLightX,o.directionalLightY,o.directionalLightZ);
        dl.intensity = o.directionalLightIntensity;
        self.scene.add(dl);
    }

    // ambient light
    if(o.ambientLight == true){
        var al = new THREE.AmbientLight(o.ambientLightColor);
        al.intensity = o.ambientLightIntensity;
        self.scene.add(al);
    }

    // spotlight
    if(o.spotLight){
        var sl	= new THREE.SpotLight( o.spotLightColor);
        sl.position.z = o.spotLightZ;
        sl.intensity = o.spotLightIntensity;
        // sl.shadowMapWidth = 1024;
        // sl.shadowMapHeight = 1024;
        // sl.shadowCameraNear= o.spotLightShadowCameraNear;
        // sl.shadowCameraFar = o.spotLightShadowCameraFar;
        // sl.castShadow = o.spotLightCastShadow;
        // sl.shadowDarkness = o.spotLightShadowDarkness;
        self.scene.add( sl );
    }

    self.scene.add(this);

    this.position.set(o.bookX, o.bookY, o.bookZ);

    this.centerContainer=new THREE.Object3D();
    this.add(this.centerContainer);

    // align flipBook center container
    this.centerContainer.position.x=-this.pageW*0.5;
	if(this.options.rightToLeft){
		this.centerContainer.position.x=this.pageW*0.5;
	}

    this.flippedleft=0;
    this.flippedright=0;

    this.cameraZMin = 300;
    this.cameraZMax = 5000;
};

FLIPBOOK.BookWebGL.prototype.onResize = function(){
    var w = jQuery(this.wrapper).width(),
        h = jQuery(this.wrapper).height();
    if(h>w){
        this.sc = w/h;
    }else{
        this.sc = 1;
    }
//    this.zoomTo();
//    this.updateCameraPosition();

    // notify the renderer of the size change
    this.renderer.setSize( w, h);
    // update the camera
    this.camera.aspect	= w/h;
    this.camera.updateProjectionMatrix();

    this.updateCameraPosition();
};

FLIPBOOK.BookWebGL.prototype.updateCameraPosition = function(){
    //tilt
    var angle = Math.PI * this.tilt / 180;
    var cameraX = 0;
    var cameraY = this.options.cameraDistance*Math.sin(angle) / (this.zoom);
    var cameraZ = this.options.cameraDistance*Math.cos(angle) / (this.zoom )

    this.scale.set(this.sc,this.sc,this.sc);
	
    //pan
    angle = Math.PI * this.pan / 180;
    cameraX = Math.sin(angle) * cameraZ;
    cameraZ = Math.cos(angle) * cameraZ;

    this.camera.position.set(Math.round(cameraX),Math.round(cameraY),Math.round(cameraZ));
    this.camera.lookAt(this.scene.position);
};

FLIPBOOK.BookWebGL.prototype.createPages = function(){
    //create all pages
    for (var i=0;i<this.pagesArr.length/2;i++)
    {
        var texturefront = this.pagesArr[2*i].src;
        var textureback = (2*i+1 >= this.pagesArr.length) ? "" : this.pagesArr[2*i + 1].src;
        var hardness = (i == 0 || i == (this.pagesArr.length/2-1))? this.options.coverHardness : this.options.pageHardness;
		var page = new FLIPBOOK.PageWebGL(this,i,texturefront,textureback,hardness,this.options);
		// page.castShadow = true;
		// page.receiveShadow = true;
		this.pages.push(page);
		this.centerContainer.add(page);
        this.flippedright++;
    }
	this.pages[0].load();
	// this.pages[1].load();
	
	
	
	//custom
	/*
	var rendererCSS	= new THREE.CSS3DRenderer();
	rendererCSS.setSize( window.innerWidth, window.innerHeight );
	rendererCSS.domElement.style.position	= 'absolute';
	rendererCSS.domElement.style.top	= 0;
	rendererCSS.domElement.style.margin	= 0;
	rendererCSS.domElement.style.padding	= 0;
	document.body.appendChild( rendererCSS.domElement );

	THREEx.WindowResize.bind(rendererCSS, world.camera().get(0));		

	// put the mainRenderer on top
	var rendererMain	= world.tRenderer();
	rendererMain.domElement.style.position	= 'absolute';
	rendererMain.domElement.style.top	= 0;
	rendererMain.domElement.style.zIndex	= 1;
	rendererCSS.domElement.appendChild( rendererMain.domElement );

	// var element	= document.createElement('iframe')
	// element.src	= 'http://learningthreejs.com'
	// element.style.width = '1024px';
	// element.style.height = '1024px';

	var element = document.createElement( 'div' );
	element.style.width = '100px';
	element.style.height = '100px';
	element.style.background = new THREE.Color( Math.random() * 0xffffff ).getStyle();

	var sceneCSS	= new THREE.Scene();
	var objectCSS 	= new THREE.CSS3DObject( element );
	window.objectCSS	= objectCSS
	objectCSS.scale.multiplyScalar(1/63.5)
	sceneCSS.add( objectCSS );
	
	*/
	
	
	
};

FLIPBOOK.BookWebGL.prototype.getNumPages=function(){
    return(this.pages.length);
};

FLIPBOOK.BookWebGL.prototype.centerContainer=function(){
    return(this.centerContainer);
};

FLIPBOOK.BookWebGL.prototype.goToPage=function(index,instant){ //index in book.pages, not page number

    this.goingToPage = index;

    index % 2 != 0 ? index++ : index;

    var self = this;

	var delay = this.options.pageFlipDuration*1000/8;
	
	if(typeof(instant) != 'undefined' && instant){
		delay = 0;
		for(var i=0;i<self.pages.length;i++	){
			self.pages[i].duration = 0;
		}
	}

    if(this.rightIndex > index){
	
        
        if(this.rightIndex -2 > index){
			this.prevPage(false);
			if(delay > 0 )
				setTimeout(function(){self.goToPage(index,instant)}, delay);
			else	
				self.goToPage(index,instant);
        }else{
			this.prevPage();
			setTimeout(function(){
				if(typeof(instant) != 'undefined' && instant){
					for(var i=0;i<self.pages.length;i++	){
						self.pages[i].duration = self.options.pageFlipDuration;
					}
				}
			}, delay);
		}
    }else if(this.rightIndex < index){
        
        if((this.rightIndex + 2 ) < index){
			this.nextPage(false);
            if(delay > 0 )
				setTimeout(function(){self.goToPage(index,instant)}, delay);
			else	
				self.goToPage(index,instant);
        }else{
			this.nextPage();
			setTimeout(function(){
				if(typeof(instant) != 'undefined' && instant){
					for(var i=0;i<self.pages.length;i++	){
						self.pages[i].duration = self.options.pageFlipDuration;
					}
				}
			}, delay);
		}
    }
};

FLIPBOOK.BookWebGL.prototype.nextPage=function(load){
    if(this.flippedright == 0)
        return;
//    if flipping in opposite direction already - return
    var i;
    for(i = 0; i <this.pages.length; i++){
        if(this.pages[i].flippingRight)
            return;
    }

    var page = this.pages[this.pages.length-this.flippedright];
	
	var rightPage = this.pages[this.flippedleft+1];
	var leftPage = this.pages[this.flippedleft];
	if(typeof(load) == 'undefined' || load ){	
		if(rightPage)
			rightPage.load();
		if(leftPage)
			leftPage.load();
	}	
    if(!page.flipping){
		page.flipLeft();
    }
	this.flippedleft++;

    this.flippedright--;
    this.rightIndex += 2;

    this.options.parent.updateCurrentPage();
};

FLIPBOOK.BookWebGL.prototype.prevPage=function(load){
    if(this.flippedleft == 0)
        return;

    var i;
    for(i = 0; i <this.pages.length; i++){
        if(this.pages[i].flippingLeft)
            return;
    }

    var page = this.pages[this.flippedleft-1];
	
	var rightPage = this.pages[this.flippedleft-1];
	var leftPage = this.pages[this.flippedleft-2];
	if(typeof(load) == 'undefined' || load ){	
		if(rightPage)
			rightPage.load();
		if(leftPage)
			leftPage.load();
	}	
	
	
    if(!page.flipping)
        page.flipRight();
    this.flippedleft--;
    this.flippedright++;
    this.rightIndex -= 2;

    this.options.parent.updateCurrentPage();
};

FLIPBOOK.BookWebGL.prototype.firstPage=function(){

};

FLIPBOOK.BookWebGL.prototype.flipFinnished=function(){
	// this.pages[this.flippedleft].load();
	// this.pages[this.flippedleft+1].load();
	// console.log("flip finnished");
	// this.pages[1].load();
};

FLIPBOOK.BookWebGL.prototype.lastPage=function(){

};

FLIPBOOK.BookWebGL.prototype.updateVisiblePages =function(){

};

FLIPBOOK.BookWebGL.prototype.render =  function(rendering) {
    var self = this;
    self.rendering = rendering;
    rendering ? self.wrapper.appendChild(self.renderer.domElement) : self.wrapper.removeChild(self.renderer.domElement);
    var animate = function(){
        if(self.rendering){
            
			if(!self.enabled) 
				return;
			requestAnimationFrame(animate);
            TWEEN.update();
            self.renderer.render(self.scene, self.camera);
			// if(self.stats)
				// self.stats.update();
			// console.log("rendering..."+self.elementId)
        }
    };

    animate();
};

FLIPBOOK.BookWebGL.prototype.zoomFor =  function(amount,time) {
    if(this.zooming)
        return;
	if(typeof(time) === 'undefined')
		time = 200;
    var self = this, factor = 1.2;
    var newZoom = amount > 0 ? this.zoom * factor : this.zoom / factor;
    newZoom = newZoom > this.options.zoomMax ? this.options.zoomMax : newZoom;
    newZoom = newZoom < this.options.zoomMin ? this.options.zoomMin : newZoom;
    this.zooming = true;
    new TWEEN.Tween(this).to({zoom:newZoom}, time)
        .easing( TWEEN.Easing.Sinusoidal.EaseInOut)
        .onUpdate(this.updateCameraPosition)
        .onComplete(function(){self.zooming = false})
        .start();
};

FLIPBOOK.BookWebGL.prototype.zoomTo =  function(amount,time) {
    if(this.zooming)
        return;
	if(typeof(time) === 'undefined')
		time = 200;
	var self = this;
    newZoom = amount > this.options.zoomMax ? this.options.zoomMax : amount;
    newZoom = amount < this.options.zoomMin ? this.options.zoomMin : amount;
    this.zooming = true;
    new TWEEN.Tween(this).to({zoom:newZoom}, time)
        .easing( TWEEN.Easing.Sinusoidal.EaseInOut)
        .onUpdate(this.updateCameraPosition)
        .onComplete(function(){self.zooming = false})
        .start();
};

FLIPBOOK.BookWebGL.prototype.tiltTo =  function(amount) {
//    if(this.tilting)
//        return;
    var self = this, factor = .3;
    var newTilt = this.tilt + amount*factor;
    newTilt = newTilt > this.options.tiltMax ? this.options.tiltMax : newTilt;
    newTilt = newTilt < this.options.tiltMin ? this.options.tiltMin : newTilt;

    this.tilt = newTilt;
    this.updateCameraPosition();

//    this.tilting = true;
//    new TWEEN.Tween(this).to({tilt:newTilt}, 400)
//        .easing( TWEEN.Easing.Sinusoidal.EaseInOut)
//        .onUpdate(this.updateCameraPosition)
//        .onComplete(function(){self.tilting = false})
//        .start();
};

FLIPBOOK.BookWebGL.prototype.panTo =  function(amount) {
//    if(this.tilting)
//        return;
    var self = this, factor = .2;
    var newPan = this.pan - amount*factor;
    newPan = newPan > this.options.panMax ? this.options.panMax : newPan;
    newPan = newPan < this.options.panMin ? this.options.panMin  : newPan;

    this.pan = newPan;
    this.updateCameraPosition();
};



FLIPBOOK.BookWebGL.prototype._bind = function (type, el, bubble) {
    (el || this.wrapper).addEventListener(type, this, !!bubble);
};

FLIPBOOK.BookWebGL.prototype.handleEvent=function (e) {
    var self = this;
//console.log(e);
    switch (e.type) {
        case self.options.parent.START_EV:
            if (!self.options.parent.hasTouch && e.button !== 0) return;
            self._start(e);
            break;
        case self.options.parent.MOVE_EV:
            self._move(e);
            break;
        case 'mouseout':
            self._end(e);
            break;
        case self.options.parent.END_EV:
        case self.options.parent.CANCEL_EV:
            self._end(e);
            break;
        case 'DOMMouseScroll':
        case 'mousewheel':
            self._wheel(e);
            break;
    }
};

FLIPBOOK.BookWebGL.prototype._wheel=function (e) {
    e.preventDefault();
    var wheelDeltaX, wheelDeltaY;

    if ('wheelDeltaX' in e) {
        wheelDeltaX = e.wheelDeltaX / 12;
        wheelDeltaY = e.wheelDeltaY / 12;
    } else if ('wheelDelta' in e) {
        wheelDeltaX = wheelDeltaY = e.wheelDelta / 12;
    } else if ('detail' in e) {
        wheelDeltaX = wheelDeltaY = -e.detail * 3;
    } else {
        return;
    }

    this.zoomFor(wheelDeltaY);

    if(this.zoom <= 1){
        this.resetCameraPosition();
    }

};
FLIPBOOK.BookWebGL.prototype.resetCameraPosition=function () {
    this.position.x = this.options.bookX;
    this.position.y = this.options.bookY;
    this.position.z = this.options.bookZ;
};

FLIPBOOK.BookWebGL.prototype._start=function (e) {

    this.mouseDown = true;

    var point = this.options.parent.hasTouch ? e.touches[0] : e;
    this.pointX = point.pageX ;
    this.pointY = point.pageY ;
	
    this.startPoint = point;

    var vector = this._getVector(e);
    var projector = new THREE.Projector();

    projector.unprojectVector( vector, this.camera );

    var raycaster = new THREE.Raycaster( this.camera.position, vector.sub( this.camera.position ).normalize() );

    var intersects = raycaster.intersectObjects( this.pages );

    this.pageMouseDown = (intersects.length > 0);
};
FLIPBOOK.BookWebGL.prototype._getVector=function (e) {

    var w = jQuery(this.canvas).width(),
        h = jQuery(this.canvas).height(),
        // x = e.clientX - jQuery(this.canvas).offset().left,
        x = e.pageX - jQuery(this.canvas).offset().left,
        // y = e.clientY - jQuery(this.canvas).offset().top,
        y = e.pageY - jQuery(this.canvas).offset().top,
        cx = jQuery(this.canvas).offset().x,
        cy = jQuery(this.canvas).offset().y
        ;
    return new THREE.Vector3( ( x / w ) * 2 - 1, - ( y / h ) * 2 + 1, 0.5 );

};

FLIPBOOK.BookWebGL.prototype._move=function (e) {

//    console.log(this.mouseDown);
//
    e.preventDefault();
    var vector = this._getVector(e);

    var projector = new THREE.Projector();

    projector.unprojectVector( vector, this.camera );

    var raycaster = new THREE.Raycaster( this.camera.position, vector.sub( this.camera.position ).normalize() );

    var intersects = raycaster.intersectObjects( this.pages );

    if(intersects.length > 0){
        this.wrapper.style.cursor = 'pointer';
    }else{
        this.wrapper.style.cursor = 'move';
    }

    var point = this.options.parent.hasTouch ? e.touches[0] : e,
        deltaX = (point.pageX - this.pointX)*.5,
        deltaY = (point.pageY - this.pointY)*.5;
		
    this.pointX = point.pageX ;
    this.pointY = point.pageY ;

    if(!this.mouseDown){
		this.onMouseMove = "";
        return;
    }
	
	if(intersects.length > 0){
		if(this.onMouseMove == "")
			this.onMouseMove = "scroll";
	}else{
		if(this.onMouseMove == "")
			this.onMouseMove = "rotate";
	}
	
	if(this.onMouseMove == "scroll"){
		this.position.x += (4* deltaX / this.zoom);
        this.position.y -= (4* deltaY / this.zoom);
	}else if (this.onMouseMove == "rotate"){
		this.tiltTo(deltaY);
        this.panTo(deltaX);
	}
};

FLIPBOOK.BookWebGL.prototype._end=function (e) {
    this.mouseDown = false;
//    this.startPoint = null;
    var point = this.options.parent.hasTouch ? e.touches[0] : e;
    this.pointX = point.pageX;
    this.pointY = point.pageY;
	
    this.endPoint = point;

    var vector = this._getVector(e);

    var projector = new THREE.Projector();

    projector.unprojectVector( vector, this.camera );
	
    var raycaster = new THREE.Raycaster( this.camera.position, vector.sub( this.camera.position ).normalize() );

    var intersects = raycaster.intersectObjects( this.pages );

    if(intersects.length > 0){
        if(this.pageMouseDown &&
            Math.abs(this.startPoint.pageX - this.endPoint.pageX) < 5 &&
            Math.abs(this.startPoint.pageY - this.endPoint.pageY) < 5 ){
            var intersect = intersects[0];
            var page = intersect.object;
            if(page.flipping)
                return;
            if(page.isFlippedLeft)
                this.prevPage();
            else
                this.nextPage();
        }
    }
    this.pageMouseDown = false;
};
FLIPBOOK.BookWebGL.prototype.moveCamera=function (deltaX, deltaY) {

};

FLIPBOOK.BookWebGL.prototype.enable=function(){
	this.enabled = true;
	this.render(true);
	this.onResize();
};
FLIPBOOK.BookWebGL.prototype.disable=function(){
	this.enabled = false;
};
