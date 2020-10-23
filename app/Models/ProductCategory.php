<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $FK_Product
 * @property int $FK_Category
 */
class ProductCategory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'PRODUCTS_CATEGORIES';

    /**
     * @var array
     */
    protected $fillable = ['FK_Product', 'FK_Category'];

}
