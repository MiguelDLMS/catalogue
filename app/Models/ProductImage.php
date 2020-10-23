<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $FK_Product
 * @property int $FK_Image
 */
class ProductImage extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'PRODUCTS_IMAGES';

    /**
     * @var array
     */
    protected $fillable = ['FK_Product', 'FK_Image'];

}
