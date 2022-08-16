<?php

namespace App\Http\Controllers;

use App\Helpers\ProductFilter;
use App\Helpers\UserAmount;
use App\Models\Brand;
use App\Models\Category;
use App\Models\GalleryImage;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class CatalogController extends Controller {
    public function index() {
        $roots = Category::where('parent_id', 0)->get();
        $brands = Brand::popular();
        return view('catalog.index', compact('roots', 'brands'));
    }

    public function category(Category $category, ProductFilter $filters) {
        $products = Product::categoryProducts($category->id)
            ->filterProducts($filters)
            ->paginate(6)
            ->withQueryString();
        return view('catalog.category', compact('category', 'products'));
    }

    public function brand(Brand $brand, ProductFilter $filters) {
        $products = $brand
            ->products() // возвращает построитель запроса
            ->filterProducts($filters)
            ->paginate(6)
            ->withQueryString();
        return view('catalog.brand', compact('brand', 'products'));
    }

    public function product(Product $product,ProductComment $comment, GalleryImage $gallery)
    {  $discount = 0;
        if(auth()->user()){
                $order = Order::getAllWhereUser(
                    auth()
                    ->user()
                    ->id);
                $userAmount = UserAmount::set();
                $userAmount->getAll($order);
                $discount = $userAmount->getDiscount();
                return view('catalog.product', compact('product','comment','gallery','userAmount','discount'));
        }else{
            return view('catalog.product', compact('product','comment','gallery','discount'));
        }
    }

    public function search(Request $request) {
        $search = $request->input('query');
        $query = Product::search($search);
        $products = $query->paginate(6)->withQueryString();
        return view('catalog.search', compact('products', 'search'));

        // $search = $request->query('query');
        // $query = Product::where('name','LIKE',"%{$search}%");
        // $products = $query->paginate(6);

        // return view('catalog.search', compact('products', 'search'));

    }
}
