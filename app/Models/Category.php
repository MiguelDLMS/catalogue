<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID_Category
 * @property string $Name
 * @property string $Description
 */
class Category extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'CATEGORIES';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID_Category';

    /**
     * @var array
     */
    protected $fillable = ['Name', 'Description'];

}
