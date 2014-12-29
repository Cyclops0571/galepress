AC.VR=Class.create();AC.VR.SpinIntro=function(i){var p=i.options.fps*i.options.introDuration,q=(typeof i.options.introInitialRow!="undefined")?i.options.introInitialRow:i.options.initialPos[1],l=q-i.options.initialPos[1],n=$A();
for(var o=0;o<p;o++){var m=o/p,r=Math.pow(m-1,4),s=Math.floor(r*i.totalFrames[0]*i.options.introSpins)+i.options.initialPos[0],t=Math.floor(r*l)+i.options.initialPos[1];
if(!n.length||n.last()[0]!=s||n.last()[1]!=t){n.push(i.validatePos([s,t],true))
}}return n};AC.VR.options={imageIndexOffset:1,loaders:3,initialLoad:4,noCache:false,initialPos:[0,0],invert:[false,false],infiniteAxis:[true,false],autoPlay:false,fps:25,grabbable:true,grabRotateDistance:1000,throwable:true,minThrowDuration:0.5,maxThrowDuration:1.5,spinnable:true,minSpinDuration:3,intro:AC.VR.SpinIntro,introSpins:0.5,introDuration:1,mobileTotalFrames:null,allowMobileScroll:null};
Object.extend(AC.VR.prototype,{convertToArray:function(c,d){return(typeof c[0]=="undefined")?[c,d]:c
},initialize:function(g,h,l,k){this.options=Object.extend(Object.clone(AC.VR.options),k);
if(this.options.noCache){this.random=Math.floor(Math.random()*10000000)}this.delegate={};
if(this.mobile=((AC.Detector.isMobile()||AC.Detector.isiPad())?true:false)){this.options.intro=null;
this.options.autoPlay=false;this.options.spinnable=false;this.options.throwable=false;
this.mobileStrings={mousedown:"touchstart",mousemove:"touchmove",mouseup:"touchend"}
}this.container=$(g).addClassName("vrcontainer");this.vr=$(document.createElement("div")).addClassName("vr");
this.container.appendChild(this.vr);this.imagePathParts=h.match(/^([^#]*)(#+)([^#]*)$/);
this.numDigits=this.imagePathParts[2].length;this.totalFrames=this.convertToArray(l,1);
if(this.mobile&&this.options.mobileTotalFrames){var i=this.totalFrames;this.totalFrames=this.convertToArray(this.options.mobileTotalFrames,1);
this.frameMultipliers=[i[0]/this.totalFrames[0],i[1]/this.totalFrames[1]]}else{this.frameMultipliers=[1,1]
}this.options.initialPos=this.convertToArray(this.options.initialPos,0);this.options.invert=this.convertToArray(this.options.invert,false);
this.frames=[];for(var j=0;j<this.totalFrames[0];j++){this.frames[j]=[]}this.playIntervalDuration=1000/this.options.fps;
this.minSpinIntervalDuration=(this.options.minSpinDuration*1000)/this.totalFrames[0];
this.minThrowFrames=Math.floor(this.options.minThrowDuration*this.options.fps);
this.maxThrowFrames=Math.floor(this.options.maxThrowDuration*this.options.fps);
this.currentPos=[0,0];this.playing=false;this.grabbing=false;this.spinning=false;
if(this.options.intro){this.introSequence=this.options.intro(this);this.loader=new AC.VR.LoaderController(this,this.introSequence.slice(0),this.playIntro.bind(this))
}else{this.loadAllFrames();this.gotoPos(this.options.initialPos);this.makeInteractive();
if(this.options.autoPlay){this.play()}}},setDelegate:function(b){if(typeof b==="object"){this.delegate=b
}},getStr:function(b){return this.mobile?this.mobileStrings[b]:b},getEvent:function(b){if(b.touches){if(b.touches.length>1){return false
}if(b.touches.length){b.clientX=b.touches[0].clientX;b.clientY=b.touches[0].clientY
}}return b},playIntro:function(){this.introInterval=setInterval(this.gotoNextIntroFrame.bind(this),this.playIntervalDuration);
this.loadAllFrames()},gotoNextIntroFrame:function(){this.gotoPos(this.introSequence.shift());
if(!this.introSequence.length){clearInterval(this.introInterval);this.makeInteractive()
}},isPosLoaded:function(b){return(typeof this.frames[b[0]]!="undefined"&&typeof this.frames[b[0]][b[1]]!="undefined")
},createLoadPlan:function(j,f){if(!f){return[0]}var h=[];do{for(var g=0;g<j;g+=f){var i=Math.floor(g);
if(h.indexOf(i)==-1){h.push(i)}}if(f==1){return h}if((f/=2)<1){f=1}}while(true)
},loadAllFrames:function(){var h=[],k=Math.floor(this.totalFrames[0]/this.options.initialLoad),m=this.createLoadPlan(this.totalFrames[0],k),l=Math.floor(this.totalFrames[1]/this.options.initialLoad),n=this.createLoadPlan(this.totalFrames[1],l);
for(var j=0;j<n.length;j++){for(var i=0;i<m.length;i++){h.push(this.validatePos([m[i]+this.options.initialPos[0],n[j]+this.options.initialPos[1]],true))
}}this.loader=new AC.VR.LoaderController(this,h);h=null;k=null;m=null;l=null;n=null
},getImageSource:function(g){var f=this.options.invert[0]?(this.totalFrames[0]-1)-g[0]:g[0],h=this.options.invert[1]?(this.totalFrames[1]-1)-g[1]:g[1],e=(Math.floor(h*this.totalFrames[0]*this.frameMultipliers[0]*this.frameMultipliers[1])+Math.floor(f*this.frameMultipliers[0])+this.options.imageIndexOffset)+"";
while(e.length<this.numDigits){e="0"+e}return this.imagePathParts[1]+e+this.imagePathParts[3]+(this.options.noCache?"?"+this.random:"")
},makeInteractive:function(){if(this.options.grabbable){this.bindGrabStart=this.onGrabStart.bind(this);
this.bindGrabChange=this.onGrabChange.bind(this);this.bindGrabEnd=this.onGrabEnd.bind(this);
this.vr.observe(this.getStr("mousedown"),this.bindGrabStart);this.onKeyDown.keys={};
this.bindOnClick=this.onClick.bind(this);this.vr.observe("click",this.bindOnClick);
this.bindOnFocus=this.onFocus.bind(this);this.vr.observe("focus",this.bindOnFocus);
this.bindOnBlur=this.onBlur.bind(this);this.vr.observe("blur",this.bindOnBlur);
this.bindKeyDown=this.onKeyDown.bind(this);this.bindKeyUp=this.onKeyUp.bind(this);
this.vr.tabIndex=0}if(this.options.spinnable){this.bindSpinChange=this.onSpinChange.bind(this);
this.bindSpinEnd=this.onSpinEnd.bind(this);var g=[];if(this.totalFrames[1]>1&&this.options.infiniteAxis[1]){g.push("Up","Down")
}if(this.totalFrames[0]>1&&this.options.infiniteAxis[0]){g.push("Left","Right")
}for(var e=0;e<g.length;e++){var f=g[e],h=$(document.createElement("div"));this.container.appendChild(h);
h.className="spinner spin"+f;h.observe("mousedown",this["onSpin"+f+"Start"].bind(this));
this["spin"+f+"Offset"]=h.cumulativeOffset();if(f=="Left"||f=="Right"){h.style.height=this.container.getHeight()+"px"
}f=null;h=null}g=null}},unmakeInteractive:function(){if(this.mobile){this.vr.down().stopObserving("touchmove",this.bindGrabChange);
this.vr.down().stopObserving("touchend",this.bindGrabEnd)}if(this.options.grabbable){this.vr.stopObserving(this.getStr("mousedown"),this.bindGrabStart);
this.vr.stopObserving("click",this.bindOnClick);this.vr.stopObserving("focus",this.bindOnFocus);
this.vr.stopObserving("blur",this.bindOnBlur)}},recycle:function(){this.unmakeInteractive();
delete this.frames;delete this.introSequence;delete this.loader},atPosition:function(b){return(this.currentPos&&b[0]==this.currentPos[0]&&b[1]==this.currentPos[1])
},play:function(){if(this.playing){return}this.playing=true;this.playInterval=setInterval(this.gotoNextFrame.bind(this),this.playIntervalDuration)
},pause:function(){if(!this.playing){return}this.playing=false;clearInterval(this.playInterval)
},gotoNextFrame:function(){this.gotoPos([this.currentPos[0]+1,this.currentPos[1]])
},gotoPreviousFrame:function(){this.gotoPos([this.currentPos[0]-1,this.currentPos[1]])
},validatePos:function(f,d){for(var e=0;e<2;e++){if(d||this.options.infiniteAxis[e]){while(f[e]>this.totalFrames[e]-1){f[e]-=this.totalFrames[e]
}while(f[e]<0){f[e]+=this.totalFrames[e]}}else{if(f[e]>this.totalFrames[e]-1){f[e]=this.totalFrames[e]-1
}if(f[e]<0){f[e]=0}}}return f},gotoPos:function(c,d){c=this.validatePos(c);if(!d&&this.atPosition(c)){return
}this.currentPos=c;if("onGotoPos" in this.delegate&&typeof this.delegate.onGotoPos==="function"){this.delegate.onGotoPos(this,this.currentPos)
}this.frame=this.frames[c[0]][c[1]];if(typeof this.frame!="undefined"&&this.frame.nodeType){if(this.currentFrame){this.vr.removeChild(this.currentFrame)
}this.currentFrame=this.frame;this.vr.appendChild(this.currentFrame)}else{this.loader.loadNow(c)
}delete this.frame},animateToPos:function(b){if(typeof this.animateToInterval!=="undefined"){clearInterval(this.animateToInterval)
}this.animateToInterval=setInterval(this._animateToPos.bind(this,b),(100/Math.abs(this.currentPos[0]-b)))
},_animateToPos:function(c){var d=c-this.currentPos[0];if(d===0||isNaN(d)){if(typeof this.animateToInterval!=="undefined"){clearInterval(this.animateToInterval)
}delete this.animateToInterval}else{if(d>0){this.gotoNextFrame()}else{this.gotoPreviousFrame()
}}},onGrabStart:function(b){if(!(b=this.getEvent(b))){return}if(typeof this.animateToInterval!=="undefined"){clearInterval(this.animateToInterval)
}this.grabbing=true;$(document.body).addClassName("grabbing");$(document).observe(this.getStr("mousemove"),this.bindGrabChange);
$(document).observe(this.getStr("mouseup"),this.bindGrabEnd);if(this.mobile){this.vr.down().observe("touchmove",this.bindGrabChange);
this.vr.down().observe("touchend",this.bindGrabEnd)}this.grabHistory=$A([b]);this.onGrabChange.clientX=this.onGrabChange.clientY=null;
this.grabHistoryInterval=setInterval(this.updateGrabHistory.bind(this),10);this.onGrabStart.clientX=b.clientX;
this.onGrabStart.clientY=b.clientY;this.onGrabStart.playing=this.playing;this.onGrabStart.pos=this.currentPos;
this.pause();this.stopThrowing();if("onGrabStart" in this.delegate&&typeof this.delegate.onGrabStart==="function"){this.delegate.onGrabStart(this,this.onGrabStart.pos)
}if(!(this.options.allowMobileScroll&&this.mobile)){b.stop()}},onGrabChange:function(h){if(!(h=this.getEvent(h))){return
}if(!(h.clientX==this.onGrabStart.clientX&&h.clientY==this.onGrabStart.clientY)){this.onGrabChange.clientX=h.clientX;
this.onGrabChange.clientY=h.clientY;var g=this.getGrabPos(h);if(g){this.gotoPos(g)
}}if("onGrabChange" in this.delegate&&typeof this.delegate.onGrabChange==="function"){this.delegate.onGrabChange(this,g)
}var e=Math.abs(this.onGrabStart.clientX-this.onGrabChange.clientX),f=Math.abs(this.onGrabStart.clientY-this.onGrabChange.clientY);
if(this.mobile&&!!this.options.allowMobileScroll&&((this.totalFrames[1]===1&&e>f)||(this.totalFrames[0]===1&&f>e))){h.preventDefault();
h.stopPropagation()}},getGrabPos:function(o){var j=o.clientX-this.onGrabStart.clientX,k=o.clientY-this.onGrabStart.clientY,n=j/this.options.grabRotateDistance,q=k/this.options.grabRotateDistance,l=Math.round(this.totalFrames[0]*n),m=Math.round(this.totalFrames[1]*q),p=this.onGrabStart.pos[0]+l,r=this.onGrabStart.pos[1]+m;
return[p,r]},updateGrabHistory:function(){var b=this.onGrabChange.clientX?this.onGrabChange:this.onGrabStart;
this.grabHistory.unshift({clientX:b.clientX,clientY:b.clientY});if(this.grabHistory.length>3){this.grabHistory.splice(3)
}},onGrabEnd:function(B){if(!(B=this.getEvent(B))){return}this.grabbing=false;$(document.body).removeClassName("grabbing");
$(document).stopObserving(this.getStr("mousemove"),this.bindGrabChange);$(document).stopObserving(this.getStr("mouseup"),this.bindGrabEnd);
clearInterval(this.grabHistoryInterval);if(this.onGrabStart.playing){this.play()
}else{if(this.options.throwable){var q=B.clientX-this.grabHistory.last().clientX,r=B.clientY-this.grabHistory.last().clientY,w=true;
if(q||r){var t=Math.sqrt(Math.pow(q,2)+Math.pow(r,2)),u=Math.floor(t/5),z=this.grabHistory.last().clientX,A=this.grabHistory.last().clientY,i=true,p=true;
if(u<this.minThrowFrames){u=this.minThrowFrames}else{if(u>this.maxThrowFrames){u=this.maxThrowFrames
}}this.throwSequence=$A();for(var x=0;x<u;x++){var v=x/u,y=Math.pow(v-1,2),z=Math.floor(y*q)+z,A=Math.floor(y*r)+A,s=this.validatePos(this.getGrabPos({clientX:z,clientY:A}));
if(!i){s[0]=this.throwSequence.last()[0]}else{if(this.throwSequence.length&&s[0]==this.throwSequence.last()[0]){i=false
}}if(!p){s[1]=this.throwSequence.last()[1]}else{if(this.throwSequence.length&&s[1]==this.throwSequence.last()[1]){p=false
}}if(!this.isPosLoaded(s)){w=false;break}this.throwSequence.push(s)}if(w){this.throwing=true;
this.throwInterval=setInterval(this.throwStep.bind(this),this.playIntervalDuration)
}}}}if("onGrabEnd" in this.delegate&&typeof this.delegate.onGrabEnd==="function"){this.delegate.onGrabEnd(this)
}},throwStep:function(){this.gotoPos(this.throwSequence.shift());if(!this.throwSequence.length){this.stopThrowing()
}},stopThrowing:function(){if(!this.throwing){return}this.throwing=false;clearInterval(this.throwInterval)
},onSpinLeftStart:function(b){this.spinAxis=0;this.spinDirection=-1;this.spinBounds=this.spinLeftOffset[0]+35;
this.onSpinStart(b)},onSpinRightStart:function(b){this.spinAxis=0;this.spinDirection=1;
this.spinBounds=this.spinRightOffset[0];this.onSpinStart(b)},onSpinUpStart:function(b){this.spinAxis=1;
this.spinDirection=-1;this.spinBounds=this.spinUpOffset[1]+35;this.onSpinStart(b)
},onSpinDownStart:function(b){this.spinAxis=1;this.spinDirection=1;this.spinBounds=this.spinRightOffset[1];
this.onSpinStart(b)},onSpinStart:function(b){this.spinning=true;$(document.body).addClassName("spinning"+(this.spinDirection==-1?"Left":"Right"));
$(document).observe(this.getStr("mousemove"),this.bindSpinChange);$(document).observe(this.getStr("mouseup"),this.bindSpinEnd);
this.onSpinStart.clientX=b.clientX;this.onSpinStart.clientY=b.clientY;this.onSpinStart.playing=this.playing;
this.pause();this.spinPosDiff=1;this.onSpinChange(b);this.spin();b.stop()},onSpinChange:function(d){var c=(this.spinAxis==0?d.clientX:d.clientY)-this.spinBounds;
if(c!=this.spinBoundsDist){if((this.spinDirection==-1&&c>0)||(this.spinDirection==1&&c<0)){this.onSpinEnd(d);
this.onGrabStart(d)}else{this.spinBoundsDist=c;this.updateSpinIntervalDuration=true
}}},spin:function(){var c=this.currentPos.slice(0);c[this.spinAxis]+=this.spinDirection*this.spinPosDiff;
this.gotoPos(c);c=null;if(this.updateSpinIntervalDuration){this.updateSpinIntervalDuration=false;
clearInterval(this.spinInterval);var d=2000/Math.abs(this.spinBoundsDist);if(d>this.minSpinIntervalDuration){d=this.minSpinIntervalDuration
}if(d<this.playIntervalDuration){this.spinPosDiff=Math.round(this.playIntervalDuration/d);
d=this.playIntervalDuration}this.spinInterval=setInterval(this.spin.bind(this),d)
}},onSpinEnd:function(b){this.spinning=false;$(document.body).removeClassName("spinning"+(this.spinDirection==-1?"Left":"Right"));
$(document).stopObserving(this.getStr("mousemove"),this.bindSpinChange);$(document).stopObserving(this.getStr("mouseup"),this.bindSpinEnd);
clearInterval(this.spinInterval);if(this.onGrabStart.playing){this.play()}},onClick:function(b){if(this.focussed){return
}this.vr.addClassName("clickfocus");this.vr.focus()},onFocus:function(b){this.focussed=true;
$(document).observe("keydown",this.bindKeyDown);$(document).observe("keyup",this.bindKeyUp)
},onBlur:function(b){this.focussed=false;this.vr.removeClassName("clickfocus");
$(document).stopObserving("keydown",this.bindKeyDown);$(document).stopObserving("keyup",this.bindKeyDown)
},onKeyDown:function(d){if(d.keyCode<37||d.keyCode>40){return}this.onKeyDown.keys["key"+d.keyCode]=true;
var c=this.currentPos.slice(0);if(this.onKeyDown.keys.key37){c[0]--}else{if(this.onKeyDown.keys.key39){c[0]++
}}if(this.onKeyDown.keys.key38){c[1]--}else{if(this.onKeyDown.keys.key40){c[1]++
}}this.gotoPos(c);d.stop()},onKeyUp:function(b){if(b.keyCode<37||b.keyCode>40){return
}this.onKeyDown.keys["key"+b.keyCode]=false;b.stop()}});AC.VR.LoaderController=Class.create({initialize:function(e,f,g){this.vr=e;
this.queue=f;this.onLoad=g;this.retiredLoaders=new Array();this.vr.vr.addClassName("loading");
for(var h=0;h<this.vr.options.loaders;h++){this.loadNext(new AC.VR.Loader(this))
}},loadNext:function(b){if(this.queue.length){b.load(this.queue.shift())}else{this.retiredLoaders.push(b);
if(this.retiredLoaders.length==this.vr.options.loaders){this.vr.vr.removeClassName("loading");
if(typeof this.onLoad=="function"){this.onLoad();this.onLoad=null}}}},loadNow:function(b){if(this.retiredLoaders.length){this.retiredLoaders.shift().load(b)
}else{this.queue.unshift(b)}}});AC.VR.Loader=Class.create({initialize:function(b){this.controller=b;
this.loadNext=this.controller.loadNext.bind(this.controller)},load:function(b){this.pos=b;
if(this.controller.vr.isPosLoaded(b)){this.controller.loadNext(this);return}this.img=new Image();
this.img.onload=this.onLoad.bind(this);this.controller.vr.frames[this.pos[0]][this.pos[1]]=true;
this.img.src=this.controller.vr.getImageSource(this.pos)},onLoad:function(){this.controller.vr.frames[this.pos[0]][this.pos[1]]=this.img;
if(this.controller.vr.atPosition(this.pos)){this.controller.vr.gotoPos(this.pos,true)
}this.loadNext.defer(this)}});