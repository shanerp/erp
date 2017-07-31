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
                <a href="#" id="toggle">
                    <span class="nav-label">Units</span>
                    <span class="glyphicon <?php echo ($current_page_menu == 'unit') ? 'glyphicon-minus' : 'glyphicon-plus' ?>" aria-hidden="true"></span>
                </a>
                <ul class="sub_menu list-unstyled <?php echo ($current_page_menu == 'unit') ? 'sidebar-dropdown-on' : '' ?>">
                    <li>
                        <a href="add-units.php">Add Units</a>
                    </li>
                    <li>
                        <a href="view-units.php">View Units</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>