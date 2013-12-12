<?php
class Comment
{
	public $id;
	public $checkform;
	public $name;
	public $email;
	public $contents;
	private function clear_me_up()
	{
		global $connect;
		$this->id=mysqli_real_escape_string($connect, $this->id );
		$this->name=mysqli_real_escape_string($connect, $this->name );
		$this->email=mysqli_real_escape_string($connect, $this->email ); 
		$this->contents=mysqli_real_escape_string($connect, $this->contents);
	}
	public function save()
	{
		global $connect;
		if($this->id == NULL)
			{
				if(strlen($this->name)>0 and strlen($this->email)>0  and strlen($this->contents)>0)
				{
					$this->clear_me_up();
					$dobav=mysqli_query($connect,'INSERT INTO main (name, Date , email, comment) VALUES ("'.$this->name.'", NOW(),"'.$this->email.'","'.$this->contents.'")');
					$this->checkform=true;
				}
				elseif(strlen($this->name)==0 or strlen ($this->email)==0  or strlen($this->contents)==0)
				{
				$this->checkform=false;	
				}
			}
			else
			{
				$this->clear_me_up();
				$result = mysqli_query($connect,"UPDATE `main` SET `name`='".$this->name."', `email`='".$this->email."',
				`comment`='".$this->contents."'		WHERE id =".$this->id);
				
			}
	}
	private function validemail()
	{
		if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
		{
			echo "E-mail is not valid";
		}
	}
	public function load($id)
	{
			global $connect;
			$this->id=mysqli_real_escape_string($connect, $id );
			$result = mysqli_query($connect, "SELECT id, name, email , comment FROM `main` WHERE id =".$this->id);
			$myrow = mysqli_fetch_assoc($result);
			$this->id=$myrow['id'];
			$this->name=$myrow['name'];
			$this->email=$myrow['email'];
			$this->contents=$myrow['comment'];
						
	}
	public function delete($id)
	{
		global $connect;
		$this->id=mysqli_real_escape_string($connect, $id );
		$result = mysqli_query($connect, "DELETE FROM `main` WHERE id = ".$this->id);
	}
	
}

class Helper
{
	static function pagination()
	{
		global $connect;
		$numofpostsperpage = 3; 
		$result = mysqli_query($connect, "SELECT COUNT(*) FROM main");
		$allposts = mysqli_fetch_row($result);
		$totalpages = intval(($allposts[0] - 1) / $numofpostsperpage) + 1; 
		if(isset($_GET['page'])) 
		{
			$page = $_GET['page']; 
		}
		elseif($page < 1)
		{
			$page = 1;
		}
		elseif ($page>$totalpages)
		{
			$page=$totalpages;
		}
		else
		{
			$page=1;
		}
		$startfrom = $page * $numofpostsperpage - $numofpostsperpage; 
		$result = mysqli_query($connect, "SELECT * FROM main ORDER BY DATE DESC LIMIT ". $startfrom.','. $numofpostsperpage); 
		while($postrow = mysqli_fetch_array($result))
		{
?>
				<div class="container">
					<div class="jumbotron">
						<h2><?php echo '<b>Name </b>'.$postrow['name'];?> </h2>
						<?php echo '<b>Date </b>'. $postrow['Date'];?> 
						<b>Email </b><a href="mailto:<?php echo $postrow['email'];?>"><?php echo $postrow['email'];?></a><br>
						<?php echo '<b>Comment </b>'. $postrow['comment'];?>
						<?php if ($_SESSION['authorization'] == true)
						{
							echo '<a href="edit.php?action=edit&id='.$postrow['id'].'">Редактировать </a>';
							echo '<a href="20.php?action=delete&id='.$postrow['id'].'"> Удалить</a>'; 
						}
						?>
					</div>
				</div>
<?php
		}
?>
		<div align="center">
		<ul class="pagination ">
		 
<?php	

		for($j = 1; $j <= $totalpages; $j++) 
		{ 

			if ($j == $_GET['page'])
			{
?>
			
			<li class="active"><a href="20.php?page=<?php echo $j;?> "><?php echo $j;?></a></li>
		 
<?php
			}
			else 
				echo '<li><a href="20.php?page='.$j.'">'.$j.'</a></li>';
		}
		echo "</ul></div><br /><br /><br />";	
	}
}

?>
