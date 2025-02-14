<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.edit_supplier') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo url('/suppliers') ?>"><?php echo lang('App.suppliers') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.edit_supplier') ?></li>
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
                        <h3 class="card-title"><?= lang('App.edit_supplier') ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php echo form_open(route_to('suppliers.update', $supplier->id), ['id' => 'supplier-edit', 'method' => 'post', 'autocomplete' => 'off']); ?>
                        <div class="row">
                            <div class="col-12">
                                <!-- Supplier Name -->
                                <div class="form-group">
                                    <label for="supplier_name"><?= lang('App.supplier_name') ?></label>
                                    <input type="text" class="form-control" name="supplier_name" id="supplier_name"
                                        placeholder="<?= lang('App.supplier_name') ?>"
                                        value="<?= $supplier->supplier_name ?>" autofocus />
                                    <?php if(isset($validation) && $validation->getError('supplier_name')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('supplier_name') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Supplier Contact Person -->
                                <div class="form-group">
                                    <label
                                        for="supplier_contact_person"><?= lang('App.supplier_contact_person') ?></label>
                                    <input type="text" class="form-control" name="supplier_contact_person"
                                        id="supplier_contact_person"
                                        placeholder="<?= lang('App.supplier_contact_person') ?>"
                                        value="<?= $supplier->supplier_contact_person ?>" />
                                    <?php if(isset($validation) && $validation->getError('supplier_contact_person')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('supplier_contact_person') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Supplier Email -->
                                <div class="form-group">
                                    <label for="supplier_email"><?= lang('App.supplier_email') ?></label>
                                    <input type="email" class="form-control" name="supplier_email" id="supplier_email"
                                        placeholder="<?= lang('App.supplier_email') ?>"
                                        value="<?= $supplier->supplier_email ?>" />
                                    <?php if(isset($validation) && $validation->getError('supplier_email')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('supplier_email') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Supplier Phone Number -->
                                <div class="form-group">
                                    <label for="supplier_phone"><?= lang('App.supplier_phone') ?></label>
                                    <input type="text" class="form-control" name="supplier_phone" id="supplier_phone"
                                        placeholder="<?= lang('App.supplier_phone') ?>"
                                        value="<?= $supplier->supplier_phone ?>" />
                                    <?php if(isset($validation) && $validation->getError('supplier_phone')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('supplier_phone') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Supplier Address -->
                                <div class="form-group">
                                    <label for="supplier_address"><?= lang('App.supplier_address') ?></label>
                                    <textarea class="form-control" name="supplier_address" id="supplier_address"
                                        placeholder="<?= lang('App.supplier_address') ?>"><?= $supplier->supplier_address ?></textarea>
                                    <?php if(isset($validation) && $validation->getError('supplier_address')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('supplier_address') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Supplier Pincode -->
                                <div class="form-group">
                                    <label for="supplier_pincode"><?= lang('App.supplier_pincode') ?></label>
                                    <input type="text" class="form-control" name="supplier_pincode"
                                        id="supplier_pincode" placeholder="<?= lang('App.supplier_pincode') ?>"
                                        value="<?= $supplier->supplier_pincode ?>" />
                                    <?php if(isset($validation) && $validation->getError('supplier_pincode')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('supplier_pincode') ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <!-- Supplier Notes -->
                                <div class="form-group">
                                    <label for="supplier_notes"><?= lang('App.supplier_notes') ?></label>
                                    <textarea class="form-control" name="supplier_notes" id="supplier_notes"
                                        placeholder="<?= lang('App.supplier_notes') ?>"><?= $supplier->supplier_notes ?></textarea>
                                    <?php if(isset($validation) && $validation->getError('supplier_notes')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('supplier_notes') ?>
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
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="country_id" name="country_id">
                                        <option value="" selected disabled><?= lang('App.select_country') ?></option>
                                        <?php foreach ($countries as $country): ?>
                                        <option value="<?= $country->id ?>"
                                            <?= ($country->id == $supplier->country_id) ? 'selected' : '' ?>>
                                            <?= $country->country_name ?>
                                        </option>
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
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="state_id" name="state_id">
                                        <option value="" selected disabled><?= lang('App.select_state') ?></option>
                                        <?php foreach ($states as $state): ?>
                                        <option value="<?= $state->id ?>"
                                            <?= ($state->id == $supplier->state_id) ? 'selected' : '' ?>>
                                            <?= $state->state_name ?>
                                        </option>
                                        <?php endforeach; ?>
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
                                    <select class="form-control select2 select2-danger"
                                        data-dropdown-css-class="select2-danger" id="city_id" name="city_id">
                                        <option value="" selected disabled><?= lang('App.select_city') ?></option>
                                        <?php foreach ($cities as $city): ?>
                                        <option value="<?= $city->id ?>"
                                            <?= ($city->id == $supplier->city_id) ? 'selected' : '' ?>>
                                            <?= $city->city_name ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if(isset($validation) && $validation->getError('city_id')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= esc($validation->getError('city_id')) ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Supplier Status -->
                        <div class="form-group">
                            <label for="supplier_status"><?= lang('App.supplier_status') ?></label>
                            <select class="form-control" name="supplier_status" id="supplier_status">
                                <option value="active"
                                    <?= ($supplier->supplier_status === 'active') ? 'selected' : '' ?>>
                                    <?= lang('App.active') ?></option>
                                <option value="inactive"
                                    <?= ($supplier->supplier_status === 'inactive') ? 'selected' : '' ?>>
                                    <?= lang('App.inactive') ?></option>
                            </select>
                            <?php if(isset($validation) && $validation->getError('supplier_status')): ?>
                            <p class='text-danger mt-2'>
                                <?= $validation->getError('supplier_status') ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        <!-- Form Buttons -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                            <a href="<?= url('/suppliers') ?>"
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
    $('#supplier-edit').validate({
        rules: {
            supplier_name: {
                required: true,
            },
            supplier_contact_person: {
                required: true,
            },
            supplier_email: {
                required: true,
            },
            supplier_phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
            },
            supplier_address: {
                required: false,
            },
            supplier_pincode: {
                required: false,
                minlength: 6,
                maxlength: 6,
            },
            supplier_notes: {
                required: false,
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
            supplier_status: {
                required: true,
            },
        },
        messages: {
            supplier_name: {
                required: "Please enter the supplier name",
            },
            supplier_contact_person: {
                required: "Please enter the supplier contact person",
            },
            supplier_email: {
                required: "Please enter the email",
            },
            supplier_phone: {
                required: "Please enter the mobile number",
                minlength: "Mobile number must be 10 digits",
                maxlength: "Mobile number must be 10 digits",
            },
            supplier_address: {
                required: "Please enter the address",
            },
            supplier_pincode: {
                required: "Please enter the pincode",
                minlength: "Pincode must be 6 digits",
                maxlength: "Pincode must be 6 digits",
            },
            supplier_notes: {
                required: "Please enter the notes",
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
            supplier_status: {
                required: "Please select the supplier status",
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
                url: "<?php echo site_url(route_to('suppliers.get_states'));?>",
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
                url: "<?php echo site_url(route_to('suppliers.get_cities'));?>",
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