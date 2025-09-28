<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lembarkerja\LogAktivitas;

class LogAktivitasController extends Controller
{
   public function index(Request $request)
{
    $query = LogAktivitas::with('user')->latest();

    // filter search (user name atau aktivitas)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('aktivitas', 'like', "%{$search}%")
              ->orWhere('detail', 'like', "%{$search}%")
              ->orWhereHas('user', function($u) use ($search) {
                  $u->where('name', 'like', "%{$search}%");
              });
        });
    }

    // filter tanggal
    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    $logs = $query->paginate(10)->withQueryString();

    return view('aktivitas.index', compact('logs'));
}

}
