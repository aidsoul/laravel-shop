<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCatalogRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\GalleryImage;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {

    private $imageSaver;
    private $id;
    
    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
    }

    protected function validator(array $data)
    {
        return Validator::make($data,[
            'name'=>['required', 'string', 'max:100'],
            'slug'=>['required', 'string', 'max:100'],
            'price'=>['required', 'int', 'max:100'],
            'content'=>['required', 'html'],
        ]);
    }

    /**
     * Показывает список всех товаров
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if(!Gate::any(['admin','operator','commodity-expert'])){
            return abort(404);
        }
        $roots = Category::where('parent_id', 0)->get();
        $products = Product::paginate(5);
        return view('admin.product.index', compact('products', 'roots'));
    }

    /**
     * Показывает товары категории
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category) {
        if(!Gate::any(['admin','operator','commodity-expert'])){
            return abort(404);
        }
        $products = $category->products()->paginate(5);
        return view('admin.product.category', compact('category', 'products'));
    }

    /**
     * Показывает форму для создания товара
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(!Gate::any(['admin','commodity-expert'])){
            return abort(404);
        }
        // все категории для возможности выбора родителя
        $items = Category::all();
        // все бренды для возмозжности выбора подходящего
        $brands = Brand::all();
        $gallery = '';
        return view('admin.product.create', compact('items', 'brands','gallery'));
    }

    /**
     * Сохраняет новый товар в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCatalogRequest $request) {
        if(!Gate::any(['admin','commodity-expert'])){
            return abort(404);
        }
        $request->merge([
            'new' => $request->has('new'),
            'hit' => $request->has('hit'),
            'sale' => $request->has('sale'),
        ]);
        $data = $request->all();
        $data['slug']  = strtolower($data['slug']);
        if(empty($request->file('images'))){ 
            $product  = Product::create($data);
        }else{
        if(count($request->file('images')) == 1){
            $data['image'] = $this->imageSaver->upload($request,null,'product');
            $product  = Product::create($data);
        }else{
            $data['image'] = $this->imageSaver->upload($request,null,'product');
            $product  = Product::create($data);
            foreach($this->imageSaver->uploads($request,null,'product/gallery') as $v=>$img){
                GalleryImage::create([
                        'id' => $product->id,
                        'url'=>$img
                ]);
            }
        }
    }
        return redirect()
            ->route('admin.product.show', ['product' => $product->id])
            ->with('success', 'Новый товар успешно создан');
    }

    /**
     * Показывает страницу товара
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        if(!Gate::any(['admin','operator','commodity-expert','driver'])){
            return abort(404);
        }
        return view('admin.product.show', compact('product'));
    }

    /**
     * Показывает форму для редактирования товара
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, GalleryImage $gallery) {
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        // все категории для возможности выбора родителя
        $items = Category::all();
        // все бренды для возмозжности выбора подходящего
        $brands = Brand::all();
        $gallery = $gallery->where('id','=',$product->id)->get()->count();
        
        return view('admin.product.edit', compact('product', 'items', 'brands','gallery'));
    }

    /**
     * Обновляет товар каталога в базе данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCatalogRequest $request, Product $product, GalleryImage $gallery  ) {
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $request->merge([
            'new' => $request->has('new'),
            'hit' => $request->has('hit'),
            'sale' => $request->has('sale'),
        ]);
        $data = $request->all();
        $data['slug']  = strtolower($data['slug']);
        if(empty($request->file('images'))){ 
            $product->update($data);
        }else{
            if(count($request->file('images')) == 1){
                $product->update($data);
                if($request->remove){          
                    foreach($gallery->where('id','=',$product->id)->get() as $imgD){
                        $this->imageSaver->removes($imgD->url,'product/gallery');
                        $a =  GalleryImage::where('id','=',$imgD->id);
                        $a->delete();
                    }          
                }    
                $data['image'] = $this->imageSaver->upload($request,$product,'product');    
                $product->update($data);  
        }else{
            if($request->remove){          
                foreach($gallery->where('id','=',$product->id)->get() as $imgD){
                    $this->imageSaver->removes($imgD->url,'product/gallery');
                    $a =  GalleryImage::where('id','=',$imgD->id);
                    $a->delete();
                }          

            }
            foreach($this->imageSaver->uploads($request,null,'product/gallery') as $img){
                $gallery->create([
                        'id' => $product->id,
                        'url'=>$img
                ]);
            }
            $data['image'] = $this->imageSaver->upload($request,$product,'product');
            $product->update($data);
        }
        }


        return redirect()
            ->route('admin.product.show', ['product' => $product->id])
            ->with('success', 'Товар был успешно обновлен');
    }

    /**
     * Удаляет товар каталога из базы данных
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $this->imageSaver->remove($product, 'product');
        $product->delete();
        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Товар каталога успешно удален');
    }
}
