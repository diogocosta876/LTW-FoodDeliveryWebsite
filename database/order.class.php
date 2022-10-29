<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/dish.class.php');

  session_start();

  class Order {
    public int $idOrder;
    public $dish_array = array();
    public int $idCustomer;
    public int $idRestaurant;
    public int $idState;
    public float $total;
    public static $id_counter = 1;

    public function __construct(int $idOrder, int $idCustomer, int $idRestaurant, int $idState){
      $this->idOrder = $idOrder;
      $this->idCustomer = $idCustomer;
      $this->idRestaurant = $idRestaurant;
      $this->idState = $idState;
      $this->total = 0;

    }

    function getCartDishes(PDO $db): array{
      return $this->dish_array;
    }


    function addDishToCart($db, $dish_id, $user_id){
      if (isset($_SESSION['id'])){
        //get restaurant
        $stmt = $db->prepare('SELECT idRestaurant FROM Dish WHERE idDish = ?');
        $stmt->execute(array($dish_id));
        
        $restaurant_id= current($stmt->fetch());

        if(isset($this->idRestaurant) & ($this->idRestaurant == 0)){
          $this->idRestaurant = intval($restaurant_id);
          console_log("new order, selecting restaurant");
        }

        //check if dish is already added
        $found = false;
        foreach ($this->dish_array as $array_dish_id){
          if ($array_dish_id == $dish_id){
            console_log("dish already added, upping quantity");
            $found = true;
          }
        }
        //if not, add it
        if (Dish::getDish($db, $dish_id)->idRestaurant == $this->idRestaurant){
          $this->dish_array[] = $dish_id;
          $_SESSION["order"] = $this->getOrder();
          console_log("adding dish");
        }
        else{
          console_log("dish already added or from a diferent restaurant");
        }

        $this->updateTotal($db);
        $_SESSION["order"] = $this->getOrder();

        //TODO ADICIONAR AO CARRINHO~
      }
    }

    function removeDishFromCart($db, $dish_id, $user_id){
      $removed = false;
      if (isset($_SESSION['id'])){
        for ($i = 0; $i < count($this->dish_array); $i++){
          if ($this->dish_array[$i] == $dish_id & !$removed){
            unset($this->dish_array[$i]);
            $removed = true;
            $this->dish_array = array_values($this->dish_array);
            console_log("successfully removed dish");
          }
        }
      
        //if there are 0 dishes, remove restaurant from the order
        if (count($this->dish_array) == 0){
          $this->idRestaurant = 0;
        }
        $this->updateTotal($db);
        $_SESSION["order"] = $this->getOrder();
      }
    }

    function sendOrder(PDO $db){
      if (count($this->dish_array) == 0){
        console_log("No items in Cart");
        return;
      }

      //if order is not in db add it
      $stmt = $db->prepare('SELECT idOrder FROM Order_ WHERE idOrder = ?');
      $stmt->execute(array($this->idOrder));
      $order_id = 0;
      while ($order = $stmt->fetch()){
        $order_id = $order['idOrder'];
      }
      console_log("id order: " .strval($order_id));

      if(!$order_id){
        console_log("adding order to db");
        $stmt = $db->prepare('INSERT INTO Order_(idOrder, idcustomer, idRestaurant, timestamp, idState)
          VALUES(?, ?, ?, \'2022-01-13 22:36:10\', 1);');
        $stmt->execute(array($this->idOrder, $this->idCustomer, $this->idRestaurant));

        //add dishes to the db order
        $dishes_map = array();
        foreach($this->dish_array as $dish){
          console_log("dish: " .strval($dish));
          if (array_key_exists($dish, $dishes_map)){
            $dishes_map[$dish] += 1;
          }
          else{
            $dishes_map[$dish] = 1;
          }
        }

        foreach($dishes_map as $dish_id => $quantity) {
          $stmt = $db->prepare('INSERT INTO BelongsToOrder(idOrder, idDish, quantity)
            VALUES(?, ?, ?)');
          $stmt->execute(array($this->idOrder, $dish_id, $quantity));
          console_log($dish_id);
          console_log($quantity);
        }
      }

      $this->dish_array = [];
      $this->idOrder += 1;
      $this->idRestaurant = 0;
      $_SESSION['order'] = $this;
    }

    function updateTotal(PDO $db){
      $this->total = 0;
      foreach ($this->dish_array as $dish_id){
        $price = strval(Dish::getDish($db, $dish_id)->price);
        $this->total += $price;
      }
    }

    function getOrder(){
      $order = new Order($this->idOrder , $this->idCustomer , $this->idRestaurant , $this->idState , $this->total);
      $order->dish_array = $this->dish_array;
      return $order;
    }


    static function searchRestaurants(PDO $db, string $search, int $count): array{
        $stmt = $db->prepare('SELECT * FROM Restaurant LIMIT WHERE name_ LIKE ? LIMIT ?');
        //Restaurants that have the term search contained in them
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
      $stmt = $db->prepare('SELECT * FROM Restaurant WHERE idRestaurant = ?');
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
  }

  function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
  }
?>