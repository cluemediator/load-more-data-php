<?php 
// include database connection file
include("db_config.php");	
?>

<!DOCTYPE html>
<html>
<head>
  <title>Load More data from database using AJAX, jQuery and PHP - Clue Mediator</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <style type="text/css">
    .container {
      width:650px;
    }
    .post {
      background-color: #F1F1F1;			
      margin: 5px 15px 2px;
      padding: 8px;
      font-size: 14px;
      line-height: 1.5;
    }
    #loadBtn {
      background-color: #499749;
      padding: 8px 17px;
      color: #fff;
      border-radius: 5px;
      font-size: 17px;
    }
    .loadmore {
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Load More data from database using PHP - <a href="https://www.cluemediator.com" target="_blank">Clue Mediator</a></h2>
    <div class="postList">
      <?php
      $count_query = "SELECT count(*) as allcount FROM posts";
      $count_result = mysqli_query($con,$count_query);
      $count_fetch = mysqli_fetch_array($count_result);
      $postCount = $count_fetch['allcount'];
      $limit = 3;

      $query = "SELECT * FROM posts ORDER BY id desc LIMIT 0,".$limit;	
      $result = mysqli_query($con,$query);
      if ($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)){ 
          ?>
          <div class="post"><?php echo $row['title']; ?></div>
        <?php }
      } ?>	
    </div>
    <div class="loadmore">
      <input type="button" id="loadBtn" value="Load More">
      <input type="hidden" id="row" value="0">
      <input type="hidden" id="postCount" value="<?php echo $postCount; ?>">
    </div>	
  </div>

  <script>
    $(document).ready(function () {
      $(document).on('click', '#loadBtn', function () {
        var row = Number($('#row').val());
        var count = Number($('#postCount').val());
        var limit = 3;
        row = row + limit;
        $('#row').val(row);
        $("#loadBtn").val('Loading...');

        $.ajax({
          type: 'POST',
          url: 'loadmore-data.php',
          data: 'row=' + row,
          success: function (data) {
            var rowCount = row + limit;
            $('.postList').append(data);
            if (rowCount >= count) {
              $('#loadBtn').css("display", "none");
            } else {
              $("#loadBtn").val('Load More');
            }
          }
        });
      });
    });		
  </script>
  
</body>
</html>