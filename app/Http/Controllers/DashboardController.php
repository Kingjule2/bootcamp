<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function redirect()
    {
        $user = Auth::user();

        return match ($user->role) {
            'dapur' => redirect('/dapur'),
            'ahli_gizi' => redirect('/gizi'),
            'sekolah' => redirect('/sekolah'),
            'admin' => redirect('/admin'),
            'kurir' => redirect('/kurir'),
            default => redirect('/login'),
        };
    }
}
