<?php
header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Allow-Methods: POST");
header ("Content-Type: application/json; charset=UTF-8");
header ("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



function msg($success,$status,$message){
    return array('success' => $success, 'status' => $status, 'message' => $message);
}

//include the content of a database.php

include_once '../webeng20g2/database.php';

//make an object
$db = new Database();

$conn = $db->getConnection();

//takes raw data from the request and converts it into a PHP object
$data = json_decode(file_get_contents("php://input"));

$returnData = [];


if ($_SERVER["REQUEST_METHOD"] != "POST"):
$returnData = msg(0,404,'Page not found');

//check the posted data 
elseif(!isset($data->firstname) || !isset($data->lastname) || !isset($data->email) || !isset($data->username) || !isset($data->password) ):

$returnData = msg(0,422,'Please Fill in all Required Fields!');

// if all fields are not empty then
else:
    
    	$firstname = trim($data->firstname);
    	$lastname = trim($data->lastname);
	$email = trim($data->email);
	$username = trim($data->username);
   	$password = trim($data->password);

//Check if the variable $email is not valid email address
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        $returnData = msg(0,422,'Invalid Email Address!');
    
    else:
        try{

            $stmt = $conn->prepare( "SELECT `email` FROM `users` WHERE `email`=:email");
            $stmt->bindValue(':email', $email,PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount()):
                $returnData = msg(0,422, 'This E-mail already in use!');
             
            else:
                $stmt = $conn->prepare("INSERT INTO `users`(`firstname`, `lastname`, `email`, `username`,`password`) VALUES(:firstname,:lastname,:email,:username,:password)");
 

                // Sanitize and bind values
                $stmt->bindValue(':firstname', htmlspecialchars(strip_tags($firstname)),PDO::PARAM_STR);
                $stmt->bindValue(':lastname', htmlspecialchars(strip_tags($lastname)),PDO::PARAM_STR);
		$stmt->bindValue(':email', $email,PDO::PARAM_STR);
                $stmt->bindValue(':username', htmlspecialchars(strip_tags($username)),PDO::PARAM_STR);
		$stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT),PDO::PARAM_STR);

                $stmt->execute();

                $returnData = msg(1,201,'You have successfully registered.');

            endif;

        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;
    
endif;

echo json_encode($returnData);


?>
