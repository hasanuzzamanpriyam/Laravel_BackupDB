<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function show()
    {
        return view('backup');
    }

    public function run(Request $request)
    {
        Artisan::call('database:backup');
        return back()->with('status', 'Database backup completed successfully!');
    }
}

