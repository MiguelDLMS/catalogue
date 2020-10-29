<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller {

   /**
    * Returns a product.
    */
    public function getProduct($productID) {
      $product = DB::table('PRODUCTS')
         ->select('ID_Product', 'Name', 'Description', 'Technical_Specifications', 'Country_Code', 'Visible')
         ->where('ID_Product', $id)
         ->first();

      return $product;
    }

    public function request(Request $request, $id) {

      // Form validation
      $this->validate($request, [
          'name' => 'required',
          'last-name' => 'required',
          'email' => 'required',
          'message' => 'required',
          'product-name' => 'required',
          'product-url' => 'required'
      ]);
  }

   public function search(Request $request) {

      // Form validation
      $this->validate($request, [
          'search' => 'required'
      ]);

      $query = "SELECT 
              ID_Product, 
              Name, 
              Description, 
              MATCH (Name) AGAINST (?) AS Name_Relevance, 
              MATCH (Description) AGAINST (?) AS Description_Relevance 
          FROM PRODUCTS 
          WHERE 
              MATCH (Name) AGAINST (?) 
              OR MATCH (Description) AGAINST (?) 
          ORDER BY 
              Name_Relevance DESC, 
              Description_Relevance DESC";

      $products = DB::select($query, array($request['search'], $request['search'], $request['search'], $request['search']));

      $products = json_decode(json_encode($products), true);

      for ($i=0; $i < count($products); $i++) { 
          $images = DB::table('IMAGES')
              ->join('PRODUCTS_IMAGES', 'PRODUCTS_IMAGES.FK_Image', '=', 'IMAGES.ID_Image')
              ->join('PRODUCTS', 'PRODUCTS.ID_Product', '=', 'PRODUCTS_IMAGES.FK_Product')
              ->select('IMAGES.Name')
              ->where('PRODUCTS.ID_Product', $products[$i]['ID_Product'])
              ->get();

          $products[$i]['Images'] = json_decode($images, true);
      }

      return view('search-results', [
          'search' => $request['search'],
          'products' => $products
      ]);
  }

   /**
    * Returns all images of a product.
    */
    public function getProductImages($productID) {
      $images = DB::table('IMAGES')
         ->join('PRODUCTS_IMAGES', 'PRODUCTS_IMAGES.FK_Image', '=', 'IMAGES.ID_Image')
         ->join('PRODUCTS', 'PRODUCTS.ID_Product', '=', 'PRODUCTS_IMAGES.FK_Product')
         ->select('IMAGES.ID_Image', 'IMAGES.Name')
         ->where('PRODUCTS.ID_Product', $productID)
         ->get();

      return $images;
    }

   public function index() {
      echo 'index';
   }
   public function create() {
      echo 'create';
   }
   public function store(Request $request) {
      echo 'store';
   }
   public function show($id) {
      echo 'show';
   }
   public function edit($id) {
      echo 'edit';
   }

   public function updateImages(Request $request, $id) {
      $res = NULL;
      $files = $request->file('insertImages');

      return response($request->input('insertImages'), 200)->header('Content-Type', 'text/plain');

      if($request->hasFile('insertImages')) {
         foreach ($files as $file) {
            $upload = true;

            if ($request->has('deleteImages')) {
               if (strpos($request->input('deleteImages'), $file->getClientOriginalName()) !== true) {
                  $upload = false;
               }
            }

            if ($upload) {
               $storagePath = $file->store('images/', ['disk' => 'products']);

               $imageID = DB::table('IMAGES')->insertGetId(array(
                  'Name' => basename($storagePath)
               ));
   
               DB::table('PRODUCTS_IMAGES')->insert(array(
                  'FK_Product' => $id,
                  'FK_Image' => $imageID
               ));
            }
         }

         $res = response("Images updated", 200)->header('Content-Type', 'text/plain');
      }

      if ($request->has('deleteImages')) {
         $imageNames = explode(';', $request->input('deleteImages'));

         foreach ($imageNames as $imageName) {
            DB::table('IMAGES')
               ->where('IMAGES.Name', $imageName)
               ->delete();

               Storage::disk('products')->delete('images/' . $imageName);
         }

         $res = response("Images updated", 200)->header('Content-Type', 'text/plain');
      }

      if (!isset($res)) {
         $res = response("Images not found", 512)->header('Content-Type', 'text/plain');
      }

      return $res;
   }

   public function update(Request $request, $id) {
      try {
         DB::table('PRODUCTS')
            ->where('PRODUCTS.ID_Product', $id)
            ->update(array(
               'Name' => $request->input('name'),
               'Description' => $request->input('description'),
               'Technical_Specifications' => $request->input('specifications'),
               'Country_Code' => $request->input('country'),
               'Visible' => $request->input('visible'),
            ));

         return response("Product updated", 200)->header('Content-Type', 'text/plain');
      } catch (Exception $e) {
         return response("Producto not updated: " . $e->getMessage(), 512)->header('Content-Type', 'text/plain');
      }
   }
   public function delete($id) {
      DB::table('PRODUCTS_CATEGORIES')
         ->where('PRODUCTS_CATEGORIES.FK_Product', $id)
         ->delete();

      $images = DB::table('IMAGES')
         ->join('PRODUCTS_IMAGES', 'PRODUCTS_IMAGES.FK_Image', '=', 'IMAGES.ID_Image')
         ->join('PRODUCTS', 'PRODUCTS.ID_Product', '=', 'PRODUCTS_IMAGES.FK_Product')
         ->select('IMAGES.ID_Image', 'IMAGES.Name')
         ->where('PRODUCTS.ID_Product', $id)
         ->get();
   
      $images = json_decode($images, true);

      foreach ($images as $image) {
         DB::table('IMAGES')
            ->where('IMAGES.ID_Image', $image["ID_Image"])
            ->delete();

            Storage::disk('products')->delete('images/' . $image["Name"]);
      }

      $deleted = DB::table('PRODUCTS')
         ->where('PRODUCTS.ID_Product', $id)
         ->delete();

      if ($deleted) {
         $res = response("Product deleted", 200)->header('Content-Type', 'text/plain');
      }

      if (!isset($res)) {
         $res = response("Product not deleted", 512)->header('Content-Type', 'text/plain');
      }

      return $res;
   }
}