<?php

namespace app\repositories;

use app\models\DB;

class UserRepository 
{
   public static function getUserByEmail(string $email)
   {
      $connPDO = DB::connect();

      $sql = "SELECT * FROM users WHERE email = :email";
      $stat = $connPDO->prepare($sql);
      $stat->bindValue(":email", $email);
      $stat->execute();

      if($stat->rowCount() > 0){
         return $stat->fetch(\PDO::FETCH_OBJ);
      } else {
         throw new \Exception('No user found!');
      }
   }

   public static function getAllUser()
   {
      $connPDO = DB::connect();

      $sql = "SELECT * FROM users";
      $stat = $connPDO->prepare($sql);
      $stat->execute();

      if($stat->rowCount() > 0){
         return $stat->fetchAll(\PDO::FETCH_ASSOC);
      } else {
         throw new \Exception('No user found!');
      }
   }


}