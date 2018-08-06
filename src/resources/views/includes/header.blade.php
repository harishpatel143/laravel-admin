<!-- Logo -->
<a href="{{ route('home') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>L</b>A</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Laravel</b>Admin</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>    
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">            
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset(Auth::guard('administrator')->user()->avatar) ?? ''}}" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{ Auth::guard('administrator')->user()->full_name ?? ''}}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="{{ asset(Auth::guard('administrator')->user()->avatar) ?? ''}}" class="img-circle" alt="User Image">
                        <p>
                            {{ Auth::guard('administrator')->user()->full_name ?? ''}}
                            <small>Member since {{ Auth::guard('administrator')->user()->created_at ?? ''}}</small>
                        </p>
                    </li>                    
                    <!-- Menu Footer-->
                    <li class="user-footer">

                        <div class="pull-left">
                            <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                        </div>

                        <div class="pull-right">
                            <a href="{{ route('account-logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Sign out</a>
                            <form id="logout-form" action="{{ route('account-logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </li>            
        </ul>
    </div>
</nav>
