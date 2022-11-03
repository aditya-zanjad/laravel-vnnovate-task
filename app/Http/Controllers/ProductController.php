<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;

/**
 * This class contains methods for managing the products.
 *
 * The methods perform tasks that include getting a paginated
 * list of products from the database.
 *
 * @author  Aditya Zanjad <adityazanjad474@gmail.com>
 * @version 1.0
 * @access  public
 */
class ProductController extends Controller
{
    /**
     * To decide the number of records per page of the datatable
     *
     * @var int RECORDS_PER_PAGE
     */
    protected const RECORDS_PER_PAGE = [10, 15, 20, 25, 30, 40, 45, 50];

    /**
     * Get a paginated list of all the users.
     *
     * @param \App\DataTables\ProductsDataTable $dataTable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProductsDataTable $dataTable)
    {
        return $dataTable->render('products.index');
    }
}
