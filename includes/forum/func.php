<?
function addtheme( $head = '', $body = '', $id_forum){
global $db;

$db->insert( SQL_PREFIX.'topics', Array( 'name' => $head, 'author' => $_SESSION['login'], 'id_forum' => $id_forum, 'datepost' => time() ), 'query' );
$id = $db->insertId();

$db->insert( SQL_PREFIX.'posts',  Array( 'topicid' => $id, 'Author' => $_SESSION['login'], 'msgtext' => $body, 'msgdate' => time() ) );

return getlast($id);
}

function addreplay( $body = '', $id_topic ){
global $db;

$db->insert( SQL_PREFIX.'posts', Array( 'topicid' => $id_topic, 'Author' => $_SESSION['login'], 'msgtext' => $body, 'msgdate' => time() ) );

if( $db->numrows("SELECT views FROM ".SQL_PREFIX."topics WHERE id = '$id_topic'") > 100 )
{	$db->update( SQL_PREFIX.'topics', Array( 'type' => 'hot_thread.gif' ), Array( 'id' => $id_topic ) );
}

$db->update( SQL_PREFIX.'topics', Array( 'datepost' => time() ), Array( 'id' => $id_topic ) );

return getlast($id_topic);
}

function getlast($top){ global $db;
return header('Location: index.php?viewtopic='.$top.'&p='.@ceil( $db->SQL_result($db->query("SELECT COUNT(*) as cnt FROM ".SQL_PREFIX."posts WHERE topicid = '$top'"),0) / 20 ).'#post'. $db->SQL_result($db->query("SELECT id FROM ".SQL_PREFIX."posts WHERE topicid = '$top' ORDER BY msgdate DESC"),0) );
}

function bbcode($str = ''){
global $db_config;
$str = preg_replace("!(\[quote])(.*?)(\[\/quote])!si", '<table border="0" align="center" width="95%" cellpadding="3" cellspacing="1"><tr><td><b>Цитата</b> </td></tr><tr><td id="code">\\2</td></tr></table>', $str);
$str = preg_replace("!(\[clan=)(.*?)(\])(.*?)(\[\/clan])!si", '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/\\2.gif" title="\\4">', $str);
$str = preg_replace("!(\[color=)(.*?)(\])(.*?)(\[\/color])!si", '<font color="\\2">\\4</font>', $str);
$str = preg_replace("!(\[align=)(.*?)(\])(.*?)(\[\/align])!si", '<div align="\\2">\\4</div>', $str);
$str = preg_replace("!(\[b])(.*?)(\[\/b])!si", '<B>\\2</B>', $str);
$str = preg_replace("!(\[i])(.*?)(\[\/i])!si", '<I>\\2</I>', $str);
$str = preg_replace("!(\[u])(.*?)(\[\/u])!si", '<U>\\2</U>', $str);
$str = preg_replace("!(\[s])(.*?)(\[\/s])!si", '<S>\\2</S>', $str);
$str = ereg_replace('[-a-z0-9!#$%&\'*+/=?^_`{|}~]+@([.]?[a-zA-Z0-9_/-])*','<a href="mailto:\\0">\\0</a>', $str);
$str = ereg_replace(' [a-zA-Z]+://(([.]?[a-zA-Z0-9_/-])*) ',' <a href="\\0">\\1</a> ', $str);
$str = ereg_replace(' (^| )(www([-]*[.]?[a-zA-Z0-9_/-?&%])*) ',' <a href="http://\\2">\\2</a> ', $str);
return $str;
}

function addNEWrazdel($type, $name = '', $about = ''){
global $db;

$db->insert( SQL_PREFIX.'mainforum', Array( 'type' => $type, 'name' => $name, 'about' => $about ) );

return "<script>window.location.href='index.php?adminpanel=1&act=razdel';</script>";
}

function DelRazdel($id = 0){
global $db;

$db->execQuery("DELETE FROM ".SQL_PREFIX."mainforum WHERE id = '$id'");

return "<script>window.location.href='index.php?adminpanel=1&act=razdel';</script>";
}

function UPDATErazdel($type, $name = '', $about = '', $id = 0){
global $db;

$db->update( SQL_PREFIX.'mainforum', Array( 'type' => $type, 'name' => $name, 'about' => $about ), Array( 'id' => $id ) );

return "<script>window.location.href='index.php?adminpanel=1&act=razdel';</script>";
}

function DELtop($forum = 1, $id = 0){
global $db;

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."topics WHERE id = '$id' AND id_forum = '$forum'") ){

$db->insert( SQL_PREFIX.'forum_topics_del', Array( 'id' => $dat['id'], 'type' => $dat['type'], 'isfixed' => $dat['isfixed'], 'name' => $dat['name'], 'author' => $dat['author'], 'views' => $dat['views'], 'id_forum' => $dat['id_forum'], 'datepost' => $dat['datepost'], 'char' => $_SESSION['login'] ) );

$post = $db->queryArray("SELECT * FROM ".SQL_PREFIX."posts WHERE topicid = '$id'");
if( !empty($post) )
{	foreach( $post as $v )
	{
	    $db->insert( SQL_PREFIX.'forum_posts_del', Array( 'id' => $v['id'], 'topicid' => $v['topicid'], 'Author' => $v['Author'], 'msgtext' => $v['msgtext'], 'msgdate' => $v['msgdate'], 'char' => $_SESSION['login'] ) );
	}
}


$db->execQuery("DELETE FROM ".SQL_PREFIX."topics WHERE id = '$id' AND id_forum = '$forum'");
$db->execQuery("DELETE FROM ".SQL_PREFIX."posts WHERE topicid = '$id'");
}


