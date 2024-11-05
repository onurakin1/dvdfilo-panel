<?php


use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FileController;
use App\Http\Controllers\Backend\GroupController;
use App\Http\Controllers\Backend\LogController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ProjectController;
use App\Http\Controllers\Backend\ContentsController;
use App\Http\Controllers\Backend\InstitutionalController;
use App\Http\Controllers\Backend\ContractsController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\BrandsController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "backend" middleware group. Now create something great!
|
*/


// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


// Users
Route::resource('users', UserController::class);

// Profile
Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('profiles/account-update', [ProfileController::class, 'accountUpdate'])->name('profile.account.update');
Route::put('profiles/password-change', [ProfileController::class, 'passwordChange'])->name('profile.account.password.change');


// Projects
Route::get('projects/', [ProjectController::class, 'index'])->name('projects');
Route::get('projects/{id}', [ProjectController::class, 'index'])->name('projects.id');
Route::post('projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('projects/{id}/update', [ProjectController::class, 'update'])->name('projects.update');
Route::get('/project-transactions', [ProjectController::class, 'transactions'])->name('projects.transactions');
Route::post('/project-download', [ProjectController::class, 'download'])->name('projects.download');


//Brands 

Route::get('/getOffers', [BrandsController::class, 'getOffers'])->name('getOffers');
Route::get('/brands', [BrandsController::class, 'brands'])->name('brands');
Route::get('/car-models', [BrandsController::class, 'carModels'])->name('carModels');
Route::post('brands/create', [BrandsController::class, 'createBrands'])->name('brands.create');
Route::get('/get-model', [BrandsController::class, 'getModelWithBrand'])->name('model.get');
Route::get('/get-brands', [BrandsController::class, 'getBrandsWithType'])->name('brand.get');
Route::get('/get-brand-model', [BrandsController::class, 'getBrandsModel'])->name('brand.model.get');
Route::post('projects/{id}/update', [BrandsController::class, 'update'])->name('models.update');
Route::delete('projects/{id}/delete', [BrandsController::class, 'modelDelete'])->name('models.delete');
Route::post('models/create', [BrandsController::class, 'createModels'])->name('models.create');

//Contents
Route::get('/contents', [ContentsController::class, 'contents'])->name('contents');
Route::post('contents/create', [ContentsController::class, 'create'])->name('contents.create');
Route::match(['put', 'post'], 'contents/{id}/update', [ContentsController::class, 'update'])->name('contents.update');
Route::delete('contents/{id}/delete', [ContentsController::class, 'deleteMainImage'])->name('contents.delete');
Route::delete('contents/{id}/refdelete', [ContentsController::class, 'deleteRefImage'])->name('contents.refdelete');

Route::get('/institutional', [InstitutionalController::class, 'contents'])->name('institutional');
Route::post('institutional/create', [InstitutionalController::class, 'create'])->name('institutional.create');
Route::match(['put', 'post'], 'institutional/{id}/update', [InstitutionalController::class, 'update'])->name('institutional.update');


Route::get('/contract', [ContractsController::class, 'contents'])->name('contract');
Route::post('contract/create', [ContractsController::class, 'create'])->name('contract.create');
Route::match(['put', 'post'], 'contract/{id}/update', [ContractsController::class, 'update'])->name('contract.update');

