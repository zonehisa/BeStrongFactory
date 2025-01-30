<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class StockManagementController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        return view('stock_management.index', compact('inventories'));
    }
}
