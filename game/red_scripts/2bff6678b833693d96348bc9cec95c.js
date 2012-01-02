function countdown(b,a){if(a==null||a==""){a=2}var d=this;d.timestamp=0;d.maxDigits=a;d.delimiter=" ";d.approx="";d.showunits=true;d.zerofill=false;var c=new Date();d.startTime=c.getTime();d.startLeftoverTime=b;this.getCurrentTimestring=function(){return d.formatTime(d.getLeftoverTime())};this.getLeftoverTime=function(){var e=new Date();return Math.round((d.startLeftoverTime-(e.getTime()-d.startTime)/1000))};this.formatTime=function(j){a=d.maxDigits;var h=new Array;h.day=86400;h.hour=3600;h.minute=60;h.second=1;var g=new Array;g.day=d.showunits?LocalizationStrings.timeunits["short"].day:"";g.hour=d.showunits?LocalizationStrings.timeunits["short"].hour:"";g.minute=d.showunits?LocalizationStrings.timeunits["short"].minute:"";g.second=d.showunits?LocalizationStrings.timeunits["short"].second:"";var i="";for(var f in h){var e=Math.floor(j/h[f]);if(a>0&&(e>0||d.zerofill&&i!="")){j=j-e*h[f];if(i!=""){i+=d.delimiter;if(e<10&&e>0&&d.zerofill){e="0"+e}if(e==0){e="00"}}i+=e+g[f];a--}}if(j>0){i=d.approx+i}return i}}function bauCountdown(d,c,b,a){if(typeof(d)=="object"){var e=this;e.totalTime=b;e.startHeight=d.offsetHeight;e.htmlObj=d;e.timeHtmlObj=getChildNodeWithClassName(d,"time");this.updateCountdown=function(){e.countdown.getCurrentTimestring();timestamp=e.countdown.getLeftoverTime();timestring=e.countdown.getCurrentTimestring();e.timeHtmlObj.innerHTML=timestring;var f=Math.max(0,timestamp)/e.totalTime;if(f>0){height=Math.round(e.startHeight*(1-(f)));e.htmlObj.style.height=height+"px";e.htmlObj.style.marginBottom="-"+height+"px"}else{e.timeHtmlObj.innerHTML=LocalizationStrings.status.ready;height=e.startHeight;e.htmlObj.style.height=height+"px";e.htmlObj.style.marginBottom="-"+height+"px";if(timestamp<=-1&&timestamp>-10&&!tb_is_open()){reload_page(a)}}};if(e.timeHtmlObj){e.countdown=new countdown(c);timerHandler.appendCallback(e.updateCountdown);e.updateCountdown()}else{window.status="kein timeHtmlObj"}}}function schiffbauCountdown(e,b,g,d,c,a){if(typeof(e)=="object"){var f=this;f.totalTime=c;f.oneShipTime=c;f.shipCount=b;f.currentShips=g;f.startHeight=e.offsetHeight;f.htmlObj=e;f.timeHtmlObj=getChildNodeWithClassName(e,"time");f.countHtmlObj=getChildNodeWithClassName(e.parentNode,"count");f.shipsHtmlObj=getChildNodeWithClassName(e.parentNode,"level");this.updateCountdown=function(){f.countdown.getCurrentTimestring();timestamp=f.countdown.getLeftoverTime();timestring=f.countdown.getCurrentTimestring();f.replaceInnerHTML(f.timeHtmlObj,timestring);var h=Math.max(0,timestamp)/f.totalTime;if(h>0){height=Math.round(f.startHeight*(1-(h)));f.htmlObj.style.height=height+"px";f.htmlObj.style.marginBottom="-"+height+"px"}else{if(f.shipCount>0){f.shipCount--;f.currentShips++}if(f.shipCount>=0){f.replaceInnerHTML(f.countHtmlObj,f.shipCount);if(typeof document.getElementById("shipcount")!="undefined"){document.getElementById("shipcount").innerHTML=f.shipCount}}f.replaceInnerHTML(f.shipsHtmlObj,gfNumberGetHumanReadable(f.currentShips));if(f.shipCount>0){f.countdown=new countdown(c);f.replaceInnerHTML(f.timeHtmlObj,"-")}else{timerHandler.removeCallback(f.timer);f.replaceInnerHTML(f.timeHtmlObj,LocalizationStrings.status.ready)}}};this.replaceInnerHTML=function(i,j){var h=document.createTextNode(j);if(i.firstChild){i.firstChild.deleteData(0,20);i.firstChild.appendData(h.nodeValue)}};if(f.timeHtmlObj&&f.countHtmlObj&&f.shipsHtmlObj){totalTime=Math.floor(b*c);f.countdown=new countdown(d);f.timer=timerHandler.appendCallback(f.updateCountdown);f.updateCountdown()}else{window.status="kein: timeHtmlObj oder countHtmlObj oder shipsHtmlObj"}}}function baulisteCountdown(c,b,a){if(typeof(c)=="object"){var d=this;d.timeHtmlObj=c;this.updateCountdown=function(){d.countdown.getCurrentTimestring();timestamp=d.countdown.getLeftoverTime();timestring=d.countdown.getCurrentTimestring();if(timestamp>0){d.timeHtmlObj.innerHTML=timestring}else{d.timeHtmlObj.innerHTML=LocalizationStrings.status.ready;if(timestamp<=-1&&timestamp>-10){if(a!=null&&timestamp>-10&&!tb_is_open()){reload_page(a)}}}};if(d.timeHtmlObj){d.countdown=new countdown(b,3);timerHandler.appendCallback(d.updateCountdown);d.updateCountdown()}}}function eventboxCountdown(b,a){if(typeof(b)=="object"){var c=this;c.timeHtmlObj=b;this.updateCountdown=function(){c.countdown.getCurrentTimestring();timestamp=c.countdown.getLeftoverTime();timestring=c.countdown.getCurrentTimestring();if(timestamp>0){c.timeHtmlObj.innerHTML=timestring}else{timerHandler.removeCallback(c.timer);c.timeHtmlObj.innerHTML=LocalizationStrings.status.ready;setTimeout("checkEventList()",2500)}};if(c.timeHtmlObj){c.countdown=new countdown(a,3);c.timer=timerHandler.appendCallback(c.updateCountdown);c.updateCountdown()}}}function simpleCountdown(d,a,c,b){if(typeof(d)=="object"){var e=this;e.timeHtmlObj=d;this.updateCountdown=function(){e.countdown.getCurrentTimestring();timestamp=e.countdown.getLeftoverTime();timestring=e.countdown.getCurrentTimestring();if(timestamp>0){e.timeHtmlObj.innerHTML=timestring;if($.isFunction(b)){b(timestamp)}}else{timerHandler.removeCallback(e.timer);e.timeHtmlObj.innerHTML=LocalizationStrings.status.ready;if(typeof c=="string"&&$.isFunction(window[c])){window[c]()}else{if($.isFunction(c)){c()}}}};if(e.timeHtmlObj){e.countdown=new countdown(a,3);e.timer=timerHandler.appendCallback(e.updateCountdown);e.updateCountdown()}}}function reloadCountdown(c,b,a){if(typeof(c)=="object"){var d=this;d.timeHtmlObj=c;this.updateCountdown=function(){d.countdown.getCurrentTimestring();timestamp=d.countdown.getLeftoverTime();timestring=d.countdown.getCurrentTimestring();if(timestamp>0){d.timeHtmlObj.innerHTML=timestring}else{d.timeHtmlObj.innerHTML=LocalizationStrings.status.ready;if(timestamp<=-2&&timestamp>-10&&!tb_is_open()){reload_page(a)}}};if(d.timeHtmlObj){d.countdown=new countdown(b,3);timerHandler.appendCallback(d.updateCountdown);d.updateCountdown()}}}function movementImageCountdown(e,c,d,a,b){if(typeof(e)=="object"){var f=this;f.timeHtmlObj=e;this.updateCountdown=function(){f.countdown.getCurrentTimestring();timestamp=f.countdown.getLeftoverTime();timestring=f.countdown.getCurrentTimestring();if(timestamp>0){percent=100-Math.floor(timestamp/(d/100));if(!a){pixel=Math.abs((274/100)*percent)}else{pixel=548-Math.abs((548/100)*percent)}if(b){f.timeHtmlObj.style.marginRight=pixel+"px"}else{f.timeHtmlObj.style.marginLeft=pixel+"px"}}};if(f.timeHtmlObj){f.countdown=new countdown(c,3);timerHandler.appendCallback(f.updateCountdown);f.updateCountdown()}}}function shipCountdown(c,f,i,d,a,h,g,e){if((typeof(c)=="object")&&(typeof(f)=="object")&&(typeof(i)=="object")){var b=this;b.totalTimeHtmlObj=c;b.unitTimeHtmlObj=f;b.sumCountHtmlObj=i;this.updateCountdown=function(){b.unitCountdown.getCurrentTimestring();unitTimestamp=b.unitCountdown.getLeftoverTime();unitTimestring=b.unitCountdown.getCurrentTimestring();b.totalCountdown.getCurrentTimestring();totalTimestamp=b.totalCountdown.getLeftoverTime();totalTimestring=b.totalCountdown.getCurrentTimestring();if(unitTimestamp>0){b.unitTimeHtmlObj.innerHTML=unitTimestring}else{g--;b.unitTimeHtmlObj.innerHTML=LocalizationStrings.status.ready;if(g>0){b.unitCountdown=new countdown(d);b.sumCountHtmlObj.innerHTML=g}else{b.sumCountHtmlObj.innerHTML=0}}if(g>0){b.totalTimeHtmlObj.innerHTML=totalTimestring}else{b.totalTimeHtmlObj.innerHTML=LocalizationStrings.status.ready;if(!tb_is_open()){reload_page(e)}}};if((b.totalTimeHtmlObj)&&(b.unitTimeHtmlObj)&&(b.sumCountHtmlObj)){b.totalCountdown=new countdown(h);b.unitCountdown=new countdown(a);timerHandler.appendCallback(b.updateCountdown);b.updateCountdown()}}}reloaded=0;function reload_page(a){if(reloaded==0){location.href=a;reloaded++}};