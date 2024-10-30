<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.add_customer') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><a
                            href="<?php echo url('/customers') ?>"><?php echo lang('App.customers') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.add_customer') ?></li>
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
                        <h3 class="card-title"><?= lang('App.add_customer') ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php echo form_open(route_to('customers.store'), ['id' => 'customer-add', 'method' => 'post', 'autocomplete' => 'off']); ?>
                            <div class="row">
                                <div class="col-12">
                                    <!-- Customer Name -->
                                    <div class="form-group">
                                        <label for="customer_name"><?= lang('App.customer_name') ?></label>
                                        <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="<?= lang('App.customer_name') ?>" autofocus />
                                        <?php if(isset($validation) && $validation->getError('customer_name')): ?>
                                            <p class='text-danger mt-2'>
                                                <?= $validation->getError('customer_name') ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Customer Email -->
                                    <div class="form-group">
                                        <label for="customer_email"><?= lang('App.customer_email') ?></label>
                                        <input type="email" class="form-control" name="customer_email" id="customer_email" placeholder="<?= lang('App.customer_email') ?>" />
                                        <?php if(isset($validation) && $validation->getError('customer_email')): ?>
                                            <p class='text-danger mt-2'>
                                                <?= $validation->getError('customer_email') ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Customer Phone Number -->
                                    <div class="form-group">
                                        <label for="customer_phone"><?= lang('App.customer_phone') ?></label>
                                        <input type="text" class="form-control" name="customer_phone" id="customer_phone" placeholder="<?= lang('App.customer_phone') ?>" />
                                        <?php if(isset($validation) && $validation->getError('customer_phone')): ?>
                                            <p class='text-danger mt-2'>
                                                <?= $validation->getError('customer_phone') ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Customer Address -->
                                    <div class="form-group">
                                        <label for="customer_address"><?= lang('App.customer_address') ?></label>
                                        <textarea class="form-control" name="customer_address" id="customer_address" placeholder="<?= lang('App.customer_address') ?>"></textarea>
                                        <?php if(isset($validation) && $validation->getError('customer_address')): ?>
                                            <p class='text-danger mt-2'>
                                                <?= $validation->getError('customer_address') ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Customer Pincode -->
                                    <div class="form-group">
                                        <label for="customer_pincode"><?= lang('App.customer_pincode') ?></label>
                                        <input type="text" class="form-control" name="customer_pincode" id="customer_pincode" placeholder="<?= lang('App.customer_pincode') ?>" />
                                        <?php if(isset($validation) && $validation->getError('customer_pincode')): ?>
                                            <p class='text-danger mt-2'>
                                                <?= $validation->getError('customer_pincode') ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Location Fields -->
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Country Input -->
                                    <div class="form-group">
                                        <label for="country_id"><?= lang('App.country_name') ?></label>
                                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="country_id" name="country_id">
                                            <option value="" selected><?= lang('App.select_country') ?></option>
                                            <?php foreach ($countries as $country): ?>
                                                <option value="<?= $country->id; ?>"><?= $country->country_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if(isset($validation) && $validation->getError('country_id')): ?>
                                            <p class='text-danger mt-2'>
                                                <?= esc($validation->getError('country_id')) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- State Input -->
                                    <div class="form-group">
                                        <label for="state_id"><?= lang('App.state_name') ?></label>
                                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="state_id" name="state_id">
                                            <option value="" selected><?= lang('App.select_state') ?></option>
                                        </select>
                                        <?php if(isset($validation) && $validation->getError('state_id')): ?>
                                            <p class='text-danger mt-2'>
                                                <?= esc($validation->getError('state_id')) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- City Input -->
                                    <div class="form-group">
                                        <label for="city_id"><?= lang('App.city_name') ?></label>
                                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="city_id" name="city_id">
                                            <option value="" selected><?= lang('App.select_city') ?></option>
                                        </select>
                                        <?php if(isset($validation) && $validation->getError('city_id')): ?>
                                            <p class='text-danger mt-2'>
                                                <?= esc($validation->getError('city_id')) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Status -->
                            <div class="form-group">
                                <label for="customer_status"><?= lang('App.customer_status') ?></label>
                                <select class="form-control" name="customer_status" id="customer_status">
                                    <option value=""><?= lang('App.select_status') ?></option>
                                    <option value="active" selected><?= lang('App.active') ?></option>
                                    <option value="inactive"><?= lang('App.inactive') ?></option>
                                </select>
                                <?php if(isset($validation) && $validation->getError('customer_status')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('customer_status') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <!-- Form Buttons -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                                <a href="<?= url('/customers') ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger"><?= lang('App.cancel') ?></a>
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

    $('#customer-add').validate({
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