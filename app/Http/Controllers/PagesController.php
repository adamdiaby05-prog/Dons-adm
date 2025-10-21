<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function network()
    {
        return view('network');
    }

    public function numero(Request $request)
    {
        return view('numero', [
            'network' => $request->query('network', 'wave'),
        ]);
    }

    public function montant(Request $request)
    {
        return view('montant', [
            'network' => $request->query('network', 'wave'),
            'phone' => $request->query('phone', '+225 07 08 09 10 11'),
        ]);
    }

    public function presentation()
    {
        return view('presentation');
    }
}
