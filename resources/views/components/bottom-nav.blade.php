<nav class="bottom-nav d-sm-none border text-primary bg-white">
    <div class="d-flex justify-content-around p-2">
        <a class="nav-link p-2 {{ Str::startsWith(Route::currentRouteName(), 'home') ? 'bg-light' : ''}} rounded" href="{{ route('home') }}">
            <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'home') ? 'bi-house-fill' : 'bi-house' }} fs-5 p-2"></i>
        </a>
        @if(Auth::check() && Auth::user()->role == 1)
            <a class="nav-link p-2 rounded {{ Str::startsWith(Route::currentRouteName(), 'users') ? 'bg-light' : ''}}" href="{{ route('users') }}">         
                <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'users') ? 'bi-people-fill' : 'bi-people' }} fs-5 p-2"></i> 
            </a>
    
            <a class="nav-link p-2 rounded {{ Str::startsWith(Route::currentRouteName(), 'response_records') ? 'bg-light' : ''}}" href="{{ route('response_records.index') }}">         
                <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'response_records') ? 'bi-credit-card-2-front-fill' : 'bi-credit-card-2-front' }} fs-5 p-2"></i>
            </a>
        @endif

        @if(Auth::check() && in_array(Auth::user()->role, [1, 2]))
            <a class="nav-link p-2 rounded {{ Str::startsWith(Route::currentRouteName(), 'incident_report') || Str::startsWith(Route::currentRouteName(), 'incident_report') ? 'bg-light' : '' }}" href="{{ route('incident_report.show_all') }}">         
                <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'incident_report') ? 'bi bi-file-text-fill' : 'bi bi-file-text' }} fs-5 p-2"></i>
            </a>
            <a class="nav-link p-2 rounded {{ Str::startsWith(Route::currentRouteName(), 'patient_care') ? 'bg-light' : '' }}" href="{{ route('patient_care.index') }}">         
                <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'patient_care') ? 'bi-clipboard2-pulse-fill' : 'bi-clipboard2-pulse' }} fs-5 p-2"></i>
            </a>
            <a class="nav-link p-2 rounded {{ Str::startsWith(Route::currentRouteName(), 'hazard_map') || Str::startsWith(Route::currentRouteName(), 'shelter') ? 'bg-light' : '' }}" href="{{ route('hazard_map.index') }}">         
                <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'hazard_map') || Str::startsWith(Route::currentRouteName(), 'shelter') ? 'bi-pin-map-fill' : 'bi-pin-map' }} fs-5 p-2"></i>
            </a>
        @endif
        
        @if(Auth::check() && in_array(Auth::user()->role, [3]))
            <a class="nav-link p-2 rounded {{ Str::startsWith(Route::currentRouteName(), 'family.assistance') || Str::startsWith(Route::currentRouteName(), 'family.assistance') ? 'bg-light' : '' }}" href="{{ route('family.assistance.records') }}">         
                <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'family.assistance') ? 'bi bi-person-fill' : 'bi bi-person' }} fs-5 p-2"></i>
            </a>
            <a class="nav-link p-2 rounded {{ Str::startsWith(Route::currentRouteName(), 'donations') || Str::startsWith(Route::currentRouteName(), 'donations') ? 'bg-light' : '' }}" href="{{ route('donations') }}">         
                <i class="bi {{ Str::startsWith(Route::currentRouteName(), 'donations') ? 'bi-clipboard2-fill' : 'bi-clipboard2' }} fs-5 p-2"></i>
            </a>
        @endif

        <div class="dropup">
            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-badge fs-5 p-2"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
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
    </div>
</nav>