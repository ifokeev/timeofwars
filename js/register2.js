var mail_ok=false,login_auth_ok=false,upwd_ok=false,sex_ok=false,day_ok=false,month_ok=false,year_ok=false;
var ok=0;
$("#register_pls").click(function()
{{
	 $('#myform').submit();
    else
     alert('������� ��� ���������� ���������.');
 }
});

$('input').keyup(function() {
  check_correct(this);
});


check_correct=function(name)
{
    var elem_id = $('#'+id);
	var value = elem_id.val();


	if(!value)return;

	var err_text='';

    var reg_mail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var reg_login = /[A-Za-z�-��-�0-9_]/;
    var reg_login_rus = /[�-��-�]/;
    var reg_login_eng = /[A-Za-z]/;
    var reg_only_int = /^[0-9]+$/;

	if(id=="login_auth")
	{
		 err_text="<b>��� ���������</b> �������� �����������<br /> �������. ��������� ���. ��� ����.<br /> ����� ����� ���������, �����, �������:<br /> ������, _ \n";
		else
		{
			 err_text+="����� <b>����� ���������</b> ������ ����<br /> �� 3-� �� 12-� ��������<br>\n";

			if( reg_login_rus.test(value) && reg_login_eng.test(value) )
			 err_text+="<b>��� ���������</b> ������ �������� �� ���� ������ ��������<br>\n";

			if(value.match(/(.)\1\1/))
			 err_text+="<b>��� ���������</b> �� ����� ��������� 3 ���������� ������� ������<br>\n";

			if( reg_only_int.test(value) )
			 err_text+="<b>��� ���������</b> �� ����� �������� ������ �� ����!<br>"}

			if(err_text=='')
			 login_auth_ok=true
		}

		if(id=="upwd")
		{
			{
				 err_text+="������ �� ����� ��������� 3 ���������� ������� ������<br>\n";

				if( value.length<6||value.length>25 )
				 err_text+="����� ������ ������ ���� �� 6 ��<br /> 25 ��������<br>\n"
			}
			else
			 err_text='������ �������� ����������� ������. ��������� ������� � ����������<br /> ����� ����� ��������� � �����<br>';

			if(err_text=='')
			 upwd_ok=true
		}

		if(id=="upwd2")
		{
			{
				upwd_ok=false
			}
			else
			 upwd_ok=true
		}

		if(id=="umail")
		{
			 err_text="�������, ����������,<br /> ���������� �������� �����<br>\n";

			if( value.length<8 || value.length>40 )
			  err_text="����� ��������� ������ ������ ���� ��<br /> 8 �� 40 ������<br>\n";

			if(err_text=='')
			  mail_ok=true
	    }
			if(id=="sex")
			{
				  err_text="�������� ��� ���";
				else
				  sex_ok=true
			}
			 if(id=="day")
			 {
			 	 err_text="�������� ���� ��������";
			 	else
			 	 day_ok=true
			 }

			 if(id=="month")
			 {
			 	  err_text="�������� ����� ��������";
			 	else
			 	  month_ok=true
			 }

			 if(id=="year")
			 {
			 	 err_text="�������� ��� ��������";
			 	else year_ok=true
			 }

			 $('#'+id+'_err').html('<font color="red">'+err_text+'</font>')
}