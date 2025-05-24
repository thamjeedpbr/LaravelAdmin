<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('assets/images/logo-dark.png')); ?>" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('assets/images/logo-light.png')); ?>" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span><?php echo app('translator')->get('translation.menu'); ?></span></li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-roles', 'view-users'])): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarApplicationMasters" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarApplicationMasters">
                            <i class="ri-file-list-line"></i> <span><?php echo app('translator')->get('menu.application master'); ?></span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarApplicationMasters">
                            <ul class="nav nav-sm flex-column">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-roles')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('roles.index')); ?>" class="nav-link"><?php echo app('translator')->get('menu.roles'); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-users')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('users.index')); ?>" class="nav-link"><?php echo app('translator')->get('menu.users'); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                
                <!-- Quiz Management Section -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarQuizManagement" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarQuizManagement">
                        <i class="ri-question-answer-line"></i> <span>Quiz Management</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarQuizManagement">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('quizzes.index')); ?>" class="nav-link">Quizzes</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('quizzes.create')); ?>" class="nav-link">Create Quiz</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-whatsapp-client'])): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarUserManagement" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarUserManagement">
                            <i class="ri-book-line"></i> <span>Whatsapp Client</span>
                        </a>
                        <div class="menu-dropdown" id="sidebarUserManagement">
                            <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('whatsapp_client.index')); ?>" class="nav-link">WhatsApp Client</a>
                                    </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH /Users/thamjeedlal/Herd/detox/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>