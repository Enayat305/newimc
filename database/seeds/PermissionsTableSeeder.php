<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use App\User;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'user.view'],
            ['name' => 'user.create'],
            ['name' => 'user.update'],
            ['name' => 'user.delete'],

            ['name' => 'supplier.view'],
            ['name' => 'supplier.create'],
            ['name' => 'supplier.update'],
            ['name' => 'supplier.delete'],

            ['name' => 'customer.view'],
            ['name' => 'customer.create'],
            ['name' => 'customer.update'],
            ['name' => 'customer.delete'],

            ['name' => 'product.view'],
            ['name' => 'product.create'],
            ['name' => 'product.update'],
            ['name' => 'product.delete'],

            ['name' => 'purchase.view'],
            ['name' => 'purchase.create'],
            ['name' => 'purchase.update'],
            ['name' => 'purchase.delete'],

            ['name' => 'sell.view'],
            ['name' => 'sell.create'],
            ['name' => 'sell.update'],
            ['name' => 'sell.delete'],

            ['name' => 'purchase_n_sell_report.view'],
            ['name' => 'contacts_report.view'],
            ['name' => 'stock_report.view'],
            ['name' => 'tax_report.view'],
            ['name' => 'trending_product_report.view'],
            ['name' => 'register_report.view'],
            ['name' => 'sales_representative.view'],
            ['name' => 'expense_report.view'],

            ['name' => 'business_settings.access'],
            ['name' => 'barcode_settings.access'],
            ['name' => 'invoice_settings.access'],

            ['name' => 'brand.view'],
            ['name' => 'brand.create'],
            ['name' => 'brand.update'],
            ['name' => 'brand.delete'],

            ['name' => 'tax_rate.view'],
            ['name' => 'tax_rate.create'],
            ['name' => 'tax_rate.update'],
            ['name' => 'tax_rate.delete'],

            ['name' => 'unit.view'],
            ['name' => 'unit.create'],
            ['name' => 'unit.update'],
            ['name' => 'unit.delete'],

            ['name' => 'category.view'],
            ['name' => 'category.create'],
            ['name' => 'category.update'],
            ['name' => 'category.delete'],
            ['name' => 'expense.access'],

            ['name' => 'access_all_locations'],
            ['name' => 'dashboard.data'],
            ['name' => 'essentials.create_message'],
            ['name' => 'essentials.view_message'],
            ['name' => 'essentials.approve_leave'],
            ['name' => 'essentials.add_allowance_and_deduction'],
            ['name' => 'essentials.assign_todos'],
           

            ['name' => 'doctor.view'],
            ['name' => 'doctor.create'],
            ['name' => 'doctor.update'],
            ['name' => 'doctor.delete'],

            ['name' => 'lab_profit_loss_report.view'],
            ['name' => 'lab_direct_sell.access'],
            ['name' => 'lab_list_drafts'],
            ['name' => 'lab_list_quotations'],
            ['name' => 'lab_view_own_sell_only'],
            ['name' => 'lab_sell.payments'],
            ['name' => 'lab_edit_product_price_from_sale_screen'],
            ['name' => 'lab_edit_product_price_from_pos_screen'],
            ['name' => 'lab_edit_product_discount_from_sale_screen'],

            ['name' => 'lab_edit_product_discount_from_pos_screen'],
            ['name' => 'lab_discount.access'],
            ['name' => 'lab_access_shipping'],
            


            ['name' => 'lab_purchase.payments'],
            ['name' => 'lab_purchase.update_status'],



            ['name' => 'lab_roles.view'],
            ['name' => 'lab_roles.create'],
            ['name' => 'lab_roles.update'],
            ['name' => 'lab_roles.delete'],


            ['name' => 'lab_test_report.view'],
            ['name' => 'lab_test_report.create'],
            ['name' => 'lab_test_report.update'],
            ['name' => 'lab_test_report.delete'],

            ['name' => 'vaccine.view'],
            ['name' => 'vaccine.create'],
            ['name' => 'vaccine.update'],
            ['name' => 'vaccine.delete'],


            ['name' => 'testparticular.view'],
            ['name' => 'testparticular.create'],
            ['name' => 'testparticular.update'],
            ['name' => 'testparticular.delete'],

            ['name' => 'test.view'],
            ['name' => 'test.create'],
            ['name' => 'test.update'],
            ['name' => 'test.delete'],

            ['name' => 'schedule.view'],
            ['name' => 'schedule.create'],
            ['name' => 'schedule.update'],
            ['name' => 'schedule.delete'],

            
            ['name' => 'prescription.view'],
            ['name' => 'prescription.create'],
            ['name' => 'prescription.update'],
            ['name' => 'prescription.delete'],

            ['name' => 'phychiatrichistory.view'],
            ['name' => 'phychiatrichistory.create'],
            ['name' => 'phychiatrichistory.update'],
            ['name' => 'phychiatrichistory.delete'],



            ['name' => 'patient.view'],
            ['name' => 'patient.create'],
            ['name' => 'patient.update'],
            ['name' => 'patient.delete'],

            ['name' => 'pathologicalhistory.view'],
            ['name' => 'pathologicalhistory.create'],
            ['name' => 'pathologicalhistory.update'],
            ['name' => 'pathologicalhistory.delete'],

            ['name' => 'nonpathologicalhistory.view'],
            ['name' => 'nonpathologicalhistory.create'],
            ['name' => 'nonpathologicalhistory.update'],
            ['name' => 'nonpathologicalhistory.delete'],

            ['name' => 'multi_report.view'],
            ['name' => 'multi_report.create'],
            ['name' => 'multi_report.update'],
            ['name' => 'multi_report.delete'],

            ['name' => 'familyhistory.view'],
            ['name' => 'familyhistory.create'],
            ['name' => 'familyhistory.update'],
            ['name' => 'familyhistory.delete'],


            ['name' => 'diet.view'],
            ['name' => 'diet.create'],
            ['name' => 'diet.update'],
            ['name' => 'diet.delete'],
            

            ['name' => 'lab_department.view'],
            ['name' => 'lab_department.create'],
            ['name' => 'lab_department.update'],
            ['name' => 'lab_department.delete'],


            ['name' => 'allergie.view'],
            ['name' => 'allergie.create'],
            ['name' => 'allergie.update'],
            ['name' => 'allergie.delete'],

            ['name' => 'appointment.view'],
            ['name' => 'appointment.create'],
            ['name' => 'appointment.update'],
            ['name' => 'appointment.delete'],

            ['name' => 'lab_user.view'],
            ['name' => 'lab_user.create'],
            ['name' => 'lab_user.update'],
            ['name' => 'lab_user.delete'],

            ['name' => 'lab_supplier.view'],
            ['name' => 'lab_supplier.create'],
            ['name' => 'lab_supplier.update'],
            ['name' => 'lab_supplier.delete'],

            ['name' => 'lab_customer.view'],
            ['name' => 'lab_customer.create'],
            ['name' => 'lab_customer.update'],
            ['name' => 'lab_customer.delete'],

            ['name' => 'lab_product.view'],
            ['name' => 'lab_product.create'],
            ['name' => 'lab_product.update'],
            ['name' => 'lab_product.delete'],

            ['name' => 'lab_purchase.view'],
            ['name' => 'lab_purchase.create'],
            ['name' => 'lab_purchase.update'],
            ['name' => 'lab_purchase.delete'],

            ['name' => 'lab_sell.view'],
            ['name' => 'lab_sell.create'],
            ['name' => 'lab_sell.update'],
            ['name' => 'lab_sell.delete'],

            ['name' => 'lab_purchase_n_sell_report.view'],
            ['name' => 'lab_contacts_report.view'],
            ['name' => 'lab_stock_report.view'],
            ['name' => 'lab_tax_report.view'],
            ['name' => 'lab_trending_product_report.view'],
            ['name' => 'lab_register_report.view'],
            ['name' => 'lab_sales_representative.view'],
            ['name' => 'lab_expense_report.view'],

            ['name' => 'lab_business_settings.access'],
            ['name' => 'lab_barcode_settings.access'],
            ['name' => 'lab_invoice_settings.access'],

            ['name' => 'lab_brand.view'],
            ['name' => 'lab_brand.create'],
            ['name' => 'lab_brand.update'],
            ['name' => 'lab_brand.delete'],

            ['name' => 'lab_tax_rate.view'],
            ['name' => 'lab_tax_rate.create'],
            ['name' => 'lab_tax_rate.update'],
            ['name' => 'lab_tax_rate.delete'],

            ['name' => 'lab_unit.view'],
            ['name' => 'lab_unit.create'],
            ['name' => 'lab_unit.update'],
            ['name' => 'lab_unit.delete'],

            ['name' => 'lab_category.view'],
            ['name' => 'lab_category.create'],
            ['name' => 'lab_category.update'],
            ['name' => 'lab_category.delete'],
            ['name' => 'lab_expense.access'],

            ['name' => 'lab_access_all_locations'],
            ['name' => 'lab_dashboard.data'],



            ['name' => 'user.view'],
            ['name' => 'user.create'],
            ['name' => 'user.update'],
            ['name' => 'user.delete'],

            ['name' => 'supplier.view'],
            ['name' => 'supplier.create'],
            ['name' => 'supplier.update'],
            ['name' => 'supplier.delete'],

            ['name' => 'customer.view'],
            ['name' => 'customer.create'],
            ['name' => 'customer.update'],
            ['name' => 'customer.delete'],

            ['name' => 'product.view'],
            ['name' => 'product.create'],
            ['name' => 'product.update'],
            ['name' => 'product.delete'],

            ['name' => 'purchase.view'],
            ['name' => 'purchase.create'],
            ['name' => 'purchase.update'],
            ['name' => 'purchase.delete'],

            ['name' => 'sell.view'],
            ['name' => 'sell.create'],
            ['name' => 'sell.update'],
            ['name' => 'sell.delete'],

            ['name' => 'purchase_n_sell_report.view'],
            ['name' => 'contacts_report.view'],
            ['name' => 'stock_report.view'],
            ['name' => 'tax_report.view'],
            ['name' => 'trending_product_report.view'],
            ['name' => 'register_report.view'],
            ['name' => 'sales_representative.view'],
            ['name' => 'expense_report.view'],

            ['name' => 'business_settings.access'],
            ['name' => 'barcode_settings.access'],
            ['name' => 'invoice_settings.access'],

            ['name' => 'brand.view'],
            ['name' => 'brand.create'],
            ['name' => 'brand.update'],
            ['name' => 'brand.delete'],

            ['name' => 'tax_rate.view'],
            ['name' => 'tax_rate.create'],
            ['name' => 'tax_rate.update'],
            ['name' => 'tax_rate.delete'],

            ['name' => 'unit.view'],
            ['name' => 'unit.create'],
            ['name' => 'unit.update'],
            ['name' => 'unit.delete'],

            ['name' => 'category.view'],
            ['name' => 'category.create'],
            ['name' => 'category.update'],
            ['name' => 'category.delete'],
            ['name' => 'expense.access'],

            ['name' => 'access_all_locations'],
            ['name' => 'dashboard.data'],

        ];

        $insert_data = [];
        $time_stamp = \Carbon::now()->toDateTimeString();
        foreach ($data as $d) {
            $d['guard_name'] = 'web';
            $d['created_at'] = $time_stamp;
            $insert_data[] = $d;
        }
        Permission::insert($insert_data);
        // $user = User::find(1);
        // $business_id=1;
        // //create Admin role and assign to user
        // $role = Role::create([ 'name' => 'Admin#' . $business_id,
        //                     'business_id' => $business_id,
        //                     'guard_name' => 'web', 'is_default' => 1
        //                 ]);
        // $user->assignRole($role->name);

        // //Create Cashier role for a new business
        // $cashier_role = Role::create([ 'name' => 'Cashier#' . $business_id,
        //                     'business_id' => $business_id,
        //                     'guard_name' => 'web'
        //                 ]);
        // $cashier_role->syncPermissions(['sell.view', 'sell.create', 'sell.update', 'sell.delete', 'access_all_locations']);

    }
}
