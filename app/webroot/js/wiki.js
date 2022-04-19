function freezeEvent(e){if(e.preventDefault)e.preventDefault();e.returnValue=false;e.cancelBubble=true;if(e.stopPropagation)e.stopPropagation();return false;}
function isWithinNode(e,i,c,t,obj){answer=false;te=e;while(te&&!answer){if((te.id&&(te.id==i))||(te.className&&(te.className==i+"Class"))||(!t&&c&&te.className&&(te.className==c))||(!t&&c&&te.className&&(te.className.indexOf(c)!=-1))||(t&&te.tagName&&(te.tagName.toLowerCase()==t))||(obj&&(te==obj))){answer=te;}else{te=te.parentNode;}}
return te;}
function getEvent(event){return(event?event:window.event);}
function getEventElement(e){return(e.srcElement?e.srcElement:(e.target?e.target:e.currentTarget));}
function findElementPosX(obj){curleft=0;if(obj.offsetParent){while(obj.offsetParent){curleft+=obj.offsetLeft;obj=obj.offsetParent;}}
else if(obj.x)
curleft+=obj.x
return curleft;}
function findElementPosY(obj){curtop=0;if(obj.offsetParent){while(obj.offsetParent){curtop+=obj.offsetTop;obj=obj.offsetParent;}}
else if(obj.y)
curtop+=obj.y
return curtop;}
function handleKeyPress(event){e=getEvent(event);eL=getEventElement(e);upEl=isWithinNode(eL,null,"wickEnabled",null,null);kc=e["keyCode"];if(siw&&((kc==13)||(kc==9))){siw.selectingSomething=true;if(siw.isSafari)siw.inputBox.blur();siw.inputBox.focus();siw.inputBox.value=siw.inputBox.value.replace(/[ \r\n\t\f\s]+$/gi,' ');hideSmartInputFloater();}else if(upEl&&(kc!=38)&&(kc!=40)&&(kc!=37)&&(kc!=39)&&(kc!=13)&&(kc!=27)){if(!siw||(siw&&!siw.selectingSomething)){processSmartInput(upEl);}}else if(siw&&siw.inputBox){siw.inputBox.focus();}}
function handleKeyDown(event){e=getEvent(event);eL=getEventElement(e);if(siw&&(kc=e["keyCode"])){if(kc==40){siw.selectingSomething=true;freezeEvent(e);if(siw.isGecko)siw.inputBox.blur();selectNextSmartInputMatchItem();}else if(kc==38){siw.selectingSomething=true;freezeEvent(e);if(siw.isGecko)siw.inputBox.blur();selectPreviousSmartInputMatchItem();}else if((kc==13)||(kc==9)){siw.selectingSomething=true;activateCurrentSmartInputMatch();freezeEvent(e);}else if(kc==27){hideSmartInputFloater();freezeEvent(e);}else{siw.selectingSomething=false;}}}
function handleFocus(event){e=getEvent(event);eL=getEventElement(e);if(focEl=isWithinNode(eL,null,"wickEnabled",null,null)){if(!siw||(siw&&!siw.selectingSomething))processSmartInput(focEl);}}
function handleBlur(event){e=getEvent(event);eL=getEventElement(e);if(blurEl=isWithinNode(eL,null,"wickEnabled",null,null)){if(siw&&!siw.selectingSomething)hideSmartInputFloater();}}
function handleClick(event){e2=getEvent(event);eL2=getEventElement(e2);if(siw&&siw.selectingSomething){selectFromMouseClick();}}
function handleMouseOver(event){e=getEvent(event);eL=getEventElement(e);if(siw&&(mEl=isWithinNode(eL,null,"matchedSmartInputItem",null,null))){siw.selectingSomething=true;selectFromMouseOver(mEl);}else if(isWithinNode(eL,null,"siwCredit",null,null)){siw.selectingSomething=true;}else if(siw){siw.selectingSomething=false;}}
function showSmartInputFloater(){if(!siw.floater.style.display||(siw.floater.style.display=="none")){if(!siw.customFloater){x=findElementPosX(siw.inputBox);y=findElementPosY(siw.inputBox)+siw.inputBox.offsetHeight;if(!siw.isGecko&&!siw.isWinIE)x+=8;if(!siw.isGecko&&!siw.isWinIE)y+=10;siw.floater.style.left=x;siw.floater.style.top=y;}else{}
siw.floater.style.display="block";siw.floater.style.visibility="visible";}}
function hideSmartInputFloater(){if(siw){siw.floater.style.display="none";siw.floater.style.visibility="hidden";siw=null;}}
function processSmartInput(inputBox){if(!siw)siw=new smartInputWindow();siw.inputBox=inputBox;classData=inputBox.className.split(" ");siwDirectives=null;for(i=0;(!siwDirectives&&classData[i]);i++){if(classData[i].indexOf("wickEnabled")!=-1)
siwDirectives=classData[i];}
if(siwDirectives&&(siwDirectives.indexOf(":")!=-1)){siw.customFloater=true;newFloaterId=siwDirectives.split(":")[1];siw.floater=document.getElementById(newFloaterId);siw.floaterContent=siw.floater.getElementsByTagName("div")[0];}
setSmartInputData();if(siw.matchCollection&&(siw.matchCollection.length>0))selectSmartInputMatchItem(0);content=getSmartInputBoxContent();if(content){modifySmartInputBoxContent(content);showSmartInputFloater();}else hideSmartInputFloater();}
function smartInputMatch(cleanValue,value){this.cleanValue=cleanValue;this.value=value;this.isSelected=false;}
function simplify(s){return s.toLowerCase().replace(/^[ \s\f\t\n\r]+/,'').replace(/[ \s\f\t\n\r]+$/,'');}
function getUserInputToMatch(s){a=s;fields=s.split(",");if(fields.length>0)a=fields[fields.length-1];return a;}
function getUserInputBase(){s=siw.inputBox.value;a=s;if((lastComma=s.lastIndexOf(","))!=-1){a=a.replace(/^(.*\,[ \r\n\t\f\s]*).*$/i,'$1');}
else
a="";return a;}
function runMatchingLogic(userInput,standalone){userInput=simplify(userInput);uifc=userInput.charAt(0).toLowerCase();if(uifc=='"')uifc=(n=userInput.charAt(1))?n.toLowerCase():"z";if(standalone)userInput=uifc;if(siw)siw.matchCollection=new Array();pointerToCollectionToUse=collection;if(siw&&siw.revisedCollection&&(siw.revisedCollection.length>0)&&siw.lastUserInput&&(userInput.indexOf(siw.lastUserInput)==0)){pointerToCollectionToUse=siw.revisedCollection;}else if(collectionIndex[userInput]&&(collectionIndex[userInput].length>0)){pointerToCollectionToUse=collectionIndex[userInput];}else if(collectionIndex[uifc]&&(collectionIndex[uifc].length>0)){pointerToCollectionToUse=collectionIndex[uifc];}else if(siw&&(userInput.length==1)&&(!collectionIndex[uifc])){siw.buildIndex=true;}else if(siw){siw.buildIndex=false;}
tempCollection=new Array();re1m=new RegExp("^([ \"\>\<\-]*)("+userInput+")","i");re2m=new RegExp("([ \"\>\<\-]+)("+userInput+")","i");re1=new RegExp("^([ \"\}\{\-]*)("+userInput+")","gi");re2=new RegExp("([ \"\}\{\-]+)("+userInput+")","gi");for(i=0,j=0;(i<pointerToCollectionToUse.length);i++){displayMatches=((!standalone)&&(j<siw.MAX_MATCHES));entry=pointerToCollectionToUse[i];mEntry=simplify(entry);if(!standalone&&(mEntry.indexOf(userInput)==0)){userInput=userInput.replace(/\>/gi,'\\}').replace(/\< ?/gi,'\\{');re=new RegExp("("+userInput+")","i");if(displayMatches){siw.matchCollection[j]=new smartInputMatch(entry,mEntry.replace(/\>/gi,'}').replace(/\< ?/gi,'{').replace(re,"<b>$1</b>"));}
tempCollection[j]=entry;j++;}else if(mEntry.match(re1m)||mEntry.match(re2m)){if(!standalone&&displayMatches){siw.matchCollection[j]=new smartInputMatch(entry,mEntry.replace(/\>/gi,'}').replace(/\</gi,'{').replace(re1,"$1<b>$2</b>").replace(re2,"$1<b>$2</b>"));}
tempCollection[j]=entry;j++;}}
if(siw){siw.lastUserInput=userInput;siw.revisedCollection=tempCollection.join(",").split(",");collectionIndex[userInput]=tempCollection.join(",").split(",");}
if(standalone||siw.buildIndex){collectionIndex[uifc]=tempCollection.join(",").split(",");if(siw)siw.buildIndex=false;}}
function setSmartInputData(){if(siw){orgUserInput=siw.inputBox.value;orgUserInput=getUserInputToMatch(orgUserInput);userInput=orgUserInput.toLowerCase().replace(/[\r\n\t\f\s]+/gi,' ').replace(/^ +/gi,'').replace(/ +$/gi,'').replace(/ +/gi,' ').replace(/\\/gi,'').replace(/\[/gi,'').replace(/\(/gi,'').replace(/\./gi,'\.').replace(/\?/gi,'');if(userInput&&(userInput!="")&&(userInput!='"')){runMatchingLogic(userInput);}
else{siw.matchCollection=null;}}}
function getSmartInputBoxContent(){a=null;if(siw&&siw.matchCollection&&(siw.matchCollection.length>0)){a='';for(i=0;i<siw.matchCollection.length;i++){selectedString=siw.matchCollection[i].isSelected?' selectedSmartInputItem':'';a+='<p class="matchedSmartInputItem' + selectedString +'" onmouseup="javascript:handleClick()">' +siw.matchCollection[i].value.replace(/\{ */gi,"&lt;").replace(/\} */gi,"&gt;")+'</p>';}}
return a;}
function modifySmartInputBoxContent(content){siw.floaterContent.innerHTML='<div id="smartInputResults">'+content+(siw.showCredit?('<p class="siwCredit">Powered By: <a target="_blank" href="http://andolasoft.com?from=smartinput&ref='+escape(location.href)+'">Andola soft</a></p>'):'')+'</div>';siw.matchListDisplay=document.getElementById("smartInputResults");}
function selectFromMouseOver(o){currentIndex=getCurrentlySelectedSmartInputItem();if(currentIndex!=null)deSelectSmartInputMatchItem(currentIndex);newIndex=getIndexFromElement(o);selectSmartInputMatchItem(newIndex);modifySmartInputBoxContent(getSmartInputBoxContent());}
function selectFromMouseClick(){activateCurrentSmartInputMatch();siw.inputBox.focus();var el=$("#members_list").get(0);var elemLen=el.value.length;el.selectionStart=elemLen;el.selectionEnd=elemLen;el.focus();hideSmartInputFloater();}
function getIndexFromElement(o){index=0;while(o=o.previousSibling){index++;}
return index;}
function getCurrentlySelectedSmartInputItem(){answer=null;for(i=0;((i<siw.matchCollection.length)&&!answer);i++){if(siw.matchCollection[i].isSelected)
answer=i;}
return answer;}
function selectSmartInputMatchItem(index){siw.matchCollection[index].isSelected=true;}
function deSelectSmartInputMatchItem(index){siw.matchCollection[index].isSelected=false;}
function selectNextSmartInputMatchItem(){currentIndex=getCurrentlySelectedSmartInputItem();if(currentIndex!=null){deSelectSmartInputMatchItem(currentIndex);if((currentIndex+1)<siw.matchCollection.length)
selectSmartInputMatchItem(currentIndex+1);else
selectSmartInputMatchItem(0);}else{selectSmartInputMatchItem(0);}
modifySmartInputBoxContent(getSmartInputBoxContent());}
function selectPreviousSmartInputMatchItem(){currentIndex=getCurrentlySelectedSmartInputItem();if(currentIndex!=null){deSelectSmartInputMatchItem(currentIndex);if((currentIndex-1)>=0)
selectSmartInputMatchItem(currentIndex-1);else
selectSmartInputMatchItem(siw.matchCollection.length-1);}else{selectSmartInputMatchItem(siw.matchCollection.length-1);}
modifySmartInputBoxContent(getSmartInputBoxContent());}
function activateCurrentSmartInputMatch(){baseValue=getUserInputBase();if((selIndex=getCurrentlySelectedSmartInputItem())!=null){addedValue=siw.matchCollection[selIndex].cleanValue;valiedemail=addedValue.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);theString=(baseValue?baseValue:"")+valiedemail[0]+", ";siw.inputBox.value=theString;runMatchingLogic(addedValue,true);}}
function smartInputWindow(){this.customFloater=false;this.floater=document.getElementById("smartInputFloater");this.floaterContent=document.getElementById("smartInputFloaterContent");this.selectedSmartInputItem=null;this.MAX_MATCHES=15;this.isGecko=(navigator.userAgent.indexOf("Gecko/200")!=-1);this.isSafari=(navigator.userAgent.indexOf("Safari")!=-1);this.isWinIE=((navigator.userAgent.indexOf("Win")!=-1)&&(navigator.userAgent.indexOf("MSIE")!=-1));this.showCredit=false;}
function registerSmartInputListeners(){texts=document.getElementsByTagName("textarea");allinputs=new Array();z=0;y=0;while(texts[y]){allinputs[z]=texts[y];z++;y++;}
for(i=0;i<allinputs.length;i++){if((c=allinputs[i].className)&&(c=="wickEnabled")){allinputs[i].setAttribute("autocomplete","OFF");allinputs[i].onfocus=handleFocus;allinputs[i].onblur=handleBlur;allinputs[i].onkeydown=handleKeyDown;allinputs[i].onkeyup=handleKeyPress;}}}
function debug(s){ds+=(s+"\n");}