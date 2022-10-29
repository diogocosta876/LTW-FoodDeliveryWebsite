<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/restaurant.class.php');

  class DishReview {
    public int $id;
    public int $idCustomer;
    public string $timestamp;
    public int $starNum;
    public int $idDish;

    public function __construct(int $id, int $idCustomer, string $timestamp, int $starNum, int $idDish)
    { 
      $this->id = $id;
      $this->idCustomer = $idCustomer;
      $this->timestamp = $timestamp;
      $this->starNum = $starNum;
      $this->idDish =  $idDish;
    }

    static function getReviews(PDO $db, int $idDish): array{
        $stmt = $db->prepare('SELECT Rating.idRating AS idRating, idCustomer, timestamp, starNum, idDish
        FROM Rating JOIN DishReview 
        ON Rating.idRating = DishReview.idRating
        WHERE idDish = ?;');
  
        $stmt->execute(array($idDish));
        $reviews = array();
        while($review = $stmt->fetch()){
          $reviews[] = new DishReview(
            intval($review['idRating']),
            intval($review['idCustomer']),
            $review['timestamp'],
            intval($review['starNum']),
            intval($review['idDish'])
          );
        }
        return $reviews;
      }

    static function addDishReview(PDO $db, int $idCustomer, string $timestamp, int $starNum, int $idDish): DishReview{
      
      $stmt = $db->prepare('SELECT max(idRating) + 1 AS idRating FROM Rating');
      $stmt->execute();
      $query = $stmt->fetch();
      $idRating = intval($query['idRating']);
  
      $stmt = $db->prepare('INSERT INTO Rating(idRating, idCustomer, timestamp, starNum)
        VALUES(?, ?, ?, ?);');
      $stmt->execute(array($idRating, $idCustomer, $timestamp, $starNum));
  
      $stmt = $db->prepare('INSERT INTO DishReview(idRating, idDish)
        VALUES(?, ?);');
      $stmt->execute(array($idRating, $idDish));
  
      return new DishReview(
        $idRating,
        $idCustomer,
        $timestamp,
        $starNum,
        $idDish,
      );
    }

  }

?>