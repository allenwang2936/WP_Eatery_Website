<?php
require_once('abstractDAO.php');
require_once('./model/customer.php');


class customerDAO extends abstractDAO{

    function __construct()
    {
        try {
            parent::__construct();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function getCustomers()
    {
  
        $result = $this->mysqli->query('SELECT * FROM mailingList');
        $customers = array();

        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_assoc()) { 
                $customer = new Customer($row['customerName'], $row['phoneNumber'], $row['emailAddress'], $row['referrer']);
                $customers[] = $customer;
            }
            $result->free();
            return $customers;
        }
        $result->free();
        return false;
    }

    public function getID()
    {
        $result = $this->mysqli->query('SELECT * FROM mailingList');  
        $ID = array();

        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_assoc()) {  
                $id = $row['_id'];
                $ID[] = $id;
            }
            $result->free();
            return $ID;
        }
        $result->free();
        return false;
    }

  
    public function getCustomer($_id)
    {
        $query = 'SELECT * FROM mailingList WHERE _id = ?';
        $stmt = $this->mysqli->prepare($query); 
        $stmt->bind_param('i', $_id);  
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $temp = $result->fetch_assoc();
            $customer = new customer($temp['customerName'], $temp['phoneNumber'], $temp['emailAddress'], $temp['referrer']);
            $result->free();
            return $customer;
        }
        $result->free();
        return false;
    }


    public function addCustomer($customer){
		
        if (!$this->mysqli->connect_errno) {     

            $query = 'INSERT INTO mailingList(customerName,phoneNumber,emailAddress,referrer) VALUES (?,?,?,?)';
           
            $stmt = $this->mysqli->prepare($query);
          
            $name = $customer->getName();
            $phone = $customer->getPhone();
           $email = $customer->getEmail();
			$hash = password_hash($email,PASSWORD_DEFAULT);
            $ref = $customer->getReferrer();

            $stmt->bind_param('ssss', $name, $phone, $hash, $ref);  
			$stmt->execute();
            
            if ($stmt->error) {
                return $stmt->error;
            } else {
                
                return $customer->getName() . ' signed up successfully!';
            }
        } else {
            return 'Sorry, could not connect to Database.';
        }
    }
	

	 public function deleteUser($id){
		 
	   if(!$this->mysqli->connect_errno){			
			$result = $this->mysqli->query("SELECT * FROM mailinglist WHERE _id =" . $id);				
		    if($result->num_rows == 0){         
              $result->free();
              return false;
		    }			
            $query = 'DELETE FROM mailinglist WHERE _id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
			
            if($stmt->error){
                return false;
            }else{
                return true;
            }	
        }else{	
            return false;
        }
    }
}
	
	?>