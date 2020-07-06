<?php

namespace PixelPenguin\Website\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use PixelPenguin\Admin\Models\Page;
use PixelPenguin\Admin\Models\ProductPrice;
use PixelPenguin\Admin\Models\Special;
use PixelPenguin\Admin\Models\NewsLetter;

class HomeController extends Controller
{
	public function index(){
		
		//echo 'hi';
		
		$page = Page::whereId(1)->first();
		
		$featuredProducts = ProductPrice::
		leftJoin('products', 'products.id', 'product_prices.product_id')
		->with('product')
		->with('product.gallery')
		->with('product.category')
		->where('products.active', true)
		->where('product_prices.active', true)
		->where('products.featured', true)
		->get();
		
		
		$discountedProducts = ProductPrice::
		leftJoin('products', 'products.id', 'product_prices.product_id')
		->with('product')
		->with('product.gallery')
		->with('product.category')
		->where('products.active', true)
		->where('product_prices.is_discount', true)
		->where('product_prices.active', true)
		->get();
		
		$specials = Special::All();
		
		//dd($featuredProducts[0]->product);
		
		return view('pixel-penguin-website::home.home1', ['discountedProducts' => $discountedProducts, 'featuredProducts' => $featuredProducts, 'page' => $page, 'specials' => $specials]);
		
	}
	
	public function SubscribeNewsLetter(Request $request){
		$input = $request->all();
		
		$newsletter = new NewsLetter();
		
		$newsletter->email = $input['email'];
		$newsletter->save();
		
		return redirect('/');
	}
	
	static public function functionInController(){
		return [
			'success' => true,
			'message' => 'controller function executed!'
		];
		
	}
}