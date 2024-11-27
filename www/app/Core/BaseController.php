<?php

  namespace Com\Daw2\Core;

use Com\Daw2\Libraries\Mensaje;


abstract class BaseController
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View(get_class($this));
    }

    public function addFlashMessage(Mensaje $message){
        if(isset($_SESSION['flashMessage']) || is_array($_SESSION['flashMessage'])){
            $_SESSION['flashMessage'] = [];
        }
        $_SESSION['flashMessage'][] = $message;
    }
}
