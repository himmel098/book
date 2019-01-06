<?php



class Controller
{

//    public $session;

    function __construct()
    {
//        $this->session = new session();
    }

    public function loadView( $view, $data = '' )
    {
        require APP . 'views/_templates/header.php';
        require APP . 'views/' . $view . '.php';
        require APP . 'views/_templates/footer.php';

    }
}
