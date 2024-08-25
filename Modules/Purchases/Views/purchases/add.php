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
    $(document).ready(function () {
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
            submitHandler: function (form) {
                form.submit();
            }
        });
        $('#supplier_id').on('change', function () {
            var $this = $(this);
            if ($this.val() !== "") {
                $this.removeClass('is-invalid'); // Remove invalid class if using Bootstrap
                $this.closest('.form-group').find('.text-danger').remove(); // Remove error message
            }
        });


        // Custom validation method for oneOf
        $.validator.addMethod("oneOf", function (value, element, arg) {
            return $.inArray(value, arg) != -1;
        }, "Please specify a valid value.");

        $('#paid_amount').val('0');
    });
</script>

<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        const productInput = document.getElementById('product_name');
        const productSuggestions = document.getElementById('product_suggestions');
        const productTableBody = document.getElementById('product_table_body');

        // Function to fetch product suggestions
        function fetchProductSuggestions(query) {
            // Construct the URL for AJAX request
            var url = '<?= site_url(route_to('purchases.search')) ?>?query=' + encodeURIComponent(query);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Clear previous suggestions
                    productSuggestions.innerHTML = '';

                    // Populate suggestions
                    data.forEach(product => {
                        const suggestion = document.createElement('button');
                        suggestion.classList.add('list-group-item', 'list-group-item-action');
                        suggestion.textContent = product.product_name;

                        suggestion.addEventListener('click', function () {
                            addProductToTable(product);
                            productSuggestions.innerHTML = '';
                            productInput.value = '';
                        });

                        productSuggestions.appendChild(suggestion);
                    });
                })
                .catch(error => {
                    console.error('Error fetching product suggestions:', error);
                });
        }

        // Function to add product to the table
        function addProductToTable(product) {
            const row = document.createElement('tr');

            row.innerHTML = `
            <td>${product.product_name}</td>
            <td><input type="number" class="form-control" name="quantity[]" value="1" required></td>
            <td><input type="number" class="form-control" name="purchase_price[]" value="${product.customer_price}" required></td>
            <!-- Add more columns as needed -->
            <td><button type="button" class="btn btn-sm btn-danger btn-remove-product">Remove</button></td>
        `;

            productTableBody.appendChild(row);
            updateTotalAmount();
        }

        // Function to update total amount
        function updateTotalAmount() {
            let totalAmount = 0;
            const rows = productTableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const quantity = parseInt(row.querySelector('input[name="quantity[]"]').value);
                const purchasePrice = parseFloat(row.querySelector('input[name="purchase_price[]"]').value);
                const totalRow = row.querySelector('.total-row');

                const total = quantity * purchasePrice;
                totalRow.textContent = total.toFixed(2);
                totalAmount += total;
            });

            document.getElementById('total_amount_display').value = totalAmount.toFixed(2);
            document.querySelector('input[name="total_amount"]').value = totalAmount.toFixed(2);

            // Calculate remaining amount if paid amount is filled
            updateRemainingAmount();
        }

        // Function to update remaining amount based on paid amount
        function updateRemainingAmount() {
            const totalAmount = parseFloat(document.getElementById('total_amount_display').value);
            const paidAmount = parseFloat(document.getElementById('paid_amount').value);
            const remainingAmountDisplay = document.getElementById('remaining_amount_display');

            const remainingAmount = totalAmount - paidAmount;
            remainingAmountDisplay.value = remainingAmount.toFixed(2);
            document.querySelector('input[name="remaining_amount"]').value = remainingAmount.toFixed(2);
        }

        // Event listener for product search input
        productInput.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length >= 2) {
                fetchProductSuggestions(query);
            } else {
                productSuggestions.innerHTML = '';
            }
        });

        // Event listener for removing product from table
        productTableBody.addEventListener('click', function (event) {
            if (event.target.classList.contains('btn-remove-product')) {
                event.target.closest('tr').remove();
                updateTotalAmount();
            }
        });

        // Event listener for paid amount input
        document.getElementById('paid_amount').addEventListener('input', updateRemainingAmount);

        // Initial update of total amount and remaining amount
        updateTotalAmount();
        updateRemainingAmount();
    });

</script>

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>


<?= $this->endSection() ?>