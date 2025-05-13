<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function responsibleGaming()
    {
        return view('pages.responsible-gaming');
    }

    public function faq()
    {
        return view('pages.faq');
    }
}