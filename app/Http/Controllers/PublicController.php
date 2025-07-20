<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class PublicController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('public.index', compact('books'));
    }
}
