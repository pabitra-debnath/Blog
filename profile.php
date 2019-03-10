<?php
include("connectdb.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}
$userID = $_SESSION['user_id'];

$result = mysqli_query($con, "SELECT * FROM posts ORDER BY post_id DESC ");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


<div class="container-fluid pd-0">
    <!------------- Navbar -------------->
    <nav class="navbar navbar-inverse bs-dark">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="profile.php">Logo</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="profile.php">HOME <span class="sr-only">(current)</span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">POSTS <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">ALL POSTS</a></li>
                        <li><a href="my_post.php">MY POSTS</a></li>
                        <li><a href="create_post.php">CREATE POST</a></li>
                    </ul>
                </li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle navbar-img" data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['user_name'] ?>
                        <img src="http://placehold.it/150x150" class="img-circle" alt="Profile Image"/>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div class="container">
    <div class="row" id="posts">
    <?php
    while ($row = $result -> fetch_assoc()) {
        $fetch_post_id = $row['post_id'];
        $post_by = mysqli_query($con, "SELECT fullname FROM `userinfo` WHERE userID = (SELECT userID from posts where post_id = $fetch_post_id) ");
        $row2 = $post_by -> fetch_assoc();
    ?>
    <div class="post-wrap">
        <div class="col-sm-12">
            <div class="card">
                <h2><a href=""><?php echo $row['post_title'] ?></a></h2>
                <?php if ($row['update_at']>$row['create_at']) {?>
                <span class="time"><?php echo $row['update_at'] ?></span>
                <?php }  else {?>
                <span class="time"><?php echo $row['create_at'] ?></span>
                <?php } ?>
                <br>
                <span class="custom_green">Posted By: <?php echo $row2['fullname'] ?></span>
                <br><br>
                <p><?php echo $row['post_text'] ?></p>

                    <a href="comments.php?id=<?php echo $row['post_id'] ?>" class="btn btn-primary pull-right">Comments</a>

                <?php if ($row['userID'] === $userID) {?>
                    <a href="update_post.php?id=<?php echo $row['post_id'] ?>" class="btn btn-primary pull-left">Update</a>
                <?php } ?>
            </div>

        </div>
    </div>
    <?php } ?>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>