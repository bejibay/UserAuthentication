<?php
// sanitise the incoming dara
function testdata($data){
$data = trim($data);
$data = stripslashes($data);
$data = strip_tags($data);
return $data;
}

Class User {

  // Defibe class properties
 protected $conn = null;
public $id = null;
public $firstname = '';
public $lastname = '';
public $email = '';
public $password = '';
public $confirmpassword ='';
public $newpassword = '';
public $created = null;
public $updated = null;
public $status = null;

// to initialise the properties
public function __construct($data = array()){
  if(isset($data['id'])&& is_int(data['id']))$this->id = testdata($data['id']);
  if(isset($data['firstname'])) $this->firstname = testdata($data['firstname']);
  if(isset($data['lastname'])) $this->lastname = testdata($data['lastname']);
  
  if(isset($data['email']) && filter_var($data['email'],FILTER_VALIDATE_EMAIL))$this->email = testdata($data['email']);
//set password pattern
$passwordpattern ="/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#\-_$%^&+=§!\?]).{8,}$/";
  if(isset($data['password']) &&  preg_match($passwordpattern,$data['password'])) 
  $this->password = $data['password'];
  if(isset($data['confirmpassword']) &&  preg_match($passwordpattern,$data['confirmpassword'])) 
  $this->confirmpassword = $data['confirmpassword'];
  if(isset($data['newpassword']) &&  preg_match($passwordpattern,$data['newpassword'])) 
  $this->newpassword = $data['newpassword'];
  if(isset($data['created']))$this->created = $data['created'];
  if(isset($data['updated']))$this->updated = $data['updated'];
}
  
//different methods coded out as follows
public function connect(){
try{
$this->conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $this->conn;
}
catch(PDOException $e){
throw new Exception ("failed connection".$e->getMessage());
}
} 


public function verifyEmail(){
$conn = $this->connect();
$sql = 'SELECT * FROM userdata where email =:email limit 1'; 
$stmt =  $conn->prepare($sql);
$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll();
return $result;
}

public function verifyPassword(){
$conn = $this->connect();
$result = $this->verifyEmail();
if(is_array($result)){
$hash = $result[0]['password'];
}
if(password_verify($this->password, $hash)){
return true;
}else {return false; 
}
}


public  function insert(){
$conn = $this->connect();
$sql = 'INSERT INTO userdata(firstname, lastname, email, password, changeurl) VALUES 
(:firstname,:lastname,:email, :password,:changeurl)';
$stmt = $conn->prepare($sql);
$changeurl = md5(rand(0,999).time());
$stmt->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
$stmt->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
$stmt->bindValue(':password', password_hash($this->password,PASSWORD_DEFAULT), PDO::PARAM_STR);
$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
$stmt->bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
$stmt->execute();
$result= $conn->LastInsertId();
return $result;
}

  
public function updatePassword($changeurl){
$conn = $this->connect();
$sql = 'UPDATE userdata SET password = :password  WHERE email = :email AND changeurl=:changeurl';
$stmt = $conn->prepare($sql);
$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
$stmt->bindValue(':password', $this->newpassword, PDO::PARAM_STR);
$stmt->bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->rowCount();
return $result;
}
 
public function activateAccount($changeurl){
$conn = $this->connect();
$status = 1;
$sql = 'UPDATE userdata SET status  =:status WHERE changeurl = :changeurl limit 1';
$stmt = $conn->prepare($sql);
$stmt->bindValue(':status', $status, PDO::PARAM_INT);
$stmt->bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->rowCount();
return $result;
}
 
public function requestReset($changeurl){
$conn = $this->connect();
$sql = 'UPDATE userdata SET changeurl =:changeurl WHERE email = :email limit 1';
$stmt = $conn->prepare($sql);
$stmt->bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->rowCount();
return $result;
}
}

 ?>