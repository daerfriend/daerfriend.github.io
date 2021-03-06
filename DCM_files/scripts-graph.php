!function(){if(this.SVG=function(t){return SVG.supported?new SVG.Doc(t):void 0},SVG.ns="http://www.w3.org/2000/svg",SVG.xlink="http://www.w3.org/1999/xlink",SVG.did=1e3,SVG.eid=function(t){return"Svgjs"+t.charAt(0).toUpperCase()+t.slice(1)+SVG.did++},SVG.create=function(t){var e=document.createElementNS(this.ns,t);return e.setAttribute("id",this.eid(t)),e},SVG.extend=function(){var t,e,i,n;for(t=[].slice.call(arguments),e=t.pop(),n=t.length-1;n>=0;n--)if(t[n])for(i in e)t[n].prototype[i]=e[i];SVG.Set&&SVG.Set.inherit&&SVG.Set.inherit()},SVG.get=function(t){var e=document.getElementById(t);return e?e.instance:void 0},SVG.supported=function(){return!!document.createElementNS&&!!document.createElementNS(SVG.ns,"svg").createSVGRect}(),!SVG.supported)return!1;SVG.regex={test:function(t,e){return this[e].test(t)},unit:/^(-?[\d\.]+)([a-z%]{0,2})$/,hex:/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i,rgb:/rgb\((\d+),(\d+),(\d+)\)/,isHex:/^#[a-f0-9]{3,6}$/i,isRgb:/^rgb\(/,isCss:/[^:]+:[^;]+;?/,isStyle:/^font|text|leading|cursor/,isBlank:/^(\s+)?$/,isNumber:/^-?[\d\.]+$/,isPercent:/^-?[\d\.]+%$/},SVG.defaults={matrix:"1 0 0 1 0 0",attrs:{"fill-opacity":1,"stroke-opacity":1,"stroke-width":0,"stroke-linejoin":"miter","stroke-linecap":"butt",fill:"#000000",stroke:"#000000",opacity:1,x:0,y:0,cx:0,cy:0,width:0,height:0,r:0,rx:0,ry:0,offset:0,"stop-opacity":1,"stop-color":"#000000"},trans:function(){return{x:0,y:0,scaleX:1,scaleY:1,rotation:0,skewX:0,skewY:0,matrix:this.matrix,a:1,b:0,c:0,d:1,e:0,f:0}}},SVG.Color=function(t){var e;this.r=0,this.g=0,this.b=0,"string"==typeof t?SVG.regex.isRgb.test(t)?(e=SVG.regex.rgb.exec(t.replace(/\s/g,"")),this.r=parseInt(e[1]),this.g=parseInt(e[2]),this.b=parseInt(e[3])):SVG.regex.isHex.test(t)&&(e=SVG.regex.hex.exec(this._fullHex(t)),this.r=parseInt(e[1],16),this.g=parseInt(e[2],16),this.b=parseInt(e[3],16)):"object"==typeof t&&(this.r=t.r,this.g=t.g,this.b=t.b)},SVG.extend(SVG.Color,{toString:function(){return this.toHex()},toHex:function(){return"#"+this._compToHex(this.r)+this._compToHex(this.g)+this._compToHex(this.b)},toRgb:function(){return"rgb("+[this.r,this.g,this.b].join()+")"},brightness:function(){return.3*(this.r/255)+.59*(this.g/255)+.11*(this.b/255)},_fullHex:function(t){return 4==t.length?["#",t.substring(1,2),t.substring(1,2),t.substring(2,3),t.substring(2,3),t.substring(3,4),t.substring(3,4)].join(""):t},_compToHex:function(t){var e=t.toString(16);return 1==e.length?"0"+e:e}}),SVG.Color.test=function(t){return t+="",SVG.regex.isHex.test(t)||SVG.regex.isRgb.test(t)},SVG.Color.isRgb=function(t){return t&&"number"==typeof t.r},SVG.Array=function(t,e){t=(t||[]).valueOf(),0==t.length&&e&&(t=e.valueOf()),this.value=this.parse(t)},SVG.extend(SVG.Array,{morph:function(t){if(this.destination=this.parse(t),this.value.length!=this.destination.length){for(var e=this.value[this.value.length-1],i=this.destination[this.destination.length-1];this.value.length>this.destination.length;)this.destination.push(i);for(;this.value.length<this.destination.length;)this.value.push(e)}return this},settle:function(){var t,e=[];for(t=this.value.length-1;t>=0;t--)-1==e.indexOf(this.value[t])&&e.push(this.value[t]);return this.value=e},at:function(t){if(!this.destination)return this;for(var e=0,i=this.value.length,n=[];i>e;e++)n.push(this.value[e]+(this.destination[e]-this.value[e])*t);return new SVG.Array(n)},toString:function(){return this.value.join(" ")},valueOf:function(){return this.value},parse:function(t){return t=t.valueOf(),Array.isArray(t)?t:this.split(t)},split:function(t){return t.replace(/\s+/g," ").replace(/^\s+|\s+$/g,"").split(" ")}}),SVG.PointArray=function(){this.constructor.apply(this,arguments)},SVG.PointArray.prototype=new SVG.Array,SVG.extend(SVG.PointArray,{toString:function(){for(var t=0,e=this.value.length,i=[];e>t;t++)i.push(this.value[t].join(","));return i.join(" ")},at:function(t){if(!this.destination)return this;for(var e=0,i=this.value.length,n=[];i>e;e++)n.push([this.value[e][0]+(this.destination[e][0]-this.value[e][0])*t,this.value[e][1]+(this.destination[e][1]-this.value[e][1])*t]);return new SVG.PointArray(n)},parse:function(t){if(t=t.valueOf(),Array.isArray(t))return t;t=this.split(t);for(var e,i=0,n=t.length,s=[];n>i;i++)e=t[i].split(","),s.push([parseFloat(e[0]),parseFloat(e[1])]);return s},move:function(t,e){var i=this.bbox();t-=i.x,e-=i.y;for(var n=this.value.length-1;n>=0;n--)this.value[n]=[this.value[n][0]+t,this.value[n][1]+e];return this},size:function(t,e){var i,n=this.bbox();for(i=this.value.length-1;i>=0;i--)this.value[i][0]=(this.value[i][0]-n.x)*t/n.width+n.x,this.value[i][1]=(this.value[i][1]-n.y)*e/n.height+n.x;return this},bbox:function(){if(0==this.value.length)return{x:0,y:0,width:0,height:0};var t,e=this.value[0][0],i=this.value[0][1],n={x:e,y:i};for(t=this.value.length-1;t>=0;t--)this.value[t][0]<n.x&&(n.x=this.value[t][0]),this.value[t][1]<n.y&&(n.y=this.value[t][1]),this.value[t][0]>e&&(e=this.value[t][0]),this.value[t][1]>i&&(i=this.value[t][1]);return n.width=e-n.x,n.height=i-n.y,n}}),SVG.Number=function(t){switch(this.value=0,this.unit="",typeof t){case"number":this.value=isNaN(t)?0:isFinite(t)?t:0>t?-3.4e38:3.4e38;break;case"string":var e=t.match(SVG.regex.unit);e&&(this.value=parseFloat(e[1]),"%"==e[2]&&(this.value/=100),this.unit=e[2]);break;default:t instanceof SVG.Number&&(this.value=t.value,this.unit=t.unit)}},SVG.extend(SVG.Number,{toString:function(){return("%"==this.unit?~~(1e8*this.value)/1e6:this.value)+this.unit},valueOf:function(){return this.value},to:function(t){return"string"==typeof t&&(this.unit=t),this},plus:function(t){return this.value=this+new SVG.Number(t),this},minus:function(t){return this.plus(-new SVG.Number(t))},times:function(t){return this.value=this*new SVG.Number(t),this},divide:function(t){return this.value=this/new SVG.Number(t),this}}),SVG.ViewBox=function(t){var e,i,n,s,r=t.bbox(),h=(t.attr("viewBox")||"").match(/-?[\d\.]+/g);this.x=r.x,this.y=r.y,this.width=t.node.clientWidth||t.node.getBoundingClientRect().width,this.height=t.node.clientHeight||t.node.getBoundingClientRect().height,h&&(e=parseFloat(h[0]),i=parseFloat(h[1]),n=parseFloat(h[2]),s=parseFloat(h[3]),this.zoom=this.width/this.height>n/s?this.height/s:this.width/n,this.x=e,this.y=i,this.width=n,this.height=s),this.zoom=this.zoom||1},SVG.extend(SVG.ViewBox,{toString:function(){return this.x+" "+this.y+" "+this.width+" "+this.height}}),SVG.BBox=function(t){var e;if(this.x=0,this.y=0,this.width=0,this.height=0,t){try{e=t.node.getBBox()}catch(i){e={x:t.node.clientLeft,y:t.node.clientTop,width:t.node.clientWidth,height:t.node.clientHeight}}this.x=e.x+t.trans.x,this.y=e.y+t.trans.y,this.width=e.width*t.trans.scaleX,this.height=e.height*t.trans.scaleY}this.cx=this.x+this.width/2,this.cy=this.y+this.height/2},SVG.extend(SVG.BBox,{merge:function(t){var e=new SVG.BBox;return e.x=Math.min(this.x,t.x),e.y=Math.min(this.y,t.y),e.width=Math.max(this.x+this.width,t.x+t.width)-e.x,e.height=Math.max(this.y+this.height,t.y+t.height)-e.y,e.cx=e.x+e.width/2,e.cy=e.y+e.height/2,e}}),SVG.RBox=function(t){var e,i,n={};if(this.x=0,this.y=0,this.width=0,this.height=0,t){for(e=t.doc().parent,i=t.doc().viewbox().zoom,n=t.node.getBoundingClientRect(),this.x=n.left,this.y=n.top,this.x-=e.offsetLeft,this.y-=e.offsetTop;e=e.offsetParent;)this.x-=e.offsetLeft,this.y-=e.offsetTop;for(e=t;e=e.parent;)"svg"==e.type&&e.viewbox&&(i*=e.viewbox().zoom,this.x-=e.x()||0,this.y-=e.y()||0)}this.x/=i,this.y/=i,this.width=n.width/=i,this.height=n.height/=i,this.cx=this.x+this.width/2,this.cy=this.y+this.height/2},SVG.extend(SVG.RBox,{merge:function(t){var e=new SVG.RBox;return e.x=Math.min(this.x,t.x),e.y=Math.min(this.y,t.y),e.width=Math.max(this.x+this.width,t.x+t.width)-e.x,e.height=Math.max(this.y+this.height,t.y+t.height)-e.y,e.cx=e.x+e.width/2,e.cy=e.y+e.height/2,e}}),SVG.Element=function(t){this._stroke=SVG.defaults.attrs.stroke,this.styles={},this.trans=SVG.defaults.trans(),(this.node=t)&&(this.type=t.nodeName,this.node.instance=this)},SVG.extend(SVG.Element,{x:function(t){return t&&(t=new SVG.Number(t),t.value/=this.trans.scaleX),this.attr("x",t)},y:function(t){return t&&(t=new SVG.Number(t),t.value/=this.trans.scaleY),this.attr("y",t)},cx:function(t){return null==t?this.bbox().cx:this.x(t-this.bbox().width/2)},cy:function(t){return null==t?this.bbox().cy:this.y(t-this.bbox().height/2)},move:function(t,e){return this.x(t).y(e)},center:function(t,e){return this.cx(t).cy(e)},size:function(t,e){return this.attr({width:new SVG.Number(t),height:new SVG.Number(e)})},clone:function(){var t,e,i=this.type;return t="rect"==i||"ellipse"==i?this.parent[i](0,0):"line"==i?this.parent[i](0,0,0,0):"image"==i?this.parent[i](this.src):"text"==i?this.parent[i](this.content):"path"==i?this.parent[i](this.attr("d")):"polyline"==i||"polygon"==i?this.parent[i](this.attr("points")):"g"==i?this.parent.group():this.parent[i](),e=this.attr(),delete e.id,t.attr(e),t.trans=this.trans,t.transform({})},remove:function(){return this.parent&&this.parent.removeElement(this),this},doc:function(t){return this._parent(t||SVG.Doc)},attr:function(t,e,i){if(null==t){for(t={},e=this.node.attributes,i=e.length-1;i>=0;i--)t[e[i].nodeName]=SVG.regex.test(e[i].nodeValue,"isNumber")?parseFloat(e[i].nodeValue):e[i].nodeValue;return t}if("object"==typeof t)for(e in t)this.attr(e,t[e]);else if(null===e)this.node.removeAttribute(t);else{if(null==e)return this._isStyle(t)?"text"==t?this.content:"leading"==t&&this.leading?this.leading():this.style(t):(e=this.node.getAttribute(t),null==e?SVG.defaults.attrs[t]:SVG.regex.test(e,"isNumber")?parseFloat(e):e);if("style"==t)return this.style(e);if("x"==t&&Array.isArray(this.lines))for(i=this.lines.length-1;i>=0;i--)this.lines[i].attr(t,e);"stroke-width"==t?this.attr("stroke",parseFloat(e)>0?this._stroke:null):"stroke"==t&&(this._stroke=e),SVG.Color.test(e)||SVG.Color.isRgb(e)?e=new SVG.Color(e):"number"==typeof e?e=new SVG.Number(e):Array.isArray(e)&&(e=new SVG.Array(e)),null!=i?this.node.setAttributeNS(i,t,e.toString()):this.node.setAttribute(t,e.toString()),this._isStyle(t)&&("text"==t?this.text(e):"leading"==t&&this.leading?this.leading(e):this.style(t,e),this.rebuild&&this.rebuild(t,e))}return this},transform:function(t,e){if(0==arguments.length)return this.trans;if("string"==typeof t){if(arguments.length<2)return this.trans[t];var i={};return i[t]=e,this.transform(i)}var i=[];t=this._parseMatrix(t);for(e in t)null!=t[e]&&(this.trans[e]=t[e]);return this.trans.matrix=this.trans.a+" "+this.trans.b+" "+this.trans.c+" "+this.trans.d+" "+this.trans.e+" "+this.trans.f,t=this.trans,t.matrix!=SVG.defaults.matrix&&i.push("matrix("+t.matrix+")"),0!=t.rotation&&i.push("rotate("+t.rotation+" "+(null==t.cx?this.bbox().cx:t.cx)+" "+(null==t.cy?this.bbox().cy:t.cy)+")"),(1!=t.scaleX||1!=t.scaleY)&&i.push("scale("+t.scaleX+" "+t.scaleY+")"),0!=t.skewX&&i.push("skewX("+t.skewX+")"),0!=t.skewY&&i.push("skewY("+t.skewY+")"),(0!=t.x||0!=t.y)&&i.push("translate("+new SVG.Number(t.x/t.scaleX)+" "+new SVG.Number(t.y/t.scaleY)+")"),this._offset&&0!=this._offset.x&&0!=this._offset.y&&i.push("translate("+-this._offset.x+" "+-this._offset.y+")"),0==i.length?this.node.removeAttribute("transform"):this.node.setAttribute("transform",i.join(" ")),this},style:function(t,e){if(0==arguments.length)return this.attr("style")||"";if(arguments.length<2)if("object"==typeof t)for(e in t)this.style(e,t[e]);else{if(!SVG.regex.isCss.test(t))return this.styles[t];t=t.split(";");for(var i=0;i<t.length;i++)e=t[i].split(":"),2==e.length&&this.style(e[0].replace(/\s+/g,""),e[1].replace(/^\s+/,"").replace(/\s+$/,""))}else null===e||SVG.regex.test(e,"isBlank")?delete this.styles[t]:this.styles[t]=e;t="";for(e in this.styles)t+=e+":"+this.styles[e]+";";return""==t?this.node.removeAttribute("style"):this.node.setAttribute("style",t),this},data:function(t,e,i){if(arguments.length<2)try{return JSON.parse(this.attr("data-"+t))}catch(n){return this.attr("data-"+t)}else this.attr("data-"+t,null===e?null:i===!0||"string"==typeof e||"number"==typeof e?e:JSON.stringify(e));return this},bbox:function(){return new SVG.BBox(this)},rbox:function(){return new SVG.RBox(this)},inside:function(t,e){var i=this.bbox();return t>i.x&&e>i.y&&t<i.x+i.width&&e<i.y+i.height},show:function(){return this.style("display","")},hide:function(){return this.style("display","none")},visible:function(){return"none"!=this.style("display")},toString:function(){return this.attr("id")},_parent:function(t){for(var e=this;null!=e&&!(e instanceof t);)e=e.parent;return e},_isStyle:function(t){return"string"==typeof t?SVG.regex.test(t,"isStyle"):!1},_parseMatrix:function(t){if(t.matrix){var e=t.matrix.replace(/\s/g,"").split(",");6==e.length&&(t.a=parseFloat(e[0]),t.b=parseFloat(e[1]),t.c=parseFloat(e[2]),t.d=parseFloat(e[3]),t.e=parseFloat(e[4]),t.f=parseFloat(e[5]))}return t}}),SVG.Parent=function(t){this.constructor.call(this,t)},SVG.Parent.prototype=new SVG.Element,SVG.extend(SVG.Parent,{children:function(){return this._children||(this._children=[])},add:function(t,e){if(!this.has(t)){if(e=null==e?this.children().length:e,t.parent){var i=t.parent.children().indexOf(t);t.parent.children().splice(i,1)}this.children().splice(e,0,t),this.node.insertBefore(t.node,this.node.childNodes[e]||null),t.parent=this}return this._defs&&(this.node.removeChild(this._defs.node),this.node.appendChild(this._defs.node)),this},put:function(t,e){return this.add(t,e),t},has:function(t){return this.children().indexOf(t)>=0},get:function(t){return this.children()[t]},first:function(){return this.children()[0]},last:function(){return this.children()[this.children().length-1]},each:function(t,e){var i,n,s=this.children();for(i=0,n=s.length;n>i;i++)s[i]instanceof SVG.Element&&t.apply(s[i],[i,s]),e&&s[i]instanceof SVG.Container&&s[i].each(t,e);return this},removeElement:function(t){var e=this.children().indexOf(t);return this.children().splice(e,1),this.node.removeChild(t.node),t.parent=null,this},clear:function(){for(var t=this.children().length-1;t>=0;t--)this.removeElement(this.children()[t]);return this._defs&&this._defs.clear(),this},defs:function(){return this.doc().defs()}}),SVG.Container=function(t){this.constructor.call(this,t)},SVG.Container.prototype=new SVG.Parent,SVG.extend(SVG.Container,{viewbox:function(t){return 0==arguments.length?new SVG.ViewBox(this):(t=1==arguments.length?[t.x,t.y,t.width,t.height]:[].slice.call(arguments),this.attr("viewBox",t))}}),SVG.FX=function(t){this.target=t},SVG.extend(SVG.FX,{animate:function(t,e,i){var n,s,r,h,o=this.target,a=this;return"object"==typeof t&&(i=t.delay,e=t.ease,t=t.duration),t=null==t?1e3:t,e=e||"<>",a.to=function(t){var i;if(t=0>t?0:t>1?1:t,null==n){n=[];for(h in a.attrs)n.push(h);if(o.morphArray){var u,l=new o.morphArray(a._plot||o.points.toString());a._size&&l.size(a._size.width.to,a._size.height.to),u=l.bbox(),a._x?l.move(a._x.to,u.y):a._cx&&l.move(a._cx.to-u.width/2,u.y),u=l.bbox(),a._y?l.move(u.x,a._y.to):a._cy&&l.move(u.x,a._cy.to-u.height/2),delete a._x,delete a._y,delete a._cx,delete a._cy,delete a._size,a._plot=o.points.morph(l)}}if(null==s){s=[];for(h in a.trans)s.push(h)}if(null==r){r=[];for(h in a.styles)r.push(h)}for(t="<>"==e?-Math.cos(t*Math.PI)/2+.5:">"==e?Math.sin(t*Math.PI/2):"<"==e?-Math.cos(t*Math.PI/2)+1:"-"==e?t:"function"==typeof e?e(t):t,a._x?o.x(a._at(a._x,t)):a._cx&&o.cx(a._at(a._cx,t)),a._y?o.y(a._at(a._y,t)):a._cy&&o.cy(a._at(a._cy,t)),a._size&&o.size(a._at(a._size.width,t),a._at(a._size.height,t)),a._plot&&o.plot(a._plot.at(t)),a._viewbox&&o.viewbox(a._at(a._viewbox.x,t),a._at(a._viewbox.y,t),a._at(a._viewbox.width,t),a._at(a._viewbox.height,t)),i=n.length-1;i>=0;i--)o.attr(n[i],a._at(a.attrs[n[i]],t));for(i=s.length-1;i>=0;i--)o.transform(s[i],a._at(a.trans[s[i]],t));for(i=r.length-1;i>=0;i--)o.style(r[i],a._at(a.styles[r[i]],t));a._during&&a._during.call(o,t,function(e,i){return a._at({from:e,to:i},t)})},"number"==typeof t&&(this.timeout=setTimeout(function(){var e=1e3/60,i=(new Date).getTime(),n=i+t;a.interval=setInterval(function(){var e=(new Date).getTime(),s=e>n?1:(e-i)/t;a.to(s),e>n&&(a._plot&&o.plot(new SVG.PointArray(a._plot.destination).settle()),clearInterval(a.interval),a._after?a._after.apply(o,[a]):a.stop())},t>e?e:t)},i||0)),this},bbox:function(){return this.target.bbox()},attr:function(t,e){if("object"==typeof t)for(var i in t)this.attr(i,t[i]);else this.attrs[t]={from:this.target.attr(t),to:e};return this},transform:function(t,e){if(1==arguments.length){t=this.target._parseMatrix(t),delete t.matrix;for(e in t)this.trans[e]={from:this.target.trans[e],to:t[e]}}else{var i={};i[t]=e,this.transform(i)}return this},style:function(t,e){if("object"==typeof t)for(var i in t)this.style(i,t[i]);else this.styles[t]={from:this.target.style(t),to:e};return this},x:function(t){return this._x={from:this.target.x(),to:t},this},y:function(t){return this._y={from:this.target.y(),to:t},this},cx:function(t){return this._cx={from:this.target.cx(),to:t},this},cy:function(t){return this._cy={from:this.target.cy(),to:t},this},move:function(t,e){return this.x(t).y(e)},center:function(t,e){return this.cx(t).cy(e)},size:function(t,e){if(this.target instanceof SVG.Text)this.attr("font-size",t);else{var i=this.target.bbox();this._size={width:{from:i.width,to:t},height:{from:i.height,to:e}}}return this},plot:function(t){return this._plot=t,this},viewbox:function(t,e,i,n){if(this.target instanceof SVG.Container){var s=this.target.viewbox();this._viewbox={x:{from:s.x,to:t},y:{from:s.y,to:e},width:{from:s.width,to:i},height:{from:s.height,to:n}}}return this},update:function(t){return this.target instanceof SVG.Stop&&(null!=t.opacity&&this.attr("stop-opacity",t.opacity),null!=t.color&&this.attr("stop-color",t.color),null!=t.offset&&this.attr("offset",new SVG.Number(t.offset))),this},during:function(t){return this._during=t,this},after:function(t){return this._after=t,this},stop:function(){return clearTimeout(this.timeout),clearInterval(this.interval),this.attrs={},this.trans={},this.styles={},delete this._x,delete this._y,delete this._cx,delete this._cy,delete this._size,delete this._plot,delete this._after,delete this._during,delete this._viewbox,this},_at:function(t,e){return"number"==typeof t.from?t.from+(t.to-t.from)*e:SVG.regex.unit.test(t.to)?new SVG.Number(t.to).minus(new SVG.Number(t.from)).times(e).plus(new SVG.Number(t.from)):t.to&&(t.to.r||SVG.Color.test(t.to))?this._color(t,e):1>e?t.from:t.to},_color:function(t,e){var i,n;return e=0>e?0:e>1?1:e,i=new SVG.Color(t.from),n=new SVG.Color(t.to),new SVG.Color({r:~~(i.r+(n.r-i.r)*e),g:~~(i.g+(n.g-i.g)*e),b:~~(i.b+(n.b-i.b)*e)}).toHex()}}),SVG.extend(SVG.Element,{animate:function(t,e,i){return(this.fx||(this.fx=new SVG.FX(this))).stop().animate(t,e,i)},stop:function(){return this.fx&&this.fx.stop(),this}}),["click","dblclick","mousedown","mouseup","mouseover","mouseout","mousemove","mouseenter","mouseleave"].forEach(function(t){SVG.Element.prototype[t]=function(e){var i=this;return this.node["on"+t]="function"==typeof e?function(){return e.apply(i,arguments)}:null,this}}),SVG.on=function(t,e,i){t.addEventListener?t.addEventListener(e,i,!1):t.attachEvent("on"+e,i)},SVG.off=function(t,e,i){t.removeEventListener?t.removeEventListener(e,i,!1):t.detachEvent("on"+e,i)},SVG.extend(SVG.Element,{on:function(t,e){return SVG.on(this.node,t,e),this},off:function(t,e){return SVG.off(this.node,t,e),this}}),SVG.Defs=function(){this.constructor.call(this,SVG.create("defs"))},SVG.Defs.prototype=new SVG.Container,SVG.G=function(){this.constructor.call(this,SVG.create("g"))},SVG.G.prototype=new SVG.Container,SVG.extend(SVG.G,{x:function(t){return null==t?this.trans.x:this.transform("x",t)},y:function(t){return null==t?this.trans.y:this.transform("y",t)}}),SVG.extend(SVG.Container,{group:function(){return this.put(new SVG.G)}}),SVG.extend(SVG.Element,{siblings:function(){return this.parent.children()},position:function(){var t=this.siblings();return t.indexOf(this)},next:function(){return this.siblings()[this.position()+1]},previous:function(){return this.siblings()[this.position()-1]},forward:function(){var t=this.position();return this.parent.removeElement(this).put(this,t+1)},backward:function(){var t=this.position();return t>0&&this.parent.removeElement(this).add(this,t-1),this},front:function(){return this.parent.removeElement(this).put(this)},back:function(){return this.position()>0&&this.parent.removeElement(this).add(this,0),this},before:function(t){t.remove();var e=this.position();return this.parent.add(t,e),this},after:function(t){t.remove();var e=this.position();return this.parent.add(t,e+1),this}}),SVG.Mask=function(){this.constructor.call(this,SVG.create("mask")),this.targets=[]},SVG.Mask.prototype=new SVG.Container,SVG.extend(SVG.Mask,{remove:function(){for(var t=this.targets.length-1;t>=0;t--)this.targets[t]&&this.targets[t].unmask();return delete this.targets,this.parent.removeElement(this),this}}),SVG.extend(SVG.Element,{maskWith:function(t){return this.masker=t instanceof SVG.Mask?t:this.parent.mask().add(t),this.masker.targets.push(this),this.attr("mask",'url("#'+this.masker.attr("id")+'")')},unmask:function(){return delete this.masker,this.attr("mask",null)}}),SVG.extend(SVG.Container,{mask:function(){return this.defs().put(new SVG.Mask)}}),SVG.Clip=function(){this.constructor.call(this,SVG.create("clipPath")),this.targets=[]},SVG.Clip.prototype=new SVG.Container,SVG.extend(SVG.Clip,{remove:function(){for(var t=this.targets.length-1;t>=0;t--)this.targets[t]&&this.targets[t].unclip();return delete this.targets,this.parent.removeElement(this),this}}),SVG.extend(SVG.Element,{clipWith:function(t){return this.clipper=t instanceof SVG.Clip?t:this.parent.clip().add(t),this.clipper.targets.push(this),this.attr("clip-path",'url("#'+this.clipper.attr("id")+'")')},unclip:function(){return delete this.clipper,this.attr("clip-path",null)}}),SVG.extend(SVG.Container,{clip:function(){return this.defs().put(new SVG.Clip)}}),SVG.Gradient=function(t){this.constructor.call(this,SVG.create(t+"Gradient")),this.type=t},SVG.Gradient.prototype=new SVG.Container,SVG.extend(SVG.Gradient,{from:function(t,e){return"radial"==this.type?this.attr({fx:new SVG.Number(t),fy:new SVG.Number(e)}):this.attr({x1:new SVG.Number(t),y1:new SVG.Number(e)})},to:function(t,e){return"radial"==this.type?this.attr({cx:new SVG.Number(t),cy:new SVG.Number(e)}):this.attr({x2:new SVG.Number(t),y2:new SVG.Number(e)})},radius:function(t){return"radial"==this.type?this.attr({r:new SVG.Number(t)}):this},at:function(t){return this.put(new SVG.Stop(t))},update:function(t){return this.clear(),t(this),this},fill:function(){return"url(#"+this.attr("id")+")"},toString:function(){return this.fill()}}),SVG.extend(SVG.Defs,{gradient:function(t,e){var i=this.put(new SVG.Gradient(t));return e(i),i}}),SVG.extend(SVG.Container,{gradient:function(t,e){return this.defs().gradient(t,e)}}),SVG.Stop=function(t){this.constructor.call(this,SVG.create("stop")),this.update(t)},SVG.Stop.prototype=new SVG.Element,SVG.extend(SVG.Stop,{update:function(t){return null!=t.opacity&&this.attr("stop-opacity",t.opacity),null!=t.color&&this.attr("stop-color",t.color),null!=t.offset&&this.attr("offset",new SVG.Number(t.offset)),this}}),SVG.Doc=function(t){this.parent="string"==typeof t?document.getElementById(t):t,this.constructor.call(this,"svg"==this.parent.nodeName?this.parent:SVG.create("svg")),this.attr({xmlns:SVG.ns,version:"1.1",width:"100%",height:"100%"}).attr("xlink",SVG.xlink,SVG.ns),this._defs=new SVG.Defs,this.node.appendChild(this._defs.node),"svg"!=this.parent.nodeName&&this.stage()},SVG.Doc.prototype=new SVG.Container,SVG.extend(SVG.Doc,{stage:function(){var t,e=this,i=document.createElement("div");return i.style.cssText="position:relative;height:100%;",e.parent.appendChild(i),i.appendChild(e.node),t=function(){"complete"===document.readyState?(e.style("position:absolute;"),setTimeout(function(){e.style("position:relative;overflow:hidden;"),e.parent.removeChild(e.node.parentNode),e.node.parentNode.removeChild(e.node),e.parent.appendChild(e.node),e.fixSubPixelOffset(),SVG.on(window,"resize",function(){e.fixSubPixelOffset()})},5)):setTimeout(t,10)},t(),this},defs:function(){return this._defs},fixSubPixelOffset:function(){var t=this.node.getScreenCTM();this.style("left",-t.e%1+"px").style("top",-t.f%1+"px")}}),SVG.Shape=function(t){this.constructor.call(this,t)},SVG.Shape.prototype=new SVG.Element,SVG.Use=function(){this.constructor.call(this,SVG.create("use"))},SVG.Use.prototype=new SVG.Shape,SVG.extend(SVG.Use,{element:function(t){return this.target=t,this.attr("href","#"+t,SVG.xlink)}}),SVG.extend(SVG.Container,{use:function(t){return this.put(new SVG.Use).element(t)}}),SVG.Rect=function(){this.constructor.call(this,SVG.create("rect"))},SVG.Rect.prototype=new SVG.Shape,SVG.extend(SVG.Container,{rect:function(t,e){return this.put((new SVG.Rect).size(t,e))}}),SVG.Ellipse=function(){this.constructor.call(this,SVG.create("ellipse"))},SVG.Ellipse.prototype=new SVG.Shape,SVG.extend(SVG.Ellipse,{x:function(t){return null==t?this.cx()-this.attr("rx"):this.cx(t+this.attr("rx"))},y:function(t){return null==t?this.cy()-this.attr("ry"):this.cy(t+this.attr("ry"))},cx:function(t){return null==t?this.attr("cx"):this.attr("cx",new SVG.Number(t).divide(this.trans.scaleX))},cy:function(t){return null==t?this.attr("cy"):this.attr("cy",new SVG.Number(t).divide(this.trans.scaleY))},size:function(t,e){return this.attr({rx:new SVG.Number(t).divide(2),ry:new SVG.Number(e).divide(2)})}}),SVG.extend(SVG.Container,{circle:function(t){return this.ellipse(t,t)},ellipse:function(t,e){return this.put(new SVG.Ellipse).size(t,e).move(0,0)}}),SVG.Line=function(){this.constructor.call(this,SVG.create("line"))},SVG.Line.prototype=new SVG.Shape,SVG.extend(SVG.Line,{x:function(t){var e=this.bbox();return null==t?e.x:this.attr({x1:this.attr("x1")-e.x+t,x2:this.attr("x2")-e.x+t})},y:function(t){var e=this.bbox();return null==t?e.y:this.attr({y1:this.attr("y1")-e.y+t,y2:this.attr("y2")-e.y+t})},cx:function(t){var e=this.bbox().width/2;return null==t?this.x()+e:this.x(t-e)},cy:function(t){var e=this.bbox().height/2;return null==t?this.y()+e:this.y(t-e)},size:function(t,e){var i=this.bbox();return this.attr(this.attr("x1")<this.attr("x2")?"x2":"x1",i.x+t).attr(this.attr("y1")<this.attr("y2")?"y2":"y1",i.y+e)},plot:function(t,e,i,n){return this.attr({x1:t,y1:e,x2:i,y2:n})}}),SVG.extend(SVG.Container,{line:function(t,e,i,n){return this.put((new SVG.Line).plot(t,e,i,n))}}),SVG.Polyline=function(){this.constructor.call(this,SVG.create("polyline"))},SVG.Polyline.prototype=new SVG.Shape,SVG.Polygon=function(){this.constructor.call(this,SVG.create("polygon"))},SVG.Polygon.prototype=new SVG.Shape,SVG.extend(SVG.Polyline,SVG.Polygon,{morphArray:SVG.PointArray,plot:function(t){return this.attr("points",this.points=new SVG.PointArray(t,[[0,0]]))},move:function(t,e){return this.attr("points",this.points.move(t,e))},x:function(t){return null==t?this.bbox().x:this.move(t,this.bbox().y)},y:function(t){return null==t?this.bbox().y:this.move(this.bbox().x,t)},size:function(t,e){return this.attr("points",this.points.size(t,e))}}),SVG.extend(SVG.Container,{polyline:function(t){return this.put(new SVG.Polyline).plot(t)},polygon:function(t){return this.put(new SVG.Polygon).plot(t)}}),SVG.Path=function(t){this.constructor.call(this,SVG.create("path")),this.unbiased=!!t},SVG.Path.prototype=new SVG.Shape,SVG.extend(SVG.Path,{_plot:function(t){return this.attr("d",t||"M0,0")}}),SVG.extend(SVG.Container,{path:function(t,e){return this.put(new SVG.Path(e)).plot(t)}}),SVG.extend(SVG.Path,{x:function(t){return null==t?this.bbox().x:this.transform("x",t)},y:function(t){return null==t?this.bbox().y:this.transform("y",t)},size:function(t,e){var i=t/this._offset.width;return this.transform({scaleX:i,scaleY:null!=e?e/this._offset.height:i})},plot:function(t){var e=this.trans.scaleX,i=this.trans.scaleY;return this._plot(t),this._offset=this.transform({scaleX:1,scaleY:1}).bbox(),this.unbiased?this._offset.x=this._offset.y=0:(this._offset.x-=this.trans.x,this._offset.y-=this.trans.y),this.transform({scaleX:e,scaleY:i})}}),SVG.Image=function(){this.constructor.call(this,SVG.create("image"))},SVG.Image.prototype=new SVG.Shape,SVG.extend(SVG.Image,{load:function(t){return t?this.attr("href",this.src=t,SVG.xlink):this}}),SVG.extend(SVG.Container,{image:function(t,e,i){return e=null!=e?e:100,this.put((new SVG.Image).load(t).size(e,null!=i?i:e))}});var t="size family weight stretch variant style".split(" ");SVG.Text=function(){this.constructor.call(this,SVG.create("text")),this.styles={"font-size":16,"font-family":"Helvetica, Arial, sans-serif","text-anchor":"start"},this._leading=new SVG.Number("1.2em"),this._rebuild=!0},SVG.Text.prototype=new SVG.Shape,SVG.extend(SVG.Text,{x:function(t,e){return null==t?e?this.attr("x"):this.bbox().x:(e||(e=this.style("text-anchor"),t="start"==e?t:"end"==e?t+this.bbox().width:t+this.bbox().width/2),this.textPath||this.lines.each(function(){this.newLined&&this.x(t)}),this.attr("x",t))},cx:function(t){return null==t?this.bbox().cx:this.x(t-this.bbox().width/2)},cy:function(t,e){return null==t?this.bbox().cy:this.y(e?t:t-this.bbox().height/2)},move:function(t,e,i){return this.x(t,i).y(e)},center:function(t,e,i){return this.cx(t,i).cy(e,i)},text:function(t){if(null==t)return this.content;if(this.clear(),"function"==typeof t)this._rebuild=!1,t(this);else{this._rebuild=!0,t=SVG.regex.isBlank.test(t)?"text":t;var e,i,n=t.split("\n");for(e=0,i=n.length;i>e;e++)this.tspan(n[e]).newLine();this.rebuild()}return this},tspan:function(t){var e=this.textPath?this.textPath.node:this.node,i=(new SVG.TSpan).text(t),n=this.style();return e.appendChild(i.node),this.lines.add(i),SVG.regex.isBlank.test(n)||i.style(n),this.content+=t,i.parent=this,i},size:function(t){return this.attr("font-size",t)},leading:function(t){return null==t?this._leading:(t=new SVG.Number(t),this._leading=t,this.lines.each(function(){this.newLined&&this.attr("dy",t)}),this)},rebuild:function(){return this._rebuild&&this.lines.attr({x:this.attr("x"),dy:this._leading,style:this.style()}),this},clear:function(){for(var t=this.textPath?this.textPath.node:this.node;t.hasChildNodes();)t.removeChild(t.lastChild);return delete this.lines,this.lines=new SVG.Set,this.content="",this}}),SVG.extend(SVG.Container,{text:function(t){return this.put(new SVG.Text).text(t)}}),SVG.TSpan=function(){this.constructor.call(this,SVG.create("tspan"))},SVG.TSpan.prototype=new SVG.Shape,SVG.extend(SVG.TSpan,{text:function(t){return this.node.appendChild(document.createTextNode(t)),this},dx:function(t){return this.attr("dx",t)},dy:function(t){return this.attr("dy",t)},newLine:function(){return this.newLined=!0,this.parent.content+="\n",this.dy(this.parent._leading),this.attr("x",this.parent.x())}}),SVG.TextPath=function(){this.constructor.call(this,SVG.create("textPath"))},SVG.TextPath.prototype=new SVG.Element,SVG.extend(SVG.Text,{path:function(t){for(this.textPath=new SVG.TextPath;this.node.hasChildNodes();)this.textPath.node.appendChild(this.node.firstChild);return this.node.appendChild(this.textPath.node),this.track=this.doc().defs().path(t,!0),this.textPath.parent=this,this.textPath.attr("href","#"+this.track,SVG.xlink),this},plot:function(t){return this.track&&this.track.plot(t),this}}),SVG.Nested=function(){this.constructor.call(this,SVG.create("svg")),this.style("overflow","visible")},SVG.Nested.prototype=new SVG.Container,SVG.extend(SVG.Container,{nested:function(){return this.put(new SVG.Nested)}}),SVG._stroke=["color","width","opacity","linecap","linejoin","miterlimit","dasharray","dashoffset"],SVG._fill=["color","opacity","rule"];var e=function(t,e){return"color"==e?t:t+"-"+e};["fill","stroke"].forEach(function(t){var i={};i[t]=function(i){if("string"==typeof i||SVG.Color.isRgb(i)||i&&"function"==typeof i.fill)this.attr(t,i);else for(index=SVG["_"+t].length-1;index>=0;index--)null!=i[SVG["_"+t][index]]&&this.attr(e(t,SVG["_"+t][index]),i[SVG["_"+t][index]]);return this},SVG.extend(SVG.Element,SVG.FX,i)}),SVG.extend(SVG.Element,SVG.FX,{rotate:function(t,e,i){return this.transform({rotation:t||0,cx:e,cy:i})},skew:function(t,e){return this.transform({skewX:t||0,skewY:e||0})},scale:function(t,e){return this.transform({scaleX:t,scaleY:null==e?t:e})},translate:function(t,e){return this.transform({x:t,y:e})},matrix:function(t){return this.transform({matrix:t})},opacity:function(t){return this.attr("opacity",t)}}),SVG.Text&&SVG.extend(SVG.Text,SVG.FX,{font:function(e){for(var i in e)"anchor"==i?this.attr("text-anchor",e[i]):t.indexOf(i)>-1?this.attr("font-"+i,e[i]):this.attr(i,e[i]);return this}}),SVG.Set=function(){this.clear()},SVG.SetFX=function(t){this.set=t},SVG.extend(SVG.Set,{add:function(){var t,e,i=[].slice.call(arguments);
for(t=0,e=i.length;e>t;t++)this.members.push(i[t]);return this},remove:function(t){var e=this.members.indexOf(t);return e>-1&&this.members.splice(e,1),this},each:function(t){for(var e=0,i=this.members.length;i>e;e++)t.apply(this.members[e],[e,this.members]);return this},clear:function(){return this.members=[],this},valueOf:function(){return this.members}}),SVG.Set.inherit=function(){var t,e=[];for(var t in SVG.Shape.prototype)"function"==typeof SVG.Shape.prototype[t]&&"function"!=typeof SVG.Set.prototype[t]&&e.push(t);e.forEach(function(t){SVG.Set.prototype[t]=function(){for(var e=0,i=this.members.length;i>e;e++)this.members[e]&&"function"==typeof this.members[e][t]&&this.members[e][t].apply(this.members[e],arguments);return"animate"==t?this.fx||(this.fx=new SVG.SetFX(this)):this}}),e=[];for(var t in SVG.FX.prototype)"function"==typeof SVG.FX.prototype[t]&&"function"!=typeof SVG.SetFX.prototype[t]&&e.push(t);e.forEach(function(t){SVG.SetFX.prototype[t]=function(){for(var e=0,i=this.set.members.length;i>e;e++)this.set.members[e].fx[t].apply(this.set.members[e].fx,arguments);return this}})},SVG.extend(SVG.Container,{set:function(){return new SVG.Set}}),SVG.extend(SVG.Element,{remember:function(t,e){if("object"==typeof arguments[0])for(var e in t)this.remember(e,t[e]);else{if(1==arguments.length)return this.memory()[t];this.memory()[t]=e}return this},forget:function(){if(0==arguments.length)this._memory={};else for(var t=arguments.length-1;t>=0;t--)delete this.memory()[arguments[t]];return this},memory:function(){return this._memory||(this._memory={})}}),"function"==typeof define&&define.amd?define(function(){return SVG}):"undefined"!=typeof exports&&(exports.SVG=SVG)}.call(this);
/*
Author: Braden Kowitz
Requires: svg.js jquery
*/

