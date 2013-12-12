<?php
session_start();
include ('sql.php');
include ('classes.php');
$connect = mysqli_connect($host,$login,$pass,$base);
$loadcomment = new Comment;
$loadcomment->id=$_POST['id'];
$loadcomment->name=$_POST['name'];
$loadcomment->email=$_POST['email'];
$loadcomment->contents=$_POST['comment'];
$loadcomment->save();
 print_r($_REQUEST);

if ($_SESSION['authorization'] == true)
{
	if($_GET['action'] == 'edit')
	{
		$loadcomment->load($_GET['id']);
			if($_POST['action']=='editcomment')
			{
				echo '<div class="alert alert-success">Комментарий отредактирован и сохранен</div> ';
			}
			echo '<a href="20.php"> Вернуться </a>';

	?>	
	<html>
		<head>	
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Edit Comment</title>
		</head>
		<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">
		<script>
			tinymce.init({selector:'textarea'});
		</script>
		<form method="post">
			<INPUT TYPE="HIDDEN" NAME="action" VALUE ="editcomment">
			<INPUT TYPE="HIDDEN" NAME="id" VALUE ="<?php echo $loadcomment->id; ?>">
			<p><input type="text" name="name" value="<?php echo  $loadcomment->name; ?>" /></p>
			<p><input type="text" name="email" value="<?php echo  $loadcomment->email; ?>" /></p>	
			<p><textarea rows="10" cols="35" name="comment"><?php echo  $loadcomment->contents; ?></textarea></p>
			<p><input type="submit" name="prov" value="Edit"></p>
		</form>
	</html>
	<?php
	}
	
}

else
{
	echo "Вы не авторизировались";
}
?>