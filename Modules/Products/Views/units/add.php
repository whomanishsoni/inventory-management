<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.add_unit') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><a
                            href="<?php echo url('/product-management/units') ?>"><?php echo lang('App.units') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.add_unit') ?></li>
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
                        <h3 class="card-title"><?= lang('App.add_unit') ?></h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open(route_to('units.store'), ['id' => 'unit-add', 'method' => 'post', 'autocomplete' => 'off']); ?>
                            <div class="form-group">
                                <label for="unit_name"><?= lang('App.unit_name') ?></label>
                                <input type="text" class="form-control" name="unit_name" id="unit_name" placeholder="<?= lang('App.unit_name') ?>" autofocus />
                                <?php if(isset($validation) && $validation->getError('unit_name')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('unit_name') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="unit_abbreviation"><?= lang('App.unit_short_name') ?></label>
                                <input type="text" class="form-control" name="unit_abbreviation" id="unit_abbreviation" placeholder="<?= lang('App.unit_short_name') ?>" />
                                <?php if(isset($validation) && $validation->getError('unit_abbreviation')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('unit_abbreviation') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="unit_status"><?= lang('App.unit_status') ?></label>
                                <select class="form-control" name="unit_status" id="unit_status">
                                    <option value=""><?= lang('App.select_status') ?></option>
                                    <option value="active" selected><?= lang('App.active') ?></option>
                                    <option value="inactive"><?= lang('App.inactive') ?></option>
                                </select>
                                <?php if(isset($validation) && $validation->getError('unit_status')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('unit_status') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                                <a href="<?= url('/product-management/units') ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger">
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

    $('#unit-add').validate({
        rules: {
            unit_name: {
                required: true,
            },
            unit_abbreviation: {
                required: true,
            },
            unit_status: {
                required: true,
            },
        },
        messages: {
            unit_name: {
                required: "Please enter the unit name",
            },
            unit_abbreviation: {
                required: "Please enter the unit short name",
            },
            unit_status: {
                required: "Please select the unit status",
            },
        },
    });
});
</script>


<?= $this->endSection() ?>
