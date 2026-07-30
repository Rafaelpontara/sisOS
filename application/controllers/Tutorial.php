<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tutorial extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['menuTutorial'] = true;
    }

    public function index()
    {
        $this->data['view'] = 'tutorial/tutorial';

        return $this->layout();
    }
}
