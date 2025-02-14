<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.edit_customer') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo url('/customers') ?>"><?php echo lang('App.customers') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.edit_customer') ?></li>
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
                        <h3 class="card-title"><?= lang('App.edit_transaction') ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php echo form_open(route_to('customers.update_transaction', $transaction->id), ['id' => 'transaction-edit', 'method' => 'post', 'autocomplete' => 'off']); ?>
                        <div class="row">
                            <div class="col-12">
                                <!-- Customer Name (Read-only) -->
                                <div class="form-group">
                                    <label for="customer_name"><?= lang('App.customer_name') ?></label>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                                        value="<?= esc($customerName) ?>" readonly />
                                </div>
                                <!-- Transaction Type -->
                                <div class="form-group">
                                    <label for="transaction_type"><?= lang('App.transaction_type') ?></label>
                                    <select name="transaction_type" id="transaction_type"
                                        class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" required>
                                        <option value="credit" <?= $transaction->transaction_type == 'credit' ? 'selected' : '' ?>><?= lang('App.credit') ?></option>
                                        <option value="debit" <?= $transaction->transaction_type == 'debit' ? 'selected' : '' ?>><?= lang('App.debit') ?></option>
                                    </select>
                                    <?php if(isset($validation) && $validation->getError('transaction_type')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('transaction_type') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Transaction Date -->
                                <div class="form-group">
                                    <label for="transaction_date"><?= lang('App.transaction_date') ?></label>
                                    <input type="date" class="form-control" name="transaction_date" id="transaction_date"
                                        value="<?= esc($transaction->transaction_date) ?>" />
                                    <?php if(isset($validation) && $validation->getError('transaction_date')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('transaction_date') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Transaction Amount -->
                                <div class="form-group">
                                    <label for="transaction_amount"><?= lang('App.transaction_amount') ?></label>
                                    <input type="number" class="form-control" name="transaction_amount" id="transaction_amount"
                                        value="<?= esc($transaction->amount) ?>" />
                                    <?php if(isset($validation) && $validation->getError('transaction_amount')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('transaction_amount') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Transaction Description -->
                                <div class="form-group">
                                    <label for="transaction_description"><?= lang('App.transaction_description') ?></label>
                                    <input type="text" class="form-control" name="transaction_description"
                                        id="transaction_description"
                                        value="<?= esc($transaction->description) ?>"
                                        placeholder="<?= lang('App.transaction_description') ?>" />
                                    <?php if(isset($validation) && $validation->getError('transaction_description')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('transaction_description') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Transaction Reference Id -->
                                <div class="form-group">
                                    <label for="transaction_reference_id"><?= lang('App.transaction_reference_id') ?></label>
                                    <input type="text" class="form-control" name="transaction_reference_id"
                                        id="transaction_reference_id"
                                        value="<?= esc($transaction->reference_id) ?>"
                                        placeholder="<?= lang('App.transaction_reference_id') ?>" />
                                    <?php if(isset($validation) && $validation->getError('transaction_reference_id')): ?>
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
                            <a href="<?= url(route_to('customers.transactions', $customerId)) ?>"
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
    $('#customer-edit').validate({
        rules: {
            customer_name: {
                required: true,
            },
            customer_email: {
                required: true,
            },
            customer_phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
            },
            customer_address: {
                required: false,
            },
            customer_pincode: {
                required: false,
                minlength: 6,
                maxlength: 6,
            },
            country_id: {
                required: true,
            },
            state_id: {
                required: true,
            },
            city_id: {
                required: true,
            },
            customer_status: {
                required: true,
            },
        },
        messages: {
            customer_name: {
                required: "Please enter the customer name",
            },
            customer_email: {
                required: "Please enter the email",
            },
            customer_phone: {
                required: "Please enter the mobile number",
                minlength: "Mobile number must be 10 digits",
                maxlength: "Mobile number must be 10 digits",
            },
            customer_address: {
                required: "Please enter the address",
            },
            customer_pincode: {
                required: "Please enter the pincode",
                minlength: "Pincode must be 6 digits",
                maxlength: "Pincode must be 6 digits",
            },
            country_id: {
                required: "Please select the country",
            },
            state_id: {
                required: "Please select the state",
            },
            city_id: {
                required: "Please select the city",
            },
            customer_status: {
                required: "Please select the customer status",
            },
        },
    });
});
$('.select2').select2()
</script>
<script>
$(document).ready(function() {
    // When the country selection changes
    $('#country_id').change(function() {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(route_to('customers.get_states'));?>",
                data: {
                    'country_id': countryId,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Response from server:", response);
                    $('#state_id').empty();
                    $('#state_id').append('<option value="">Select State</option>');
                    $.each(response, function(key, value) {
                        $('#state_id').append('<option value="' + value.id + '">' +
                            value.state_name + '</option>');
                    });
                }
            });
        } else {
            $('#state_id').empty();
        }
    });

    // When the state selection changes
    $('#state_id').change(function() {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(route_to('customers.get_cities'));?>",
                data: {
                    'state_id': stateId
                },
                dataType: 'json',
                success: function(response) {
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select City</option>');
                    $.each(response, function(key, value) {
                        $('#city_id').append('<option value="' + value.id + '">' +
                            value.city_name + '</option>');
                    });
                }
            });
        } else {
            $('#city_id').empty();
        }
    });

});
</script>
<?= $this->endSection() ?>