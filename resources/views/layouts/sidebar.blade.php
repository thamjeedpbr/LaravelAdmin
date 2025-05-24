<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="17">
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
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                @canany(['view-roles', 'view-users'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarApplicationMasters" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarApplicationMasters">
                            <i class="ri-file-list-line"></i> <span>@lang('menu.application master')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarApplicationMasters">
                            <ul class="nav nav-sm flex-column">
                                @can('view-roles')
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}" class="nav-link">@lang('menu.roles')</a>
                                    </li>
                                @endcan
                                @can('view-users')
                                    <li class="nav-item">
                                        <a href="{{ route('users.index') }}" class="nav-link">@lang('menu.users')</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                
                <!-- Quiz Management Section -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarQuizManagement" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarQuizManagement">
                        <i class="ri-question-answer-line"></i> <span>Quiz Management</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarQuizManagement">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('quizzes.index') }}" class="nav-link">Quizzes</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('quizzes.create') }}" class="nav-link">Create Quiz</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                @canany(['view-whatsapp-client'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarUserManagement" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarUserManagement">
                            <i class="ri-book-line"></i> <span>Whatsapp Client</span>
                        </a>
                        <div class="menu-dropdown" id="sidebarUserManagement">
                            <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('whatsapp_client.index') }}" class="nav-link">WhatsApp Client</a>
                                    </li>
                            </ul>
                        </div>
                    </li>
                @endcanany
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
