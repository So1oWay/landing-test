<?php

require_once('FormAbstract.php');
require_once('CallbackForm.php');

class ApplicationForm extends CallbackForm
{
    private $mail;
    private $type;

    public function __construct(string $name, string $phone, string $mail)
    {
        parent::__construct($name, $phone);
        $this->mail = $mail;
    }

    private function fileType()
    {
        $this->type = strtolower(end(explode('.', $_FILES['pdf']['name'])));
        return $this->type;
    }

    public function validate(): bool
    {
        if (!(empty($this->mail) || preg_match("/[0-9a-z]+@[a-z]+\.[a-z]/", $this->mail))) {
            return false;
        }
        if (!empty($_FILES['pdf']['name']) && ($this->fileType() != "pdf" || $_FILES['pdf']['size'] > 5242880)) {
            return false;
        }
        return parent::validate();
    }

    private function loadingFile()
    {
        if (!empty($_FILES['pdf']['name'])) {
            if (file_exists('files') == false) {
                mkdir('files');
            }
            move_uploaded_file($_FILES['pdf']['tmp_name'], "files/" . $_FILES['pdf']['name']);
            echo "Файл \"" . $_FILES['pdf']['name'] . "\" загружен";
        }
    }

    private function mail()
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