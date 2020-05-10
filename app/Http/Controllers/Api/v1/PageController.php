<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;

class PageController extends Controller
{

	public function __invoke(Page $page)
	{
		return PageResource::make($page);
	}
}
