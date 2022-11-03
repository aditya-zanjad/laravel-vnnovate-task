<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\DataTables\ShopsDataTable;
use App\DataTables\ShopProductsDataTable;

/**
 * This class contains methods for managing shops.
 *
 * Currently, it includes only one method which fetches
 * paginated data of the shops from the database & displays
 * it in the specified view file.
 *
 * @author  Aditya Zanjad <adityazanjad474@gmail.com>
 * @version 1.0
 * @access  public
 */
class ShopController extends Controller
{
    /**
     * Return a view that'll display the paginated data of the shops
     * using a datatable
     *
     * @param \App\DataTables\ShopsDataTable $dataTable
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(ShopsDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('shops.index');
    }

    /**
     * Return a view that'll display the paginated data of the products
     * filtered by their shop ID.
     *
     * @param mixed $shopID
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function shopProductsIndex(mixed $shopID): View|JsonResponse
    {
        // Validate '$shopID'
        request()->merge(['shop_id' => $shopID]);

        $validator = validator()->make(request()->all(), [
            'shop_id' => 'required|numeric|integer|exists:shops,id'
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Invalid Shop ID Provided');
            return redirect()->route('shops.index');
        }

        $validated = $validator->validated();  // Get validated form data

        $dataTable = new ShopProductsDataTable($validated['shop_id']);
        return $dataTable->render('shops.products.index');
    }
}
