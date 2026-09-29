<?php
if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit();
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$sms_consent = isset($_POST['sms_consent']) && $_POST['sms_consent'] === 'yes';
$raw_phone = isset($_POST['phone']) && is_string($_POST['phone']) ? $_POST['phone'] : '';
$phone = preg_replace('/[^0-9+(). -]/', '', $raw_phone) ?? '';
$phone_digits = preg_replace('/\D/', '', $phone) ?? '';
if($sms_consent && (strlen($phone_digits) < 7 || strlen($phone_digits) > 15)) {
  http_response_code(400);
  exit();
}
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$to = "hkwholesalenj@gmail.com";
$subject = "$m_subject:  $name";
$body = "You have received a new message from your website contact form.\n\n" . "Here are the details:\n\nName: $name\nEmail: $email\nPhone: $phone\nSMS consent: " . ($sms_consent ? "Yes" : "No") . "\n";
if($sms_consent) {
  $body .= "SMS consent recorded at: " . gmdate('c') . " UTC\nConsent text: I agree to receive up to 3 text messages from HK Wholesale about this inquiry. Message and data rates may apply. Reply STOP to opt out or HELP for help. Consent is not a condition of purchase.\n";
}
$body .= "\nSubject: $m_subject\n\nMessage: $message";
$header = "From: $email";
$header .= "Reply-To: $email";	

if(!mail($to, $subject, $body, $header))
  http_response_code(500);
?>
