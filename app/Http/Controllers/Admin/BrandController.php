<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandCatalogRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\Gate;

class BrandController extends Controller {

    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
    }

    /**
     * Показывает список всех брендов
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if(!Gate::any(['admin','commodity-expert','operator'])){
            return abort(404);
        }
        $brands = Brand::paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Показывает форму для создания бренда
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(!Gate::any(['admin','commodity-expert'])){
            return abort(404);
        }
        return view('admin.brand.create');
    }

    /**
     * Сохраняет новый бренд в базу данных
     *
     * @param BrandCatalogRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandCatalogRequest $request) {
        if(!Gate::any(['admin','commodity-expert'])){
            return abort(404);
        }
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, null, 'brand');
        $data['slug']  = strtolower($data['slug']);
        $brand = Brand::create($data);
        return redirect()
            ->route('admin.brand.show', ['brand' => $brand->id])
            ->with('success', 'Новый бренд успешно создан');
    }

    /**
     * Показывает страницу бренда
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand) {
        if(!Gate::any(['admin','commodity-expert','operator'])){
            return abort(404);
        }
        return view('admin.brand.show', compact('brand'));
    }

    /**
     * Показывает форму для редактирования бренда
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand) {
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        return view('admin.brand.edit',compact('brand'));
    }

    /**
     * Обновляет бренд (запись в таблице БД)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandCatalogRequest $request, Brand $brand) {
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, $brand, 'brand');
        $data['slug']  = strtolower($data['slug']);
        $brand->update($data);
        return redirect()
            ->route('admin.brand.show', ['brand' => $brand->id])
            ->with('success', 'Бренд был успешно отредактирован');
    }

    /**
     * Удаляет бренд (запись в таблице БД)
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand) {
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        Gate::any(['admin','operator']);
        if ($brand->products->count()) {
            return back()->withErrors('Нельзя удалить бренд, у которого есть товары');
        }
        $this->imageSaver->remove($brand, 'brend');
        $brand->delete();
        return redirect()
            ->route('admin.brand.index')
            ->with('success', 'Бренд каталога успешно удален');
    }
}
