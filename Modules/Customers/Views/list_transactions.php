<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.transactions') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo url('/customers') ?>"><?php echo lang('App.customers') ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo lang('App.transactions') ?></li>
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
                        <h3 class="card-title p-3"><?php echo lang('App.transactions') ?></h3>
                        <div class="ml-auto p-2">
                            <?php if (hasPermissions('customer_transactions_add')): ?>
                                <a href="<?= url(route_to('customers.add_transaction', $customerId)) ?>"
                                    class="btn btn-primary btn-sm" data-toggle="tooltip"
                                    title="<?= lang('App.add_transaction') ?>">
                                    <span class="pr-1"><i class="fa fa-plus"></i></span>
                                    <?php echo lang('App.add_transaction') ?>
                                </a>
                            <?php endif ?>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <strong><?php echo lang('App.total_available_balance'); ?>:
                                ₹<?php echo number_format($totalAvailableBalance, 2); ?></strong>
                        </div>
                        <table id="transactions" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo lang('App.id') ?></th>
                                    <th><?php echo lang('App.customer_name') ?></th>
                                    <th><?php echo lang('App.transaction_type') ?></th>
                                    <th><?php echo lang('App.transaction_amount') ?></th>
                                    <th><?php echo lang('App.transaction_balance') ?></th>
                                    <th><?php echo lang('App.transaction_date') ?></th>
                                    <th><?php echo lang('App.transaction_description') ?></th>
                                    <th><?php echo lang('App.transaction_reference_id') ?></th>
                                    <th><?php echo lang('App.transaction_created_by') ?></th>
                                    <th><?php echo lang('App.transaction_updated_by') ?></th>
                                    <th><?php echo lang('App.action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($listCustomerTransactions as $row): ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td>
                                            <?php echo ucwords(strtolower($row->customer_name)) ?>
                                        </td>
                                        <td>
                                            <?php if ($row->transaction_type == 'credit'): ?>
                                                <span class="badge badge-success"><?php echo lang('App.credit') ?></span>
                                            <?php elseif ($row->transaction_type == 'debit'): ?>
                                                <span class="badge badge-danger"><?php echo lang('App.debit') ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->amount ?>
                                        </td>
                                        <td>
                                            <?php echo $row->balance ?>
                                        </td>
                                        <td><?php echo date('d-m-Y', strtotime($row->transaction_date)); ?></td>
                                        <td>
                                            <?php echo $row->description ?>
                                        </td>
                                        <td>
                                            <?php echo $row->reference_id ?>
                                        </td>
                                        <td>
                                            <?php echo $row->created_by ?>
                                        </td>
                                        <td>
                                            <?php echo $row->updated_by ?>
                                        </td>
                                        <td>
                                            <div style="display:flex; gap:5px;">
                                                <?php if (hasPermissions('customer_transactions_edit')): ?>
                                                    <a href="<?= url(route_to('customers.edit_transaction', $row->id)) ?>"
                                                        class="btn btn-sm btn-primary"
                                                        title="<?php echo lang('App.edit_transaction') ?>"
                                                        data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                                <?php endif ?>
                                                <?php if (hasPermissions('customer_transactions_delete')): ?>
                                                    <a href="<?= url(route_to('customers.delete_transaction', $row->id)) ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Do you really want to delete this transaction ?')"
                                                        title="<?php echo lang('App.delete_transaction') ?>"
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
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- page script -->
<script>
    $(function () {
        $('#transactions').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
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
            var customerId = $(this).data('id');

            $.ajax({
                url: '<?= site_url(route_to('customers.update_transaction_status')) ?>',
                type: 'POST',
                data: {
                    id: customerId,
                    customer_status: status,
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