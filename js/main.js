function a_click()
{
   if (event.shiftKey) {
   		top.frames['bar'].window.document.forms[0].text.focus();
		  top.frames['bar'].document.forms[0].text.value = 'private ['+event.srcElement.innerText+'] '+top.frames['bar'].document.forms[0].text.value;
   } else {
 			top.frames['bar'].window.document.forms[0].text.focus();
  		top.frames['bar'].document.forms[0].text.value = 'to ['+event.srcElement.innerText+'] '+top.frames['bar'].document.forms[0].text.value;
   }
   event.returnValue = false
   return false;
}

function dlogin(name, level, align, clan){
	var s="";
	var rank = 0;
	var alpict="";
	if( align < 10 ){
		switch(align){
			case 0: alpict="#5A5AA1"; break;
			case 1: alpict="#D9A7A7"; break;
			case 2: alpict="#A7D9A7"; break;
			case 3: alpict="#A7D9D2"; break;
			//
			case 4: alpict="#5A5AA1"; break;
			case 5: alpict="#5A5AA1"; break;
		}
	}else if( clan > 0 && clan != 200 ){

		rank = (align - clan*10);

		rank = (rank > 0) ? rank : 0;
		align = 0;

	}else{

		align = 0;
	}

	if( clan > 0 ){

		s += "<A HREF='/top5.php?show="+clan+"' target=_blank>";

		if( rank != 0 ){

			s+="<IMG SRC='http://admin.dnlab.ru/images/clan/rank/"+clan+"_"+rank+".gif' WIDTH=24 HEIGHT=15 ALT='' border='0'>";

		}else{

			s+="<IMG SRC='http://admin.dnlab.ru/images/clan/"+clan+".gif' WIDTH=24 HEIGHT=15 ALT='' border='0'></A>";
		}

	}else{
		//(clan=="0")
		s+="<IMG SRC='http://admin.dnlab.ru/images/1pix.gif' WIDTH=24 HEIGHT=15 ALT='' border='0'>";
	}

	s += "<a href='javascript:top.AddToPrivate(\""+name+"\",true)'>"

	if( align==0 ){
		s += ""+name+" ["+level+"]";
	}else{
		s += "<FONT style='BACKGROUND-COLOR: "+alpict+"'>"+name+"</font> ["+level+"]";
	}

	s += "</a>";

  	s+="<A HREF='/inf.php?uname="+name+"' target='_blank'><IMG SRC='http://admin.dnlab.ru/images/inf.gif' WIDTH=12 HEIGHT=12 ALT='Инф. о "+name+"' border='0'></A>";

	/*
	if (level!=-1) s+="["+level+"]";
	s+="<A HREF='/inf.php?uname="+name+"' target='_blank'><IMG SRC='http://admin.dnlab.ru/images/inf.gif' WIDTH=12 HEIGHT=12 ALT='Инф. о "+name+"' border='0'></A>";
	*/
  	document.write(s);
}


var delay    = 6;
var delay2   = 3;
var redHP    = 0.33;
var yellowHP = 0.66;
var TimerOn  = -1;
var tkHP, maxHP;

function setHP(value, max) {
	tkHP=value; maxHP=max;
	if (TimerOn>=0) { clearTimeout(TimerOn); TimerOn=-1; }
	setHPlocal();
}
function setHP2(value, max) {
	tkHP=value; maxHP=max;
	if (TimerOn>=0) { clearTimeout(TimerOn); TimerOn=-1; }
	setHPlocal2();
}
function setHPlocal() {
	if (tkHP>maxHP) { tkHP=maxHP; }
	var sz1 = Math.round((149/maxHP)*tkHP);
	var sz2 = 150 - sz1;
	if (top.frames['TOP'].document.getElementById("HP")) {
		top.frames['TOP'].document.getElementById('HP1').width=sz1;
		top.frames['TOP'].document.getElementById('HP2').width=sz2;
		if (tkHP/maxHP < redHP) { top.frames['TOP'].document.getElementById('HP1').src='http://admin.dnlab.ru/images/hpred.gif'; }
		else {
			if (tkHP/maxHP < yellowHP) { top.frames['TOP'].document.getElementById('HP1').src='http://admin.dnlab.ru/images/hpyellow.gif'; }
			else { top.frames['TOP'].document.getElementById('HP1').src='http://admin.dnlab.ru/images/hpgreen.gif'; }
		}
		var s = top.frames['TOP'].document.getElementById("HP").innerHTML;
		top.frames['TOP'].document.getElementById("HP").innerHTML = s.substring(0, s.lastIndexOf(':')+1) + Math.round(tkHP)+"/"+maxHP;
	}
	tkHP = (tkHP+(maxHP/100));
	if (tkHP<maxHP) { TimerOn=setTimeout('setHPlocal()', delay*1000); }
	else { TimerOn=-1; }
}
function setHPlocal2() {
	if (tkHP>maxHP) { tkHP=maxHP; }
	var sz1 = Math.round((149/maxHP)*tkHP);
	var sz2 = 150 - sz1;
	if (top.frames['TOP'].document.getElementById("HP")) {
		top.frames['TOP'].document.getElementById('HP1').width=sz1;
		top.frames['TOP'].document.getElementById('HP2').width=sz2;
		if (tkHP/maxHP < redHP) { top.frames['TOP'].document.getElementById('HP1').src='http://admin.dnlab.ru/images/hpred.gif'; }
		else {
			if (tkHP/maxHP < yellowHP) { top.frames['TOP'].document.getElementById('HP1').src='http://admin.dnlab.ru/images/hpyellow.gif'; }
			else { top.frames['TOP'].document.getElementById('HP1').src='http://admin.dnlab.ru/images/hpgreen.gif'; }
		}
		var s = top.frames['TOP'].document.getElementById("HP").innerHTML;
		top.frames['TOP'].document.getElementById("HP").innerHTML = s.substring(0, s.lastIndexOf(':')+1) + Math.round(tkHP)+"/"+maxHP;
	}
	tkHP = (tkHP+(maxHP/100));
	if (tkHP<maxHP) { TimerOn=setTimeout('setHPlocal2()', delay2*1000); }
	else { TimerOn=-1; }
}

function hlth(CurHP,MaxHP){
var tmp;
var tmp2;
var cl;
var s;
var leng=10;
var leng2;
var tmp3;

tmp = MaxHP / 3;
if (CurHP < tmp){cl="hpred";}
tmp2 = tmp * 2;
if ((CurHP <= tmp2)&&(CurHP >= tmp)){cl="hpyellow";}
if (CurHP >= tmp2){cl="hpgreen";}
leng = 150 * CurHP / MaxHP;
leng2=150-leng;
s="   <IMG height=10 alt=\"Уровень жизни\" src=\"http://admin.dnlab.ru/images/"+cl+".gif\" width="+leng+" border=0>";
s+="<IMG height=10 alt=\"Уровень жизни\" src=\"http://admin.dnlab.ru/images/hpsilver.gif\" width="+leng2+"border=0>:"+CurHP+"/"+MaxHP;
s+="<IMG height=10 alt=\"Уровень жизни\"  src=\"http://admin.dnlab.ru/images/herz.gif\" width=10>";
document.write(s);
}

function inverse(id)
{
  elem=document.getElementById(id);
  if (elem.style.display=="none")
  {
    elem.style.display="";
  }
  else
  {
    elem.style.display="none";
  }
}
