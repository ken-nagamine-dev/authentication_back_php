<?php

namespace app\services;

use app\repositories\UserRepository;
use app\services\AuthService;

class UsersService
{
   public static function getUserByEmail($email)
   {
      $email = strip_tags($email);
      return UserRepository::getUserByEmail($email);
   }

   public function getAll()
   {
      // check if the token is valid
      $auth = AuthService::checkAuth();
      if($auth === NULL || $auth === 'Expired token'){
         return 'No access permission!';
      } 

      return UserRepository::getAllUser();
   }

}