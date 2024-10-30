<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.edit_product') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo url('/product-management/products') ?>"><?php echo lang('App.products') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.edit_product') ?></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <?= form_open(route_to('products.update', $product->id), ['id' => 'product-edit', 'method' => 'put', 'autocomplete' => 'off']); ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Left column -->
            <div class="col-md-12">
                <!-- Variations -->
                <div class="card">
                    <div class="card-body">
                        <!-- Product -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_name"><?= lang('App.product_name') ?></label>
                                    <input type="text" class="form-control" name="product_name" id="product_name"
                                        placeholder="<?= lang('App.product_name') ?>"
                                        value="<?= $product->product_name ?>" autofocus />
                                    <?= isset($validation) && $validation->getError('product_name') ? '<p class="text-danger mt-2">' . esc($validation->getError('product_name')) . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- SKU Code -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sku_code"><?= lang('App.sku_code') ?></label>
                                    <input type="text" class="form-control" name="sku_code" id="sku_code"
                                        placeholder="<?= lang('App.sku_code') ?>" value="<?= $product->sku_code ?>"
                                        readonly />
                                </div>
                            </div>
                        </div>

                        <!-- Brand -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="brand_id"><?= lang('App.brand_name') ?></label>
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="brand_id" name="brand_id">
                                        <option value="" selected><?= lang('App.select_brand') ?></option>
                                        <?php foreach ($brands as $brand): ?>
                                        <option value="<?= $brand->id; ?>"
                                            <?= $product->brand_id == $brand->id ? 'selected' : '' ?>>
                                            <?= $brand->brand_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= isset($validation) && $validation->getError('brand_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('brand_id')) . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Unit -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit_id"><?= lang('App.unit') ?></label>
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="unit_id" name="unit_id">
                                        <option value="" selected><?= lang('App.select_unit') ?></option>
                                        <?php foreach ($units as $unit): ?>
                                        <option value="<?= $unit->id; ?>"
                                            <?= $product->unit_id == $unit->id ? 'selected' : '' ?>>
                                            <?= $unit->unit_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= isset($validation) && $validation->getError('unit_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('unit_id')) . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Category & Sub-Category -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id"><?= lang('App.category') ?></label>
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="category_id" name="category_id">
                                        <option value="" selected><?= lang('App.select_category') ?></option>
                                        <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->id; ?>"><?= $category->category_name; ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->id; ?>"
                                            <?= $product->category_id == $category->id ? 'selected' : '' ?>>
                                            <?= $category->category_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= isset($validation) && $validation->getError('category_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('category_id')) . '</p>' : '' ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sub_category_id"><?= lang('App.sub_category') ?></label>
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="sub_category_id"
                                        name="sub_category_id">
                                        <option value="" selected><?= lang('App.select_sub_category') ?></option>
                                    </select>
                                    <?= isset($validation) && $validation->getError('sub_category_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('sub_category_id')) . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Product Status -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_status"><?= lang('App.product_status') ?></label>
                                    <select class="form-control" name="product_status" id="product_status">
                                        <option value="active"
                                            <?= $product->product_status == 'active' ? 'selected' : '' ?>>
                                            <?= lang('App.active') ?></option>
                                        <option value="inactive"
                                            <?= $product->product_status == 'inactive' ? 'selected' : '' ?>>
                                            <?= lang('App.inactive') ?></option>
                                    </select>
                                    <?= isset($validation) && $validation->getError('product_status') ? '<p class="text-danger mt-2">' . esc($validation->getError('product_status')) . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col (left) -->
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.update') ?></button>
        <a href="<?= url('/product-management/products') ?>" onclick="return confirm('Are you sure you want to leave?')"
            class="btn btn-flat btn-danger">
            <?= lang('App.cancel') ?>
        </a>
    </div>
    <?= form_close(); ?>
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<!-- Include jQuery Validation -->
<script src="<?php echo assets_url('admin') ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo assets_url('admin') ?>/plugins/jquery-validation/additional-methods.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Set default options for jQuery Validation
    $.validator.setDefaults({
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    // Initialize form validation
    $('#product-edit').validate({
        rules: {
            product_name: {
                required: true,
            },
            product_status: {
                required: true,
            },
        },
        messages: {
            product_name: {
                required: "Please enter the product name",
            },
            product_status: {
                required: "Please select the product status",
            },
        },
    });
});
$('.select2').select2()
</script>
<?= $this->endSection() ?>