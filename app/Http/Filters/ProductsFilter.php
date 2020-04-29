<?php

namespace App\Http\Filters;

class ProductsFilter extends QueryFilter
{
	public function name($value)
	{
		$this->builder->where('name', 'like', "%$value%");
	}

	public function price_to($value)
	{
		if (! $value) return;

		$this->builder->where('price', '<=', $value);
	}

	public function price_from($value)
	{
		if (! $value) return;

		$this->builder->where('price', '>=', $value);
	}

	public function category($value)
	{
		if (! $value) return;
		//
	}
}
