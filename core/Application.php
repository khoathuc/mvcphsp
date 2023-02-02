<?php
    namespace app\core;
    use app\core\Request;
    use app\core\Router;
    use app\core\Response;
    use app\core\Controller;
    use app\core\Session;
    /**
     * Class Application
     * 
     * @package app\core 
     */
    class Application{

        public static string $ROOTDIR;
        public string $layout = 'main';
        public Router $router;
        public Request $request;
        public Response $response;
        public Database $db;
        public Session $session;
        public static Application $app;
        public ?Controller $controller = null;
        
        public function setController($controller){
            $this->app->controller = $controller;
        } 
        public function login($user){   
            $this->session->set('user', ['id'=>$user['id']]);
            return true;
        }
        public function logout(){
            $this->session->remove('user');
        }
        public function __construct($rootPath, array $config)
        {
            self::$ROOTDIR = $rootPath;
            $this->request = new Request();
            $this->response = new Response();
            $this->session = new Session();
            $this->db = new Database($config['db']);
            $this->router = new Router($this->request, $this->response);
            self::$app = $this;
        }
        public function run(){
            return $this->router->resolve();
        }
    }