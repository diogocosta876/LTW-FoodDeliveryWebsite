<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/restaurant.class.php');
  require_once(__DIR__ . '/../database/order.class.php');
  require_once(__DIR__ . '/../database/dish.class.php');

  session_start();

  class resCategory {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    { 
      $this->id = $id;
      $this->name = $name;
    }

    static function getCategories(PDO $db, int $count) : array {
      $stmt = $db->prepare('SELECT idResCategory, name FROM RestaurantCategory LIMIT ?');
      $stmt->execute(array($count));
  
      $categories = array();
      while ($category = $stmt->fetch()) {
        $categories[] = new resCategory(
          intval($category['idResCategory']),
          $category['name'],
        );
      }
  
      return $categories;
    }

    static function searchCategories(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare('SELECT idResCategory, name FROM RestaurantCategory LIMIT ?');
      $stmt->execute(array('%' . $search . '%', $count));

      $categories = array();
      while ($category = $stmt->fetch()) {
        $categories[] = new resCategory(
          $category['idResCategory'],
          $category['name'],
        );
      }

      return $categories;
    }


    static function getCategory(PDO $db, int $id) : resCategory {
      $stmt = $db->prepare('SELECT idResCategory, name FROM RestaurantCategory WHERE idResCategory = ?');
      $stmt->execute(array($id));
  
      $category = $stmt->fetch();
  
      return new resCategory(
        $category['idResCategory'], 
        $category['name']
      );
    }  

    /*GET MAXIMUM OF COUNT RESTAURANTS FROM CATEGORY*/
    static function getRestaurants(PDO $db, int $category, int $count) : array {
        $stmt = $db->prepare('SELECT Restaurant.idRestaurant AS idRestaurant
        FROM Restaurant LEFT JOIN ResBelongsToCategory
        ON ResBelongsToCategory.idRestaurant == Restaurant.idRestaurant
        WHERE idResCategory == ? LIMIT ?');

        $stmt->execute(array($category, $count));
  
        $restaurants = array();
        while ($query = $stmt->fetch()) {
          $restaurants[] = 
            Restaurant::getRestaurant($db, intval($query['idRestaurant']));
        }
  
        return $restaurants;
    }
  }
?>