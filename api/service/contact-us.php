<?php
error_reporting(0);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $log_data  = "";
    $log_data .= "Name: $name\n";
    $log_data .= "Email: $email\n";
    $log_data .= "Phone: $phone\n";
    $log_data .= "=================================================\n";

    // Send email
    $to = "info@invictaeclat.com,sales@invictaeclat.com"; // Change this to your email address
    $subject = "New Enquiry";
    $message = $log_data;
    $headers = "From: $email";

    $reqArr = array();
    
    if (mail($to, $subject, $message, $headers)) {
        $reqArr = array('flag'=>true, 'msg'=>"Thank you for your enquiry, we will get in touch with you shortly!");
    } else {
        // If mail couldn't be sent, log error and provide console error
        $error_message = error_get_last()['message'];
        error_log("Error sending email: $error_message");
        $reqArr = array('flag'=>false, 'msg'=>"Something went wrong. Please try again.");
    }

    // Log the data to a file (You might need to adjust the file path)
    $log_file = fopen("form_data.log", "a") or die("Unable to open file!");
    fwrite($log_file, $log_data);
    fclose($log_file);

    echo json_encode($reqArr);

} else {
    // If someone tries to access this file directly
    echo "Access denied!";
}
?>
