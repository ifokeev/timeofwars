/////////////////////////////
// Basic browser detection
//
 var ie = ((document.all)&&(!document.getSelection)) ? 1 : 0;
 var nn = (document.layers) ? 1 : 0;
 var n6 = (window.sidebar) ? 1 : 0;
 var opera = ((document.all)&&(document.getSelection))? 1:0;
 //lang - ето раздел, в котором юзер находится в данный момент



function getSelectedText(){
        if (ie || opera){
                return document.selection.createRange().text;
        }

        if (nn){
                var s;
                if (typeof(window.getSelection)=="function"){
                   s = window.getSelection();
                }else{
                   s = document.getSelection();
                }

                return s;
        }

        return "Upgrade your browser pls !";
}

function Insert(name){
        var input = document.getElementById("Post");
        input.value = input.value+"[quote]"+name+"[/quote]";
}

function klan(thevalue) {
        var input = document.getElementById("Post");
        input.value += "[clan="+thevalue+"[/clan]";
        input.focus();
}



function makeCodeOption(langID,langName){
var html = '<li value="0" onClick="ubbCodeSource(\''+langID+'\')">'+langName+'</li>';
return html;
}

function ubbCodeSource(value) {
var code="";
if(value==null)code = '[code]\n' + getText() + '\n[/code]';
else
code = '[code=' + value + ']\n' + getText() + '\n[/code]';

ubbCode(code);

}

/////////////////////////////
// Stylesheet output
//
function writeStyle() {
var html = '<style type="text/css"><!--\n';
html += '.ibcButton { font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; background-color:#cccccc;  }\n';
html += '.ubbcButton { font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; background-color:#ececec;}\n';
html += '.codeSelect{ vertical-align: middle; font-size:12px; font-weight: bold; font-style:italic; font-family:Verdana, Arial, Helvetica, sans-serif; background-color:#cccccc; width: 90px ;height:22px;}\n';
html += '.ibcSelect{ font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; background-color:#cccccc;  }\n';
html += '.ibcButton { font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; background-color:#ececec; }\n';
html += '.button, button { vertical-align: middle; font-size:12px; font-weight: bold; font-style:italic; font-family:Verdana, Arial, Helvetica, sans-serif; background-color:#cccccc; width: 68px ;height:22px;}\n';
html += '@media all{html>body button{height:auto;position:relative;display:inline;}}';
html += '.button{padding:.4em .8em;height:2em;}';
html += '.button:hover{text-decoration:none;}';
html += 'button.hasdefaultstate{'+(window.opera?('top:10;'):'')+' vertical-align: middle;background:url(http://us.i1.yimg.com/us.yimg.com/i/us/pim/r/medici/all/bt_s_dd_2.gif) no-repeat right center;padding-right:22px;height:22px;background-color:#D6D6CE;}';
html += '.buttonmenu{top:0;left:0;z-index:2;position:absolute;visibility:hidden;border-style:solid;border-width:1px;font:verdana;}';
html += 'html>body .buttonmenu{width:1%;}';
html += '@media all{html>body .buttonmenu{width:auto;}}';
html += '.buttonmenu strong{display:none;}';
html += '.buttonmenu ul{margin:0;list-style:none;padding:.5em;}';
html += '.buttonmenu li{padding:.25em;border-width:1px;border-style:solid;cursor:pointer;cursor:hand;}';
html += '.buttonmenu li a:hover{text-decoration:none;}';
html += 'html>body .buttonmenu ul{float:left;}';
html += '@media all{html>body .buttonmenu ul{float:none;width:auto;}}';
html += '.buttonmenu li a, .buttonmenu li a:hover{color:#333;}';
html += '.buttonmenu{border-color:#C1C1C1;background-color:#F6F6F6;}';
html += '.buttonmenu li, #movemenu li{border-color:#F6F6F6;}';
html += '.buttonmenu li.hover, #movemenu li.hover, .buttonmenu li:hover, #movemenu li:hover{background-color:#E6E6E6;border-color:#C1C1C1;}';
html += ' --></style>';

document.write(html);
}

