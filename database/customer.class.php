<?php
  declare(strict_types = 1);

  session_start();

  class Customer {
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


    static function getCustomerWithPassword(PDO $db, string $username, string $password) : ?Customer {
        $stmt = $db->prepare('SELECT idUser, username, address_, phoneNumber 
        FROM User JOIN Customer ON idCustomer = idUser
        WHERE username = ? AND password = ?');
        $stmt->execute(array($username, sha1($password)));
    
        if ($customer = $stmt->fetch()) {
            return new Customer(
                intval($customer['idUser']),
                $customer['username'],
                $customer['address_'],
                $customer['phoneNumber'],
            );
        } else return null;
      }


    static function getCustomer(PDO $db, int $idCustomer): Customer{
        $stmt = $db->prepare('SELECT idUser, username, address_, phoneNumber FROM User WHERE idUser = ?');
        $stmt->execute(array($idCustomer));

        $customer = $stmt->fetch();

        if ($customer != false){

          return new Customer(
            intval($customer['idUser']),
            $customer['username'],
            $customer['address_'],
            $customer['phoneNumber'],
          );
        }
        return new Customer(0,'null', 'null', 'null');
    }

    static function registerCustomer(PDO $db, string $username, string $password, string $address, string $phoneNumber): ?Customer{
      $stmt = $db->prepare('SELECT COUNT(idUser) AS numUsername FROM User WHERE username = ?');
      $stmt->execute(array($username));
      $ans = $stmt->fetch();

      if($ans['numUsername'] > 0) return null;

      $stmt = $db->prepare('SELECT max(idUser) + 1 AS idUser FROM User');
      $stmt->execute();
      $query = $stmt->fetch();
      $idCustomer = intval($query['idUser']);

      $stmt = $db->prepare('INSERT INTO User(idUser, username, password, address_, phoneNumber)
        VALUES(?, ?, ?, ?, ?);');
      $stmt->execute(array($idCustomer, $username, sha1($password), $address, $phoneNumber));

      $stmt = $db->prepare('INSERT INTO Customer(idCustomer)
        VALUES(?);');
      $stmt->execute(array($idCustomer));

      return new Customer(
        $idCustomer,
        $username,
        $address,
        $phoneNumber,
      );
    }

    static function changeInfo(PDO $db,int $idCustomer, string $username, string $password, string $address, string $phoneNumber): ?Customer{
      
      $stmt = $db->prepare('UPDATE User
                            SET username = ?, password = ?, address_ = ?, phoneNumber = ?
                            WHERE idUser = ?;');
      $stmt->execute(array($username, sha1($password), $address, $phoneNumber, $idCustomer));

      return new Customer(
        $idCustomer,
        $username,
        $address,
        $phoneNumber,
      );
    }
  }
?>