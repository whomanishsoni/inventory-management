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
                <h1><?php echo lang('App.add_product') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><a
                            href="<?php echo url('/product-management/products') ?>"><?php echo lang('App.products') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.add_product') ?></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <?= form_open(route_to('products.store'), ['id' => 'product-add', 'method' => 'post', 'autocomplete' => 'off']); ?>
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
                                        placeholder="<?= lang('App.product_name') ?>" autofocus />
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
                                        placeholder="<?= lang('App.sku_code') ?>" value="<?= esc($sku_code) ?>"
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
                                        <option value="<?= $brand->id; ?>"><?= $brand->brand_name; ?></option>
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
                                        <option value="<?= $unit->id; ?>"><?= $unit->unit_name; ?></option>
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

                        <!-- Select to Toggle Variation Display -->
                        <div class="form-group">
                            <label for="has_variation"><?= lang('App.product_type') ?></label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                                id="has_variation" name="has_variation">
                                <option value="0" selected><?= lang('App.single') ?></option>
                                <option value="1"><?= lang('App.variable') ?></option>
                            </select>
                        </div>

                        <!-- Table for Single Product Type -->
                        <div class="row" id="single_product_table">
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
                                                        step="0.01" />
                                                    <?= isset($validation) && $validation->getError('buying_price') ? '<p class="text-danger mt-2">' . esc($validation->getError('buying_price')) . '</p>' : '' ?>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="customer_price"
                                                        id="customer_price"
                                                        placeholder="<?= lang('App.customer_price') ?>" step="0.01" />
                                                    <?= isset($validation) && $validation->getError('customer_price') ? '<p class="text-danger mt-2">' . esc($validation->getError('customer_price')) . '</p>' : '' ?>
                                                </td>
                                                <td>
                                                    <select class="form-control select2 select2-danger"
                                                        id="tax_group_id" name="tax_group_id">
                                                        <option value=""><?= lang('App.select_tax_rate') ?></option>
                                                        <?php foreach ($tax_groups as $tax_group): ?>
                                                        <option value="<?= $tax_group->id; ?>"
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
                                                        readonly step="0.01" />
                                                    <?= isset($validation) && $validation->getError('tax_amount') ? '<p class="text-danger mt-2">' . esc($validation->getError('tax_amount')) . '</p>' : '' ?>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="sale_price"
                                                        id="sale_price" placeholder="<?= lang('App.sale_price') ?>"
                                                        readonly step="0.01" />
                                                    <?= isset($validation) && $validation->getError('sale_price') ? '<p class="text-danger mt-2">' . esc($validation->getError('sale_price')) . '</p>' : '' ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <!-- Variation Selection Box (Initially hidden) -->
                        <div class="form-group" id="variation_selection_box" style="display: none;">
                            <label for="variation_id"><?= lang('App.variations') ?></label>
                            <div class="select2-danger">
                                <select class="select2" data-placeholder="<?= lang('App.variations') ?>"
                                    data-dropdown-css-class="select2-danger" id="variation_id" name="variation_id"
                                    style="width: 100%;">
                                    <option value="" selected disabled><?= lang('App.select_variation')?></option>
                                    <?php foreach ($variations as $variation): ?>
                                    <option value="<?= $variation->id; ?>"><?= $variation->variation_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= isset($validation) && $validation->getError('variation_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('variation_id')) . '</p>' : '' ?>
                            </div>
                        </div>

                        <!-- Variation Values Selection Box -->
                        <div class="form-group" id="variation_values_selection_box" style="display: none;">
                            <label for="variation_values"><?= lang('App.variation_values') ?></label>
                            <div class="select2-danger">
                                <select class="select2" multiple="multiple"
                                    data-placeholder="<?= lang('App.variation_values') ?>"
                                    data-dropdown-css-class="select2-danger" id="variation_values"
                                    name="variation_values[]" style="width: 100%;">
                                    <!-- Dynamically filled via AJAX -->
                                </select>
                            </div>
                        </div>

                        <!-- Container for Variation Tables -->
                        <div id="variation_values_container"></div>

                        <!-- Product Status -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_status"><?= lang('App.product_status') ?></label>
                                    <select class="form-control" name="product_status" id="product_status">
                                        <option value="active" selected><?= lang('App.active') ?></option>
                                        <option value="inactive"><?= lang('App.inactive') ?></option>
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
        <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
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
<!-- jquery-validation -->
<script src="<?php echo assets_url('admin') ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo assets_url('admin') ?>/plugins/jquery-validation/additional-methods.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Set default options for jQuery Validation
    $.validator.setDefaults({
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback text-danger mt-2');
            if (element.closest('table').length) {
                element.closest('td').append(error);
            } else {
                element.closest('.form-group').append(error);
            }
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }
    });

    // Custom validation method for variation price check
    $.validator.addMethod("variationPriceCheck", function(value, element) {
        var buyingPrice = parseFloat($(element).closest('tr').find('input[name="variation_buying_price[]"]').val());
        var customerPrice = parseFloat(value);
        return customerPrice >= buyingPrice;
    }, "Customer price cannot be less than the buying price.");

    // Validate the form
    $('#product-add').validate({
        rules: {
            product_name: {
                required: true,
            },
            brand_id: {
                required: true,
            },
            unit_id: {
                required: true,
            },
            category_id: {
                required: true,
            },
            sub_category_id: {
                required: false,
            },
            buying_price: {
                required: true,
                number: true
            },
            customer_price: {
                required: true,
                number: true,
                singleProductPriceCheck: true
            },
            tax_group_id: {
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
            brand_id: {
                required: "Please select the brand",
            },
            unit_id: {
                required: "Please select the unit",
            },
            category_id: {
                required: "Please select the category",
            },
            sub_category_id: {
                required: "Please select the sub category",
            },
            buying_price: {
                required: "Please enter the buying price",
                number: "Please enter a valid number"
            },
            customer_price: {
                required: "Please enter the customer price",
                number: "Please enter a valid number",
                singleProductPriceCheck: "Customer price cannot be less than the buying price"
            },
            tax_group_id: {
                required: "Please select the Tax Rate",
            },
            product_status: {
                required: "Please select the product status",
            },
        },
        submitHandler: function(form) {
            // Additional code for form submission if needed
            form.submit();
        }
    });

    // Apply validation rules for each variation row dynamically
    function applyVariationValidation() {
        $('input[name="variation_product_name[]"]').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter the product name",
                }
            });
        });

        $('input[name="variation_buying_price[]"]').each(function() {
            $(this).rules("add", {
                required: true,
                number: true,
                messages: {
                    required: "Please enter the buying price",
                    number: "Please enter a valid number",
                }
            });
        });

        $('input[name="variation_customer_price[]"]').each(function() {
            $(this).rules("add", {
                required: true,
                number: true,
                variationPriceCheck: true,
                messages: {
                    required: "Please enter the customer price",
                    number: "Please enter a valid number",
                }
            });
        });

        $('select[name="variation_tax_group_id[]"]').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please select the tax group",
                }
            });
        });
    }

    // Reapply validation whenever a new row is added or values change
    $(document).on('change', '#variation_values', function() {
        applyVariationValidation();
    });

    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').find('input, select').each(function() {
            $(this).rules('remove');
        });
    });

    // Ensure product name is not empty when 'variable' is selected
    $('#has_variation').change(function() {
        var selectedValue = $(this).val();
        if (selectedValue === '1' && $.trim($('#product_name').val()) === '') {
            alert('Product name cannot be empty when variation is selected.');
            $(this).val('0'); // Reset to default if validation fails
            return false;
        }
    });

    // Apply initial validation
    applyVariationValidation();
});
</script>
<script>
$(document).ready(function() {
    var variationCounter = 0;
    var createdVariations = {};
    var createdVariationRows = {};
    var taxGroups = <?php echo json_encode($tax_groups); ?>;

    // Initialize the visibility based on the default value
    toggleVariationDisplay($('#has_variation').val());

    // Handle change event for the toggle variation select box
    $('#has_variation').change(function() {
        toggleVariationDisplay($(this).val());
    });

    function toggleVariationDisplay(value) {
        if (value === '1') {
            $('#variation_selection_box').show();
            $('#variation_values_selection_box').show();
            $('#single_product_table').hide();
        } else {
            $('#variation_selection_box').hide();
            $('#variation_values_selection_box').hide();
            $('#single_product_table').show();
            $('#variation_values_container').empty();
            createdVariations = {}; // Clear created variations
            createdVariationRows = {}; // Clear variation rows
        }
    }

    // Handle single variation selection
    $('#variation_id').change(function() {
        var selectedVariationId = $(this).val();

        // Clear any existing variation tables and selection values
        $('#variation_values_container').empty();
        $('#variation_values').empty();
        createdVariations = {};
        createdVariationRows = {};

        if (selectedVariationId) {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(route_to('products.get_variation_values')); ?>",
                data: {
                    'variation_id': selectedVariationId
                },
                dataType: 'json',
                success: function(response) {
                    if (Array.isArray(response) && response.length > 0) {
                        createdVariations[selectedVariationId] = ++variationCounter;

                        // Populate the variation values selection box
                        var $variationValuesSelect = $('#variation_values');
                        $variationValuesSelect.empty();
                        $.each(response, function(index, value) {
                            $variationValuesSelect.append(
                                '<option value="' + value.id +
                                '" data-variation-id="' + value.variation_id +
                                '">' +
                                value.variation_value + '</option>'
                            );
                        });

                        generateVariationValuesTable(response, createdVariations[
                            selectedVariationId], selectedVariationId);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching variation values:", error);
                }
            });
        }
    });

    // Fetch and manage variation values and rows
    $('#variation_values').change(function() {
        var selectedValues = $(this).val() || [];
        var variationId = $(this).find('option:selected').data('variation-id') || '';

        // Ensure variationId is a string before using substring
        variationId = String(variationId);

        var variationTableId = 'variation_values_table_' + createdVariations[variationId];

        // Remove rows for unselected values
        $('#' + variationTableId + ' tbody tr').each(function() {
            var rowValueId = $(this).find('input[name="variation_values[]"]').val();
            if (!selectedValues.includes(rowValueId)) {
                $(this).remove();
                delete createdVariationRows[rowValueId];
            }
        });

        // Add rows for newly selected values
        $.each(selectedValues, function(index, valueId) {
            if (!createdVariationRows[valueId]) {
                var valueText = $('#variation_values option[value="' + valueId + '"]').text();
                var variationSkuCode = $('#sku_code').val().trim() + '-' + variationId
                    .substring(0, 2).toUpperCase() +
                    (index + 1).toString().padStart(3, '0');
                var variationProductName = ($('#product_name').val() + ' - ' + valueText)
                    .toLowerCase();

                var newRow = '<tr>';
                newRow +=
                    '<td><input type="text" class="form-control" readonly name="variation_sku_code[]" value="' +
                    variationSkuCode + '" placeholder="Enter SKU code"></td>';
                newRow +=
                    '<td><input type="text" class="form-control variation-product-name" name="variation_product_name[]" value="' +
                    variationProductName + '" placeholder="Enter product name"></td>';
                newRow +=
                    '<td class="hidden-column"><input type="hidden" class="form-control variation-value" name="variation_values[]" value="' +
                    valueId + '"><span>' + valueText + '</span></td>';
                newRow +=
                    '<td><input type="number" name="variation_buying_price[]" class="form-control" placeholder="Enter buying price"></td>';
                newRow +=
                    '<td><input type="number" name="variation_customer_price[]" class="form-control" placeholder="Enter customer price"></td>';
                newRow +=
                    '<td><select class="form-control select2 select2-danger tax-group" name="variation_tax_group_id[]">';
                newRow += '<option value="">Select Tax Rate</option>';
                $.each(taxGroups, function(taxIndex, taxGroup) {
                    newRow += '<option value="' + taxGroup.id + '">' + taxGroup
                        .tax_group_name + '</option>';
                });
                newRow += '</select></td>';
                newRow +=
                    '<td><input type="text" name="variation_tax_amount[]" class="form-control" readonly placeholder="Tax amount"></td>';
                newRow +=
                    '<td><input type="text" name="variation_sale_price[]" class="form-control" readonly placeholder="Enter sale price"></td>';
                newRow +=
                    '<td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-trash"></i></button></td>';
                newRow += '</tr>';

                $('#' + variationTableId + ' tbody').append(newRow);
                createdVariationRows[valueId] = true;
            }
        });
    });

    function generateVariationValuesTable(variationValues, counter, variationId) {
        var tableId = 'variation_values_table_' + counter;
        var table = '<div class="table-container" id="table_container_' + counter + '">';
        table += '<table id="' + tableId + '" class="table">';
        table +=
            '<thead><tr><th><?= lang('App.sku_code') ?></th><th><?= lang('App.product_name') ?></th><th class="hidden-column"><?= lang('App.variation_name') ?></th><th><?= lang('App.buying_price') ?></th><th><?= lang('App.customer_price') ?></th><th>Tax Rate</th><th><?= lang('App.tax_amount') ?></th><th><?= lang('App.sale_price') ?></th><th><?= lang('App.action')?></th></tr></thead>';
        table += '<tbody></tbody></table></div>';
        $('#variation_values_container').append(table);
    }

    // Handle removing rows
    $(document).on('click', '.remove-row', function() {
        var row = $(this).closest('tr');
        var rowValueId = row.find('input[name="variation_values[]"]').val();
        row.remove();
        delete createdVariationRows[rowValueId];

        // Unselect the value from the variation values box
        $('#variation_values option[value="' + rowValueId + '"]').prop('selected', false);
        $('#variation_values').trigger('change'); // Trigger change event to update the UI
    });

    // Update tax amount and sale price when tax group or prices are changed
    $(document).on('change', '.tax-group', function() {
        updateRowCalculations($(this).closest('tr'));
    });

    $(document).on('input', 'input[name="variation_buying_price[]"], input[name="variation_customer_price[]"]',
        function() {
            updateRowCalculations($(this).closest('tr'));
        });

    // Calculate tax amount and sale price for single product table
    $('#buying_price, #customer_price, #tax_group_id').on('input change', function() {
        var buyingPrice = parseFloat($('#buying_price').val());
        var customerPrice = parseFloat($('#customer_price').val());
        var taxGroupId = $('#tax_group_id').val();

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
                    var taxRate = parseFloat(response.total_tax_amount);
                    if (!isNaN(taxRate)) {
                        var taxAmount = (buyingPrice * taxRate) / 100;
                        var salePrice = customerPrice + taxAmount;
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
    });

    // Function to update row calculations
    function updateRowCalculations(row) {
        var buyingPrice = parseFloat(row.find('input[name="variation_buying_price[]"]').val()) || 0;
        var customerPrice = parseFloat(row.find('input[name="variation_customer_price[]"]').val()) || 0;
        var taxGroupId = row.find('.tax-group').val();

        if (buyingPrice && customerPrice && taxGroupId) {
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
                    var taxRate = parseFloat(response.total_tax_amount);
                    if (!isNaN(taxRate)) {
                        var taxAmount = (buyingPrice * taxRate) / 100;
                        var salePrice = customerPrice + taxAmount;
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
        }
    }
});
</script>
<script>
$(document).ready(function() {
    // Fetch sub-categories based on selected category
    $('#category_id').change(function() {
        var categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(route_to('products.get_sub_categories')); ?>",
                data: {
                    'category_id': categoryId
                },
                dataType: 'json',
                success: function(response) {
                    $('#sub_category_id').empty();
                    $('#sub_category_id').append(
                        '<option value="" selected><?= lang('App.select_sub_category') ?></option>'
                    );
                    $.each(response, function(index, subCategory) {
                        $('#sub_category_id').append('<option value="' + subCategory
                            .id + '">' + subCategory.sub_category_name +
                            '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching sub-categories:", error);
                }
            });
        } else {
            $('#sub_category_id').empty();
            $('#sub_category_id').append(
                '<option value="" selected><?= lang('App.select_sub_category') ?></option>');
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>

<?= $this->endSection() ?>