var GVGraph = GVGraph || {};

GVGraph.render = function() {
  $("gvgraph").each(function(i,el){
    var src = $(el).attr("data-src");
    $.getJSON(src, function(data) {
      $(el).empty();
      var g = new GVGraph.Graph(el);
      g.fromJSON(data);
    });
    $(this).on("mousedown", function(e) {
      e.preventDefault();
    });
  });
};

$(window).on('navigated', function() {
  GVGraph.render();
});
$(function() {
  GVGraph.render();
});

GVGraph.Vector = function(_x, _y) {
  
  this.x = _x || 0;
  this.y = _y || 0;
  
  this.dist = function(vector) {
    var dx = this.x - vector.x;
    var dy = this.y - vector.y;
    return Math.sqrt(dx*dx + dy*dy);
  };

  this.minus = function(vector) {
    return new GVGraph.Vector(
      this.x - vector.x,
      this.y - vector.y);
  };
  
  this.scale = function(scale) {
    this.x *= scale;
    this.y *= scale;
  };
  
  this.apply = function(vector) {
    this.x += vector.x;
    this.y += vector.y;
  };

};


GVGraph.Node = function(_x, _y, _draw) {
  
  Node.radius = 8;
  Node.hoverRadius = 50;
  
  this.pos = new GVGraph.Vector(_x,_y);
  this.home = new GVGraph.Vector(_x,_y);
  
  var draw = _draw;
  
  this.isAttachedToCursor = false;
  
  var set = draw.set();
  var hoverEl = draw.circle(Node.hoverRadius).attr({ fill: 'transparent' });
  var dotEl = draw.circle(Node.radius);
  set.add(hoverEl, dotEl);
  set.center(this.pos.x, this.pos.y);
  
  this.distFromHome = function() {
    return this.pos.dist(this.home);
  };
  
  this.dist = function(node) {
    return this.pos.dist(node.pos);
  };
  
  this.attachStyle = function() {
    dotEl.fill("#eee").stroke("#999");
    this.isAttachedToCursor = true;
  };
  
  this.detachStyle = function() {
    dotEl.fill("#fff").stroke("#ccc");
    this.isAttachedToCursor = false;
  };
  this.detachStyle();
  
  this.redraw = function() {
    set.center(this.pos.x, this.pos.y);
  };
  
};


