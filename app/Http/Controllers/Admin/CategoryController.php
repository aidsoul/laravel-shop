<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCatalogRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller {

    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
    }

    /**
     * Показывает список всех категорий
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index() {
        if(!Gate::any(['admin','commodity-expert','operator'])){
            return abort(404);
        }
        $items = Category::paginate(35);
        return view('admin.category.index', compact('items'));
    }

    /**
     * Показывает форму для создания категории
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(!Gate::any(['admin','commodity-expert'])){
            return abort(404);
        }
        $items = Category::all();
        return view('admin.category.create', compact('items'));
    }

    /**
     * Сохраняет новую категорию в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCatalogRequest $request) {
        if(!Gate::any(['admin','commodity-expert'])){
            return abort(404);
        }
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, null, 'category');
        $data['slug']  = strtolower($data['slug']);
        $category = Category::create($data);
        return redirect()
            ->route('admin.category.show', ['category' => $category->id])
            ->with('success', 'Новая категория успешно создана');
    }

    /**
     * Показывает страницу категории
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category) {
        if(!Gate::any(['admin','commodity-expert','operator'])){
            return abort(404);
        }
        return view('admin.category.show', compact('category'));
    }

    /**
     * Показывает форму для редактирования категории
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category) {
        // все категории для возможности выбора родителя
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $items = Category::all();
        return view('admin.category.edit',compact('category', 'items'));
    }

    /**
     * Обновляет категорию каталога
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryCatalogRequest $request, Category $category) {
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, $category, 'category');
        $data['slug']  = strtolower($data['slug']);
        $category->update($data);
        return redirect()
            ->route('admin.category.show', ['category' => $category->id])
            ->with('success', 'Категория была успешно исправлена');
    }

    /**
     * Удаляет категорию каталога
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) {
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        if ($category->children->count()) {
            $errors[] = 'Нельзя удалить категорию с дочерними категориями';
        }
        if ($category->products->count()) {
            $errors[] = 'Нельзя удалить категорию, которая содержит товары';
        }
        if (!empty($errors)) {
            return back()->withErrors($errors);
        }
        $this->imageSaver->remove($category, 'category');
        $category->delete();
        return redirect()
            ->route('admin.category.index')
            ->with('success', 'Категория каталога успешно удалена');
    }
}
