<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;

class ImportProductsController extends Controller
{

    public function create()
    {
        return view('Dashboard.Productes.import');
    }
    public function store(Request $request)
    {
        $job = new ImportProducts($request->post('count'));
        $job->onQueue('import');
        dispatch($job);

        return redirect()->route('products.index')->with('success', 'Products imported Runing...');
    }
}
