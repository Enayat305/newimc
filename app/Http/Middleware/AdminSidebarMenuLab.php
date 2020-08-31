<?php

namespace App\Http\Middleware;

use App\Utils\ModuleUtil;
use Closure;
use Menu;

class AdminSidebarMenuLab
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }

        Menu::create('admin-sidebar-menulab', function ($menu) {
            $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];
            //Home
            $menu->url(action('Lab\HomeController@index'), __('home.home'), ['icon' => 'fa fas fa-tachometer-alt', 'active' => request()->segment(1) == 'home'])->order(5);

            //User management dropdown
            if (auth()->user()->can('lab_user.view') || auth()->user()->can('lab_user.create') || auth()->user()->can('lab_roles.view')) {
                $menu->dropdown(
                    __('user.user_management'),
                    function ($sub) {
                        if (auth()->user()->can('lab_user.view')) {
                            $sub->url(
                                action('Lab\ManageUserController@index'),
                                __('user.users'),
                                ['icon' => 'fa fas fa-user', 'active' => request()->segment(1) == 'users']
                            );
                        }
                        if (auth()->user()->can('lab_roles.view')) {
                            $sub->url(
                                action('Lab\RoleController@index'),
                                __('user.roles'),
                                ['icon' => 'fa fas fa-briefcase', 'active' => request()->segment(1) == 'roles']
                            );
                        }
                       
                    },
                    ['icon' => 'fa fas fa-users']
                )->order(10);
            }

            //Contacts dropdown
            if (auth()->user()->can('lab_supplier.view') || auth()->user()->can('lab_customer.view')) {
                $menu->dropdown(
                    __('contact.contacts'),
                    function ($sub) {
                        if (auth()->user()->can('lab_supplier.view')) {
                            $sub->url(
                                action('Lab\ContactController@index', ['type' => 'supplier']),
                                __('report.supplier'),
                                ['icon' => 'fa fas fa-star', 'active' => request()->input('type') == 'supplier']
                            );
                        }
                        if (auth()->user()->can('lab_customer.view')) {
                            $sub->url(
                                action('Lab\ContactController@index', ['type' => 'customer']),
                                __('report.customer'),
                                ['icon' => 'fa fas fa-star', 'active' => request()->input('type') == 'customer']
                            );
                            $sub->url(
                                action('CustomerGroupController@index'),
                                __('lang_v1.customer_groups'),
                                ['icon' => 'fa fas fa-users', 'active' => request()->segment(1) == 'customer-group']
                            );
                        }
                      
                    },
                    ['icon' => 'fa fas fa-address-book', 'id' => "tour_step4"]
                )->order(15);
            }

        
            //Products dropdown
            if (auth()->user()->can('lab_product.view') || auth()->user()->can('lab_product.create') ||
                auth()->user()->can('lab_brand.view') || auth()->user()->can('lab_unit.view') ||
                auth()->user()->can('lab_category.view') || auth()->user()->can('lab_brand.create') ||
                auth()->user()->can('lab_unit.create') || auth()->user()->can('lab_category.create')) {
                $menu->dropdown(
                    __('sale.products'),
                    function ($sub) {
                        if (auth()->user()->can('lab_product.view')) {
                            $sub->url(
                                action('Lab\ProductController@index'),
                                __('lang_v1.list_products'),
                                ['icon' => 'fa fas fa-list', 'active' => request()->segment(2) == 'products' && request()->segment(3) == '']
                            );
                        }
                        if (auth()->user()->can('lab_product.create')) {
                            $sub->url(
                                action('Lab\ProductController@create'),
                                __('product.add_product'),
                                ['icon' => 'fa fas fa-plus-circle', 'active' =>request()->segment(1) == 'lab' && request()->segment(2) == 'products' && request()->segment(3) == 'create']
                            );
                        }
                        if (auth()->user()->can('lab_product.view')) {
                            $sub->url(
                                action('LabelsController@show'),
                                __('barcode.print_labels'),
                                ['icon' => 'fa fas fa-barcode', 'active' => request()->segment(1) == 'labels' && request()->segment(2) == 'show']
                            );
                        }
                     
                        if (auth()->user()->can('lab_unit.view') || auth()->user()->can('lab_unit.create')) {
                            $sub->url(
                                action('Lab\UnitController@index'),
                                __('unit.units'),
                                ['icon' => 'fa fas fa-balance-scale', 'active' => request()->segment(2) == 'units']
                            );
                        }
                  
                        if (auth()->user()->can('lab_brand.view') || auth()->user()->can('lab_brand.create')) {
                            $sub->url(
                                action('Lab\BrandController@index'),
                                __('brand.brands'),
                                ['icon' => 'fa fas fa-gem', 'active' => request()->segment(2) == 'brands']
                            );
                        }

                    },
                    ['icon' => 'fa fas fa-cubes', 'id' => 'tour_step5']
                )->order(20);
            }
            ///press
            if (auth()->user()->can('prescription.view') || auth()->user()->can('prescription.create') ||
            auth()->user()->can('schedule.view') || auth()->user()->can('appointment.view') ||
            auth()->user()->can('schedule.create') ||
            auth()->user()->can('appointment.create')) {
            $menu->dropdown(
                __('Clanic'),
                function ($sub) {
                    if (auth()->user()->can('prescription.view')) {
                        $sub->url(
                            action('Lab\PrescriptionController@index'),
                            __('List Prescription'),
                            ['icon' => 'fa fas fa-list', 'active' => request()->segment(2) == 'prescription' && request()->segment(3) == '']
                        );
                    }
                    if (auth()->user()->can('prescription.create')) {
                        $sub->url(
                            action('Lab\PrescriptionController@create'),
                            __('Add Prescription'),
                            ['icon' => 'fa fas fa-plus-circle', 'active' =>request()->segment(1) == 'lab' && request()->segment(2) == 'prescription' && request()->segment(3) == 'create']
                        );
                    }
                    
                    
                    if (auth()->user()->can('schedule.view') || auth()->user()->can('schedule.create')) {
                        $sub->url(
                            action('Lab\ScheduleController@index'),
                            __('Schedules'),
                            ['icon' => 'fa fas fa-balance-scale', 'active' => request()->segment(2) == 'schedule']
                        );
                    }
                    if (auth()->user()->can('appointment.view')) {
                        $sub->url(
                            action('Lab\AppointmentController@index'),
                            __('Appointments '),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'appointment' ]
                        );
                    }
                    if (auth()->user()->can('patient.view')) {
                        $sub->url(
                            action('Lab\PatientController@index'),
                            __('Patients '),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'patients']
                        );
                    }
                    if (auth()->user()->can('diet.view')) {
                        $sub->url(
                            action('Lab\DietController@index'),
                            __('Diets '),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'diets']
                        );
                    }
                    if (auth()->user()->can('allergie.view')) {
                        $sub->url(
                            action('Lab\AllergieController@index'),
                            __('Allergies'),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'allergies']
                        );
                    }
                    if (auth()->user()->can('familyhistory.view')) {
                        $sub->url(
                            action('Lab\FamilyHistoryController@index'),
                            __('Family History'),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'familyhistory']
                        );
                    }
                    if (auth()->user()->can('pathologicalHistory.view')) {
                        $sub->url(
                            action('Lab\PathologicalHistoryController@index'),
                            __('Pathological History'),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'pathologicalhistory']
                        );
                    }
                    if (auth()->user()->can('phychiatricHistory.view')) {
                        $sub->url(
                            action('Lab\PhychiatricHistoryController@index'),
                            __('Phychiatric History'),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'phychiatrichistory']
                        );
                    }
                    if (auth()->user()->can('nonpathologicalhistory.view')) {
                        $sub->url(
                            action('Lab\NonPathologicalHistoryController@index'),
                            __('Non Pathological History'),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'nonpathologicalhistory']
                        );
                    }
                    if (auth()->user()->can('vaccine.view')) {
                        $sub->url(
                            action('Lab\VaccineController@index'),
                            __('Vaccine'),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'vaccine']
                        );
                    }
                  
                },
                ['icon' => 'fa fas fa-cubes', 'id' => 'tour_step5']
            )->order(20);
        }
            //Test dropdown
            if (auth()->user()->can('test.view') || auth()->user()->can('test.create') ||
                auth()->user()->can('lab_departments.view') || auth()->user()->can('testparticulart.view') ||
                auth()->user()->can('lab_category.view') || auth()->user()->can('lab_departments.create') ||
                auth()->user()->can('testparticulart.create') || auth()->user()->can('lab_category.create')) {
                $menu->dropdown(
                    __('Tests'),
                    function ($sub) {
                        if (auth()->user()->can('test.view')) {
                            $sub->url(
                                action('Lab\TestController@index'),
                                __('List Tests'),
                                ['icon' => 'fa fas fa-list', 'active' => request()->segment(2) == 'tests' && request()->segment(3) == '']
                            );
                        }
                        if (auth()->user()->can('test.create')) {
                            $sub->url(
                                action('Lab\TestController@create'),
                                __('Add Test'),
                                ['icon' => 'fa fas fa-plus-circle', 'active' =>request()->segment(1) == 'lab' && request()->segment(2) == 'tests' && request()->segment(3) == 'create']
                            );
                        }
                        
                        
                        if (auth()->user()->can('testparticular.view') || auth()->user()->can('testparticular.create')) {
                            $sub->url(
                                action('Lab\TestParticularController@index'),
                                __('Test Particulars'),
                                ['icon' => 'fa fas fa-balance-scale', 'active' => request()->segment(2) == 'testparticular']
                            );
                        }
                        if (auth()->user()->can('testparticular.create')) {
                            $sub->url(
                                action('Lab\TestParticularController@create'),
                                __('Add Test Particulars '),
                                ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'testparticular' && request()->segment(3) == 'create']
                            );
                        }
                        if (auth()->user()->can('lab_test_report.view')) {
                            $sub->url(
                                action('Lab\TestReportController@index'),
                                __('Add Test Reports '),
                                ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'test_reports']
                            );
                         
                        }
                        if (auth()->user()->can('multi_report.create')) {
                        
                        $sub->url(
                            action('Lab\Multi_ReportController@create'),
                            __('Add Multi Test Reports '),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'test_reports']
                        );
                    }

                    if (auth()->user()->can('lab_department.create')) {
                        
                        $sub->url(
                            action('Lab\DepartmentController@index'),
                            __('Departments'),
                            ['icon' => 'fa fas fa-shield-alt', 'active' => request()->segment(2) == 'departments']
                        );
                    }
                      
                    },
                    ['icon' => 'fa fas fa-cubes', 'id' => 'tour_step5']
                )->order(20);
            }
            //Purchase dropdown
            if (auth()->user()->can('lab_purchase.view') || auth()->user()->can('lab_purchase.create') || auth()->user()->can('lab_purchase.update')) {
                $menu->dropdown(
                    __('purchase.purchases'),
                    function ($sub) {
                        if (auth()->user()->can('lab_purchase.view')) {
                            $sub->url(
                                action('Lab\PurchaseController@index'),
                                __('purchase.list_purchase'),
                                ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'purchases' && request()->segment(2) == null]
                            );
                        }
                        if (auth()->user()->can('lab_purchase.create')) {
                            $sub->url(
                                action('Lab\PurchaseController@create'),
                                __('purchase.add_purchase'),
                                ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(1) == 'purchases' && request()->segment(2) == 'create']
                            );
                        }
                        if (auth()->user()->can('lab_purchase.update')) {
                            $sub->url(
                                action('PurchaseReturnController@index'),
                                __('lang_v1.list_purchase_return'),
                                ['icon' => 'fa fas fa-undo', 'active' => request()->segment(1) == 'purchase-return']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-arrow-circle-down', 'id' => 'tour_step6']
                )->order(25);
            }
            //Sell dropdown
            if (auth()->user()->can('lab_sell.view') || auth()->user()->can('lab_sell.create') || auth()->user()->can('lab_direct_sell.access') ||  auth()->user()->can('lab_view_own_sell_only')) {
                $menu->dropdown(
                    __('sale.sale'),
                    function ($sub) use ($enabled_modules) {
                        if (auth()->user()->can('lab_direct_sell.access') ||  auth()->user()->can('lab_view_own_sell_only')) {
                            $sub->url(
                                action('Lab\SellPosController@index'),
                                __('lang_v1.all_sales'),
                                ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'sells' && request()->segment(2) == null]
                            );
                        }
                        
                        if (auth()->user()->can('lab_sell.view')) {
                            $sub->url(
                                action('Lab\SellPosController@index'),
                                __('sale.list_pos'),
                                ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'pos' && request()->segment(2) == null]
                            );
                        }
                        if (auth()->user()->can('lab_sell.create')) {
                            $sub->url(
                                action('Lab\SellPosController@create'),
                                __('sale.pos_sale'),
                                ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(1) == 'pos' && request()->segment(2) == 'create']
                            );
                           
                          
                        }

                        if (auth()->user()->can('lab_sell.view')) {
                            $sub->url(
                                action('SellReturnController@index'),
                                __('lang_v1.list_sell_return'),
                                ['icon' => 'fa fas fa-undo', 'active' => request()->segment(1) == 'sell-return' && request()->segment(2) == null]
                            );
                        }


                      
                      
                    },
                    ['icon' => 'fa fas fa-arrow-circle-up', 'id' => 'tour_step7']
                )->order(30);
            }

            // //Stock transfer dropdown
            // if (auth()->user()->can('lab_purchase.view') || auth()->user()->can('lab_purchase.create')) {
            //     $menu->dropdown(
            //         __('lang_v1.stock_transfers'),
            //         function ($sub) {
            //             if (auth()->user()->can('lab_purchase.view')) {
            //                 $sub->url(
            //                     action('StockTransferController@index'),
            //                     __('lang_v1.list_stock_transfers'),
            //                     ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'stock-transfers' && request()->segment(2) == null]
            //                 );
            //             }
            //             if (auth()->user()->can('lab_purchase.create')) {
            //                 $sub->url(
            //                     action('StockTransferController@create'),
            //                     __('lang_v1.add_stock_transfer'),
            //                     ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(1) == 'stock-transfers' && request()->segment(2) == 'create']
            //                 );
            //             }
            //         },
            //         ['icon' => 'fa fas fa-truck']
            //     )->order(35);
            // }

            // //stock adjustment dropdown
            // if (auth()->user()->can('lab_purchase.view') || auth()->user()->can('lab_purchase.create')) {
            //     $menu->dropdown(
            //         __('stock_adjustment.stock_adjustment'),
            //         function ($sub) {
            //             if (auth()->user()->can('lab_purchase.view')) {
            //                 $sub->url(
            //                     action('StockAdjustmentController@index'),
            //                     __('stock_adjustment.list'),
            //                     ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'stock-adjustments' && request()->segment(2) == null]
            //                 );
            //             }
            //             if (auth()->user()->can('lab_purchase.create')) {
            //                 $sub->url(
            //                     action('StockAdjustmentController@create'),
            //                     __('stock_adjustment.add'),
            //                     ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(1) == 'stock-adjustments' && request()->segment(2) == 'create']
            //                 );
            //             }
            //         },
            //         ['icon' => 'fa fas fa-database']
            //     )->order(40);
            // }

            //Expense dropdown
            if (auth()->user()->can('lab_expense.access')) {
                $menu->dropdown(
                    __('expense.expenses'),
                    function ($sub) {
                        $sub->url(
                            action('Lab\ExpenseController@index'),
                            __('lang_v1.list_expenses'),
                            ['icon' => 'fa fas fa-list', 'active' => request()->segment(2) == 'expenses' && request()->segment(3) == null]
                        );
                        $sub->url(
                            action('Lab\ExpenseController@create'),
                            __('messages.add') .  __('expense.expenses'),
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(2) == 'expenses' && request()->segment(3) == 'create']
                        );
                        $sub->url(
                            action('Lab\ExpenseCategoryController@index'),
                            __('expense.expense_categories'),
                            ['icon' => 'fa fas fa-circle', 'active' => request()->segment(2) == 'expense-categories']
                        );
                    },
                    ['icon' => 'fa fas fa-minus-circle']
                )->order(45);
            }
            //Accounts dropdown
            // if (auth()->user()->can('lab_account.access') && in_array('account', $enabled_modules)) {
            //     $menu->dropdown(
            //         __('lang_v1.payment_accounts'),
            //         function ($sub) {
            //             $sub->url(
            //                 action('AccountController@index'),
            //                 __('account.list_accounts'),
            //                 ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'account']
            //             );
            //             $sub->url(
            //                 action('AccountReportsController@balanceSheet'),
            //                 __('account.balance_sheet'),
            //                 ['icon' => 'fa fas fa-book', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'balance-sheet']
            //             );
            //             $sub->url(
            //                 action('AccountReportsController@trialBalance'),
            //                 __('account.trial_balance'),
            //                 ['icon' => 'fa fas fa-balance-scale', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'trial-balance']
            //             );
            //             $sub->url(
            //                 action('AccountController@cashFlow'),
            //                 __('lang_v1.cash_flow'),
            //                 ['icon' => 'fa fas fa-exchange-alt', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'cash-flow']
            //             );
            //             $sub->url(
            //                 action('AccountReportsController@paymentAccountReport'),
            //                 __('account.payment_account_report'),
            //                 ['icon' => 'fa fas fa-file-alt', 'active' => request()->segment(1) == 'account' && request()->segment(2) == 'payment-account-report']
            //             );
            //         },
            //         ['icon' => 'fa fas fa-money-check-alt']
            //     )->order(50);
            // }

            //Reports dropdown
            if (auth()->user()->can('lab_purchase_n_sell_report.view') || auth()->user()->can('lab_contacts_report.view')
                || auth()->user()->can('lab_stock_report.view') || auth()->user()->can('lab_tax_report.view')
                || auth()->user()->can('lab_trending_product_report.view') || auth()->user()->can('lab_sales_representative.view') || auth()->user()->can('lab_register_report.view')
                || auth()->user()->can('lab_expense_report.view')) {
                $menu->dropdown(
                    __('report.reports'),
                    function ($sub) use ($enabled_modules) {
                        if (auth()->user()->can('lab_profit_loss_report.view')) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@getProfitLoss'),
                                __('report.profit_loss'),
                                ['icon' => 'fa fas fa-file-invoice-dollar', 'active' => request()->segment(3) == 'profit-loss']
                            );
                        }
                     

                    
                        if (auth()->user()->can('lab_contacts_report.view')) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@getCustomerSuppliers'),
                                __('report.contacts'),
                                ['icon' => 'fa fas fa-address-book', 'active' => request()->segment(3) == 'customer-supplier']
                            );
                            $sub->url(
                                action('Lab\LaboratoryReportController@getCustomerGroup'),
                                __('lang_v1.customer_groups_report'),
                                ['icon' => 'fa fas fa-users', 'active' => request()->segment(3) == 'customer-group']
                            );
                        }
                        if (auth()->user()->can('lab_stock_report.view')) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@getStockReport'),
                                __('report.stock_report'),
                                ['icon' => 'fa fas fa-hourglass-half', 'active' => request()->segment(3) == 'stock-report']
                            );
                            if (session('business.enable_product_expiry') == 1) {
                                $sub->url(
                                    action('Lab\LaboratoryReportController@getStockExpiryReport'),
                                    __('report.stock_expiry_report'),
                                    ['icon' => 'fa fas fa-calendar-times-o', 'active' => request()->segment(3) == 'stock-expiry']
                                );
                            }
                            if (session('business.enable_lot_number') == 1) {
                                $sub->url(
                                    action('Lab\LaboratoryReportController@getLotReport'),
                                    __('lang_v1.lot_report'),
                                    ['icon' => 'fa fas fa-hourglass-half', 'active' => request()->segment(3) == 'lot-report']
                                );
                            }

                            $sub->url(
                                action('Lab\LaboratoryReportController@getStockAdjustmentReport'),
                                __('report.stock_adjustment_report'),
                                ['icon' => 'fa fas fa-sliders-h', 'active' => request()->segment(3) == 'stock-adjustment-report']
                            );
                        }

                        if (auth()->user()->can('lab_trending_product_report.view')) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@getTrendingProducts'),
                                __('Trending Tests'),
                                ['icon' => 'fa fas fa-chart-line', 'active' => request()->segment(3) == 'trending-products']
                            );
                        }

                        if (auth()->user()->can('lab_purchase_n_sell_report.view')) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@itemsReport'),
                                __('lang_v1.items_report'),
                                ['icon' => 'fa fas fa-tasks', 'active' => request()->segment(3) == 'items-report']
                            );

                            $sub->url(
                                action('Lab\LaboratoryReportController@getproductPurchaseReport'),
                                __('lang_v1.product_purchase_report'),
                                ['icon' => 'fa fas fa-arrow-circle-down', 'active' => request()->segment(3) == 'product-purchase-report']
                            );

                            $sub->url(
                                action('Lab\LaboratoryReportController@getproductSellReport'),
                                __('lang_v1.product_sell_report'),
                                ['icon' => 'fa fas fa-arrow-circle-up', 'active' => request()->segment(3) == 'product-sell-report']
                            );

                            $sub->url(
                                action('Lab\LaboratoryReportController@purchasePaymentReport'),
                                __('lang_v1.purchase_payment_report'),
                                ['icon' => 'fa fas fa-search-dollar', 'active' => request()->segment(3) == 'purchase-payment-report']
                            );

                            $sub->url(
                                action('Lab\LaboratoryReportController@sellPaymentReport'),
                                __('lang_v1.sell_payment_report'),
                                ['icon' => 'fa fas fa-search-dollar', 'active' => request()->segment(3) == 'sell-payment-report']
                            );
                        }
                        if (auth()->user()->can('lab_expense_report.view')) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@getExpenseReport'),
                                __('report.expense_report'),
                                ['icon' => 'fa fas fa-search-minus', 'active' => request()->segment(3) == 'expense-report']
                            );
                        }
                        if (auth()->user()->can('lab_register_report.view')) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@getRegisterReport'),
                                __('report.register_report'),
                                ['icon' => 'fa fas fa-briefcase', 'active' => request()->segment(3) == 'register-report']
                            );
                        }
                        if (auth()->user()->can('lab_sales_representative.view')) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@getSalesRepresentativeReport'),
                                __('report.sales_representative'),
                                ['icon' => 'fa fas fa-user', 'active' => request()->segment(3) == 'sales-representative-report']
                            );
                        }
                        if (auth()->user()->can('lab_purchase_n_sell_report.view') && in_array('tables', $enabled_modules)) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@getTableReport'),
                                __('restaurant.table_report'),
                                ['icon' => 'fa fas fa-table', 'active' => request()->segment(2) == 'table-report']
                            );
                        }

                        if (auth()->user()->can('lab_sales_representative.view') && in_array('service_staff', $enabled_modules)) {
                            $sub->url(
                                action('Lab\LaboratoryReportController@getServiceStaffReport'),
                                __('restaurant.service_staff_report'),
                                ['icon' => 'fa fas fa-user-secret', 'active' => request()->segment(2) == 'service-staff-report']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-chart-bar', 'id' => 'tour_step8']
                )->order(55);
            }

            //Backup menu
            if (auth()->user()->can('lab_backup')) {
                $menu->url(action('BackUpController@index'), __('lang_v1.backup'), ['icon' => 'fa fas fa-hdd', 'active' => request()->segment(2) == 'backup'])->order(60);
            }
            if (auth()->user()->can('doctor.view')) {
            $menu->url(action('Lab\DoctorCommissionController@index'), __('Doctor Commission'), ['icon' => 'fa fa-user-md"', 'active' => request()->segment(2) == 'doctor'])->order(80);
            }
            // //Modules menu
            // if (auth()->user()->can('lab_manage_modules')) {
            //     $menu->url(action('Install\ModulesController@index'), __('lang_v1.modules'), ['icon' => 'fa fas fa-plug', 'active' => request()->segment(1) == 'manage-modules'])->order(60);
            // }

            //Booking menu
            if (in_array('booking', $enabled_modules) && (auth()->user()->can('lab_crud_all_bookings') || auth()->user()->can('lab_crud_own_bookings'))) {
                $menu->url(action('Restaurant\BookingController@index'), __('restaurant.bookings'), ['icon' => 'fas fa fa-calendar-check', 'active' => request()->segment(1) == 'bookings'])->order(65);
            }

            //Kitchen menu
            if (in_array('kitchen', $enabled_modules)) {
                $menu->url(action('Restaurant\KitchenController@index'), __('restaurant.kitchen'), ['icon' => 'fa fas fa-fire', 'active' => request()->segment(1) == 'modules' && request()->segment(2) == 'kitchen'])->order(70);
            }

            //Service Staff menu
            if (in_array('service_staff', $enabled_modules)) {
                $menu->url(action('Restaurant\OrderController@index'), __('restaurant.orders'), ['icon' => 'fa fas fa-list-alt', 'active' => request()->segment(1) == 'modules' && request()->segment(2) == 'orders'])->order(75);
            }

            //Notification template menu
            // if (auth()->user()->can('lab_send_notifications')) {
            //     $menu->url(action('NotificationTemplateController@index'), __('lang_v1.notification_templates'), ['icon' => 'fa fas fa-envelope', 'active' => request()->segment(1) == 'notification-templates'])->order(80);
            // }

            //Settings Dropdown
            // if (auth()->user()->can('lab_business_settings.access') ||
            //     auth()->user()->can('lab_barcode_settings.access') ||
            //     auth()->user()->can('lab_invoice_settings.access') ||
            //     auth()->user()->can('lab_tax_rate.view') ||
            //     auth()->user()->can('lab_tax_rate.create')) {
            //     $menu->dropdown(
            //         __('business.settings'),
            //         function ($sub) use ($enabled_modules) {
            //             if (auth()->user()->can('lab_business_settings.access')) {
            //                 $sub->url(
            //                     action('BusinessController@getBusinessSettings'),
            //                     __('business.business_settings'),
            //                     ['icon' => 'fa fas fa-cogs', 'active' => request()->segment(1) == 'business', 'id' => "tour_step2"]
            //                 );
            //                 $sub->url(
            //                     action('BusinessLocationController@index'),
            //                     __('business.business_locations'),
            //                     ['icon' => 'fa fas fa-map-marker', 'active' => request()->segment(1) == 'business-location']
            //                 );
            //             }
            //             if (auth()->user()->can('lab_invoice_settings.access')) {
            //                 $sub->url(
            //                     action('InvoiceSchemeController@index'),
            //                     __('invoice.invoice_settings'),
            //                     ['icon' => 'fa fas fa-file', 'active' => in_array(request()->segment(1), ['invoice-schemes', 'invoice-layouts'])]
            //                 );
            //             }
            //             if (auth()->user()->can('lab_barcode_settings.access')) {
            //                 $sub->url(
            //                     action('BarcodeController@index'),
            //                     __('barcode.barcode_settings'),
            //                     ['icon' => 'fa fas fa-barcode', 'active' => request()->segment(1) == 'barcodes']
            //                 );
            //             }
            //             $sub->url(
            //                 action('PrinterController@index'),
            //                 __('printer.receipt_printers'),
            //                 ['icon' => 'fa fas fa-share-alt', 'active' => request()->segment(1) == 'printers']
            //             );

            //             if (auth()->user()->can('lab_tax_rate.view') || auth()->user()->can('lab_tax_rate.create')) {
            //                 $sub->url(
            //                     action('TaxRateController@index'),
            //                     __('tax_rate.tax_rates'),
            //                     ['icon' => 'fa fas fa-bolt', 'active' => request()->segment(1) == 'tax-rates']
            //                 );
            //             }

            //             if (in_array('tables', $enabled_modules) && auth()->user()->can('lab_business_settings.create')) {
            //                 $sub->url(
            //                     action('Restaurant\TableController@index'),
            //                     __('restaurant.tables'),
            //                     ['icon' => 'fa fas fa-table', 'active' => request()->segment(1) == 'modules' && request()->segment(2) == 'tables']
            //                 );
            //             }

            //             if (in_array('modifiers', $enabled_modules) && (auth()->user()->can('lab_product.view') || auth()->user()->can('lab_product.create'))) {
            //                 $sub->url(
            //                     action('Restaurant\ModifierSetsController@index'),
            //                     __('restaurant.modifiers'),
            //                     ['icon' => 'fa fas fa-pizza-slice', 'active' => request()->segment(1) == 'modules' && request()->segment(2) == 'modifiers']
            //                 );
            //             }

            //             if (in_array('types_of_service', $enabled_modules)) {
            //                 $sub->url(
            //                     action('TypesOfServiceController@index'),
            //                     __('lang_v1.types_of_service'),
            //                     ['icon' => 'fa fas fa-user-circle', 'active' => request()->segment(1) == 'types-of-service']
            //                 );
            //             }
            //         },
            //         ['icon' => 'fa fas fa-cog', 'id' => 'tour_step3']
            //     )->order(85);
            // }
        });
        
     
        return $next($request);
    }
}
