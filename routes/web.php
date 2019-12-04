<?php

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

//Route::get('/temir', 'HomeController@temir');
//Route::get('/status', 'HomeController@create_status');///delete
Route::get('/reset-password', 'UserController@get_reset_password');///delete
Route::post('/reset-password', 'UserController@post_reset_password');///delete

Route::group(['prefix'=>'/', 'middleware'=>'Login'], function () {
    //home page
    Route::get('/', 'HomeController@get_index');
    Route::get('/index', 'HomeController@get_index');
    Route::get('/home', 'HomeController@get_index');

    Route::get('/users/update', 'UserController@get_users_update');
    Route::post('/users/update', 'UserController@post_users_update');

    //warehouse for supply user
    Route::group(['prefix'=>'/users/warehouse', 'middleware'=>'User'], function () {
        Route::get('/', 'WareHouseController@get_warehouse_for_users');
        Route::post('/', 'WareHouseController@post_warehouse');
    });

    //delivered for supply user
    Route::group(['prefix'=>'/users/delivered', 'middleware'=>'User'], function () {
        Route::get('/', 'DeliveryController@get_delivered_for_users');
        Route::post('/', 'DeliveryController@post_delivered');
    });

    //orders for users
    Route::group(['prefix'=>'orders', 'middleware'=>'User'], function () {
        Route::get('/', 'OrderController@get_orders');
        Route::post('/', 'OrderController@post_delete_order');
    });

    //vehicles for users
    Route::group(['prefix'=>'vehicles', 'middleware'=>'User'], function () {
        Route::get('/', 'VehicleController@get_vehicles');
        Route::post('/', 'VehicleController@post_vehicles');
    });

    //orders for chiefs
    Route::group(['prefix'=>'chief/orders'], function () {
        Route::get('/', 'OrderController@get_orders_for_chief');
        Route::post('/', 'OrderController@post_delete_order_for_chief');
    });

    //warehouse for chief
    Route::group(['prefix'=>'/chief/warehouse', 'middleware'=>'UserChief'], function () {
        Route::get('/', 'WareHouseController@get_warehouse_for_chief');
        Route::post('/', 'WareHouseController@post_warehouse');
    });

    //delivered for chief
    Route::group(['prefix'=>'/chief/delivered', 'middleware'=>'UserChief'], function () {
        Route::get('/', 'DeliveryController@get_delivered_for_chief');
        Route::post('/', 'DeliveryController@post_delivered');
    });

    //users for supply chiefs
    Route::group(['prefix'=>'supply/users', 'middleware'=>'SupplyChief'], function () {
        Route::get('/', 'UserController@get_users');
        Route::post('/', 'UserController@post_delete_or_approve_user');
    });

    //orders for supply
    Route::group(['prefix'=>'supply', 'middleware'=>'Supply'], function () {
        Route::get('/orders', 'OrderController@get_orders');
        Route::post('/orders', 'OrderController@post_delete_order');
        Route::get('/alternatives', 'OrderController@get_orders_for_supply');
        Route::post('/alternatives', 'OrderController@post_delete_order_for_supply');
    });

    //orders for supply chief
    Route::group(['prefix'=>'supply/chief', 'middleware'=>'SupplyChief'], function () {
        Route::get('/orders', 'OrderController@get_orders_for_chief');
        Route::post('/orders', 'OrderController@post_delete_order_for_chief');
    });

    //alternatives list for supply chief
    Route::group(['prefix'=>'supply', 'middleware'=>'SupplyChief'], function () {
        Route::get('/alternatives-list', 'AlternativesController@get_alternatives');
        Route::post('/alternatives-list', 'AlternativesController@post_alternatives');
    });

    //demand for supply
    Route::group(['prefix'=>'supply', 'middleware'=>'Supply'], function () {
        Route::get('/demand', 'DemandController@get_demand');
        Route::post('/demand', 'DemandController@post_demand');
        Route::get('/demand/print', 'DemandController@print_orders_for_demand_for_supply');
    });

    //accounts for supply
    Route::group(['prefix'=>'supply/accounts', 'middleware'=>'Supply'], function () {
        Route::get('/', 'AccountController@get_accounts_for_supply');
        Route::post('/', 'AccountController@post_accounts_for_supply');
        Route::get('/print', 'AccountController@print_orders_in_account_for_supply');
        Route::get('/finance/print', 'AccountController@print_orders_for_demand_for_supply');
        Route::get('/report/print', 'AccountController@print_orders_for_finance_for_supply');
    });

    //purchase for supply user
    Route::group(['prefix'=>'supply/purchases', 'middleware'=>'Supply'], function () {
        Route::get('/', 'PurchaseController@get_purchases_for_supply');
        Route::post('/', 'PurchaseController@post_purchase_for_supply');
    });

    //warehouse for supply user
    Route::group(['prefix'=>'supply/warehouse', 'middleware'=>'Supply'], function () {
        Route::get('/', 'WareHouseController@get_warehouse_for_supply');
        Route::post('/', 'WareHouseController@post_warehouse');
    });

    //delivered for supply user
    Route::group(['prefix'=>'supply/delivered', 'middleware'=>'Supply'], function () {
        Route::get('/', 'DeliveryController@get_delivered_for_supply');
        Route::post('/', 'DeliveryController@post_delivered');
    });

    //companies for supply
    Route::group(['prefix'=>'supply/companies', 'middleware'=>'Supply'], function () {
        Route::get('/', 'CompanyController@get_companies');
        Route::post('/', 'CompanyController@post_companies');
    });

    //director
    Route::group(['prefix'=>'director', 'middleware'=>'Director'], function () {
        //purchase
        Route::group(['prefix'=>'/purchases'], function () {
            Route::get('/', 'PurchaseController@get_purchases');
            Route::post('/', 'PurchaseController@post_purchases');
        });

        //alternatuves
        Route::group(['prefix'=>'/alternatives'], function () {
            Route::get('/', 'LawyerController@get_orders_for_alts');
            Route::post('/', 'LawyerController@post_order_for_alts');
        });

        //pending orders
        Route::group(['prefix'=>'/pending/orders', 'middleware'=>'DirectorLawyer'], function () {
            Route::get('/', 'LawyerController@get_pending_orders');
            Route::post('/', 'LawyerController@post_pending_orders');
        });

        //warehouse
        Route::group(['prefix'=>'/warehouse'], function () {
            Route::get('/', 'WareHouseController@get_warehouse_for_director');
            Route::post('/', 'WareHouseController@post_warehouse');
        });

        //delivered
        Route::group(['prefix'=>'/delivered'], function () {
            Route::get('/', 'DeliveryController@get_delivered_for_director');
            Route::post('/', 'DeliveryController@post_delivered');
        });

        Route::get('/accounts/print', 'AccountController@print_orders_in_account_for_supply');
    });

    //chiefs for admins
    Route::group(['prefix'=>'chiefs', 'middleware'=>'Admin'], function () {
        Route::get('/', 'ChiefController@get_chiefs');
        Route::post('/', 'ChiefController@post_delete_chief');
        Route::get('/add', 'ChiefController@get_add_chief');
        Route::post('/add', 'ChiefController@post_add_chief');
        Route::get('/update/{id}', 'ChiefController@get_update_chief');
        Route::post('/update/{id}', 'ChiefController@post_update_chief');
    });

    //directors for admins
    Route::group(['prefix'=>'directors', 'middleware'=>'Admin'], function () {
        Route::get('/', 'DirectorController@get_directors');
        Route::post('/', 'DirectorController@post_delete_director');
        Route::get('/add', 'DirectorController@get_add_director');
        Route::post('/add', 'DirectorController@post_add_director');
        Route::get('/update/{id}', 'DirectorController@get_update_director');
        Route::post('/update/{id}', 'DirectorController@post_update_director');
    });

    //authorities for admins
    Route::group(['prefix'=>'authorities', 'middleware'=>'Admin'], function () {
        Route::get('/', 'AuthorityController@get_authorities');
        Route::post('/', 'AuthorityController@post_delete_authority');
        Route::get('/add', 'AuthorityController@get_add_authority');
        Route::post('/add', 'AuthorityController@post_add_authority');
        Route::get('/update/{id}', 'AuthorityController@get_update_authority');
        Route::post('/update/{id}', 'AuthorityController@post_update_authority');
    });

    //admins for admins
    Route::group(['prefix'=>'admins', 'middleware'=>'Admin'], function () {
        Route::get('/', 'AdminController@get_admins');
        Route::post('/', 'AdminController@post_delete_admin');
        Route::get('/add', 'AdminController@get_add_admin');
        Route::post('/add', 'AdminController@post_add_admin');
        Route::get('/update/{id}', 'AdminController@get_update_admin');
        Route::post('/update/{id}', 'AdminController@post_update_admin');
    });

    //SupplyUser for admins
    Route::group(['prefix'=>'supply-users', 'middleware'=>'Admin'], function () {
        Route::get('/', 'SupplyController@get_supply_users');
        Route::post('/', 'SupplyController@post_delete_supply_user');
    });

    //Settings for admins
    Route::group(['prefix'=>'settings', 'middleware'=>'Admin'], function () {
        Route::get('/', 'SettingsController@get_settings');
        Route::post('/', 'SettingsController@update_settings');
    });

    //situations for admins
    Route::group(['prefix'=>'situations', 'middleware'=>'Admin'], function () {
        Route::get('/', 'SituationController@get_situations');
        Route::post('/', 'SituationController@post_delete_situation');
        Route::get('/add', 'SituationController@get_add_situation');
        Route::post('/add', 'SituationController@post_add_situation');
        Route::get('/update/{id}', 'SituationController@get_update_situation');
        Route::post('/update/{id}', 'SituationController@post_update_situation');
    });

    //deadlines for admins
    Route::group(['prefix'=>'deadlines', 'middleware'=>'Admin'], function () {
        Route::get('/', 'DeadlineController@get_deadlines');
        Route::post('/', 'DeadlineController@post_delete_deadline');
        Route::get('/add', 'DeadlineController@get_add_deadline');
        Route::post('/add', 'DeadlineController@post_add_deadline');
        Route::get('/update/{id}', 'DeadlineController@get_update_deadline');
        Route::post('/update/{id}', 'DeadlineController@post_update_deadline');
    });

    //departments for admins
    Route::group(['prefix'=>'departments', 'middleware'=>'Admin'], function () {
        Route::get('/', 'DepartmentController@get_departments');
        Route::post('/', 'DepartmentController@post_delete_department');
        Route::get('/add', 'DepartmentController@get_add_department');
        Route::post('/add', 'DepartmentController@post_add_department');
        Route::get('/update/{id}', 'DepartmentController@get_update_department');
        Route::post('/update/{id}', 'DepartmentController@post_update_department');
    });

    //companies for admin
    Route::group(['prefix'=>'companies', 'middleware'=>'Admin'], function () {
        Route::get('/', 'CompanyController@get_companies');
        Route::post('/', 'CompanyController@post_companies');
    });

    //vehicles for admins
    Route::group(['prefix'=>'admin/vehicles', 'middleware'=>'Admin'], function () {
        Route::get('/', 'VehicleController@get_vehicles');
        Route::post('/', 'VehicleController@post_vehicles');
    });

    //users for chiefs
    Route::group(['prefix'=>'/chief/users', 'middleware'=>'UserChief'], function () {
        Route::get('/', 'UserController@get_users');
        Route::post('/', 'UserController@post_delete_or_approve_user');
    });

    //lawyers
    Route::group(['prefix'=>'law', 'middleware'=>'Lawyer'], function () {
        //orders for users
        Route::group(['prefix'=>'/orders'], function () {
            Route::get('/', 'OrderController@get_orders');
            Route::post('/', 'OrderController@post_delete_order');
        });

        //pending orders
        Route::group(['prefix'=>'/pending/orders'], function () {
            Route::get('/', 'LawyerController@get_pending_orders');
            Route::post('/', 'LawyerController@post_pending_orders');
        });

        //purchase
        Route::group(['prefix'=>'/purchases'], function () {
            Route::get('/', 'PurchaseController@get_purchases');
            Route::post('/', 'PurchaseController@post_purchases');
        });

        //warehouse
        Route::group(['prefix'=>'/warehouse'], function () {
            Route::get('/', 'WareHouseController@get_warehouse_for_director');
            Route::post('/', 'WareHouseController@post_warehouse');
        });

        //delivered
        Route::group(['prefix'=>'/delivered'], function () {
            Route::get('/', 'DeliveryController@get_delivered_for_director');
            Route::post('/', 'DeliveryController@post_delivered');
        });

        Route::get('/accounts/print', 'AccountController@print_orders_in_account_for_supply');
    });

    //lawyer chief
    Route::group(['prefix'=>'/law', 'middleware'=>'LawyerChief'], function () {
        //users for lawyer chiefs
        Route::group(['prefix'=>'/users'], function () {
            Route::get('/', 'UserController@get_users');
            Route::post('/', 'UserController@post_delete_or_approve_user');
        });

        //orders for chiefs
        Route::group(['prefix'=>'/chief/orders'], function () {
            Route::get('/', 'OrderController@get_orders_for_chief');
            Route::post('/', 'OrderController@post_delete_order_for_chief');
        });

        //pending orders
        Route::group(['prefix'=>'/chief/pending/orders'], function () {
            Route::get('/', 'LawyerController@get_pending_orders');
            Route::post('/', 'LawyerController@post_pending_orders');
        });

        //purchase
        Route::group(['prefix'=>'/chief/purchases'], function () {
            Route::get('/', 'PurchaseController@get_purchases');
            Route::post('/', 'PurchaseController@post_purchases');
        });
    });

    //finance
    Route::group(['prefix'=>'finance', 'middleware'=>'Finance'], function () {
        //orders for users
        Route::group(['prefix'=>'/orders'], function () {
            Route::get('/', 'OrderController@get_orders');
            Route::post('/', 'OrderController@post_delete_order');
        });

        //pending orders
        Route::group(['prefix'=>'/pending/orders'], function () {
            Route::get('/', 'LawyerController@get_pending_orders');
            Route::post('/', 'LawyerController@post_pending_orders');
        });

        //purchase
        Route::group(['prefix'=>'/purchases'], function () {
            Route::get('/', 'PurchaseController@get_purchases');
            Route::post('/', 'PurchaseController@post_purchases');
        });

        //warehouse
        Route::group(['prefix'=>'/warehouse'], function () {
            Route::get('/', 'WareHouseController@get_warehouse_for_director');
            Route::post('/', 'WareHouseController@post_warehouse');
        });

        //delivered
        Route::group(['prefix'=>'/delivered'], function () {
            Route::get('/', 'DeliveryController@get_delivered_for_director');
            Route::post('/', 'DeliveryController@post_delivered');
        });

        Route::get('/accounts/print', 'AccountController@print_orders_in_account_for_supply');
    });

    //finance chief
    Route::group(['prefix'=>'/finance', 'middleware'=>'FinanceChief'], function () {
        //users for chiefs
        Route::group(['prefix'=>'/users'], function () {
            Route::get('/', 'UserController@get_users');
            Route::post('/', 'UserController@post_delete_or_approve_user');
        });

        //orders for chiefs
        Route::group(['prefix'=>'/chief/orders'], function () {
            Route::get('/', 'OrderController@get_orders_for_chief');
            Route::post('/', 'OrderController@post_delete_order_for_chief');
        });

        //pending orders
        Route::group(['prefix'=>'/chief/pending/orders'], function () {
            Route::get('/', 'LawyerController@get_pending_orders');
            Route::post('/', 'LawyerController@post_pending_orders');
        });

        //purchase
        Route::group(['prefix'=>'/chief/purchases'], function () {
            Route::get('/', 'PurchaseController@get_purchases');
            Route::post('/', 'PurchaseController@post_purchases');
        });
    });

    //warehouseman
    Route::group(['prefix'=>'warehouseman', 'middleware'=>'WareHouseMan'], function () {
        //warehouse
        Route::group(['prefix'=>'orders'], function () {
            Route::get('/', 'WareHouseController@get_warehouse_for_warehouseman');
            Route::post('/', 'WareHouseController@post_warehouse');
        });
        //delivered orders for warehouseman
        Route::group(['prefix'=>'delivered'], function () {
            Route::get('/', 'DeliveryController@get_delivered_for_warehouseman');
            Route::post('/', 'DeliveryController@post_delivered');
        });
    });

    //messages
    Route::group(['prefix'=>'/chat'], function () {
        Route::get('/', 'MessagesController@get_messages');
        Route::post('/', 'MessagesController@post_messages');
    });
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/wait', function () {
    return view('home');
});


//sellers form
Route::group(['prefix'=>'/sellers'], function () {
    Route::get('/', 'SellerController@get_sellers_form');
    Route::post('/', 'SellerController@post_sellers_form');
});