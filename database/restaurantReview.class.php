<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/restaurant.class.php');

  class RestaurantReview {
    public int $id;
    public int $idCustomer;
    public string $timestamp;
    public int $starNum;
    public int $idRestaurant;
    public string $reviewText;

    public function __construct(int $id, int $idCustomer, string $timestamp, int $starNum, int $idRestaurant, string $reviewText)
    { 
      $this->id = $id;
      $this->idCustomer = $idCustomer;
      $this->timestamp = $timestamp;
      $this->starNum = $starNum;
      $this->idRestaurant =  $idRestaurant;
      $this->reviewText = $reviewText;
    }

    static function getReviews(PDO $db, int $idRestaurant): array{
        $stmt = $db->prepare('SELECT Rating.idRating AS idRating, idCustomer, timestamp, starNum, idRestaurant, reviewText
        FROM Rating JOIN RestaurantReview 
        ON Rating.idRating = RestaurantReview.idRating
        WHERE idRestaurant = ?;');
  
        $stmt->execute(array($idRestaurant));
        $reviews = array();
        while($review = $stmt->fetch()){
          $reviews[] = new RestaurantReview(
            intval($review['idRating']),
            intval($review['idCustomer']),
            $review['timestamp'],
            intval($review['starNum']),
            intval($review['idRestaurant']),
            $review['reviewText']
          );
        }
        return $reviews;
      }

      static function addRestaurantReview(PDO $db, int $idCustomer, string $timestamp, int $starNum, int $idRestaurant, string $reviewText): RestaurantReview{
      
        $stmt = $db->prepare('SELECT max(idRating) + 1 AS idRating FROM Rating');
        $stmt->execute();
        $query = $stmt->fetch();
        $idRating = intval($query['idRating']);
    
        $stmt = $db->prepare('INSERT INTO Rating(idRating, idCustomer, timestamp, starNum)
          VALUES(?, ?, ?, ?);');
        $stmt->execute(array($idRating, $idCustomer, $timestamp, $starNum));
    
        $stmt = $db->prepare('INSERT INTO RestaurantReview(idRating, idRestaurant, reviewText)
          VALUES(?, ?, ?);');
        $stmt->execute(array($idRating, $idRestaurant, $reviewText));
    
        return new RestaurantReview(
          $idRating,
          $idCustomer,
          $timestamp,
          $starNum,
          $idRestaurant,
          $reviewText
        );
      }
  }
?>