<?php
function testdata($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = strip_tags($data);
  return $data;
}

Class User {
protected $conn = null;
public $id = null;
public $firstname = '';
public $lastname = '';
public $email = '';
public $password = '';
public $confirmpassword ='';
public $newpassword = '';
public $created = null;
public $status = null;

public function __construct($data = array()){
  if(isset(data['id'])) $this->id = int(testdata($data['id']));
  if(isset(data['firstname'])) $this->firstname = testdata($data['firstnsame']);
  if(isset(data['lastname'])) $this->lastname = testdata($data['lastname']);
  if(isset(data['email'])) $this->lastname = filter_var(testdata($data['lastname']),FILTER_VALIDATE_EMAIL);
//set password pattern
$passwordpattern ="/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#\-_$%^&+=§!\?])
[0-9A-Za-z@#\-_$%^&+=§!\?]{8}$/";
  if(isset($data['password'])) $this->password = preg_match($passwordpattern,$data['password']);
  if(isset($data['confirmpassword'])) $this->confirmpassword = preg_match($passwordpattern,$data['confirmpassword']);
  if($this->password == $this->confirmpassword) $this->password = hash_password($this->password,PASSWORD_BCRYPT);
 if(isset($data['created']))$this->created = date_format($data['created'],'Y-m-d');
}
  
 function connect(){
try{$this->conn = new PDO(DSN, USERNAME, PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $this->conn;
}
catch(PDOException $e){
die("falied to connect to database" . $e->getMessage());
}
}


 function verifyEmail($email){
if(isset($email)){
$this->connect();
$sql = 'SELECT email FROM user where email =:email limit 0,1'; 
$stmt =  $conn->prepare($sql);
$stmt->bindValue('email', $email);
$stmt->execute();
$emailResult = $stmt->fetch();
  return $emailResult;
  }
}

 function verifyPassword($email, $password){
if(isset($email )&& isset($password)){
  $password = hash_password($password,PASSWORD_BCRYPT);
$this->connect();
$this->verifyEmail();
if(count($emailResult)>0){
  $sql = 'SELECT `email`,`password`,`firstname`, `lastname` FROM `user`  where `email` =:email limit 0,1';  
  $stmt  = $conn->prepare($sql);
  $stmt->bindValue(':email',$email, PDO::PARAM_STR);
  $stmt->bindValue(':password',$password, PDO::PARAM_STR);
  $tmtt->execute();
  $pwResult = $stmt->fetch(PDO::FETCH_ASSOC);
  return $pwResult;

}

}
}
  
   function insert(){
  $this->connect();
  $sql = 'INSERT INTO user (firstname, lastname, status, activationurl, email, password, created) VALUES
  (:firstname,:lastname, :password, :created, :email,:status, :created, :activationurl)';
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(':firstname', $this->firstname. PDO::PARAM_STR);
   $stmt->bindValue(':lasttname', $this->lasttname. PDO::PARAM_STR);
   $stmt->bindValue(':email', $this->email. PDO::PARAM_STR);
   $stmt->bindValue(':pasword', $this->pattword. PDO::PARAM_STR);
   $stmt->bindValue(':created', $this->created. PDO::PARAM_INT);
   $stmt->bindValue(':status', $this->status. PDO::PARAM_INT);
   $stmt->bindValue(':activationurl', $this->activationurl. PDO::PARAM_STR);
  $stmt->execute();
  if($conn->LastInsertId()){$successInsert =  "success insert"; return $successInsert;}
  }
  
   function updatepassword(){
  $this->connect();
  $sql = 'UPDATE table SET password = :password  WHERE email = :email';
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':email', $thsi->email, PDO::PARAM_STR);
  $stmt-bindValue(':password', $this->password, PDO::PARAM_STR);
  $stmt->execute();
  if($tmt->execute()) {$result = "password successfully updated"; return $result;}
  }
  
   function activateaccount($url){
  if(isset($url)){
  $url =$_GET['activationurl'];
  $this->connect();
  $status = 1;
  $sql =  'UPDATE table SET status  =:status WHERE activationurl = :activationurl limit 0,1';
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':status', $status, PDO::PARAM_INT);
  $stmt-bindValue(':actionurl', $actionurl, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetch();
  return $result;
  }
  }
  }
 ?>