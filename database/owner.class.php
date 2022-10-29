<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/restaurant.class.php');

  class Owner {
    public int $id;
    public string $username;
    public string $address;
    public string $phoneNumber;

    public function __construct(int $id, string $username, string $address, string $phoneNumber){
      $this->id = $id;
      $this->username = $username;
      $this->address = $address;
      $this->phoneNumber = $phoneNumber;
    }


    static function getOwnerWithPassword(PDO $db, string $username, string $password) : ?Owner {
        $stmt = $db->prepare('SELECT idUser, username, address_, phoneNumber 
        FROM User JOIN RestaurantOwner ON idUser = idRestaurantOwner
        WHERE username = ? AND password = ?');
        $stmt->execute(array($username, sha1($password)));
    
        if ($owner = $stmt->fetch()) {
            return new Owner(
                intval($owner['idUser']),
                $owner['username'],
                $owner['address_'],
                $owner['phoneNumber'],
            );
        } else return null;
      }


    static function getOwner(PDO $db, int $idOwner): Owner{
        $stmt = $db->prepare('SELECT idUser, username, address_, phoneNumber FROM User WHERE idUser = ?');
        $stmt->execute(array($idOwner));

        $owner = $stmt->fetch();

        return new Owner(
            intval($owner['idUser']),
            $owner['username'],
            $owner['address_'],
            $owner['phoneNumber'],
        );
    }

    static function registerOwner(PDO $db, string $username, string $password, string $address, string $phoneNumber): ?Customer{
      $stmt = $db->prepare('SELECT COUNT(idUser) AS numUsername FROM User WHERE username = ?');
      $stmt->execute(array($username));
      $ans = $stmt->fetch();

      if($ans['numUsername'] > 0) return null;

      $stmt = $db->prepare('SELECT max(idUser) + 1 AS idUser FROM User');
      $stmt->execute();
      $query = $stmt->fetch();
      $idOwner = intval($query['idUser']);

      $stmt = $db->prepare('INSERT INTO User(idUser, username, password, address_, phoneNumber)
        VALUES(?, ?, ?, ?, ?);');
      $stmt->execute(array($idOwner, $username, sha1($password), $address, $phoneNumber));

      $stmt = $db->prepare('INSERT INTO RestaurantOwner(idRestaurantOwner)
        VALUES(?);');
      $stmt->execute(array($idOwner));

      return new Customer(
        $idOwner,
        $username,
        $address,
        $phoneNumber,
      );
    }

    static function getRestaurants(PDO $db, int $idOwner) : array {
      
      $stmt = $db->prepare('SELECT idRestaurant FROM Owns WHERE idOwner == ?');
      
      $stmt->execute(array($idOwner));
      
      $restaurants = array();
      while ($query = $stmt->fetch()) {
        console_log(intval($query['idRestaurant']));
        $restaurants[] = 
          Restaurant::getRestaurant($db, intval($query['idRestaurant']));
      }
      return $restaurants;
    }
  }
?>