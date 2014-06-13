    <table cellspacing="0" cellpadding="0">
	 <tr>
	  <td align="center"><?=$this->slogin( $this->Username, $this->Level, $this->id_clan );?></td>
     </tr>
	 <tr>
	  <td nowrap="nowrap">
	   <div id="HP<?=$this->Id;?>"><?=$str;?></div>
      </td>
     </tr>
	</table>
    <table cellpadding="0" cellspacing="0" width="243px">
     <td>
      <div style="position:relative;" width="242px" height="290px" border="0">
       <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/frames/_main/pers_i_s.gif" width="242px" height="290px" border="0">
       <div width="242px" height="20px" style="position:absolute;left:0px; top:-5px; z-index:1;"></div>
       <div style="position:absolute; left:95px; top:13px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][7]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][7];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][7];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][7];?>.gif" width="50px" height="51px" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][7];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][7];?>.gif" width="50px" height="51px" />
       <? endif; ?>
       </div>
       <div style="position:absolute; left:17px; top:66px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][2]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][2];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][2];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][2];?>.gif" width="50px" height="50px" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][2];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][2];?>.gif" width="50px" height="50px" />
       <? endif; ?>
       </div>
       <div style="position:absolute; left:170px; top:62px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][9]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][9];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][9];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][9];?>.gif" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][9];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][9];?>.gif" />
       <? endif; ?>
       </div>
       <div style="position:absolute; left:160px; top:145px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][3]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][3];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][3];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][3];?>.gif" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][3];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][3];?>.gif" />
       <? endif; ?>
       </div>
       <div style="position:absolute; left:23px; top:210px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/book0.gif" alt="Пустой слот аксесуары" />
       </div>
       <div style="position:absolute; left:22px; top:150px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][8]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][8];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][8];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][8];?>.gif" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][8];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][8];?>.gif" />
       <? endif; ?>
       </div>
       <div style="position:absolute; left:173px; top:220px;z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][10]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][10];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][10];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][10];?>.gif" width="50px" height="35px" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][10];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][10];?>.gif" width="50px" height="35px" />
       <? endif; ?>
       </div>
       <div align="center" style="position:absolute; left:70px; top:69px; width:100px ;height:200px; z-index:2; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pict/<?=$this->Pict;?>.gif" width="70px" height="180px" title="<?=$this->Username;?>" />
       </div>
       <div style="position:absolute; left:27px; top:35px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][1]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][1];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][1];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][1];?>.gif" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][1];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][1];?>.gif" />
       <? endif; ?>
       </div>
       <div style="position:absolute; left:170px; top:35px; z-index:1;width:50px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][0]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][0];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][0];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][0];?>.gif" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][0];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][0];?>.gif" />
       <? endif; ?>
       </div>
       <div style="position:absolute; left:90px; top:260px; z-index:1;width:20px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][4]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][4];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][4];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][4];?>.gif" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][4];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][4];?>.gif" />
       <? endif; ?>
       </div>
       <div style="position:absolute; left:113px; top:258px; z-index:1;width:20px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][5]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][5];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][5];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][5];?>.gif" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][5];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][5];?>.gif" />
       <? endif; ?>
       </div>
       <div style="position:absolute; left:134px; top:260px; z-index:1;width:20px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
       <? if( !empty($out['Slot_id'][6]) ): ?>
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$out['Slot_id'][6];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][6];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][6];?>.gif" />
        </a>
       <? else: ?>
         <img alt="<?=$out['Slot_name'][6];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][6];?>.gif" />
       <? endif; ?>
       </div>
      </td>
     </tr>
    </table>