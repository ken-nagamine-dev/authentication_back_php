<?php
namespace app\models;

class Rest 
{
   private $request;
   private $service;
   private $method;
   private $params = array();

   public function __construct($req)
   {
      $this->request = $req;
      $this->setAction();
   }

   public function setAction()
   {
      $sharedUrl = explode('/', $this->request['REQUEST_URI']);
      array_shift($sharedUrl);

      if(isset($sharedUrl[0]) && $sharedUrl[0] !== ''){
         $this->service = ucfirst($sharedUrl[0]).'Service'; 
         array_shift($sharedUrl);

         if(isset($sharedUrl[0]) && $sharedUrl[0] !== ''){
            $this->method = $sharedUrl[0];
            array_shift($sharedUrl);

            if(isset($sharedUrl[0]) && $sharedUrl[0] !== ''){
               $this->params = $sharedUrl;
            }
         }
      }

      if(!isset($this->method) ){
         return null;
      }
   }

   public function run()
   {
      if($this->method !== NULL && class_exists("\app\services\\".$this->service) && method_exists("\app\services\\".$this->service, $this->method)){

         //list of methods released by services...
         $apiMethods = ['getAll','login'];

         if(in_array($this->method, $apiMethods) ){
            try {
               $service = "\app\services\\".$this->service;
               $response = call_user_func_array(array(new $service, $this->method), $this->params);
               return json_encode(array('data' => $response));
   
            } catch (\Exception $e){
               return json_encode(array('Error: ' => $e->getMessage()));
            }
         }
         return json_encode(array('Error' => 'invalid operation!'), JSON_UNESCAPED_UNICODE);
      } else {
         http_response_code(404);
         return json_encode(array('Error' => 'invalid operation!'), JSON_UNESCAPED_UNICODE);
      }
   }
}