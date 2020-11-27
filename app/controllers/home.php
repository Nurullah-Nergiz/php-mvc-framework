<?php

namespace app\controllers;

class home
{

    public function index($id = '')
    {
        return 'Bursası anasayfa ' . $id;
    }
    public function users()
    {
    }
    public function admin($data)
    {
        echo 'data ' . $data;
    }
}