/////////////////////////////
// Interface output
//
function makeInterface(images,flash,graphical,lang,viewurl,viewimg) {
var html = '<table border="0" cellpadding="2" cellspacing="0"><tr><td align=center>' + ((nn) ? '&nbsp;' : '');
html += '</td></tr><tr><td align=center>' + ((nn) ? '&nbsp;' : '');
if (graphical) {
html +=makeTranslitEnabler()+makeImage('/pixel.gif',3,1,'');
html += makeLink("ubbBasic('b');",'Жирный[B]') + makeImage('/bold.gif','23','22','Жирный[B]') + '</a>';
html += makeLink("ubbBasic('i');",'Наклонный[I]') + makeImage('/italics.gif','23','22','Наклонный[I]') + '</a>';
html += makeLink("ubbBasic('u');",'Подчёркнутый[U]') + makeImage('/underline.gif','23','22','Подчёркнутый[U]') + '</a>';
html += makeLink("ubbBasic('s');",'Зачёркнутый[S]') + makeImage('/strikethrough.gif','23','22','Зачёркнутый[S]') + '</a>';
} else {
html +=makeTranslitEnabler();
html += makeButton("ubbBasic('b');",' B ','Жирный[B]','b') + makeImage('/pixel.gif',1,1,'');
html += makeButton("ubbBasic('i');",' I ','Наклонный[I]','i') + makeImage('/pixel.gif',1,1,'');
html += makeButton("ubbBasic('u');",' U ','Подчёркнутый[U]','u') + makeImage('/pixel.gif',1,1,'');
html += makeButton("ubbBasic('s');",' S ','Зачёркнутый[S]','s');
}
if (graphical) {
html += makeLink("Insert(getSelectedText());",'Цитата[Q]') + makeImage('/quote_ru.gif','64','22','Цитата[Q]') + '</a>';
} else {
html += makeButton("Insert(getSelectedText());",'Quote','Цитата[Q]','q') + makeImage('/pixel.gif',1,1,'');
}
if (graphical) {
if (viewurl==1) {html += makeLink("ubbBasic('url');",'Ссылка [H]') + makeImage('/url.gif','23','22','Ссылка [H]') + '</a>';}
html += makeLink("ubbBasic('email');",'[E]mail]') + makeImage('/email.gif','23','22','[E]mail') + '</a>';
if (viewimg==1) {html += ((images) ? makeLink("ubbImage();",'Картинка[P]') + makeImage('/image.gif','23','22','Картинка[P]') + '</a>' : '');}
} else {
if (viewurl==1) {html += makeButton("ubbBasic('url');",'URL','Ссылка [H]','h') + makeImage('/pixel.gif',1,1,'');}
//html += makeButton("ubbBasic('email');",' @ ','[E]mail','e') + makeImage('/email.gif',1,1,'');
if (viewimg==1) {html += ((images) ? makeButton("ubbImage();",'IMG','Картинка[P]','p') + makeImage('/pixel.gif',1,1,'') : '');}
}


html += ' <select name="talign" class="ibcSelect" onchange="ubbAlign(this.options[this.selectedIndex].value);">';
html += makeOption('','Выравнивание',0);
html += makeOption('left','По левому краю',0);
html += makeOption('center','По центру',0);
html += makeOption('right','По правому краю',0);
html += '</select> ';

html += ' <select class="ibcSelect" onchange="klan(this.options[this.selectedIndex].value)">';
html += makeOption('','Клан',0);
aaa=0;
while(k[aaa]){
html += makeOption(k[aaa][0]+']'+k[aaa][1], k[aaa][1],0);
aaa++;
}
k=[];
html += '</select> ';
html += '<select name="fcolor" class="ibcSelect" onchange="ubbFont(this);">';
html += makeOption('','Цвет',0);
html += makeOption('skyblue','Светло-голубой',1);
html += makeOption('royalblue','Голубой',1);
html += makeOption('blue','Синий',1);
html += makeOption('darkblue','Тёмно-синий',1);
html += makeOption('orange','Оранжевый',1);
html += makeOption('orangered','Морковный',1);
html += makeOption('crimson','Бордовый',1);
html += makeOption('red','Красный',1);
html += makeOption('firebrick','Кирпичный',1);
html += makeOption('darkred','Коричневый',1);
html += makeOption('green','Зелёный',1);
html += makeOption('limegreen','Салатовый',1);
html += makeOption('seagreen','Болотный',1);
html += makeOption('deeppink','Розовый',1);
html += makeOption('tomato','Томатный',1);
html += makeOption('coral','Coral',1);
html += makeOption('purple','Сиреневый',1);
html += makeOption('indigo','Фиолетовый',1);
html += makeOption('burlywood','Горчичный',1);
html += makeOption('sandybrown','Песчаный',1);
html += makeOption('sienna','Кофейный',1);
html += makeOption('chocolate','Шоколадный',1);
html += makeOption('teal','Морской',1);
html += makeOption('silver','Серебряный',1);
html += '</select> ';

html += '</td></tr></table>';
document.write(html);
}

