<!-- Sidebar Menu -->
<nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


        <li class="nav-item">
            <a href="<?php echo url('dashboard') ?>"
                class="nav-link <?php echo (@$_page->menu == 'dashboard') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    <?php echo lang('App.dashboard') ?>
                </p>
            </a>
        </li>

        <!-- Product Management Menu -->
        <?php if (hasPermissions('product_management')): ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'product_management') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?php echo (@$_page->menu == 'product_management') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-cube"></i>
                    <p>
                        <?php echo lang('App.product_management') ?>
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <!-- Products Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'Products') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'Products') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.products') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Products List -->
                            <?php if (hasPermissions('products_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('products.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Products List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.products_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New Product -->
                            <?php if (hasPermissions('products_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('products.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New Product') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.add_new_product') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add other product-related actions as needed -->
                        </ul>
                    </li>

                    <!-- Brands Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'Brands') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'Brands') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.brands') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Brands List -->
                            <?php if (hasPermissions('brands_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('brands.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Brands List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.brands_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New Brand -->
                            <?php if (hasPermissions('brands_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('brands.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New Brand') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.add_new_brand') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add other brand-related actions as needed -->
                        </ul>
                    </li>

                    <!-- Units Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'Units') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'Units') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.units') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Units List -->
                            <?php if (hasPermissions('units_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('units.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Units List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.units_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New Unit -->
                            <?php if (hasPermissions('units_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('units.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New Unit') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.add_new_unit') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add other unit-related actions as needed -->
                        </ul>
                    </li>

                    <!-- Categories Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'Categories') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'Categories') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.categories') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Categories List -->
                            <?php if (hasPermissions('categories_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('categories.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Categories List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.categories_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New Category -->
                            <?php if (hasPermissions('categories_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('categories.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New Category') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.add_new_category') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add other category-related actions as needed -->
                        </ul>
                    </li>

                    <!-- Sub-Categories Menu -->
                    <li
                        class="nav-item has-treeview <?php echo (@$_page->submenu == 'Sub-Categories') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'Sub-Categories') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.sub_categories') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Sub-Categories List -->
                            <?php if (hasPermissions('sub_categories_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('sub-categories.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Sub-Categories List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.sub_categories_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New Sub-Category -->
                            <?php if (hasPermissions('sub_categories_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('sub-categories.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New Sub-Category') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.add_new_sub_category') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add other sub-category-related actions as needed -->
                        </ul>
                    </li>

                    <!-- Variations Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'Variations') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'Variations') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.variations') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Variations List -->
                            <?php if (hasPermissions('variations_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('variations.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Variations List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.variations_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New Variation -->
                            <?php if (hasPermissions('variations_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('variations.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New Variation') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.add_new_variation') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add other variation-related actions as needed -->
                        </ul>
                    </li>

                    <!-- Tax Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'Tax') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'Tax') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.tax') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Tax Groups List -->
                            <?php if (hasPermissions('tax_groups_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('tax-groups.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Tax Groups List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.tax_groups_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New Tax Group -->
                            <?php if (hasPermissions('tax_groups_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('tax-groups.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New Tax Group') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo lang('App.add_new_tax_group') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>

                </ul>
            </li>
        <?php endif; ?>

        <!-- Inventory Management Menu -->
        <?php if (hasPermissions('inventory_management')): ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'inventory_management') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?php echo (@$_page->menu == 'inventory_management') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-map-marker"></i>
                    <p>
                        <?php echo lang('App.inventory_management') ?>
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <!-- City Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'City') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'City') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.city') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- City List -->
                            <?php if (hasPermissions('cities_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('cities.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'City List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> <?php echo lang('App.city_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New City -->
                            <?php if (hasPermissions('cities_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('cities.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New City') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> <?php echo lang('App.add_new_city') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>

                </ul>
            </li>
        <?php endif; ?>

        <!-- Purchase Management Menu -->
        <?php if (hasPermissions('purchase_management')): ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'purchase_management') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?php echo (@$_page->menu == 'purchase_management') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        <?php echo lang('App.purchase_management') ?>
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <!-- Purchase Orders List -->
                    <?php if (hasPermissions('purchases_list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url(route_to('purchases.index')) ?>"
                                class="nav-link <?php echo (@$_page->submenu == 'Purchases List') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> <?php echo lang('App.purchases_list') ?></p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- Create New Purchase Order -->
                    <?php if (hasPermissions('purchases_add')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url(route_to('purchases.add')) ?>"
                                class="nav-link <?php echo (@$_page->submenu == 'Create New Purchase') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> <?php echo lang('App.add_new_purchase') ?></p>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <!-- Sales Management Menu -->
        <?php if (hasPermissions('sales_management')): ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'sales_management') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?php echo (@$_page->menu == 'sales_management') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <p>
                        <?php echo lang('App.sales_management') ?>
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <!-- Sales Orders List -->
                    <?php if (hasPermissions('sales_list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url(route_to('sales.index')) ?>"
                                class="nav-link <?php echo (@$_page->submenu == 'Sales List') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> <?php echo lang('App.sales_list') ?></p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- Create New Sales Order -->
                    <?php if (hasPermissions('sales_add')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url(route_to('sales.add')) ?>"
                                class="nav-link <?php echo (@$_page->submenu == 'Add New Sale') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> <?php echo lang('App.add_new_sale') ?></p>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <!-- Supplier Management Menu -->
        <?php if (hasPermissions('supplier_management')): ?>
            <li class="nav-item <?php echo (@$_page->menu == 'supplier_management') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?php echo (@$_page->menu == 'supplier_management') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-truck"></i>
                    <p>
                        <?php echo lang('App.supplier_management') ?>
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <!-- Suppliers List -->
                    <?php if (hasPermissions('suppliers_list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url(route_to('suppliers.index')) ?>"
                                class="nav-link <?php echo (@$_page->submenu == 'Suppliers List') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> <?php echo lang('App.suppliers_list') ?></p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Add New Supplier -->
                    <?php if (hasPermissions('suppliers_add')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url(route_to('suppliers.add')) ?>"
                                class="nav-link <?php echo (@$_page->submenu == 'Add New Supplier') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> <?php echo lang('App.add_new_supplier') ?></p>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </li>
        <?php endif; ?>


        <!-- Customer Management Menu -->
        <?php if (hasPermissions('customer_management')): ?>
            <li class="nav-item <?php echo (@$_page->menu == 'customer_management') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?php echo (@$_page->menu == 'customer_management') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        <?php echo lang('App.customer_management') ?>
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <!-- Customers List -->
                    <?php if (hasPermissions('customers_list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url(route_to('customers.index')) ?>"
                                class="nav-link <?php echo (@$_page->submenu == 'Customers List') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> <?php echo lang('App.customers_list') ?></p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Add New Customer -->
                    <?php if (hasPermissions('customers_add')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url(route_to('customers.add')) ?>"
                                class="nav-link <?php echo (@$_page->submenu == 'Add New Customer') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> <?php echo lang('App.add_new_customer') ?></p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Customer Balances -->
                    <?php if (hasPermissions('customer_balances')): ?>
                        <li class="nav-item">
                            <a href="<?= url(route_to('customers.balances')) ?>"
                                class="nav-link <?= (@$_page->submenu == 'Customer Balances') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('App.customer_balances') ?></p>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </li>
        <?php endif; ?>

        <!-- Locations Menu -->
        <?php if (hasPermissions('location_management')): ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'locations') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?php echo (@$_page->menu == 'locations') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-map-marker"></i>
                    <p>
                        <?php echo lang('App.locations') ?>
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <!-- City Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'City') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'City') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.city') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- City List -->
                            <?php if (hasPermissions('cities_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('cities.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'City List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> <?php echo lang('App.city_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New City -->
                            <?php if (hasPermissions('cities_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('cities.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New City') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> <?php echo lang('App.add_new_city') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <!-- State Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'State') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'State') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.state') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- State List -->
                            <?php if (hasPermissions('states_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('states.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'State List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> <?php echo lang('App.state_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New State -->
                            <?php if (hasPermissions('states_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('states.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New State') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> <?php echo lang('App.add_new_state') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <!-- Country Menu -->
                    <li class="nav-item has-treeview <?php echo (@$_page->submenu == 'Country') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo (@$_page->submenu == 'Country') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo lang('App.country') ?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Country List -->
                            <?php if (hasPermissions('countries_list')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('countries.index')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Countries List') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> <?php echo lang('App.country_list') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Add New Country -->
                            <?php if (hasPermissions('countries_add')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo url(route_to('countries.add')) ?>"
                                        class="nav-link <?php echo (@$_page->submenu == 'Add New Country') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> <?php echo lang('App.add_new_country') ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>

                </ul>
            </li>
        <?php endif; ?>

        <!-- User Management Menu -->
        <?php if (hasPermissions('users_management')): ?>
            <li class="nav-item has-treeview <?= (@$_page->menu == 'User Management') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?= (@$_page->menu == 'User Management') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        <?= lang('App.users_management') ?>
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <!-- Users List -->
                    <?php if (hasPermissions('users_list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url('users') ?>"
                                class="nav-link <?php echo (@$_page->menu == 'users') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    <?php echo lang('App.users_list') ?>
                                </p>
                            </a>
                        </li>
                    <?php endif ?>
                    <!-- Roles Management -->
                    <?php if (hasPermissions('roles_list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url('roles') ?>"
                                class="nav-link <?php echo (@$_page->menu == 'roles') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-lock"></i>
                                <p>
                                    <?php echo lang('App.manage_roles') ?>
                                </p>
                            </a>
                        </li>
                    <?php endif ?>
                    <!-- Permissions Management -->
                    <?php if (hasPermissions('permissions_list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url('permissions') ?>"
                                class="nav-link <?php echo (@$_page->menu == 'permissions') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    <?php echo lang('App.manage_permissions') ?>
                                </p>
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (hasPermissions('company_settings')): ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'settings') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link  <?php echo (@$_page->menu == 'settings') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        <?php echo lang('App.settings') ?>
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo url('settings/general') ?>"
                            class="nav-link <?php echo (@$_page->submenu == 'general') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo lang('App.general_setings') ?> </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo url('settings/company') ?>"
                            class="nav-link <?php echo (@$_page->submenu == 'company') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo lang('App.company_setings') ?> </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo url('settings/email_templates') ?>"
                            class="nav-link <?php echo (@$_page->submenu == 'email_templates') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo lang('App.manage_email_template') ?></p>
                        </a>
                    </li>
                    <?php if (hasPermissions('activity_log_list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url('activityLogs') ?>"
                                class="nav-link <?php echo (@$_page->menu == 'activity_logs') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    <?php echo lang('App.activity_logs') ?>
                                </p>
                            </a>
                        </li>
                    <?php endif ?>
                    <?php if (hasPermissions('backup_db')): ?>
                        <li class="nav-item">
                            <a href="<?php echo url('backup') ?>"
                                class="nav-link <?php echo (@$_page->menu == 'backup') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    <?php echo lang('App.backup') ?>
                                </p>
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </li>
        <?php endif ?>

        <?php if (hasPermissions('logout')): ?>
            <li class="nav-item">
                <a href="<?php echo url('auth/logout') ?>"
                    class="nav-link <?php echo (@$_page->menu == 'logout') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                        <?php echo lang('App.logout') ?>
                    </p>
                </a>
            </li>
        <?php endif ?>

    </ul>
</nav>
<!-- /.sidebar-menu -->