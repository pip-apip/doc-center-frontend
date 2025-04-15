<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item {{ $title == 'Home' ? 'active' : ''  }} ">
                    <a href="{{ route('home') }}" class='sidebar-link'>
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>

                <li class="sidebar-title">Menu</li>
                {{-- @if(Auth::user()->role == 'SUPERADMIN') --}}
                <li class="sidebar-item {{ $title == 'categoryAct' || $title == 'categoryAdm' ? 'active' : ''  }} has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-list"></i>
                        <span>Category</span>
                    </a>
                    <ul class="submenu {{ $title == 'categoryAct' || $title == 'categoryAdm' ? 'active' : '' }}">
                        <li class="submenu-item {{ $title == 'categoryAdm' ? 'active' : ''  }}">
                            <a href="{{ route('categoryAdmin') }}">Administration</a>
                        </li>
                        <li class="submenu-item {{ $title == 'categoryAct' ? 'active' : ''  }}">
                            <a href="{{ route('categoryActivity') }}">Activity</a>
                        </li>
                    </ul>
                </li>
                {{-- @endif --}}

                <li class="sidebar-item {{ $title == 'Company' ? 'active' : ''  }} ">
                    <a href="{{ route('company') }}" class='sidebar-link'>
                        <i class="fa-solid fa-building"></i>
                        <span>Company</span>
                    </a>
                </li>

                <li class="sidebar-item {{ $title == 'Project' ? 'active' : ''  }} ">
                    <a href="{{ route('project') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Project</span>
                    </a>
                </li>

                <li class="sidebar-item {{ $title == 'Activity' ? 'active' : ''  }} ">
                    <a href="{{ route('activity') }}" class='sidebar-link'>
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Activity</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a class="sidebar-link" onclick="document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
