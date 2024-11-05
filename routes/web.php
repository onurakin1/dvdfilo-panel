<?php

use App\Http\Controllers\Frontend\AppointmentRequestController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ExhibitionController;
use App\Http\Controllers\Frontend\LocationController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\SapServiceController;
use App\Http\Controllers\Frontend\SearchController;
use App\Mail\FormMail;
use App\Models\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;


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


Route::get('/', function () {
    return redirect('login');
});


Route::any('/check-status', function () {
    Log::info('checkStatus', ['result' => request()->all()]);
    Artisan::call('replicate:check-status');
    return true;
});

Route::get('test', function () {

    return phpinfo();
    $extensionName = 'imagick'; // Örnek olarak Imagick eklentisi



    $imagick = ImageManager::imagick()->read(public_path('test-10.bmp'));
    $imagick->resolution(100, 100);

    // $core = $imagick->core()->native();
    // $core->setImageInterpolateMethod(Imagick::INTERPOLATE_UNDEFINED);

    $imagick->resize(640, 1150);

    $imagick->reduceColors(8);
    $imagick->toBitmap();
    $imagick->setResolution(48, 100)->save(public_path('OUT' . rand(1, 1000) . '.bmp'));
});

Route::get('test2', function () {

    $image = new Imagick(public_path('test-10.bmp'));

    // İlk olarak, resmi küçült
    $newWidth = 1000; // Yeni genişlik
    $newHeight = 1750; // 0 değeri oranı korur, istediğiniz bir değeri kullanabilirsiniz
    $image->setImageInterpolateMethod(Imagick::INTERPOLATE_BICUBIC);

    $image->resizeImage($newWidth, $newHeight, Imagick::FILTER_TRIANGLE, 1);

    // BMP formatı için sıkıştırma ayarları
    $image->setImageFormat('BMP');
    $image->setImageCompression(Imagick::COMPRESSION_RLE); // Sıkıştırma tipini belirtin
    $image->sharpenImage(2, 1);

    // Yeni resmi kaydet
    $newImagePath = public_path('test-10.bmp') . '_1000x175022.bmp';
    $image->writeImage($newImagePath);

    // Belleği temizle
    $image->clear();
    $image->destroy();
});