return "<script>window.location.href='index.php?viewforum=$forum';</script>";
}

function UPDATEtop($id = 0, $name, $forum, $isfix, $type){
global $db;

$db->update( SQL_PREFIX.'topics', Array( 'name' => $name, 'id_forum' => $forum, 'isfixed' => $isfix, 'type' => $type ), Array( 'id' => $id ) );

return "<script>window.location.href='index.php?viewforum=$forum';</script>";
}

function DELpost($topic = 0, $page = 0, $id = 0){
global $db;

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."posts WHERE id = '$id' AND topicid = '$topic'") ){

$db->insert( SQL_PREFIX.'forum_posts_del', Array( 'id' => $v['id'], 'topicid' => $v['topicid'], 'Author' => $v['Author'], 'msgtext' => $v['msgtext'], 'msgdate' => $v['msgdate'], 'char' => $_SESSION['login'] ) );
$db->execQuery("DELETE FROM ".SQL_PREFIX."posts WHERE id = '$id' AND topicid = '$topic' LIMIT 1");

}

return "<script>window.location.href='index.php?viewtopic=$topic&p=$page';</script>";
}

function UPDATEpost($topic = 0, $page = 0, $id = 0, $text){
global $db;

$db->execQuery("UPDATE ".SQL_PREFIX."posts SET msgtext = concat('$text', '\n\n<small>Редактировано ".$_SESSION['login']." <span class=date>".date('j.n.Y H:i')."</span></small>' )WHERE id = '$id' AND topicid = '$topic'");

echo "<script>window.location.href='index.php?viewtopic=$topic&p=$page#post$id';</script>";
return false;
}

function ogran($str = '', $long = 20){
$txt = '';
for($i = 0; $i <= $long; $i++){ @$txt .= $str[$i]; }
if(!empty($str[$i])){ $txt .= '...'; }
return $txt;
}


function viewform( $fortheme = 0, $head = '', $body = '' ){
global $db, $db_config;
$dat = $db->queryArray("SELECT id_clan, title FROM ".SQL_PREFIX."clan");
?>
     <table class="g" cellspacing="1" cellpadding="3" border="0" align="center" width="800px">
		  <form name="REPLIER" method="POST" action="<?=$_SERVER['REQUEST_URI'];?>">
<? if($fortheme != 0){ ?>
		    <tr>
		      <td class="bg4 medium">Название темы</td>
		    </tr>
		    <tr>
		      <td class="bg6 medium" align="center"><input style="width: 95%" type="text" name="title" value="<?=$head;?>" /></td>
		    </tr>
<? } ?>
		    <tr>
		      <td class="bg4 medium">Кнопки кодов</td>
		    </tr>
		   <tr>
		      <td class="bg6 medium" align="center">

<script type="text/javascript" src="http://<?=$db_config[DREAM]['other'];?>/js/ubbc_ru.js"></script>
<script type="text/javascript" src="http://<?=$db_config[DREAM]['other'];?>/js/translit_only.js"></script>
<script type="text/javascript">
<!--
k=[
<? if(!empty($dat)){ ?>
<? foreach($dat as $v){ ?>
['<?=$v['id_clan'];?>','<?=$v['title'];?>'],
<? } ?>
<? } ?>
]
<? unset($dat, $v); ?>
var flash_w = '200'; var flash_h = '400';
var ubbc_dir = 'http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/bbcode';
var use_graphics = 0; // 1 = Graphical, 0 = Form based (buttons)
makeInterface(1,1,use_graphics, 'sql',2,2);
//-->
</script>
<script language="javascript">
<!--
ubbcInit(1,1,use_graphics);
//-->
</script>
		  </td>
		   <tr>
		     <td  class="bg4 medium">Введите сообщение</td>
		   </tr>
		   <tr class="bg6 medium">
		     <td valign="top"  align="center">
		     <textarea id="Post" style="width: 100%; height: 200px" wrap="soft" name="Post" tabindex="3" class="textinput" style="width: 95%" onClick="storeCaret(this); storeBuffer(this);" onkeydown="onescapebutton(event);" onkeypress="encodeCharacter(event);" onKeyup="storeCaret(this); doTranslit(event);" onChange="storeCaret(this);" onFocus="storeCaret(this);"><?=$body;?></textarea>

<script type="text/javascript">
<!--
ubbcInit(1,1,use_graphics);
function res(){
var el = document.getElementById("Post");
el.value = '';
}
//-->
</script>
</td>
		   </tr>
		 <tr class="bg5 medium">
		  <td align="center" style="text-align:center">

						        <input type="button" name="clear" onclick="res()" value="Очистить" tabindex="5" class="btn" style="width:250px;" />
		        <input type="submit" name="submit" value="Отправить" tabindex="4" class="btn" accesskey="s" style="width:250px;" />
		  </td>
	</tr>
	</table>
	</form>
	<br />
<? } ?>
