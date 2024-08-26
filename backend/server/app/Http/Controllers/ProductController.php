<?php

namespace App\Http\Controllers;
use App\Services\FirebaseService;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function readDatabase()
    {
        $database = $this->firebaseService->getDatabase();
        $blog = $database->getReference('products');

        echo '<pre>';
        print_r($blog->getValue());
        echo '</pre>';
    }
 
    public function searchByCategory(Request $request)
    {
        $category = $request->query('category');

        if (!$category) {
            return response()->json(['error' => 'Category is required'], 400);
        }

         // Firebase'de ürünlerin saklandığı yolu belirtelim
         $database = $this->firebaseService->getDatabase();
         $productsRef = $database->getReference('products');
 
         // Kategorilere göre filtreleme yapalım
         $products = $productsRef->orderByChild('category')->equalTo($category)->getValue();
 
         if (empty($products)) {
             return response()->json(['message' => 'No products found for this category'], 404);
         }
 
         return response()->json($products, 200);
    }
}
