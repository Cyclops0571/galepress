var FLIPBOOK = FLIPBOOK || {};

FLIPBOOK.PageWebGL=function(book,i,matf,matb,hard,options)
{
    this.book=book;
	this.preloader = THREE.ImageUtils.loadTexture(options.assets.preloader);
    this.frontTexture=matf;
    this.backTexture=matb;
    this.index=i;
    this.materialType = options.pageMaterial;
    this.pW = options.pageWidth;
    this.pH = options.pageHeight;
    this.pageShininess = options.pageShininess;
    this.nfacesw = options.pageSegmentsW;
    this.nfacesh = options.pageSegmentsH;
    this.mats=[];
    this.pageHardness=hard;
//	this.pageThickness=1 + hard/10;
    this.pageThickness= hard;
//    this.pageThickness= 20;
    this.duration = options.pageFlipDuration;
    this.angle=.25*Math.PI*this.pW/this.pH;
    this.force=10;
    this.offset=0;
    this.to=null;
    this.flipPt=0.3;
    this.mod=null;
    this.bend=null;
    this.pivot=null;
    this.isFlippedLeft=false;
    this.isFlippedRight=true;
    this.flippingLeft=false;
    this.flippingRight=false;
    this.zz=2;
    this.sides={bottom:3,top:2,	right:0,left:1,	front:4,back:5};
	this.overdraw = 1;
    // add page flip interaction TO DO..

    var map;
    for (var mii=0;mii<6;mii++)
    {
        // add front - back page images
        if (mii==this.sides.front){
            // this.mats[this.sides.front] = this.createMaterial(this.materialType, this.frontTexture);
            this.mats[this.sides.front] = this.createEmptyMaterial(this.materialType);
        }
        else if (mii==this.sides.back){
            // this.mats[this.sides.back] = this.createMaterial(this.materialType, this.backTexture);
            this.mats[this.sides.back] = this.createEmptyMaterial(this.materialType);
        }
        else{
            //random gray
            var r = parseInt(Math.random()*5);
            var a = [0x777777, 0x999999, 0xaaaaaa, 0xdddddd, 0xffffff];
            var c = a[r];
            this.mats[mii]=new THREE.MeshBasicMaterial( { color: c } );
        }
    }
	
	//test
	// if(this.index == 0){
	// this.nfacesw = this.nfacesh = 50;
	// }else{
	// this.nfacesw = this.nfacesh = 1;
	// }
	
	
    // call super
    THREE.Mesh.call(this, new THREE.CubeGeometry( this.pW, this.pH, 1, this.nfacesw, this.nfacesh, 1 ), new THREE.MeshFaceMaterial(this.mats));
    this.overdraw=true;

    //TODO bug with shadows - if this.castShadow = true; the pages have shadows always
   this.castShadow = true;
   this.receiveShadow = true;
    this.position.x=this.pW*0.5;
//	this.position.z=-this.zz*this.index;
    if(this.index > 0 )
        this.position.z = this.book.pages[this.index-1].position.z - this.book.pages[this.index-1].pageThickness/2 - this.pageThickness/2 - 1;
    else
        this.position.z = this.pageThickness/2;
    // flip modifiers
    this.mod = new MOD3.ModifierStack( new MOD3.LibraryThree(), this );
    this.pivot = new MOD3.Pivot(this.position.x, 0, 0);
    this.mod.addModifier(this.pivot);
    this.mod.collapse();
	
    this.bend = new MOD3.Bend(0,0,0);
    this.bend.constraint = MOD3.ModConstant.LEFT;
    if (this.pH>this.pW)
        this.bend.switchAxes=true;
    this.mod.addModifier( this.bend );
	/*
	this.bend2 = new MOD3.Bend(0,0,0);
    this.bend2.constraint = MOD3.ModConstant.LEFT;
    if (this.pH>this.pW)
        this.bend2.switchAxes=true;
    this.mod.addModifier( this.bend2 );
	this.bend2.force = .1;
	this.bend2.offset = .3;
	this.mod.apply();*/
};


//FLIPBOOK.PageWebGL.prototype= Object.create( THREE.Mesh.prototype );
FLIPBOOK.PageWebGL.prototype=new THREE.Mesh();

FLIPBOOK.PageWebGL.prototype.constructor=FLIPBOOK.PageWebGL;

