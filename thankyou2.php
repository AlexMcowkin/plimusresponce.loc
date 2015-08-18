<?php

require_once('Models/connect_db.php');

$BlueSnapIps = array("62.216.234.196", "62.216.234.197", "62.216.234.198", "62.216.234.199", "62.216.234.200", "62.216.234.201", "62.216.234.202", "62.216.234.203", "62.216.234.204", "62.216.234.205", "62.216.234.206", "62.216.234.207", "62.216.234.208", "62.216.234.209", "62.216.234.210", "62.216.234.211", "62.216.234.212", "62.216.234.213", "62.216.234.214", "62.216.234.215", "62.216.234.216", "62.216.234.217", "62.216.234.218", "62.216.234.219", "62.216.234.220", "62.216.234.221", "62.216.234.222", "72.20.107.242", "72.20.107.243", "72.20.107.244", "72.20.107.245", "72.20.107.246", "72.20.107.247", "72.20.107.248", "72.20.107.249", "72.20.107.250", "209.128.93.97", "209.128.93.98", "209.128.93.99", "209.128.93.100", "209.128.93.101", "209.128.93.102", "209.128.93.103", "209.128.93.104", "209.128.93.105", "209.128.93.106", "209.128.93.107", "209.128.93.108", "209.128.93.109", "209.128.93.110", "209.128.93.225", "209.128.93.226", "209.128.93.227", "209.128.93.228", "209.128.93.229", "209.128.93.230", "209.128.93.231", "209.128.93.232", "209.128.93.233", "209.128.93.234", "209.128.93.235", "209.128.93.236", "209.128.93.237", "209.128.93.238", "209.128.93.239", "209.128.93.240", "209.128.93.241", "209.128.93.242", "209.128.93.243", "209.128.93.244", "209.128.93.245", "209.128.93.246", "209.128.93.247", "209.128.93.248", "209.128.93.249", "209.128.93.250", "209.128.93.251", "209.128.93.252", "209.128.93.253", "209.128.93.254", "209.128.93.255", "62.219.121.253", "99.186.243.9", "99.186.243.10", "99.186.243.11", "99.186.243.12", "99.186.243.13", "99.180.227.233", "99.180.227.234", "99.180.227.235", "99.180.227.236", "99.180.227.237", "209.128.104.18", "209.128.104.19", "209.128.104.20", "209.128.104.21", "209.128.104.22", "209.128.104.23", "209.128.104.24", "209.128.104.25", "209.128.104.26", "209.128.104.27", "209.128.104.28", "209.128.104.29", "209.128.104.30", "209.128.104.31", "209.128.104.32", "209.128.104.33", "209.128.104.34", "209.128.104.35", "209.128.104.36", "209.128.104.37", "127.0.0.1", "localhost");

//Check if the request came from BlueSnap IP
if (array_search($_SERVER['REMOTE_ADDR'], $BlueSnapIps) == false)
{
	exit($_SERVER['REMOTE_ADDR'] . " is not a BlueSnap server!!!");
}
else
{
	//Put IPN Parameters in local varibales
	echo $transactionType = $_REQUEST['transactionType'];
	//$transactionDate = $_REQUEST['transactionDate'];
	echo $productName = $_REQUEST['productName'];
	//$firstName = $_REQUEST['firstName'];
	//$lastName = $_REQUEST['lastName'];
	echo $fullName = $_REQUEST['firstName'].' '.$_REQUEST['lastName'];
	echo $email = $_REQUEST['email'];
	echo $email2 = 'emailname@gmail.com';
	echo $contractPrice = $_REQUEST['contractPrice'];
	
	switch($productName)
	{
		case 'iPhone': $zone = 'iPhone'; $access = 'iPhone'; break;
		case 'iPad': $zone = 'iPad'; $access = 'iPad'; break;
		case 'iPhone and iPad': $zone ='iPhone and iPad'; $access = 'full'; break;
		default: $zone = ''; $access = ''; break;
	}

	if ($transactionType == 'CHARGE')
	{
		// generate password
		$symbols = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789!@#$%_?<>^&';
		$strlen = iconv_strlen($symbols,'utf-8');
		$password = null;
		$lenght = 12;
		for ($i=1; $i<=$lenght; $i++)
		{
			$randsymnumber = mt_rand(0, $strlen);
			$symbol = substr($symbols, $randsymnumber,1);
			$password .=$symbol;
		}
		
		// insert data in DB
		$sql = $db->prepare('SELECT name FROM tbl_person WHERE email = :email LIMIT 1');
		$sql->bindParam(':email', $email);
		$sql->execute();
		$result = $sql->fetchAll();
		if ($sql->rowCount() == 1)
		{
			exit();
		}
		else
		{
			$sql = "INSERT INTO tbl_person (`id`, `name`, `email`, `pass`, `access`, `payday`) VALUES (NULL, :name, :email, :pass, :access, :date)";
			$result = $this->database->prepare($sql);
			
			$result->bindParam(':name', $fullName);
			$result->bindParam(':email', $email);
			$result->bindParam(':pass', $password);
			$result->bindParam(':access', $access);
			$result->bindParam(':date', $date);

			$date = date('Y-m-d H:i:s');
			
			$result->execute();
		}
		
		// send email to customer
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=utf-8' . "\r\n"; 
		$header .= 'From: SiteName.com <support@SiteName.com>' . "\r\n";

		$title = 'Your purchase at SiteName.com';

		$message = " 
		Dear ".$fullName.",<br /><br />	Thank you for your order.";
		
		mail($email, $title, $message, $header);
		mail($email2, $title, $message, $header);
	}
}
?>