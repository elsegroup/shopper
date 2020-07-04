<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category as Catalog;
use App\Http\Controllers\Controller;
use App\Http\Resources\CatalogResource;
use App\Http\Resources\CatalogCollection;

class CatalogsController extends Controller
{
    protected $catalogModel;

    public function __construct(Catalog $catalogModel)
    {
        return $this->catalogModel = $catalogModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CatalogCollection(
            Catalog::whereStatus(Catalog::STATUS_ACTIVE)->with('products')->get()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Catalog $catalog)
    {
        return CatalogResource::make($catalog);
    }

}
