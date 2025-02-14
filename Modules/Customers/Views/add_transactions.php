<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.add_transaction') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo url('/customers') ?>"><?php echo lang('App.customers') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.add_transaction') ?></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('App.add_transaction') ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php echo form_open(route_to('customers.store_transaction', $customerId), ['id' => 'transaction-add', 'method' => 'post', 'autocomplete' => 'off']); ?>
                        <div class="row">
                            <div class="col-12">
                                <!-- Customer Name -->
                                <div class="form-group">
                                    <label for="customer_name"><?= lang('App.customer_name') ?></label>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                                        value="<?= esc($customerName) ?>" readonly />
                                </div>

                                <!-- Customer ID (Hidden) -->
                                <input type="hidden" name="customer_id" value="<?= esc($customerId) ?>" />

                                <!-- Transaction Type -->
                                <div class="form-group">
                                    <label for="transaction_type"><?= lang('App.transaction_type') ?></label>
                                    <select name="transaction_type" id="transaction_type"
                                        class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" required>
                                        <option value=""><?= lang('App.select_transaction_type') ?></option>
                                        <option value="credit"><?= lang('App.credit') ?></option>
                                        <option value="debit"><?= lang('App.debit') ?></option>
                                    </select>
                                    <?php if (isset($validation) && $validation->getError('transaction_type')): ?>
                                        <p class='text-danger mt-2'>
                                            <?= $validation->getError('transaction_type') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <!-- Transaction Date -->
                                <div class="form-group">
                                    <label for="transaction_date"><?= lang('App.transaction_date') ?></label>
                                    <input type="date" class="form-control" name="transaction_date"
                                        id="transaction_date" placeholder="<?= lang('App.transaction_date') ?>" />
                                    <?php if (isset($validation) && $validation->getError('transaction_date')): ?>
                                        <p class='text-danger mt-2'>
                                            <?= $validation->getError('transaction_date') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <!-- Transaction Amount -->
                                <div class="form-group">
                                    <label for="transaction_amount"><?= lang('App.transaction_amount') ?></label>
                                    <input type="number" class="form-control" name="transaction_amount"
                                        id="transaction_amount" placeholder="<?= lang('App.transaction_amount') ?>"
                                        step="0.01" required />
                                    <?php if (isset($validation) && $validation->getError('transaction_amount')): ?>
                                        <p class='text-danger mt-2'>
                                            <?= $validation->getError('transaction_amount') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <!-- Transaction Description -->
                                <div class="form-group">
                                    <label
                                        for="transaction_description"><?= lang('App.transaction_description') ?></label>
                                    <textarea class="form-control" name="transaction_description"
                                        id="transaction_description"
                                        placeholder="<?= lang('App.transaction_description') ?>"></textarea>
                                    <?php if (isset($validation) && $validation->getError('transaction_description')): ?>
                                        <p class='text-danger mt-2'>
                                            <?= $validation->getError('transaction_description') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <!-- Transaction Reference Id -->
                                <div class="form-group">
                                    <label
                                        for="transaction_reference_id"><?= lang('App.transaction_reference_id') ?></label>
                                    <input type="text" class="form-control" name="transaction_reference_id"
                                        id="transaction_reference_id"
                                        placeholder="<?= lang('App.transaction_reference_id') ?>" />
                                    <?php if (isset($validation) && $validation->getError('transaction_reference_id')): ?>
                                        <p class='text-danger mt-2'>
                                            <?= $validation->getError('transaction_reference_id') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                            <a href="<?= url('/customers/transactions/' . $customerId) ?>"
                                onclick="return confirm('Are you sure you want to leave?')"
                                class="btn btn-flat btn-danger"><?= lang('App.cancel') ?></a>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- /.content -->



<?= $this->endSection() ?>
<?= $this->section('js') ?>
<!-- jquery-validation -->
<script src="<?php echo assets_url('admin') ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo assets_url('admin') ?>/plugins/jquery-validation/additional-methods.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        // Set default options for jQuery Validation
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
            }
        });

        $('#transaction-add').validate({
            rules: {
                customer_name: {
                    required: true,
                },
                transaction_type: {
                    required: true,
                },
                transaction_date: {
                    required: true,
                    date: true,
                },
                transaction_amount: {
                    required: true,
                    number: true,
                    min: 0,
                },
                transaction_description: {
                    required: false,
                    maxlength: 255,
                },
                transaction_reference_id: {
                    required: false,
                    maxlength: 255,
                },
            },
            messages: {
                customer_name: {
                    required: "Please enter the customer name",
                },
                transaction_type: {
                    required: "Please select the transaction type",
                },
                transaction_date: {
                    required: "Please enter the transaction date",
                    date: "Please enter a valid date",
                },
                transaction_amount: {
                    required: "Please enter the amount",
                    number: "Please enter a valid number",
                    min: "Amount cannot be negative",
                },
                transaction_description: {
                    maxlength: "Description cannot be more than 255 characters",
                },
                transaction_reference_id: {
                    maxlength: "Reference ID cannot be more than 255 characters",
                },
            },
        });

        $('.select2').select2();
    });
</script>

<?= $this->endSection() ?>