<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.edit_variation') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo url('/product-management/variations') ?>"><?php echo lang('App.variations') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.edit_variation') ?></li>
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
                        <h3 class="card-title"><?= lang('App.edit_variation') ?></h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open(route_to('variations.update', $variation->id), ['id' => 'variation-edit', 'method' => 'post', 'autocomplete' => 'off']); ?>
                            <div class="form-group">
                                <label for="variation_name"><?= lang('App.variation_name') ?></label>
                                <input type="text" class="form-control" name="variation_name" id="variation_name" placeholder="<?= lang('App.variation_name') ?>" value="<?= $variation->variation_name ?>" autofocus />
                                <?php if(isset($validation) && $validation->getError('variation_name')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('variation_name') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="variation_status"><?= lang('App.variation_status') ?></label>
                                <select class="form-control" name="variation_status" id="variation_status">
                                    <option value="active" <?= ($variation->variation_status === 'active') ? 'selected' : '' ?>><?= lang('App.active') ?></option>
                                    <option value="inactive" <?= ($variation->variation_status === 'inactive') ? 'selected' : '' ?>><?= lang('App.inactive') ?></option>
                                </select>
                                <?php if(isset($validation) && $validation->getError('variation_status')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('variation_status') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                                <a href="<?= url('/product-management/variations') ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger">
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
    $('#variation-edit').validate({
        rules: {
            variation_name: {
                required: true,
            },
            variation_status: {
                required: true,
            },
        },
        messages: {
            variation_name: {
                required: "Please enter the variation name",
            },
            variation_status: {
                required: "Please select the variation status",
            },
        },
    });
});
</script>
<?= $this->endSection() ?>
