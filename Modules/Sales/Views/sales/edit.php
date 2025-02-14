<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= lang('App.edit_Sales') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?= url('/sale-management/sales') ?>"><?= lang('App.sales') ?></a></li>
                    <li class="breadcrumb-item active"><?= lang('App.edit_Sales') ?></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <?= form_open(route_to('sales.update', $sale->id), ['id' => 'sale-edit', 'method' => 'post', 'autocomplete' => 'off']); ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Left column -->
            <div class="col-md-12">
                <!-- Variations -->
                <div class="card">
                    <div class="card-body">

                        <!-- customer Name & Purchase Date & Reference No -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_id"><?= lang('App.customer') ?></label>
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="customer_id" name="customer_id">
                                        <option value=""><?= lang('App.select_customer') ?></option>
                                        <?php foreach ($customers as $customer): ?>
                                            <option value="<?= $customer->id; ?>" <?= ($customer->id == $sale->customer_id) ? 'selected' : '' ?>>
                                                <?= $customer->customer_name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= isset($validation) && $validation->getError('customer_id') ? '<p class="text-danger mt-2">' . esc($validation->getError('customer_id')) . '</p>' : '' ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sale_date"><?= lang('App.sale_date') ?></label>
                                    <input type="date" class="form-control" name="sale_date" id="sale_date"
                                        value="<?= old('sale_date', date('Y-m-d', strtotime($sale->created_at))) ?>"
                                        required />
                                    <?= isset($validation) && $validation->getError('sale_date') ? '<p class="text-danger mt-2">' . esc($validation->getError('purchase_date')) . '</p>' : '' ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reference_no"><?= lang('App.reference_no') ?></label>
                                    <input type="text" class="form-control" id="reference_no" name="reference_no"
                                        value="<?= old('reference_no', $sale->reference_no) ?>" readonly>
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
                                        placeholder="<?= lang('App.search_product_name_and_select') ?>"
                                        value="<?= old('product_name') ?>" />
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
                                            <!-- Existing products will be added here via JavaScript -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    <strong><?= lang('App.total_amount') ?></strong>
                                                </td>
                                                <td><input type="text" class="form-control" id="total_amount_display"
                                                        value="<?= old('total_amount', $sale->total_amount) ?>"
                                                        disabled /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    <strong><?= lang('App.paid_amount') ?></strong>
                                                </td>
                                                <td><input type="number" class="form-control" name="paid_amount"
                                                        id="paid_amount"
                                                        value="<?= old('paid_amount', $sale->paid_amount) ?>" />
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    <strong><?= lang('App.remaining_amount') ?></strong>
                                                </td>
                                                <td><input type="text" class="form-control"
                                                        id="remaining_amount_display"
                                                        value="<?= old('remaining_amount', $sale->remaining_amount) ?>"
                                                        disabled /></td>
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
                                        <option value=""><?= lang('App.select_payment_status') ?></option>
                                        <option value="paid" <?= ($sale->payment_status == 'paid') ? 'selected' : '' ?>>
                                            <?= lang('App.paid') ?>
                                        </option>
                                        <option value="unpaid" <?= ($sale->payment_status == 'unpaid') ? 'selected' : '' ?>>
                                            <?= lang('App.unpaid') ?>
                                        </option>
                                        <option value="partial" <?= ($sale->payment_status == 'partial') ? 'selected' : '' ?>>
                                            <?= lang('App.partial') ?>
                                        </option>
                                    </select>
                                    <?= isset($validation) && $validation->getError('payment_status') ? '<p class="text-danger mt-2">' . esc($validation->getError('payment_status')) . '</p>' : '' ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purchase_status"><?= lang('App.purchase_status') ?></label>
                                    <select class="form-control" name="purchase_status" id="purchase_status">
                                        <option value=""><?= lang('App.select_purchase_status') ?></option>
                                        <option value="completed" <?= ($sale->sale_status == 'completed') ? 'selected' : '' ?>>
                                            <?= lang('App.completed') ?>
                                        </option>
                                        <option value="pending" <?= ($sale->sale_status == 'pending') ? 'selected' : '' ?>>
                                            <?= lang('App.pending') ?>
                                        </option>
                                        <option value="pending" <?= ($sale->sale_status == 'canceled') ? 'selected' : '' ?>>
                                            <?= lang('App.canceled') ?>
                                        </option>
                                    </select>
                                    <?= isset($validation) && $validation->getError('sale_status') ? '<p class="text-danger mt-2">' . esc($validation->getError('purchase_status')) . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields to store calculated values -->
                        <input type="hidden" name="total_amount"
                            value="<?= old('total_amount', $sale->total_amount) ?>">
                        <input type="hidden" name="remaining_amount"
                            value="<?= old('remaining_amount', $sale->remaining_amount) ?>">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
        <a href="<?= url('/product-management/purchases') ?>"
            onclick="return confirm('<?= lang('App.leave_confirmation') ?>')" class="btn btn-flat btn-danger">
            <?= lang('App.cancel') ?>
        </a>
    </div>
    <?= form_close(); ?>
