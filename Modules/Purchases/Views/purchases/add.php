<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.add_purchase') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><a
                            href="<?php echo url('/purchase-management/purchases') ?>"><?php echo lang('App.purchases') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.add_purchase') ?></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <?= form_open(route_to('purchases.store'), ['id' => 'purchase-add', 'method' => 'post', 'autocomplete' => 'off']); ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Left column -->
            <div class="col-md-12">
                <!-- Variations -->
                <div class="card">
                    <div class="card-body">

                        <!-- Supplier Name & Purchase Date & Reference No -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="supplier_id"><?= lang('App.supplier') ?></label>
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="supplier_id" name="supplier_id">
                                        <option value="" selected><?= lang('App.select_supplier') ?></option>
                                        <?php foreach ($suppliers as $supplier): ?>
                                            <option value="<?= $supplier->id; ?>"><?= $supplier->supplier_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= isset($validation) && $validation->getError('supplier_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('supplier_id')) . '</p>' : '' ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_date"><?= lang('App.purchase_date') ?></label>
                                    <input type="date" class="form-control" name="purchase_date" id="purchase_date"
                                        value="<?= date('Y-m-d') ?>" required />
                                    <?= isset($validation) && $validation->getError('purchase_date') ? '<p class="text-danger mt-2">' . esc($validation->getError('purchase_date')) . '</p>' : '' ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reference_no"><?= lang('App.reference_no') ?></label>
                                    <input type="text" class="form-control" id="reference_no" name="reference_no"
                                        readonly>
                                    <?= isset($validation) && $validation->getError('reference_no') ? '<p class="text-danger mt-2">' . esc($validation->getError('reference_no')) . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Product Search -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_name"><?= lang('App.product_name') ?></label>
                                    <input type="text" class="form-control" name="product_name" id="product_name"
                                        placeholder="<?= lang('App.search_product_name_and_select') ?>" />
                                    <?= isset($validation) && $validation->getError('product_name') ? '<p class="text-danger mt-2">' . esc($validation->getError('product_name')) . '</p>' : '' ?>
                                    <div id="product_suggestions" class="list-group mt-2"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Table to display selected products -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?= lang('App.product_name') ?></th>
                                                <th><?= lang('App.quantity') ?></th>
                                                <th><?= lang('App.purchase_price') ?></th>
                                                <th><?= lang('App.manufacture_date') ?></th>
                                                <th><?= lang('App.expiry_date') ?></th>
                                                <th><?= lang('App.total') ?></th>
                                                <th><?= lang('App.actions') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="product_table_body">
                                            <!-- Product rows will be added here by JavaScript -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    <strong><?= lang('App.total_amount') ?></strong>
                                                </td>
                                                <td><input type="text" class="form-control" id="total_amount_display"
                                                        disabled /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    <strong><?= lang('App.paid_amount') ?></strong>
                                                </td>
                                                <td><input type="number" class="form-control" name="paid_amount"
                                                        id="paid_amount" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    <strong><?= lang('App.remaining_amount') ?></strong>
                                                </td>
                                                <td><input type="text" class="form-control"
                                                        id="remaining_amount_display" disabled /></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Payment and Purchase Status -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_status"><?= lang('App.payment_status') ?></label>
                                    <select class="form-control" name="payment_status" id="payment_status">
                                        <option value="" selected><?= lang('App.select_payment_status') ?></option>
                                        <option value="paid"><?= lang('App.paid') ?></option>
                                        <option value="unpaid"><?= lang('App.unpaid') ?></option>
                                        <option value="partial"><?= lang('App.partial') ?></option>
                                    </select>
                                    <?= isset($validation) && $validation->getError('payment_status') ? '<p class="text-danger mt-2">' . esc($validation->getError('payment_status')) . '</p>' : '' ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purchase_status"><?= lang('App.purchase_status') ?></label>
                                    <select class="form-control" name="purchase_status" id="purchase_status">
                                        <option value="" selected><?= lang('App.select_purchase_status') ?></option>
                                        <option value="received"><?= lang('App.received') ?></option>
                                        <option value="pending"><?= lang('App.pending') ?></option>
                                    </select>
                                    <?= isset($validation) && $validation->getError('purchase_status') ? '<p class="text-danger mt-2">' . esc($validation->getError('purchase_status')) . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields to store calculated values -->
                        <input type="hidden" name="total_amount" value="0">
                        <input type="hidden" name="remaining_amount" value="0">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
        <a href="<?= url('/product-management/purchases') ?>"
            onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger">
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
                $(element).closest('.form-group').find('.invalid-feedback').remove();
            }
        });

        $('#purchase-add').validate({
            rules: {
                supplier_id: {
                    required: true,
                    digits: true
                },
                purchase_date: {
                    required: true,
                    date: true
                },
                payment_status: {
                    required: true,
                    oneOf: ["paid", "unpaid", "partial"]
                },
                purchase_status: {
                    required: true,
                    oneOf: ["received", "pending"]
                }
            },
            messages: {
                supplier_id: {
                    required: "Please select a supplier.",
                    digits: "Invalid supplier ID."
                },
                purchase_date: {
                    required: "Please enter the purchase date.",
                    date: "Please enter a valid date."
                },
                payment_status: {
                    required: "Please select the payment status.",
                    oneOf: "Invalid payment status."
                },
                purchase_status: {
                    required: "Please select the purchase status.",
                    oneOf: "Invalid purchase status."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        // Custom validation method for oneOf
        $.validator.addMethod("oneOf", function(value, element, arg) {
            return $.inArray(value, arg) != -1;
        }, "Please specify a valid value.");

        $('#paid_amount').val('0');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productNameInput = document.getElementById('product_name');
        const productSuggestions = document.getElementById('product_suggestions');
        const productTableBody = document.getElementById('product_table_body');
        const totalAmountDisplay = document.getElementById('total_amount_display');
        const paidAmountField = document.getElementById('paid_amount');
        const remainingAmountDisplay = document.getElementById('remaining_amount_display');
        const totalAmountField = document.querySelector('input[name="total_amount"]');
        const remainingAmountField = document.querySelector('input[name="remaining_amount"]');
        const referenceNoInput = document.getElementById('reference_no');
        const form = document.getElementById('purchase-add');

        // Fetch purchase order number on page load
        fetchPurchaseOrderNumber();

        function fetchPurchaseOrderNumber() {
            fetch('<?= site_url(route_to('purchases.generate_purchase_order_number')) ?>')
                .then(response => response.json())
                .then(data => {
                    console.log('Purchase Order Number:', data.reference_no);
                    referenceNoInput.value = data.reference_no;
                })
                .catch(error => {
                    console.error('Error fetching purchase order number:', error);
                });
        }

        productNameInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length < 2) {
                productSuggestions.innerHTML = '';
                return;
            }

            // AJAX request to fetch product suggestions
            fetch('<?= site_url(route_to('purchases.search')) ?>?query=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    console.log('Product Suggestions:', data);

                    let suggestions = '';
                    if (data.length > 0) {
                        data.forEach(product => {
                            suggestions +=
                                `<button type="button" class="list-group-item list-group-item-action" data-product='${JSON.stringify(product)}'>${product.variation_product_name ? product.variation_product_name : product.product_name}</button>`;
                        });
                    } else {
                        suggestions = '<div class="list-group-item">No result</div>';
                    }
                    productSuggestions.innerHTML = suggestions;
                })
                .catch(error => {
                    console.error('Error fetching product suggestions:', error);
                });
        });

        // Handle product suggestion click
        productSuggestions.addEventListener('click', function(e) {
            if (e.target.classList.contains('list-group-item') && e.target.getAttribute('data-product')) {
                const product = JSON.parse(e.target.getAttribute('data-product'));
                addProductToTable(product);
                productNameInput.value = '';
                productSuggestions.innerHTML = '';
            }
        });

        form.addEventListener('submit', function(event) {
            if (!validateProductTable()) {
                event.preventDefault();
            }
        });

        function addProductToTable(product) {
            const productId = product.has_variation ? product.product_id : product.id;
            const productName = product.variation_product_name || product.product_name;
            const productSKU = product.sku_code || product.variation_sku_code || ''; // Add SKU Code
            const productPrice = parseFloat(product.buying_price || product.variation_buying_price || 0);
            const manufactureDate = '';
            const expiryDate = '';

            // These fields are for brand, unit, category, and sub-category
            const brandId = product.brand_id || ''; // Handle missing value if it's not provided
            const unitId = product.unit_id || '';
            const categoryId = product.category_id || '';
            const subCategoryId = product.sub_category_id || '';

            if (product.has_variation && Array.isArray(product.variations)) {
                product.variations.forEach((variation, index) => {
                    // Create a unique key for each variation row by appending an index
                    const uniqueIndex = Date.now() + '-' + index; // You can use any unique logic here

                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>
                        <input type="hidden" name="products[${uniqueIndex}][product_id]" value="${productId}" /> 
                        ${productName} - ${variation.name}
                    </td>
                    <td>
                        <input type="number" name="products[${uniqueIndex}][quantity]" value="1" min="1" class="form-control quantity-input" />
                        <span class="text-danger mt-2 error-message"></span>
                    </td>
                    <td>
                        <input type="number" name="products[${uniqueIndex}][price]" value="${productPrice}" class="form-control price-input" />
                        <span class="text-danger mt-2 error-message"></span>
                    </td>
                    <td>
                        <input type="date" name="products[${uniqueIndex}][manufacture_date]" value="${manufactureDate}" class="form-control manufacture-date-input" />
                        <span class="text-danger mt-2 error-message"></span>
                    </td>
                    <td>
                        <input type="date" name="products[${uniqueIndex}][expiry_date]" value="${expiryDate}" class="form-control expiry-date-input" />
                        <span class="text-danger mt-2 error-message"></span>
                    </td>
                    <td class="total">${productPrice.toFixed(2)}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-product">Remove</button></td>
                    <input type="hidden" name="products[${uniqueIndex}][brand_id]" value="${brandId}" />
                    <input type="hidden" name="products[${uniqueIndex}][unit_id]" value="${unitId}" />
                    <input type="hidden" name="products[${uniqueIndex}][category_id]" value="${categoryId}" />
                    <input type="hidden" name="products[${uniqueIndex}][sub_category_id]" value="${subCategoryId}" />
                    <input type="hidden" name="products[${uniqueIndex}][product_name]" value="${productName}" />
                    <input type="hidden" name="products[${uniqueIndex}][sku_code]" value="${productSKU}" />
                    <input type="hidden" name="products[${uniqueIndex}][variation_id]" value="${variation.id || ''}" />
                    <input type="hidden" name="products[${uniqueIndex}][variation_value_id]" value="${variation.value_id || ''}" />
                `;
                    productTableBody.appendChild(row);

                    row.querySelectorAll('input').forEach(input => {
                        input.addEventListener('input', function() {
                            if (validateProductRow(row)) {
                                clearValidationError(input);
                            }
                            updateRowTotal.call(input);
                        });
                    });

                    row.querySelector('.remove-product').addEventListener('click', function() {
                        row.remove();
                        updateTotalAmount();
                    });

                    updateTotalAmount();
                });
            } else {
                // Handle product without variations
                const uniqueIndex = Date.now(); // Unique index for single product row
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>
                    <input type="hidden" name="products[${uniqueIndex}][product_id]" value="${productId}" /> 
                    ${productName}
                </td>
                <td>
                    <input type="number" name="products[${uniqueIndex}][quantity]" value="1" min="1" class="form-control quantity-input" />
                    <span class="text-danger mt-2 error-message"></span>
                </td>
                <td>
                    <input type="number" name="products[${uniqueIndex}][price]" value="${productPrice}" class="form-control price-input" />
                    <span class="text-danger mt-2 error-message"></span>
                </td>
                <td>
                    <input type="date" name="products[${uniqueIndex}][manufacture_date]" value="${manufactureDate}" class="form-control manufacture-date-input" />
                    <span class="text-danger mt-2 error-message"></span>
                </td>
                <td>
                    <input type="date" name="products[${uniqueIndex}][expiry_date]" value="${expiryDate}" class="form-control expiry-date-input" />
                    <span class="text-danger mt-2 error-message"></span>
                </td>
                <td class="total">${productPrice.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-product">Remove</button></td>
                <input type="hidden" name="products[${uniqueIndex}][brand_id]" value="${brandId}" />
                <input type="hidden" name="products[${uniqueIndex}][unit_id]" value="${unitId}" />
                <input type="hidden" name="products[${uniqueIndex}][category_id]" value="${categoryId}" />
                <input type="hidden" name="products[${uniqueIndex}][sub_category_id]" value="${subCategoryId}" />
                <input type="hidden" name="products[${uniqueIndex}][product_name]" value="${productName}" />
                <input type="hidden" name="products[${uniqueIndex}][sku_code]" value="${productSKU}" />
                <input type="hidden" name="products[${uniqueIndex}][variation_id]" value="${product.variation_id || ''}" />
                <input type="hidden" name="products[${uniqueIndex}][variation_value_id]" value="${product.variation_value_id || ''}" />
            `;
                productTableBody.appendChild(row);

                row.querySelectorAll('input').forEach(input => {
                    input.addEventListener('input', function() {
                        if (validateProductRow(row)) {
                            clearValidationError(input);
                        }
                        updateRowTotal.call(input);
                    });
                });

                row.querySelector('.remove-product').addEventListener('click', function() {
                    row.remove();
                    updateTotalAmount();
                });

                updateTotalAmount();
            }
        }

        // Function to validate a product row
        function validateProductRow(row) {
            let isValid = true;

            const quantityInput = row.querySelector('.quantity-input');
            const manufactureDateInput = row.querySelector('.manufacture-date-input');
            const expiryDateInput = row.querySelector('.expiry-date-input');

            if (quantityInput.value <= 0) {
                displayValidationError(quantityInput, 'Quantity must be greater than 0.');
                isValid = false;
            } else {
                clearValidationError(quantityInput);
            }

            const manufactureDate = new Date(manufactureDateInput.value);
            const expiryDate = new Date(expiryDateInput.value);

            if (manufactureDate > expiryDate) {
                displayValidationError(manufactureDateInput, 'Manufacture date must be before the expiry date.');
                displayValidationError(expiryDateInput, 'Expiry date must be after the manufacture date.');
                isValid = false;
            } else {
                clearValidationError(manufactureDateInput);
                clearValidationError(expiryDateInput);
            }

            return isValid;
        }

        // Function to validate the entire product table
        function validateProductTable() {
            let isValid = true;
            const productRows = productTableBody.querySelectorAll('tr');

            if (productRows.length === 0) {
                alert('Please add at least one product.');
            }

            productRows.forEach(row => {
                if (!validateProductRow(row)) {
                    isValid = false;
                }
            });

            const totalAmount = parseFloat(totalAmountField.value) || 0;
            const paidAmount = parseFloat(paidAmountField.value) || 0;

            if (paidAmount > totalAmount) {
                displayValidationError(paidAmountField, 'Paid amount cannot be greater than the total amount.');
                isValid = false;
            } else {
                clearValidationError(paidAmountField);
            }

            return isValid;
        }

        // Function to display validation error messages dynamically
        function displayValidationError(element, message) {
            const errorElement = element.closest('td').querySelector('.error-message');
            if (errorElement) {
                errorElement.textContent = message;
            } else {
                const errorMessage = document.createElement('span');
                errorMessage.classList.add('text-danger', 'mt-2', 'error-message');
                errorMessage.textContent = message;
                element.closest('td').appendChild(errorMessage);
            }
        }

        // Function to clear validation error messages
        function clearValidationError(element) {
            const errorElement = element.closest('td').querySelector('.error-message');
            if (errorElement) {
                errorElement.textContent = '';
            }
        }

        // Function to update row total amount
        function updateRowTotal() {
            const row = this.closest('tr');
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const total = quantity * price;
            row.querySelector('.total').textContent = total.toFixed(2);
            updateTotalAmount();
        }

        // Function to update total amount of all products
        function updateTotalAmount() {
            let totalAmount = 0;
            productTableBody.querySelectorAll('tr').forEach(row => {
                const total = parseFloat(row.querySelector('.total').textContent) || 0;
                totalAmount += total;
            });

            totalAmountDisplay.value = totalAmount.toFixed(2);
            totalAmountField.value = totalAmount.toFixed(2);
            updateRemainingAmount();
        }

        // Function to update remaining amount after paid amount change
        function updateRemainingAmount() {
            const paidAmount = parseFloat(paidAmountField.value) || 0;
            const totalAmount = parseFloat(totalAmountField.value) || 0;
            const remainingAmount = totalAmount - paidAmount;

            remainingAmountDisplay.value = remainingAmount.toFixed(2);
            remainingAmountField.value = remainingAmount.toFixed(2);
        }

        // Event listener for paid amount field input
        paidAmountField.addEventListener('input', function() {
            if (paidAmountField.value > parseFloat(totalAmountField.value) || 0) {
                displayValidationError(paidAmountField,
                    'Paid amount cannot be greater than the total amount.');
            } else {
                clearValidationError(paidAmountField);
            }
            updateRemainingAmount();
        });

        // Set default value for paid amount
        paidAmountField.value = '0';
    });
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>


<?= $this->endSection() ?>