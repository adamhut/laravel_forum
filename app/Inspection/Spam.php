<?php 
namespace App\Inspection;

class Spam
{

	protected $inspections = [
		InvalidKeywords::class,
		KeyHeldDown::class,
	];

	public function detect($body)
	{
		foreach($this->inspections as $inspection){
			app($inspection)->detect($body);
		}
		//$this->detectInvalidKeywords($body);
		//$this->detectKeyHeldDown($body);
		return false;
	}


	
}