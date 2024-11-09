<?php 
include('connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postID = $_POST['postID'];
    $userID = $_SESSION['userID'];
    $content = $_POST['commentText'];
    $dateTime = date('Y-m-d H:i:s');

    $insertCommentQuery = "
        INSERT INTO comments (postID, userID, content, dateTime)
        VALUES ('$postID', '$userID', '$content', '$dateTime')
    ";
    executeQuery($insertCommentQuery);

    header("Location: index.php");
    exit;
}
?>