function chaosalign(align)
{
     var input = document.getElementById("Post");
     input.value += '[align]'+align+'[/align]';
}

//Ето рекция на событие листа
function ubbSource(list) {
    var attrib = list.name.substring(1,list.name.length);
    var value = list.options[list.selectedIndex].value;
    if (value && attrib) {
    //Вот code можно форматировать как тебе угодно :)
    //        например var code = '[' + value + ']' + getText() + '[/' + value + ']';
    //если хочеж, чтобы теги были [java]dfgsdfgsdfg[/java]
      var code = '[' + attrib + '=' + value + ']' + getText() + '[/' + attrib + ']';
      ubbCode(code);
    }
    resetList(list.name);
}

/////////////////////////////
// Code inserter
//
function ubbCode(code) {
/*Для эксплорера оставим как было*/
if(ie){
 if (form["Post"].createTextRange && form["Post"].caretPos)
 {
   var caretPos = form["Post"].caretPos;
   caretPos.text = code;
 } else { form["Post"].value += code; }
 }
else  /*пошёл нетскейп/мозилла*/
if(n6) {
     var post=form["Post"];

/*Тут делим техт из поста на две части 1) до выборки 2) после выборки*/
     var firstPart=post.value.substring(0,post.selectionStart);
     var lastPart=post.value.substr(post.selectionEnd);

/*ну и запишем правильный текст обратно в пост*/
     post.value=firstPart+code+lastPart;

/*Возвращаем курсор на место */
     var post=form["Post"];
     post.selectionStart=selStart+code.length;
     post.selectionEnd=post.selectionStart;
     post.scrollTop=scrTop;
     }
     else{form["Post"].value += code;}

 form["Post"].focus();
}

/////////////////////////////
// HTML shortcuts
//
//Graph elements for translit
function checkTheBox() {
kodirovka=document.getElementById("EnableTranslit").checked;
deleteCookie("translit");
setCookie ("translit", kodirovka);
var post=form["Post"];
post.selectionStart=selStart;
post.selectionEnd=selEnd;
post.focus();

}
function makeTranslitEnabler() {
  var checked=(getCookie ("translit")=="true")?true:false;

  kodirovka=checked;
  var html= 'транслит <input type="checkbox" name="translit" class="checkbox" id="EnableTranslit" '+(checked==true?('checked="true"'):(''))+' onClick="checkTheBox();">';


  return html;
}


  function makeButton(onclick,value,title,accesskey) {
    var html = '<input type="button" onclick="' + onclick;
       html += 'return false;" title="' + title;
       html += '" accesskey="' + accesskey + '" class="ubbcButton';
       html += '" value="' + value + '">';
    return html;
  }

  function makeLink(onclick,text) {
    var html = '<a href="#" onclick="' + onclick;
       html += 'return false;" onmouseover="return winStat(\'' + text;
       html += '\');" onmouseout="return winStat(\'\');">';
    return html;
  }

  function makeImage(source,width,height,alt) {
    var html = '<img src="' + ubbc_dir + source + '" width="' + width;
       html += '" height="' + height + '" border="0" alt="' + alt;
       html += '" align="absmiddle">';
    return html;
  }

  function makeOption(value,text,style) {
    var html = '<option value="' + value;
       html += ((style && ie) ? '" style="font-size:12px;color:' + value : '');
       html += '">' + text + '</option>';
    return html;
  }


/////////////////////////////
// Misc utils
//
//С помощью этих переменных нетскейп запоминает позицию в тексте
var selStart=0;
var selEnd=0;
var scrTop=0;

