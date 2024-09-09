<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-3">
    <div class="container">
        <a class="navbar-brand" href="#">
            Dev<strong>Test</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('test.home.index') ? 'active text-success bg-white rounded-top border-bottom border-success border-3' : '' }}"
                       href="{{ route('test.home.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('test.mqtt.index') ? 'active text-success bg-white rounded-top border-bottom border-success border-3' : '' }}"
                       href="{{ route('test.mqtt.index') }}">MQTT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('test.sensors.index') ? 'active text-success bg-white rounded-top border-bottom border-success border-3' : '' }}"
                       href="{{ route('test.sensors.index') }}">Sensors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('test.aerator-manage.index') ? 'active text-success bg-white rounded-top border-bottom border-success border-3' : '' }}"
                       onclick="handleNavLinkClick(event)" href="{{ route('test.aerator-manage.index') }}">Aerator Manage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('test.remove-seed.index') ? 'active text-success bg-white rounded-top border-bottom border-success border-3' : '' }}"
                       onclick="handleNavLinkClick(event)" href="{{ route('test.remove-seed.index') }}">Remove Seed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('test.mail.index') ? 'active text-success bg-white rounded-top border-bottom border-success border-3' : '' }}"
                       onclick="handleNavLinkClick(event)" href="{{ route('test.mail.index') }}">Mail</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('test.convert-switches.index') ? 'active text-success bg-white rounded-top border-bottom border-success border-3' : '' }}"
                       onclick="handleNavLinkClick(event)" href="{{ route('test.convert-switches.index') }}">Convert
                        Switches</a>
                </li>
            </ul>
            <div>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link"
                           style="cursor: alias"
                           href="{{ route('l5-swagger.default.api') }}"
                           target="_blank"
                        >
                            API Documentation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           style="cursor: alias"
                           href="{{ route('backpack.dashboard') }}"
                           target="_blank"
                        >
                            Admin
                        </a>
                    </li>
                </ul>
            </div>
            <form class="d-none">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <script>
                const handleNavLinkClick = (e) => {
                    e.preventDefault();
                    const userConfirmed = confirm("Are you sure you want to navigate to this page?");
                    if (userConfirmed) {
                        window.location.href = e.currentTarget.href;
                    }
                }
            </script>
        </div>
    </div>
</nav>
