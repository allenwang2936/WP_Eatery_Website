<?php

 
require_once('header.php');
require_once('dao/customerDAO.php');
require_once('WebsiteUser.php');


session_start();
session_regenerate_id(false);


if(isset($_SESSION['AdminID'])){
    if(!$_SESSION['websiteUser']->isAuthenticated()){
       header('Location:userlogin.php'); 
    }
} else {
    header('Location:userlogin.php');
}


	$customerDAO = new customerDAO;
	$customers = $customerDAO->getCustomers();

		
		echo '<div>'.'Session AdminID = ' . $_SESSION['websiteUser']->getID().'</div>';
		if ($_SESSION['websiteUser']->getLastLogin()!=null){
			date_default_timezone_set('America/Toronto');
			$_SESSION['Lastlogin'] = date('m/d/Y');
			echo '<div>'.'Last Login Date = '. $_SESSION['Lastlogin'] .'</div>';
		}else{
			echo '<div>'.'your first time to login in'.'</div>';
		}
		echo("<button onclick=\"location.href='logout.php'\">Logout!</button>");
		
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		$connect = mysqli_connect("127.0.0.1","wp_eatery", "password","wp_eatery");
		$query= 'SELECT *FROM MailingList';
		$result = $connect->query($query);
		
	
		echo '<table style= \"text-align：center;\" border ="1">';
		echo '<tr>';
		echo '<th>ID</th>';
		echo '<th>Customer name</th>';
		echo '<th>Phone</th>';
		echo '<th>Email</th>';
		echo '<th>Referrer</th>';
		echo '</tr>';
		while ($row=mysqli_fetch_array($result)){
			echo '<tr>';
			echo '<td style = "text-align：center">'.$row['_id'].'</td>';
			echo '<td style = "text-align：center">'.$row['customerName'].'</td>';
			echo '<td style = "text-align：center">'.$row['phoneNumber'].'</td>';
			echo '<td style = "text-align：center">'.$row['emailAddress'].'</td>';
			echo '<td style = "text-align：center">'.$row['referrer'].'</td>';
			echo '</tr>';
		}
			echo '<table>';
			mysqli_close($connect);
?>


<?php include 'footer.php';?>