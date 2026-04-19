<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function generosPage()
    {
        return view('admin/generos');
    }

    public function cancionesPage()
    {
        return view('admin/canciones');
    }
}