<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function Dashboard()
    {
        $data = [
            'pageTitle' => 'Admin | Dashboard'
        ];
        return view('backend.pages.dashboard.index', $data);
    }
}
