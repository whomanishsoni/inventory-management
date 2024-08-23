<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<style>
.table-container {
    overflow-x: auto;
    margin-bottom: 20px;
    /* Add some space below the table */
}

.table {
    min-width: 1000px;
    /* Adjust based on your table's width */
    border-collapse: collapse;
}

.table th,
.table td {
    white-space: nowrap;
    /* Prevent text from wrapping */
}

.hidden-column {
    display: none;
}
</style>

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
    <?= form_open(route_to('products.update', $product->id), ['id' => 'product-edit', 'method' => 'post', 'autocomplete' => 'off']); ?>
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
                                        value="<?= esc($product->product_name) ?>" autofocus />
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
                                        placeholder="<?= lang('App.sku_code') ?>" value="<?= esc($product->sku_code) ?>"
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
                                            <?= $product->brand_id == $brand->id ? 'selected' : ''; ?>>
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
                                            <?= $product->unit_id == $unit->id ? 'selected' : ''; ?>>
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
                                        <option value="<?= $category->id; ?>"
                                            <?= $product->category_id == $category->id ? 'selected' : ''; ?>>
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
                                        <?php foreach ($sub_categories as $sub_category): ?>
                                        <option value="<?= $sub_category->id; ?>"
                                            <?= $product->sub_category_id == $sub_category->id ? 'selected' : ''; ?>>
                                            <?= $sub_category->sub_category_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= isset($validation) && $validation->getError('sub_category_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('sub_category_id')) . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Select to Toggle Variation Display -->
                        <div class="form-group">
                            <label for="has_variation"><?= lang('App.product_type') ?></label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                                id="has_variation" name="has_variation">
                                <option value="0" <?= $product->has_variation == 0 ? 'selected' : ''; ?>>
                                    <?= lang('App.single') ?></option>
                                <option value="1" <?= $product->has_variation == 1 ? 'selected' : ''; ?>>
                                    <?= lang('App.variable') ?></option>
                            </select>
                        </div>

                        <!-- Variation Selection Box -->
                        <div class="form-group" id="variation_selection_box"
                            <?= $product->has_variation == 0 ? 'style="display:none;"' : ''; ?>>
                            <label for="variation_id"><?= lang('App.variations') ?></label>
                            <div class="select2-danger">
                                <select class="select2" multiple="multiple"
                                    data-placeholder="<?= lang('App.variations') ?>"
                                    data-dropdown-css-class="select2-danger" id="variation_id" name="variation_id[]"
                                    style="width: 100%;">
                                    <?php foreach ($variations as $variation): ?>
                                    <option value="<?= $variation->id; ?>"
                                        <?= in_array($variation->id, array_column($product_variations, 'variation_id')) ? 'selected' : ''; ?>>
                                        <?= $variation->variation_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= isset($validation) && $validation->getError('variation_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('variation_id')) . '</p>' : '' ?>
                            </div>
                        </div>

                        <!-- Variation Values Selection Box -->
                        <div class="form-group" id="variation_values_selection_box"
                            <?= $product->has_variation == 0 ? 'style="display:none;"' : ''; ?>>
                            <label for="variation_values"><?= lang('App.variation_values') ?></label>
                            <div class="select2-danger">
                                <select class="select2" multiple="multiple"
                                    data-placeholder="<?= lang('App.variation_values') ?>"
                                    data-dropdown-css-class="select2-danger" id="variation_values"
                                    name="variation_values[]" style="width: 100%;">

                                </select>
                                <?= isset($validation) && $validation->getError('variation_values') ? '<p class="text-danger mt-2">' . esc($validation->getError('variation_values')) . '</p>' : '' ?>
                            </div>
                        </div>

                        <!-- Table for Single Product Type -->
                        <div class="row" id="single_product_table"
                            <?= $product->has_variation == 1 ? 'style="display:none;"' : ''; ?>>
                            <div class="col-md-12">
                                <div class="table-container">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?= lang('App.buying_price') ?></th>
                                                <th><?= lang('App.customer_price') ?></th>
                                                <th><?= lang('App.tax_rate') ?></th>
                                                <th><?= lang('App.tax_amount') ?></th>
                                                <th><?= lang('App.sale_price') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>   
                                                    
                                                    <input type="number" class="form-control" name="buying_price"
                                                        id="buying_price" placeholder="<?= lang('App.buying_price') ?>"
                                                        step="0.01" value="<?= esc($product->buying_price) ?>" />
                                                    <?= isset($validation) && $validation->getError('buying_price') ? '<p class="text-danger mt-2">' . esc($validation->getError('buying_price')) . '</p>' : '' ?>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="customer_price"
                                                        id="customer_price"
                                                        placeholder="<?= lang('App.customer_price') ?>" step="0.01"
                                                        value="<?= esc($product->customer_price) ?>" />
                                                    <?= isset($validation) && $validation->getError('customer_price') ? '<p class="text-danger mt-2">' . esc($validation->getError('customer_price')) . '</p>' : '' ?>
                                                </td>
                                                <td>
                                                    <select class="form-control select2 select2-danger"
                                                        id="tax_group_id" name="tax_group_id">
                                                        <option value=""><?= lang('App.select_tax_rate') ?></option>
                                                        <?php foreach ($tax_groups as $tax_group): ?>
                                                        <option value="<?= $tax_group->id; ?>"
                                                            <?= $product->tax_group_id == $tax_group->id ? 'selected' : ''; ?>
                                                            data-tax-rate="<?= $tax_group->tax_group_name; ?>">
                                                            <?= $tax_group->tax_group_name; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?= isset($validation) && $validation->getError('select_tax_rate') ? '<p class="text-danger mt-2">' . esc($validation->getError('select_tax_rate')) . '</p>' : '' ?>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="tax_amount"
                                                        id="tax_amount" placeholder="<?= lang('App.tax_amount') ?>"
                                                        readonly step="0.01" value="<?= esc($product->tax_amount) ?>" />
                                                    <?= isset($validation) && $validation->getError('tax_amount') ? '<p class="text-danger mt-2">' . esc($validation->getError('tax_amount')) . '</p>' : '' ?>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="sale_price"
                                                        id="sale_price" placeholder="<?= lang('App.sale_price') ?>"
                                                        readonly step="0.01" value="<?= esc($product->sale_price) ?>" />
                                                    <?= isset($validation) && $validation->getError('sale_price') ? '<p class="text-danger mt-2">' . esc($validation->getError('sale_price')) . '</p>' : '' ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Table for Variable Product Type -->
                        <div class="row" id="variable_product_table"
                            <?= $product->has_variation == 0 ? 'style="display:none;"' : ''; ?>>
                            <div class="col-md-12">
                                <div class="table-container">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?= lang('App.sku_code') ?></th>
                                                <th><?= lang('App.product_name') ?></th>
                                                <th><?= lang('App.buying_price') ?></th>
                                                <th><?= lang('App.customer_price') ?></th>
                                                <th><?= lang('App.tax_rate') ?></th>
                                                <th><?= lang('App.tax_amount') ?></th>
                                                <th><?= lang('App.sale_price') ?></th>
                                                <th><?= lang('App.status') ?></th>
                                                <th><?= lang('App.actions') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="variation_table">
                                            <?php foreach ($product_variations as $variation): ?>
                                           <tr>
                                           <input type="hidden" name="variation_value_id[]" value="<?= esc($variation->variation_value_id) ?>">
                                                <td>
                                                    <input type="text" class="form-control" name="variation_sku_code[]"
                                                        value="<?= esc($variation->variation_sku_code) ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        name="variation_product_name[]"
                                                        value="<?= esc($variation->variation_product_name) ?>" />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        name="variation_buying_price[]"
                                                        value="<?= esc($variation->variation_buying_price) ?>"
                                                        step="0.01" />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        name="variation_customer_price[]"
                                                        value="<?= esc($variation->variation_customer_price) ?>"
                                                        step="0.01" />
                                                </td>
                                                <td>
                                                    <select class="form-control select2 select2-danger"
                                                        data-dropdown-css-class="select2-danger"
                                                        name="variation_tax_group_id[]">
                                                        <option value=""><?= lang('App.select_tax_rate') ?></option>
                                                        <?php foreach ($tax_groups as $tax_group): ?>
                                                        <option value="<?= $tax_group->id; ?>"
                                                            <?= $variation->variation_tax_group_id == $tax_group->id ? 'selected' : ''; ?>
                                                            data-tax-rate="<?= $tax_group->tax_group_name; ?>">
                                                            <?= $tax_group->tax_group_name; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        name="variation_tax_amount[]"
                                                        value="<?= esc($variation->variation_tax_amount) ?>" 
                                                        readonly step="0.01" />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        name="variation_sale_price[]"
                                                        value="<?= esc($variation->variation_sale_price) ?>" 
                                                        readonly step="0.01" />
                                                </td>
                                                <td>
                                                    <select class="form-control select2 select2-danger"
                                                        data-dropdown-css-class="select2-danger"
                                                        name="variation_status[]">
                                                        <option value="1"
                                                            <?= $variation->product_variation_status == 1 ? 'selected' : ''; ?>>
                                                            <?= lang('App.active') ?></option>
                                                        <option value="0"
                                                            <?= $variation->product_variation_status == 0 ? 'selected' : ''; ?>>
                                                            <?= lang('App.inactive') ?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-row"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-left">
                            <button type="submit" class="btn btn-primary"><?= lang('App.update_product') ?></button>
                                <a href="<?= route_to('products.index') ?>"
                                    class="btn btn-danger"><?= lang('App.cancel') ?></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
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
</script>

<script>
$(document).ready(function() {
    // Toggle between Single and Variable product type
    $('#has_variation').change(function() {
        if ($(this).val() === '1') {
            $('#variation_selection_box, #variation_values_selection_box, #variable_product_table').show();
            $('#single_product_table').hide();
        } else {
            $('#variation_selection_box, #variation_values_selection_box, #variable_product_table').hide();
            $('#single_product_table').show();
        }
    });

    // Calculate Tax Amount and Sale Price for Single Product
    $('#tax_group_id, #buying_price, #customer_price').on('change', function() {
        updateSingleProductPricing();
    });

    // Calculate Tax Amount and Sale Price for Variable Product
    $('body').on('change', 
        'select[name="variation_tax_group_id[]"], input[name="variation_buying_price[]"], input[name="variation_customer_price[]"]', 
        function() {
            let row = $(this).closest('tr');
            updateRowCalculations(row);
        }
    );

    // Pre-fill Sub-Categories based on Category
    $('#category_id').change(function() {
        let categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                type: "GET",
                url: "<?= site_url(route_to('products.get_sub_categories')) ?>",
                data: { 'category_id': categoryId },
                dataType: 'json',
                success: function(response) {
                    $('#sub_category_id').empty().append('<option value="" selected><?= lang('App.select_sub_category') ?></option>');
                    $.each(response, function(index, subCategory) {
                        $('#sub_category_id').append('<option value="' + subCategory.id + '">' + subCategory.sub_category_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching sub-categories:", error);
                }
            });
        } else {
            $('#sub_category_id').empty().append('<option value="" selected><?= lang('App.select_sub_category') ?></option>');
        }
    });

    // Fetch and populate variation values based on selected variations
    $('#variation_id').change(function() {
        var selectedVariations = $(this).val() || [];

        // Remove tables for unselected variations
        $.each(createdVariations, function(variationId, counter) {
            if (!selectedVariations.includes(variationId)) {
                $('#table_container_' + counter).remove();
                delete createdVariations[variationId];
            }
        });

        // Fetch and populate variation values for selected variations
        $.each(selectedVariations, function(index, variationId) {
            if (variationId && !createdVariations[variationId]) {
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url(route_to('products.get_variation_values')); ?>",
                    data: { 'variation_id': variationId },
                    dataType: 'json',
                    success: function(response) {
                        if (Array.isArray(response) && response.length > 0) {
                            populateVariationValues(response, variationId);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching variation values:", error);
                    }
                });
            }
        });
    });

    // Handle changes to tax group or prices
    $(document).on('change', '.tax-group', function () {
        updateRowCalculations($(this).closest('tr'));
    });

    $(document).on('input', 'input[name="variation_buying_price[]"], input[name="variation_customer_price[]"]', function () {
        updateRowCalculations($(this).closest('tr'));
    });

    // Calculate tax amount and sale price for single product table
    $('#buying_price, #customer_price, #tax_group_id').on('input change', function () {
        updateSingleProductPricing();
    });

    // Remove variation row
    $('body').on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });

// Function to update row calculations
function updateRowCalculations(row) {
    let buyingPrice = parseFloat(row.find('input[name="variation_buying_price[]"]').val()) || 0;
    let customerPrice = parseFloat(row.find('input[name="variation_customer_price[]"]').val()) || 0;
    let taxGroupId = row.find('select[name="variation_tax_group_id[]"]').val();

    // Ensure that tax group ID is selected and prices are valid
    if (taxGroupId && buyingPrice > 0 && customerPrice > 0) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(route_to('products.get_tax_rate')); ?>",
            data: {
                tax_group_id: taxGroupId,
                customer_price: customerPrice,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response && !isNaN(response.total_tax_amount)) {
                    let taxRate = parseFloat(response.total_tax_amount);
                    let taxAmount = (customerPrice * taxRate) / 100;
                    let salePrice = customerPrice + taxAmount;

                    row.find('input[name="variation_tax_amount[]"]').val(taxAmount.toFixed(2));
                    row.find('input[name="variation_sale_price[]"]').val(salePrice.toFixed(2));
                } else {
                    row.find('input[name="variation_tax_amount[]"]').val('');
                    row.find('input[name="variation_sale_price[]"]').val('');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error updating row calculations:", error);
            }
        });
    } else {
        // Clear the fields if data is invalid or missing
        row.find('input[name="variation_tax_amount[]"]').val('');
        row.find('input[name="variation_sale_price[]"]').val('');
    }
}


    // Function to update single product pricing
    function updateSingleProductPricing() {
        let buyingPrice = parseFloat($('#buying_price').val());
        let customerPrice = parseFloat($('#customer_price').val());
        let taxGroupId = $('#tax_group_id').val();

        if (!isNaN(buyingPrice) && !isNaN(customerPrice) && taxGroupId) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(route_to('products.get_tax_rate')); ?>",
                data: {
                    tax_group_id: taxGroupId,
                    customer_price: customerPrice,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(response) {
                    let taxRate = parseFloat(response.total_tax_amount);
                    if (!isNaN(taxRate)) {
                        let taxAmount = (buyingPrice * taxRate) / 100;
                        let salePrice = customerPrice + taxAmount;
                        $('#tax_amount').val(taxAmount.toFixed(2));
                        $('#sale_price').val(salePrice.toFixed(2));
                    } else {
                        $('#tax_amount').val('');
                        $('#sale_price').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error calculating tax amount and sale price:", error);
                }
            });
        }
    }
    // Function to update variation product pricing
