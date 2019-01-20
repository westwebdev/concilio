<?

function view_nav_panel()
{
	?>

	<header class="header">
		<div class="container">
			<div class="header_nav">
				<a href="?page=home">Home</a>
			</div>
			<div class="header_registration">
				<ul>
					<li>
						<a href="?page=registration">Registration</a>
					</li>
					<li>
						<a href="?page=login">Login</a>
					</li>
				</ul>
			</div>
		</div>
	</header>

	<?
}

function view_registration_form($errors)
{
	?>
	<div class="container">
		<h2 class="page_h">Registration</h2>
		<div class="success_msg"><? if($errors && isset($errors['success'])){ echo $errors['success']; } ?></div>
		<form method="post" class="registration_form" novalidate>

			<div>
				<label for="firstName">First Name</label>
				<input type='text' id="firstName" name="first_name"  
				value="<? if(isset($_POST['first_name'])) {echo $_POST['first_name'];}?>">
				<?if($errors && isset($errors['first_name'])):?>
				<span class="error_msg"><?=$errors['first_name'];?></span>
				<?endif;?>
			</div>

			<div>
				<label for="lastName">Last Name</label>
				<input type='text' id="lastName" name="last_name"  
				value="<?if(isset($_POST['last_name'])) { echo $_POST['last_name'];}?>">
				<?if($errors && isset($errors['last_name'])):?>
				<span class="error_msg"><?=$errors['last_name'];?></span>
				<?endif;?>
			</div>

			<div>
				<label for="userMail">Email</label>
				<input type='email' id="userMail" name="user_mail" 
				value="<?if(isset($_POST['user_mail'])) { echo $_POST['user_mail'];}?>">
				<?if($errors && isset($errors['user_mail'])):?>
				<span class="error_msg"><?=$errors['user_mail'];?></span>
				<?endif;?>
				<?if($errors && isset($errors['mail_error'])):?>
				<span class="error_msg"><?=$errors['mail_error'];?></span>
				<?endif;?>
			</div>

			<div>
				<label for="birthday">Birthday</label>
				<input type='text' id="birthday" name="user_birthday" 
				AUTOCOMPLETE="off"
				value="<?if(isset($_POST['user_birthday'])) { echo $_POST['user_birthday'];}?>" >
				<?if($errors && isset($errors['user_birthday'])):?>
				<span class="error_msg"><?=$errors['user_birthday'];?></span>
				<?endif;?>
			</div>

			<div>
				<label for="userPass">Password</label>
				<input type='password' id="userPass" name="user_pass"  value="">
				<?if($errors && isset($errors['user_pass'])):?>
				<span class="error_msg"><?=$errors['user_pass'];?></span>
				<?endif;?>
			</div>

			<div>
				<label for="userPassRepeat">Repeat password</label>
				<input type='password' id="userPassRepeat" name="user_pass_repeat"  value="">
				<?if($errors && isset($errors['user_pass_repeat'])):?>
				<span class="error_msg"><?=$errors['user_pass_repeat'];?></span>
				<?endif;?>
				<?if($errors && isset($errors['not_equal'])):?>
				<span class="error_msg"><?=$errors['not_equal'];?></span>
				<?endif;?>
			</div>

			<div>
				<label for="langSelect">Choose programming language</label>
				<select name="lang_select" id="langSelect">
					<option value="0">-Choise language-</option>
					<?
					$prog_languages = model_get_all_languages();
					while ($language = mysql_fetch_array($prog_languages))
					{
						?>
						<option value="<?= $language['id']?>"><?= $language['program_lang']?></option>
						<?
					}
					?>
				</select>
				<?if($errors && isset($errors['language'])):?>
				<span class="error_msg"><?=$errors['language'];?></span>
				<?endif;?>
			</div>
			
			<div>
				<label for="countrySelect">Choose country</label>
				<select name="country_select" id="countrySelect">
					<option value="0">-Choise country-</option>
					<?
					$countries = model_get_all_countries();
					while ($country = mysql_fetch_array($countries))
					{
						?>
						<option value="<?= $country['id']?>"><?= $country['country']?></option>
						<?
					}
					?>
				</select>
				<?if($errors && isset($errors['country'])):?>
				<span class="error_msg"><?=$errors['country'];?></span>
				<?endif;?>
			</div>

			<button type="submit" name="user_regist" value="Registration">Registration</button>
			<?if($errors && isset($errors['exist_reg_user'])):?>
			<div><?=$errors['exist_reg_user'];?></div>
			<?endif;?>

		</form>
	</div>

	<?
}


function view_home_page($errors)
{
	$db_name = 'concilio_user';
	$users = model_get_some_user_info($db_name);
	?>
	<div class="container">
		<h2 class="page_h">Home</h2>

		<div class="success_msg"><? if($errors && isset($errors['success'])){ echo $errors['success']; } ?></div>

		<div class="user_table">
			<div class="user_table_h">
				<div class="user_table_h_item number">№</div>
				<div class="user_table_h_item first_name">Name</div>
				<div class="user_table_h_item last_name">Last name</div>
				<div class="user_table_h_item country">Country</div>
			</div>
			
			<?
			$i=0;
			while ($user = mysql_fetch_array($users))
			{
				$i++;
				?>
				<div class="user_table_row">
					<div class="user_table_row_item number"><?=$i?></div>
					<a href="?page=account&id=<?=$user['id'];?>" 
							 class="user_table_row_item first_name link"><?=$user['firstName']?></a>
					<div class="user_table_row_item last_name"><?=$user['lastName']?></div>
					<div class="user_table_row_item country"><?=$user['country']?></div>
				</div>
				<?
			}
			?>
		</div>
	</div>
	<?
}


function view_account_page($user, $birthday, $language, $country)
{
	?>
	<div class="container">
		<div class="user_info">
			<div class="user_info_block">
				<div class="headline">First name:</div>
				<div class="data"><?=$user['firstName'];?></div>
			</div>
			<div class="user_info_block">
				<div class="headline">Last name:</div>
				<div class="data"><?=$user['lastName'];?></div>
			</div>
			<div class="user_info_block">
				<div class="headline">E-mail:</div>
				<div class="data"><?=$user['email'];?></div>
			</div>
			<div class="user_info_block">
				<div class="headline">Birthday:</div>
				<div class="data"><?=$birthday;?></div>
			</div>
			<div class="user_info_block">
				<div class="headline">Programing language:</div>
				<div class="data"><?=$language['program_lang'];?></div>
			</div>
			<div class="user_info_block">
				<div class="headline">Country:</div>
				<div class="data"><?=$country['country'];?></div>
			</div>
			<div class="user_info_block">
				<div class="headline">Registration date:</div>
				<div class="data"><?=$user['regisration_date'];?></div>
			</div>
		</div>
	</div>
	<?
}

function view_account_page_error($error)
{
	?>
	<div class="container">
		<div class="error_msg"><?=$error?></div>
	</div>
	<?
}

function view_login_page()
{
	?>
	<div class="container">
		<div class="">This page is being developed</div>
	</div>
	<?
}

?>