<div class="sidebar bg-white p-2 h-100 d-none d-sm-inline" style="width: 300px;">
    <div class="mt-2"></div>
    <ul class="nav flex-column">
        <li class="nav-item py-1">
            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'home') ? 'bg-light' : ''}} rounded" href="{{ route('home') }}">
                <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'home') ? 'bi-house-fill' : 'bi-house' }} fs-5 p-2"></i>
                Home
            </a>
        </li>

        @if(Auth::check() && Auth::user()->role == 1)
            <li class="nav-item py-1">
                <a class="nav-link rounded {{ Str::startsWith(Route::currentRouteName(), 'users') ? 'bg-light' : ''}}" href="{{ route('users') }}">         
                    <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'users') ? 'bi-people-fill' : 'bi-people' }} fs-5 p-2"></i> 
                    Users
                </a>
            </li>
        
            <li class="nav-item py-1">
                <a class="nav-link rounded {{ Str::startsWith(Route::currentRouteName(), 'response_records') ? 'bg-light' : ''}}" href="{{ route('response_records.index') }}">         
                    <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'response_records') ? 'bi-credit-card-2-front-fill' : 'bi-credit-card-2-front' }} fs-5 p-2"></i>
                    Response Records
                </a>
            </li>
        @endif

        @if(Auth::check() && in_array(Auth::user()->role, [1, 2]))
            <li class="nav-item py-1">
                <a class="nav-link rounded {{ Str::startsWith(Route::currentRouteName(), 'incident_report') || Str::startsWith(Route::currentRouteName(), 'incident_report') ? 'bg-light' : '' }}" href="{{ route('incident_report.show_all') }}">         
                    <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'incident_report') ? 'bi bi-file-text-fill' : 'bi bi-file-text' }} fs-5 p-2"></i>
                    Incident Reports
                </a>
            </li>
            <li class="nav-item py-1">
                <a class="nav-link rounded {{ Str::startsWith(Route::currentRouteName(), 'patient_care') ? 'bg-light' : '' }}" href="{{ route('patient_care.index') }}">         
                    <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'patient_care') ? 'bi-clipboard2-pulse-fill' : 'bi-clipboard2-pulse' }} fs-5 p-2"></i>
                    Patient Care Reports
                </a>
            </li>
            
            <li class="nav-item py-1">
                <a class="nav-link rounded {{ Str::startsWith(Route::currentRouteName(), 'hazard_map') || Str::startsWith(Route::currentRouteName(), 'shelter') ? 'bg-light' : '' }}" href="{{ route('hazard_map.index') }}">         
                    <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'hazard_map') || Str::startsWith(Route::currentRouteName(), 'shelter') ? 'bi-pin-map-fill' : 'bi-pin-map' }} fs-5 p-2"></i>
                    Hazard Map
                </a>
            </li>
        @endif

        @if(Auth::check() && in_array(Auth::user()->role, [3]))
            <li class="nav-item py-1">
                <a class="nav-link rounded {{ Str::startsWith(Route::currentRouteName(), 'family.assistance') || Str::startsWith(Route::currentRouteName(), 'family.assistance') ? 'bg-light' : '' }}" href="{{ route('family.assistance.records') }}">         
                    <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'family.assistance') ? 'bi bi-person-fill' : 'bi bi-person' }} fs-5 p-2"></i>
                    Family Assistance
                </a>
            </li>
            <li class="nav-item py-1">
                <a class="nav-link rounded {{ Str::startsWith(Route::currentRouteName(), 'donations') || Str::startsWith(Route::currentRouteName(), 'donations') ? 'bg-light' : '' }}" href="{{ route('donations') }}">         
                    <i class="bi {{ Route::currentRouteName() == 'donations' ? 'bi-clipboard2-fill' : 'bi-clipboard2' }} fs-5 p-2"></i>
                    Manage Donations
                </a>
            </li>
        @endif
        
        <li class="nav-item py-1">
            <a class="nav-link text-danger" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">         
                <i class="bi bi-door-closed fs-5 p-2"></i> 
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>        
        </li>
    </ul>
</div>