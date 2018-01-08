<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters{

	protected $filters = ['by','popular','unanswered'];


	/**
	 * Filter a query by a username
	 * @param  $username
	 * @return  mixed
	 */
	public function by($username)
	{
		$user = User::where('name',$username)->firstOrFail();
		return $this->builder->where('user_id',$user->id);
	}

	/**
	 * Filter the query accounding to most popular threads
	 * @return [type] [description]
	 */
	public function popular()
	{
		//To clear out any existing order by ;
		$this->builder->getQuery()->orders = [];
		return $this->builder->orderBy('replies_count','desc');
	}

	/**
	 * Filter the query accounding to most popular threads
	 * @return [type] [description]
	 */
	public function unanswered()
	{
		//To clear out any existing order by ;
		return $this->builder->where('replies_count',0);
	}
}
