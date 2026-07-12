<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class HomeController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()->get();

        return view('home', compact('faqs'));
    }
}
