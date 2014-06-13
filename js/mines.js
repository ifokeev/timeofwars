var g_iCount;startCountdown=function()
{if((g_iCount-1)>=0)
{g_iCount-=1;$('numberCountdown').update('<br />Буду копать еще '+g_iCount+' сек.');setTimeout('startCountdown()',1000);}else{$('numberCountdown').update();Go_go(3);}}
minesGo=function(y)
{rand=y!=0?Math.floor(Math.random()*11):0;if(rand!=0)
{g_iCount=3;startCountdown();}
new Ajax.Request('ajax/mines.php',{method:'post',parameters:{slot:rand},onSuccess:function(transport)
{var json=transport.responseText.evalJSON();$('level').update(json.level);$('table').update(json.table);$('newexp').update(json.newexp);$('exp').update(json.exp);if(json.msg)$('msg').update(json.msg);if(rand!=0)Go_stop(3);}});}
Go_stop=function(a)
{for(i=1;i<=a;i++)
{$('d'+i).update('копать');}}
Go_go=function(a)
{for(i=1;i<=a;i++)
{$('d'+i).update('<a href="javascript:minesGo(1)">копать</a>');}}
Go=function(a)
{for(i=1;i<=a;i++)
{elem=$('d'+i);elem2=$('d0');if(elem)
{elem.style.position='absolute';elem.style.top=parseInt(10+(parseInt(elem2.style.width)-10)*Math.random())+'px';elem.style.left=parseInt(400+(parseInt(elem2.style.width)-50)*Math.random())+'px';}}
setTimeout('Go(3)',1500);}