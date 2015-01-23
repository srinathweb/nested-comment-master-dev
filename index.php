<!DOCTYPE html>
<html>
<head>
	<title>nested comment demo</title>
	<link rel="stylesheet" href="style.css">
	<script src="jquery.js" type="text/javascript"></script>
</head>
<body>
<!-- include nasted comment class -->
<?php include('kw_nestedcomment.php'); ?>
<!-- end included class -->

<div class="wapper">
	<div class="commentblock">
	<form action="index.php"   method="post">
	<p>Name</p>
		<p><input type="text" name="user"></p>
		<p>Comment</p>
		<p><textarea name="comment" id="" cols="70" rows="10"></textarea></p>
		<p><input type="submit" value="Add Comment"></p>
	</form>
</div>

<div class="usercomments">
	
<!-- disply user comments -->
<?php
$mycomment=new nestedcomment();  
//show comments

$Array = json_decode($mycomment->displaycomments(), true);  //decode json formated data

foreach ($Array as $key => $value)
{
      
        $subcomment=$value['is_reply'];
       //check wether comment is subcomment
       if($subcomment!=1){
                 echo '<div class="commententry">';
                   echo '<h2>Comment:'.$value['commented_user'].'<span id="left">'.$value['datecreated'].'</span></h2>';
                   echo '<p>'.$value['comment'].'<br><br><br><a class="reply" >reply</a></p>';
                            echo '<div class="replybox" style="display:none;">';
						    echo '<p>Name:</P><p><input type="text" name="ruser" id="ruser"></p>';
						    echo '<input type="hidden" id="commentid" value="'.$value['id'].'">';
							echo '<p>Comment</P><p><textarea name="rcomment" id="rcomment" cols="70" rows="5"></textarea></p>';
							echo '<p><input type="submit" value="Reply" class="replyc"></p>';
						    echo '</div>';
	              echo '</div>';

	                        

            	 
			}
		else{
            echo '<div class="reply">';
	         echo '<p>'.$value['comment'].'<br>@'.$value['commented_user'].'</p>';
		    echo '</div>';


		}
		    
   
}

?>
<!-- end display comments -->


</div>

</div>




<!-- process form data -->
<?php


// if(isset($_POST)){
 //  $user=$_POST['user'];
 //  $comment=$_POST['comment'];
	// $mycomment->addcomment($user,$comment);

// }







?>
<!-- end process data -->

</body>
<script>
	$(document).ready(function(){
		$('.reply').click(function(e){
				
			$(this).parent().next('.replybox').toggle('2000');
			
			
		});
       
       $('.replyc').click(function(){
       	
      $.post( 
             "reply.php",
             { ruser: ruser,commentid:commentid,rcomment:rcomment },
             function(data) {
               alert('data');

             });


        });

	});
</script>
</html>