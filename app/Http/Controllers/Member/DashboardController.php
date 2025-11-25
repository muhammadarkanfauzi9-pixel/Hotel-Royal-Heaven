<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('member.dashboard');
    }
}
