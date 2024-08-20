1. https://github.com/MuhammadAliashraf/blueneek
2. https://github.com/templatecookie/poco-html
3. https://dev.to/davidepacilio/40-free-html-landing-page-templates-3gfp
4. https://dev.to/davidepacilio/40-free-html-landing-page-templates-3gfp
5. https://startbootstrap.com/theme/agency
6. https://colorlib.com/wp/themes/pixova-lite/
7. https://colorlib.com/wp/themes/illdy/
8. https://www.abtasty.com/blog/bootstrap-landing-page-templates/
9. https://github.com/Blazity/next-saas-starter
10. https://startbootstrap.com/template/business-frontpage
11. https://github.com/uideck/play-bootstrap
12. https://github.com/Alexandrbig1/WebStudio

https://blog.alfauzikri.my.id/Admin-Template-and-UI-Kit/

1. https://blueneek.netlify.app/
2. https://poco-html.netlify.app/
3. https://www.designbombs.com/freebies-demo/union/
4. https://www.lapa.ninja/lab/atlas/#
5. https://startbootstrap.com/previews/agency
6. https://colorlibhub.com/pixova-lite/
7. https://colorlibhub.com/illdy/
8. https://bootstrapmade.com/demo/Regna/
9. https://next-saas-starter-ashy.vercel.app/
10. https://startbootstrap.com/previews/business-frontpage
11. https://preview.uideck.com/items/play-bootstrap/index.html
12. https://alexandrbig1.github.io/WebStudio/
13. https://designsmaz.com/demo/akad-free-digital-agencies-html-template/
14. https://templatemo.com/live/templatemo_561_purple_buzz
15. https://templatemo.com/live/templatemo_535_softy_pinko
16. https://templatemo.com/live/templatemo_537_art_factory

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productNameInput = document.getElementById('product_name');
    const productSuggestions = document.getElementById('product_suggestions');
    const productTableBody = document.getElementById('product_table_body');
    const totalAmountDisplay = document.getElementById('total_amount_display');
    const paidAmountField = document.getElementById('paid_amount');
    const remainingAmountDisplay = document.getElementById('remaining_amount_display');
    const totalAmountField = document.querySelector('input[name="total_amount"]');
    const remainingAmountField = document.querySelector('input[name="remaining_amount"]');
    const referenceNoInput = document.getElementById('reference_no');
    const form = document.getElementById('purchase-add');

    // Fetch purchase order number on page load
    fetchPurchaseOrderNumber();

    function fetchPurchaseOrderNumber() {
        fetch('<?= site_url(route_to('purchases.generate_purchase_order_number')) ?>')
            .then(response => response.json())
            .then(data => {
                console.log('Purchase Order Number:', data.reference_no);
                referenceNoInput.value = data.reference_no;
            })
            .catch(error => {
                console.error('Error fetching purchase order number:', error);
            });
    }

    productNameInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length < 2) {
            productSuggestions.innerHTML = '';
            return;
        }

        // AJAX request to fetch product suggestions
        fetch('<?= site_url(route_to('purchases.search')) ?>?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                console.log('Product Suggestions:', data);

                let suggestions = '';
                if (data.length > 0) {
                    data.forEach(product => {
                        suggestions +=
                            `<button type="button" class="list-group-item list-group-item-action" data-product='${JSON.stringify(product)}'>${product.variation_product_name ? product.variation_product_name : product.product_name}</button>`;
                    });
                } else {
                    suggestions = '<div class="list-group-item">No result</div>';
                }
                productSuggestions.innerHTML = suggestions;
            })
            .catch(error => {
                console.error('Error fetching product suggestions:', error);
            });
    });

    // Handle product suggestion click
    productSuggestions.addEventListener('click', function(e) {
        if (e.target.classList.contains('list-group-item') && e.target.getAttribute('data-product')) {
            const product = JSON.parse(e.target.getAttribute('data-product'));
            addProductToTable(product);
            productNameInput.value = '';
            productSuggestions.innerHTML = '';
        }
    });

    form.addEventListener('submit', function(event) {
        if (!validateProductTable()) {
            event.preventDefault();
        }
    });

    // Function to add product to the table
    function addProductToTable(product) {
        const productId = product.id || product.product_id;
        const productName = product.variation_product_name || product.product_name;
        const productPrice = parseFloat(product.buying_price || product.variation_buying_price || 0);
        const manufactureDate = '';
        const expiryDate = '';

        // Check if the product is already added
        const existingProduct = Array.from(productTableBody.querySelectorAll('tr')).find(row => {
            const existingProductId = row.querySelector('input[name*="[product_id]"]').value;
            return existingProductId === `${productId}`;
        });

        if (existingProduct) {
            alert('This product is already added.');
            return;
        }

        const row = document.createElement('tr');
        const displayProductName = productName.toLowerCase();

        row.innerHTML = `
            <td><input type="hidden" name="products[${productId}][product_id]" value="${productId}" /> ${displayProductName}</td>
            <td>
                <input type="number" name="products[${productId}][quantity]" value="1" min="1" class="form-control quantity-input" />
                <span class="text-danger mt-2 error-message"></span>
            </td>
            <td>
                <input type="number" name="products[${productId}][price]" value="${productPrice}" class="form-control price-input" />
                <span class="text-danger mt-2 error-message"></span>
            </td>
            <td>
                <input type="date" name="products[${productId}][manufacture_date]" value="${manufactureDate}" class="form-control manufacture-date-input" />
                <span class="text-danger mt-2 error-message"></span>
            </td>
            <td>
                <input type="date" name="products[${productId}][expiry_date]" value="${expiryDate}" class="form-control expiry-date-input" />
                <span class="text-danger mt-2 error-message"></span>
            </td>
            <td class="total">${productPrice.toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-product">Remove</button></td>
            <input type="hidden" name="products[${productId}][variation_id]" value="${product.variation_id || ''}" />
            <input type="hidden" name="products[${productId}][variation_value_id]" value="${product.variation_value_id || ''}" />
        `;

        productTableBody.appendChild(row);

        row.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                if (validateProductRow(row)) {
                    clearValidationError(input);
                }
                updateRowTotal.call(input);
            });
        });

        row.querySelector('.remove-product').addEventListener('click', function() {
            row.remove();
            updateTotalAmount();
        });

        if (!validateProductRow(row)) {
            return;
        }

        updateTotalAmount();
    }

    // Function to validate a product row
    function validateProductRow(row) {
        let isValid = true;

        const quantityInput = row.querySelector('.quantity-input');
        const manufactureDateInput = row.querySelector('.manufacture-date-input');
        const expiryDateInput = row.querySelector('.expiry-date-input');

        if (quantityInput.value <= 0) {
            displayValidationError(quantityInput, 'Quantity must be greater than 0.');
            isValid = false;
        } else {
            clearValidationError(quantityInput);
        }

        const manufactureDate = new Date(manufactureDateInput.value);
        const expiryDate = new Date(expiryDateInput.value);

        if (manufactureDate > expiryDate) {
            displayValidationError(manufactureDateInput, 'Manufacture date must be before the expiry date.');
            displayValidationError(expiryDateInput, 'Expiry date must be after the manufacture date.');
            isValid = false;
        } else {
            clearValidationError(manufactureDateInput);
            clearValidationError(expiryDateInput);
        }

        return isValid;
    }

    // Function to validate the entire product table
    function validateProductTable() {
        let isValid = true;
        const productRows = productTableBody.querySelectorAll('tr');

        if (productRows.length === 0) {
            alert('Please add at least one product.');
        }

        productRows.forEach(row => {
            if (!validateProductRow(row)) {
                isValid = false;
            }
        });

        const totalAmount = parseFloat(totalAmountField.value) || 0;
        const paidAmount = parseFloat(paidAmountField.value) || 0;

        if (paidAmount > totalAmount) {
            displayValidationError(paidAmountField, 'Paid amount cannot be greater than the total amount.');
            isValid = false;
        } else {
            clearValidationError(paidAmountField);
        }

        return isValid;
    }

    // Function to display validation error messages dynamically
    function displayValidationError(element, message) {
        const errorElement = element.closest('td').querySelector('.error-message');
        if (errorElement) {
            errorElement.textContent = message;
        } else {
            const errorMessage = document.createElement('span');
            errorMessage.classList.add('text-danger', 'mt-2', 'error-message');
            errorMessage.textContent = message;
            element.closest('td').appendChild(errorMessage);
        }
    }

    // Function to clear validation error messages
    function clearValidationError(element) {
        const errorElement = element.closest('td').querySelector('.error-message');
        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    // Function to update row total amount
    function updateRowTotal() {
        const row = this.closest('tr');
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const total = quantity * price;
        row.querySelector('.total').textContent = total.toFixed(2);
        updateTotalAmount();
    }

    // Function to update total amount of all products
    function updateTotalAmount() {
        let totalAmount = 0;
        productTableBody.querySelectorAll('tr').forEach(row => {
            const total = parseFloat(row.querySelector('.total').textContent) || 0;
            totalAmount += total;
        });

        totalAmountDisplay.value = totalAmount.toFixed(2);
        totalAmountField.value = totalAmount.toFixed(2);
        updateRemainingAmount();
    }

    // Function to update remaining amount after paid amount change
    function updateRemainingAmount() {
        const paidAmount = parseFloat(paidAmountField.value) || 0;
        const totalAmount = parseFloat(totalAmountField.value) || 0;
        const remainingAmount = totalAmount - paidAmount;

        remainingAmountDisplay.value = remainingAmount.toFixed(2);
        remainingAmountField.value = remainingAmount.toFixed(2);
    }

    // Event listener for paid amount field input
    paidAmountField.addEventListener('input', function() {
        if (paidAmountField.value > parseFloat(totalAmountField.value) || 0) {
            displayValidationError(paidAmountField,
                'Paid amount cannot be greater than the total amount.');
        } else {
            clearValidationError(paidAmountField);
        }
        updateRemainingAmount();
    });

    // Set default value for paid amount
    paidAmountField.value = '0';
});
</script>

