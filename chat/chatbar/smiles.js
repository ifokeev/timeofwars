var chatHtmlSmiles = '';

chatHtmlSmiles += '<div STYLE="width: 295px; height: 250px; border: 1px solid #634638; padding: 1px; overflow:auto; "><table style="border-collapse: collapse;" width=100%>';
sm=new Array();
sm[0]='face1';
sm[1]='face2';
sm[2]='face3';
sm[3]='face4';
sm[4]='face5';
sm[5]='fingal';
sm[6]='evil';
sm[7]='batman';
sm[8]='adolf';
sm[9]='am';
sm[10]='angel';
sm[11]='cool';
sm[12]='coolman';
sm[13]='crazy';
sm[14]='devil';
sm[15]='aplause';
sm[16]='ha';
sm[17]='help';
sm[18]='happy';
sm[19]='hello';
sm[20]='ill';
sm[21]='hummer2';
sm[22]='music';
sm[23]='newyear';
sm[24]='ogo';
sm[25]='police';
sm[26]='police2';
sm[27]='prise';
sm[28]='punk';
sm[29]='ravvin';
sm[30]='ravvin2';
sm[31]='rupor';
sm[32]='scare';
sm[33]='king';
sm[34]='sleep';
sm[35]='song';
sm[36]='strong';
sm[37]='student';
sm[38]='goodnigth';
sm[39]='fuu';
sm[40]='girl';
sm[41]='inlove';
sm[42]='kiss1';
sm[43]='lick';
sm[44]='lips';
sm[45]='two';
sm[46]='pare';
sm[47]='fuck';
sm[48]='dinner';
sm[49]='friday';
sm[50]='drink';
sm[51]='beer';
sm[52]='cola';
sm[53]='killed';
sm[54]='throwout';
sm[55]='boxing';
sm[56]='duel';
sm[57]='gun1';
sm[58]='gun2';
sm[59]='gun_1';
sm[60]='hummer';
sm[61]='jack';
sm[62]='knut';
sm[63]='matrix';
sm[64]='med';
sm[65]='ninja';
sm[66]='nunchak';
sm[67]='t2';
sm[68]='terminator';
sm[69]='training';
sm[70]='trio';
sm[71]='user';
sm[72]='censored';
sm[73]='compkill';
sm[74]='helloween';
sm[75]='lock';
sm[76]='lol';
sm[77]='loo';
sm[78]='mol';
sm[79]='nuclear';
sm[80]='yo';
sm[81]='dollar';
sm[82]='heart';
sm[83]='luck';
sm[84]='mac';
sm[85]='win';
sm[86]='rip';
sm[87]='bye';
sm[88]='baby';
sm[89]='man_hat';

var i=0;
var td=0;
while(i<sm.length) {
if(td==3){td=0; chatHtmlSmiles +='</tr>';}
if (td==0 ){chatHtmlSmiles +='<tr>';}
        var s = sm[i++];
        chatHtmlSmiles +='<td style="border: 1px solid #634638; cursor: hand; padding: 3px;" align="center"';
        chatHtmlSmiles +='onMouseOver="this.style.backgroundColor=\'#dbdbdb\';"';
        chatHtmlSmiles +='onMouseOut="this.style.backgroundColor=\'transparent\';" onclick="top.bar.S(\''+s+'\')">';
        chatHtmlSmiles +='<IMG SRC="http://other.it-industry.biz/images/smiles/'+s+'.gif" BORDER=0 ></td>';
        td++;
}
chatHtmlSmiles +='</table></div>';




function chatShowSmiles(_obj) {
if (!window.createPopup) {
window.open("smiles.html", "", "width=310,height=250,location=no,menubar=no,resizable=yes,scrollbars=auto,status=no,toolbar=no");
} else {
var smileMenu = window.createPopup();
smileMenu.document.onselectstart = function() { return false; }
smileMenu.document.body.innerHTML = chatHtmlSmiles;
smileMenu.show(0,0,0,0,_obj);
smileMenu.hide();
smileMenu.show(0, -smileMenu.document.body.scrollHeight, smileMenu.document.body.scrollWidth, smileMenu.document.body.scrollHeight,_obj);
}
}

function S(name)
{
        top.frames['bar'].document.all('text').focus();
        top.frames['bar'].document.all('text').value = top.frames['bar'].document.all('text').value + ':'+name+': ';
        return false;
}
