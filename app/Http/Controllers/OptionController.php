<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function isPenaltiesStrict()
    {
        $option = Option::first();
        return $option->options['isPenaltiesStrict'];
    }

    public function setPenaltiesStrictMode(Request $request) {
        $option = Option::first();
        $option->update([
           'options' => [
               'isPenaltiesStrict' => $request->isPenaltiesStrict
           ]
        ]);
        return $option;
    }
}
