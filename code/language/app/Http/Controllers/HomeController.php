<?php

namespace App\Http\Controllers;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @author willy.lai <willy.lai@astrocorp.com.tw>
     */
    public function index()
    {
        return view('home/index');
    }
}
