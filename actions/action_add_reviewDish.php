<?php
  declare(strict_types = 1);

  session_start();

  if (!(isset($_SESSION['id']))) die(header('Location: ' . $_SERVER['HTTP_REFERER']));

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/dishReview.class.php');

  $db = getDatabaseConnection();

  $date = date('Y-m-d H:i:s', time());

  echo($date);
  $rating = intval($_POST['rating']);
  $idDish = intval($_POST['idDish']);

  if($rating == 0){
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  DishReview::addDishReview($db, $_SESSION['id'], $date, $rating, $idDish);

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>