<?php
include('connect.php');
session_start();
$_SESSION['userID'] = 1; //Do not have a login page so default user is set to userID 1.

$query = "
    SELECT posts.postID, posts.content, posts.dateTime, posts.attachment, users.userName
    FROM posts
    JOIN users ON posts.userID = users.userID
    WHERE posts.isDeleted = 0 
";
$result = executeQuery($query);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Social Media Project</title>

    <link rel="icon" href="assets/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <style>
    .gallery-container {
        max-width: 85%;
        margin: 20px auto;
    }

    .image-container {
        gap: 10px;
    }

    @media (min-width: 576px) {
        .image-container {
            columns: 1;
        }
    }

    @media (min-width: 768px) {
        .image-container {
            columns: 2;
        }
    }

    @media (min-width: 1300px) {
        .image-container {
            columns: 4;
        }
    }

    .image-container img {
        margin-bottom: 15px;
        border-radius: 5px;
        width: 100%; 
    }

    .card {
        margin-bottom: 10px;
        overflow: hidden;
        height: auto;
        width: 300px; 
    }

    .card-body {
        padding: 15px; 
    }

    .card-title, .card-text {
        margin: 0; 
    }

    .card-img-top {
        transition: transform 0.3s ease;
    }

    .card-img-top:hover {
        transform: scale(1.1);
    }

    .like-button {
        margin-right: 10px;
    }

    .interaction-container {
        margin: 0px;
    }

    .comment-section {
        font-size: 12px;
    }

    .commentPost {
        padding: 20px;
        margin-left: 10px;
    }

  </style>
  <body>
  <nav class="navbar sticky-top bg-body-tertiary">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="">BrainStormity</a>

        <div class="d-flex gap-3">
            <a href="" class="btn btn-outline-secondary">
                <span>Explore</span>
            </a>
            <a href="" class="btn btn-outline-secondary">
                <span>Chats</span>
            </a>

            <div style="cursor: pointer;" onclick="changeColorMode()" class="d-flex align-items-center">
                <span id="colorModeIcon">
                    <svg fill="none" viewBox="2 2 20 20" width="24" height="24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="currentColor" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </span>
                <label class="form-check-label" id="btnColor" style="margin-left: 5px;">Dark Mode</label>
            </div>
        </div>
    </div>
  </nav>

  <div class="gallery-container">
    <h1 class="my-3">Explore</h1>
    <div class="image-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($posts = mysqli_fetch_assoc($result)) {
              ?>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($posts['attachment']); ?>" class="card-img-top" alt="Post Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($posts['userName']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($posts['content']); ?></p>
                            <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($posts['dateTime']); ?></small></p>
                        
                            <div class="comment">
                                <h6>Comments</h6>

                                <?php 
                                $commentQuery = "
                                    SELECT comments.content, comments.dateTime, users.userName
                                    FROM comments
                                    JOIN users ON comments.userID = users.userID
                                    WHERE comments.postID = {$posts['postID']}
                                    ORDER BY comments.dateTime DESC
                                ";
                                $commentResult = executeQuery($commentQuery);

                                if (mysqli_num_rows($commentResult) > 0) {
                                    while ($comment = mysqli_fetch_assoc($commentResult)) {
                                        echo "<p><strong>{$comment['userName']}</strong>: " . htmlspecialchars($comment['content']) . " <small class='text-muted'>{$comment['dateTime']}</small></p>";
                                    }
                                } else {
                                    echo "<p>No comments yet.</p>";
                                }
                                ?>

                                <form action="comment.php" method="POST">
                                    <input type="hidden" name="postID" value="<?php echo $posts['postID']; ?>">
                                    <div class="mb-2 d-flex">
                                        <textarea name="commentText" class="form-contol" rows="2"  placeholder="Add a comment..."></textarea>
                                        <button type="submit" class="btn btn-primary btn-sm commentPost">Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>            
                </div>
                <?php
            }
        } else {
            echo "<p>No posts available.</p>";
        }
        ?>
    </div>
  </div>
   
  <script>
    var colorMode = "light"; 

    function changeColorMode() {
        if (colorMode === "light") {
            document.body.setAttribute("data-bs-theme", "dark"); 
            document.getElementById("btnColor").innerHTML = "Light Mode"; 
            document.getElementById("colorModeIcon").innerHTML = `
                <svg fill="none" viewBox="3 3 18 18" width="24" height="24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="currentColor" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            `;
        colorMode = "dark"; 
        } else {
            document.body.setAttribute("data-bs-theme", "light"); 
            document.getElementById("btnColor").innerHTML = "Dark Mode";
            document.getElementById("colorModeIcon").innerHTML = `
                <svg fill="none" viewBox="2 2 20 20" width="24" height="24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="currentColor" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            `;
            colorMode = "light"; 
        }
    }
  </script>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>