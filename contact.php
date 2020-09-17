<?php
include("header.php");
require_once('dao/abstractDAO.php');
require_once('dao/customerDAO.php');
require_once('PasswordHash.php')


?>

<?php

	try {
		$customerDAO = new customerDAO();
		$abstractDAO = new abstractDAO();
		$iserror = false;
		$errormessage = Array();



			if (isset($_POST['customerName']) || isset($_POST['phoneNumber']) || isset($_POST['emailAddress']) 		|| isset($_POST['referral'])) {
				
				
			if ($_POST['customerName'] == "") {
				$iserror = true;
				$errormessage['customerName'] = "Please enter your name";
			}
			
			
			if ($_POST['phoneNumber'] == "") {
						$errormessage['phoneNumber'] = "Please enter a phone number";
						$iserror = true;
			}
			
			if($_POST['phoneNumber'] !=0 && (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $_POST['phoneNumber']))){
						$errormessage['phoneNumber'] = "The phone number you input is not in a valid format";
						$iserror = true;
			}
			
			
			if (empty ( $_POST ['emailAddress'] ) || (! filter_var ( $_POST ['emailAddress'], FILTER_VALIDATE_EMAIL ))){
				$iserror = true;
				$errormessage['emailAddress'] = "Please enter a valid email";
			}
			
			
			
			$emailCheck=$_POST['emailAddress'];
			$sql= "SELECT * FROM mailingList where emailAddress = '$emailCheck'";
			$email = $abstractDAO->getMysqli()->query($sql);
			$numberaffect = $abstractDAO->getMysqli()->affected_rows;
			
			if($numberaffect != 0){
				$iserror = true;
				$errormessage['emailAddress'] = "you enter duplicate Email Address.";
			}
			
			if (empty($_POST['referral'])) {
				$iserror = true;
				$errormessage['referral'] = "Please enter a referral";
			}
			if (!$iserror) {
				$email = $_POST['emailAddress'];
				$customer = new Customer($_POST['customerName'], $_POST['phoneNumber'], $email, $_POST['referral']);
				$addSuccess = $customerDAO->addCustomer($customer);
            echo '<h4>' . $addSuccess . '</h4>';


			if (isset($_POST["btnSubmit"])){
				$target_path = "files/";  
				$target_path = $target_path.basename( $_FILES['uploadedfile']['name']); 
			
				if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)){
					echo 'file ' . basename( $_FILES['uploadedfile']['name']).' has been uploaded';
				}else{
					echo " error uploading  file.";
				}
			}
        }
    }

		?>

    <div id="content" class="clearfix">
        <aside>
            <h2>Mailing Address</h2>
            <h3>1385 Woodroffe Ave<br>
                Ottawa, ON K4C1A4</h3>
            <h2>Phone Number</h2>
            <h3>(613)727-4723</h3>
            <h2>Fax Number</h2>
            <h3>(613)555-1212</h3>
            <h2>Email Address</h2>
            <h3>info@wpeatery.com</h3>
        </aside>
        <div class="main">
            <h1>Sign up for our newsletter</h1>
            <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP
                eatery!</p>
            <form name="frmNewsletter" id="frmNewsletter" method="post" enctype= "multipart/form-data" action="contact.php">
                <table>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="customerName" id="customerName" placeholder="Peng Wang"
                                   size='40'>
                            <?php
                            if (isset($errormessage['customerName']))
                                echo '<span style=\'color:red\'>'.$errormessage['customerName'].'</span>'; ?></td>

                    </tr>
                    <tr>
                        <td>Phone Number:</td>
                        <td><input type="text" name="phoneNumber" id="phoneNumber" placeholder="613-123-1234" size='40'>
                            <?php
                            if (isset($errormessage['phoneNumber']))
                                echo '<span style=\'color:red\'>'.$errormessage['phoneNumber'].'</span>'; ?></td>
                    </tr>
                    <tr>
                        <td>Email Address:</td>
                        <td><input type="text" name="emailAddress" id="emailAddress" placeholder="lucky123@gmail.com"
                                   size='40'>
                            <?php
                            if (isset($errormessage['emailAddress']))
                                echo '<span style=\'color:red\'>'.$errormessage['emailAddress'].'</span>'; ?></td>
                    </tr>
                    <tr>
                        <td>How did you hear<br> about us?</td>
                        <td>Newspaper<input type="radio" name="referral" id="referralNewspaper" value="newspaper">
                            Radio<input type="radio" name='referral' id='referralRadio' value='radio'>
                            TV<input type='radio' name='referral' id='referralTV' value='TV'>
                            Other<input type='radio' name='referral' id='referralOther' value='other'>
                            <?php
                            if (isset($errormessage['referral']))
                                echo '<span style=\'color:red\'>'.$errormessage['referral'].'</span>'; ?></td>
                    </tr>
					
					
					<tr> 
						<td>Choose a file to upload </td>
					</tr>
					<tr>
						<td><input type = "file" name = "uploadedfile" ></td>
					</tr>
					
					
                    <tr>
                        <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input
                                    type='reset' name="btnReset" id="btnReset" value="Reset Form"></td>
                    </tr>
                </table>
            </form>
        </div><!-- End Main -->
    </div><!-- End Content -->

    <?php
	

	
		}catch(Exception $e){	
			echo '<h3>Error on page.</h3>';
			echo '<p>' . $e->getMessage() . '</p>';
		}
?>

<?php include("footer.php"); ?>