</section>
<!-- /.content -->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- jquery-validation -->
<script src="<?= assets_url('admin') ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= assets_url('admin') ?>/plugins/jquery-validation/additional-methods.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        // Validation setup
        $.validator.setDefaults({
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).closest('.form-group').find('.invalid-feedback').remove();
            }
        });

        $('#purchase-edit').validate({
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
                    required: "<?= lang('App.select_supplier_error') ?>",
                    digits: "<?= lang('App.invalid_supplier_id_error') ?>"
                },
                purchase_date: {
                    required: "<?= lang('App.enter_purchase_date_error') ?>",
                    date: "<?= lang('App.valid_date_error') ?>"
                },
                payment_status: {
                    required: "<?= lang('App.select_payment_status_error') ?>",
                    oneOf: "<?= lang('App.invalid_payment_status_error') ?>"
                },
                purchase_status: {
                    required: "<?= lang('App.select_purchase_status_error') ?>",
                    oneOf: "<?= lang('App.invalid_purchase_status_error') ?>"
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        // Custom validation method for oneOf
        $.validator.addMethod("oneOf", function (value, element, arg) {
            return $.inArray(value, arg) != -1;
        }, "<?= lang('App.valid_value_error') ?>");

        // Initialize paid amount field with current value or default
        $('#paid_amount').val('<?= old('paid_amount', $sale->paid_amount) ?>');
    });
</script>





