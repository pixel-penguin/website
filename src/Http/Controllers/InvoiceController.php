<?php

namespace PixelPenguin\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PixelPenguin\Admin\Models\Sale;

use Auth;

use App\Mail\Contact;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index($referenceCode){
		
		$sale = Sale::where('reference_code', $referenceCode)->first();
		
		//dd($sale->products);
		
		//return view('website.contact', ['page' => $page]);
		return view('pixel-penguin-website::invoice.template1', ['sale' => $sale]);
	}
	
	public function thankYou($referenceCode){
		
		$user = Auth::user();
		
		$sale = Sale::where('reference_code', $referenceCode)->first();
		
		$message = "
			<p>$user->name placed a new order at $sale->created_at</p>
			<p><a href='/invoice/$referenceCode'>Click here to view the invoice</a></p>
		";
		
		$messageUser = "
			<p>Hi $user->name,</p>
			<p>You placed a new order at ".env('APP_NAME')." at $sale->created_at</>
			<p><a href='/invoice/$referenceCode'>Click here to view the invoice</a></p>
		";

		$subject = 'Your new order!';
		
		if(strlen(env('EMAIL_ADDRESS_ORDER_1')) > 0){
			Mail::to(env('EMAIL_ADDRESS_ORDER_1'))->send(new Contact($message, $subject));
		}
		
		if(strlen(env('EMAIL_ADDRESS_ORDER_2')) > 0){
			Mail::to(env('EMAIL_ADDRESS_ORDER_2'))->send(new Contact($message, $subject));
		}
		
		if(env('EMAIL_SEND_USER_EMAIL') == 1){
			Mail::to($user->email)->send(new Contact($messageUser, $subject));
		}
		
		
		return view('pixel-penguin-website::thankyou.index',['referenceCode' => $referenceCode]);
	}
}
