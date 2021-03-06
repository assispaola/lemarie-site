<?php

require("./sendgrid-php/sendgrid-php.php");

$email_site = "paolasantos.assis@gmail.com";
$nome_site = "Le Marie - Imagem e Estilo";

$nome_user = $_POST["nome"];
$email_user = $_POST["email"];
$telefone_user = $_POST['telefone'];
$mensagem_user = $_POST['mensagem'];

$body_content = "";
foreach( $_POST as $field => $value) {
  if( $field !== "leaveblank" && $field !== "dontchange" && $field !== "enviar") {
    $sanitize_value = filter_var($value, FILTER_SANITIZE_STRING);
    $body_content .= "$field: $value \n";
  }
}

$email = new \SendGrid\Mail\Mail(null, "paolasantos.assis@gmail.com", "paolasantos.assis@gmail.com"); 
$email->setFrom("assispaola.dev@gmail.com", "Le Marie - Imagem e Estilo");
$email->addTo("paolasantos.assis@gmail.com", "Le Marie - Imagem e Estilo");

$email->setReplyTo($email_user, $nome_user);

$email->setSubject("Formulário Le Marie");
$email->addContent("text/html", "Olá! <br><br>Nova mensagem de: <br><br>Nome: $nome_user <br>Email: $email_user <br>Telefone: $telefone_user <br>Mensagem: $mensagem_user");

$sendgrid = new \SendGrid('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');
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo "Caught exception: ". $e->getMessage() ."\n";
}