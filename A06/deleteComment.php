<?php 
include('connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['commentID']) && !empty($_POST['commentID'])) {
        $commentID = $_POST['commentID'];

        if ($_SESSION['userID'] == 1) {
            $deleteQuery = "
                DELETE FROM comments 
                WHERE commentID = '$commentID'
            ";

            if (mysqli_query($conn, $deleteQuery)) {
                $_SESSION['message'] = "Comment deleted successfully.";
            } else {
                $_SESSION['message'] = "Failed to delete comment.";
            }
        } else {
            $_SESSION['message'] = "You are not authorized to delete this comment.";
        }
    } else {
        $_SESSION['message'] = "Invalid comment ID.";
    }
    header("Location: index.php");
    exit;
}
?>