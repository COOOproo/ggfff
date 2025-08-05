<?php
$recipientEmail = 'priglossvadba@gmail.com';
$siteName = 'Свадьба Натали и Андрея';
$senderEmail = 'no-reply@' . $_SERVER['SERVER_NAME'];
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (empty($data['name']) || empty($data['attendance'])) {
    http_response_code(400);
    echo 'Пожалуйста, заполните обязательные поля';
    exit;
}
$name = htmlspecialchars(trim($data['name']));
$attendance = htmlspecialchars(trim($data['attendance']));
$drink = !empty($data['drink']) ? htmlspecialchars(trim($data['drink'])) : 'Не указано';
$subject = "Ответ на приглашение: $name";
$emailBody = <<<HTML
<html>
<head><title>Ответ на свадебное приглашение</title></head>
<body>
<p><strong>Имя гостя:</strong> $name</p>
<p><strong>Присутствие:</strong> $attendance</p>
<p><strong>Предпочтения в напитках:</strong> $drink</p>
</body></html>
HTML;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: $siteName <$senderEmail>" . "\r\n";
if (mail($recipientEmail, $subject, $emailBody, $headers)) {
    echo "Успешно отправлено";
} else {
    http_response_code(500);
    echo "Ошибка при отправке";
}
?>
