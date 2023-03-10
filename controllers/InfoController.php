<?php

    namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\DbModel;
use app\core\Response;
use app\models\User;
    use app\core\Request;
use Exception;

    /**
     * 
     * Class InfoController
     * @package app\controllers
     */
    class InfoController extends Controller{
        public function info(Request $request, Response $response){
            try{
                $this->setLayout('main');
                $user = [];
                $userId = Application::$app->session->get('user')['id']??false;
                if($request ->isPost()){
                    if(User::updateInfo($request->getBody(), $userId)){
                        $response->redirect('/PHPMVCFramework/src/info');
                    }
                }
                $user = User::findOne(['id'=>$userId]);
                
                return $this->render('info',[
                    'userModel'=>$user,
                    'userId'=>$userId
                ]);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }