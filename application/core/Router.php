<?php

class Router
{
    /** @var null The controller */
    private $urlController = null;

    /** @var null The method (of the above controller), often also named "action" */
    private $urlAction = null;

    /** @var array URL parameters */
    private $urlParams = [];

    private $controllerPath = '/controllers/';

    private $controllerSuffix = 'Controller';

    /**
     * "Start" the application:
     * Analyze the URL elements and calls the according controller/method or the fallback
     */
    public function __construct()
    {
        // create array with URL parts in $url
        $this->splitUrl();

        // check for controller: no controller given ? then load start-page

        if ( ! $this->urlController ) {

            require APP . $this->controllerPath. 'HomeController.php';
            $page = new HomeController();
            $page->index();

        } elseif ( file_exists( APP . $this->controllerPath . $this->urlController. '.php' ) ) {
            // here we did check for controller: does such a controller exist ?

            // if so, then load this file and create this controller
            // example: if controller would be "car", then this line would translate into: $this->car = new car();
            require APP . $this->controllerPath . $this->urlController . '.php';
            $this->urlController = new $this->urlController();

            // check for method: does such a method exist in the controller ?
            if ( method_exists( $this->urlController, $this->urlAction ) ) {

                if ( ! empty( $this->urlParams ) ) {
                    // Call the method and pass arguments to it
                    call_user_func_array( array( $this->urlController, $this->urlAction ), $this->urlParams );
                } else {
                    // If no parameters are given, just call the method without parameters, like $this->home->method();
                    $this->urlController->{$this->urlAction}();
                }

            } else {
                if ( strlen( $this->urlAction ) == 0 ) {
                    // no action defined: call the default index() method of a selected controller
                    $this->urlController->index();
                } else {
                    header( 'location: ' . URL . 'problem' );
                }
            }
        } else {
            header( 'location: ' . URL . 'problem' );
        }
    }

    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        if ( isset( $_GET['url'] ) ) {

            // split URL
            $url = trim( $_GET['url'], '/' );
            $url = filter_var( $url, FILTER_SANITIZE_URL );
            $url = explode( '/', $url );

            if($url[0]=='admin'){
                $this->urlController = isset( $url[1] ) ? ucfirst($url[1]).$this->controllerSuffix : 'HomeController';
                $this->urlAction     = isset( $url[2] ) ? $url[2] : null;
                $this->controllerPath .='admin/';
            }else{
                $this->urlController = isset( $url[0] ) ? ucfirst($url[0]).$this->controllerSuffix : null;
                $this->urlAction     = isset( $url[1] ) ? $url[1] : null;

            }

            // Put URL parts into according properties

            // Remove controller and action from the split URL
            unset( $url[0], $url[1] );

            // Rebase array keys and store the URL params
            $this->urlParams = array_values( $url );

            // for debugging. uncomment this if you have problems with the URL
            //echo 'Controller: ' . $this->url_controller . '<br>';
            //echo 'Action: ' . $this->url_action . '<br>';
            //echo 'Parameters: ' . print_r($this->url_params, true) . '<br>';
        }
    }
}
