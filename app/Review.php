<?php

namespace App;

class Review extends Base
{
	protected $fillable = [
		'title',
		'content',
		'rating'
	];

	/**
    * Item can be anything
    */
	public function item()
    {
        return $this->morphTo();
    }
}
