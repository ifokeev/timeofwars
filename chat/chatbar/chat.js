var allchat = '';
var new_msg = '';
var chatlen = '60';
var startmsg = '';
var newmsgs = '';
var i2 = '';

var map_en = new Array('s`h','S`h','S`H','s`е','sh`','Sh`','SH`',"'o",'yo',"'O",'Yo','YO','zh','w','Zh','ZH','W','ch','Ch','CH','sh','Sh','SH','e`','E`',"'u",'yu',"'U",'Yu',"YU","'a",'ya',"'A",'Ya','YA','a','A','b','B','v','V','g','G','d','D','e','E','z','Z','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','r','R','s','S','t','T','u','U','f','F','h','H','c','C','`','y','Y',"'")
var map_ru = new Array('ёѕ','бѕ','бе','ёе','љ','й','й','И','И','Ј','Ј','Ј','ц','ц','Ц','Ц','Ц','ї','з','з','ј','и','и','§','н','ў','ў','о','о','о','џ','џ','п','п','п','р','Р','с','С','т','Т','у','У','ф','Ф','х','Х','ч','Ч','ш','Ш','щ','Щ','ъ','Ъ','ы','Ы','ь','Ь','э','Э','ю','Ю','я','Я','№','а','ё','б','ђ','в','ѓ','г','є','д','ѕ','е','і','ж','њ','ћ','л','ќ')

function convert(str){
for(var i=0;i<map_en.length;++i) while(str.indexOf(map_en[i])>=0) str = str.replace(map_en[i],map_ru[i]);
return str;
}

function translate(msg) {
var strarr = new Array();
strarr = msg.split(' ');
for(var k=0;k<strarr.length;k++) {
if(strarr[k].indexOf("http://") < 0 && strarr[k].indexOf('@') < 0 && strarr[k].indexOf("www.") < 0 && !(strarr[k].charAt(0)==":" && strarr[k].charAt(strarr[k].length-1)==":")) {
if ((k<strarr.length-1)&&(strarr[k]=="to" || strarr[k]=="private")&&(strarr[k+1].charAt(0)=="[")) {
while ( (k<strarr.length-1) && (strarr[k].charAt(strarr[k].length-1)!="]") ) k++;
} else { strarr[k] = convert(strarr[k]) }
}
}
return strarr.join(' ');
}