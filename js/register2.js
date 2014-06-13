var mail_ok=false,login_auth_ok=false,upwd_ok=false,sex_ok=false,day_ok=false,month_ok=false,year_ok=false;
var ok=0;
$("#register_pls").click(function()
{{	if(login_auth_ok==true&&upwd_ok==true&&mail_ok==true&&sex_ok==true&&month_ok==true&&year_ok==true)
	 $('#myform').submit();
    else
     alert('Введите всю информацию корректно.');
 }
});

$('input').keyup(function() {
  check_correct(this);
});


check_correct=function(name)
{	var id=(name=='day'||name=='month'||name=='year'||name=='sex')?name:name.id;
    var elem_id = $('#'+id);
	var value = elem_id.val();


	if(!value)return;

	var err_text='';

    var reg_mail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var reg_login = /[A-Za-zА-Яа-я0-9_]/;
    var reg_login_rus = /[А-Яа-я]/;
    var reg_login_eng = /[A-Za-z]/;
    var reg_only_int = /^[0-9]+$/;

	if(id=="login_auth")
	{		if( reg_login.test(value) == false )
		 err_text="<b>Имя персонажа</b> содержит запрещенные<br /> символы. Разрешены рус. или англ.<br /> буквы обоих регистров, цифры, символы:<br /> пробел, _ \n";
		else
		{			if( value.length<3||value.length>12 )
			 err_text+="Длина <b>Имени персонажа</b> должна быть<br /> от 3-х до 12-и символов<br>\n";

			if( reg_login_rus.test(value) && reg_login_eng.test(value) )
			 err_text+="<b>Имя персонажа</b> должно состоять из букв одного алфавита<br>\n";

			if(value.match(/(.)\1\1/))
			 err_text+="<b>Имя персонажа</b> не может содержать 3 одинаковых символа подряд<br>\n";

			if( reg_only_int.test(value) )
			 err_text+="<b>Имя персонажа</b> не может состоять только из цифр!<br>"}

			if(err_text=='')
			 login_auth_ok=true
		}

		if(id=="upwd")
		{			if( reg_login.test(value) )
			{				if( value.match(/(.)\1\1/) )
				 err_text+="Пароль не может содержать 3 одинаковых символа подряд<br>\n";

				if( value.length<6||value.length>25 )
				 err_text+="Длина пароля должна быть от 6 до<br /> 25 символов<br>\n"
			}
			else
			 err_text='Пароль содержит запрещенный символ. Разрешены русские и английские<br /> буквы обоих регистров и цифры<br>';

			if(err_text=='')
			 upwd_ok=true
		}

		if(id=="upwd2")
		{			if($('#upwd').val()!=value&&$('#upwd').val())
			{				err_text='Пароль и копия пароля не совпадают';
				upwd_ok=false
			}
			else
			 upwd_ok=true
		}

		if(id=="umail")
		{			if(reg_mail.test(value) == false)
			 err_text="Введите, пожалуйста,<br /> корректный почтовый адрес<br>\n";

			if( value.length<8 || value.length>40 )
			  err_text="Длина почтового адреса должна быть от<br /> 8 до 40 знаков<br>\n";

			if(err_text=='')
			  mail_ok=true
	    }
			if(id=="sex")
			{				if(value!=1&&value!=2)
				  err_text="Выберите ваш пол";
				else
				  sex_ok=true
			}
			 if(id=="day")
			 {			 	if(value<1||value>31)
			 	 err_text="Выберите День рождения";
			 	else
			 	 day_ok=true
			 }

			 if(id=="month")
			 {			 	if(value<1||value>12)
			 	  err_text="Выберите Месяц рождения";
			 	else
			 	  month_ok=true
			 }

			 if(id=="year")
			 {			 	if(value<1950||value>2005)
			 	 err_text="Выберите Год рождения";
			 	else year_ok=true
			 }

			 $('#'+id+'_err').html('<font color="red">'+err_text+'</font>')
}