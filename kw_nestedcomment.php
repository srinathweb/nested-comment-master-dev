<?php
/*author k.w.s. madushanka
  madusanka525@gmail.com
  this is simple class to add nested comment to your post.
  this class based on http://www.ferdychristant.com/blog/  Hierarchical data in MySQL: easy and fast
   Flat Table Model idea .......
 */	

class nestedcomment{
  
  /**
   * mysql database connection and database related method credit goes
   * http://alperguc.blogspot.com/2013/08/php-database-class-mysqli.html
   */

   // our mysqli object instance
	public $mysqli = null;

	function __construct()
	{
			include_once "config.php";       
        
					$this->mysqli =
				   new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	 
					if ($this->mysqli->connect_errno) {
					    echo "Error MySQLi: ("&nbsp. $this->mysqli->connect_errno
					    . ") " . $this->mysqli->connect_error;
					    exit();
					 }
					   $this->mysqli->set_charset("utf8"); 
	}



				// Class deconstructor override
	public function __destruct() 
	{
			   $this->CloseDB();
	}


	// runs a sql query
	 public function runQuery($qry) 
	 {
	        $result = $this->mysqli->query($qry);
	        return $result;
	 }
	 
    // runs multiple sql queres
    public function runMultipleQueries($qry) {
        $result = $this->mysqli->multi_query($qry);
        return $result;
    }
 
	// Close database connection
	    public function CloseDB()
	{
	        $this->mysqli->close();
	}
	 
		// Escape the string get ready to insert or update
	public function clearText($text) 
	{
		        $text = trim($text);
		        return $this->mysqli->real_escape_string($text);
	}
		 
		// Get the last insert id
    public function lastInsertID()
     {
		        return $this->mysqli->insert_id;
	
	 }
		 
	// Gets the total count and returns integer
    public function totalCount($fieldname, $tablename, $where = "")
    {
		$q = "SELECT count(".$fieldname.") FROM "
		. $tablename . " " . $where;
		         
		$result = $this->mysqli->query($q);
		$count = 0;
		if ($result) {
		    while ($row = mysqli_fetch_array($result)) {
		    $count = $row[0];
		   }
		  }
		  return $count;
	}

//end database related class based on http://alperguc.blogspot.com/2013/08/php-database-class-mysqli.html
      
		/**
		 * method for add new comment
		 */
	function addcomment($commentuser,$comment)
	{
	     //get comment id and lineage for new comment 
	     //parent id=lineage for fresh comment
	       $selectid='select if(max(id)is null,0,max(id))as  id from comments';
		   $lineagequery=$this->runQuery( $selectid);
		   if(isset($lineagequery))
			{
			  $row = mysqli_fetch_array($lineagequery);
			  $lineage = $row['id']+1;
			  
			}


			$comment=$this->clearText($comment); //clear data for insert
			$commentuser=$this->clearText($commentuser);

	     $insetquery="insert into `comments`(`id`,`comment`,`parentid`,`linage`,`deep`,`datecreated`,`lastedited`,`commented_user`,is_reply) 
		values ( NULL,'$comment','0','$lineage','0',now(),CURRENT_TIMESTAMP,'$commentuser','0')";


			$addcomments=$this->runQuery($insetquery);
		if(isset($addcomments))
			{
			 
			echo 'successfully added ';
			  
			}	

                
   	}
	
	/**
	 * responsible for reply comment
	 */

	function replycomment($replyuser,$reply,$parent){
		$sql="select count(*)as newlineage from comments where parentid=$parent";

        $lineagequery=$this->runQuery( $sql);
		   if(isset($lineagequery))
			{

			 $row_cnt = mysqli_num_rows($lineagequery);
			 if($row_cnt>0){
			 	  $row = mysqli_fetch_array($lineagequery);
			  $lineage =$parent.'-'.$row['newlineage']+1;
			 }
			 else{
             $lineage =$parent.'-1';
			 }
			

			$comment=$this->clearText($reply); //clear data for insert
			$commentuser=$this->clearText($replyuser);

	     $insetquery="insert into `comments`(`id`,`comment`,`parentid`,`linage`,`deep`,`datecreated`,`lastedited`,`commented_user`,is_reply) 
		values ( NULL,'$comment','$parent','$lineage','1',now(),CURRENT_TIMESTAMP,'$commentuser','0')";


			$addcomments=$this->runQuery($insetquery);
		   if(isset($addcomments))
			{
			 
			echo 'successfully added ';
			  
			}	
			  
			}






	}

		/**
		 * delete spam comment this can use for admin pannal
		 * 
		 */

	 function deletecomment($commentid){

	 }

		/**
		 * get last insert id for add comments
		 */

	 private function _lastinsertid(){


	 }

	/**
	 * responsible for displaing comments
	 * this return light weight json array of data
	 * @return string 
	 */
	
	 function displaycomments(){

	 		 $sql="SELECT c.id, c.commented_user, 
					c.comment,
					 c.deep, 
					c.linage, 
					c.parentid,
					c.is_reply,
					c.datecreated,
					c.lastedited,
					(SELECT COUNT(*) FROM comments where comments.linage LIKE (CONCAT(c.linage,'%')) AND comments.linage!=c.linage) as replies
					FROM comments as c
					order by c.linage";
	 		 $displayquery=$this->runQuery( $sql);

	 		
	 		 if($displayquery)
          {
						
			$rows = array();
			  while( $row = mysqli_fetch_array($displayquery))
			  {
		
              $rows[] =$row;


			  }
              
                
                return json_encode($rows);
                

			}




	 }


}