function storeCaret(el)
{
  if(ie)
  {
     if (el.createTextRange)
     {
       el.caretPos = document.selection.createRange().duplicate();
     }
    }else
    if(n6)
    {//Тут добавлено сохранение позиции
      var post=form["Post"];
      selStart=post.selectionStart;
      selEnd=post.selectionEnd;
      scrTop=post.scrollTop;
    }
}


function getText() {
 /*Для эксплорера оставим как было.*/
        if (ie) {
          return ((form["Post"].createTextRange && form["Post"].caretPos) ? form["Post"].caretPos.text : '');
        }
  /*пошёл нетскейп/мозилла*/
        if(n6) {
        var post=form["Post"];
         return post.value.substr(post.selectionStart,post.selectionEnd-post.selectionStart);
        }
 /*Тут незнакомый броузер так было раньше для всех, кроме эксплорера*/
        return '';
}

  function isUrl(text) {
    return ((text.indexOf('.') > 7) &&
            ((text.substring(0,7) == 'http://') ||
            (text.substring(0,6) == 'ftp://')));
  }

  function isEmail(str) {
    if (!reSupport) { return (str.indexOf(".") > 2) && (str.indexOf("@") > 0); }
    var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
    var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)$");
    return (!r1.test(str) && r2.test(str));
  }

  function winStat(txt) {
    window.status = txt;
    return true;
  }

  function returnFocus() {
    setTimeout('form["Post"].focus()',10);
  }

  function resetList(list) {
    setTimeout('form["'+list+'"].options[0].selected = true',10);
  }

  function ubbHelp() {
    var url = ubbc_dir + '/help/index.htm';
    var options = 'height=350,width=300,scrollbars=yes';
    window.open(url,'ubbc_help',options);
  }

function ubbSmile() {
    var url = 'http://mysmilies.com';
    var options = 'scrollbars=yes';
    window.open(url);
  }

  function removeElement(array,value) {
    array = array.split(',');
    for (i = 0; i < array.length; i++) {
      if (array[i] == value) { var pos = i; break; }
    }
    for (i = pos; i < (array.length-1); i++) {
      array[i] = array[i + 1];
    }
    array.length = array.length - 1;
    return array.join(',');
  }

/*
functions for cookies
*/

function setCookie (name, value, expires, path, domain, secure) {
  var curCookie = name + "=" + escape(value) +
      ((expires) ? ";expires=" + expires : "") +
      ((path) ? ";path=" + path : "") +
      ((domain) ? ";domain=" + domain : "") +
      ((secure) ? ";secure" : "");
  if ((escape(value)).length <= 4000) document.cookie = curCookie+";";
}

function getCookie (name) {
  var prefix = name + "=";
  var cookieStartIndex = document.cookie.indexOf(prefix);
  if (cookieStartIndex == -1) return null;
  var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length);
  if (cookieEndIndex == -1) cookieEndIndex = document.cookie.length;
  return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex));
}

function deleteCookie (name, path, domain) {
  if (getCookie(name)) {
      document.cookie = name + "=" +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") + "; expires=Thu, 01-Jan-99 00:00:01 GMT"
  }
}


