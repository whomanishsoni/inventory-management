<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.variation_values') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo url('/product-management/variations') ?>"><?php echo lang('App.variations') ?></a></li>
                    <li class="breadcrumb-item active"><?php echo lang('App.variation_values') ?></li>
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
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"><?php echo lang('App.variation_values') ?></h3>
                        <div class="ml-auto p-2">
                            <?php if (hasPermissions('variation_values_add')): ?>
                            <a href="<?= url(route_to('variation-values.add', $variationId)) ?>" class="btn btn-primary btn-sm"
                                data-toggle="tooltip" title="<?= lang('App.add_variation_value') ?>"><span class="pr-1"><i
                                        class="fa fa-plus"></i></span>
                                <?php echo lang('App.add_variation_value') ?></a>
                            <?php endif ?>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="variation-values" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo lang('App.id') ?></th>
                                    <th><?php echo lang('App.variation_value') ?></th>
                                    <th><?php echo lang('App.variation_value_created_at') ?></th>
                                    <th><?php echo lang('App.variation_value_status') ?></th>
                                    <th><?php echo lang('App.action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $counter = 1;
                                foreach ($listVariationValues as $row): ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td>
                                        <?php echo $row->variation_value ?>
                                    </td>
                                    <td><?php echo date('d-m-Y', strtotime($row->created_at)); ?></td>
                                    <td>
                                        <input type="checkbox" class="status-toggle" data-id="<?php echo $row->id; ?>"
                                            <?php echo ($row->variation_value_status == 'active') ? 'checked' : ''; ?>>
                                    </td>
                                    <td>
                                        <?php if (hasPermissions('variation_values_edit')): ?>
                                        <a href="<?= url(route_to('variation-values.edit', $variationId, $row->id)) ?>"
                                            class="btn btn-sm btn-primary"
                                            title="<?php echo lang('App.edit_variation_value') ?>" data-toggle="tooltip"><i
                                                class="fas fa-edit"></i></a>
                                        <?php endif ?>
                                        <?php if (hasPermissions('variation_values_delete')): ?>
                                        <a href="<?= url(route_to('variation-values.delete', $variationId, $row->id)) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Do you really want to delete this variation value ?')"
                                            title="<?php echo lang('App.delete_variation_value') ?>" data-toggle="tooltip"><i
                                                class="fa fa-trash"></i></a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
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
<?=  $this->endSection() ?>

<?= $this->section('js') ?>
<!-- page script -->
<script>
$(function() {
    $('#variation-values').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});
</script>
<script>
$('.status-toggle').bootstrapSwitch({
    size: 'small',
    onText: 'Active',
    offText: 'Inactive',
    onColor: 'success',
    offColor: 'default',
    onSwitchChange: function(event, state) {
        var status = state ? 'active' : 'inactive';
        var variationValuesId = $(this).data('id');

        $.ajax({
            url: '<?= site_url(route_to('variation-values.update_status')) ?>',
            type: 'POST',
            data: {
                id: variationValuesId,
                variation_value_status: status,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);

                // Handle success
                if (response.success) {
                    // Use Toastr.js to show success message
                    toastr.success(response.message, 'Success');

                    // Update UI or perform additional actions as needed

                } else {
                    // Use Toastr.js to show error message
                    toastr.error(response.message, 'Error');
                    console.error('Failed to update status: ' + response.message);
                }
            },
            error: function(error) {
                console.error(error);

                // Use Toastr.js to show generic error message
                toastr.error('An error occurred during the AJAX request', 'Error');
            }
        });
    }
});
<?php if (session()->has('error')): ?>
toastr.error("<?= session('error') ?>", 'Error', {
    closeButton: true
});
<?php endif ?>
</script>
<?=  $this->endSection() ?>