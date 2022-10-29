<?php
  declare(strict_types = 1);

  session_start();

  if (!(isset($_SESSION['id']))) die(header('Location: ' . $_SERVER['HTTP_REFERER']));

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/restaurantReview.class.php');

  $db = getDatabaseConnection();

  $date = date('Y-m-d H:i:s', time());

  $rating = intval($_POST['rating']);
  $idRestaurant = intval($_POST['idRestaurant']);
  $reviewText = $_POST['reviewText'];

  if($rating == 0){
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  RestaurantReview::addRestaurantReview($db, $_SESSION['id'], $date, $rating, $idRestaurant, $reviewText);

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>