#!/usr/bin/php
<?php

$link = mysqli_connect("127.0.0.1", "root", "", "wwd_testbd");

if (!$link) 
{
	echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
	echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
	echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
	exit;
}
echo "Соединение с MySQL установлено!" . PHP_EOL;
echo "Информация о сервере: " . mysqli_get_host_info($link) . PHP_EOL;

if($argv[1])
{
	if($argv[1] == 'list_id')
	{
		$user_array = array();

		$query="select * from `concilio_user`";
		$res=mysqli_query($link, $query);

		while($role = mysqli_fetch_array($res, MYSQLI_ASSOC))
		{
			$user_array[] = $role['id'];
		}
			echo "\n";
		foreach ($user_array as $key => $value) {
			echo 'id';
			echo " - "; 
			echo $value;
			echo "; "; 
			echo "\n";
		}
			echo "\n";
	}
	
	if($argv[1] == 'list')
	{
		$user_array = array();

		$query="SELECT 
		`concilio_user`.id,
		`concilio_user`.firstName,
		`concilio_user`.lastName,
		`concilio_user`.birthday,
		`concilio_country`.country
		FROM 
		`concilio_user`, `concilio_country`
		WHERE 
		`concilio_user`.countryId = `concilio_country`.id 
		GROUP by 
		`concilio_user`.id";
		$res=mysqli_query($link, $query);

		while($role = mysqli_fetch_array($res, MYSQLI_ASSOC))
		{
			$user_array[] = $role;
		}
		// var_dump($user_array);

		foreach ($user_array as $key => $value) {
			echo "\n";
			foreach ($value as $key => $value) {
				if($key == 'firstName')
					$key = 'Name';
				if($key == 'lastName')
					$key = 'Surname';
				echo $key;
				echo " - "; 
				echo $value;
				echo "; "; 
				echo "\n";

			}
			echo "\n";
			echo "\n";
		}

	}
	if($argv[1] == 'remove')
	{
		if(!isset($argv[2]) || !is_numeric($argv[2])  || (isset($argv[2]) && $argv[2]==''))
			{
				echo('Use "remove" with "id", example "remove 2"');
			}
			else
			{
				$query="delete from `concilio_user` where id='$argv[2]' ";
				if($res=mysqli_query($link, $query))
				{
					echo "User removed";
				}
			}
	}


	$user_array = array();

	$query="select * from `concilio_user` where id='".$argv[1]."' ";
	$res=mysqli_query($link, $query);

	while($role = mysqli_fetch_array($res, MYSQLI_ASSOC))
	{
		$user_array[] = $role;
	}
	foreach ($user_array as $key => $value) {
		echo "\n";
		foreach ($value as $key => $value) {
			echo $key;
			echo " - "; 
			echo $value;
			echo ";"; 
			echo "\n";

		}
		echo "\n";
	}
}
else
{
	$user_array = array();

	$query="select * from `concilio_user` ";
	$res=mysqli_query($link, $query);

	while($role = mysqli_fetch_array($res, MYSQLI_ASSOC))
	{
		$user_array[] = $role;
	}
	var_dump($user_array);
}
?>