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
public $hashpassword = '';

public function __construct($data = array()){
  if(isset(data['id'])&& is_int(data['id']))$this->id = testdata($data['id']);
  if(isset(data['firstname'])) $this->firstname = testdata($data['firstnsame']);
  if(isset(data['lastname'])) $this->lastname = testdata($data['lastname']);
  if(isset(data['email']) && filter_var($data['lastname'],FIfLTER_VALIDATE_EMAIL)) $this->email = testdata($data['lastname']);
//set password pattern
$passwordpattern ="/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#\-_$%^&+=§!\?])
[0-9A-Za-z@#\-_$%^&+=§!\?]{8}$/";
  if(isset($data['password']) &&  preg_match($passwordpattern,$data['password'])) $this->password = testdata($data['password']);
  if(isset($data['confirmpassword']) &&  preg_match($passwordpattern,$data['confirmpassword'])) $this->confirmpassword = testdata($data['confirmpassword']);
  if(isset($data['newpassword']) &&  preg_match($passwordpattern,$data['newpassword'])) $this->newpassword = testdata($data['newpassword']);
  if($this->password == $this->confirmpassword) $this->hashpassword = hash_password($this->password,PASSWORD_BCRYPT);
  if($this->newpassword == $this->confirmpassword) $this->hashpassword = hash_password($this->newpassword,PASSWORD_BCRYPT);
 if(isset($data['created']))$this->created = date_format($data['created'],'Y-m-d');
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
$sql = 'SELECT email,password FROM user where email =:email limit 0,1'; 
$stmt =  $conn->prepare($sql);
$stmt->bindValue('email', $email);
$stmt->execute();
$emailResult = $stmt->fetch(PDO::FETCH_ASSOC());
  return $emailResult;
  if(!$emailResult)return false;
}

 function verifyPassword(){
$conn= $this->connect();
$this->verifyEmail();
if(count($emailResult)>0){
 if(verify_password($password, $emailResult['password'])){
  $sql = 'SELECT `email`,`firstname`, `lastname` FROM `user`  where `email` =:email limit 0,1';  
  $stmt  = $conn->prepare($sql);
  $stmt->bindValue(':email',$email, PDO::PARAM_STR);
  $stmt->bindValue(':password',$password, PDO::PARAM_STR);
  $tmt->execute();
  $pswResult = $stmt->fetch(PDO::FETCH_ASSOC);
  if($pswResult) return $pwResult;
  else{return false;}
 }
 
}
}

  
   function insert(){
  $conn= $this->connect();
  $sql = 'INSERT INTO user (firstname, lastname, status, changeurl, email, password, created) VALUES
  (:firstname,:lastname, :password, :created, :email,:status, :created, :changeurl)';
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(':firstname', $this->firstname. PDO::PARAM_STR);
   $stmt->bindValue(':lasttname', $this->lasttname. PDO::PARAM_STR);
   $stmt->bindValue(':email', $this->email. PDO::PARAM_STR);
   $stmt->bindValue(':pasword', $this->pattword. PDO::PARAM_STR);
   $stmt->bindValue(':created', $this->created. PDO::PARAM_INT);
   $stmt->bindValue(':status', $this->status. PDO::PARAM_INT);
   $stmt->bindValue(':changeurl', $this->changeurl. PDO::PARAM_STR);
  $stmt->execute();
   $successInsert= $conn->LastInsertId();
  if($successInsert)return $successInsert;
  else{return false;}
  }
  
   function updatepassword(){
    $pswupdate = 0;
  $conn = $this->connect();
  $sql = 'UPDATE table SET password = :password  WHERE email = :email';
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':email', $this->email, PDO::PARAM_STR);
  $stmt-bindValue(':password', $this->password, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->rowCount();
  if($result)return $result;
  else{return false;}
}
  
   function activateaccount(){
    $activatestatuss = 0;
  $conn = $this->connect();
  $status = 1;
  $sql =  'UPDATE table SET status  =:status WHERE changeurl = :changeurl limit 0,1';
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':status', $status, PDO::PARAM_INT);
  $stmt-bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->rowCount();
  return $result;
  if(!$result) return false;

   }

   function resetaccountstatus(){
    $accountsatuss = 0;
  $conn = $this->connect();
  $status = 1;
  $sql =  'UPDATE table SET status  =:status WHERE statuschangeurl = :statuschangeurl limit 0,1';
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':status', $status, PDO::PARAM_INT);
  $stmt-bindValue(':statuschangeurl', $statuschangeurl, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->rowCount();
  return $result;
  if(!$result) return false;

   }

  }
  
 ?>