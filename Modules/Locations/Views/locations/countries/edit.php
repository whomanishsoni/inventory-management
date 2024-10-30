<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.edit_country') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo url('/locations/countries') ?>"><?php echo lang('App.countries') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.edit_country') ?></li>
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
                        <h3 class="card-title"><?= lang('App.edit_country') ?></h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open(route_to('countries.update', $country->id), ['id' => 'country-edit', 'method' => 'post', 'autocomplete' => 'off']); ?>
                            <div class="form-group">
                                <label for="country_name"><?= lang('App.country_name') ?></label>
                                <input type="text" class="form-control" name="country_name" id="country_name" placeholder="<?= lang('App.country_name') ?>" value="<?= $country->country_name ?>" autofocus />
                                <?php if(isset($validation) && $validation->getError('country_name')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('country_name') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="country_status"><?= lang('App.country_status') ?></label>
                                <select class="form-control" name="country_status" id="country_status">
                                    <option value="active" <?= ($country->country_status === 'active') ? 'selected' : '' ?>><?= lang('App.active') ?></option>
                                    <option value="inactive" <?= ($country->country_status === 'inactive') ? 'selected' : '' ?>><?= lang('App.inactive') ?></option>
                                </select>
                                <?php if(isset($validation) && $validation->getError('country_status')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('country_status') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                                <a href="<?= url('/locations/countries') ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger">
                                    <?= lang('App.cancel') ?>
                                </a>
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
    $('#country-edit').validate({
        rules: {
            country_name: {
                required: true,
            },
            country_status: {
                required: true,
            },
        },
        messages: {
            country_name: {
                required: "Please enter the country name",
            },
            country_status: {
                required: "Please select the country status",
            },
        },
    });
});
</script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<?= $this->endSection() ?>
