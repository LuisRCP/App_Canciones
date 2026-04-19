<?php

namespace App\Controllers;

class MusicController extends BaseController
{
    public function reproductorPage()
    {
        return view('music/reproductor');
    }
}