(self.webpackChunk_am5=self.webpackChunk_am5||[]).push([[5547],{6269:function(e,t,a){"use strict";a.r(t),a.d(t,{am5wc:function(){return _}});var i={};a.r(i),a.d(i,{WordCloud:function(){return y}});var r=a(5125),o=a(3409),n=a(6245),s=a(7142),l=a(9395),u=function(e){function t(){return null!==e&&e.apply(this,arguments)||this}return(0,r.ZT)(t,e),Object.defineProperty(t.prototype,"setupDefaultRules",{enumerable:!1,configurable:!0,writable:!0,value:function(){var t=this;e.prototype.setupDefaultRules.call(this);var a=this._root.interfaceColors,i=this.rule.bind(this);i("WordCloud").setAll({width:n.AQ,height:n.AQ,minFontSize:(0,n.aQ)(2),maxFontSize:(0,n.aQ)(15),excludeWords:[],angles:[0,-90],minWordLength:1,step:15,randomness:0,autoFit:!0,animationEasing:l.out(l.cubic)});var r=i("Label",["wordcloud"]);r.setAll({text:"{category}",centerX:n.CI,centerY:n.CI,position:"absolute",lineHeight:n.AQ,populateText:!0}),r.setup=function(e){e.set("background",s.A.new(t._root,{fill:a.get("background"),fillOpacity:0}))}}}),t}(o.Q),h=a(3399),c=a(5769),f=a(962),d=a(8777),g=a(7144),b=a(1112),p=a(7652),v=a(5071),m=a(751),y=function(e){function t(){var t=null!==e&&e.apply(this,arguments)||this;return Object.defineProperty(t,"_currentIndex",{enumerable:!0,configurable:!0,writable:!0,value:0}),Object.defineProperty(t,"_timeoutDP",{enumerable:!0,configurable:!0,writable:!0,value:void 0}),Object.defineProperty(t,"_ghostContainer",{enumerable:!0,configurable:!0,writable:!0,value:t.children.push(d.W.new(t._root,{layer:99,opacity:.01}))}),Object.defineProperty(t,"_pointSets",{enumerable:!0,configurable:!0,writable:!0,value:[]}),Object.defineProperty(t,"_sets",{enumerable:!0,configurable:!0,writable:!0,value:3}),Object.defineProperty(t,"_process",{enumerable:!0,configurable:!0,writable:!0,value:!1}),Object.defineProperty(t,"_buffer",{enumerable:!0,configurable:!0,writable:!0,value:[]}),Object.defineProperty(t,"_boundsToAdd",{enumerable:!0,configurable:!0,writable:!0,value:void 0}),Object.defineProperty(t,"labels",{enumerable:!0,configurable:!0,writable:!0,value:t._makeLabels()}),t}return(0,r.ZT)(t,e),Object.defineProperty(t.prototype,"_afterNew",{enumerable:!1,configurable:!0,writable:!0,value:function(){var t=this;this._defaultThemes.push(u.new(this._root)),this.fields.push("category","fill"),this._setDefault("valueField","value"),this._setDefault("categoryField","category"),e.prototype._afterNew.call(this),this._root.events.on("frameended",(function(){t.set("progress",t._currentIndex/t.dataItems.length)}))}}),Object.defineProperty(t.prototype,"makeLabel",{enumerable:!1,configurable:!0,writable:!0,value:function(e){var t=this.children.push(this.labels.make());t._setDataItem(e),t._setDefault("fill",e.get("fill")),t.set("x",-999999),e.set("label",t),this.labels.push(t);var a=this._ghostContainer.children.push(this.labels.make());return a._setDataItem(e),a.setAll({fill:b.Il.fromHex(0),fontWeight:"900"}),e.set("ghostLabel",a),this.labels.push(a),t}}),Object.defineProperty(t.prototype,"_makeLabels",{enumerable:!1,configurable:!0,writable:!0,value:function(){var e=this;return new g.o(c.YS.new({}),(function(){return f._._new(e._root,{themeTags:p.mergeTags(e.labels.template.get("themeTags",[]),["wordcloud","series"])},[e.labels.template])}))}}),Object.defineProperty(t.prototype,"processDataItem",{enumerable:!1,configurable:!0,writable:!0,value:function(t){if(e.prototype.processDataItem.call(this,t),null==t.get("fill")){var a=this.get("colors");a&&t.setRaw("fill",a.next())}this.makeLabel(t)}}),Object.defineProperty(t.prototype,"_prepareChildren",{enumerable:!1,configurable:!0,writable:!0,value:function(){e.prototype._prepareChildren.call(this),this.isDirty("text")&&(this.data.setAll(this._getWords(this.get("text"))),this._dirty.text=!1)}}),Object.defineProperty(t.prototype,"_updateChildren",{enumerable:!1,configurable:!0,writable:!0,value:function(){var t=this;e.prototype._updateChildren.call(this);var a=this._root._renderer.resolution,i=Math.round(this._root.width()*a),r=2*this.get("step",1);if(this._valuesDirty||this._sizeDirty||this.isPrivateDirty("adjustedFontSize")){var o=this.getPrivate("adjustedFontSize",1),n=this.innerWidth(),s=this.innerHeight(),l=Math.min(n,s),u=Math.max(n,s);this._buffer=Array(Math.ceil(this._root.width()*this._root.height()*a*a)).fill(0),l<800&&(r/=2),this._ghostContainer._display.clear(),this._pointSets=[];for(var h=0;h<this._sets;h++){for(var c=r*(this._sets-h),f=this._spiralPoints(n/2,s/2,n,s,0,c*s/u,c*n/u,0,0),d=f.length-1;d>=0;d--){var g=f[d];(g.x<0||g.x>n||g.y<0||g.y>s)&&f.splice(d,1)}this._pointSets.push(f)}var b=0,m=0,y=0,_=1/0,w=0;v.each(this._dataItems,(function(e){var t=e.get("valueWorking",0);b+=t,m+=Math.abs(t)})),this._dataItems.sort((function(e,t){var a=e.get("value"),i=t.get("value");return a>i?-1:a<i?1:0})),v.each(this._dataItems,(function(e){var t=e.get("valueWorking",0);t>=m&&(b=e.get("value",0)),t>y&&(y=t),t<_&&(_=t),w++})),this.setPrivateRaw("valueLow",_),this.setPrivateRaw("valueHigh",y),this.setPrivateRaw("valueSum",b),this.setPrivateRaw("valueAverage",b/w),this.setPrivateRaw("valueAbsoluteSum",m);var x=Math.min(n,s),P=p.relativeToValue(this.get("minFontSize",10),x)*o,j=p.relativeToValue(this.get("maxFontSize",100),x)*o,I=this.get("angles",[0]);v.each(this._dataItems,(function(e){var a=e.get("valueWorking",0),i=e.get("ghostLabel"),r=P+(j-P)*(a-_)/(y-_),o=t._sets-1-Math.floor((r-P)/(j-P)*(t._sets-1));e.setRaw("set",o),e.setRaw("fontSize",r);var n=I[Math.floor(Math.random()*I.length)];e.setRaw("angle",n),i.setAll({fontSize:r,rotation:n,x:-1e4})})),this._process=!1,this._currentIndex=0,this._root.events.once("frameended",(function(){t.setTimeout((function(){t._process=!0,t._markDirtyKey("progress")}),50)}))}var O=this._boundsToAdd;if(O){for(var C=this._ghostContainer._display.getLayer().context,D=Math.round(O.top),M=Math.round(O.left),S=(n=Math.round(O.right-O.left),s=Math.round(O.bottom-O.top),C.getImageData(M,D,n,s).data),k=this._buffer,A=3,R=D;R<D+s;R++)for(var z=M;z<M+n;z++)h=(R+1)*i-(i-z),0!=S[A]&&(k[h]=1),A+=4;this._boundsToAdd=void 0}this._process&&this.isDirty("progress")&&this._processItem()}}),Object.defineProperty(t.prototype,"_processItem",{enumerable:!1,configurable:!0,writable:!0,value:function(){var e=this;if(this._boundsToAdd=void 0,this._currentIndex<this.dataItems.length){var t=this.dataItems[this._currentIndex],a=t.get("label"),i=t.get("ghostLabel"),o=this._root._renderer.resolution,n=i.width(),s=i.height(),l=i._display.getLayer().context,u=t.get("set"),h=this._pointSets[u],c=this.innerWidth(),f=this.innerHeight(),d=Math.round(this._root.width()*o),g=this.x(),b=this.y(),p=this.get("angles",[0]);c>f&&n>=c/2&&v.each(p,(function(e){var a;0==e&&0!=t.get("angle")&&(t.setRaw("angle",0),i.set("rotation",0),a=(0,r.CR)([s,n],2),n=a[0],s=a[1])})),f>c&&n>=c/2&&v.each(p,(function(e){var a;90==Math.abs(e)&&0==t.get("angle")&&(t.setRaw("angle",e),i.set("rotation",e),a=(0,r.CR)([s,n],2),n=a[0],s=a[1])}));var m=Math.ceil(n*o),y=Math.ceil(s*o);if(l&&n>0&&s>0)for(var _=Math.round(Math.random()*h.length*this.get("randomness",0)),w=!0;w;){var x=h[_];if(x){if(w=!1,this._currentIndex>0){var P=Math.round((x.x+g)*o-m/2),j=Math.round((x.y+b)*o-y/2);w=this._hasColor(P,j,m,y,d)}if(x.x-n/2<0||x.x+n/2>c||x.y-s/2<0||x.y+s/2>f)_++,w=!0;else if(w)_+=2;else{var I=t.get("angle",0),O=t.get("fontSize",0);-999999!=a.get("x")?(a.animate({key:"x",to:x.x,duration:this.get("animationDuration",0),easing:this.get("animationEasing")}),a.animate({key:"y",to:x.y,duration:this.get("animationDuration",0),easing:this.get("animationEasing")}),a.animate({key:"rotation",to:I,duration:this.get("animationDuration",0),easing:this.get("animationEasing")}),a.animate({key:"fontSize",to:O,duration:this.get("animationDuration",0),easing:this.get("animationEasing")})):(a.setAll({x:x.x,y:x.y,rotation:I,fontSize:O}),a.appear()),i.setAll({x:x.x,y:x.y});for(var C=h.length-1;C>=0;C--){var D=h[C];D.x>=x.x-n/2&&D.x<=x.x+n/2&&D.y>=x.y-s/2&&D.y<=x.y+s/2&&h.splice(C,1)}this._boundsToAdd={left:(x.x+g-n/2)*o,right:(x.x+g+n/2)*o,top:(x.y+b-s/2)*o,bottom:(x.y+b+s/2)*o}}}else{if(this.get("autoFit"))return void this.setTimeout((function(){e.setPrivate("adjustedFontSize",.9*e.getPrivate("adjustedFontSize",1))}),50);a.set("x",-999999),w=!1}}this._currentIndex++}}}),Object.defineProperty(t.prototype,"disposeDataItem",{enumerable:!1,configurable:!0,writable:!0,value:function(t){e.prototype.disposeDataItem.call(this,t);var a=t.get("label");a&&(this.labels.removeValue(a),a.dispose());var i=t.get("ghostLabel");i&&(this.labels.removeValue(i),i.dispose())}}),Object.defineProperty(t.prototype,"_getWords",{enumerable:!1,configurable:!0,writable:!0,value:function(e){var t=[];if(e){var a="A-Za-zªµºÀ-ÖØ-öø-ˁˆ-ˑˠ-ˤˬˮͰ-ʹͶ-ͷͺ-ͽΆΈ-ΊΌΎ-ΡΣ-ϵϷ-ҁҊ-ԣԱ-Ֆՙա-ևא-תװ-ײء-يٮ-ٯٱ-ۓەۥ-ۦۮ-ۯۺ-ۼۿܐܒ-ܯݍ-ޥޱߊ-ߪߴ-ߵߺऄ-हऽॐक़-ॡॱ-ॲॻ-ॿঅ-ঌএ-ঐও-নপ-রলশ-হঽৎড়-ঢ়য়-ৡৰ-ৱਅ-ਊਏ-ਐਓ-ਨਪ-ਰਲ-ਲ਼ਵ-ਸ਼ਸ-ਹਖ਼-ੜਫ਼ੲ-ੴઅ-ઍએ-ઑઓ-નપ-રલ-ળવ-હઽૐૠ-ૡଅ-ଌଏ-ଐଓ-ନପ-ରଲ-ଳଵ-ହଽଡ଼-ଢ଼ୟ-ୡୱஃஅ-ஊஎ-ஐஒ-கங-சஜஞ-டண-தந-பம-ஹௐఅ-ఌఎ-ఐఒ-నప-ళవ-హఽౘ-ౙౠ-ౡಅ-ಌಎ-ಐಒ-ನಪ-ಳವ-ಹಽೞೠ-ೡഅ-ഌഎ-ഐഒ-നപ-ഹഽൠ-ൡൺ-ൿඅ-ඖක-නඳ-රලව-ෆก-ะา-ำเ-ๆກ-ຂຄງ-ຈຊຍດ-ທນ-ຟມ-ຣລວສ-ຫອ-ະາ-ຳຽເ-ໄໆໜ-ໝༀཀ-ཇཉ-ཬྈ-ྋက-ဪဿၐ-ၕၚ-ၝၡၥ-ၦၮ-ၰၵ-ႁႎႠ-Ⴥა-ჺჼᄀ-ᅙᅟ-ᆢᆨ-ᇹሀ-ቈቊ-ቍቐ-ቖቘቚ-ቝበ-ኈኊ-ኍነ-ኰኲ-ኵኸ-ኾዀዂ-ዅወ-ዖዘ-ጐጒ-ጕጘ-ፚᎀ-ᎏᎠ-Ᏼᐁ-ᙬᙯ-ᙶᚁ-ᚚᚠ-ᛪᛮ-ᛰᜀ-ᜌᜎ-ᜑᜠ-ᜱᝀ-ᝑᝠ-ᝬᝮ-ᝰក-ឳៗៜᠠ-ᡷᢀ-ᢨᢪᤀ-ᤜᥐ-ᥭᥰ-ᥴᦀ-ᦩᧁ-ᧇᨀ-ᨖᬅ-ᬳᭅ-ᭋᮃ-ᮠᮮ-ᮯᰀ-ᰣᱍ-ᱏᱚ-ᱽᴀ-ᶿḀ-ἕἘ-Ἕἠ-ὅὈ-Ὅὐ-ὗὙὛὝὟ-ώᾀ-ᾴᾶ-ᾼιῂ-ῄῆ-ῌῐ-ΐῖ-Ίῠ-Ῥῲ-ῴῶ-ῼⁱⁿₐ-ₔℂℇℊ-ℓℕℙ-ℝℤΩℨK-ℭℯ-ℹℼ-ℿⅅ-ⅉⅎⅠ-ↈⰀ-Ⱞⰰ-ⱞⱠ-Ɐⱱ-ⱽⲀ-ⳤⴀ-ⴥⴰ-ⵥⵯⶀ-ⶖⶠ-ⶦⶨ-ⶮⶰ-ⶶⶸ-ⶾⷀ-ⷆⷈ-ⷎⷐ-ⷖⷘ-ⷞⸯ々-〇〡-〩〱-〵〸-〼ぁ-ゖゝ-ゟァ-ヺー-ヿㄅ-ㄭㄱ-ㆎㆠ-ㆷㇰ-ㇿ㐀䶵一鿃ꀀ-ꒌꔀ-ꘌꘐ-ꘟꘪ-ꘫꙀ-ꙟꙢ-ꙮꙿ-ꚗꜗ-ꜟꜢ-ꞈꞋ-ꞌꟻ-ꠁꠃ-ꠅꠇ-ꠊꠌ-ꠢꡀ-ꡳꢂ-ꢳꤊ-ꤥꤰ-ꥆꨀ-ꨨꩀ-ꩂꩄ-ꩋ가-힣豈-鶴侮-頻並-龎ﬀ-ﬆﬓ-ﬗיִײַ-ﬨשׁ-זּטּ-לּמּנּ-סּףּ-פּצּ-ﮱﯓ-ﴽﵐ-ﶏﶒ-ﷇﷰ-ﷻﹰ-ﹴﹶ-ﻼＡ-Ｚａ-ｚｦ-ﾾￂ-ￇￊ-ￏￒ-ￗￚ-ￜ0-9@+",i=new RegExp("(["+a+"]+[-"+a+"]*["+a+"]+)|(["+a+"]+)","ig"),r=e.match(i);if(!r)return[];for(var o=void 0;o=r.pop();){for(var n=void 0,s=0;s<t.length;s++)if(t[s].category.toLowerCase()==o.toLowerCase()){n=t[s];break}n?(n.value++,this.isCapitalized(o)||(n.category=o)):t.push({category:o,value:1})}var l=this.get("excludeWords"),u=this.get("minValue",1),h=this.get("minWordLength",1);if(u>1||h>1||l&&l.length>0)for(s=t.length-1;s>=0;s--){var c=t[s],f=c.category;c.value<u&&t.splice(s,1),f.length<h&&t.splice(s,1),l&&-1!==l.indexOf(f)&&t.splice(s,1)}t.sort((function(e,t){return e.value==t.value?0:e.value>t.value?-1:1}));var d=this.get("maxCount",1/0);t.length>d&&(t=t.slice(0,d))}return t}}),Object.defineProperty(t.prototype,"isCapitalized",{enumerable:!1,configurable:!0,writable:!0,value:function(e){var t=e.toLowerCase();return e[0]!=t[0]&&e.substr(1)==t.substr(1)&&e!=t}}),Object.defineProperty(t.prototype,"_spiralPoints",{enumerable:!1,configurable:!0,writable:!0,value:function(e,t,a,i,r,o,n,s,l){for(var u=r+.01,h=s*m.RADIANS,c=[];u<a+n;){var f=o;if(f/2>u&&(f=2*u),(h+=2*Math.asin(f/2/u))*m.DEGREES>l+(a-r)/n*360)break;var d=h*m.DEGREES,g={x:e+u*Math.cos(h),y:t+u*i/a*Math.sin(h)};c.push(g),u=r+d/360*n}return c.shift(),c}}),Object.defineProperty(t.prototype,"_hasColor",{enumerable:!1,configurable:!0,writable:!0,value:function(e,t,a,i,r){var o=this._buffer;if(o)for(var n=t;n<t+i;n+=4)for(var s=e;s<e+a;s+=4)if(0!=o[(n+1)*r-(r-s)])return!0;return!1}}),Object.defineProperty(t,"className",{enumerable:!0,configurable:!0,writable:!0,value:"WordCloud"}),Object.defineProperty(t,"classNames",{enumerable:!0,configurable:!0,writable:!0,value:h.F.classNames.concat([t.className])}),t}(h.F);const _=i}},function(e){"use strict";var t=(6269,e(e.s=6269)),a=window;for(var i in t)a[i]=t[i];t.__esModule&&Object.defineProperty(a,"__esModule",{value:!0})}]);
//# sourceMappingURL=wc.js.map