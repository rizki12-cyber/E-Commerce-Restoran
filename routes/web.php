<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CatalogController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CartController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/menu', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/menu/{product:slug}', [ProductController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| Dashboard Redirector (berdasarkan role)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes (Breeze)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Customer Routes (Butuh Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        
        // Cart Routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Wishlist Routes
        Route::get('/wishlist', [\App\Http\Controllers\Customer\WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/toggle', [\App\Http\Controllers\Customer\WishlistController::class, 'toggle'])->name('wishlist.toggle');


        // Checkout & Order Routes
        Route::get('/checkout', [\App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [\App\Http\Controllers\Customer\CheckoutController::class, 'store'])->name('checkout.store');
        
        Route::get('/orders', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order:order_number}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');

        // Payment Upload
        Route::post('/orders/{order:order_number}/payment', [\App\Http\Controllers\Customer\OrderController::class, 'uploadPayment'])->name('orders.payment.upload');
    
                // Review Routes
        Route::get('/orders/{order:order_number}/review/{order_item}', [\App\Http\Controllers\Customer\ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [\App\Http\Controllers\Customer\ReviewController::class, 'store'])->name('reviews.store');
        
        });

            
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Payment Management
        Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/verify', [\App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('payments.verify');
        Route::post('/payments/{payment}/reject', [\App\Http\Controllers\Admin\PaymentController::class, 'reject'])->name('payments.reject');
     
        // Product Management
        Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

        // Order Management
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order:order_number}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order:order_number}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Review Management
        Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('/reviews/{review}/status', [\App\Http\Controllers\Admin\ReviewController::class, 'updateStatus'])->name('reviews.updateStatus');
        Route::post('/reviews/{review}/reply', [\App\Http\Controllers\Admin\ReviewController::class, 'reply'])->name('reviews.reply');


        // Customer Management
        Route::get('/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{user}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');

        // Reports
        Route::get('/reports/sales', [\App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('reports.sales');

        // Store Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\StoreSettingController::class, 'update'])->name('settings.update');
        
                // CMS Routes
        Route::get('/cms/homepage', [\App\Http\Controllers\Admin\HomepageController::class, 'index'])->name('cms.homepage.index');
        Route::post('/cms/homepage', [\App\Http\Controllers\Admin\HomepageController::class, 'update'])->name('cms.homepage.update');
        
        // FAQ Routes (Eksplisit)
        Route::get('/cms/faqs', [\App\Http\Controllers\Admin\FaqController::class, 'index'])->name('cms.faqs.index');
        Route::post('/cms/faqs', [\App\Http\Controllers\Admin\FaqController::class, 'store'])->name('cms.faqs.store');
        Route::put('/cms/faqs/{faq}', [\App\Http\Controllers\Admin\FaqController::class, 'update'])->name('cms.faqs.update');
        Route::delete('/cms/faqs/{faq}', [\App\Http\Controllers\Admin\FaqController::class, 'destroy'])->name('cms.faqs.destroy');
        
        // Category Management
        Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
        
        // Inventory Management
        Route::get('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
        Route::post('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'store'])->name('inventory.store');
        
        // Variant & Addon Management
        Route::get('/variants', [\App\Http\Controllers\Admin\VariantController::class, 'index'])->name('variants.index');
        Route::post('/variants/product/{product}', [\App\Http\Controllers\Admin\VariantController::class, 'storeVariant'])->name('variants.store');
        Route::put('/variants/{variant}', [\App\Http\Controllers\Admin\VariantController::class, 'updateVariant'])->name('variants.update');
        Route::delete('/variants/{variant}', [\App\Http\Controllers\Admin\VariantController::class, 'destroyVariant'])->name('variants.destroy');
        Route::post('/addons/product/{product}', [\App\Http\Controllers\Admin\VariantController::class, 'storeAddon'])->name('addons.store');
        Route::put('/addons/{addon}', [\App\Http\Controllers\Admin\VariantController::class, 'updateAddon'])->name('addons.update');
        Route::delete('/addons/{addon}', [\App\Http\Controllers\Admin\VariantController::class, 'destroyAddon'])->name('addons.destroy');

        // Voucher Management
        Route::resource('/vouchers', \App\Http\Controllers\Admin\VoucherController::class)->except(['show']);

        // Activity Log
        Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');

        // Gallery Management
        Route::resource('/galleries', \App\Http\Controllers\Admin\GalleryController::class)->except(['show', 'create', 'edit']);
        
        
        });

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';