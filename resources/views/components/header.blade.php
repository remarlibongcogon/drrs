<div class="m-0 p-0">
   <nav class="navbar navbar-light bg-white px-3 align-items-center shadow">
        <div class="container-fluid">
            <a class="navbar-brand text-primary d-flex align-items-center navbar-brand-responsive" href="/">
                <span>DRRS <span class="d-none d-sm-inline">: Disaster Response & Recovery System</span></span>
            </a>

            @guest
            <div class="d-flex gap-2">
                <a class="btn btn-outline-secondary " href="{{ route('request.family.assistance') }}">
                    <i class="bi bi-box2-heart-fill"></i>
                    <span class="d-none d-sm-inline">Request Relief Goods</span>
                </a>

                <a class="btn btn-danger" href="{{ route('incident_report.create') }}">
                    <i class="bi bi-shield-exclamation"></i>
                    <span class="d-none d-sm-inline">Report Incident</span>
                </a>

                <a class="btn btn-outline-primary" href="{{ route('loginPage') }}">
                    <i class="bi bi-person-circle"></i>
                    <span class="d-none d-sm-inline">Login</span>
                </a>
            </div>
            @endguest
            @auth
                <strong class="text-primary font-weight-bold">{{ Auth::user()->firstname. ' ' . Auth::user()->lastname}}</strong>
            @endauth
        </div>
   </nav>
</div>  