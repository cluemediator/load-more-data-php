<?php
include('db_config.php');
if (isset($_POST['row'])) {
  $start = $_POST['row'];
  $limit = 3;
  $query = "SELECT * FROM posts ORDER BY id desc LIMIT ".$start.",".$limit;	
  $result = mysqli_query($con,$query);
  if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="post"><?php echo $row['title']; ?></div>
    <?php }  
  }	
}
?>
