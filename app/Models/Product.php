<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID_Product
 * @property string $Name
 * @property string $Description
 * @property string $Technical_Specifications
 * @property string $Country_Code
 * @property boolean $Visible
 * @property CATEGORY[] $cATEGORIEs
 * @property IMAGE[] $iMAGEs
 */
class Product extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'PRODUCTS';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID_Product';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['Name', 'Description', 'Technical_Specifications', 'Country_Code', 'Visible'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cATEGORIEs()
    {
        return $this->belongsToMany('App\CATEGORY', 'PRODUCTS_CATEGORIES', 'FK_Product', 'FK_Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function iMAGEs()
    {
        return $this->belongsToMany('App\IMAGE', 'PRODUCTS_IMAGES', 'FK_Product', 'FK_Image');
    }
}
