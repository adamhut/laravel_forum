<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
	protected $request;

	protected $builder;

	protected $filters = [];

	public function __construct(Request $request)
	{
		$this->request	 = $request	;
	}

	public function apply($builder)
	{
		$this->builder = $builder;

		/*//fnctional approcah
		collect($this->getFilters())
			->filter(function($value,$filter){

				return method_exists($this, $filter);
			})
			->each(function($value,$filter){
				$this->$filter($value);
			});
		*/

		//dd($this->getFilters());
		//we apply our filter to the builder
		foreach($this->getFilters() as $filter=>$value)
		{
			if(method_exists($this,$filter))
			{
				$this->$filter($value);
			}
		}


		return $this->builder;
	}

	public function getFilters()
	{
		//return $this->request->only($this->filters);
		//return $this->request->intersect($this->filters);
		return array_filter($this->request->only($this->filters));
	}



}