/////////////////////////////
// Indivdual code types
//
  var openTags = new Array('');
  var closedTags = new Array('dummy','b','i','u','s','code','quote','me','list');
  function ubbBasic(code) {
    var text = getText();
    if (text) {
      code = '[' + code + ']' + text + '[/' + code + ']';
      ubbCode(code);
    } else {
      if (openTags.join(',').indexOf(','+code) != -1) {
        var tag = '[/' + code + ']';
        openTags = removeElement(openTags.join(','),code).split(',');
        closedTags[closedTags.length] = code;
      } else {
        var tag = '[' + code + ']';
        closedTags = removeElement(closedTags.join(','),code).split(',');
        openTags[openTags.length] = code;
      } ubbCode(tag);
    }
  }

  function ubbFont(list) {
    var attrib = list.name.substring(1,list.name.length);
    var value = list.options[list.selectedIndex].value;
    if (value && attrib) {
      var code = '[' + attrib + '=' + value + ']' + getText() + '[/' + attrib + ']';
      ubbCode(code);
    }
    resetList(list.name);
  }

 function ubbAlign(align) {
    if (!align) { return; }
    code = '[align=' + align + ']' + getText() + '[/align]';
    ubbCode(code);
    resetList("talign");
  }


  function ubbList(size) {
    var text = getText();
    if (!size && !text) { ubbBasic('list'); }
    else if (!size && text && reSupport) {
      var regExp = /\n/g;
      text = text.replace(regExp,'\n[*]');
      var code = '[list]\n[*]' + text + '\n[/list]\n';
      ubbCode(code);
    } else {
      if (text) { text += '\n'; }
      var code = text + '[list]\n';
      for (i = 0; i < size; i++) { code += '[*]\n'; }
      code += '[/list]\n';
      ubbCode(code);
      resetList("quicklist");
    }
  }

  function ubbListItem() {
    var code = '[*]' + getText();
    ubbCode(code);
  }

  function ubbHref() {
    var url = 'http://'; var desc = '';
    var text = getText();
    if (text) {
      if (isUrl(text)) { url = text; }
      else { desc = text; }
    }
    url = prompt('Введите ссылку:',url) || '';
    desc = prompt('Описание ссылки:',desc) || url;
    if (!isUrl(url)) { returnFocus(); return; }
    var code = '[url=' + url + ']' + desc + '[/url]';
    ubbCode(code);
  }

  function ubbEmail() {
    var email = ''; var desc = '';
    var text = getText();
    if (text) {
      if (isEmail(text)) { email = text; }
      else { desc = text; }
    }
    email = prompt('Введите E-mail адрес:',email) || '';
    desc = prompt('Введите описание:',desc) || email;
    if (!isEmail(email)) { returnFocus(); return; }
    var code = '[email=' + email + ']' + desc + '[/email]';
    ubbCode(code);
  }

  function ubbImage() {
    var text = getText();
    var url = (text && isUrl) ? text : prompt("\nВведите URL картинки:","http://") || "";
    if (!url) { return; }
    var code = "[IMG]" + url + "[/IMG]";
    ubbCode(code);
  }



  function ubbFlash() {
    var url = 'http://'; var h = ''; var w = '';
    var text = getText();
    if (text && isUrl(text)) { url = text; text = ''; }
    url = prompt('Введите URL Flash объекта:',url) || '';
    w = prompt('Введите ширину Flash:\nMax = '+flash_w, w) || '';
    h = prompt('Введите высоту Flash:\nMax = '+flash_h, h) || '';
    if (isNaN(w) || (w > flash_w)) { w = flash_w; }
    if (isNaN(h) || (h > flash_h)) { h = flash_h; }
    if (!isUrl(url)) { returnFocus(); return; }
    var code = ((text) ? text + ' ' : '') + '[flash=' + w + ',' + h + ']' + url + '[/flash]';
    ubbCode(code);
  }


function ubbGlow() {
    var color = ''; var write = '';
    var text = getText();
    if (text && isUrl(text)) { url = text; text = ''; }
    color = prompt('Введите цвет свечения:',color) || '';
    write = prompt('Введите текст:',write) || '';
    var code = ((text) ? text + ' ' : '') + '[glow=' + color + ']' + write + '[/glow]';
    ubbCode(code);
  }

  function ubbShadow() {
    var color = ''; var write = '';
    var text = getText();
    if (text && isUrl(text)) { url = text; text = ''; }
    color = prompt('Введите цвет тени:',color) || '';
    write = prompt('Введите текст:',write) || '';
    var code = ((text) ? text + ' ' : '') + '[shadow=' + color + ']' + write + '[/shadow]';
    ubbCode(code);
  }

  function ubbSpoil() {
    var write = '';
    var text = getText();
    if (text && isUrl(text)) { url = text; text = ''; }
    write = prompt('Введите скрываемый текст:',write) || '';
    var code = ((text) ? text + ' ' : '') + '[spoiler]' + write + '[/spoiler]';
    ubbCode(code);
  }

  function ubbsound() {
    var text = getText();
    var url = (text && isUrl) ? text : prompt("\nВведите URL звука:","http://") || "";
    if (!url) { return; }
    var code = '[sound]' + url + '[/sound]';
    ubbCode(code);
  }

  function ubbvideo() {
    var text = getText();
    var url = (text && isUrl) ? text : prompt("\nВведите URL видео:","http://") || "";
    if (!url) { return; }
    var code = '[video]' + url + '[/video]';
    ubbCode(code);
  }

  function ubbweb() {
    var text = getText();
    var url = (text && isUrl) ? text : prompt("\nВведите ссылку копируемого сайта:","http://") || "";
    if (!url) { return; }
    var code = '[web]' + url + '[/web]';
    ubbCode(code);
  }



