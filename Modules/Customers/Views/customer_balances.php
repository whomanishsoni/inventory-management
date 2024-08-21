<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.customer_balances') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
                    <li class="breadcrumb-item active"><?php echo lang('App.customer_balances') ?></li>
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
                        <h3 class="card-title p-3"><?php echo lang('App.customer_balances') ?></h3>
                    </div>

                    <div class="card-body">
                        <table id="customer_balances" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo lang('App.id') ?></th>
                                    <th><?php echo lang('App.customer_name') ?></th>
                                    <th><?php echo lang('App.customer_balance') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($customerBalances as $row): ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td>
                                            <a href="<?= url(route_to('customers.transactions', $row->customer_id)) ?>">
                                                <?php echo ucwords(strtolower($row->customer_name)) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo number_format($row->balance, 2) ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center" colspan="2"><?php echo lang('App.total_balance'); ?></th>
                                    <th id="totalBalance">₹<?php echo number_format($totalBalance, 2); ?></th>
                                </tr>
                            </tfoot>
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
    $(function () {
        var table = $('#customer_balances').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "scrollX": true,
        });

        table.on('search.dt', function () {
            var totalBalance = 0;
            table.rows({ filter: 'applied' }).every(function (rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                var balance = parseFloat(data[2].replace(/,/g, '')); // Assuming the balance is in the 3rd column (index 2)
                totalBalance += balance;
            });
            $('#totalBalance').text('₹' + totalBalance.toFixed(2));
        });

        // Initial calculation
        table.trigger('search.dt');
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