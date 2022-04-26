<?php

session_start();

include_once("connction.php");
include_once("url.php");


$data = $_POST;

if (!empty($data)) {
;
   //Create
   if ($data["type"] === "Create") {
      $nome = $data["nome"];
      $phone = $data["phone"];
      $observation = $data["observation"];

      $query = "INSERT INTO contacts(nome, phone, observation) VALUES (:nome, :phone, :observation)";

      $stmt = $conn->prepare($query);

      $stmt->bindParam(":nome", $nome);
      $stmt->bindParam(":phone", $phone);
      $stmt->bindParam(":observation", $observation);

      try {
         $stmt->execute();
         $_SESSION['msg'] = "Contato criado com sucesso!";
      } catch (PDOException $e) {
         $error = $e->getMessage();
         echo "Erro: $error";
      }
   
   } elseif ($data['type'] === 'Edit') {

      $nome = $data['nome'];
      $phone = $data['phone'];
      $observation = $data['observation'];
      $id = $data['id'];

      $query = "UPDATE contacts SET nome = :nome, phone = :phone, observation = :observation WHERE id = :id";

      $stmt = $conn->prepare($query);

      $stmt->bindParam(":nome", $nome);
      $stmt->bindParam(":phone", $phone);
      $stmt->bindParam(":observation", $observation);
      $stmt->bindParam(":id", $id);

      try {
         $stmt->execute();
         $_SESSION['msg'] = "Contato atualizado com sucesso!";
      } catch (PDOException $e) {
         $error = $e->getMessage();
         echo "Erro: $error";
      }

   } elseif ($data['type'] === 'Delete') {

      $id = $data['id'];

      $query = "DELETE FROM contacts WHERE id = :id";

      $stmt = $conn->prepare($query);
      $stmt->bindParam(":id", $id);

      try {
         $stmt->execute();
         $_SESSION['msg-del'] = "Contato excluído com sucesso!";
      } catch (PDOException $e) {
         $error = $e->getMessage();
         echo "Erro: $error";
      }
   }

   //Redirect home
   header("Location:" . $BASE_URL . "../index.php");
} else {

   if (!empty($_GET)) {
      //1 contato

      $id;
      $id = $_GET['id'];
   
      $query = "SELECT * FROM contacts WHERE id = :id";

      $stmt = $conn->prepare($query);
      $stmt->bindParam(":id", $id);
      $stmt->execute();

      $contact = $stmt->fetch();

   } else {
      //Diversos contatos

      $contacts = [];

      $query = "SELECT * FROM contacts";

      $stmt = $conn->prepare($query);
      $stmt->execute();

      $contacts = $stmt->fetchAll();
   }
}

// Close connection
$conn = null;
?>