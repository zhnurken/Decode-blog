<?php
  include "../../config/base_url.php";
  include "../../config/db.php";

  if(isset($_GET['nickname'])&&
  strlen($_GET['nickname'])>0){
    $nickname = $_GET["nickname"];
    $prep = mysqli_prepare($con,
    "SELECT b.*, u.nickname, c.name FROM blogs b
    LEFT OUTER JOIN users u ON u.id=b.author_id
    LEFT OUTER JOIN categories c ON c.id=b.category_id
    WHERE u.nickname =?");
    mysqli_stmt_bind_param($prep, "s", $nickname);
    mysqli_stmt_execute($prep);
    $blogs = mysqli_stmt_get_result($prep);
    $res = array();
    if(mysqli_num_rows($blogs)>0){
        while($blog = mysqli_fetch_assoc($blogs)){
            $res[]=$blog;
        }
    }
    
    echo json_encode($res);

  }else{
    echo "error";
  }
?>