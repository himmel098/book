<?php


class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title'   => 'Admin panel',
        ];
        $this->loadView( 'admin/index', $data );

    }
}