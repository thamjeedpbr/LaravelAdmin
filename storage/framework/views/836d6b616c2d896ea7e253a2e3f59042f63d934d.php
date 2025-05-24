<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('assets/images/logo-dark.png')); ?>" alt="" height="17">
                        </span>
                    </a>
                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('assets/images/logo-light.png')); ?>" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                        aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-category-alt fs-22'></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fw-semibold fs-15"> Quick Links </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="/" class="btn btn-sm btn-soft-info"> View All Apps
                                        <i class="ri-arrow-right-s-line align-middle"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="p-2">
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="<?php echo e(route('users.index')); ?>">
                                        <img src="<?php echo e(URL::asset('assets/images/brands/users.png')); ?>" alt="Github">
                                        <span>Users</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?php if(Auth::user()->avatar != ''): ?><?php echo e(URL::asset('images/' . Auth::user()->avatar)); ?><?php else: ?><?php echo e(URL::asset('images/user-icon.webp')); ?><?php endif; ?>"
                                alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo e(Auth::user()->name); ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?php echo e(Auth::user()->roles[0]['display_name']); ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome <?php echo e(Auth::user()->name); ?>!</h6>
                       
                        <a class="dropdown-item" href="#">
                            <i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">Valid Till: <b><?php echo e(\Carbon\Carbon::parse(Auth::user()->valid_till)->format('F j, Y')); ?></b></span>
                        </a>
                        
                        <a class="dropdown-item" href="#">
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Token: <b id="token"><?php echo e(Auth::user()->token); ?></b></span>
                            <button class="btn btn-link text-muted fs-16 align-middle ms-2" onclick="copyToken('<?php echo e(Auth::user()->token); ?>')" title="Copy Token">
                                <i class="mdi mdi-content-copy"></i>
                            </button>
                        </a>
                        
                        
                        <a class="dropdown-item " href="javascript:void();"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span></a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /Users/thamjeedlal/Herd/detox/resources/views/layouts/topbar.blade.php ENDPATH**/ ?>