<?php

require_once('FormAbstract.php');
require_once('CallbackForm.php');

class Application extends CallbackForm
{
    public $mail;

    public function __construct(string $name, string $phone, string $mail)
    {
        parent::__construct($name, $phone);
        $this->mail = $mail;
    }

    public function validate(): bool
    {
        if (!(empty($this->mail) || preg_match("/[0-9a-z]+@[a-z]+\.[a-z]/", $this->mail))) {
            return false;
        }
        if (!empty($_FILES['pdf']['name']) && (strtolower(end(explode('.', $_FILES['pdf']['name']))) != "pdf" || $_FILES['pdf']['size'] > 5000000)) {
            return false;
        }
        return parent::validate();
    }

    public function loadingFile()
    {
        if (!empty($_FILES['pdf']['name'])) {
            if (file_exists('files') == false) {
                mkdir('files');
                move_uploaded_file($_FILES['pdf']['tmp_name'], "files/" . $_FILES['pdf']['name']);
                echo "Файл \"" . $_FILES['pdf']['name'] . "\" загружен";
            } else {
                move_uploaded_file($_FILES['pdf']['tmp_name'], "files/" . $_FILES['pdf']['name']);
                echo "Файл \"" . $_FILES['pdf']['name'] . "\" загружен";
            }
        }
    }

    public function mail()
    {
        if (!empty($this->mail)) {
            echo 'Email: ' . $this->mail;
        }
    }

    public function send()
    {
        parent::send();
        echo '<br>';
        $this->mail();
        echo '<br>';
        $this->loadingFile();
    }
}
