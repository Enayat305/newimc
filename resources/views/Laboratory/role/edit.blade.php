@extends('lab_layouts.app')
@section('title', __('role.edit_role'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>@lang( 'role.edit_role' )</h1>
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        {!! Form::open(['url' => action('Lab\RoleController@update', [$role->id]), 'method' => 'PUT', 'id' => 'role_form' ]) !!}
        <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            {!! Form::label('name', __( 'user.role_name' ) . ':*') !!}
              {!! Form::text('name', str_replace( '#' . auth()->user()->business_id, '', $role->name) , ['class' => 'form-control', 'required', 'placeholder' => __( 'user.role_name' ) ]); !!}
          </div>
        </div>
        </div>
        @if(in_array('lab_service_staff', $enabled_modules))
        <div class="row">
        <div class="col-md-2">
          <h4>@lang( 'lang_v1.user_type' )</h4>
        </div>
        <div class="col-md-9 col-md-offset-1">
          <div class="col-md-12">
          <div class="checkbox">
            <label>
              {!! Form::checkbox('is_service_staff', 1, $role->is_service_staff, 
              [ 'class' => 'input-icheck']); !!} {{ __( 'restaurant.service_staff' ) }}
            </label>
            @show_tooltip(__('restaurant.tooltip_service_staff'))
          </div>
          </div>
        </div>
        </div>
        @endif
        <div class="row">
        <div class="col-md-3">
          <label>@lang( 'user.permissions' ):</label> 
        </div>
        </div>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'role.user' )</h4>
        </div>
        <div class="col-md-2">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_user.view', in_array('lab_user.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.user.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_user.create', in_array('lab_user.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.user.create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_user.update', in_array('lab_user.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.user.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_user.delete', in_array('lab_user.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.user.delete' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'user.roles' )</h4>
        </div>
        <div class="col-md-2">
          <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_roles.view', in_array('lab_roles.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.view_role' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_roles.create', in_array('lab_roles.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.add_role' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_roles.update', in_array('lab_roles.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.edit_role' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_roles.delete', in_array('lab_roles.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.delete_role' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'role.supplier' )</h4>
        </div>
        <div class="col-md-2">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_supplier.view', in_array('lab_supplier.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.supplier.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_supplier.create', in_array('lab_supplier.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.supplier.create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_supplier.update', in_array('lab_supplier.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.supplier.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_supplier.delete', in_array('lab_supplier.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.supplier.delete' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'role.customer' )</h4>
        </div>
        <div class="col-md-2">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_customer.view', in_array('lab_customer.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.customer.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_customer.create', in_array('lab_customer.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.customer.create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_customer.update', in_array('lab_customer.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.customer.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_customer.delete', in_array('lab_customer.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.customer.delete' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'business.product' )</h4>
        </div>
        <div class="col-md-2">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_product.view', in_array('lab_product.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.product.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_product.create', in_array('lab_product.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.product.create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_product.update', in_array('lab_product.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.product.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_product.delete', in_array('lab_product.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.product.delete' ) }}
              </label>
            </div>
          </div>
       
       
        </div>
        </div>
        <hr>
        @if(in_array('lab_purchases', $enabled_modules) || in_array('lab_stock_adjustment', $enabled_modules) )
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'role.purchase' )</h4>
        </div>
        <div class="col-md-2">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_purchase.view', in_array('lab_purchase.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_purchase.create', in_array('lab_purchase.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase.create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_purchase.update', in_array('lab_purchase.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_purchase.delete', in_array('lab_purchase.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase.delete' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_purchase.payments', in_array('lab_purchase.payments', $role_permissions),['class' => 'input-icheck']); !!}
                {{ __('lang_v1.purchase.payments') }}
              </label>
              @show_tooltip(__('lang_v1.purchase_payments'))
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_purchase.update_status', in_array('lab_purchase.update_status', $role_permissions),['class' => 'input-icheck']); !!}
                {{ __('lang_v1.update_status') }}
              </label>
            </div>
          </div>
 

        </div>
        </div>
        <hr>
        @endif
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'sale.sale' )</h4>
        </div>
        <div class="col-md-2">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_sell.view', in_array('lab_sell.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.view' ) }}
              </label>
            </div>
          </div>
         
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_sell.create', in_array('lab_sell.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.create' ) }}
              </label>
            </div>
          </div>
         
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_sell.update', in_array('lab_sell.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_sell.delete', in_array('lab_sell.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.delete' ) }}
              </label>
            </div>
          </div>
          @if(in_array('lab_add_sale', $enabled_modules))
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_direct_sell.access', in_array('lab_direct_sell.access', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.direct_sell.access' ) }}
              </label>
            </div>
          </div>
          @endif
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_list_drafts', in_array('lab_list_drafts', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.list_drafts' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_list_quotations', in_array('lab_list_quotations', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.list_quotations' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_view_own_sell_only', in_array('lab_view_own_sell_only', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.view_own_sell_only' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_sell.payments', in_array('lab_sell.payments', $role_permissions), ['class' => 'input-icheck']); !!}
                {{ __('lang_v1.sell.payments') }}
              </label>
              @show_tooltip(__('lang_v1.sell_payments'))
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_edit_product_price_from_sale_screen', in_array('lab_edit_product_price_from_sale_screen', $role_permissions), ['class' => 'input-icheck']); !!}
                {{ __('lang_v1.edit_product_price_from_sale_screen') }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_edit_product_price_from_pos_screen', in_array('lab_edit_product_price_from_pos_screen', $role_permissions), ['class' => 'input-icheck']); !!}
                {{ __('lang_v1.edit_product_price_from_pos_screen') }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_edit_product_discount_from_sale_screen', in_array('lab_edit_product_discount_from_sale_screen', $role_permissions), ['class' => 'input-icheck']); !!}
                {{ __('lang_v1.edit_product_discount_from_sale_screen') }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_edit_product_discount_from_pos_screen', in_array('lab_edit_product_discount_from_pos_screen', $role_permissions), ['class' => 'input-icheck']); !!}
                {{ __('lang_v1.edit_product_discount_from_pos_screen') }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_discount.access', in_array('lab_discount.access', $role_permissions), ['class' => 'input-icheck']); !!}
                {{ __('lang_v1.discount.access') }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_access_shipping', in_array('lab_access_shipping', $role_permissions), ['class' => 'input-icheck']); !!}
                {{ __('lang_v1.access_shipping') }}
              </label>
            </div>
          </div>
  
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'role.brand' )</h4>
        </div>
        <div class="col-md-2">
          <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_brand.view', in_array('lab_brand.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.brand.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_brand.create', in_array('lab_brand.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.brand.create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_brand.update', in_array('lab_brand.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.brand.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_brand.delete', in_array('lab_brand.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.brand.delete' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'role.tax_rate' )</h4>
        </div>
        <div class="col-md-2">
          <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_tax_rate.view', in_array('lab_tax_rate.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_rate.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_tax_rate.create', in_array('lab_tax_rate.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_rate.create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_tax_rate.update', in_array('lab_tax_rate.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_rate.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_tax_rate.delete', in_array('lab_tax_rate.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_rate.delete' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'role.unit' )</h4>
        </div>
        <div class="col-md-2">
          <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_unit.view', in_array('lab_unit.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.unit.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_unit.create', in_array('lab_unit.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.unit.create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_unit.update', in_array('lab_unit.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.unit.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_unit.delete', in_array('lab_unit.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.unit.delete' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'category.category' )</h4>
        </div>
        <div class="col-md-2">
          <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_category.view', in_array('lab_category.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.category.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_category.create', in_array('lab_category.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.category.create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_category.update', in_array('lab_category.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.category.update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_category.delete', in_array('lab_category.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.category.delete' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'role.report' )</h4>
        </div>
        <div class="col-md-2">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
        @if(in_array('lab_purchases', $enabled_modules) || in_array('lab_add_sale', $enabled_modules) || in_array('lab_pos_sale', $enabled_modules))
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_purchase_n_sell_report.view', in_array('lab_purchase_n_sell_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase_n_sell_report.view' ) }}
              </label>
            </div>
          </div>
        @endif
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_tax_report.view', in_array('lab_tax_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_report.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_contacts_report.view', in_array('lab_contacts_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.contacts_report.view' ) }}
              </label>
            </div>
          </div>
          @if(in_array('lab_expenses', $enabled_modules))
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_expense_report.view', in_array('lab_expense_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.expense_report.view' ) }}
              </label>
            </div>
          </div>
          @endif
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_profit_loss_report.view', in_array('lab_profit_loss_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.profit_loss_report.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_stock_report.view', in_array('lab_stock_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.stock_report.view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_trending_product_report.view', in_array('lab_trending_product_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.trending_product_report.view' ) }}
              </label>
            </div>
          </div>

          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_register_report.view', in_array('lab_register_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.register_report.view' ) }}
              </label>
            </div>
          </div>

          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_sales_representative.view', in_array('lab_sales_representative.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sales_representative.view' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <div class="row check_group">
        <div class="col-md-1">
          <h4>@lang( 'role.settings' )</h4>
        </div>
        <div class="col-md-2">
          <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_business_settings.access', in_array('lab_business_settings.access', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.business_settings.access' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_barcode_settings.access', in_array('lab_barcode_settings.access', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.barcode_settings.access' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_invoice_settings.access', in_array('lab_invoice_settings.access', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.invoice_settings.access' ) }}
              </label>
            </div>
          </div>
          @if(in_array('lab_expenses', $enabled_modules))
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_expense.access', in_array('lab_expense.access', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.expense.access' ) }}
              </label>
            </div>
          </div>
         
          @endif
        
        </div>
        </div>
        <hr>
        <div class="row">
        <div class="col-md-3">
          <h4>@lang( 'role.dashboard' )</h4>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_dashboard.data', in_array('lab_dashboard.data', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'role.dashboard.data' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        <hr>
        <hr>
       
        
        
        <div class="row check_group">
        <div class="col-md-1">
          <h4>Test</h4>
        </div>
        <div class="col-md-2">
          <div class="checkbox">
              <label>
                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
              </label>
            </div>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'test.view', in_array('test.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'test.create', in_array('test.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'test.update', in_array('test.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'test.delete', in_array('test.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test delete' ) }}
              </label>
            </div>
         
          <div class="checkbox">
            <label>
              {!! Form::checkbox('permissions[]', 'testparticular.view', in_array('testparticular.view', $role_permissions), 
              [ 'class' => 'input-icheck']); !!} {{ __( 'Test particular view' ) }}
            </label>
          </div>
        </div>
        <div class="col-md-12">
          <div class="checkbox">
            <label>
              {!! Form::checkbox('permissions[]', 'testparticular.create', in_array('testparticular.create', $role_permissions), 
              [ 'class' => 'input-icheck']); !!} {{ __( 'Test  particular create' ) }}
            </label>
          </div>
        </div>
        <div class="col-md-12">
          <div class="checkbox">
            <label>
              {!! Form::checkbox('permissions[]', 'testparticular.update', in_array('testparticular.update', $role_permissions), 
              [ 'class' => 'input-icheck']); !!} {{ __( 'Test particular update' ) }}
            </label>
          </div>
        </div>
        <div class="col-md-12">
          <div class="checkbox">
            <label>
              {!! Form::checkbox('permissions[]', 'testparticular.delete', in_array('testparticular.delete', $role_permissions), 
              [ 'class' => 'input-icheck']); !!} {{ __( 'Test particular delete' ) }}
            </label>
          </div>
        </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_test_report.view', in_array('lab_test_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test report view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_test_report.create', in_array('lab_test_report.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test report create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_test_report.update', in_array('lab_test_report.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test report update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_test_report.delete', in_array('lab_test_report.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test report delete' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'multi_report.view', in_array('multi_report.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test  multi report view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'multi_report.create', in_array('multi_report.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test multi report create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'multi_report.update', in_array('multi_report.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test multi report update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'multi_report.delete', in_array('multi_report.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'Test multi report delete' ) }}
              </label>
            </div>
          </div>


          
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_department.view', in_array('lab_department.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lab_department view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_department.create', in_array('lab_department.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lab_department create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_department.update', in_array('lab_department.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lab_department update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'lab_department.delete', in_array('lab_department.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'lab_department delete' ) }}
              </label>
            </div>
          </div>
        </div>
        </div>
        
        <hr>
        <div class="row check_group">
          <div class="col-md-1">
            <h4>Clanic</h4>
          </div>
          <div class="col-md-2">
            <div class="checkbox">
                <label>
                  <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                </label>
              </div>
          </div>
          <div class="col-md-9">
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'vaccine.view', in_array('vaccine.view', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'vaccine view' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'vaccine.create', in_array('vaccine.create', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'vaccine create' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'vaccine.update', in_array('vaccine.update', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'vaccine update' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'vaccine.delete', in_array('vaccine.delete', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'vaccine delete' ) }}
                </label>
              </div>
           
              
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'schedule.view', in_array('schedule.view', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'schedule view' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'schedule.create', in_array('schedule.create', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'schedule create' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'schedule.update', in_array('schedule.update', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'schedule update' ) }}
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'schedule.delete', in_array('schedule.delete', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __( 'schedule delete' ) }}
              </label>
            </div>
          </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'prescription.view', in_array('prescription.view', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'prescription view' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'prescription.create', in_array('prescription.create', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'prescription create' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'prescription.update', in_array('prescription.update', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'prescription update' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'prescription.delete', in_array('prescription.delete', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'prescription delete' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'phychiatrichistory.view', in_array('phychiatrichistory.view', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'phychiatrichistory view' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'phychiatrichistory.create', in_array('phychiatrichistory.create', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'phychiatrichistory create' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'phychiatrichistory.update', in_array('phychiatrichistory.update', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'phychiatrichistory update' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'phychiatrichistory.delete', in_array('phychiatrichistory.delete', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'phychiatrichistory delete' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'patient.view', in_array('patient.view', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'patient view' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'patient.create', in_array('patient.create', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'patient create' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'patient.update', in_array('patient.update', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'patient update' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'patient.delete', in_array('patient.delete', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'patient delete' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'pathologicalhistory.view', in_array('pathologicalhistory.view', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'pathologicalhistory view' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'pathologicalhistory.create', in_array('pathologicalhistory.create', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'pathologicalhistory create' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'pathologicalhistory.update', in_array('pathologicalhistory.update', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'pathologicalhistory update' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'pathologicalhistory.delete', in_array('pathologicalhistory.delete', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'pathologicalhistory delete' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'familyhistory.view', in_array('familyhistory.view', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'familyhistory view' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'familyhistory.create', in_array('familyhistory.create', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'familyhistory create' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'familyhistory.update', in_array('familyhistory.update', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'familyhistory update' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'familyhistory.delete', in_array('familyhistory.delete', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'familyhistory delete' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'diet.view', in_array('diet.view', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'diet view' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'diet.create', in_array('diet.create', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'diet create' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'diet.update', in_array('diet.update', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'diet update' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'diet.delete', in_array('diet.delete', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'diet delete' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'allergie.view', in_array('allergie.view', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'allergie view' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'allergie.create', in_array('allergie.create', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'allergie create' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'allergie.update', in_array('allergie.update', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'allergie update' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'allergie.delete', in_array('allergie.delete', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'allergie delete' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'appointment.view', in_array('appointment.view', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'appointment view' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'appointment.create', in_array('appointment.create', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'appointment create' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'appointment.update', in_array('appointment.update', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'appointment update' ) }}
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('permissions[]', 'appointment.delete', in_array('appointment.delete', $role_permissions), 
                  [ 'class' => 'input-icheck']); !!} {{ __( 'appointment delete' ) }}
                </label>
              </div>
            </div>
          </div>
          </div>
          <hr>
        <div class="row">
        <div class="col-md-3">
          <h4>@lang( 'lang_v1.access_selling_price_groups' )</h4>
        </div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('permissions[]', 'access_default_selling_price', in_array('access_default_selling_price', $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ __('lang_v1.default_selling_price') }}
              </label>
            </div>
          </div>
          @if(count($selling_price_groups) > 0)
          @foreach($selling_price_groups as $selling_price_group)
          <div class="col-md-12">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('spg_permissions[]', 'selling_price_group.' . $selling_price_group->id, in_array('selling_price_group.' . $selling_price_group->id, $role_permissions), 
                [ 'class' => 'input-icheck']); !!} {{ $selling_price_group->name }}
              </label>
            </div>
          </div>
          @endforeach
          @endif
        </div>
        </div>
    
        @include('Laboratory/role.partials.module_permissions')
        <div class="row">
        <div class="col-md-12">
           <button type="submit" class="btn btn-primary pull-right">@lang( 'messages.update' )</button>
        </div>
        </div>

        {!! Form::close() !!}
    @endcomponent
</section>
<!-- /.content -->
@endsection