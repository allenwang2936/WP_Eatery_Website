<?php 

require_once('header.php');
require_once('dao/customerDAO.php');

$customerDAO = new customerDAO;
$delete = false;			
	
$deleteID = "";	
$del_user = false;
if(isset($_POST['id'])){
									
	if ($_POST['id'] != ""){	
		$delete = true;
		$deleteID = $_POST['id'];				           					
		$del_user = $customerDAO->deleteUser($deleteID);		
	}						
}
	$deleteID = "";
	
if($delete == true){		
	if ($del_user == true){
		echo '<span style=\'color:red\'> successful deleted </span>';
		$delete = false;		
	}else{
	//echo '<span style=\'color:red\'> fail deleted</span>';				
		header("location:userlogin.php");
	}
}
			
?>

	
<form  method="post" action = "<?php echo $_SERVER["PHP_SELF"];?>">	  
	INPUT ID<input type="text" name="id"  placeholder="id">			  
			<input type="submit" name="delete"  value="Delete">		
</form> 
    

<?php

require_once('footer.php');

?>