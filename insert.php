<?php
$name= $_POST['name'];
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];

if(!empty($name) || !empty($username) || !empty($email) || !empty($password)) {
	$host="localhost";
	$dbusername="root";
	$dbpassword="";
	$dbname="youtube";

// create connection

	$conn=new mysqli($host,$dbusername,$dbpassword,$dbname);

	if(mysqli_connect_error()) {
		die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
	} else{
		$SELECT="SELECT email From register Where email = ? Limit 1 ";
		$INSERT="INSERT Into register(name,username,password,email) values(?,?,?,?)";

// prepare statement
		$stmt=$conn->prepare($SELECT);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum=$stmt->num_rows;

		if($rnum==0){
			$stmt->close();
			$stmt=$conn->prepare($INSERT);
			$stmt->bind_param("ssss",$name,$username,$email,$password);
			$stmt->execute();
			echo "New record inserted successfully";

		} else {
			echo "Someone already resgistered using this email ";
		}
		$stmt->close();
		$conn->close();
	}

}

else{
	echo "All fields are required";
	die();

}


?>