//loads the page bitmap
FLIPBOOK.PageWebGL.prototype.load = function(){
	if(this.loaded)
		return;
	var texture;
	for (var i=0;i<6;i++)
    {
        if (i==this.sides.front){
			texture = THREE.ImageUtils.loadTexture(this.frontTexture);
            this.mats[this.sides.front] = this.createMaterial(this.materialType, texture);
        }
        else if (i==this.sides.back){
			texture = THREE.ImageUtils.loadTexture(this.backTexture);
            this.mats[this.sides.back] = this.createMaterial(this.materialType, texture);
        }
    }
	this.material = new THREE.MeshFaceMaterial(this.mats);
	this.loaded = true;
};

FLIPBOOK.PageWebGL.prototype.createEmptyMaterial = function(type){
    var mat;
    if(type == 'lambert'){
        mat = new THREE.MeshLambertMaterial( {
			map: this.preloader,
            overdraw: this.overdraw,
            ambient: 0xdddddd,
            specular: 0xffffff,
            diffuse:0xffffff,
            shininess: 20,
            perPixel: true //???
        } );
    }
    else if(type == 'phong'){
        mat = new THREE.MeshPhongMaterial( {
			map: this.preloader,
            overdraw: this.overdraw,
            ambient: 0xdddddd,
            specular: 0xffffff,
            diffuse:0xffffff,
            shininess: 20,
            perPixel: true //???
        } );
    }
    else if(type == 'basic'){
        mat = new THREE.MeshBasicMaterial( {
			map: this.preloader,
            overdraw: this.overdraw,
            perPixel: true //???
        } );
    }
    return mat;
};

FLIPBOOK.PageWebGL.prototype.createMaterial = function(type, map){
    var mat;

    if(type == 'lambert'){
        mat = new THREE.MeshLambertMaterial( {
            map: map,
            overdraw: this.overdraw,
            ambient: 0xdddddd,
            specular: 0xffffff,
            diffuse:0xffffff,
            shininess: 20,
            perPixel: true //???
        } );
    }
    else if(type == 'phong'){
        mat = new THREE.MeshPhongMaterial( {
            map: map,
            overdraw: this.overdraw,
            ambient: 0xdddddd,
            specular: 0xffffff,
            diffuse:0xffffff,
            shininess: 20,
            perPixel: true //???
        } );
		
		// mat = new THREE.MeshBasicMaterial( { color: 0x00ee00, wireframe: true, transparent: true } ); 
    }
    else if(type == 'basic'){
        mat = new THREE.MeshBasicMaterial( {
            map: map,
            overdraw: this.overdraw,
            perPixel: true //???
        } );
    }
    return mat;
};

