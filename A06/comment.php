<?php 
include('connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['commentText']) && !empty($_POST['commentText'])) {
        $commentContent = mysqli_real_escape_string($conn, $_POST['commentText']);

        $userID = $_SESSION['userID'];
        $postID = $_POST['postID'];

        $insertCommentQuery = "
        INSERT INTO comments (postID, userID, content, dateTime)
        VALUES ('$postID', '$userID', '$commentContent', NOW())
        ";

        if (mysqli_query($conn, $insertCommentQuery)) {
            $_SESSION['message'] = "Comment posted successfully!";
        } else {
            $_SESSION['message'] = "Comment cannot be empty!";
        }
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['message'] = "Comment cannot be empty!";
        header("Location:index.php");
        exit;
    }
}
?>