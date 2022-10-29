<?php
  declare(strict_types = 1);


  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/customer.class.php');

  $db = getDatabaseConnection();

  if ($_SESSION['name'] != $_POST['username']) {
    $_SESSION['name'] = $_POST['username'];
  }

  $stmt = $db->prepare('UPDATE User
                        SET username = ?, password = ?, address_ = ?, phoneNumber = ?
                        WHERE idUser = ?;');
  $stmt->execute(array($_POST['username'], sha1($_POST['password']), $_POST['address'], $_POST['phone_number'],intval($_POST['id'])));

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>