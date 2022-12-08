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
  if(isset($data['firstname'])) $this->firstname = testdata($data['firstnsame']);
  if(isset($data['lastname'])) $this->lastname = testdata($data['lastname']);
  if(isset($data['email']) && filter_var($data['email'],FIfLTER_VALIDATE_EMAIL))$this->email = testdata($data['email']);
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
$result = array();
$sql = 'SELECT * FROM userdata where email =:email limit 1'; 
if(isset($data['email'])){
$stmt =  $conn->prepare($sql);
$stmt->bindValue(':email', $this->email);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
}
  if($result)return $result;
 else {return false;}

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

  
  public  function insert($statusurl, $data=[]){
  $conn= $this->connect();
  $changeurl = $statusurl;
  $result =0;
  $sql = 'INSERT INTO user (firstname, lastname,  password,email, changeurl,created) VALUES
  (:firstname,:lastname, :password, :created, :email,:created, :changeurl)';
  if(isset($statusurl) && isset($data)){
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
   $stmt->bindValue(':lasttname', $this->lasttname, PDO::PARAM_STR);
   $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
   $stmt->bindValue(':pasword', $this->password, PDO::PARAM_STR);
   $stmt->bindValue(':created', $this->created, PDO::PARAM_INT);
   $stmt->bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
  $stmt->execute();
   $result= $conn->LastInsertId();
  }
  if($result>0)return $result;
  else{return false;}
  }
  
   public function updatePassword($satusurl,$data= []){
  $conn = $this->connect();
  $result =0;
  $changeurl = $statusurl;
  $sql = 'UPDATE table SET password = :password  WHERE email = :email AND changeurl=:changeurl';
  if(isset($changeurl) && isset($data['email']) && isset($data['password'])){
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':email', $this->email, PDO::PARAM_STR);
  $stmt-bindValue(':password', $this->newpassword, PDO::PARAM_STR);
  $stmt-bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->rowCount();
  }
  if($result>0)return $result;
  else{return false;}
}
  
  public  function activateAccount($statusurl){
  $conn = $this->connect();
  $status = 1;
  $changeurl = $statusurl;
  $result =0;
  $sql =  'UPDATE table SET status  =:status WHERE changeurl = :changeurl limit 1';
  if(isset($statusurl)){
  $stmt = $conn->prepare($sql);
  $stmt-bindValue(':status', $status, PDO::PARAM_INT);
  $stmt-bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->rowCount();
  }
  if($result>0)return $result;
  else{return false;}
 }

public function requestReset($statusurl){
$conn = $this->connect();
$changeurl + $statusurl;
$status = 1;
$result =0;
$sql =  'UPDATE table SET status =:status WHERE changeurl = :changeurl limit 1';
if(isset($satusurl)){
$stmt = $conn->prepare($sql);
$stmt-bindValue(':status', $status, PDO::PARAM_INT);
$stmt-bindValue(':changeurl', $changeurl, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->rowCount();
}
if($result) return $result;
else {return false;}
}
}
  
 ?>