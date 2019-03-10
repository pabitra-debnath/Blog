<?php
include("connectdb.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}


$status = '';
$post_error = '';
$userID = $_SESSION['user_id'];
if (isset($_POST['submit'])) {
    $post_title = mysqli_real_escape_string($con, $_POST['post_title']);
    $post_text = mysqli_real_escape_string($con, $_POST['post_text']);
    $create_at = date("Y-m-d H:i:s", time());
    $update_at = date("Y-m-d H:i:s", time());

    $insertQry = "INSERT INTO `posts`(`userID`, `post_title`, `post_text`, `update_at`) VALUES ('$userID', '$post_title', '$post_text', '$update_at')";

    if ($post_title && $post_text) {
        if (mysqli_query($con, $insertQry)) {
            $status = 1;
        } else {
            $status = "";
        }
    }else{
        $post_error = "Please Fill up Post Title and Post Text";
    }
}


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
                <li class=""><a href="profile.php">HOME <span class="sr-only">(current)</span></a></li>
                <li class="dropdown active">
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
    <div class="row">
        <div class="post-wrap">
            <div class="col-sm-6 col-sm-offset-3">
                <?php if ($status) { ?>
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p class="text-center">Posted Successfully.</p>
                    </div>
                <?php } ?>
                <?php if ($post_error) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p class="text-center"><?php echo $post_error ?></p>
                    </div>
                <?php } ?>
                <div class="card">
                    <form class="" method="post">
                        <div class="form-group">
                            <label for="post">Post Title:</label>
                            <input type="text" class="form-control" id="post" name="post_title">
                        </div>
                        <div class="form-group">
                            <label for="post_text">Post Text:</label>
                            <!-- <input type="text" class="form-control" id="post_text" name="post_text"> -->
                            <textarea class="form-control" name="post_text" id="post_text" cols="30"
                                      rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>