<?php

namespace PixelPenguin\Website;

use Illuminate\Support\ServiceProvider;

class PixelPenguinWebsiteServiceProvider extends ServiceProvider
{
	public function boot(){
		
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
		$this->loadViewsFrom(__DIR__.'/views', 'pixel-penguin-website');
		
		$this->loadMigrationsFrom(__DIR__.'/database/migrations');
		
	}
	
	public function register(){
		
	}
}