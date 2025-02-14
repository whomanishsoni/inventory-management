<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.edit_variation_value') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo url('/product-management/variations') ?>"><?php echo lang('App.variations') ?></a></li>
                    <li class="breadcrumb-item active"><a
                            href="<?= site_url('/product-management/variation-values/list/' . $variationId) ?>"><?= lang('App.variation_values') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.edit_variation_value') ?></li>
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
                        <h3 class="card-title"><?= lang('App.edit_variation_value') ?></h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open(route_to('variation-values.update', $variationId, $variationValue->id), ['id' => 'variation-value-edit', 'method' => 'post', 'autocomplete' => 'off']); ?>
                            <div class="form-group">
                                <label for="variation_value"><?= lang('App.variation_value') ?></label>
                                <input type="text" class="form-control" name="variation_value" id="variation_value" placeholder="<?= lang('App.variation_value') ?>" value="<?= $variationValue->variation_value ?>" autofocus />
                                <?php if(isset($validation) && $validation->getError('variation_value')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('variation_value') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="variation_value_status"><?= lang('App.variation_status') ?></label>
                                <select class="form-control" name="variation_value_status" id="variation_value_status">
                                    <option value="active" <?= ($variationValue->variation_value_status === 'active') ? 'selected' : '' ?>><?= lang('App.active') ?></option>
                                    <option value="inactive" <?= ($variationValue->variation_value_status === 'inactive') ? 'selected' : '' ?>><?= lang('App.inactive') ?></option>
                                </select>
                                <?php if(isset($validation) && $validation->getError('variation_value_status')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('variation_value_status') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                                <a href="<?= url('/product-management/variation-values/list/' . $variationId) ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger">
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
    $('#variation-value-edit').validate({
        rules: {
            variation_value: {
                required: true,
            },
            variation_value_status: {
                required: true,
            },
        },
        messages: {
            variation_value: {
                required: "Please enter the variation value",
            },
            variation_value_status: {
                required: "Please select the variation value status",
            },
        },
    });
});
</script>
<?= $this->endSection() ?>
