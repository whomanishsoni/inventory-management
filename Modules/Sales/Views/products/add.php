<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

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
                            <label for="toggle_variation"><?= lang('App.product_type') ?>:</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                                id="toggle_variation">
                                <option value="0"><?= lang('App.single') ?></option>
                                <option value="1"><?= lang('App.variable') ?></option>
                            </select>
                        </div>

                        <!-- Table for Single Product Type -->
                        <div class="row" id="single_product_table" style="display: none;">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?= lang('App.buying_price') ?></th>
                                            <th><?= lang('App.customer_price') ?></th>
                                            <th><?= lang('App.tax_rate') ?></th>
                                            <th><?= lang('App.sale_price') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="buying_price"
                                                    id="buying_price" placeholder="Buying Price" />
                                                <?= isset($validation) && $validation->getError('buying_price') ? '<p class="text-danger mt-2">' . esc($validation->getError('buying_price')) . '</p>' : '' ?>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="customer_price"
                                                    id="customer_price" placeholder="Customer Price" />
                                                <?= isset($validation) && $validation->getError('customer_price') ? '<p class="text-danger mt-2">' . esc($validation->getError('customer_price')) . '</p>' : '' ?>
                                            </td>
                                            <td>
                                                <select class="form-control select2 select2-danger" id="tax_group_id"
                                                    name="tax_group_id">
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
                                                <input type="text" class="form-control" name="sale_price"
                                                    id="sale_price" placeholder="Sale Price" readonly />
                                                <?= isset($validation) && $validation->getError('sale_price') ? '<p class="text-danger mt-2">' . esc($validation->getError('sale_price')) . '</p>' : '' ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Variation & Variation Values -->
                        <div class="row" id="variation_product_table" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="variation_id"><?= lang('App.variations') ?></label>
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="variation_id" name="variation_id">
                                        <option value="" selected><?= lang('App.select_category') ?></option>
                                        <?php foreach ($variations as $variation): ?>
                                        <option value="<?= $variation->id; ?>"><?= $variation->variation_name; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= isset($validation) && $validation->getError('variation_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('variation_id')) . '</p>' : '' ?>
                                </div>
                            </div>

                            <!-- Variation values -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="create_variation_values_table_btn" type="button"
                                        class="btn btn-primary">Create Variation Values Table</button>
                                    <div id="variation_values_container"></div>
                                    <!-- Changed ID here to handle multiple tables -->
                                </div>
                            </div>
                        </div>

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

    // Add custom validation method for single product price check
    $.validator.addMethod("singleProductPriceCheck", function(value, element) {
        var buyingPrice = parseFloat($('#buying_price').val());
        var customerPrice = parseFloat(value);
        if (!isNaN(buyingPrice) && !isNaN(customerPrice)) {
            return customerPrice >= buyingPrice;
        }
        return true;
    }, "Customer price cannot be less than the buying price");

    // Add custom validation method for variation price check
    $.validator.addMethod("variationPriceCheck", function(value, element) {
        var buyingPrice = parseFloat($(element).closest('tr').find(
            'input[name="variation_buying_price[]"]').val());
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
                required: false,
            },
            product_status: {
                required: true,
            },
            'variation_buying_price[]': {
                required: true,
                number: true,
            },
            'variation_customer_price[]': {
                required: true,
                number: true,
                variationPriceCheck: true
            }
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
            'variation_buying_price[]': {
                required: "Please enter the buying price",
                number: "Please enter a valid number",
            },
            'variation_customer_price[]': {
                required: "Please enter the customer price",
                number: "Please enter a valid number",
            }
        },
        submitHandler: function(form) {
            // Additional code for form submission if needed
            form.submit();
        }
    });
});
</script>
<script>
$(document).ready(function() {
    var variationValues = [];
    var variationCounter = 0; // To keep track of each variation table
    var maxRowsPerTable = 0;
    var createdVariations = []; // Array to track created variations

    // When the category selection changes
    $('#category_id').change(function() {
        var categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(route_to('products.get_sub_categories'));?>",
                data: {
                    'category_id': categoryId,
                },
                dataType: 'json',
                success: function(response) {
                    $('#sub_category_id').empty().append(
                        '<option value="">Select Sub Category</option>');
                    $.each(response, function(key, value) {
                        $('#sub_category_id').append('<option value="' + value.id +
                            '">' + value.sub_category_name + '</option>');
                    });
                }
            });
        } else {
            $('#sub_category_id').empty();
        }
    });

    $('#variation_id').change(function() {
        var variationId = $(this).val();
        if (variationId) {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(route_to('products.get_variation_values'));?>",
                data: {
                    'variation_id': variationId,
                },
                dataType: 'json',
                success: function(response) {
                    if (Array.isArray(response) && response.length > 0) {
                        variationValues =
                            response; // Update the global variationValues array
                        maxRowsPerTable = response.length;
                    } else {
                        $('#variation_values_id').empty();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching variation values:", error);
                    $('#variation_values_id').empty();
                }
            });
        } else {
            $('#variation_values_id').empty();
        }
    });

    // Pass tax groups data from PHP to JavaScript
    var taxGroups = <?php echo json_encode($tax_groups); ?>;

    // Function to generate variation values table dynamically
    function generateVariationValuesTable(variationValues, counter) {
        var tableId = 'variation_values_table_' + counter;
        var table = '<div class="table-container" id="table_container_' + counter + '">';
        table += '<table id="' + tableId + '" class="table">';
        table +=
            '<thead><tr><th>Variation Value</th><th>Buying Price</th><th>Customer Price</th><th>Tax Rate</th><th>Sale Price</th><th>Action</th></tr></thead>';
        table += '<tbody>';
        $.each(variationValues, function(index, value) {
            table += '<tr>';
            table +=
                '<td><select class="form-control variation-select" name="variation_values_id[]">';
            $.each(variationValues, function(index, value) {
                table += '<option value="' + value.id + '">' + value.variation_value +
                    '</option>';
            });
            table += '</select></td>';
            table +=
                '<td><input type="text" name="variation_buying_price[]" class="form-control" placeholder="Enter buying price"></td>';
            table +=
                '<td><input type="text" name="variation_customer_price[]" class="form-control" placeholder="Enter customer price"></td>';
            table += '<td><select class="form-control tax-group" name="variation_tax_group_id[]">';
            table += '<option value="">Select Tax Rate</option>';
            // Iterate over taxGroups array
            $.each(taxGroups, function(taxIndex, taxGroup) {
                table += '<option value="' + taxGroup.id + '">' + taxGroup.tax_group_name +
                    '</option>';
            });
            table += '</select></td>';
            table +=
                '<td><input type="text" name="variation_sale_price[]" class="form-control" placeholder="Enter sale price"></td>';
            table += '<td><button type="button" class="btn btn-danger remove-row">-</button></td>';
            table += '</tr>';
        });
        table += '</tbody></table>';
        table += '<button type="button" class="btn btn-success add-row-btn" data-table-id="' + tableId +
            '">Add Row</button>';
        table +=
            '<button type="button" class="btn btn-danger remove-table-btn" data-table-container-id="table_container_' +
            counter + '">Delete Table</button>';
        table += '</div>';
        $('#variation_values_container').append(table);

        // Set the first variation value as selected for each dropdown
        $('#' + tableId + ' .variation-select').each(function(index) {
            $(this).val(variationValues[index].id);
        });
    }

    // Handle removing rows
    $(document).on('click', '.remove-row', function() {
        var row = $(this).closest('tr');
        row.remove();
    });

    // Handle removing tables
    $(document).on('click', '.remove-table-btn', function() {
        var tableContainerId = $(this).data('table-container-id');
        $('#' + tableContainerId).remove();
    });

    // Handle adding new rows to the table
    $(document).on('click', '.add-row-btn', function() {
        var tableId = $(this).data('table-id');
        var currentRowCount = $('#' + tableId + ' tbody tr').length;

        if (currentRowCount < maxRowsPerTable) {
            var newRow = '<tr>' +
                '<td><select class="form-control variation-select" name="variation_values_id[]">';
            $.each(variationValues, function(index, value) {
                newRow += '<option value="' + value.id + '">' + value.variation_value +
                    '</option>';
            });
            newRow += '</select></td>' +
                '<td><input type="text" name="variation_buying_price[]" class="form-control" placeholder="Enter buying price"></td>' +
                '<td><input type="text" name="variation_customer_price[]" class="form-control" placeholder="Enter customer price"></td>' +
                '<td><select class="form-control tax-group" name="variation_tax_group_id[]">' +
                '<option value="">Select Tax Rate</option>';
            $.each(taxGroups, function(taxIndex, taxGroup) {
                newRow += '<option value="' + taxGroup.id + '">' + taxGroup.tax_group_name +
                    '</option>';
            });
            newRow += '</select></td>' +
                '<td><input type="text" name="variation_sale_price[]" class="form-control" placeholder="Enter sale price"></td>' +
                '<td><button type="button" class="btn btn-danger remove-row">-</button></td>' +
                '</tr>';
            $('#' + tableId + ' tbody').append(newRow);

            // Pre-select the variation value for the new row
            $('#' + tableId + ' tbody tr:last-child .variation-select').val(variationValues[
                currentRowCount].id);
        } else {
            alert('All variation values are already utilized.');
        }
    });

    $(document).on('change', '.tax-group', function() {
        var taxGroupId = $(this).val();
        var row = $(this).closest('tr');
        var buyingPrice = parseFloat(row.find('input[name="variation_buying_price[]"]').val());
        var customerPrice = parseFloat(row.find('input[name="variation_customer_price[]"]').val());

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
                    console.log('Response:', response);
                    try {
                        var taxRate = parseFloat(response.total_tax_amount);
                        if (!isNaN(taxRate)) {
                            var taxAmount = (buyingPrice * taxRate) / 100;
                            var salePrice = customerPrice + taxAmount;
                            row.find('input[name="variation_sale_price[]"]').val(salePrice
                                .toFixed(2));
                        } else {
                            row.find('input[name="variation_sale_price[]"]').val('');
                        }
                    } catch (error) {
                        row.find('input[name="variation_sale_price[]"]').val('');
                    }
                },
                error: function(xhr, status, error) {
                    row.find('input[name="variation_sale_price[]"]').val('');
                }
            });
        } else {
            row.find('input[name="variation_sale_price[]"]').val('');
        }
    });

    $(document).on('input', 'input[name="variation_buying_price[]"], input[name="variation_customer_price[]"]',
        function() {
            var input = $(this).val();
            if (isNaN(input)) {
                $(this).val('');
            }
        });

    $('#tax_group_id').on('change', function() {
        var customerPrice = parseFloat($('#customer_price').val());
        var taxGroupId = $(this).val();

        if (!isNaN(customerPrice) && taxGroupId) {
            $.ajax({
                url: "<?php echo site_url(route_to('products.get_tax_rate')); ?>",
                method: 'POST',
                data: {
                    tax_group_id: taxGroupId,
                    customer_price: customerPrice,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    console.log('Response:', response); // Debugging
                    try {
                        var taxAmount = parseFloat(response.total_tax_amount);
                        if (!isNaN(taxAmount)) {
                            var salePrice = customerPrice + taxAmount;
                            $('#sale_price').val(salePrice.toFixed(2));
                        } else {
                            $('#sale_price').val('');
                        }
                    } catch (error) {
                        console.error('Error parsing response:', error); // Error handling
                        $('#sale_price').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error); // Error handling
                    $('#sale_price').val('');
                }
            });
        } else {
            $('#sale_price').val('');
        }
    });

    $('#customer_price').on('input', function() {
        var customerPrice = parseFloat($(this).val());
        var taxGroupId = $('#tax_group_id').val();

        if (!isNaN(customerPrice) && taxGroupId) {
            $.ajax({
                url: "<?php echo site_url(route_to('products.get_tax_rate')); ?>",
                method: 'POST',
                data: {
                    tax_group_id: taxGroupId,
                    customer_price: customerPrice,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    console.log('Response:', response); // Debugging
                    try {
                        var taxAmount = parseFloat(response.total_tax_amount);
                        if (!isNaN(taxAmount)) {
                            var salePrice = customerPrice + taxAmount;
                            $('#sale_price').val(salePrice.toFixed(2));
                        } else {
                            $('#sale_price').val('');
                        }
                    } catch (error) {
                        console.error('Error parsing response:', error); // Error handling
                        $('#sale_price').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error); // Error handling
                    $('#sale_price').val('');
                }
            });
        } else {
            $('#sale_price').val('');
        }
    });

    $('#create_variation_values_table_btn').click(function() {
        var variationId = $('#variation_id').val();
        if (variationId) {
            if (!createdVariations.includes(variationId)) {
                createdVariations.push(variationId);
                variationCounter++;
                generateVariationValuesTable(variationValues, variationCounter);
            } else {
                alert('A table for this variation already exists.');
            }
        } else {
            alert('Please select a variation.');
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<script>
// Show the table for single products by default
$('#single_product_table').show();

// Toggle display based on product type selection
$('#toggle_variation').on('change', function() {
    var selectedType = $(this).val();
    if (selectedType == '0') { // Single
        $('#variation_product_table').hide();
        $('#single_product_table').show();
    } else { // Variable
        $('#variation_product_table').show();
        $('#single_product_table').hide();
    }
});
</script>
<script>
$(document).ready(function() {
    $('#buying_price, #tax_group_id').on('input change', function() {
        var buyingPrice = parseFloat($('#buying_price').val());
        var taxRate = parseFloat($('#tax_group_id option:selected').data('tax-rate'));

        if (!isNaN(buyingPrice) && !isNaN(taxRate)) {
            var taxAmount = (buyingPrice * taxRate) / 100;
            var totalPrice = buyingPrice + taxAmount;
            $('#sale_price').val(totalPrice.toFixed(2));
        } else {
            $('#sale_price').val('');
        }
    });
});
</script>

<?= $this->endSection() ?>