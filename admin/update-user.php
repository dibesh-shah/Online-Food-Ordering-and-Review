<?php

session_start();

include('../connect.php');

if (isset($_POST['uid']) && isset($_POST['status'])) {
    $uid = mysqli_real_escape_string($con, $_POST['uid']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $query = "UPDATE `userinfo` SET `status` = '$status' WHERE `uid` = '$uid'";

    if (mysqli_query($con, $query)) {
        echo json_encode(['message' => 'User status updated successfully!']);
    } else {
        echo json_encode(['error' => 'Error updating user status.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}

?>