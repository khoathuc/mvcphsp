<?php

    namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Response;
use app\models\User;
    use app\core\Request;

    /**
     * 
     * Class InfoController
     * @package app\controllers
     */
    class InfoController extends Controller{
        public function info(Request $request, Response $response){
                $this->setLayout('main');
                $user = [];
                $userId = Application::$app->session->get('user')['id']??false;
                if($userId){
                    $user = User::findOne(['id'=>$userId]);
                }
                if($request ->isPost()){
                    
                }
                
                return $this->render('info',[
                    'userModel'=>$user
                ]);

        }
    }