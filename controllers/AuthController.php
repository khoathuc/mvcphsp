<?php 
    namespace app\controllers;

use app\core\Application;
use app\core\Controller;
    use app\core\Request;
    use app\core\Response;
    use app\models\User;
    use app\models\LoginForm;
    /**
     * class AuthController
     * @package app\controllers
     */
    class AuthController extends Controller{
        public function login(Request $request,Response $response){
            $this->setLayout('auth');
            $loginModel = new LoginForm();
            if($request->isPost()){
                $loginModel->loadData($request->getBody());
                if($loginModel->validate() && $loginModel->login()){
                    $response->redirect('/PHPMVCFramework/src/info');
                }
            }
            return $this->render('login',[
                'model'=>$loginModel
            ]);
        }
        public function logout(Request $request,Response $response){
            $this->setLayout('auth');
            Application::$app->logout();
            $response->redirect('/PHPMVCFramework/src/login');
        }
        public function register(Request $request, Response $response){
            $this->setLayout('auth');
            $registerModel = new User();
            if($request->isPost()){
                $registerModel->loadData($request->getBody()); 
                $registerModel->checkValidName();
                if($registerModel->validate()){
                    $registerId = $registerModel->save();
                    if($registerId){
                        $user = User::findOne(['id'=>$registerId]);
                        Application::$app->login($user);
                        $response->redirect('/PHPMVCFramework/src/info');
                    }
                }
                return $this->render('register',[
                    'model'=>$registerModel
                ]);
            }
            return $this->render('register',[
                'model'=>$registerModel
            ]);
        }
    }