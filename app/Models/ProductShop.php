<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductShop extends Model
{
    use HasFactory;

    /**
     * Explicitly specify the name of the database table
     *
     * @var string $table
     */
    protected $table = 'product_shop';
}
