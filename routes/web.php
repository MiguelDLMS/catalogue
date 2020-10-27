<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --------------------------------------------------------------------------
// Public

Route::get('/', function () {
    $products = DB::table('PRODUCTS')
        ->select('ID_Product', 'Name', 'Description')
        ->where('Visible', 1)
        ->get();

    $products = json_decode($products, true);

    for ($i=0; $i < count($products); $i++) { 
        $images = DB::table('IMAGES')
            ->join('PRODUCTS_IMAGES', 'PRODUCTS_IMAGES.FK_Image', '=', 'IMAGES.ID_Image')
            ->join('PRODUCTS', 'PRODUCTS.ID_Product', '=', 'PRODUCTS_IMAGES.FK_Product')
            ->select('IMAGES.Name')
            ->where('PRODUCTS.ID_Product', $products[$i]['ID_Product'])
            ->get();

        $products[$i]['Images'] = json_decode($images, true);
    }

    return view('public.index', [ 
        'products' => $products
     ]);
});

Route::get('product/{id}', function ($id) {
    $product = DB::table('PRODUCTS')
        ->select('ID_Product', 'Name', 'Description', 'Technical_Specifications', 'Latitude', 'Longitude')
        ->where('ID_Product', $id)
        ->where('Visible', 1)
        ->first();

    $product = json_decode(json_encode($product), true);

    $images = DB::table('IMAGES')
        ->join('PRODUCTS_IMAGES', 'PRODUCTS_IMAGES.FK_Image', '=', 'IMAGES.ID_Image')
        ->join('PRODUCTS', 'PRODUCTS.ID_Product', '=', 'PRODUCTS_IMAGES.FK_Product')
        ->select('IMAGES.Name')
        ->where('PRODUCTS.ID_Product', $id)
        ->get();
    
    $product['Images'] = json_decode($images, true);

    $suggestedProducts = DB::table('PRODUCTS')
        ->select('ID_Product', 'Name', 'Description')
        ->where('Visible', 1)
        ->limit(3)
        ->get();

    $suggestedProducts = json_decode($suggestedProducts, true);

    for ($i=0; $i < count($suggestedProducts); $i++) { 
        $images = DB::table('IMAGES')
            ->join('PRODUCTS_IMAGES', 'PRODUCTS_IMAGES.FK_Image', '=', 'IMAGES.ID_Image')
            ->join('PRODUCTS', 'PRODUCTS.ID_Product', '=', 'PRODUCTS_IMAGES.FK_Product')
            ->select('IMAGES.Name')
            ->where('PRODUCTS.ID_Product', $suggestedProducts[$i]['ID_Product'])
            ->get();

        $suggestedProducts[$i]['Images'] = json_decode($images, true);
    }

    return view('public.product', [ 
        'product' => $product,
        'suggestedProducts' => $suggestedProducts
     ]);
});

Route::get('category/{name}', function ($name) {
    $category = DB::table('CATEGORIES')
        ->select('ID_Category', 'Name', 'Description')
        ->where('Name', $name)
        ->first();

    $products = DB::table('PRODUCTS')
        ->join('PRODUCTS_CATEGORIES', 'PRODUCTS_CATEGORIES.FK_Product', '=', 'PRODUCTS.ID_Product')
        ->select('PRODUCTS.ID_Product', 'PRODUCTS.Name', 'PRODUCTS.Description')
        ->where('PRODUCTS_CATEGORIES.FK_Category', $category->ID_Category)
        ->get();

    $products = json_decode($products, true);

    for ($i=0; $i < count($products); $i++) { 
        $images = DB::table('IMAGES')
            ->join('PRODUCTS_IMAGES', 'PRODUCTS_IMAGES.FK_Image', '=', 'IMAGES.ID_Image')
            ->join('PRODUCTS', 'PRODUCTS.ID_Product', '=', 'PRODUCTS_IMAGES.FK_Product')
            ->select('IMAGES.Name')
            ->where('PRODUCTS.ID_Product', $products[$i]['ID_Product'])
            ->get();

        $products[$i]['Images'] = json_decode($images, true);
    }

    return view('public.category', [ 
        'category' => $name,
        'products' => $products
     ]);
});

// --------------------------------------------------------------------------
// Admin

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('product/{id}/edit', function ($id) {
    $product = DB::table('PRODUCTS')
        ->select('ID_Product', 'Name', 'Description', 'Technical_Specifications', 'Latitude', 'Longitude')
        ->where('ID_Product', $id)
        ->where('Visible', 1)
        ->first();

    $product = json_decode(json_encode($product), true);

    $images = DB::table('IMAGES')
        ->join('PRODUCTS_IMAGES', 'PRODUCTS_IMAGES.FK_Image', '=', 'IMAGES.ID_Image')
        ->join('PRODUCTS', 'PRODUCTS.ID_Product', '=', 'PRODUCTS_IMAGES.FK_Product')
        ->select('IMAGES.Name')
        ->where('PRODUCTS.ID_Product', $id)
        ->get();
    
    $product['Images'] = json_decode($images, true);

    $suggestedProducts = DB::table('PRODUCTS')
        ->select('ID_Product', 'Name', 'Description')
        ->where('Visible', 1)
        ->limit(3)
        ->get();

    $suggestedProducts = json_decode($suggestedProducts, true);

    for ($i=0; $i < count($suggestedProducts); $i++) { 
        $images = DB::table('IMAGES')
            ->join('PRODUCTS_IMAGES', 'PRODUCTS_IMAGES.FK_Image', '=', 'IMAGES.ID_Image')
            ->join('PRODUCTS', 'PRODUCTS.ID_Product', '=', 'PRODUCTS_IMAGES.FK_Product')
            ->select('IMAGES.Name')
            ->where('PRODUCTS.ID_Product', $suggestedProducts[$i]['ID_Product'])
            ->get();

        $suggestedProducts[$i]['Images'] = json_decode($images, true);
    }

    return view('edit.product', [ 
        'product' => $product,
        'suggestedProducts' => $suggestedProducts
     ]);
});

// --------------------------------------------------------------------------
// Forms

Route::post('/search', [
    'uses' => 'App\Http\Controllers\SearchProductFormController@Search',
    'as' => 'search.product'
]);

Route::post('/request-quote', [
    'uses' => 'App\Http\Controllers\QuoteRequestFormController@Request',
    'as' => 'request.quote'
]);

Route::post('/update-product-images', [
    'uses' => 'App\Http\Controllers\F@update',
    'as' => 'update.product.images'
]);
