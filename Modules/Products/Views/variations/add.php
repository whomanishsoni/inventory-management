<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.add_variation') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><a
                            href="<?php echo url('/product-management/variations') ?>"><?php echo lang('App.variations') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.add_variation') ?></li>
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
                        <h3 class="card-title"><?= lang('App.add_variation') ?></h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open(route_to('variations.store'), ['id' => 'variation-add', 'method' => 'post', 'autocomplete' => 'off']); ?>
                        <div class="form-group">
                            <label for="variation_name"><?= lang('App.variation_name') ?></label>
                            <input type="text" class="form-control" name="variation_name" id="variation_name"
                                placeholder="<?= lang('App.variation_name') ?>" autofocus />
                            <?php if(isset($validation) && $validation->getError('variation_name')): ?>
                            <p class='text-danger mt-2'>
                                <?= $validation->getError('variation_name') ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="variation_status"><?= lang('App.variation_status') ?></label>
                            <select class="form-control" name="variation_status" id="variation_status">
                                <option value="active" selected><?= lang('App.active') ?></option>
                                <option value="inactive"><?= lang('App.inactive') ?></option>
                            </select>
                            <?php if(isset($validation) && $validation->getError('variation_status')): ?>
                            <p class='text-danger mt-2'>
                                <?= $validation->getError('variation_status') ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-flat btn-primary"><?= lang('App.submit') ?></button>
                            <a href="<?= url('/product-management/variations') ?>"
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

    $('#variation-add').validate({
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
<script>
    function addField() {
    var container = $('#variation-values-container');
    var inputField = $('<input>').attr({
        type: 'text',
        class: 'form-control',
        name: 'variation_value[]',
        placeholder: 'Enter Variation Value'
    });

    var addButton = $('<button>').attr({
        type: 'button',
        class: 'btn btn-success'
    }).text('+').click(addField);

    var removeButton = $('<button>').attr({
        type: 'button',
        class: 'btn btn-danger'
    }).text('-').click(function() {
        removeField($(this));
    });

    var inputGroup = $('<div>').addClass('input-group mt-2').append(inputField, $('<div>').addClass(
        'input-group-append').append(addButton, removeButton));

    container.append(inputGroup);
}

function removeField(button) {
    var container = $('#variation-values-container');
    var inputGroups = container.children('.input-group');

    if (inputGroups.length > 1) {
        var inputGroup = $(button).closest('.input-group');
        inputGroup.remove();
        $('#error-message').text('');
    } else {
        $('#error-message').text('At least one field is required.');
    }
}
</script>
<?= $this->endSection() ?>