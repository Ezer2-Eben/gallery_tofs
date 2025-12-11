<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'totalImages' => Image::where('user_id', $user->id)->count(),
            'publicImages' => Image::where('user_id', $user->id)
                ->where('visibility', 'public')
                ->count(),
            'totalCategories' => Category::count(),
            'recentImages' => Image::where('user_id', $user->id)
                ->with(['category', 'subcategory'])
                ->latest()
                ->limit(8)
                ->get(),
        ];

        return view('dashboard', $stats);
    }
}