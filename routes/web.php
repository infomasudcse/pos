<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\VariationvalController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\Report;
use App\Http\Controllers\BranchreportController;
use App\Http\Controllers\BranchTransferController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ExpensetypeController;

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
     return view('auth.login');
 });
 
// Route::get('/', function () {
//     return view('one');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');


Route::middleware(['auth','role:admin'])->group(function () {
	  //only admin access 
    Route::get('/dashboard', [Report::class,'home'])->name('dashboard');
    Route::resources([
    'configs' => ConfigController::class,
    'branches' => BranchController::class,
    'employees' => EmployeeController::class,
    'categories' => CategoryController::class,
    'subcategories' => SubcategoryController::class,
    'variations' => VariationController::class,
    'variationvals' => VariationvalController::class,
    'items' => ItemController::class,
    'inventories' => InventoryController::class,
    'expensetype' => ExpensetypeController::class,
    ]);  
    Route::get('/config/changeSystemStatus', [ConfigController::class, 'changeState']);      
    Route::get('/BranchController/getBranch', [BranchController::class,'getBranch']);
    Route::get('/EmployeeController/getEmplopyee',[EmployeeController::class,'getEmplopyee']);
    Route::get('/employee/status/{id}',[EmployeeController::class,'changeEmplopyeeStatus']);
    Route::get('/employee/canTransferMode/{id}',[EmployeeController::class,'changeTranserMode']);

    Route::get('/CategoryController/getCategory', [CategoryController::class,'getCategory']); 
    Route::get('/SubCategoryController/getSubCategory', [SubcategoryController::class,'getSubCategory']); 
    Route::get('/SubCategoryController/getSubCategoryByCatId/{id}', [SubcategoryController::class,'getSubCategoryByCatId']);
    Route::get('/VariationController/getVariation', [VariationController::class,'getVariation']);    
   Route::get('/VariationvalController/getVariationval', [VariationvalController::class,'getVariationval']);
    Route::get('/ItemController/getItems',[ItemController::class,'getItems']);
    Route::get('/ItemController/getSuggestion/{id}',[ItemController::class,'getSuggestion']);
    Route::get('/InventoryController/getInventory',[InventoryController::class,'getInventory']);
    Route::get('/InventoryController/searchSku/{id}',[InventoryController::class,'searchSku']);
    Route::get('/InventoryController/getInventoryById/{id}',[InventoryController::class,'getInventoryById']);
    Route::get('/ExpensetypeController/getExpenseType',[ExpensetypeController::class,'getExpenseType']);
    
    
    

    Route::get('/HelperController/getCSRF',[HelperController::class,'getCSRF']);
    Route::post('/helper/printBarcode',[HelperController::class,'printBarcode']);
    Route::post('/helper/transferTo',[HelperController::class,'transferTo']);
    Route::get('/inventory/massDistribute',[InventoryController::class,'massDistribute']);
    Route::post('/helper/addToAdminTransfer',[HelperController::class,'addToAdminTransfer']);
    Route::post('/helper/setBranchForTransfer',[HelperController::class,'setBranchForTransfer']);
    Route::get('/helper/startOverDistribute',[HelperController::class,'startOverDistribute']);
    Route::post('/helper/startMassDistribute',[HelperController::class,'startMassDistribute']);
    //Report
    Route::get('/report',[Report::class,'index']);
    Route::get('/report/sale/today',[Report::class,'todaySale']);
    Route::post('/report/sale/summary',[Report::class,'saleSummary']);
    Route::post('/report/sale/details',[Report::class,'saleDetails']);
    Route::get('/report/distribute/today',[Report::class,'distributeToday']); 
    Route::post('/report/distribute/history',[Report::class,'distributeHistory']);
    Route::post('/report/presentinventory',[Report::class,'presentInventory']);
    Route::post('/report/todayinventory',[Report::class,'todayInventory']);
    

   
});

Route::middleware(['auth','role:staff'])->group(function () {
    //only staff
    //Branch Sales
    Route::get('/sales',[SaleController::class, 'index'])->name('sale');
    Route::post('/sales/addToCart',[SaleController::class, 'addToCart']);
    Route::get('/sales/removeFromCart/{id}',[SaleController::class, 'removeFromCart']);
    Route::post('/sales/addPayment',[SaleController::class, 'addPayment']);
    Route::get('/sales/deletePayment',[SaleController::class, 'deletePayment']);
    Route::post('/sales/doSale',[SaleController::class, 'doSale']);
    Route::get('/sales/cancelSale',[SaleController::class, 'cancelSale']);  
    Route::post('/sales/addDiscount',[SaleController::class, 'addDiscount']);
    //Branch Report
    Route::get('/branchReport',[BranchreportController::class, 'index'])->name('branch-report');
    Route::get('/branchReport/todayDetails',[BranchreportController::class, 'todayDetails']);
    Route::post('/branchReport/saleDetails',[BranchreportController::class, 'saleDetails']);
    //Branch Transfer
    Route::get('/branchTransfer',[BranchTransferController::class, 'index'])->name('branch-transfer');
    Route::get('/branchTransfer/startOverTransfer',[BranchTransferController::class, 'startOverTransfer']);
    Route::post('/branchTransfer/addToBranchTransfer',[BranchTransferController::class, 'addTo']);
    Route::post('/branchTransfer/startMassTransfer',[BranchTransferController::class, 'startMassTransfer']);

   

});

Route::middleware(['auth'])->group(function () {
    //Only authenticated user
     //sales receipt 
    Route::get('/sales/receipt/{id}',[PreviewController::class, 'saleReceipt']);
    Route::post('/PreviewController/printPad',[PreviewController::class, 'BusinessPad']);


});


require __DIR__.'/auth.php';
