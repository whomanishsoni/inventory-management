<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.Sales') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><?php echo lang('App.sales') ?></li>
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
                        <h3 class="card-title p-3"><?php echo lang('App.Sales') ?></h3>
                        <div class="ml-auto p-2">
                            <?php if (hasPermissions('sales_add')): ?>
                                <a href="<?= url(route_to('sales.add')) ?>" class="btn btn-primary btn-sm"
                                    data-toggle="tooltip" title="<?= lang('App.add_Sales') ?>"><span class="pr-1"><i
                                            class="fa fa-plus"></i></span>
                                    <?php echo lang('App.add_Sales') ?></a>
                            <?php endif ?>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="Sales" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo lang('App.id') ?></th>
                                    <th><?php echo lang('App.customer') ?></th>
                                    <th><?php echo lang('App.reference_no') ?></th>
                                    <th><?php echo lang('App.sale_date') ?></th>
                                    <th><?php echo lang('App.total_amount') ?></th>
                                    <th><?php echo lang('App.paid_amount') ?></th>
                                    <th><?php echo lang('App.remaining_amount') ?></th>
                                    <th><?php echo lang('App.payment_status') ?></th>
                                    <th><?php echo lang('App.sale_status') ?></th>
                                    <th><?php echo lang('App.sale_created_at') ?></th>
                                    <th><?php echo lang('App.action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($listSales as $row): ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td>
                                            <?php echo $row->customer_name ?>
                                        </td>
                                        <td>
                                            <?php echo $row->reference_no ?>
                                        </td>
                                        <td>
                                            <?php
                                            $saleDate = new DateTime($row->sale_date);
                                            echo $saleDate->format('d-m-Y');
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row->total_amount ?>
                                        </td>
                                        <td>
                                            <?php echo $row->paid_amount ?>
                                        </td>
                                        <td>
                                            <?php echo $row->remaining_amount ?>
                                        </td>
                                        <td>
                                            <?php if ($row->payment_status == 'paid'): ?>
                                                <span class="badge badge-success"><?= lang('App.paid') ?></span>
                                            <?php elseif ($row->payment_status == 'unpaid'): ?>
                                                <span class="badge badge-danger"><?= lang('App.unpaid') ?></span>
                                            <?php elseif ($row->payment_status == 'partial'): ?>
                                                <span class="badge badge-warning"><?= lang('App.partial') ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row->sale_status == 'completed'): ?>
                                                <span class="badge badge-success"><?php echo lang('App.completed') ?></span>
                                            <?php elseif ($row->sale_status == 'pending'): ?>
                                                <span class="badge badge-warning"><?php echo lang('App.pending') ?></span>
                                            <?php elseif ($row->sale_status == 'canceled'): ?>
                                                <span class="badge badge-danger"><?php echo lang('App.canceled') ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d-m-Y', strtotime($row->created_at)); ?></td>
                                        <td>
                                            <?php if (hasPermissions('sales_edit')): ?>
                                                <a href="<?= url(route_to('sales.edit', $row->id)) ?>"
                                                    class="btn btn-sm btn-primary" title="<?php echo lang('App.edit_sale') ?>"
                                                    data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                            <?php endif ?>
                                            <?php if (hasPermissions('sales_delete')): ?>
                                                <a href="<?= url(route_to('sales.delete', $row->id)) ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Do you really want to delete this sale ?')"
                                                    title="<?php echo lang('App.delete_sale') ?>" data-toggle="tooltip"><i
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
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- page script -->
<script>
    $(function () {
        $('#Sales').DataTable({
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
        onSwitchChange: function (event, state) {
            var status = state ? 'active' : 'inactive';
            var productId = $(this).data('id');

            $.ajax({
                url: '<?= site_url(route_to('Sales.update_status')) ?>',
                type: 'POST',
                data: {
                    id: productId,
                    product_status: status,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function (response) {
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
                error: function (error) {
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