//========================- Special Browser Detection -===================
function getOperaVersion() {
  var opver=navigator.userAgent.match(/Opera\s*([0-9.]+)/i);
  return (opver&&opver.length>1)? parseFloat(opver[1]): 0;
}

//============================- Hot Key's -============================

HotKeyHandler.keys = {};
HotKeyHandler.convertIEKey={"1":65,"2":66,"4":68,"12":76,"16":80,"19":83,"20":84,"21":85,"26":90};
function HotKeyHandler(ev) {
          var evt, key;
        if(!(evt=window.event? window.event: ev)) return;
        key = evt.keyCode? evt.keyCode: evt.charCode;
        key=HotKeyHandler.convertIEKey[String(key)]? HotKeyHandler.convertIEKey[String(key)]: key;
    if ((evt && evt.ctrlKey)||key==27) { //ctr key or ESC
            key=evt.shiftKey? String.fromCharCode(key).toUpperCase(): String.fromCharCode(key).toLowerCase();
            if(typeof(HotKeyHandler.keys[key]) == "function"){
               HotKeyHandler.keys[key](evt);
                   evt.cancelBubble = true;
           evt.returnValue = false;
                   if(evt.preventDefault) evt.preventDefault();
                   if(evt.stopPropagation) evt.stopPropagation();
           return false;
                }
    }
    return true;
}

//Default init.
HotKeyHandler.init=function(obj) {
   if(!obj) obj=document;
   if(obj.addEventListener && (getOperaVersion()>6||getOperaVersion()==0)) {
     obj.addEventListener("keypress", HotKeyHandler, false);
   } else {
     //FIXME: IE DOM2 Event patch is off, so traditional event model is used
         //it's not possible to have two document.onkeydown handlers!

         //ensureAddEventListener(document);
         //document.addEventListener("keydown", HotKeyHandler, false);
         obj.onkeydown=HotKeyHandler;
   }
}

function Forum_Hotkey_init() {
    HotKeyHandler.keys = {
      "\r":function() {form.submitPost();},
      "b":function(){ubbBasic('b');},
      "i":function(){ubbBasic('i');},
      "u":function(){ubbBasic('u');},
      "S":function(){ubbBasic('s');},

      "h":ubbHref,
      "e":ubbEmail,
      "p":ubbImage,
      "q":function(){ubbBasic('quote');},
          "m":function(){ubbBasic('me');},
          "g":function(){ubbBasic('code')},
          "k":ubbListItem,
          "l":ubbList
//      "\x1B":onswitchkod //esc, translit
    };

    HotKeyHandler.init();
}


/////////////////////////////
// Replacing default iB JS
//
  function emoticon(theSmilie) {
    var text = getText() + ' ';
    var code = text + theSmilie + ' ';
    ubbCode(code);
  }


/////////////////////////////
// Initilization
//
  var form;
  writeStyle();
  var reSupport = 0;
  function ubbcInit(images,flash,graphical,lang) {
    form = document.forms["REPLIER"];
    form['submitPost']=form.submit;
    if (graphical) Forum_Hotkey_init();

    if (window.RegExp) {
      var tempStr = "a";
      var tempReg = new RegExp(tempStr);
      if (tempReg.test(tempStr)) { reSupport = 1; }
    }
  }

  function check_submit(formS,event_)
  {
/*
 var k=event_.keyCode;
        if(k==13)
        {
         if(event_.ctrlKey)
        {
                document.forms['REPLIER'].submit()
        }
         }  */
}




/*
Dobavka ;-)
*/
function Reply_Click()
{

        var oEvent = this.Event;
        var nOffsetX = (oEvent.layerX) ? (oEvent.layerX) : oEvent.offsetX;

        if(nOffsetX > (this.offsetWidth-22))
        {
                if(this.Menu.opened)
                {
                HideMenu();
                this.Menu.opened=false;
                }
                else
                {
                        //HideMenu();
                        this.Menu.Show();
                }
        }else
        {
                HideMenu();
         this.saveclick();
        }

};

