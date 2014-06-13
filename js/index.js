function imover(im) {im.filters.Alpha.Enabled=false;}
function imout(im) {im.filters.Alpha.Enabled=true;}
function imouti(im) {im.filters.Alpha.opacity=60;}
function imoveri(im) {im.filters.Alpha.opacity=80;}

 <!--
    var t=0,timer;
 function pos_Top(obj){
    pos_T = obj.offsetTop;
    while(obj.offsetParent!=null)
    {
     pos_T+=obj.offsetParent.offsetTop;
 obj = obj.offsetParent;
    }
    return pos_T;
    }

 function pos_Left(obj){
  pos_L = obj.offsetLeft;
    while(obj.offsetParent!=null)
    {
     pos_L+=obj.offsetParent.offsetLeft;
 obj = obj.offsetParent;
    }
    return pos_L;
    }

 function TRV_param(){
 document.getElementById('tabs').style.display = "block";
 t=0;
 cur=document.getElementById('pos_tab')
 document.getElementById('tabs').width = 287;

 document.getElementById('pos_tab').height = 360;
 document.getElementById('trv_box').style.width = document.getElementById('tabs').width-50;
 b=eval(document.getElementById('pos_tab').height-16)
 document.getElementById('trv_box').style.clip = "rect("+t+" "+document.getElementById('trv_box').style.width+" "+b+" 0)";
 document.getElementById('trv_box').style.position = "absolute";
 document.getElementById('trv_box').style.textAlign = "justify";
 document.getElementById('trv_box').style.height = "auto";
 document.getElementById('trv_box').style.posLeft = pos_Left(cur)+15;
 document.getElementById('trv_box').style.posTop =  pos_Top(cur)+40;

 document.getElementById('trv_top').style.posLeft = pos_Left(cur)+271;
 document.getElementById('trv_top').style.posTop =  pos_Top(cur)+40;

 document.getElementById('trv_bot').style.posLeft = pos_Left(cur)+271;
 document.getElementById('trv_bot').style.posTop =  pos_Top(cur)+330;
 top_text_move = document.getElementById('trv_box').offsetHeight - (pos_Top(cur)+cur.offsetHeight-5)
 bot_text_move = pos_Top(cur)+10
     top_text_move*=-1;
 }



 function top_text(){
 t+=1;
 b+=1;
     if(document.getElementById('trv_box').style.posTop >= top_text_move){
 document.getElementById('trv_box').style.posTop-=1;
 document.getElementById('trv_box').style.clip="rect("+t+" "+document.getElementById('trv_box').style.width+" "+b+" 0)";
 timer=setTimeout("top_text()",10); } else{topSpeed()}
 }

 function bot_text(){
 t-=1;
 b-=1;
    if(document.getElementById('trv_box').style.posTop<=bot_text_move){
 document.getElementById('trv_box').style.posTop+=1;
 document.getElementById('trv_box').style.clip="rect("+t+" "+document.getElementById('trv_box').style.width+" "+b+" 0)";
 timer=setTimeout("bot_text()",10); } else{ botSpeed() }
 }

function botSpeed(){
b= eval(document.getElementById('pos_tab').height-16);
t=0;
document.getElementById('trv_box').style.posTop = pos_Top(cur)+40;
document.getElementById('trv_box').style.clip = "rect("+t+" "+document.getElementById('trv_box').style.width+" "+(document.getElementById('pos_tab').height-16)+" 0)";
}


 function stop(a){
 clearTimeout(timer);
 }
window.onresize = TRV_param
//-->
