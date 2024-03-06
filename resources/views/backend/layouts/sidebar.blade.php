<!-- Sidebar -->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <!-- HOME -->
            <li>
                <a href="{{ route('admin.dashboard.index') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <!-- HOME -->
            <!-- USER -->
            @if(Auth::user()->type == 1)
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-user"></i>
                    <span class="nav-text">User</span>
                </a>

                <ul aria-expanded="false">
                    <li><a href="{{route('admin.users.index')}}">
                            <p>All</p>
                        </a>
                    </li>
                    
                    <li><a href="{{route('admin.users.create')}}">
                            <p>Create</p>
                        </a>
                    </li>
                    <li><a href="{{route('admin.trashed.index')}}">
                            <p>Trashed</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <!-- USER -->
            <!-- New QUOTES -->
            <li>
                <a class="ai-icon" href="{{route('admin.quotes.index')}}" aria-expanded="false">
                <i class="fas fa-exclamation" style="color:#FF0000 !important;"></i>
                    <span class="nav-text">New Quotes</span>
                </a>
            </li>
            <!-- New QUOTES -->
            <!--  QUOTES -->
            <li>
                <a class="ai-icon" href="{{route('admin.quoted.index')}}" aria-expanded="false">
                <i class="fa fa-question" style="color:#E28743 !important;"></i>
                    <span class="nav-text">Quoted</span>
                </a>
            </li>
            <!--  QUOTES -->
            <!--  BOOKED -->
            <li>
                <a class="ai-icon" href="{{route('admin.booked.index')}}" aria-expanded="false">
                <i class="fas fa-check" style="color:#49be25 !important;"></i>
                    <span class="nav-text">Booked</span>
                </a>
            </li>
            <!--  BOOKED -->

             <!--  REMOVED -->
             <li>
                <a class="ai-icon" href="{{route('admin.removed.index')}}" aria-expanded="false">
                <i class="fas fa-trash-alt" style="color:#676d66 !important;"></i>
                    <span class="nav-text">Removed</span>
                </a>
            </li>
            <!--  REMOVED -->

            <!--  FORWARD -->
            <li>
                <a class="ai-icon" href="{{route('admin.forwarded.index')}}" aria-expanded="false">
                <i class="fas fa-share" style="color:#5050d0 !important;"></i>
                    <span class="nav-text">Forward</span>
                </a>
            </li>
            <!--  FORWARD -->

            <!--  VEHICLE -->
            @if(Auth::user()->type == 1)
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="fas fa-truck"></i>
                    <span class="nav-text">Vehicle</span>
                </a>

                <ul aria-expanded="false">
                    <li><a href="{{route('admin.vehicles.index')}}">
                            <p>All</p>
                        </a>
                    </li>
                    <li><a href="{{route('admin.vehicles.create')}}">
                            <p>Create</p>
                        </a>
                    </li>
                    <li><a href="{{route('admin.vehicle.trashed.index')}}">
                            <p>Trashed</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <!--  VEHICLE -->

            <!--  DOMAIN -->
            @if(Auth::user()->type == 1)
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="fas fa-globe"></i>
                    <span class="nav-text">Domain</span>
                </a>

                <ul aria-expanded="false">
                    <li><a href="{{route('admin.domains.index')}}">
                            <p>All</p>
                        </a>
                    </li>
                    <li><a href="{{route('admin.domains.create')}}">
                            <p>Create</p>
                        </a>
                    </li>
                    <li><a href="{{route('admin.domain.trashed.index')}}">
                            <p>Trashed</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <!--  DOMAIN -->
            @if(Auth::user()->type == 1)
            <!--MASTERS-->
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-settings-7"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin.settings.edit',['setting' => 1])}}">General Settings</a></li>
                        <li><a href="{{route('admin.cache.setting')}}">Cache Setting</a></li>
                      
                        
                    </ul>
                </li>
            <!--MASTERS-->
            @endif

            <!-- Profile -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-user"></i>
                    <span class="nav-text">My Account</span>
                </a>

                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.profile.index') }}">
                            <p>Profile</p>
                        </a>
                    </li>
                    <li><a href="{{route('admin.change.password')}}">
                            <p>Change Password</p>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Profile -->

            <!--LOGOUT-->
            <li>
                <a href="{{ route('admin.logout') }}" class="ai-icon"
                    onclick="event.preventDefault(); $('#sidebar-logout-form').submit();">
                    <i class="flaticon-381-exit-2"></i>
                    <span class="nav-text">Logout</span>
                </a>
                <form id="sidebar-logout-form" action="{{ route('admin.logout') }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>
            </li>
            <!--/. LOGOUT-->
        </ul>
    </div>
</div>
<!-- /.sidebar -->
