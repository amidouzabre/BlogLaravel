<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function create(): Response
    {
        if(!Auth::check()) {
            abort(403);
        }

        return Inertia::render('Post/Create');
    }
}
