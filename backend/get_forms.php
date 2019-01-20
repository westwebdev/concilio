<?

// function reg_user_form($errors)
// if(isset($_GET['page']) && $_GET['page'] == 'registration')
// {
// 	view_registration_form($errors);
// }


function validate_registration_form()
{
	$errors['action'] = '?page=registration';
	$iserror=false;

	$first_name	= trim($_POST['first_name']);
	$last_name	= trim($_POST['last_name']);
	$mail	= trim($_POST['user_mail']);
	$birthday	= trim($_POST['user_birthday']);
	$pass	= trim($_POST['user_pass']);
	$pass_repeat	= trim($_POST['user_pass_repeat']);
	$language	= trim($_POST['lang_select']);
	$country	= trim($_POST['country_select']);

	foreach($_POST as $key=>$value)
	{
		if(strlen($value)<4)
		{
			$iserror=true;
			$errors[$key]="Length must be more than 4 characters.";
		}
		if($key === 'lang_select' || $key === 'country_select')
		{
			if($value != '0')
			{
				$iserror=false;
			}
		}
	}

	if(!(strpos($mail, '@') === false))
	{
		if(get_user_exist_by_param('email', $mail))
		{
			$iserror = true;
			$errors['mail_error'] = "This email allready exist";
		}
	}
	else
	{
		$iserror = true;
		$errors['mail_error'] = "Incorect email";
	}

	if(strlen($birthday)<10)
	{
		$iserror=true;
		$errors['user_birthday'] = "Length must be more than 10 characters.";
	}

	if($pass != $pass_repeat)
	{
		$iserror=true;
		$errors['not_equal'] = "Passwords do not match";
	}

	$language_array = array();
	$data = model_get_all_languages();
	while($language_data = mysql_fetch_array($data))
	{
		$language_array[] = $language_data['id'];
	}
	$country_array = array();
	$data = model_get_all_countries();
	while($country_data = mysql_fetch_array($data))
	{
		$country_array[] = $country_data['id'];
	}
	if(!in_array($language, $language_array))
	{
		$iserror=true;
		$errors['language'] = "Choose programming language";
	}	
	if(!in_array($country, $country_array))
	{
		$iserror=true;
		$errors['country'] = "Choose country";
	}	

	if ($iserror)
	{
		$_GET['page'] = 'registration';
		return $errors;
	} 
	else{
		return false;
	}
}

function get_register_new_user()
{
	if(isset($_POST['user_regist']))
	{
		$first_name	= $_POST['first_name'];
		$last_name	= $_POST['last_name'];
		$mail	= $_POST['user_mail'];
		$birthday	= $_POST['user_birthday'];
		$pass	= $_POST['user_pass'];
		$pass_repeat	= $_POST['user_pass_repeat'];
		$language	= $_POST['lang_select'];
		$country	= $_POST['country_select'];

		$errors = validate_registration_form();
		
		if(!$errors)
		{
			$regisration_date = date('d.m.Y');
			model_add_new_user($first_name, $last_name, $mail, $birthday, $pass, $pass_repeat, $language, $country, $regisration_date);
			$_GET['page'] = 'home';
			$errors['success'] = 'User addedet';
		}

		return $errors;
	}
}

function get_view_account_page()
{
	if(isset($_GET['id']))
	{
		$user_id = $_GET['id'];

		$user_id_array = array();
		$user_data = model_get_all_record_from_db('concilio_user', NULL, NULL );
		while($user = mysql_fetch_array($user_data))
		{
			$user_id_array[] = $user['id'];
		}
		if(!in_array($user_id, $user_id_array))
		{
			$error = 'This user has been deleted or not registered yet.';
			view_account_page_error($error);
		}
		else
		{
			$user_query = model_get_all_record_from_db('concilio_user', 'id', $user_id);
			$user = mysql_fetch_array($user_query);
			$language_query = model_get_all_record_from_db('concilio_programming_lang', 'id', $user['programLangId']);
			$country_query = model_get_all_record_from_db('concilio_country', 'id', $user['countryId']);
			$language = mysql_fetch_array($language_query);
			$country = mysql_fetch_array($country_query);

			$date_array = explode('-', $user['birthday']);
			$birthday = implode('.', $date_array);

			view_account_page($user, $birthday, $language, $country);
		}
	}
}


?>