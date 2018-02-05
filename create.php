<html>
   <head>
      <meta charset="utf-8">
      <title>Simple Web App</title>
      <link rel="stylesheet" type="text/css" href="css/style.css">
   </head>
   <body>
      <img width="400" src="http://resources.johnsonchiang.com/banner.png" referrerpolicy="origin"/>
      <h2>建立使用者</h2>
<?php 
if (isset($_POST['submit']))
{
	require "../config.php";
	require "../common.php";

	try 
	{
		$connection = new PDO($dsn, $username, $password, $options);
		
		$new_user = array(
			"firstname" => $_POST['firstname'],
			"lastname"  => $_POST['lastname'],
			"email"     => $_POST['email'],
			"age"       => $_POST['age'],
			"location"  => $_POST['location']
		);

		$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"users",
				implode(", ", array_keys($new_user)),
				":" . implode(", :", array_keys($new_user))
		);
		
		$statement = $connection->prepare($sql);
		$statement->execute($new_user);
	}
	catch(PDOException $error) 
	{
		echo $sql . "<br>" . $error->getMessage();
	}
	
}
?>

<?php 
if (isset($_POST['submit']) && $statement) 
{
?>
	<blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
<?php 
}
?>

      <form class="form-style" method="post">
         <ul>
            <li>
               <label for="firstname">First Name</label>
               <input type="text" name="firstname" maxlength="100">
               <span>輸入First Name</span>
            </li>
            <li>
               <label for="lastname">Last Name</label>
               <input type="text" name="lastname" maxlength="100">
               <span>輸入Last Name</span>
            </li>
            <li>
               <label for="email">Email Address</label>
               <input type="text" name="email" maxlength="100">
               <span>輸入Email</span>
            </li>
            <li>
               <label for="age">Age</label>
               <input type="text" name="age" maxlength="50">
               <span>輸入年齡數字</span>
            </li>
            <li>
               <label for="location">Location</label>
               <input type="text" name="location" maxlength="50">
               <span>輸入地點，例：HK, TPE, BJ, SH</span>
            </li>
            <li>
               <input type="submit" name="submit" value="Submit" >
               <a class="link-btn" href="index.html">返回首頁</a>
            </li>
         </ul>
      </form>
   </body>
</html>
