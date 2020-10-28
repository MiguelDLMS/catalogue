<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller {

   public function Search(Request $request) {

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

      if($request->hasFile('insertImages')) {
         foreach ($files as $file) {
            $upload = true;

            if ($request->has('deleteImages')) {
               $res = response($file->getClientOriginalName(), 200)->header('Content-Type', 'text/plain');

               if (strpos($request->has('deleteImages'), $file->getClientOriginalName())) {
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
      $files = $request->file('insertImages');

      if($request->hasFile('insertImages')) {
         foreach ($files as $file) {
            $file->store('images/', ['disk' => 'products']);
         }

         return response("Images updated", 200)->header('Content-Type', 'text/plain');
      }

      return response("Images not found", 512)->header('Content-Type', 'text/plain');
   }
   public function destroy($id) {
      echo 'destroy';
   }
}