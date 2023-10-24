<?php
$toEmail = 'amir.barin76@gmail.com'; /// Change this to your email address

/////////////
$errors_name = $errors_email = $errors_phone = $errors_message = '';
$errors      = [];
$success     = 'fail';
if ( $_POST ) {


	$name    = ( $_POST['name'] );
	$email   = ( $_POST['email'] );
	$phone   = ( $_POST['phone'] );
	$message = ( $_POST['message'] );

	if ( empty( $name ) ) {
		$errors[] = $errors_name = 'نام خالی است';
	}
	if ( empty( $email ) ) {
		$errors[] = $errors_email = 'ایمیل خالی است';
	} else if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$errors[] = $errors_email = 'ایمیل معتبر نیست';
	}
	if ( empty( $phone ) ) {
		$errors[] = $errors_phone = 'تلفن خالی است';
	}
	if ( empty( $message ) ) {
		$errors[] = $errors_message = 'پیام خالی است';
	}

	if ( empty( $errors ) ) {
		$emailSubject   = 'ایمیل جدید از طرف وبسایت';
		$headers        = [
			'From'         => $email,
			'Reply-To'     => $email,
			'Content-type' => 'text/html; charset=utf-8'
		];
		$bodyParagraphs = [
			"نام: {$name}" . "<br>",
			"ایمیل: {$email}" . "<br>",
			"پیام: {$message}" . "<br>",
			"شماره تلفن: {$phone}" . "<br>",
		];
		$body           = join( PHP_EOL, $bodyParagraphs );

		if ( mail( $toEmail, $emailSubject, $body, $headers ) ) {
			$success = "success";
		}
	}

	echo json_encode( [
		'success'        => $success,
		'nameMessage'    => $errors_name,
		'emailMessage'   => $errors_email,
		'messageMessage' => $errors_message,
		'phoneMessage'   => $errors_phone
	], JSON_UNESCAPED_UNICODE );

}