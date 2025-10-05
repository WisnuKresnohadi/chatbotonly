<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css/app.css">
<!-- <title>Navigation Right Alignment</title> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<style>
    .image-container {
        display: flex;
        align-items: center;
    }

    .image-container .image {
        display: inline-block;
        position: relative;
        width: 32px;
        height: 32px;
        overflow: hidden;
        border-radius: 50%;
        margin-right: 10px;
    }

    .image-container .image img {
        width: auto;
        height: 100%;
    }

    #top-notification-dropdown>a {
        position: relative;
    }

    #top-notification-dropdown>a span {
        position: absolute;
        right: 10%;
        top: 10%;
    }

    #top-notification-dropdown>a span.badge {
        padding: 2px 5px;
    }

    .scrollable {
        max-height: 250px;
        overflow-y: scroll;
    }

    .active {
        color: #1967D2 !important;
    }


    #Perusahaan {
        color: var(--typography-color-heading-text, var(--typography-color-heading-text, #23314B));
        font-feature-settings: 'clig' off, 'liga' off;
        /* Basic Typography/Paragraph/Paragraph 1 - Medium */

        margin-left: 50px;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: 22px;

        /* 146.667% */
    }

    #program {
        color: var(--typography-color-heading-text, var(--typography-color-heading-text, #23314B));
        font-feature-settings: 'clig' off, 'liga' off;
        /* Basic Typography/Paragraph/Paragraph 1 - Medium */

        margin-left: 30px;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: 22px;

        /* 146.667% */
    }

    #lamaransaya {
        color: var(--typography-color-heading-text, var(--typography-color-heading-text, #23314B));
        font-feature-settings: 'clig' off, 'liga' off;
        /* Basic Typography/Paragraph/Paragraph 1 - Medium */

        margin-left: 30px;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: 22px;
        /* 146.667% */
    }

    #layanan {
        color: var(--typography-color-heading-text, var(--typography-color-heading-text, #23314B));
        font-feature-settings: 'clig' off, 'liga' off;
        /* Basic Typography/Paragraph/Paragraph 1 - Medium */

        margin-left: 30px;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: 22px;
        /* 146.667% */
    }

    a.btn.btn-outline-success:hover {
        background-color: white !important;
    }

    button.btn.btn-outline-success.dropdown-toggle {
        background-color: white !important;
        color: #4EA971 !important;
    }
</style>

<header class="main-header">
    <div class="container-fluid" style="padding: 0!important;">
        <!-- Main box -->
        <div class="main-box mx-4">
            <!--Nav Outer -->
            <div class="logo-box mr-3">
                <div class="logo mr-3" style="margin-left: 30px;"> <img src="{{ asset('front/assets/img/logo.svg') }}" class="img-fluid" alt=""><a href="{{ url('/') }}"></a></div>

                <div id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a id="Perusahaan" class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Perusahaan</a>
                        <div class="dropdown-menu" style="height:80px; width:180px;">
                            <a class="dropdown-item" href="#">Daftar Mitra </a>
                            <a class="dropdown-item" href="#">Lowongan Magang</a>
                        </div>
                    </div>
                </div>
                <div id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a id="program" class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Program Magang</a>
                        <div class="dropdown-menu" style="height:80px; width:180px;">
                            <a class="dropdown-item" href="/magang_fakultas">Magang Fakultas </a>
                            <a class="dropdown-item" href="/informasi/magang">Informasi Magang</a>
                        </div>
                    </div>
                </div>
                <div id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a id="lamaransaya" class="nav-link" href="#">Lamaran Saya</a>
                    </div>
                </div>
                <div id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a id="layanan" class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Layanan LKM</a>
                        <div class="dropdown-menu" style="height:190px; width:270px;">
                            <a class="dropdown-item" href="#">Logbook</a>
                            <a class="dropdown-item" href="#">Persetujuan Dosen Wali</a>
                            <a class="dropdown-item" href="#">Konfirmasi Magang</a>
                            <a class="dropdown-item" href="#">Input Dokumen Magang Mandiri</a>
                            <a class="dropdown-item" href="#">Input Dokumen Magang Kerja</a>
                        </div>
                    </div>
                </div>




            </div>
            @php
            $user = Auth::user();
            @endphp
            @if (!$user)

            <div class=" outer-box">
                <!--Dropdown Bahasa-->
                <div class="btn-group">

                    <!-- Login/Register -->
                    <a href="{{ route('login')}}">
                        <button class="btn btn-outline-success me-2" style="margin-left:450px; border-radius: 8px;" type="button">Masuk</button>
                    </a>
                    <a href="{{ route('register')}}">
                        <button class="btn btn-outline-success me-2 ml-2" style="border-radius: 8px;" type="button">Daftar</button>
                    </a>


                    <!-- <a href="{{ route('register')}}" style="text-decoration: none; color:#23314B; font-weight: 500; font-size: 15px;">Untuk Perusahaan</a> -->
                </div>
            </div>
            @else
            <div class="outer-box">
                <!-- Notifications Dropdown Menu -->
                @if($user && is_array($user->roles) && count($user->roles) > 0 && $user->roles[0]->name != 'applicant'
                || $user->profile)
                <li class="nav-item dropdown" id="top-notification-dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell-o" style="color:black;"></i>
                        @if(count($user->unreadNotifications) > 0)
                        <span class="badge badge-warning navbar-badge">{{ count($user->unreadNotifications) }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="scrollable">
                            @foreach ($user->unreadNotifications as $notification)
                            @include('notifications.'.snake_case(class_basename($notification->type)))
                            @endforeach
                        </div>
                        @if(count($user->unreadNotifications) > 0)
                        <a id="mark-notification-read" href="javascript:void(0);" class="dropdown-item dropdown-footer">@lang('app.markNotificationRead') <i class="fa fa-check"></i></a>
                        @else
                        <a href="javascript:void(0);" class="dropdown-item dropdown-footer">@lang('messages.notificationNotFound') </a>
                        @endif
                    </div>
                </li>
                @endif
                <nav class="nav main-menu" style="min-width: 160px;">
                    <ul class="navigation p-0 m-0" id="navbar">
                        <li class="current dropdown p-0 m-0">
                            <a class="image-container nav-link waves-effect waves-light" style="display: flex; align-items: center; justify-content: center; text-align: left;">
                                <div class="image">
                                    <img src="{{ Auth::user()->profile_image_url ?? '\assets\images\user.png'}}" style=" vertical-align:unset;" alt="User Image">
                                </div>
                                <div style="line-height: normal;">
                                    <span style="color:black;">{{ ucwords($user->name) }}<br></span>
                                    @if($user && is_array($user->roles) && count($user->roles) > 0 &&
                                    $user->roles[0]->name != 'applicant')
                                    <span class="text-muted" style="font-size: 12px;">{{ $user->roles[0]->name }}</span>
                                    @endif
                                </div>
                            </a>
                            <ul>

                                @if(isset($user) && isset($user->roles) && count($user->roles) > 0 &&
                                $user->roles[0]->name == 'applicant')
                                @if($user->profile)
                                <li><a href="{{ route('profile.index') }}" class="{{ request()->is('profile') ? 'active' : '' }}">My Profile</a></li>
                                <li><a href="{{ route('application.index') }}" class="{{ request()->is('profile/applications') ? 'active' : '' }}">My
                                        Applications</a></li>
                                @else
                                <li><a href="{{ route('profile.setup') }}" class="{{ request()->is('profile/setup') ? 'active' : '' }}">Setup Profile</a>
                                </li>
                                @endif
                                @else

                                <li><a href="">Dashboard</a></li>

                                @endif
                                @if ($user->profile)
                                <hr class="my-2">
                                @if (request()->url() != url('search'))
                                <li><a href="{{ url('search') }}">Search Jobs</a></li>
                                @else
                                <li><a href="{{ url('/') }}">Front Page</a></li>
                                @endif
                                @endif
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </a>

                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            @endif
        </div>

        <!-- Mobile Header -->
</header>

<script>
    function saveUrl() {
        <?php
        Illuminate\Support\Facades\Session::put('previousUrl', url()->current());
        ?>
    }
</script>