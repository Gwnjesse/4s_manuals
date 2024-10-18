<?php

use Illuminate\Support\Facades\Route;

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

/*
2017-10-30 setup for urls
Home:			/
Brand:			/52/AEG/
Type:			/52/AEG/53/Superdeluxe/
Manual:			/52/AEG/53/Superdeluxe/8023/manual/
				/52/AEG/456/Testhandle/8023/manual/

If we want to add product categories later:
Productcat:		/category/12/Computers/
*/

use App\Models\Brand;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\LocaleController;

// Homepage
Route::get('/', function () {
    // Fetch brands sorted by name
    $brands = Brand::all()->sortBy('name');

    // Fetch top 10 manuals sorted by 'clicks' in descending order
    $topManuals = \App\Models\Manual::orderBy('clicks', 'desc')->limit(10)->get();

    // Pass both 'brands' and 'topManuals' to the homepage view
    return view('pages.homepage', compact('brands', 'topManuals'));
})->name('home');


// Route voor het doorverwijzen naar de manual met het verhogen van clicks

Route::get('/manual/{id}/redirect', [ManualController::class, 'redirectToManual'])->name('manual.redirect');

//Contact pagina

Route::get('/pages/contact', [ContactController::class, 'show']);


Route::get('/manual/{language}/{brand_slug}/', [RedirectController::class, 'brand']);
Route::get('/manual/{language}/{brand_slug}/brand.html', [RedirectController::class, 'brand']);

Route::get('/datafeeds/{brand_slug}.xml', [RedirectController::class, 'datafeed']);

// Locale routes
Route::get('/language/{language_slug}/', [LocaleController::class, 'changeLocale']);

Route::get('/{brand_id}/{brand_slug}/', [ManualController::class, 'show'])->name('brand.show');


Route::get('/manual/{id}/download', [BrandController::class, 'downloadManual'])->name('manual.download');
// List of manuals for a brand
Route::get('/{brand_id}/{brand_slug}/', [BrandController::class, 'show']);

// Detail page for a manual
Route::get('/{brand_id}/{brand_slug}/{manual_id}/', [ManualController::class, 'show']);

// Generate sitemaps
Route::get('/generateSitemap/', [SitemapController::class, 'generate']);
