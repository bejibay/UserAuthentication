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
public $updated = null;
public $status = null;

public function __construct($data = array()){
  if(isset($data['id'])&& is_int(data['id']))$this->id = testdata($data['id']);
  if(isset($data['firstname'])) $this->firstname = testdata($data['firstname']);
  if(isset($data['lastname'])) $this->lastname = testdata($data['lastname']);
  if(isset($data['email']) && filter_var($data['email'],FILTER_VALIDATE_EMAIL))$this->email = testdata($data['email']);
//set password pattern
$passwordpattern ="/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#\-_$%^&+=§!\?])
[0-9A-Za-z@#\-_$%^&+=§!\?]{8}$/";
  if(isset($data['password']) &&  preg_match($passwordpattern,$data['password'])) 
  $this->password = $data['password'];
  if(isset($data['confirmpassword']) &&  preg_match($passwordpattern,$data['confirmpassword'])) 
  $this->confirmpassword = $data['confirmpassword'];
  if(isset($data['newpassword']) &&  preg_match($passwordpattern,$data['newpassword'])) 
  $this->newpassword = $data['newpassword'];
  if(isset($data['created']))$this->created = $data['created'];
  if(isset($data['updated']))$this->updated = $data['updated'];
}
  
 public function connect(){
try{$this->conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $this->conn;
}
catch(Exception $e){
throw new Exception("failed to connect".$e->getMessage);
}
}


 public function verifyEmail($data=[]){
$conn = $this->connect();
$sql = 'SELECT * FROM userdata where email =:email limit 1'; 
if(isset($data['email'])){
$stmt =  $conn->prepare($sql);
$stmt->bindValue(':email', $this->email);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result)return $result;
 else {return false;}
}
}

 public function verifyPassword($data=[]){
$conn= $this->connect();
if(isset($data['email']) && isset($data['password'])){
$result = $this->verifyEmail($data['email']);
if($result){
 if(password_verify($this->password, $result['password'])) return true;
 else{return false;}
 }
 }
}

  
  public  function insert($changeurl, $data=[]){
  $conn= $this->connect();
  $sql = 'INSERT INTO userdata(firstname, lastname, email, password, changeurl) VALUES
  (:firstname,:lastname,:email, :password,:changeurl)';
  if(isset($changeurl) && isset($data['firstname']) && isset($data['lastname']) && isset($data['email']) 
  && isset($data['password'])){
  $result1  =$this->verifyEmail($data['email']);
  if($result1){
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
  $stmt->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
  $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
  $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
  $stmt->bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
  $stmt->execute();
  $result2= $conn->LastInsertId();
  if($result2)return $result2;
  else{return false;}
  }
  }
}
  
   public function updatePassword($changeurl,$data= []){
  $conn = $this->connect();
  $sql = 'UPDATE userdata SET password = :password  WHERE email = :email AND changeurl=:changeurl';
  if(isset($changeurl) && isset($data['email']) && isset($data['password'])){
  $result1 = $this->verifyEmail($data['email']);
  if($result1){
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':email', $this->email, PDO::PARAM_STR);
  $stmt-bindValue(':password', $this->newpassword, PDO::PARAM_STR);
  $stmt-bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
  $stmt->execute();
  $result2 = $stmt->rowCount();
  if($result2)return $result;
  else{return false;}
  }
}
}
  
  public  function activateAccount($chaneurl){
  $conn = $this->connect();
  $status = 1;
   $sql =  'UPDATE userdata SET status  =:status WHERE changeurl = :changeurl limit 1';
  if(isset($changeurl)){
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':status', $status, PDO::PARAM_INT);
  $stmt-bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->rowCount();
  if($result>0)return $result;
  else{return false;}
  }
 }

public function requestReset($changeurl, $data=[]){
$conn = $this->connect();
$sql =  'UPDATE userdata SET changeurl =:url WHERE email = :email limit 1';
if(isset($changeurl) && isset($data['email'])){
$stmt = $conn->prepare($sql);
$stmt-bindValue(':url', $changeurl, PDO::PARAM_STR);
$stmt-bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->rowCount();
if($result) return $result;
else {return false;}
}
}
}
  
 ?>