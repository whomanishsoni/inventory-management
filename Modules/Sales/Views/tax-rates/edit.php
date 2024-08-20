<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.edit_tax_rate') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                                        <li class="breadcrumb-item active"><a
                            href="<?php echo url('/product-management/tax-groups') ?>"><?php echo lang('App.tax_groups') ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo url('/product-management/tax-rates/group/' . $taxRate->group_id) ?>"><?php echo lang('App.tax_rates') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.edit_tax_rate') ?></li>
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
                        <h3 class="card-title"><?= lang('App.edit_tax_rate') ?></h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open(route_to('tax-rates.update', $taxRate->id), ['id' => 'tax-rate-edit', 'method' => 'post', 'autocomplete' => 'off']); ?>
                            <div class="form-group">
                                <label for="tax_name"><?= lang('App.tax_name') ?></label>
                                <input type="text" class="form-control" name="tax_name" id="tax_name" placeholder="<?= lang('App.tax_name') ?>" value="<?= $taxRate->tax_name ?>" autofocus />
                                <?php if(isset($validation) && $validation->getError('tax_name')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('tax_name') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="tax_rate"><?= lang('App.tax_rate') ?></label>
                                <input type="text" class="form-control" name="tax_rate" id="tax_rate" placeholder="<?= lang('App.tax_rate') ?>" value="<?= $taxRate->tax_rate ?>" />
                                <?php if(isset($validation) && $validation->getError('tax_rate')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('tax_rate') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="tax_status"><?= lang('App.tax_status') ?></label>
                                <select class="form-control" name="tax_status" id="tax_status">
                                    <option value="active" <?= ($taxRate->tax_status === 'active') ? 'selected' : '' ?>><?= lang('App.active') ?></option>
                                    <option value="inactive" <?= ($taxRate->tax_status === 'inactive') ? 'selected' : '' ?>><?= lang('App.inactive') ?></option>
                                </select>
                                <?php if(isset($validation) && $validation->getError('tax_status')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('tax_status') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                                <a href="<?= url('/product-management/tax-rates/group/' . $taxRate->group_id) ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger">
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
    $('#tax-rate-edit').validate({
        rules: {
            tax_name: {
                required: true,
            },
            tax_rate: {
                required: true,
            },
            tax_status: {
                required: true,
            },
        },
        messages: {
            tax_name: {
                required: "Please enter the tax rate name",
            },
            tax_rates: {
                required: "Please enter the tax rate",
            },
            tax_status: {
                required: "Please select the tax rate status",
            },
        },
    });
});
</script>
<?= $this->endSection() ?>
