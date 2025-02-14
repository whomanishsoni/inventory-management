<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.add_city') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><a
                            href="<?php echo url('/locations/cities') ?>"><?php echo lang('App.cities') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.add_city') ?></li>
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
                        <h3 class="card-title"><?= lang('App.add_city') ?></h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open(route_to('cities.store'), ['id' => 'city-add', 'method' => 'post', 'autocomplete' => 'off']); ?>
                            
                        <div class="form-group">
                                <label for="country_id"><?= lang('App.country_name') ?></label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="country_id" name="country_id">
                                    <option value="" selected><?= lang('App.select_country') ?></option>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?= $country->id ?>"><?= ucfirst($country->country_name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(isset($validation) && $validation->getError('country_id')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= esc($validation->getError('country_id')) ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="state_id"><?= lang('App.state_name') ?></label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="state_id" name="state_id">
                                    <option value="" selected><?= lang('App.select_state') ?></option>
                                    <?php foreach ($states as $state): ?>
                                        <option value="<?= $state->id ?>"><?= ucfirst($state->state_name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(isset($validation) && $validation->getError('state_id')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= esc($validation->getError('state_id')) ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="city_name"><?= lang('App.city_name') ?></label>
                                <input type="text" class="form-control" name="city_name" id="city_name" placeholder="<?= lang('App.city_name') ?>" autofocus />
                                <?php if(isset($validation) && $validation->getError('city_name')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('city_name') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="city_status"><?= lang('App.city_status') ?></label>
                                <select class="form-control" name="city_status" id="city_status">
                                    <option value=""><?= lang('App.select_status') ?></option>
                                    <option value="active" selected><?= lang('App.active') ?></option>
                                    <option value="inactive"><?= lang('App.inactive') ?></option>
                                </select>
                                <?php if(isset($validation) && $validation->getError('city_status')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('city_status') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                                <a href="<?= url('/locations/cities') ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger">
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

    $('#city-add').validate({
        rules: {
            country_id: {
                required: true,
                integer: true
            },
            state_id: {
                required: true,
                integer: true
            },
            city_name: {
                required: true,
            },
            city_status: {
                required: true,
            },
        },
        messages: {
            country_id: {
                required: "Please select a country",
                integer: "Please select a valid country"
            },
            state_id: {
                required: "Please select a state",
                integer: "Please select a valid state"
            }
            city_name: {
                required: "Please enter the city name",
            },
            city_status: {
                required: "Please select the city status",
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
