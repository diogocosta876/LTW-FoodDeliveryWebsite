<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/restaurant.class.php');

  class dishCategory {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    { 
      $this->id = $id;
      $this->name = $name;
    }

    static function getCategories(PDO $db, int $count) : array {
      $stmt = $db->prepare('SELECT idDishCategory, name FROM DishCategory LIMIT ?');
      $stmt->execute(array($count));
  
      $categories = array();
      while ($category = $stmt->fetch()) {
        $categories[] = new dishCategory(
          intval($category['idDishCategory']),
          $category['name'],
        );
      }
  
      return $categories;
    }

    static function searchCategories(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare('SELECT idDishCategory, name FROM DishCategory LIMIT ?');
      $stmt->execute(array('%' . $search . '%', $count));

      $categories = array();
      while ($category = $stmt->fetch()) {
        $categories[] = new dishCategory(
          $category['idDishCategory'],
          $category['name'],
        );
      }

      return $categories;
    }


    static function getCategory(PDO $db, int $id) : dishCategory {
      $stmt = $db->prepare('SELECT idDishCategory, name FROM DishCategory WHERE idDishCategory = ?');
      $stmt->execute(array($id));
  
      $category = $stmt->fetch();
  
      return new dishCategory(
        $category['idDishCategory'], 
        $category['name']
      );
    }  

    /*GET MAXIMUM OF COUNT RESTAURANTS FROM CATEGORY*/
    static function getDishes(PDO $db, int $category, int $count) : array {
        $stmt = $db->prepare('SELECT Dish.idDish AS idDish
        FROM Dish LEFT JOIN DishBelongsToCategory
        ON DishBelongsToCategory.idDish ==Dish.idDish
        WHERE idDishCategory == ? LIMIT ?');

        $stmt->execute(array($category, $count));
  
        $dishes = array();
        while ($query = $stmt->fetch()) {
          $dishes[] = 
            Dish::getDish($db, intval($query['idDish']));
        }
  
        return $dishes;
    }
  }
?>