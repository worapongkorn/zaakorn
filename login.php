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
Login form
<hr>

<?PHP
	if(isset($_POST['submit'])){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$random = trim($_POST['random']);
		if($random ==1234){
		
		$query = "SELECT * FROM LOGIN WHERE ID='$username' and PASSWORD='$password'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row){
			$_SESSION['ID'] = $row['ID'];
			$_SESSION['NAME'] = $row['FIRST_NAME'];
			$_SESSION['SURNAME'] = $row['LAST_NAME'];
			echo '<script>window.location = "MemberPage.php";</script>';
		}else{
			echo "Login fail.";
		}
		}else{
			echo "Login fail.";
		}
	};
	oci_close($conn);
?>

<form action='login.php' method='post'>
	<p>Username <br>
	  <input name='username' type='input'>
	  <br>
	Password<br>
	<input name='password' type='password'>
  </p>
	<p>1234	  </p>
	<p>
	  <input name='random' type='input' id="random" />
	  <br>
	  <br>
	  <input name='submit' type='submit' value='Login'>
            </p>
</form>
