<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.add_state') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><a
                            href="<?php echo url('/locations/states') ?>"><?php echo lang('App.states') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.add_state') ?></li>
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
                        <h3 class="card-title"><?= lang('App.add_state') ?></h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open(route_to('states.store'), ['id' => 'state-add', 'method' => 'post', 'autocomplete' => 'off']); ?>

                        <!-- Country Input -->
                        <div class="form-group">
                            <label for="country_id"><?= lang('App.country_name') ?></label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                                id="country_id" name="country_id" required>
                                <option value="" selected><?= lang('App.select_country') ?></option>
                                <?php foreach ($countries as $country): ?>
                                <option value="<?= $country->id; ?>"><?= ucfirst($country->country_name); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($validation) && $validation->getError('country_id')): ?>
                            <p class='text-danger mt-2'>
                                <?= esc($validation->getError('country_id')) ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <!-- State Input -->
                        <div class="form-group">
                            <label for="state_name"><?= lang('App.state_name') ?></label>
                            <input type="text" class="form-control" name="state_name" id="state_name"
                                placeholder="<?= lang('App.state_name') ?>" autofocus />
                            <?php if(isset($validation) && $validation->getError('state_name')): ?>
                            <p class='text-danger mt-2'>
                                <?= $validation->getError('state_name') ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="state_status"><?= lang('App.state_status') ?></label>
                            <select class="form-control" name="state_status" id="state_status">
                                <option value=""><?= lang('App.select_status') ?></option>
                                <option value="active" selected><?= lang('App.active') ?></option>
                                <option value="inactive"><?= lang('App.inactive') ?></option>
                            </select>
                            <?php if(isset($validation) && $validation->getError('state_status')): ?>
                            <p class='text-danger mt-2'>
                                <?= $validation->getError('state_status') ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                            <a href="<?= url('/locations/states') ?>"
                                onclick="return confirm('Are you sure you want to leave?')"
                                class="btn btn-flat btn-danger">
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

    $('#state-add').validate({
        rules: {
            country_id: {
                required: true,
            },
            state_name: {
                required: true,
            },
            state_status: {
                required: true,
            },
        },
        messages: {
            country_id: {
                required: "Please select a country",
            },
            state_name: {
                required: "Please enter the state name",
            },
            state_status: {
                required: "Please select the state status",
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