function updateVariationProductPricing() {
    $('#variation_table').find('tr').each(function() {
        let buyingPrice = parseFloat($(this).find('input[name^="variation_buying_price"]').val());
        let customerPrice = parseFloat($(this).find('input[name^="variation_customer_price"]').val());
        let taxGroupId = $(this).find('select[name^="variation_tax_group_id"]').val();

        if (!isNaN(buyingPrice) && !isNaN(customerPrice) && taxGroupId) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(route_to('products.get_tax_rate')); ?>",
                data: {
                    tax_group_id: taxGroupId,
                    customer_price: customerPrice,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(response) {
                    let taxRate = parseFloat(response.total_tax_amount);
                    if (!isNaN(taxRate)) {
                        let taxAmount = (buyingPrice * taxRate) / 100;
                        let salePrice = customerPrice + taxAmount;
                        $(this).find('input[name^="variation_tax_amount"]').val(taxAmount.toFixed(2));
                        $(this).find('input[name^="variation_sale_price"]').val(salePrice.toFixed(2));
                    } else {
                        $(this).find('input[name^="variation_tax_amount"]').val('');
                        $(this).find('input[name^="variation_sale_price"]').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error calculating tax amount and sale price:", error);
                }
            });
        }
    });
}

    // Function to populate variation values
    function populateVariationValues(response, variationId) {
        var $variationValuesSelect = $('#variation_values');
        $variationValuesSelect.empty();
        $.each(response, function(index, value) {
            $variationValuesSelect.append('<option value="' + value.id + '" data-variation-id="' + value.variation_id + '">' + value.variation_value + '</option>');
        });

        createdVariations[variationId] = ++variationCounter;
        generateVariationValuesTable(response, createdVariations[variationId], variationId);
    }
});
</script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<?= $this->endSection() ?>