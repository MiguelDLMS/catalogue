<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteRequestFormController extends Controller
{
    public function Request(Request $request) {

        // Form validation
        $this->validate($request, [
            'name' => 'required',
            'last-name' => 'required',
            'email' => 'required',
            'message' => 'required',
            'product-name' => 'required',
            'product-url' => 'required'
        ]);
    }
}