new code

<script>
$(document).ready(function() {
    var variationCounter = 0;
    var createdVariations = {};
    var taxGroups = <?php echo json_encode($tax_groups); ?>;

    // Initialize the visibility based on the default value
    toggleVariationDisplay($('#has_variation').val());

    // Handle change event for the toggle variation select box
    $('#has_variation').change(function() {
        toggleVariationDisplay($(this).val());
    });

    function toggleVariationDisplay(value) {
        if (value === '1') {
            $('#variation_selection_box').show();
            $('#variation_values_selection_box').show();
            $('#single_product_table').hide();
        } else {
            $('#variation_selection_box').hide();
            $('#variation_values_selection_box').hide();
            $('#single_product_table').show();
            $('#variation_values_container').empty();
            createdVariations = {}; // Clear created variations
        }
    }

    // Fetch sub-categories based on selected category
    $('#category_id').change(function() {
        var categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(route_to('products.get_sub_categories')); ?>",
                data: {
                    'category_id': categoryId
                },
                dataType: 'json',
                success: function(response) {
                    $('#sub_category_id').empty();
                    $('#sub_category_id').append(
                        '<option value="" selected><?= lang('App.select_sub_category') ?></option>'
                    );
                    $.each(response, function(index, subCategory) {
                        $('#sub_category_id').append('<option value="' + subCategory
                            .id + '">' + subCategory.sub_category_name +
                            '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching sub-categories:", error);
                }
            });
        } else {
            $('#sub_category_id').empty();
            $('#sub_category_id').append(
                '<option value="" selected><?= lang('App.select_sub_category') ?></option>');
        }
    });

    // Generate SKU code for the product
    $('#product_name').on('input', function() {
        var productName = $(this).val().trim().replace(/\s+/g, '_');
        var baseSkuCode = $('#sku_code').val().trim();

        // Update SKU code and product name for variations
        updateVariationSkuCodes(productName, baseSkuCode);
        updateVariationProductNames(productName);
    });

    function updateVariationSkuCodes(productName, baseSkuCode) {
        $('input[name="variation_sku_code[]"]').each(function(index) {
            var variationType = $(this).closest('tr').find('input[name="variation_values[]"]').val();
            if (variationType && baseSkuCode) {
                var variationSkuCode = baseSkuCode + '-' + variationType.substring(0, 2).toUpperCase() +
                    (index + 1).toString().padStart(3, '0');
                $(this).val(variationSkuCode);
            }
        });
    }

    function updateVariationProductNames(productName) {
        $('input[name="variation_product_name[]"]').each(function() {
            var variationValue = $(this).closest('tr').find('input[name="variation_values[]"]').val();
            if (productName && variationValue) {
                $(this).val(productName + ' - ' + variationValue);
            } else {
                $(this).val('');
            }
        });
    }

    $('#variation_id').change(function() {
        var selectedVariations = $(this).val() || []; // Get all selected variation IDs

        // Remove tables for unselected variations
        $.each(createdVariations, function(variationId, counter) {
            if (!selectedVariations.includes(variationId)) {
                $('#table_container_' + counter).remove();
                delete createdVariations[variationId];
            }
        });

        // Add tables for newly selected variations
        selectedVariations.forEach(function(variationId) {
            if (variationId && !createdVariations[variationId]) {
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url(route_to('products.get_variation_values'));?>",
                    data: {
                        'variation_id': variationId
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (Array.isArray(response) && response.length > 0) {
                            createdVariations[variationId] = ++variationCounter;

                            // Populate the variation values selection box
                            var $variationValuesSelect = $('#variation_values');
                            $variationValuesSelect.empty();
                            $.each(response, function(index, value) {
                                $variationValuesSelect.append(
                                    '<option value="' + value.id +
                                    '" data-variation-id="' + value
                                    .variation_id + '">' +
                                    value.variation_value + '</option>'
                                );
                            });

                            generateVariationValuesTable(response,
                                createdVariations[variationId], variationId);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching variation values:", error);
                    }
                });
            }
        });
    });

    function generateVariationValuesTable(variationValues, counter, variationId) {
        var productName = $('#product_name').val();
        var baseSkuCode = $('#sku_code').val().trim();
        var tableId = 'variation_values_table_' + counter;
        var table = '<div class="table-container" id="table_container_' + counter + '">';
        table += '<table id="' + tableId + '" class="table">';
        table +=
            '<thead><tr><th><?= lang('App.sku_code') ?></th><th><?= lang('App.product_name') ?></th><th class="hidden-column"><?= lang('App.variation_name') ?></th><th><?= lang('App.buying_price') ?></th><th><?= lang('App.customer_price') ?></th><th>Tax Rate</th><th><?= lang('App.tax_amount') ?></th><th><?= lang('App.sale_price') ?></th><th><?= lang('App.action')?></th></tr></thead>';
        table += '<tbody>';
        $.each(variationValues, function(index, value) {
            var variationSkuCode = baseSkuCode + '-' + variationId.substring(0, 2).toUpperCase() + (
                index + 1).toString().padStart(3, '0');
            var variationProductName = productName ? (productName + ' - ' + value.variation_value) : '';
            table += '<tr>';
            table +=
                '<td><input type="text" class="form-control" readonly name="variation_sku_code[]" value="' +
                variationSkuCode + '" placeholder="Enter SKU code"></td>';
            table +=
                '<td><input type="text" class="form-control variation-product-name" name="variation_product_name[]" value="' +
                variationProductName + '" placeholder="Enter product name"></td>';
            table +=
                '<td class="hidden-column"><input type="hidden" class="form-control variation-value" name="variation_values[]" value="' +
                value.id + '"><span>' + value.variation_value + '</span></td>';
            table +=
                '<td><input type="text" name="variation_buying_price[]" class="form-control" placeholder="Enter buying price"></td>';
            table +=
                '<td><input type="text" name="variation_customer_price[]" class="form-control" placeholder="Enter customer price"></td>';
            table += '<td><select class="form-control tax-group" name="variation_tax_group_id[]">';
            table += '<option value="">Select Tax Rate</option>';
            $.each(taxGroups, function(taxIndex, taxGroup) {
                table += '<option value="' + taxGroup.id + '">' + taxGroup.tax_group_name +
                    '</option>';
            });
            table += '</select></td>';
            table +=
                '<td><input type="text" name="variation_tax_amount[]" class="form-control" readonly placeholder="Tax amount"></td>';
            table +=
                '<td><input type="text" name="variation_sale_price[]" class="form-control" readonly placeholder="Enter sale price"></td>';
            table +=
                '<td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-trash"></i></button></td>';
            table += '</tr>';
        });
        table += '</tbody></table>';
        table += '</div>';
        $('#variation_values_container').append(table);
    }

    // Handle removing rows
    $(document).on('click', '.remove-row', function() {
        var row = $(this).closest('tr');
        row.remove();
    });

    // Update tax amount and sale price when tax group or prices are changed
    $(document).on('change', '.tax-group', function() {
        updateRowCalculations($(this).closest('tr'));
    });

    $(document).on('input', 'input[name="variation_buying_price[]"], input[name="variation_customer_price[]"]',
        function() {
            updateRowCalculations($(this).closest('tr'));
        });

    // Calculate tax amount and sale price for single product table
    $('#buying_price, #customer_price, #tax_group_id').on('input change', function() {
        var buyingPrice = parseFloat($('#buying_price').val());
        var customerPrice = parseFloat($('#customer_price').val());
        var taxGroupId = $('#tax_group_id').val();

        if (!isNaN(buyingPrice) && !isNaN(customerPrice) && taxGroupId) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(route_to('products.get_tax_rate')); ?>",
                data: {
                    tax_group_id: taxGroupId,
                    customer_price: customerPrice,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(response) {
                    var taxRate = parseFloat(response.total_tax_amount);
                    if (!isNaN(taxRate)) {
                        var taxAmount = (buyingPrice * taxRate) / 100;
                        var salePrice = customerPrice + taxAmount;
                        $('#tax_amount').val(taxAmount.toFixed(2));
                        $('#sale_price').val(salePrice.toFixed(2));
                    } else {
                        $('#tax_amount').val('');
                        $('#sale_price').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching tax rate:", error);
                }
            });
        }
    });

    function updateRowCalculations(row) {
        var buyingPrice = parseFloat(row.find('input[name="variation_buying_price[]"]').val());
        var customerPrice = parseFloat(row.find('input[name="variation_customer_price[]"]').val());
        var taxGroupId = row.find('select[name="variation_tax_group_id[]"]').val();

        if (!isNaN(buyingPrice) && !isNaN(customerPrice) && taxGroupId) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(route_to('products.get_tax_rate')); ?>",
                data: {
                    tax_group_id: taxGroupId,
                    customer_price: customerPrice,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(response) {
                    var taxRate = parseFloat(response.total_tax_amount);
                    if (!isNaN(taxRate)) {
                        var taxAmount = (buyingPrice * taxRate) / 100;
                        var salePrice = customerPrice + taxAmount;
                        row.find('input[name="variation_tax_amount[]"]').val(taxAmount.toFixed(2));
                        row.find('input[name="variation_sale_price[]"]').val(salePrice.toFixed(2));
                    } else {
                        row.find('input[name="variation_tax_amount[]"]').val('');
                        row.find('input[name="variation_sale_price[]"]').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching tax rate:", error);
                }
            });
        }
    }
});
</script>
