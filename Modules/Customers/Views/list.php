<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.customers') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><?php echo lang('App.customers') ?></li>
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
                        <h3 class="card-title p-3"><?php echo lang('App.customers') ?></h3>
                        <div class="ml-auto p-2">
                            <?php if (hasPermissions('customers_add')): ?>
                                <a href="<?= url(route_to('customers.add')) ?>" class="btn btn-primary btn-sm"
                                    data-toggle="tooltip" title="<?= lang('App.add_customer') ?>"><span class="pr-1"><i
                                            class="fa fa-plus"></i></span>
                                    <?php echo lang('App.add_customer') ?></a>
                            <?php endif ?>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="customers" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo lang('App.id') ?></th>
                                    <th><?php echo lang('App.customer_name') ?></th>
                                    <th><?php echo lang('App.customer_phone') ?></th>
                                    <th><?php echo lang('App.customer_email') ?></th>
                                    <th><?php echo lang('App.customer_city') ?></th>
                                    <th><?php echo lang('App.customer_state') ?></th>
                                    <th><?php echo lang('App.customer_balances') ?></th>
                                    <th><?php echo lang('App.customer_created_at') ?></th>
                                    <th><?php echo lang('App.customer_status') ?></th>
                                    <th><?php echo lang('App.action') ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($listCustomers as $row): ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td><?php echo $row->customer_name; ?></td>
                                        <td><?php echo $row->customer_phone; ?></td>
                                        <td><?php echo $row->customer_email; ?></td>
                                        <td><?php echo $row->city_name; ?></td>
                                        <td><?php echo $row->state_name; ?></td>
                                        <td><?php echo $row->balance; ?></td> <!-- Display the balance here -->
                                        <td><?php echo date('d-m-Y', strtotime($row->created_at)); ?></td>
                                        <td>
                                            <input type="checkbox" class="status-toggle" data-id="<?php echo $row->id; ?>"
                                                <?php echo ($row->customer_status == 'active') ? 'checked' : ''; ?>>
                                        </td>
                                        <td>
                                            <div style="display:flex; gap:5px;">
                                                <?php if (hasPermissions('customer_transactions_add')): ?>
                                                    <!-- Button to trigger the modal -->
                                                    <a href="<?= url(route_to('customers.transactions', $row->id)) ?>"
                                                        class="btn btn-sm btn-default"
                                                        title="<?php echo lang('App.view_transcation') ?>" data-toggle="tooltip"
                                                        data-id="<?= $row->id ?>" data-toggle="modal"
                                                        data-target="#addBalanceModal">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                <?php endif ?>
                                                <?php if (hasPermissions('customer_transactions_add')): ?>
                                                    <!-- Button to trigger the modal -->
                                                    <a href="<?= url(route_to('customers.add_transaction', $row->id)) ?>"
                                                        class="btn btn-sm btn-success"
                                                        title="<?php echo lang('App.add_balance') ?>" data-toggle="tooltip"
                                                        data-id="<?= $row->id ?>" data-toggle="modal"
                                                        data-target="#addBalanceModal">
                                                        <i class="fas fa-coins"></i>
                                                    </a>
                                                <?php endif ?>
                                                <?php if (hasPermissions('customers_edit')): ?>
                                                    <a href="<?= url(route_to('customers.edit', $row->id)) ?>"
                                                        class="btn btn-sm btn-primary"
                                                        title="<?php echo lang('App.edit_customer') ?>" data-toggle="tooltip"><i
                                                            class="fas fa-edit"></i></a>
                                                <?php endif ?>
                                                <?php if (hasPermissions('customers_delete')): ?>
                                                    <a href="<?= url(route_to('customers.delete', $row->id)) ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Do you really want to delete this customer ?')"
                                                        title="<?php echo lang('App.delete_customer') ?>"
                                                        data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                                                <?php endif ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                            <!-- Total Balance Section -->
                            <tfoot>
                                <tr>

                                </tr>
                            </tfoot>
                            <tfoot>
                                <tr>
                                    <th class="text-center"><?php echo lang('App.total_balance'); ?>
                                        <b id="totalBalance">
                                            ₹<?php echo number_format($totalBalance, 2); ?></b>
                                    </th>
                                </tr>
                            </tfoot>
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
        var table = $('#customers').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": false,
            "scrollX": true,
        });

        function updateTotalBalance() {
            var totalBalance = 0;
            table.rows({ filter: 'applied' }).every(function () {
                var data = this.data();
                var balance = parseFloat(data[6].replace(/[^0-9.-]+/g, '')); // Assuming balance is in the 7th column (index 6)
                totalBalance += balance;
            });
            $('#totalBalance').text('₹' + totalBalance.toFixed(2));
        }

        table.on('search.dt', function () {
            updateTotalBalance();
        });

        // Initial calculation
        updateTotalBalance();
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
                url: '<?= site_url(route_to('customers.update_status')) ?>',
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