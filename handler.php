<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 18.05.17
 * Time: 19:40
 */
require_once('lib/CallbackForm.php');
require_once('lib/Application.php');

$file_pdf = $_FILES['pdf'];
$call = isset($_POST['call']);
$app = isset($_POST['app']);
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$mail = isset($_POST['mail']) ? trim($_POST['mail']) : '';
$formType = isset($_POST['formType']) ? trim($_POST['formType']) : '';

$form = new CallbackForm($name, $phone);
$form2 = new Application($name, $phone, $mail);


if ($app && $form2->validate()) {
    $form2->send();
} elseif ($call && $form->validate()) {
    $form->send();
} else {
    echo 'Введите корректные данные';
}
