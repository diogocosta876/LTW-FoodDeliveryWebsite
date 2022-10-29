<?php
  declare(strict_types = 1);

  session_start();

  class Dish {
    public int $id;
    public int $idRestaurant;
    public string $name_;
    public float $price;
    public float $rating;
    public string $photo;

    public function __construct(int $id, int $idRestaurant, string $name_, float $price, float $rating, string $photo){
      $this->id = $id;
      $this->idRestaurant = $idRestaurant;
      $this->name_ = $name_;
      $this->price = $price;
      $this->rating = $rating;
      $this->photo = $photo;
    }

    static function getDishes(PDO $db, int $count): array{
      $stmt = $db->prepare('SELECT Dish.idDish, idRestaurant, name_, price, AVG(starNum) AS rating, photo 
      FROM Dish LEFT JOIN DishReview ON DishReview.idDish = Dish.idDish
      LEFT JOIN Rating ON Rating.idRating = DishReview.idRating
      GROUP BY Dish.idDish
      LIMIT ?');
      $stmt->execute(array($count));
  
      $dishes = array();
      while($dish = $stmt->fetch()){
          $dishes[] = new Dish(
              intval($dish['idDish']),
              intval($dish['idRestaurant']),
              $dish['name_'],
              floatval($dish['price']),
              floatval($dish['rating']),
              $dish['photo']
          );
      }
      return $dishes;
    }

    static function searchDishes(PDO $db, string $search, int $count): array{
        $stmt = $db->prepare('SELECT Dish.idDish, idRestaurant, name_, price, AVG(starNum) AS rating, photo 
        FROM Dish LEFT JOIN DishReview ON DishReview.idDish = Dish.idDish
        LEFT JOIN Rating ON Rating.idRating = DishReview.idRating
        WHERE name_ LIKE ? 
        GROUP BY Dish.idDish
        LIMIT ?');
        //Dishes that have the term search contained in them
        $stmt->execute(array('%' . $search . '%', $count));

        $dishes = array();
        while($dish = $stmt->fetch()){
            $dishes[] = new Dish(
              intval($dish['idDish']),
              intval($dish['idRestaurant']),
              $dish['name_'],
              floatval($dish['price']),
              floatval($dish['rating']),
              $dish['photo']
            );
        }
        return $dishes;
      }

    static function getDish(PDO $db, int $idDish): Dish{
      $stmt = $db->prepare('SELECT Dish.idDish, idRestaurant, name_, price, AVG(starNum) AS rating, photo 
      FROM Dish LEFT JOIN DishReview ON DishReview.idDish = Dish.idDish
      LEFT JOIN Rating ON Rating.idRating = DishReview.idRating
      WHERE Dish.idDish = ?
      GROUP BY Dish.idDish');
      $stmt->execute(array($idDish));

      $dish = $stmt->fetch();

      return new Dish(
        intval($dish['idDish']),
        intval($dish['idRestaurant']),
        $dish['name_'],
        floatval($dish['price']),
        floatval($dish['rating']),
        $dish['photo']
      );
    }

    static function getDishesFromRestaurant(PDO $db, int $idRestaurant): array{
      $stmt = $db->prepare('SELECT Dish.idDish, idRestaurant, name_, price, AVG(starNum) AS rating, photo 
      FROM Dish LEFT JOIN DishReview ON DishReview.idDish = Dish.idDish
      LEFT JOIN Rating ON Rating.idRating = DishReview.idRating
      WHERE Dish.idRestaurant = ?
      GROUP BY Dish.idDish');
      $stmt->execute(array($idRestaurant));

      $dishes = array();
      while($dish = $stmt->fetch()){
          $dishes[] = new Dish(
              intval($dish['idDish']),
              intval($dish['idRestaurant']),
              $dish['name_'],
              floatval($dish['price']),
              floatval($dish['rating']),
              $dish['photo']
          );
      }
      return $dishes;
    }

    static function addDish(PDO $db, int $idRestaurant, string $name_, float $price, float $rating, string $photo){
      $stmt = $db->prepare('SELECT max(idDish) + 1 AS idDish FROM Dish');
      $stmt->execute();
      $query = $stmt->fetch();
      $idDish = intval($query['idDish']);

      console_log($idDish);
      $stmt = $db->prepare('INSERT INTO Dish(idDish, idRestaurant, name_, price, rating, photo)
          VALUES(?, ?, ?, ?, ?, ?);');
      $stmt->execute(array($idDish, $idRestaurant, $name_, $price, $rating, $photo));

      return new Dish(
        $idDish,
        $idRestaurant,
        $name_,
        $price,
        $rating,
        $photo
      );
    }

  public function isDishInFavourites(PDO $db, int $idUser): bool{
    $stmt = $db->prepare('SELECT idDish, idCustomer FROM FavouriteDish WHERE idDish = ? AND idCustomer = ?');
    $stmt->execute(array($this->id, $idUser));

    $fav = $stmt->fetch();

    if(empty($fav)){
      return false;
    }
    return true;
  }

  public function addDishToFavourites(PDO $db, int $idUser): void {
    $stmt = $db->prepare('INSERT INTO FavouriteDish(idDish, idCustomer)
    VALUES(?, ?)');
    $stmt->execute(array($this->id, $idUser));  
    return;
  }

  public function removeDishFromFavourites(PDO $db, int $idUser) {
    $stmt = $db->prepare('DELETE FROM FavouriteDish
    WHERE idDish = ? AND idCustomer = ?');
    $stmt->execute(array($this->id, $idUser));
    return;
  }
}
?>