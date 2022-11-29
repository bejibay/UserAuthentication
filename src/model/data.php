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
  if(isset(data['id'])&& is_int(data['id']))$this->id = testdata($data['id']);
  if(isset(data['firstname'])) $this->firstname = testdata($data['firstnsame']);
  if(isset(data['lastname'])) $this->lastname = testdata($data['lastname']);
  if(isset(data['email']) && filter_var($data['email'],FIfLTER_VALIDATE_EMAIL)) $this->email = testdata($data['email']);
//set password pattern
$passwordpattern ="/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#\-_$%^&+=§!\?])
[0-9A-Za-z@#\-_$%^&+=§!\?]{8}$/";
  if(isset($data['password']) &&  preg_match($passwordpattern,$data['password'])) 
  $this->password = testdata(password_hash($data['password']),PASSWORD_BCRYPT);
  if(isset($data['confirmpassword']) &&  preg_match($passwordpattern,$data['confirmpassword'])) 
  $this->confirmpassword = testdata(password_verify($data['confirmpassword']),PASSWORD_BCRYPT);
  if(isset($data['newpassword']) &&  preg_match($passwordpattern,$data['newpassword'])) 
  $this->newpassword = testdata(password_verify($data['newpassword']),PASSWORD_BCRYPT);
  if(isset($data['created']))$this->created = $data['created'];
}
  
 function connect(){
try{$this->conn = new PDO(DSN, USERNAME, PASSWORD);
$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $this->conn;
}
catch(PDOException $e){
die("falied to connect to database" . $e->getMessage());
}
}


 function verifyEmail(){
$conn = $this->connect();
$sql = 'SELECT * FROM user where email =:email limit 1'; 
$stmt =  $conn->prepare($sql);
$stmt->bindValue(':email', $this->email);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC());
  if($result)return $result;
 else {return false;}
}

 function verifyPassword(){
$conn= $this->connect();
$result = $this->verifyEmail();
if(isset($result)){
 if(password_verify($this->password, $result['password'])) return true;
 else{return false;}
 }
 }

  
   function insert($url){
  $conn= $this->connect();
  $changeurl = $url;
  $sql = 'INSERT INTO user (firstname, lastname, changeurl, email, password, created) VALUES
  (:firstname,:lastname, :password, :created, :email,:created, :changeurl)';
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
   $stmt->bindValue(':lasttname', $this->lasttname, PDO::PARAM_STR);
   $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
   $stmt->bindValue(':pasword', $this->password, PDO::PARAM_STR);
   $stmt->bindValue(':created', $this->created, PDO::PARAM_INT);
   $stmt->bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
  $stmt->execute();
   $result= $conn->LastInsertId();
  if($result)return $result;
  else{return false;}
  }
  
   function updatePassword(){
  $conn = $this->connect();
  $sql = 'UPDATE table SET password = :password  WHERE email = :email';
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':email', $this->email, PDO::PARAM_STR);
  $stmt-bindValue(':password', $this->newpassword, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->rowCount();
  if($result)return $result;
  else{return false;}
}
  
   function activateAccount($url){
  $conn = $this->connect();
  $status = 1;
  $changeurl = $url;
  $sql =  'UPDATE table SET status  =:status WHERE changeurl = :changeurl limit 1';
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':status', $status, PDO::PARAM_INT);
  $stmt-bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->rowCount();
  if($result)return $result;
  else{return false;}
 }

function resetAccountStatus($url){
$conn = $this->connect();
$changeurl + $url;
$status = 1;
$sql =  'UPDATE table SET status =:status WHERE changeurl = :changeurl limit 1';
$stmt = $conn->prepare($sql);
$stmt-bindValue(':status', $status, PDO::PARAM_INT);
$stmt-bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->rowCount();
if($result) return $result;
else {return false;}
}
}
  
 ?>