<?php

namespace app\services;

use app\services\UsersService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();

class AuthService
{
   public function login()
   {
      $data = json_decode(file_get_contents('php://input'));

      if($_SERVER['REQUEST_METHOD'] === 'POST') {
         if (property_exists($data, 'email') && property_exists($data, 'password')) {
            $user = UsersService::getUserByEmail($data->email);
            if (is_object($user) && $user->password === $data->password) {
   
               $payload = [
                  'exp' => time() + 240, // expired time in seconds
                  'iat' => time(),
                  'email' => $data->email,
               ];
   
               $encode = JWT::encode($payload, $_ENV['JWT_KEY'], 'HS256');
               return json_encode($encode);
            }
         } else {
            return 'Bad request';
         }
      } else {
         return 'Request method not supported';
      }
   }

   public static function checkAuth()
   {
      if( !array_key_exists('HTTP_AUTHORIZATION', $_SERVER)){
         return 'No access permission!';
      }
      $authorization = $_SERVER['HTTP_AUTHORIZATION'];
      $token = str_replace('Bearer ', '', $authorization);

      try {
         $decoded = JWT::decode($token, new Key($_SERVER['JWT_KEY'], 'HS256'));
         return json_encode($decoded);
      } catch (\Throwable $e) {
         return $e->getMessage();
      }
   }
}
