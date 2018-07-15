<?php

namespace App;

class Slug extends Base
{
	protected $fillable = [
		'item_type',
		'item_id',
		'title'
	];

    /**
     * Item can be anyting
     */
	public function item()
    {
        return $this->morphTo();
    }
}
