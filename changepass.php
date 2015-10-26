<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "korn40236", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Change Password Form
<hr>

<?PHP
	if(isset($_POST['submit'])){
		$oldpassword = trim($_POST['oldpassword']);
		$password = trim($_POST['password']);
		$confirm = trim($_POST['confirm']);
		if($confirm ==$password){
		$query = "SELECT * FROM LOGIN WHERE PASSWORD='$oldpassword'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row){
		$query = "update LOGIN set PASSWORD ='$password' WHERE PASSWORD='$oldpassword'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
			echo '<script>window.location = "MemberPage.php";</script>';
		}else{
			echo "can't change password";
		}
		}else{
			echo "can't change password";
		}
	};
	oci_close($conn);
	if(isset($_POST['submit2'])){
	    $parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
			echo '<script>window.location = "MemberPage.php";</script>';
	}
?>

<form action='changepass.php' method='post'>
	<p>Old Password<br>
	  <input name='oldpassword' type='input'>
	  <br>
	New Password
	<br>
	<input name='password' type='input'>
  </p>
  <p>Confirm Password  </p>
	<p>
	  <input name='confirm' type='input' id="random" />
	  <br>
	  <br>
	  <input name='submit' type='submit' value='ok'>
      <input name='submit2' type='submit' value='back'>
  </p>
</form>

