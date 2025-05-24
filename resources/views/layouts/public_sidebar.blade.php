<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                @canany(['view-roles','view-institutions','view-academic_years','view-departments','view-courses','view-classes'])
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
                            @can('view-institutions')
                                <li class="nav-item">
                                    <a href="{{ route('institutions.index') }}" class="nav-link">@lang('menu.institutions')</a>
                                </li>
                            @endcan
                            @can('view-academic_years')
                                <li class="nav-item">
                                    <a href="{{ route('academic_year.index') }}" class="nav-link">@lang('menu.academic_years')</a>
                                </li>
                            @endcan
                            @can('view-departments')
                            <li class="nav-item">
                                <a href="{{ route('departments.index') }}" class="nav-link">@lang('menu.departments')</a>
                            </li>
                            @endcan
                            @can('view-courses')
                            <li class="nav-item">
                                <a href="{{ route('courses.index') }}" class="nav-link">@lang('menu.courses')</a>
                            </li>
                            @endcan
                            @can('view-classes')
                            <li class="nav-item">
                                <a href="{{ route('class-rooms.index') }}" class="nav-link">@lang('menu.classes')</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany
                @canany(['view-users','view-teachers','view-students'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUserManagement" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarUserManagement">
                        <i class="ri-file-user-line"></i> <span>@lang('menu.user management')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarUserManagement">
                        <ul class="nav nav-sm flex-column">
                            @can('view-users')
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">@lang('menu.users')</a>
                            </li>
                            @endcan
                            @can('view-teachers')
                            <li class="nav-item">
                                <a href="{{ route('teachers.index') }}" class="nav-link">@lang('menu.teachers')</a>
                            </li>
                            @endcan
                            @can('view-students')
                            <li class="nav-item">
                                <a href="{{ route('students.index') }}" class="nav-link">@lang('menu.students')</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany
                @canany(['view-batches','view-subjects'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAcademicSetup" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAcademicSetup">
                        <i class="ri-bar-chart-box-line"></i> <span>@lang('menu.academic setup')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAcademicSetup">
                        <ul class="nav nav-sm flex-column">
                            @can('view-batches')
                            <li class="nav-item">
                                <a href="{{ route('batches.index') }}" class="nav-link">@lang('menu.batches')</a>
                            </li>
                            @endcan
                            @can('view-subjects')
                            <li class="nav-item">
                                <a href="{{ route('subjects.index') }}" class="nav-link">@lang('menu.subject management')</a>
                            </li>
                            @endcan

                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['view-batches','view-subjects','view-batch_assign','students'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAdmission" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAdmission">
                        <i class="ri-bar-chart-box-line"></i> <span>@lang('menu.admission')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAdmission">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('onlineadmission.index') }}" class="nav-link">@lang('menu.online_admission')</a>
                            </li>

                            @can('view-students')
                            <li class="nav-item">
                                <a href="{{ route('students.index') }}" class="nav-link">@lang('menu.students')</a>
                            </li>
                            @endcan
                            @can('view-batch_assign')
                            <li class="nav-item">
                                <a href="{{ route('student-assign.index') }}"
                                    class="nav-link">@lang('menu.student-assign')</a>
                            </li>
                            @endcan
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
