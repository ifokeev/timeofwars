alert_msg=function(wtf,what,txt)
{
	switch(wtf)
	{
		case'alert':jAlert(what,'Сообщение');break;
		case'target':jPrompt(txt,'','Сообщение',
		function(r)
		{
			if(r)
			{
				do_magic(what,r);
	        }
		});

		break;
	}
};


do_magic=function(what,target)
{
	if(!target)
	{
		var urlq='battle2.php?use_magic='+what;
    }
	else
	{
		var urlq='battle2.php?use_magic='+what+'&target='+target;
    }

	$.get(urlq,
	function(data)
	{
		if(data)
		{
			$('#msg').show(300).html(data);
		}
		else
		{
			$('#msg').hide(1000);
			checker();
		}
		return;
	});
};

var attack1=false,attack2=false,block=false,block_s=[];

$('input[name=kick1]').live('click',
function()
{
	attack1=this.value;
});

$('input[name=kick2]').live('click',
function()
{
	attack2=this.value;
});

$('input[name=block1]').live('click',
function()
{
	block=true;
	block_s=blocks();
});


get_log=function()
{
	$.getJSON('ajax/battle2_check.php',{act:'get_log',battle_id:$('#batid').text()},
	function(data)
	{
		$('#team1').html(data.team1);
		$('#team2').html(data.team2);
		$('#log').html(data.log);
	});
};

update_hp=function()
{
	$.getJSON('battle2.php',{"act":"update_hp"},
	function(data)
	{
		$.ajaxSetup({cache:true});
		$('#HP'+data.player_id).html(data.player_hp);
		$('#mana'+data.player_id).html(data.player_mana);

		if(last_enemy_id!=data.enemy_id)
		{
			$.get("battle2.php",{'act':'load_enemy'},
			function(z)
			{
				$('#enemy').html(z);
			});
		}
		else if(last_enemy_id==data.enemy_id)
		{
			$('#HP'+data.enemy_id).html(data.enemy_hp);
			$('#mana'+data.enemy_id).html(data.enemy_mana);
		}

		last_enemy_id=data.enemy_id;
	});
};

checker=function()
{
	if( $('#end_battle').length )
	{
		return;
	}

	$("#battle_status").load("ajax/battle2_check.php",{'act':'check'},
	function()
	{
		if($('.attack_table').length)
		{
			var radio1=$(":radio[name=kick1]").length,radio2=$(":radio[name=kick2]").length;

			for(var i=0;i<block_s.length;i++)
			{
				$('#B'+block_s[i]).attr('checked',true);
	        }

			if(radio1)
			{
				$(":radio[name=kick1][value="+attack1+"]").attr('checked','checked');
	        }

			if(radio2)
			{
				$(":radio[name=kick2][value="+attack2+"]").attr('checked','checked');
	        }

			get_log();
		}

		update_hp();
	});
};


blocks=function()
{
	var result=[];
	$("input[name=block1]:checked").each(
	function(id)
	{
		result.push(this.value);
	});

	return result;
};

attacks=function()
{
	var result=[];

	if( $(":radio[name=kick1]").length )
	{
		result.push( $(":radio[name=kick1]").filter(":checked").val() );
	}

	if($(":radio[name=kick2]").length)
	{
		result.push( $(":radio[name=kick2]").filter(":checked").val() );
	}

	return result;
};

$('#attack').live('click',function()
{
	var radio1=$(":radio[name=kick1]").length;
	var radio2=$(":radio[name=kick2]").length;

	if( ( (radio1 && !attack1) || (radio2 && !attack2) ) && !block )
	{
		$('#msg').show(300).html('Блок и удар не выбраны');
	}
	else if( (radio1 && !attack1) || (radio2 && !attack2) )
	{
		$('#msg').show(300).html('Удар не выбран');
	}
	else if(!block)
	{
		$('#msg').show(300).html('Блок не выбран');
	}
	else if(block_s.length>2)
	{
		$('#msg').show(300).html('Можно выбрать не больше 2-х точек для блока.');
	}
	else if($('#B5').length && block_s.length<=1)
	{
		$('#msg').show(300).html('Нужно выбрать 2 точки для блока.');
	}
	else
	{
		$('#msg').hide(1000);
		$.get('ajax/battle2_kick.php',{act:'kick','kick[]':attacks(),'block[]':blocks()},
		function(data)
		{

			attack1=false;
			attack2=false;
			block=false;
			block_s=[];
			checker();
		});
	}
});

$('.btn1').click(function()
{
	$('#pict_'+this.id).show();
});

$('.btn2').click(function()
{
	$('#pict_'+this.id).hide();
});
