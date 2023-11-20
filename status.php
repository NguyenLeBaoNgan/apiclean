<?php
require "config.php";

header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['id_appointment'])) {
        $id_appointment = $_POST['id_appointment'];


        $query = "SELECT status FROM appointments WHERE id_appointment = '$id_appointment'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $currentStatus = $row['status'];
            
            
            $newStatus = $currentStatus + 1;

     
            $updateQuery = "UPDATE appointments SET status = $newStatus WHERE id_appointment = '$id_appointment'";
            $updateResult = mysqli_query($connection, $updateQuery);

            if ($updateResult) {
               
                $successResponse = array('value' => 1, 'message' => 'Cập nhật trạng thái thành công', 'new_status' => $newStatus);
                echo json_encode($successResponse);
            } else {
                $errorResponse = array('value' => 2, 'message' => 'Lỗi khi cập nhật trạng thái');
                echo json_encode($errorResponse);
            }
        } else {
            $errorResponse = array('value' => 2, 'message' => 'Lỗi khi truy vấn trạng thái');
            echo json_encode($errorResponse);
        }
    } else {
        $errorResponse = array('value' => 2, 'message' => 'Lỗi: id_appointment không được cung cấp trong yêu cầu POST');
        echo json_encode($errorResponse);
    }
}

?> 