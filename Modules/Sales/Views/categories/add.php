<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.add_category') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><a
                            href="<?php echo url('/product-management/categories') ?>"><?php echo lang('App.categories') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.add_category') ?></li>
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
                        <h3 class="card-title"><?= lang('App.add_category') ?></h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open(route_to('categories.store'), ['id' => 'category-add', 'method' => 'post', 'autocomplete' => 'off']); ?>
                            <div class="form-group">
                                <label for="category_name"><?= lang('App.category_name') ?></label>
                                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="<?= lang('App.category_name') ?>" autofocus />
                                <?php if(isset($validation) && $validation->getError('category_name')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('category_name') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="category_description"><?= lang('App.category_description') ?></label>
                                <input type="text" class="form-control" name="category_description" id="category_description" placeholder="<?= lang('App.category_description') ?>" />
                                <?php if(isset($validation) && $validation->getError('category_description')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('category_description') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="category_status"><?= lang('App.category_status') ?></label>
                                <select class="form-control" name="category_status" id="category_status">
                                    <option value="active" selected><?= lang('App.active') ?></option>
                                    <option value="inactive"><?= lang('App.inactive') ?></option>
                                </select>
                                <?php if(isset($validation) && $validation->getError('category_status')): ?>
                                    <p class='text-danger mt-2'>
                                        <?= $validation->getError('category_status') ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                                <a href="<?= url('/product-management/categories') ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger">
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

    $('#category-add').validate({
        rules: {
            category_name: {
                required: true,
            },
            category_status: {
                required: true,
            },
        },
        messages: {
            category_name: {
                required: "Please enter the category name",
            },
            category_status: {
                required: "Please select the category status",
            },
        },
    });
});
</script>


<?= $this->endSection() ?>
