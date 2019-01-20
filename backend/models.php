<?
function model_add_new_user($first_name, $last_name, $mail, $birthday, $pass, $pass_repeat, $language, $country, $regisration_date)
{
	$query="insert into `concilio_user` 
	set 
	firstName='".$first_name."', 
	lastName='".$last_name."', 
	email='".$mail."',
	pass='".$pass."',
	birthday='".$birthday."',
	programLangId='".$language."',
	countryId='".$country."',
	regisration_date='".$regisration_date."'  ";
	$res=mysql_query($query);
}

function model_get_some_user_info()
{
	$query="SELECT 
						`concilio_user`.id,
						`concilio_user`.firstName,
						`concilio_user`.lastName,
						`concilio_country`.country
					FROM 
					 	`concilio_user`, `concilio_country`
					WHERE 
					 	`concilio_user`.countryId = `concilio_country`.id 
					GROUP by 
				 		`concilio_user`.id";
	$res=mysql_query($query);
	return $res;
}

function model_get_all_record_from_db($db_name, $param_name, $param_value)
{
	if(isset($param_name))
	{
		$where = "where ".$param_name."='' " ;
		if(isset($param_value))
		{
			$where = "where ".$param_name."='".$param_value."' " ;
		}
	}
	else
	{
		$where = "";
	}

	$query="select * from `".$db_name."` ".$where." ";
	$res=mysql_query($query);
	return $res;
}

function model_get_all_countries()
{
	$query="select * from `concilio_country` ";
	$res=mysql_query($query);
	return $res;
}
function model_get_all_languages()
{
	$query="select * from `concilio_programming_lang` ";
	$res=mysql_query($query);
	return $res;
}
function get_user_exist_by_param($param_name, $param_value)
{
	$query="select * from `concilio_user` where ".$param_name."='".$param_value."' ";
	$res=mysql_query($query);
	$role = mysql_fetch_array($res);
	if($role)
	{
		return true;
	}
	else
	{
		return false;
	}
}



?>