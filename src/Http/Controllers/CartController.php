<?php

namespace PixelPenguin\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PixelPenguin\Admin\Models\Page;
use PixelPenguin\Admin\Models\ProductPrice;

use ShoppingCart;

class CartController extends Controller
{
	
	public function viewCart(){
		
		
		return view ('pixel-penguin-website::cart.cart1');
	}
	
	public function viewCheckout(){
		
		
		return view ('pixel-penguin-website::checkout.checkout1');
	}
	
	public function addToCart(Request $request){
		
		$input = $request->all();
		
		//dd($input);
		
		if ($request->session()->exists('cart')) {
			$cart = $request->session()->get('cart');
		}
		else{
			$cart = collect();
		}
		
		
		
		$productPrice = ProductPrice::whereId($input['productPriceId'])->first();
		$quantity = $input['quantity'];
		
		// add the product to cart
		
		$price = $productPrice->price;
		if($productPrice->is_discount){
			$price = $productPrice->discounted_price;
		}
		
		
		if(!$cart->isEmpty() && $cart->where('id', $productPrice->id)->first() != false){
			
			//dd($cart->where('id', $productPrice->id)->first());
			
			$existingQuantity = $cart->where('id', $productPrice->id)->first()['quantity'];
			
			//dd($item);
			
			$test = $cart->where('id', $productPrice->id)->reject(function($element, $key) use ($productPrice, $cart) {
				
				$cart->forget($key);
				
				return $element['id'] != $productPrice->id;				
				
			});
			
			//dd($test);
			
			$cart->push([
				'id' => $productPrice->id, 
				'name' => $productPrice->name, 
				'quantity' => $existingQuantity + $quantity, 
				'price' => $price,
				'delete' => false,
				'product' => $productPrice->product()->with('gallery')->first()
			]);	
				
		}
		else{
			
			$cart->push([
				'id' => $productPrice->id, 
				'name' => $productPrice->name, 
				'quantity' => $quantity, 
				'price' => $price,
				'delete' => false,
				'product' => $productPrice->product()->with('gallery')->first()
			]);	
		}
		
		
		
		//dd($cartProduct);
		
		$request->session()->put('cart', $cart);
		
		return [
			'success' => true,
			//'obj' => $cart
		];
			
	}
	
	public function updateCart(Request $request){
		
		$input = $request->all();
		
		//dd($input);
		
		//dd($input);
		
		
		$cart = collect();
		
		
		
		foreach($input['cart'] as $cartEntry){
			
			$productPrice = ProductPrice::whereId($cartEntry['id'])->first();
			
			$price = $productPrice->price;
			if($productPrice->is_discount){
				$price = $productPrice->discounted_price;
			}
			
			$cart->push([
				'id' => $productPrice->id, 
				'name' => $productPrice->name, 
				'quantity' => $cartEntry['quantity'], 
				'price' => $price,
				'delete' => false,
				'product' => $productPrice->product()->with('gallery')->first()
			]);	
		}
		
		//dd($cartProduct);
		
		$request->session()->put('cart', $cart);
		
		return [
			'success' => true,
			//'obj' => $cart
		];
			
	}
	
	public function getCart(Request $request){
		
		if ($request->session()->exists('cart')) {
			$cart = $request->session()->get('cart');
		}
		else{
			$cart = collect();
		}
		
		$subtotal = 0;
		
		$totalQuantity = 0;
		
		foreach($cart as $cartEntry){
			$subtotal += ($cartEntry['price'] * $cartEntry['quantity']);
			
			$totalQuantity += $cartEntry['quantity'];
		}
		
		return [
			'success' => true,
			'obj' => $cart,
			'subtotal' => $subtotal,
			'totalQuantity' => $totalQuantity
		];
	}
	
	public function removeItemCompletely(Request $request){
		
		$input = $request->all();
		
		$productPrice = ProductPrice::whereId($input['productPriceId'])->first();
		
		if ($request->session()->exists('cart')) {
			$cart = $request->session()->get('cart');
		}
		else{
			$cart = collect();
		}
		
		//dd($productPrice);
		
		
		
		$cart->where('id', $productPrice->id)->reject(function($element, $key) use ($productPrice, $cart) {

			$cart->forget($key);

			return $element['id'] != $productPrice->id;				

		});
		
		
		//dd($cart);
		
		$request->session()->put('cart', $cart);
	}
	
	public function clearCart(Request $request){		
		
		$cart = collect();
		
		$request->session()->put('cart', $cart);
		
	}
	
	
}