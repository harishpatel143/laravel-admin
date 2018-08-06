<?php
if (empty($activeSidebarMenu)) {
    $activeSidebarMenu = "";
}
if (empty($activeSidebarSubMenu)) {
    $activeSidebarSubMenu = "";
}
$sidebarMenus = [
    'dashboard' => [
        'text' => 'Dashboard',
        'routeName' => 'home',
        'permissionKey' => [],
        'icon' => 'fa fa-home'
    ],
    'settings' => [
        'text' => 'Settings',
        'icon' => 'fa fa-cogs',
        'subMenu' => [
            'administrators' => [
                'text' => 'Administrators',
                'routeName' => 'administrators',
                'permissionKey' => ['administrator-listing'],
                'icon' => 'fa fa-users'
            ],
            'roles' => [
                'text' => 'Roles',
                'routeName' => 'roles',
                'permissionKey' => ['roles-listing'],
                'icon' => 'fa fa-circle-o'
            ]
        ]
    ],
];
?>
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset(Auth::guard('admin')->user()->avatar) }}" class="img-circle" alt="User Image" style="height: 45px;">
        </div>
        <div class="pull-left info" style="margin-top: 7px;">
            <p>{{ Auth::guard('admin')->user()->full_name }}</p>       
        </div>
    </div>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <?php
        foreach ($sidebarMenus as $key => $menu) {
            if (empty($menu['permissionKey']) || Multidots\Admin\Traits\CheckRolePermission::hasAccess($menu['permissionKey'])) {
                $active = ($key == $activeSidebarMenu) ? 'active' : '';
                $subMenu = !empty($menu['subMenu']) ? 'treeview' : '';
                $href = (!empty($menu['routeName'])) ? route($menu['routeName']) : 'javascript:;';
                ?>
                <li class="<?php echo $active . ' ' . $subMenu; ?>">
                    <a href="<?php echo (!empty($menu['routeName'])) ? route($menu['routeName']) : 'javascript:;'; ?>">
                        <i class="<?= $menu['icon']; ?>"></i>
                        <span><?php echo $menu['text']; ?></span>
                        <?php if (!empty($menu['subMenu'])) { ?>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        <?php } ?>
                    </a>
                    <?php if (!empty($menu['subMenu'])) { ?>
                        <ul class="treeview-menu">
                            <?php
                            foreach ($menu['subMenu'] as $innerKey => $innerMenu) {
                                if (empty($innerMenu['permissionKey']) || Multidots\Admin\Traits\CheckRolePermission::hasAccess($innerMenu['permissionKey'])) {
                                    ?>
                                    <li class="<?php echo ($innerKey == $activeSidebarSubMenu) ? 'active' : ''; ?>">
                                        <a href="<?php echo (!empty($innerMenu['routeName'])) ? route($innerMenu['routeName']) : 'javascript:;'; ?>">
                                            <i class="<?= $innerMenu['icon']; ?>"></i>
                                            <?php echo $innerMenu['text']; ?>                                    
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <?php
            }
        }
        ?>        
    </ul>
</section>
<!-- /.sidebar -->