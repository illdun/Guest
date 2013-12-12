<?php

session_start();
include ('sql.php');
if ($_POST['action']=='Login')
{
	if (isset($_POST['login']) && isset($_POST['password']))
	{
		$connect = mysqli_connect($host,$login,$pass,$base);
		$password=md5($_POST['password']);
		$query = mysqli_query($connect, "SELECT `id` FROM `GBookusers` WHERE `login`='".mysqli_real_escape_string($connect, $_POST['login'])."' AND `password`='".mysqli_real_escape_string ($connect, $password)."' LIMIT 1");
		if (mysqli_num_rows($query) == 1) 
		{
			$myrow = mysqli_fetch_assoc($query);
		   $_SESSION['authorization'] = true;
		}
		else 
		{
			echo 'Неверный Логин или Пароль, попробуйте еще раз';
		}
	}
}
 
?>  

<html>
	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Fantastic Guest Book</title>
	</head>
	<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
	<script>
        tinymce.init({selector:'textarea'});
	</script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">
		<script>
			function formSubmit1()
			{
			document.getElementById("frm1").submit();
			}
		</script>
	<body>	
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div align="right"><a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg">Add comment</a></div>
</nav>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Adding comment</h4>
        </div>
        <div class="modal-body">
          <div>
			<form id="frm1" action="20.php" method="post">
			<INPUT TYPE="HIDDEN" NAME="action" VALUE ="save">
				<table>
					<tr>
						<td>Name</td>
						<td><input type="text" name="name"></td>
					</tr>
					<tr>
						<td>e-mail</td>
						<td><input type="text" name="email"></td>
					</tr>
					<tr>
						<td> comment</td>
						<td><textarea rows="10" cols="45" name="comment"></textarea></td>
					</tr>
				</table>
			</form>
		</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" onclick="formSubmit1()" class="btn btn-primary">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
     <br />
   <br />
   <br />
 <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
	<div align="right"><a data-toggle="modal" href="#Login" class="btn btn-primary btn-lg">Login</a></div>
</nav>
<script>
			function formSubmit2()
			{
			document.getElementById("frm2").submit();
			}
		</script>
 <!-- Modal -->
  <div class="modal fade" id="Login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Authorization</h4>
        </div>
        <div class="modal-body">
          <div>
			<form id="frm2" action="20.php" method="post">
			<INPUT TYPE="HIDDEN" NAME="action" VALUE ="Login">
				<table>
					<tr>
						<td>Login</td>
						<td><input type="text" name="login"></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="password" name="password"></td>
					</tr>
				</table>
			</form>
		</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" onclick="formSubmit2()" class="btn btn-primary">Sign in</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
    
<?php

$connect = mysqli_connect($host,$login,$pass,$base);
include "classes.php";
$newcomment = new Comment();
$newcomment->name=$_POST['name'];
$newcomment->email=$_POST['email'];
$newcomment->contents=$_POST['comment'];

if($_POST['action']=='save')
{
	$newcomment->save();
		if ($newcomment->checkform == true)
		{
?>
			<div class="container"><div class="alert alert-success"><?php echo "Данные успешно добавлены";?> </div> </div>
<?php			
		}
		elseif($newcomment->checkform== false)
		{	
?>	
			<div class="container"><div class="alert alert-danger"><?php echo "Заполните все поля"; ?> </div></div>
<?php
		}
}
if($_GET['action'] == 'delete')
{
	$newcomment->delete($_GET['id']);
	Echo '<div class="container"><div class="alert alert-success">Комментарий успешно удален </div></div>';
}
Helper::pagination();
?>


</body>
</html>