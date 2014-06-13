function SET(login){
document.all("Post").focus();
document.all("Post").value = '[B]'+login+'[/B],'+document.all("Post").value;
}

function dlogin(name, level, align, clan){
var s="";
var rank = 0;
if( clan > 0 ){
s += "<A HREF='../top5.php?show="+clan+"' target=_blank>";
if( rank != 0 ){ s+="<IMG SRC='http://admin.dnlab.ru/images/clan/rank/"+clan+"_"+rank+".gif' WIDTH=24 HEIGHT=15 ALT='' border='0'>"; }
else{ s+="<IMG SRC='http://admin.dnlab.ru/images/clan/"+clan+".gif' WIDTH=24 HEIGHT=15 ALT='' border='0'></A>"; }
}else{
s+="<IMG SRC='http://admin.dnlab.ru/images/1pix.gif' WIDTH=24 HEIGHT=15 ALT='' border='0'>";
}

s += "<a href='javascript:SET(\""+name+"\",true)'>"
 s += "<B>"+name+"</B>";
s += "</a>  ["+level+"]";
s+="<A HREF='../inf.php?uname="+name+"' target='_blank'><IMG SRC='http://admin.dnlab.ru/images/inf.gif' WIDTH=12 HEIGHT=12 ALT='Èíô. î "+name+"' border='0'></A>";
document.write(s);
}

