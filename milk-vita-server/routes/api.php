<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\RawMaterial\{MaterialPurchaseController, MaterialUseController};
use App\Http\Controllers\Api\Report\{MilkStandardizationController, MilkProductionStatement, DistributorReport};
//
use App\Http\Controllers\Api\ChillingPlant\{
    ChallanController as ChillingPlantChallanController, 
    ChillingPlantReportController
};
//
use App\Http\Controllers\Api\ProcessingPlant\{ 
    ChallanController as ProcessingPlantChallanController, 
    BulkController, DriverController, StockController, StockTransferController,
};
//
use App\Http\Controllers\Api\HeadOffice\{
    BankForwardingApplicationController,
    DistributorDemandController as HeadOfficeDistributorDemandController,
    DistributorChallanController as HeadOfficeDistributorChallanController
};
//
use App\Http\Controllers\Api\Product\{
    CategoryController, UnitController as ProductUnitController, 
    ProductController, ProductPriceController, FinishProductController
};
//
use App\Http\Controllers\Api\{
    ZoneController, ShopController, AreaController, DistributorController, 
    ShopOrderController, DistributorDemandController, DistributorShopMapController,
    TransferMilkToColdRoomController, FormulaEstimateController, OfficeController, 
    RoleController, VehicleCategoryController, VehicleController, DesignationController, 
    TestController, TestResultController, DepartmentController, ActionMenuController, 
    MeetingResolutionController, NotificationController, LocationController, RoadTypeController, 
    PrivilegeController, MilkCategoryController, ChillingPlantController, ProcessingPlantController,
    MenuController, EntityController, SurveyController, DashboardController,TaskScheduleController
};
//
use App\Http\Controllers\Api\UserAccess\UserController;
use App\Http\Controllers\Api\Association\{
    MemberController, ChallanController, AssociationController, MilkCollectionController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->group(function ()
{
    Route::group(['prefix'=>'task-schedule'], function(){
        Route::post('list', [TaskScheduleController::class, 'index']);
        Route::post('view/{id}', [TaskScheduleController::class, 'view']);
        Route::post('store', [TaskScheduleController::class, 'store']);
        Route::post('update/{id}', [TaskScheduleController::class, 'update']);
        Route::post('done/{id}', [TaskScheduleController::class, 'done']);
    });

    //
    Route::group(['prefix'=>'stock-transfer'], function(){
        //
        Route::group(['prefix'=>'milk-send'], function(){
            Route::post('list', [StockTransferController::class, 'milkTransactionList']);
            Route::post('store', [StockTransferController::class, 'storeMilkTransaction']);
            Route::post('update/{id?}', [StockTransferController::class, 'updateMilkTransaction']);
            Route::post('details/{id?}', [StockTransferController::class, 'milkStockDetails']);
        });

        //
        Route::group(['prefix'=>'finish-product'], function(){
            Route::post('list', [StockTransferController::class, 'productTransactionList']);
            Route::post('store', [StockTransferController::class, 'storeProductTransaction']);
            Route::post('update/{id?}', [StockTransferController::class, 'updateProductTransaction']);
            Route::post('details/{id?}', [StockTransferController::class, 'productStockDetails']);
            //
            Route::post('receive-list', [StockTransferController::class, 'productTransactionReceiveList']);
            Route::post('receive-confirm/{id?}', [StockTransferController::class, 'productTransactionReceiveConfirm']);
        });
    });
    //
    Route::group(['prefix'=>'stock-transfer'], function(){
        //
        Route::group(['prefix'=>'milk-receive'], function(){
            Route::post('list', [StockTransferController::class, 'milkTransactionReceiveList']);
            Route::post('confirm/{id?}', [StockTransferController::class, 'milkTransactionReceiveConfirm']);
        });
    });

    //
    Route::group(['prefix'=>'report'], function(){
        // STANDARDIZATION
        Route::group(['prefix'=>'milk-standardization'], function(){
            Route::post('list', [MilkStandardizationController::class, 'list']);
        });

        // TRANSFER MILK TO COLD ROOM
        Route::group(['prefix'=>'transfer-milk-to-cold-room'], function(){
            Route::post('list', [TransferMilkToColdRoomController::class, 'list']);
            Route::post('store', [TransferMilkToColdRoomController::class, 'store']);
            Route::post('update/{transfer_id}', [TransferMilkToColdRoomController::class, 'update']);
            Route::post('destroy/{transfer_id}', [TransferMilkToColdRoomController::class, 'destroy']);
            Route::post('details/{transfer_id}', [TransferMilkToColdRoomController::class, 'details']);
        });

        // FORMULA ESTIMATE
        Route::group(['prefix'=>'formula-estimate'], function(){
            Route::post('list', [FormulaEstimateController::class, 'list']);
            Route::post('store', [FormulaEstimateController::class, 'store']);
            Route::post('update/{transfer_id}', [FormulaEstimateController::class, 'update']);
            Route::post('destroy/{transfer_id}', [FormulaEstimateController::class, 'destroy']);
            Route::post('details/{transfer_id}', [FormulaEstimateController::class, 'details']);
        });

        // DISTRIBUTOR REPORTS 
        Route::group(['prefix'=>'distributor'], function(){
            Route::post('challan', [DistributorReport::class, 'challan']);
        });

        //
        Route::post('milk-production-statement', [MilkProductionStatement::class, 'record']);
        Route::post('milk-production-closing', [MilkProductionStatement::class, 'closingBalance']);
    });

    // APPLICATION MODULE
    Route::group(['prefix'=>'application'], function(){
        Route::post('/list', [ApplicationController::class, 'list']);
        Route::post('/view/{app_id?}', [ApplicationController::class, 'view']);
        Route::post('/set-status/{app_id?}', [ApplicationController::class, 'setStatus']);
    });

    // OFFICE MODULE
    Route::group(['prefix'=>'office'], function()
    {
        Route::post('synchronize', [OfficeController::class, 'synchronize']);
    });
    // DISTRIBUTOR MODULE
    Route::group(['prefix'=>'distributor'], function()
    {
        Route::post('challan/receive/{id}', [DistributorDemandController::class, 'challanReceive']);
        //
        Route::group(['prefix'=>'demand'], function()
        {
            Route::post('list', [DistributorDemandController::class, 'list']);
            Route::post('store', [DistributorDemandController::class, 'store']);
            Route::post('update/{demand_id}', [DistributorDemandController::class, 'update']);
            Route::post('destroy/{demand_id}', [DistributorDemandController::class, 'destroy']);
            Route::post('details/{demand_id}', [DistributorDemandController::class, 'details']);
            Route::post('tag', [DistributorDemandController::class, 'tag']);
        });
        //
        Route::group(['prefix'=>''], function(){
            Route::post('store/{distributor_id}', [DistributorShopMapController::class, 'store']);
            Route::post('data/{distributor_id}', [DistributorShopMapController::class, 'mapData']);
        });
        //
        Route::post('list', [DistributorController::class, 'list']);
        Route::post('store', [DistributorController::class, 'store']);
        Route::post('update/{zone_id}', [DistributorController::class, 'update']);
        Route::post('destroy/{zone_id}', [DistributorController::class, 'destroy']);
        //
    });

    // AREA MODULE
    Route::group(['prefix'=>'area'], function(){
        Route::post('list', [AreaController::class, 'list']);
        Route::post('store', [AreaController::class, 'store']);
        Route::post('update/{zone_id}', [AreaController::class, 'update']);
        Route::post('destroy/{zone_id}', [AreaController::class, 'destroy']);
    });

    // SHOP MODULE
    Route::group(['prefix'=>'shop'], function()
    {
        // SHOP ORDER MODULE
        Route::group(['prefix'=>'order'], function()
        {
            Route::post('list', [ShopOrderController::class, 'list']);
            Route::post('store', [ShopOrderController::class, 'store']);
            Route::post('update/{order_id}', [ShopOrderController::class, 'update']);
            Route::post('destroy/{order_id}', [ShopOrderController::class, 'destroy']);
            Route::post('details/{order_id}', [ShopOrderController::class, 'details']);
            Route::post('place/{order_id}', [ShopOrderController::class, 'orderPlace']);
        });

        //
        Route::post('list', [ShopController::class, 'list']);
        Route::post('store', [ShopController::class, 'store']);
        Route::post('update/{zone_id}', [ShopController::class, 'update']);
        Route::post('destroy/{zone_id}', [ShopController::class, 'destroy']);
    });

    // ZONE MODULE
    Route::group(['prefix'=>'zone'], function(){
        Route::post('list', [ZoneController::class, 'list']);
        Route::post('store', [ZoneController::class, 'store']);
        Route::post('update/{zone_id}', [ZoneController::class, 'update']);
        Route::post('destroy/{zone_id}', [ZoneController::class, 'destroy']);
        Route::post('map/{user_id?}', [ZoneController::class, 'map']);
    });

    // HEAD OFFICE MODULE
    Route::group(['prefix'=>'head-office'], function()
    {
        //
        Route::group(['prefix'=>'distributor'], function()
        {

            Route::post('demand/list', [HeadOfficeDistributorDemandController::class, 'list']);
            Route::post('demand/details/{demand_id}', [HeadOfficeDistributorDemandController::class, 'details']);
            Route::post('demand/receive/{demand_id}', [HeadOfficeDistributorDemandController::class, 'receive']);

            //
            Route::group(['prefix'=>'challan'], function()
            {
                Route::post('list', [HeadOfficeDistributorChallanController::class, 'list']);
                Route::post('store', [HeadOfficeDistributorChallanController::class, 'store']);
                Route::post('update/{challan_id}', [HeadOfficeDistributorChallanController::class, 'update']);
                Route::post('details/{challan_id}', [HeadOfficeDistributorChallanController::class, 'details']);
            });
        });

        // REPORT MODULE
        Route::group(['prefix'=>'report'], function(){
            Route::post('chilling-plant-record/{chilling_plant_id?}', [BankForwardingApplicationController::class, 'chillingPlantRecord']);
            Route::post('application/submit', [BankForwardingApplicationController::class, 'applicationSubmit']);
            Route::post('application/update/{app_id?}', [BankForwardingApplicationController::class, 'applicationUpdate']);
            Route::post('application/view/{application_id?}', [BankForwardingApplicationController::class, 'applicationView']);
            Route::post('application/list/', [BankForwardingApplicationController::class, 'applicationList']);
        });
    });

    // DASHBOARD
    Route::post('dashboard', [DashboardController::class, 'dashboard']);
    // RAW MATERIAL MODULE
    Route::group(['prefix'=>'raw-material'], function(){
        // PURCHASE MODULE
        Route::group(['prefix'=>'purchase'], function(){
            Route::post('list', [MaterialPurchaseController::class, 'list']);
            Route::post('store', [MaterialPurchaseController::class, 'store']);
            Route::post('view/{id?}', [MaterialPurchaseController::class, 'view']);
            Route::post('update/{id?}', [MaterialPurchaseController::class, 'update']);
            Route::post('destroy/{id?}', [MaterialPurchaseController::class, 'destroy']);
            //
            Route::post('item-delete/{id?}', [MaterialPurchaseController::class, 'itemDelete']);
            Route::post('check-item', [MaterialPurchaseController::class, 'makePurchaseItem']);
        });
        // RAW MATERIAL USE MODULE
        Route::group(['prefix'=>'use'], function(){
            Route::post('list', [MaterialUseController::class, 'list']);
            Route::post('store', [MaterialUseController::class, 'store']);
            Route::post('view/{id?}', [MaterialUseController::class, 'view']);
            Route::post('update/{id?}', [MaterialUseController::class, 'update']);
            Route::post('destroy/{id?}', [MaterialUseController::class, 'destroy']);
            //
            Route::post('item-delete/{id?}', [MaterialUseController::class, 'itemDelete']);
            Route::post('check-item', [MaterialUseController::class, 'checkItem']);
        });
    });

    // PRODUCT MODULE
    Route::group(['prefix'=>'product'], function(){
        // PRODUCT PART
        Route::post('list', [ProductController::class, 'list']);
        Route::post('store', [ProductController::class, 'store']);
        Route::post('update/{id?}', [ProductController::class, 'update']);
        Route::post('destroy/{id?}', [ProductController::class, 'destroy']);
        Route::post('config/set', [ProductController::class, 'configSet']);
        Route::post('details/{id?}', [ProductController::class, 'productDetails']);

        // FINISH PRODUCT MODULE
        Route::group(['prefix'=>'finish'], function(){
            Route::post('make-production-item', [FinishProductController::class, 'makeProductionItem']);
            Route::post('item-delete/{id?}', [FinishProductController::class, 'itemDelete']);
            // PRODUCTION PART
            Route::post('list', [FinishProductController::class, 'list']);
            Route::post('store', [FinishProductController::class, 'store']);
            Route::post('update/{id?}', [FinishProductController::class, 'update']);
            Route::post('view/{id?}', [FinishProductController::class, 'view']);
            Route::post('destroy/{id?}', [FinishProductController::class, 'destroy']);
        });

        // CATEGORY PART
        Route::group(['prefix'=>'category'], function(){
            Route::post('list', [CategoryController::class, 'list']);
            Route::post('store', [CategoryController::class, 'store']);
            Route::post('update/{id?}', [CategoryController::class, 'update']);
            Route::post('destroy/{id?}', [CategoryController::class, 'destroy']);
        });

        // UNIT PART
        Route::group(['prefix'=>'unit'], function(){
            Route::post('list', [ProductUnitController::class, 'list']);
            Route::post('store', [ProductUnitController::class, 'store']);
            Route::post('update/{id?}', [ProductUnitController::class, 'update']);
            Route::post('destroy/{id?}', [ProductUnitController::class, 'destroy']);
        });
        // PRICE PART
        Route::group(['prefix'=>'price'], function(){
            Route::post('list', [ProductPriceController::class, 'list']);
            Route::post('store', [ProductPriceController::class, 'store']);
            Route::post('update/{id?}', [ProductPriceController::class, 'update']);
            Route::post('destroy/{id?}', [ProductPriceController::class, 'destroy']);

            // LABEL PART
            Route::group(['prefix'=>'label'], function(){
                Route::post('list', [ProductPriceController::class, 'labelList']);
            });
        });
    });

    // NOTIFICATION MODULE
    Route::group(['prefix'=>'notification'], function(){
        // USER NOTIFICATION
        Route::post('list', [NotificationController::class, 'index']);
        Route::post('view/{id}', [NotificationController::class, 'view']);
    });

    //
    Route::group(['prefix'=>'meeting-resolution'], function(){
        Route::post('list', [MeetingResolutionController::class, 'list']);
        Route::post('new', [MeetingResolutionController::class, 'store']);
        Route::post('resolution-submit/{resolution_id?}', [MeetingResolutionController::class, 'resolutionSubmit']);
    });

    // MENU MODLE
    Route::group(['prefix' => 'menu'], function () {
        Route::post('list', [MenuController::class, 'list']);
        Route::post('store', [MenuController::class, 'store']);
        Route::post('update/{id}', [MenuController::class, 'update']);
        Route::post('delete/{id}', [MenuController::class, 'destroy']);
    });

    // MENU MODLE
    Route::group(['prefix' => 'action-menu'], function () {
        Route::post('list', [ActionMenuController::class, 'list']);
        Route::post('store', [ActionMenuController::class, 'store']);
        Route::post('update/{id}', [ActionMenuController::class, 'update']);
        Route::post('delete/{id}', [ActionMenuController::class, 'destroy']);
    });
    // DEPARTMENT MODULE
    Route::group(['prefix' => 'department'], function () {
        Route::post('list', [DepartmentController::class, 'list']);
        Route::post('store', [DepartmentController::class, 'store']);
        Route::post('update/{id}', [DepartmentController::class, 'update']);
        //
        Route::post('config-setup/{department_id?}', [DepartmentController::class, 'configSetup']);
        Route::post('config/{department_id?}', [DepartmentController::class, 'config']);
        Route::post('stock', [DepartmentController::class, 'stock']);
    });

    // DESIGNATION MODULE
    Route::group(['prefix' => 'designation'], function () {
        Route::post('list', [DesignationController::class, 'list']);
        Route::post('store', [DesignationController::class, 'store']);
        Route::post('update/{id}', [DesignationController::class, 'update']);
    });

    // CHILLING PLANT MODULE
    Route::group(['prefix' => 'chilling-plant'], function () {
        Route::post('all', [ChillingPlantController::class, 'all']);
        Route::post('store', [ChillingPlantController::class, 'store']);
        Route::post('update/{plant_id}', [ChillingPlantController::class, 'update']);
        Route::post('destroy/{plant_id}', [ChillingPlantController::class, 'destroy']);
        Route::post('milk-stock', [ChillingPlantController::class, 'stock']);

        // CHALLAN MODULE
        Route::group(['prefix'=>'challan'], function(){
            Route::post('list', [ChillingPlantChallanController::class, 'list']);
            Route::post('store/{challan_id?}', [ChillingPlantChallanController::class, 'store']);
            Route::post('update/{challan_id?}', [ChillingPlantChallanController::class, 'update']);
            Route::post('delete/{challan_id?}', [ChillingPlantChallanController::class, 'destroy']);
            Route::post('get-voucher', [ChillingPlantChallanController::class, 'getVouchar']);
            //
            Route::post('association', [ChillingPlantChallanController::class, 'AssociationChallanList']);
            Route::post('receive/{association_id?}', [ChillingPlantChallanController::class, 'AssociationChallanReceive']);
        });

        // CHALLAN MODULE
        Route::group(['prefix'=>'report'], function(){
            Route::post('list', [ChillingPlantReportController::class, 'list']);
            Route::post('view/{id?}', [ChillingPlantReportController::class, 'view']);
            //
            Route::post('last-milk-collection-list', [ChillingPlantReportController::class, 'lastMilkCollectionList']);
            Route::post('generate-association-bill-record', [ChillingPlantReportController::class, 'GenerateAssociationBillBecord']);
        });
    });

    // DRIVER MODULE 
    Route::group(['prefix'=>'driver'], function(){
        Route::post('list', [DriverController::class, 'list']);
    });

    // ASSOCIATION MODULE
    Route::group(['prefix' => 'association'], function () {
        Route::post('list', [AssociationController::class, 'list']);

        //
        Route::post('status-update/{association_id}', [AssociationController::class, 'statusUpdate']);
        Route::post('log/{association_id?}', [AssociationController::class, 'log']);

        //
        Route::post('store', [AssociationController::class, 'store']);
        Route::post('update/{association_id}', [AssociationController::class, 'update']);

        //
        Route::post('application/{association_id}', [AssociationController::class, 'application']);
        Route::post('resolution-submit/{association_id}', [AssociationController::class, 'resolutionSubmit']);

        // UPDATE BANK INFORMATION
        Route::post('update-bank-info/{association_id}', [AssociationController::class, 'updateBankInfo']);

        // MEMBER MODULE
        Route::post('add-member', [MemberController::class, 'add']);
        Route::post('all-member', [MemberController::class, 'all']);
        Route::post('update-member/{member_id}', [MemberController::class, 'update']);
        Route::post('update-profile/{member_id}', [MemberController::class, 'updateProfile']);

        // MILK COLLECTION IN ASSOCIATION
        Route::post('milk-collection/all', [MilkCollectionController::class, 'all']);
        Route::post('milk-collection/get-single-entry', [MilkCollectionController::class, 'getSingleEntry']);
        Route::post('milk-collection/single-test-result/{id}', [MilkCollectionController::class, 'getSingleTestResult']);
        Route::post('milk-collection/add', [MilkCollectionController::class, 'store']);
        Route::post('milk-collection/update/{id}', [MilkCollectionController::class, 'update']);

        // ASSOCIATION MILK CHALLAN
        Route::group(['prefix'=>'milk'], function(){
            Route::post('stock', [ChallanController::class, 'stock']);
            Route::post('challan-submit', [ChallanController::class, 'challanSubmit']);
            Route::post('challan-update/{challan_id?}', [ChallanController::class, 'challanUpdate']);
            Route::post('challan-list', [ChallanController::class, 'challanList']);
            Route::post('challan-delete/{challan_id?}', [ChallanController::class, 'destroy']);
        });
    });

    // ENTITY MODULE
    Route::group(['prefix' => 'entity'], function () {
        Route::post('all', [EntityController::class, 'index']);
        Route::post('store', [EntityController::class, 'store']);
        Route::post('update/{id?}', [EntityController::class, 'update']);
    });

    // PRIVILEGE MODULE
    Route::group(['prefix' => 'privilege'], function () {
        Route::post('get', [PrivilegeController::class, 'permitedMenus']);
        Route::post('update', [PrivilegeController::class, 'permitedMenuUpdate']);
    });

    // ROLE MODULE
    Route::group(['prefix' => 'role'], function () {
        Route::post('all', [RoleController::class, 'all']);
        Route::post('store', [RoleController::class, 'store']);
        Route::post('update/{role_id}', [RoleController::class, 'update']);
        Route::post('sync', [RoleController::class, 'sync']);
    });

    // ROAD TYPE MODULE
    Route::group(['prefix' => 'road-type'], function () {
        Route::post('all', [RoadTypeController::class, 'all']);
        Route::post('add', [RoadTypeController::class, 'add']);
        Route::post('update', [RoadTypeController::class, 'update']);
    });

    //Vehicle Category
    Route::group(['prefix' => 'vehicle/'], function () {
        Route::post('category', [VehicleCategoryController::class, 'all']);
        Route::post('category/add', [VehicleCategoryController::class, 'store']);
        Route::post('category/update/{id}', [VehicleCategoryController::class, 'update']);
    });

    //Vehicle
    Route::group(['prefix' => 'vehicle'], function () {
        Route::post('list', [VehicleController::class, 'all']);
        Route::post('add', [VehicleController::class, 'store']);
        Route::post('update/{id}', [VehicleController::class, 'update']);
    });

    //Test
    Route::group(['prefix' => 'test'], function () {
        Route::post('list', [TestController::class, 'all']);
        Route::post('test-list/add', [TestController::class, 'store']);
        Route::post('test-list/update/{id}', [TestController::class, 'update']);
        Route::post('result', [TestResultController::class, 'all']);
        Route::post('result/add', [TestResultController::class, 'store']);
        Route::post('result/update/{id}', [TestResultController::class, 'update']);
    });

    //Milk Category
    Route::group(['prefix' => 'milk-category'], function () {
        Route::post('list', [MilkCategoryController::class, 'all']);
        Route::post('add', [MilkCategoryController::class, 'store']);
        Route::post('update/{id}', [MilkCategoryController::class, 'update']);
    });

    /*
     * ******************************
     *  PROCESSING PLANT MODULE
     * ************************** */
    Route::group(['prefix' => 'processing-plant'], function ()
    {
        Route::post('all', [ProcessingPlantController::class, 'all']);
        Route::post('add', [ProcessingPlantController::class, 'store']);
        Route::post('update/{id}', [ProcessingPlantController::class, 'update']);

        // STOCK STATUS
        Route::post('stock-list/{type?}', [StockController::class, 'list']);

        // NOTIFICATION OF MILK COLLECTION
        Route::group(['prefix'=>'bulk'], function(){
            Route::post('list', [BulkController::class, 'list']);
            Route::post('add', [BulkController::class, 'store']);
            Route::post('view/{bulk_id?}', [BulkController::class, 'view']);
            Route::post('receive/{bulk_id?}', [BulkController::class, 'receive']);
            //
            Route::group(['prefix'=>'qc-report'], function(){
                Route::post('store', [BulkController::class, 'qcReportStore']);
                Route::post('update', [BulkController::class, 'qcReportUpdate']);
                Route::post('list/{bulk_id?}', [BulkController::class, 'qcReportList']);
            });
        });

        // FETCH ALL TYPE WISE CHALLANS FOR PROCESSING PALNT 
        Route::group(['prefix'=>'challan'], function(){
            Route::post('list', [ProcessingPlantChallanController::class, 'list']);
            Route::post('receive/{challan_id?}', [ProcessingPlantChallanController::class, 'receive']);
            Route::post('sample-submit/{challan_id?}', [ProcessingPlantChallanController::class, 'sampleSubmit']);
            Route::post('report-submit/{challan_id?}', [ProcessingPlantChallanController::class, 'reportSubmit']);
            Route::post('standerdization/{challan_id?}', [ProcessingPlantChallanController::class, 'standardization']);
            Route::post('category-wise-milk-submit/{challan_id?}', [ProcessingPlantChallanController::class, 'categoryWiseMilkSubmit']);
            Route::post('department-wise-milk-submit/{challan_id?}', [ProcessingPlantChallanController::class, 'departmentWiseMilkSubmit']);
            Route::post('view/{challan_id?}', [ProcessingPlantChallanController::class, 'view']);
        });

        // NOTIFICATION OF MILK COLLECTION
        Route::group(['prefix'=>'notification'], function(){
            Route::post('milk', [NotificationController::class, 'collection']);
        });
    });

    // ADMIN MODULE
    Route::group(['prefix' => 'user'], function () {
        Route::post('all', [UserController::class, 'all']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('update/{user_id}', [AuthController::class, 'update']);
        Route::post('forgot-password', [AuthController::class, 'ForgotPassword']);

        //
        Route::post('/', function(Request $request)
        {
            $sso_user = Cache::get('user'.$request->user()->id);
            // return response()->json(($request->user() ?? false), (isset($sso_user['details']) ? 200:401));
            return response()->json(($sso_user['details'] ?? false), (isset($sso_user['details']) ? 200:401));
        });
    });
    
    // LOOUT ROUTE
    Route::post('/logout', [AuthController::class, 'logout']);
    //
});


/*
 * *********************
 * PUBLIC ROUTES
 * *****************/ 
// LOCATION
Route::group(['prefix' => 'location'], function () {
    Route::post('divisions', [LocationController::class, 'divisions']);
    Route::post('districts', [LocationController::class, 'districts']);
    Route::post('thanas', [LocationController::class, 'thanas']);
    Route::post('/', [LocationController::class, 'location']);
});


// DISTRIBUTOR AND SHOP APPLICATION
Route::group(['prefix'=>'application'], function(){
    Route::post('/', [ApplicationController::class, 'distributorApplication']);
});
//
Route::post('/login', [AuthController::class, 'login']);