GVGraph.Edge = function(_n1, _n2, _draw) {
  var draw = _draw;
  this.n1 = _n1;
  this.n2 = _n2;
  this.homeLength = this.n1.home.dist(this.n2.home);
  var el = draw.line(this.n1.pos.x, this.n1.pos.y, this.n2.pos.x, this.n2.pos.y);
  el.stroke({width: 1, color:"#eee"});
  
  this.redraw = function() {
    el.attr({
      x1: this.n1.pos.x,
      y1: this.n1.pos.y,
      x2: this.n2.pos.x,
      y2: this.n2.pos.y
    });
  };
  
  this.length = function() {
    return this.n1.pos.dist(this.n2.pos);
  };
  
};


GVGraph.Graph = function(elementOrId) {
  
  var draw = new SVG(elementOrId);
  var edgeGroup = draw.group();
  var nodeGroup = draw.group();
  
  this.nodes = [];
  this.edges = [];
  this.physics = new GVGraph.Physics(this, draw);
  var width, height;
  
  this.size = function(_width, _height) {
    width = _width;
    height = _height;
    draw.size(_width, _height);
    draw.parent.style.width = width + 'px';
    draw.parent.style.height = height + 'px';
  };
  
  this.clear = function() {
    edgeGroup.clear();
    nodeGroup.clear();
    this.nodes = [];
    this.edges = [];
  };
  
  this.addNode = function(x, y) {
    var n = new GVGraph.Node(x, y, nodeGroup);
    this.nodes.push(n);
    return n;
  };
    
  this.addEdge = function(n1, n2) {
    var e = new GVGraph.Edge(n1, n2, edgeGroup);
    this.edges.push(e);
    return e;
  };
  
  this.redraw = function() {
    for (var n in this.nodes) {
      this.nodes[n].redraw();
    }
    for (var e in this.edges) {
      this.edges[e].redraw();
    }
  };
  
  this.fromJSON = function(json) {
    this.clear();
    this.size(json.width, json.height);
    var nodeObjs = {};
    for (var n in json.nodes) {
      var newNode = this.addNode(
        json.nodes[n].x,
        json.nodes[n].y
        );
      nodeObjs[n] = newNode;
    }
    for (var e in json.edges) {
      this.addEdge(
        nodeObjs[json.edges[e].n1],
        nodeObjs[json.edges[e].n2]
        );
    }
  };
  
};

