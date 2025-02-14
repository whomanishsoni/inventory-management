<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.products') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><?php echo lang('App.products') ?></li>
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
                        <h3 class="card-title p-3"><?php echo lang('App.products') ?></h3>
                        <div class="ml-auto p-2">
                            <?php if (hasPermissions('products_add')): ?>
                            <a href="<?= url(route_to('products.add')) ?>" class="btn btn-primary btn-sm"
                                data-toggle="tooltip" title="<?= lang('App.add_product') ?>"><span class="pr-1"><i
                                        class="fa fa-plus"></i></span>
                                <?php echo lang('App.add_product') ?></a>
                            <?php endif ?>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="products" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo lang('App.id') ?></th>
                                    <th><?php echo lang('App.product_name') ?></th>
                                    <th><?php echo lang('App.brand') ?></th>
                                    <th><?php echo lang('App.unit') ?></th>
                                    <th><?php echo lang('App.category') ?></th>
                                    <th><?php echo lang('App.sub_category') ?></th>
                                    <th><?php echo lang('App.variant') ?></th>
                                    <th><?php echo lang('App.product_created_at') ?></th>
                                    <th><?php echo lang('App.product_status') ?></th>
                                    <th><?php echo lang('App.action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $counter = 1;
                                    foreach ($listProducts as $row): ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td>
                                        <?php if ($row->has_variation == 1): ?>
                                        <a href="<?= url(route_to('products.variation_product_details', $row->id)) ?>">
                                            <?php echo $row->product_name ?>
                                        </a>
                                        <?php else: ?>
                                        <a href="<?= url(route_to('products.single_product_details', $row->id)) ?>">
                                            <?php echo $row->product_name ?>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $row->brand_name ?></td>
                                    <td><?php echo $row->unit_abbreviation ?></td>
                                    <td><?php echo $row->category_name ?></td>
                                    <td><?php echo ($row->sub_category_id == 0) ? 'No Sub Category' : $row->sub_category_name; ?>
                                    </td>
                                    <td>
                                        <?php if ($row->has_variation == 1): ?>
                                        <span class="badge badge-success">Yes</span>
                                        <?php else: ?>
                                        <span class="badge badge-warning">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d-m-Y', strtotime($row->created_at)); ?></td>
                                    <td>
                                        <input type="checkbox" class="status-toggle" data-id="<?php echo $row->id; ?>"
                                            <?php echo ($row->product_status == 'active') ? 'checked' : ''; ?>>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <?php if (hasPermissions('products_view')): ?>
                                            <a href="<?= url(route_to('products.view', $row->id)) ?>"
                                                class="btn btn-sm btn-default"
                                                title="<?php echo lang('App.view_product') ?>" data-toggle="tooltip"><i
                                                    class="fas fa-eye"></i></a>
                                            <?php endif ?>
                                            <?php if (hasPermissions('products_edit')): ?>
                                            <a href="<?= url(route_to('products.edit', $row->id)) ?>"
                                                class="btn btn-sm btn-primary"
                                                title="<?php echo lang('App.edit_product') ?>" data-toggle="tooltip"><i
                                                    class="fas fa-edit"></i></a>
                                            <?php endif ?>
                                            <?php if (hasPermissions('products_delete')): ?>
                                            <a href="<?= url(route_to('products.delete', $row->id)) ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Do you really want to delete this product ?')"
                                                title="<?php echo lang('App.delete_product') ?>"
                                                data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                                            <?php endif ?>
                                        </div>
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
    $('#products').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "scrollX": true,
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
        var productId = $(this).data('id');

        $.ajax({
            url: '<?= site_url(route_to('products.update_status')) ?>',
            type: 'POST',
            data: {
                id: productId,
                product_status: status,
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