FLIPBOOK.PageWebGL.prototype.flipLeft=function(pt)
{
    if (!this.isFlippedLeft && !this.flippingLeft && !this.flippingRight && this.index==this.book.flippedleft)
    {
		if(this.duration > 0){
			this.flippingLeft=true;
			this.flipping=true;
			this.force = 0;
			var newForce = (1 + Math.random()) / (this.pageHardness);
			var newOffset = .1 + Math.random()* .2;
			this.to={angle:this.rotation.y, t:-1,xx:0, thiss:this, force:this.force, offset:this.offset};
			this.bendIn(-Math.PI,newForce, newOffset);
		}else{
			this.rotation.y = -Math.PI;
			this.flippingLeft=false;
			this.isFlippedLeft=true;
			this.flippingRight=false;
			this.isFlippedRight=false;
		}
	
        //correct z order
        this.position.z=this.pageThickness/2 +1;
        //left side
        for (var i= this.index-1; i >= 0; i--)
        {
            this.book.pages[i].position.z = this.book.pages[i+1].position.z - this.book.pages[i+1].pageThickness/2 - this.book.pages[i].pageThickness/2 - 1;
        }
        //right side
        for (var i= this.index+1; i < this.book.pages.length; i++)
        {
            this.book.pages[i].position.z = this.book.pages[i-1].position.z - this.book.pages[i-1].pageThickness/2 - this.book.pages[i].pageThickness/2 - 1;
        }
    }
};
FLIPBOOK.PageWebGL.prototype.flipRight=function(pt)
{
    if (!this.isFlippedRight && !this.flippingRight && !this.flippingLeft && this.index==this.book.getNumPages()-this.book.flippedright-1)
    {
        
		if(this.duration > 0){
			this.flippingRight=true;
			this.flipping=true;
			this.force = 0;
			this.to={angle:this.rotation.y, t:-1,xx:0, thiss:this, force:this.force, offset:this.offset};
			var newForce = (-1 - Math.random() *.5) /this.pageHardness;
			var newOffset = .1 + Math.random()* .2;
			this.bendIn(0,newForce, newOffset);
		}else{
			this.rotation.y = 0;
			this.flippingLeft=false;
			this.isFlippedLeft=false;
			this.flippingRight=false;
			this.isFlippedRight=true;
		}
        
//
        //correct z order
        this.position.z=this.pageThickness/2 +1;

        //right side
        for (var i= this.index+1; i < this.book.pages.length; i++)
        {
            this.book.pages[i].position.z = this.book.pages[i-1].position.z - this.book.pages[i-1].pageThickness/2 - this.book.pages[i].pageThickness/2 - 1;
        }
        //left side
        for (var i= this.index-1; i >= 0; i--)
        {
            this.book.pages[i].position.z = this.book.pages[i+1].position.z - this.book.pages[i+1].pageThickness/2 - this.book.pages[i].pageThickness/2 - 1;
        }

    }
};
FLIPBOOK.PageWebGL.prototype.bendIn=function(angle,newForce,newOffset)
{
    //random bend angle
//    this.bend.setAngle(Math.random() * .25 - .5);
    this.bend.setAngle(Math.random() * (Math.PI / 6) - (Math.PI / 12));
    this.bend.force=0.0;
    this.bend.offset=0.0;
    this.mod.apply();

    var time1 = this.duration*(400+ this.pageHardness*5);
    var time2 = this.duration*(225+ this.pageHardness*5);

    //tween page rotation Y
    new TWEEN.Tween(this.to).to({angle:angle, xx:1, t:1}, time1)
        .easing( TWEEN.Easing.Sinusoidal.EaseInOut )
        .onUpdate(this.renderFlip)
        .start();
    //tween bend.force
    new TWEEN.Tween(this.to).to({force:newForce}, time2)
        .easing( TWEEN.Easing.Quadratic.EaseIn)
        .onUpdate(this.modApply)
        .onComplete(this.bendOut)
        .start();
    //tween bend.offset
    new TWEEN.Tween(this.to).to({offset:newOffset}, time2)
        .easing( TWEEN.Easing.Quadratic.EaseOut)
        .onUpdate(this.modApply)
        .start();
};

//FlipBook3D.Page.prototype.bendOpposite=function()
//{
//    new TWEEN.Tween(this.thiss.to).to({force:-this.thiss.bend.force*3}, this.thiss.duration*350 / this.thiss.pageHardness)
//        .easing( TWEEN.Easing.Sinusoidal.EaseOut)
//        .onUpdate(this.thiss.modApply)
//        .onComplete(this.thiss.bendOut)
//        .start();
//};