GVGraph.Cursor = function(graphEl) {
  
  var self = this;
  this.graphEl = $(graphEl);
  this.pos = new GVGraph.Vector(0, 0);
  this.mouseDown = false;
  this.mousePresent = false;
  this.onmouseleave = null;
  this.onmouseenter = null;
  this.onmousemove = null;
  
  this.graphEl.on("mousemove", function(e) {
    if (e.offsetX !== undefined) {
      self.pos.x = e.offsetX;
      self.pos.y = e.offsetY;
      self.mousePresent = true;
      if (self.onmousemove) { self.onmousemove(); }
    }
  });
  
  this.graphEl.on("mousedown ", function() {
    self.mouseDown = true;
  });
  
  this.graphEl.on("mouseup ", function() {
    self.mouseDown = false;
  });
  
  this.graphEl.on("mouseenter ", function() {
    self.mousePresent = true;
    if (self.onmouseenter) { self.onmouseenter(); }
  });
  
  this.graphEl.on("mouseleave ", function() {
    self.mouseDown = false;
    self.mousePresent = false;
    if (self.onmouseleave) { self.onmouseleave(); }
  });

};

GVGraph.Physics = function(_graph, _draw) {
  
  this.autoStart = true;
  this.clickForce = 0.4;
  this.hoverForce = 0.02;
  this.homeForce = 0.25;
  this.edgeForce = 0.2;
  this.hoverDistance = 100;
  this.clickDistance = 30;
  this.timeTillStop = 1000;
  
  var self = this;
  var graph = _graph;
  var draw = _draw;
  var cursor = new GVGraph.Cursor(draw.parent);
  
  // Forces
  this.applyCursorForce = function(node) {
    if (cursor.mousePresent) {
      var diff = cursor.pos.minus(node.pos);
      var dist = cursor.pos.dist(node.pos);
      if (cursor.mouseDown) {
        if (node.isAttachedToCursor) {
          diff.scale(this.clickForce);
          node.pos.apply(diff);
        }
        else if (dist<this.hoverDistance) {
          diff.scale(this.hoverForce);
          node.pos.apply(diff);
        }
      }
      else {
        if (dist<this.clickDistance) {
          node.attachStyle();
        }
        else {
          node.detachStyle();
        }
        if (dist<this.hoverDistance) {
          diff.scale(this.hoverForce);
          node.pos.apply(diff);
        }
      }
    }
  };
  
  cursor.onmouseleave = function() {
    for (var n in graph.nodes) {
      graph.nodes[n].detachStyle();
    }
    if (self.autoStart) { self.stopIn(self.timeTillStop); }
  };
  
  cursor.onmouseenter = function() {
    if (self.autoStart) { self.start(); }
  };
  
  cursor.onmousemove = function() {
    if (self.autoStart) {
      self.start();
      self.stopIn(self.timeTillStop);
    }
  };
  
  this.applyHomeForce = function(node) {
    var diff = node.home.minus(node.pos);
    diff.scale(this.homeForce);
    node.pos.apply(diff);
  };
  
  this.applyEdgeForce = function(edge) {
    var force = edge.n1.pos.minus(edge.n2.pos);
    var length = edge.length();
    var stretch = length - edge.homeLength;
    // unitize and scale the force
    force.scale( this.edgeForce * stretch / length);
    edge.n2.pos.apply(force);
    force.scale(-1);
    edge.n1.pos.apply(force);
  };
  
  // animation loop setup
  var stepTime = 1000.0 / 30;
  var running = false;
  var animationTimer = null;
  var stopTimer = null;
  this.stop = function() {
    running = false;
    if (animationTimer) { clearTimeout(animationTimer); }
    animationTimer = null;
  };
  this.start = function() {
    if (running) { return; }
    running = true;
    if (animationTimer) { clearTimeout(animationTimer); }
    if (stopTimer) { clearTimeout(stopTimer); }
    animationTimer = setTimeout(nextStep, stepTime);
  };
  var nextStep = function() {
    if (running) {
      self.step();
      animationTimer = setTimeout(nextStep, stepTime);
    }
  };
  this.step = function() {
    for (var n in graph.nodes) {
      var node = graph.nodes[n];
      this.applyCursorForce(node);
      this.applyHomeForce(node);
    }
    for (var e in graph.edges) {
      this.applyEdgeForce(graph.edges[e]);
    }
    graph.redraw();
  };
  this.stopIn = function(msec) {
    if (!running) { return; }
    if (stopTimer) { clearTimeout(stopTimer); }
    stopTimer = setTimeout(self.stop, msec);
  };
  
};

