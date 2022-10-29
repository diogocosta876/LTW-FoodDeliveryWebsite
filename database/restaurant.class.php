<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../database/owner.class.php');

  class Restaurant {
    public int $id;
    public string $name;
    public string $address;
    public float $rating;
    public string $photo;

    public function __construct(int $id, string $name, string $address, float $rating, string $photo){
      $this->id = $id;
      $this->name = $name;
      $this->address = $address;
      $this->rating = $rating;
      $this->photo = $photo;
    }

    static function getRestaurants(PDO $db, int $count): array{
        $stmt = $db->prepare('SELECT Restaurant.idRestaurant, name_, address_, AVG(starNum) AS rating, photo 
        FROM Restaurant LEFT JOIN RestaurantReview ON RestaurantReview.idRestaurant = Restaurant.idRestaurant
        LEFT JOIN Rating ON Rating.idRating = RestaurantReview.idRating
        GROUP BY Restaurant.idRestaurant
        LIMIT ?');
        $stmt->execute(array($count));



        $restaurants = array();
        while($restaurant = $stmt->fetch()){
            $restaurants[] = new Restaurant(
                intval($restaurant['idRestaurant']),
                $restaurant['name_'],
                $restaurant['address_'],
                floatval($restaurant['rating']),
                $restaurant['photo'],
            );
        }
        return $restaurants;
    }

    static function searchRestaurants(PDO $db, string $search, int $count): array{
        $stmt = $db->prepare('SELECT Restaurant.idRestaurant, name_, address_, AVG(starNum) AS rating, photo 
        FROM Restaurant LEFT JOIN RestaurantReview ON RestaurantReview.idRestaurant = Restaurant.idRestaurant
        LEFT JOIN Rating ON Rating.idRating = RestaurantReview.idRating
        WHERE name_ LIKE ? 
        GROUP BY Restaurant.idRestaurant
        LIMIT ?');
        $stmt->execute(array('%' . $search . '%', $count));

        $restaurants = array();
        while($restaurant = $stmt->fetch()){
            $restaurants[] = new Restaurant(
              intval($restaurant['idRestaurant']),
              $restaurant['name_'],
              $restaurant['address_'],
              floatval($restaurant['rating']),
              $restaurant['photo'],
            );
        }
        return $restaurants;
    }

    static function getRestaurant(PDO $db, int $idRestaurant): Restaurant{
      $stmt = $db->prepare('SELECT Restaurant.idRestaurant, name_, address_, AVG(starNum) AS rating, photo 
      FROM Restaurant LEFT JOIN RestaurantReview ON RestaurantReview.idRestaurant = Restaurant.idRestaurant
      LEFT JOIN Rating ON Rating.idRating = RestaurantReview.idRating
      WHERE Restaurant.idRestaurant = ?
      GROUP BY Restaurant.idRestaurant');
      $stmt->execute(array($idRestaurant));
  
      $restaurant = $stmt->fetch();

      return new Restaurant(
        intval($restaurant['idRestaurant']),
        $restaurant['name_'],
        $restaurant['address_'],
        floatval($restaurant['rating']),
        $restaurant['photo'],
      );
    }

    public function getOwner(PDO $db): int{
      $stmt = $db->prepare('SELECT idOwner FROM Owns WHERE idRestaurant = ?');
      $stmt->execute(array($this->id));

      $query = $stmt->fetch();

      return intval($query['idOwner']);
    }



  static function addRestaurant(PDO $db,int $idOwner, string $name_, string $address, float $rating, string $photo){
    $stmt = $db->prepare('SELECT max(idRestaurant) + 1 AS idRestaurant FROM Restaurant');
    $stmt->execute();
    $query = $stmt->fetch();
    $idRestaurant = intval($query['idRestaurant']);

    console_log($idRestaurant);
    $stmt = $db->prepare('INSERT INTO Restaurant(idRestaurant, name_, address_, photo, rating)
        VALUES(?, ?, ?, ?, ?);');
    $stmt->execute(array($idRestaurant, $name_, $address, $photo, $rating));

    $stmt = $db->prepare('INSERT INTO Owns(idOwner, idRestaurant)
        VALUES(?, ?);');
    $stmt->execute(array($idOwner, $idRestaurant));

    return new Restaurant(
      $idRestaurant,
      $name_,
      $address,
      $rating,
      $photo
    );
  }

  function console_log2($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
  }
}
?>
