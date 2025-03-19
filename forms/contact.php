<?php
// Enable debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set your receiving email address
$receiving_email_address = 't.s.vinoth27@gmail.com';

// Check if the PHP Email Form library exists
$php_email_form = '../assets/vendor/php-email-form/php-email-form.php';
if (!file_exists($php_email_form)) {
    die(json_encode(['status' => 'error', 'message' => 'PHP Email Form library is missing!']));
}

include($php_email_form);

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'Unknown';
$contact->from_email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : 'no-reply@example.com';
$contact->subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : 'No Subject';

$contact->add_message($contact->from_name, 'From');
$contact->add_message($contact->from_email, 'Email');
$contact->add_message(isset($_POST['message']) ? htmlspecialchars($_POST['message']) : 'No Message', 'Message', 10);

// Enable SMTP (If needed)
$contact->smtp = array(
    'host' => 'smtp.yourdomain.com',  // Replace with your SMTP server
    'username' => 'your-email@yourdomain.com',
    'password' => 'your-email-password',
    'port' => '587'
);

// Send email and return JSON response
if ($contact->send()) {
    echo json_encode(['status' => 'success', 'message' => 'Your message has been sent successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
}
?>
