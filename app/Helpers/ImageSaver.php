<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ImageSaver {
    /**
     * Сохраняет изображение при создании или редактировании категории,
     * бренда или товара; создает два уменьшенных изображения.
     *
     * @param \Illuminate\Http\Request $request — объект HTTP-запроса
     * @param \App\Models\Item $item — модель категории, бренда или товара
     * @param string $dir — директория, куда будем сохранять изображение
     * @return string|null — имя файла изображения для сохранения в БД
     */
    public function upload($request, $item, $dir) {

        $name = $item->image ?? null;
        
        if($request->file('images')){
            $source = $request->file('images')[0];
        }else{
            $source = $request->file('image');
        }
        if ($item && $request->remove) { // если надо удалить изображение
            $this->remove($item, $dir);
            $name = null;
        }

        if ($source) { // если было загружено изображение
            // перед загрузкой нового изображения удаляем старое
            if ($item && $item->image) {
                $this->remove($item, $dir);
            }
            $ext = $source->extension();
            // сохраняем загруженное изображение без всяких изменений
            $path = $source->store('catalog/'.$dir.'/source', 'public');
            $path = Storage::disk('public')->path($path); // абсолютный путь
            $name = basename($path); // имя файла
            // создаем уменьшенное изображение 600x300px, качество 100%
            $dst = 'catalog/'.$dir.'/image/';
            $this->resize($path, $dst, 600, 300, $ext);
            // создаем уменьшенное изображение 300x150px, качество 100%
            $dst = 'catalog/'.$dir.'/thumb/';
            $this->resize($path, $dst, 300, 150, $ext);
        }
        return $name;
    }

    public function uploads($request, $item, $dir) {
        $arr = [];
        foreach($request->file('images') as $itm){
            if ($itm) { // если было загружено изображение
                // перед загрузкой нового изображения удаляем старое
                $ext = $itm->extension();
                // сохраняем загруженное изображение без всяких изменений
                $path = $itm->store('catalog/'.$dir.'/source', 'public');
                $path = Storage::disk('public')->path($path); // абсолютный путь
                $arr[] = basename($path); // имя файла
                // создаем уменьшенное изображение 600x300px, качество 100%
                $dst = 'catalog/'.$dir.'/image/';
                $this->resize($path, $dst, 600, 300, $ext);
            }
        }

        return $arr;
    }

    public function removes($url,$dir) {

        Storage::disk('public')->delete('catalog/'.$dir.'/source/' .  $url);
        Storage::disk('public')->delete('catalog/'.$dir.'/image/' .  $url);

        
    }



    /**
     * Создает уменьшенную копию изображения
     *
     * @param string $src — путь к исходному изображению
     * @param string $dst — куда сохранять уменьшенное
     * @param integer $width — ширина в пикселях
     * @param integer $height — высота в пикселях
     * @param string $ext — расширение уменьшенного
     */
    private function resize($src, $dst, $width, $height, $ext) {
        // создаем уменьшенное изображение width x height, качество 100%
        $image = Image::make($src)
            ->heighten($height)
            ->resizeCanvas($width, $height, 'center', false, 'eeeeee')
            ->encode($ext, 100);
        // сохраняем это изображение под тем же именем, что исходное
        $name = basename($src);
        Storage::disk('public')->put($dst . $name, $image);
        $image->destroy();
    }

    /**
     * Удаляет изображение при удалении категории, бренда или товара
     *
     * @param \App\Models\Item $item — модель категории, бренда или товара
     * @param string $dir — директория, в которой находится изображение
     */
    public function remove($item, $dir) {
        $old = $item->image;
        if ($old) {
            Storage::disk('public')->delete('catalog/'.$dir.'/source/' . $old);
            Storage::disk('public')->delete('catalog/'.$dir.'/image/' . $old);
            Storage::disk('public')->delete('catalog/'.$dir.'/thumb/' . $old);
        }
    }
}
