<?php

namespace App\Http\Controllers\Navigation;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class NavigationController extends Controller
{


    public function back(Request $request)
    {

        $back = $request->session()->get('pre_previous');

        if ($back) {
            return redirect($back);
        }

        return redirect(RouteServiceProvider::HOME);

    }
}
