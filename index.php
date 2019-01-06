<?php


define( 'APP', 'application' . DIRECTORY_SEPARATOR );


// load application config (error reporting etc.)
require APP . 'config/config.php';

// FOR DEVELOPMENT: this loads PDO-debug, a simple function that shows the SQL query (when using PDO).
// If you want to load pdoDebug via Composer, then have a look here: https://github.com/panique/pdo-debug
require APP . 'libs/helper.php';

// load application class
require APP . 'core/Router.php';
require APP . 'core/controller.php';
require APP . 'core/model.php';
require APP . 'libs/session.php';

function __autoload($class)
{
    $directorys = array( //include all directories in Array
        '/application/controllers/',
        '/application/models/',
        '/application/views/'
    );
    //foreach directory
    foreach($directorys as $directory)
    {
        //see if the file exsists
        if(file_exists(dirname(__FILE__).$directory.$class.'.php'))
        {
            require_once(dirname(__FILE__).$directory.$class.'.php');
            //only require the class once, so quit after to save effort (if you got more, then name them something else
            return;
        }
    }
}


// start the application
$app = new Router();
