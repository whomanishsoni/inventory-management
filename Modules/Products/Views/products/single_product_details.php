<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= lang('App.product_details') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= url('/') ?>"><?= lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><?= lang('App.product_details') ?></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"><?= lang('App.product_details') ?></h3>
                    </div>
                    <div class="card-body">
                        <table id="singleProductTable" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Unit</th>
                                    <th>Category</th>
                                    <th>Sub Cat</th>
                                    <th>Tax Group</th>
                                    <th>Buy Price</th>
                                    <th>Cus Price</th>
                                    <th>Sale Price</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $product->id; ?></td>
                                    <td><?= $product->sku_code; ?></td>
                                    <td><?= $product->product_name; ?></td>
                                    <td><?= $product->brand_name; ?></td>
                                    <td><?= $product->unit_abbreviation; ?></td>
                                    <td><?= $product->category_name; ?></td>
                                    <td><?= ($product->sub_category_id == 0) ? 'No Sub Category' : $product->sub_category_name; ?>
                                    </td>
                                    <td><?= $product->tax_group_id; ?></td>
                                    <td><?= $product->buying_price; ?></td>
                                    <td><?= $product->customer_price; ?></td>
                                    <td><?= $product->sale_price; ?></td>
                                    <td>
                                        <input type="checkbox" class="status-toggle" data-id="<?= $product->id; ?>"
                                            <?= ($product->product_status == 'active') ? 'checked' : ''; ?>>
                                    </td>
                                    <td><?= $product->created_at; ?></td>
                                    <td><?= $product->updated_at; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- page script -->
<script>
$(function() {
    $('#singleProductTable').DataTable({
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
<?= $this->endSection() ?>