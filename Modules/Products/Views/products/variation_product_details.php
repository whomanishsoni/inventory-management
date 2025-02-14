<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.variation_product_details') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><?php echo lang('App.variation_product_details') ?></li>
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
                        <h3 class="card-title p-3"><?php echo lang('App.variation_product_details') ?></h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($product)): ?>
                        <h4>Product: <?php echo $product->product_name; ?></h4>
                        <p>SKU: <?php echo $product->sku_code; ?></p>
                        <p>Brand: <?php echo $product->brand_name; ?></p>
                        <p>Category: <?php echo $product->category_name; ?></p>
                        <p>Sub Category: <?php echo $product->sub_category_name; ?></p>
                        <?php endif; ?>

                        <table id="variationsProductTable" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Var Name</th>
                                    <th>Var Value</th>
                                    <th>Brand</th>
                                    <th>Unit</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Tax</th>
                                    <th>Buy Price</th>
                                    <th>Cus Price</th>
                                    <th>Sale Price</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($variations as $variation): ?>
                                <tr>
                                    <td><?php echo $variation->id; ?></td>
                                    <td><?php echo $variation->variation_sku_code; ?></td>
                                    <td><?php echo $variation->variation_product_name; ?></td>
                                    <td><?php echo $variation->variation_name; ?></td>
                                    <td><?php echo $variation->variation_value; ?></td>
                                    <td><?php echo $variation->variation_brand_name; ?></td>
                                    <td><?php echo $variation->variation_unit_abbreviation; ?></td>
                                    <td><?php echo $variation->variation_category_name; ?></td>
                                    <td><?php echo $variation->variation_sub_category_name; ?></td>
                                    <td><?php echo $variation->variation_tax_group_id; ?></td>
                                    <td><?php echo $variation->variation_buying_price; ?></td>
                                    <td><?php echo $variation->variation_customer_price; ?></td>
                                    <td><?php echo $variation->variation_sale_price; ?></td>
                                    <td>
                                        <input type="checkbox" class="status-toggle" data-id="<?php echo $variation->id; ?>"
                                            <?php echo ($variation->product_variation_status == 'active') ? 'checked' : ''; ?>>
                                    </td>
                                    <td><?php echo $variation->created_at; ?></td>
                                    <td><?php echo $variation->updated_at; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.content -->
<?=  $this->endSection() ?>

<?= $this->section('js') ?>
<!-- page script -->
<script>
$(function() {
    $('#variationsProductTable').DataTable({
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