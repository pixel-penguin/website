<?php

namespace PixelPenguin\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PixelPenguin\Admin\Models\Sale;

class InvoiceController extends Controller
{
    public function index($referenceCode){
		
		$sale = Sale::where('reference_code', $referenceCode)->first();
		
		//dd($sale->products);
		
		//return view('website.contact', ['page' => $page]);
		return view('pixel-penguin-website::invoice.template1', ['sale' => $sale]);
	}
	
	public function thankYou($referenceCode){
		
		return view('pixel-penguin-website::thankyou.index',['referenceCode' => $referenceCode]);
	}
}
