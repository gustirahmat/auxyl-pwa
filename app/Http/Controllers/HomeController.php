<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Homepage', [
            'appName' => config('app.name'),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'categories' => Category::all()->take(2),
            'products' => Product::with('relatedCategory', 'relatedPhotos')->latest()->get()
        ]);
    }
}
