<?php  
session_start();
include('connect.php');

if (isset($_POST['btnEdit'])) {
    $postID = $_POST['postID'];
    $newContent = mysqli_real_escape_string($conn, $_POST['newContent']);

    $editQuery = "UPDATE posts SET content = '$newContent' WHERE postID = '$postID' AND userID = '{$_SESSION['userID']}'";    
    if (executeQuery($editQuery)) {
        echo "<script>alert('Post updated successfully!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error updating post!');</script>";
    }
}
?>