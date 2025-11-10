<style>
    .suzuka-logo {
        width: 80%;
    }
</style>
<?php 

$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="index.php" class="navbar-brand">

            <!--Logo start-->
            <div class="logo-main">
                <div class="logo-normal">
                    <img src="./assets/images/auth/headerLogo.jpg" alt="logo" class=" suzuka-logo">
                </div>
                <div class="logo-mini">
                    <img src="./assets/images/auth/headerLogo.jpg" alt="logo" class=" suzuka-logo">
                </div>
            </div>
            <!--logo End-->

        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled" href="#" tabindex="-1">
                        <span class="default-icon">Home</span>
                        <span class="mini-icon">-</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page=='index.php')? 'active':''  ?>" aria-current="page" href="index.php">
                        <i class="fa-sharp fa-solid fa-table-columns"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page=='station_list.php' || $current_page=='station_add.php')? 'active':''  ?>" aria-current="page" href="./station_list.php">
                        <i class="fa-sharp fa-solid fa-train-subway"></i>
                        <span class="item-name">Railway Station</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page=='department_list.php' || $current_page=='department_add.php')? 'active':''  ?>" aria-current="page" href="./department_list.php">
                        <i class="fa-sharp fa-solid fa-building"></i>
                        <span class="item-name">Departments</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link <?= ($current_page =='designation_list.php' || $current_page=='designation_add.php')? 'active':''  ?>" aria-current="page" href="./designation_list.php">
                        <i class="fa-sharp fa-solid fa-briefcase"></i>
                        <span class="item-name">Designations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page =='shift_list.php' || $current_page=='shift_add.php')? 'active':''  ?>" aria-current="page" href="./shift_list.php">
                        <i class="fa-sharp fa-solid fa-clock"></i>
                        <span class="item-name">Shift</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page =='employee_list.php' || $current_page=='employee_add.php')? 'active':''  ?>" aria-current="page" href="./employee_list.php">
                        <i class="fa-sharp fa-solid fa-user-tie"></i>
                        <span class="item-name">Employees</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page =='attendance_history.php' )? 'active':''  ?>" aria-current="page" href="./attendance_history.php">
                        <i class="fa-sharp fa-solid fa-table"></i>
                        <span class="item-name">Attendance History</span>
                    </a>
                </li>
            </ul>
            <!-- Sidebar Menu End -->
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>