<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;
use DNS1D;
use Artisan;

use Carbon\Carbon;

class pdfPrueba extends Controller
{
    public function index(Request $request)
    {
    	/*echo Artisan::call('migrate',[
            '--force' => '--force'
        ]);*/

        return "hecho";
    }
}