<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productNameInput = document.getElementById('product_name');
        const productSuggestions = document.getElementById('product_suggestions');
        const productTableBody = document.getElementById('product_table_body');
        const totalAmountDisplay = document.getElementById('total_amount_display');
        const paidAmountField = document.getElementById('paid_amount');
        const remainingAmountDisplay = document.getElementById('remaining_amount_display');
        const totalAmountField = document.querySelector('input[name="total_amount"]');
        const remainingAmountField = document.querySelector('input[name="remaining_amount"]');
        const referenceNoInput = document.getElementById('reference_no');
        const form = document.getElementById('purchase-edit');

        const addedProductIds = new Set(); // Track added product IDs
        const addedProductNames = new Set(); // Track added product names
        const existingProducts = new Set(); // Store existing product IDs

        // Load existing purchase items and populate the table
        const saleItems = <?= json_encode($saleItems) ?>;
        saleItems.forEach(item => {
            // Always add the product row regardless of whether it has a variation or not
            addProductRow(item, true);
            addedProductNames.add(item.product_name);
            existingProducts.add(item.id); // Track existing product IDs
            // Always track the main product ID (even if it doesn't have variations)
            if (item.has_variation) {
                existingProducts.add(item.variation_id); // Track variation IDs if present
            }
        });

        fetchPurchaseOrderNumber();

        function fetchPurchaseOrderNumber() {
            fetch('<?= site_url(route_to('purchases.generate_purchase_order_number')) ?>')
                .then(response => response.json())
                .then(data => {
                    referenceNoInput.value = data.reference_no;
                })
                .catch(error => console.error('Error fetching purchase order number:', error));
        }

        function addProductRow(product, isExisting, price) {
            // Use the appropriate ID for tracking
            const productId = product.has_variation ? product.variation_id : product.id;
            const productSKU = product.sku_code || product.variation_sku_code || ''; // Add SKU Code
            const productName = product.variation_product_name || product.product_name;
            if (addedProductIds.has(productId) && !isExisting) {
                alert('This product has already been added.');
                return;
            }

            const uniqueIndex = isExisting ? product.unique_index : Date.now();
            addedProductIds.add(productId);

            // Ensure displayPrice is a valid number
            const displayPrice = isExisting ? product.unit_price : price || 0;

            // Extract display name for the row
            const displayName = product.variation_product_name || product.product_name;

            // Set default values for quantity and price to avoid NaN
            const quantity = product.quantity || 1; // Default quantity to 1 if not defined
            const validPrice = parseFloat(displayPrice) || 0; // Ensure displayPrice is a number

            const row = document.createElement('tr');
            row.innerHTML = `
        
        <td>${displayName}</td>
        <td><input type="number" name="products[${uniqueIndex}][quantity]" value="${quantity}" class="form-control quantity-input" /></td>
        <td><input type="number" name="products[${uniqueIndex}][price]" value="${validPrice.toFixed(2)}" class="form-control price-input" readonly/></td>
        <td>${generateDateFields(product, uniqueIndex)}</td>
        <td>${generateDateFields1(product, uniqueIndex)}</td>
        <td class="total">${(quantity * validPrice).toFixed(2)}</td>
        <td><button type="button" class="btn btn-danger btn-sm remove-product">Remove</button></td>
       <input type="hidden" name="products[${uniqueIndex}][sku_code]" value="${productSKU}" />
        <input type="hidden" name="products[${uniqueIndex}][product_name]" value="${productName}" />
        ${generateHiddenFields(product, uniqueIndex)}
    `;

            productTableBody.appendChild(row);
            attachRowEvents(row);
            updateTotalAmount();
        }



        function generateDateFields(product, uniqueIndex) {
            return `<input type="date" name="products[${uniqueIndex}][expiry_date]" value="${product.expiry_date || ''}" class="form-control" />`;
        }

        function generateDateFields1(product, uniqueIndex) {
            return `<input type="date" name="products[${uniqueIndex}][expiry_date]" value="${product.expiry_date || ''}" class="form-control" />`;
        }

        function generateHiddenFields(product, uniqueIndex) {
            return `
                <input type="hidden" name="products[${uniqueIndex}][product_id]" value="${product.id}" />
                <input type="hidden" name="products[${uniqueIndex}][product_name]" value="${product.product_name}" />
                <input type="hidden" name="products[${uniqueIndex}][variation_id]" value="${product.variation_id || ''}" />
                <input type="hidden" name="products[${uniqueIndex}][variation_value_id]" value="${product.variation_value_id || ''}" />
            `;
        }

        function attachRowEvents(row) {
            row.querySelector('.quantity-input').addEventListener('input', function () {
                updateRowTotal.call(this);
                updateTotalAmount();
            });
            row.querySelector('.price-input').addEventListener('input', function () {
                updateRowTotal.call(this);
                updateTotalAmount();
            });
            row.querySelector('.remove-product').addEventListener('click', function () {
                const productId = row.querySelector('input[name*="[product_id]"]').value;
                addedProductIds.delete(productId);
                row.remove();
                updateTotalAmount();
            });
        }

        productNameInput.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length < 2) {
                productSuggestions.innerHTML = '';
                return;
            }

            // AJAX request to fetch product suggestions excluding already added single products
            fetch('<?= site_url(route_to('purchases.search')) ?>?query=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    let suggestions = '';
                    data.forEach(product => {
                        const displayName = product.product_name || product.variation_product_name;
                        const price = product.buying_price || product.variation_buying_price;
                        suggestions += `<button type="button" class="list-group-item list-group-item-action" data-product='${JSON.stringify(product)}'>${displayName} - ${price}</button>`;
                    });
                    console.log(data);
                    productSuggestions.innerHTML = suggestions.length > 0 ? suggestions : '<div class="list-group-item">No result</div>';
                })
                .catch(error => console.error('Error fetching product suggestions:', error));
        });

        productSuggestions.addEventListener('click', function (e) {
            if (e.target.classList.contains('list-group-item') && e.target.getAttribute('data-product')) {
                const product = JSON.parse(e.target.getAttribute('data-product'));

                // Ensure to check for product name
                const productName = product.variation_product_name || product.product_name;

                // Ensure to use the correct price for the product being added
                const price = product.variation_buying_price || product.buying_price || 0;

                // Check if the product name has already been added
                if (addedProductNames.has(productName)) {
                    alert('This product has already been added.');
                    return;
                }

                // If not already added, add the product row
                addProductRow(product, false, price);
                addedProductNames.add(productName); // Add to the added product names set
                productNameInput.value = '';
                productSuggestions.innerHTML = ''; // Hide suggestions after product selection
            }
        });


        form.addEventListener('submit', function (event) {
            if (!validateProductTable()) {
                event.preventDefault();
            }
        });

        function updateRowTotal() {
            const row = this.closest('tr');
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            row.querySelector('.total').textContent = (quantity * price).toFixed(2);
        }

        function updateTotalAmount() {
            let totalAmount = 0;
            productTableBody.querySelectorAll('tr').forEach(row => {
                totalAmount += parseFloat(row.querySelector('.total').textContent) || 0;
            });
            totalAmountDisplay.value = totalAmount.toFixed(2);
            totalAmountField.value = totalAmount.toFixed(2);
            updateRemainingAmount();
        }

        function updateRemainingAmount() {
            const paidAmount = parseFloat(paidAmountField.value) || 0;
            const totalAmount = parseFloat(totalAmountField.value) || 0;
            const remainingAmount = totalAmount - paidAmount;
            remainingAmountDisplay.value = remainingAmount.toFixed(2);
            remainingAmountField.value = remainingAmount.toFixed(2);
        }

        paidAmountField.addEventListener('input', function () {
            updateRemainingAmount();
        });

        function validateProductTable() {
            const productRows = productTableBody.querySelectorAll('tr');
            if (productRows.length === 0) {
                alert('Please add at least one product.');
                return false;
            }

            let isValid = true;
            productRows.forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                if (quantity <= 0) {
                    alert('Quantity must be greater than zero.');
                    isValid = false;
                }
            });
            return isValid;
        }
    });
</script>





<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
<?= $this->endSection() ?>