<?

// error_reporting(E_ALL);

include 'config.php';

include 'views.php';
include 'get_forms.php';
include 'models.php';

$errors = get_register_new_user();
// $errors = validate_registration_form();

view_nav_panel();

if(isset($_GET['page']))
{
	$page = $_GET['page'];

	switch ($page) {
		case 'registration':
			view_registration_form($errors);
		break;
		case 'login':
			view_login_page();
		break;
		case 'home':
			view_home_page($errors);		
		break;
		case 'account':
			get_view_account_page();
		break;

		default:
		view_home_page();		
		break;
	}
}

?>