  <div class="playerinfo">
      <div class="player" id="Player<?=$this->Id;?>">
	   <?=$this->slogin( $this->Username, $this->Level, $this->id_clan );?>
      </div>
	  <div class="hpsilver hp" id="HP<?=$this->Id;?>"><?=$hp;?></div>
	  <div class="hpsilver mana" id="mana<?=$this->Id;?>"><?=$mana;?></div>
	  <div id="pict_<?=$this->Id;?>">
	    <div class="player_pict_bg"></div>
	    <div class="player_pict"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pict/<?=$this->Pict;?>" title="<?=$this->Username;?>" /></div>
      </div>
      <div class="btn1" id="<?=$this->Id;?>"></div>
      <div class="btn2" id="<?=$this->Id;?>"></div>
      <? if( !empty($out['Slot_id'][0]) ): ?>
	  <div class="slots" id="slot0" style="background: #000 url('<?=$out['Slot_type'][0];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][0];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][0];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][0];?>.gif"  />
         </a>
      </div>
      <? endif; ?>
      <? if( !empty($out['Slot_id'][1]) ): ?>
	  <div class="slots" id="slot1" style="background: #000 url('<?=$out['Slot_type'][1];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][1];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][1];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][1];?>.gif"  />
         </a>
      </div>
      <? endif; ?>
	  <? if( !empty($out['Slot_id'][2]) ): ?>
	  <div class="slots" id="slot2" style="background: #000 url('<?=$out['Slot_type'][2];?>') no-repeat;">
        <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][2];?>" target="_blank">
         <img alt="<?=$out['Slot_name'][2];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][2];?>.gif"  />
        </a>
      </div>
      <? endif; ?>
      <? if( !empty($out['Slot_id'][3]) ): ?>
	  <div class="slots" id="slot3" style="background: #000 url('<?=$out['Slot_type'][3];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][3];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][3];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][3];?>.gif" width="60px" height="60px" />
         </a>
      </div>
      <? endif; ?>
      <? if( !empty($out['Slot_id'][4]) ): ?>
	  <div class="slots" id="slot4" style="background: #000 url('<?=$out['Slot_type'][4];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][4];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][4];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][4];?>.gif" />
         </a>
      </div>
      <? endif; ?>
      <? if( !empty($out['Slot_id'][5]) ): ?>
	  <div class="slots" id="slot5" style="background: #000 url('<?=$out['Slot_type'][5];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][5];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][5];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][5];?>.gif" />
         </a>
      </div>
      <? endif; ?>
      <? if( !empty($out['Slot_id'][6]) ): ?>
	  <div class="slots" id="slot6" style="background: #000 url('<?=$out['Slot_type'][6];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][6];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][6];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][6];?>.gif" />
         </a>
      </div>
      <? endif; ?>
      <? if( !empty($out['Slot_id'][7]) ): ?>
	  <div class="slots" id="slot7" style="background: #000 url('<?=$out['Slot_type'][7];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][7];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][7];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][7];?>.gif"  />
         </a>
      </div>
      <? endif; ?>
      <? if( !empty($out['Slot_id'][8]) ): ?>
	  <div class="slots" id="slot8" style="background: #000 url('<?=$out['Slot_type'][8];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][8];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][8];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][8];?>.gif"  />
         </a>
      </div>
      <? endif; ?>
      <? if( !empty($out['Slot_id'][9]) ): ?>
	  <div class="slots" id="slot9" style="background: #000 url('<?=$out['Slot_type'][9];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][9];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][9];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][9];?>.gif"  />
         </a>
      </div>
      <? endif; ?>
      <? if( !empty($out['Slot_id'][10]) ): ?>
	  <div class="slots" id="slot10" style="background: #000 url('<?=$out['Slot_type'][10];?>') no-repeat;">
         <a href="http://<?=$db_config[DREAM]['server'];?>/thing.php?thing=<?=$out['Slot_id'][10];?>" target="_blank">
          <img alt="<?=$out['Slot_name'][10];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$out['Slot'][10];?>.gif"  />
         </a>
      </div>
      <? endif; ?>

   </div>
