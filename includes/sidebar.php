<aside class="left-panel">
    <span class="glyphicon glyphicon-menu-left left_panel_toggle_btn" aria-hidden="true"></span>
    <nav class="navigation">
        <ul class="list-unstyled">
            <li>
                <a href="dashboard.php">
                    <span class="nav-label">Dashboard</span>
                    <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
                </a>
            </li>
            <li>
                <a href="purchase.php">
                    <span class="nav-label">Purchase</span>
                    <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
                </a>
            </li>
            <li>
                <a href="#" id="toggle">
                    <span class="nav-label">Sell</span>
                    <span class="glyphicon <?php echo ($current_page_menu == 'sell') ? 'glyphicon-minus' : 'glyphicon-plus' ?>" aria-hidden="true"></span>
                </a>
                <ul class="sub_menu list-unstyled <?php echo ($current_page_menu == 'sell') ? 'sidebar-dropdown-on' : '' ?>">
                    <li>
                        <a href="retail-sell.php">Retail</a>
                    </li>
                    <li>
                        <a href="whole-sell.php">Wholesale</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" id="toggle">
                    <span class="nav-label">Products</span>
                    <span class="glyphicon <?php echo ($current_page_menu == 'product') ? 'glyphicon-minus' : 'glyphicon-plus' ?>" aria-hidden="true"></span>
                </a>
                <ul class="sub_menu list-unstyled <?php echo ($current_page_menu == 'product') ? 'sidebar-dropdown-on' : '' ?>">
                    <li>
                        <a href="add-products.php">Add Products</a>
                    </li>
                    <li>
                        <a href="view-products.php">View Products</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" id="toggle">
                    <span class="nav-label">Vendors</span>
                    <span class="glyphicon <?php echo ($current_page_menu == 'vendor') ? 'glyphicon-minus' : 'glyphicon-plus' ?>" aria-hidden="true"></span>
                </a>
                <ul class="sub_menu list-unstyled <?php echo ($current_page_menu == 'vendor') ? 'sidebar-dropdown-on' : '' ?>">
                    <li>
                        <a href="add-vendor.php">Add Vendor</a>
                    </li>
                    <li>
                        <a href="#">View Vendors</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" id="toggle">
                    <span class="nav-label">Report</span>
                    <span class="glyphicon <?php echo ($current_page_menu == 'report') ? 'glyphicon-minus' : 'glyphicon-plus' ?>" aria-hidden="true"></span>
                </a>
                <ul class="sub_menu list-unstyled <?php echo ($current_page_menu == 'report') ? 'sidebar-dropdown-on' : '' ?>">
                    <li>
                        <a href="invoice-report.php">Invoice Report</a>
                    </li>
                    <li>
                        <a href="purchase-report.php">Purchase Report</a>
                    </li>
                    <li>
                        <a href="sell-report.php">Sell Report</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>