<?php

$form_errors = validate_form();


$log_file = __DIR__.'/log.txt';
$current = file_get_contents($log_file);


if (count($form_errors)) {
    print json_encode(array('result' => 'error', 'form_errors' => $form_errors));
    $current .= date('d-m-Y G:i:s') ." - Ошибка валидации\n";
} else {
    $current .= date('d-m-Y G:i:s') ." - Валидация прошла успешно\n";
    file_put_contents($log_file, $current);
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $recipients = array(
	        'in@cubegg.com',
            'demchuk@silencatech.com',
            'kenangadji@gmail.com',
            // 'alegria2112@gmail.com'
        );
        $mail_to = implode(',', $recipients); //demchuk@silencatech.com; in@cubegg.com
        $mail_from = $email;
        $mail_subject = 'Cubegg contact form.';
        $mail_body = "User message: $message";
        $mail_header = "From: $name <$email>";
        $current .= date('d-m-Y G:i:s') ." - Отправка письма\n";
        mail($mail_to, $mail_subject, $mail_body, $mail_header);
        $current .= date('d-m-Y G:i:s') . " - Письмо отправлено успешно\n";
        print json_encode(array('result' => 'ok'));
    } catch(Exception $e) {
        print json_encode(array('result' => 'error', 'form_errors' => ['message' => 'Ошибка сервера']));
        $current .= date('d-m-Y G:i:s') ." - Системная ошибка\n";
    }
}
file_put_contents($log_file, $current);
function validate_form() {
    $errors = array();

    if (! (isset($_POST['name']) && (strlen($_POST['name']) >= 2))) {
        $errors['name'] = 'Enter a name of at least 2 letters';
    }
    if (! (isset($_POST['email']) && strlen($_POST['email']) > 0 && filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
        $errors['email'] = 'Invalid email address.';
    }

    if (! (isset($_POST['message']) && (strlen($_POST['message']) > 0))) {
        $errors['message'] = 'Message is required.';
    }
    return $errors;
}
