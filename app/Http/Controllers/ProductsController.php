<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller {

   public function Search(Request $request) {

      // Form validation
      $this->validate($request, [
          'search' => 'required'
      ]);

      $my_query = "SELECT 
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

      $products = DB::select($my_query, array($request['search'], $request['search'], $request['search'], $request['search']));

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