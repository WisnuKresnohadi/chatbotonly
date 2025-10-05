<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ $global->logo_url }}"
             alt="AdminLTE Logo"
             class="brand-image img-fluid">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
   
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" id="sidebarnav" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                        <div style="display: flex; align-items: center;">
                            <i class="material-symbols-outlined mx-1" style="font-size: 16px;">space_dashboard</i>
                            <p class="mx-1">
                                @lang('menu.dashboard')
                            </p>
                        </div>
                    </a>
                </li>
                @permission('view_jobs')
                <li class="nav-item">
                    <a href="{{ route('admin.jobs.index') }}" class="nav-link {{ request()->is('admin/jobs*') ? 'active' : '' }}">
                        <div style="display: flex; align-items: center;">
                            <i class="material-symbols-outlined mx-1" style="font-size: 16px;">work</i>
                            <p class="mx-1">
                                @lang('menu.jobs')
                            </p>
                        </div>
                    </a>
                </li>
                @endpermission

                @permission('view_job_applications')
                <li class="nav-item">
                <a href="{{ route('admin.company.index') }}" class="nav-link {{ request()->is('admin/company*') ? 'active' : '' }}">
                        <div style="display: flex; align-items: center;">
                            <i class="material-symbols-outlined mx-1" style="font-size: 16px;">draft</i>
                            <p class="mx-1">
                                @lang('menu.jobApplications')
                            </p>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.candidate.index') }}" class="nav-link {{ request()->is('admin/candidate*') ? 'active' : '' }}">
                        <div style="display: flex; align-items: center;">
                            <i class="material-symbols-outlined mx-1" style="font-size: 16px;">table</i>
                            <p class="mx-1">
                                @lang('menu.candidateDatabase')
                            </p>
                        </div>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.job-onboard.index') }}" class="nav-link {{ request()->is('admin/job-onboard*') ? 'active' : '' }}">
                        <div style="display: flex; align-items: center;">
                            <i class="material-symbols-outlined mx-1" style="font-size: 16px;">person</i>
                            <p class="mx-1">
                                @lang('app.job') @lang('app.onBoard')
                            </p>
                        </div>
                    </a>
                </li> --}}
                @endpermission

                @permission('view_schedule')
                <li class="nav-item">
                    <a href="{{ route('admin.interview-schedule.index') }}" class="nav-link {{ request()->is('admin/interview-schedule*') ? 'active' : '' }}">
                        <div style="display: flex; align-items: center;">
                            <i class="material-symbols-outlined mx-1" style="font-size: 16px;">calendar_month</i>
                            <p class="mx-1">
                                @lang('menu.interviewSchedule')
                            </p>
                        </div>
                    </a>
                </li>
                @endpermission

                @permission('view_team')
                <li class="nav-item">
                    <a href="{{ route('admin.team.index') }}" class="nav-link {{ request()->is('admin/team*') ? 'active' : '' }}">
                        <div style="display: flex; align-items: center;">
                            <i class="material-symbols-outlined mx-1" style="font-size: 16px;">groups</i>
                            <p class="mx-1">
                                @lang('menu.team')
                            </p>
                        </div>
                    </a>
                </li>
                @endpermission

                {{-- @if ($user->roles->count() > 0)
                    <li class="nav-item">
                        <a href="{{ route('admin.todo-items.index') }}" class="nav-link {{ request()->is('admin/todo-items*') ? 'active' : '' }}">
                            <div style="display: flex; align-items: center;">
                                <i class="material-symbols-outlined mx-1" style="font-size: 16px;">format_list_bulleted</i>
                                <p class="mx-1">
                                    @lang('menu.todoList')
                                </p>
                            </div>
                        </a>
                    </li>
                @endif --}}

                {{-- Testing Dulu --}}
                @permission('manage_master_data')
                <li class="nav-item has-treeview @if(\Request()->is('admin/job-category/*'))active menu-open @endif">
                    <a href="#" class="nav-link" style="display: flex; align-items: center;">
                        <i class="material-symbols-outlined mx-1" style="font-size: 16px;">dataset</i>
                        <p class="mx-1">
                            @lang('menu.masterData')
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @permission('manage_master_data')
                        <li class="nav-item">
                            <a href="{{ route('admin.job-categories.index') }}" class="nav-link {{ request()->is('admin/job-categories*') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.jobCategories')</p>
                            </a>
                        </li>
                        @endpermission
                        @permission('manage_master_data')
                        <li class="nav-item">
                            <a href="{{ route('admin.job-industries.index') }}" class="nav-link {{ request()->is('admin/job-industries*') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.jobIndustries')</p>
                            </a>
                        </li>
                        @endpermission
                        @permission('manage_master_data')
                        <li class="nav-item">
                            <a href="{{ route('admin.skills.index') }}" class="nav-link {{ request()->is('admin/skills*') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.skills')</p>
                            </a>
                        </li>
                        @endpermission
                        @permission('manage_master_data')
                        <li class="nav-item">
                            <a href="{{ route('admin.master-company.index') }}" class="nav-link {{ request()->is('admin/master-company*') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.companies')</p>
                            </a>
                        </li>
                        @endpermission
                        @permission('manage_master_data')
                        <li class="nav-item">
                            <a href="{{ route('admin.locations.index') }}" class="nav-link {{ request()->is('admin/locations*') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.locations')</p>
                            </a>
                        </li>
                        @endpermission
                        @permission('manage_master_data')
                        <li class="nav-item">
                            <a href="{{ route('admin.majors.index') }}" class="nav-link {{ request()->is('admin/majors*') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.majors')</p>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endpermission
                {{-- Okee ini end ny --}}
                
                <li class="nav-item has-treeview @if(\Request()->is('admin/settings/*') || \Request()->is('admin/profile*'))active menu-open @endif">
                    <a href="#" class="nav-link" style="display: flex; align-items: center;">
                        <i class="material-symbols-outlined mx-1" style="font-size: 16px;">settings</i>
                        <p class="mx-1">
                            @lang('menu.settings')
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.profile.index') }}" class="nav-link {{ request()->is('admin/profile*') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> @lang('menu.myProfile')</p>
                            </a>
                        </li>
                        @permission('manage_settings')
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->is('admin/settings/settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.businessSettings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.application-setting.index') }}" class="nav-link {{ request()->is('admin/settings/application-setting') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.applicationFormSettings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.role-permission.index') }}" class="nav-link {{ request()->is('admin/settings/role-permission') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.rolesPermission')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.language-settings.index') }}" class="nav-link {{ request()->is('admin/settings/language-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('app.language') @lang('menu.settings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.footer-settings.index') }}" class="nav-link {{ request()->is('admin/settings/footer-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.footerSettings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.theme-settings.index') }}" class="nav-link {{ request()->is('admin/settings/theme-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.themeSettings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.smtp-settings.index') }}" class="nav-link {{ request()->is('admin/settings/smtp-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.mailSetting')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sms-settings.index') }}" class="nav-link {{ request()->is('admin/settings/sms-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.smsSettings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.linkedin-settings.index') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.linkedInSettings')</p>
                            </a>
                        </li>
                        @if($global->system_update == 1)
                        <li class="nav-item">
                            <a href="{{ route('admin.update-application.index') }}" class="nav-link {{ request()->is('admin/settings/update-application') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.updateApplication')</p>
                            </a>
                        </li>
                        @endif
                        {{--
                        <li class="nav-item">
                            <a href="https://envato-froiden.freshdesk.com/support/solutions/" class="nav-link" target="_blank">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.help')</p>
                            </a>
                        </li>
                        --}}
                        @endpermission

                    </ul>
                </li>
                <li class="nav-header mt-2" style="padding: 8px!important;">MISCELLANEOUS</li>
                <li class="nav-item">
                    <a href="{{ url('/') }}" target="_blank" class="nav-link">
                        <div style="display: flex; align-items: center;">
                            <i class="material-symbols-outlined mx-1" style="font-size: 16px;">house</i>
                            <p class="mx-1">
                                Front Website
                            </p>
                        </div>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>