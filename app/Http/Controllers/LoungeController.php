<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 休息室
 */
class LoungeController extends Controller
{
    /**
     * 休息室大厅
     * @return [type]           [description]
     */
    public function index()
    {
        return view('lounge.index');
    }
}
