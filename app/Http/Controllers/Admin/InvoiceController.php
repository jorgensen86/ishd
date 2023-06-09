<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        if (request()->ajax() && Str::of(request()->filter_invoice)->trim()) {
            return Invoice::where(function ($query) {
                if(request()->user_id) {
                    $query->whereNull('user_id');
                    $query->orWhere('user_id', '!=', request()->user_id);
                }
            })
                ->where('invoice_number', 'LIKE', request()->filter_invoice . '%')
                ->orWhere('domain', 'LIKE', request()->filter_invoice . '%')
                ->limit(10)
                ->get();
        }
    }
}