FLIPBOOK.PageWebGL.prototype.bendOut=function()
{
    //tween bend.force to 0
    var time = this.thiss.duration*(700 - this.thiss.pageHardness*75);

    new TWEEN.Tween(this.thiss.to).to({force:0}, time)
        .easing( TWEEN.Easing.Sinusoidal.EaseIn)
        .onUpdate(this.thiss.modApply)
        .start();

    //tween bend.offset to 1
    new TWEEN.Tween(this.thiss.to).to({force:0, offset:1}, time)
        .easing( TWEEN.Easing.Sinusoidal.EaseInOut)
        .onUpdate(this.thiss.modApply)
        .onComplete(this.thiss.flipFinished)
        .start();
};
FLIPBOOK.PageWebGL.prototype.modApply=function()
{
    this.thiss.bend.force = this.force;
    this.thiss.bend.offset = this.offset;
//    this.thiss.bend.setAngle((2*this.thiss.flipPt-1)*this.thiss.angle);
    this.thiss.mod.apply();

	return;
	
	
    // this.thiss.geometry.computeCentroids();
    // this.thiss.geometry.computeFaceNormals();
   // this.thiss.geometry.computeVertexNormals();
   // this.thiss.geometry.mergeVertices();
   // THREE.GeometryUtils.triangulateQuads( this.thiss.geometry );

return;

    var g = this.thiss.geometry;

    computeVertexNormals(this.thiss.nfacesw, this.thiss.nfacesh,1,g);
    function computeVertexNormals (w,h,d,g)
    {

        var v, vl, f, fl, face, vertices;

        // create internal buffers for reuse when calling this method repeatedly
        // (otherwise memory allocation / deallocation every frame is big resource hog)

        if ( this.__tmpVertices === undefined ) {

            this.__tmpVertices = new Array( g.vertices.length );
            vertices = this.__tmpVertices;

            for ( v = 0, vl = g.vertices.length; v < vl; v ++ ) {

                vertices[ v ] = new THREE.Vector3();

            }

            for ( f = 0, fl = g.faces.length; f < fl; f ++ ) {

                face = g.faces[ f ];


                face.vertexNormals = [ new THREE.Vector3(), new THREE.Vector3(), new THREE.Vector3(), new THREE.Vector3() ];


            }

        } else {

            vertices = this.__tmpVertices;

            for ( v = 0, vl = g.vertices.length; v < vl; v ++ ) {

                vertices[ v ].set( 0, 0, 0 );

            }

        }
        //do not add face normals from edge faces
        var edgeFacesCount = 2*w*d + 2*h*d;

        for ( f = edgeFacesCount, fl = g.faces.length; f < fl; f ++ ) {

            face = g.faces[ f ];

            if ( face instanceof THREE.Face3 ) {

                vertices[ face.a ].add( face.normal );
                vertices[ face.b ].add( face.normal );
                vertices[ face.c ].add( face.normal );

            } else if ( face instanceof THREE.Face4 ) {

                vertices[ face.a ].add( face.normal );
                vertices[ face.b ].add( face.normal );
                vertices[ face.c ].add( face.normal );
                vertices[ face.d ].add( face.normal );

            }

        }

        for ( v = 0, vl = g.vertices.length; v < vl; v ++ ) {

            vertices[ v ].normalize();

        }

        for ( f = 0, fl = g.faces.length; f < fl; f ++ ) {

            face = g.faces[ f ];

            if ( face instanceof THREE.Face3 ) {

                face.vertexNormals[ 0 ].copy( vertices[ face.a ] );
                face.vertexNormals[ 1 ].copy( vertices[ face.b ] );
                face.vertexNormals[ 2 ].copy( vertices[ face.c ] );

            } else if ( face instanceof THREE.Face4 ) {

                face.vertexNormals[ 0 ].copy( vertices[ face.a ] );
                face.vertexNormals[ 1 ].copy( vertices[ face.b ] );
                face.vertexNormals[ 2 ].copy( vertices[ face.c ] );
                face.vertexNormals[ 3 ].copy( vertices[ face.d ] );

            }

        }

    }

};

FLIPBOOK.PageWebGL.prototype.renderFlip=function()
{
    var p2=Math.PI*0.5;
    // align flipBook to center
    if (this.thiss.flippingLeft && this.thiss.index==0 && this.thiss.book.getNumPages()>1)
        this.thiss.book.centerContainer.position.x=(1-this.xx)*this.thiss.book.centerContainer.position.x;
    else if (this.thiss.flippingLeft && this.thiss.index==this.thiss.book.getNumPages()-1)
        this.thiss.book.centerContainer.position.x=(1-this.xx)*this.thiss.book.centerContainer.position.x+this.xx*this.thiss.book.pageW*0.5;
    else if (this.thiss.flippingRight && this.thiss.index==0)
        this.thiss.book.centerContainer.position.x=(1-this.xx)*this.thiss.book.centerContainer.position.x-this.xx*this.thiss.book.pageW*0.5;
    else if (this.thiss.flippingRight && this.thiss.index==this.thiss.book.getNumPages()-1)
        this.thiss.book.centerContainer.position.x=(1-this.xx)*this.thiss.book.centerContainer.position.x;

    //apply new angle
    this.thiss.rotation.y = this.angle;
};
FLIPBOOK.PageWebGL.prototype.flipFinished=function()
{
    if (this.thiss.flippingLeft)
    {
        this.thiss.flippingLeft=false;
        this.thiss.isFlippedLeft=true;
        this.thiss.flippingRight=false;
        this.thiss.isFlippedRight=false;

    }
    else if (this.thiss.flippingRight)
    {
        this.thiss.flippingLeft=false;
        this.thiss.isFlippedRight=true;
        this.thiss.flippingRight=false;
        this.thiss.isFlippedLeft=false;
    }
    this.thiss.bend.force=0.0;
//    this.thiss.bend.setAngle(0.0);
    this.thiss.bend.offset=0.0;
    this.thiss.mod.apply();
    this.thiss.flipping = false;
	
//test - change geometry
// this.thiss.geometry = new THREE.CubeGeometry(100,100,100,2,2,2);

	
	this.thiss.book.flipFinnished();
};

FLIPBOOK.PageWebGL.prototype.isFlippedLeft=function()
{
    return this.thiss.isFlippedLeft;
};

FLIPBOOK.PageWebGL.prototype.isFlippedRight=function()
{
    return this.thiss.isFlippedRight;
};