function ylib_getPageX(o) {
         var x=0;
         if(nold)
         x=o.pageX;
         else
          {
                  while(eval(o))
                  {
                          x+=o.offsetLeft; o=o.offsetParent;
                  }
          }
          return x;
};
var nold=false;
function ylib_getPageY(o) {  var y=0; if(nold) y=o.pageY; else { while(eval(o)) { y+=o.offsetTop; o=o.offsetParent; } } return y; };

/*Click on menu*/
function Menu_Click(p_oEvent)
{
        var oEvent = p_oEvent ? p_oEvent : window.event;
        var oSender = p_oEvent ? oEvent.target : oEvent.srcElement;
        if(p_oEvent) oEvent.stopPropagation();
        else oEvent.cancelBubble = true;
        this.Sender = oSender;
        this.Event = oEvent;
        HideMenu();
};
/*For IE and hover menu issues*/
function Menu_MouseOver(p_oEvent)
{
        var oEvent = p_oEvent ? p_oEvent : window.event;
        var oSender = p_oEvent ? oEvent.target : oEvent.srcElement;

        if(oSender.tagName == 'LI') oSender.className = 'hover';
        else if(oSender.tagName == 'A') oSender.parentNode.className = 'hover';
        else return false;
};

function Menu_MouseOut(p_oEvent)
{
        var oEvent = p_oEvent ? p_oEvent : window.event;
        var oSender = p_oEvent ? oEvent.target : oEvent.srcElement;

        if(oSender.tagName == 'LI') oSender.className = '';
        else if(oSender.tagName == 'A') oSender.parentNode.className = '';
        else return false;
};

/*Handle the button click*/
function Button_Click(p_oEvent)
{

        var oEvent = p_oEvent ? p_oEvent : window.event;
        var oSender = p_oEvent ? oEvent.target : oEvent.srcElement;

        if(p_oEvent) oEvent.stopPropagation();
        else oEvent.cancelBubble = true;

        this.Event = oEvent;
        this.Sender = oSender;

        this.Menu.Button = this;
        g_oMenu = this.Menu;

        if(typeof this.ClickHandler != 'undefined') this.ClickHandler();
        else g_oMenu.Show();

        document.onclick = Document_Click;
};

function ButtonMenu(p_sMenuId, p_oClickHandler)
{
        var oMenu = document.getElementById(p_sMenuId);

        if(oMenu)
        {
        oMenu.opened=false;
                if(typeof p_oClickHandler != 'undefined') oMenu.ClickHandler = p_oClickHandler;

                oMenu.Show = function () {
                        if(document.all) this.style.width = this.offsetWidth+'px';
                        oMenu.opened=true;
                        this.style.top = ylib_getPageY(this.Button)+this.Button.offsetHeight+'px';
                        this.style.left = ylib_getPageX(this.Button)+'px';
                        this.style.visibility = 'visible';
                };

                oMenu.onclick = Menu_Click;

                if(document.all)
                {
                        oMenu.onmouseover = Menu_MouseOver;
                        oMenu.onmouseout = Menu_MouseOut;
                }

                return oMenu;
        }
        else return false;
};

function Button(p_sButtonId)
{
        var oButton = document.getElementById(p_sButtonId);

        if(oButton)
        {
                oButton.saveclick=oButton.onclick;
                oButton.onclick = Button_Click;
                return oButton;
        }
        else return false;
};

function MenuButton(p_sButtonId, p_sMenuId)
{
                var oButton = new Button(p_sButtonId);

                if(oButton)
                {

                        oButton.ClickHandler = Reply_Click;
                        oButton.Menu = new ButtonMenu(p_sMenuId, null);
                        return oButton;
                }
        else return false;
};

function HideMenu()
{
        if(typeof g_oMenu != 'undefined' && g_oMenu)
        {
                g_oMenu.opened=false;
                g_oMenu.style.visibility = 'hidden';
                g_oMenu = null;
                document.onclick = null;
                window.onresize = null;
        }
        else return;
};

function Document_Click()
{
        if(document.Selects)
        {
                var nSelects = document.Selects.length-1;
                for(var i=nSelects;i>=0;i--) document.Selects[i].style.visibility = 'visible';
        }

        HideMenu();
};
