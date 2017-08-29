<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title></title>
</head>
<body>
<? 
include "db.php";
include('lang.php');
echo '<a href="/index.php">'.mainpage.'</a><br><br><form action="auth.php" method="POST" id="form1">
<select name="login" form="form1">'; 
if ($rs = $mysqli->query('SELECT login from pass'))
 while ($line = mysqli_fetch_array($rs)) {
 echo '<option value="'.$line['login'].'">'.$line['login'].'</option>';
    }
?>
</select>
<input type = "password" placeholder="password" name="password"><br>
<button type="submit">Login</button>
</form>
</body>
</html>