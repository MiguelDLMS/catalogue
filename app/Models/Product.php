<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID_Product
 * @property string $Name
 * @property string $Description
 * @property string $Technical_Specifications
 * @property float $Latitude
 * @property float $Longitude
 * @property boolean $Visible
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
    protected $fillable = ['Name', 'Description', 'Technical_Specifications', 'Latitude', 'Longitude', 'Visible'];

}
