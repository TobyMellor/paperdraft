<?php

namespace App\Http\Controllers;

use App\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $items = Item::all();
        
        return $items;
    }
}
