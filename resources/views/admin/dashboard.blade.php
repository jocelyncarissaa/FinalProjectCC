<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PharmaPlus Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --primary: #1053D4;
            --primary-soft: #DEE9FF;
            --accent: #D64779;
            --bg-body: #F3F4F8;
            --sidebar-bg: #0F172A;
            --sidebar-active: #1F2937;
            --text-dark: #111827;
            --text-muted: #6B7280;
            --card-radius: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
            sans-serif;
            background: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Layout */
        .layout {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: var(--sidebar-bg);
            color: #E5E7EB;
            display: flex;
            flex-direction: column;
            padding: 1.25rem 1rem;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1.75rem;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: #10B981;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .brand-text {
            font-weight: 700;
            font-size: 1.05rem;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.7rem 0.5rem;
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.8);
            margin-bottom: 1.5rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            background: linear-gradient(135deg, #22C55E, #16A34A);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .profile-role {
            font-size: 0.75rem;
            color: #A5B4FC;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding-right: 0.3rem;
        }

        .menu-section-title {
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #9CA3AF;
            margin: 0.75rem 0 0.4rem;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.55rem 0.7rem;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #D1D5DB;
            cursor: pointer;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .menu-item:hover {
            background: rgba(55, 65, 81, 0.85);
        }

        .menu-item.active {
            background: #059669;
            color: white;
        }

        .menu-icon {
            width: 18px;
            text-align: center;
            font-size: 0.95rem;
        }

        .menu-badge {
            margin-left: auto;
            background: var(--accent);
            color: white;
            font-size: 0.7rem;
            padding: 0.12rem 0.4rem;
            border-radius: 999px;
        }

        .sidebar-footer {
            font-size: 0.75rem;
            color: #9CA3AF;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(55, 65, 81, 0.7);
            margin-top: 0.75rem;
        }

        /* MAIN CONTENT */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1.2rem 1.5rem 1.5rem;
            gap: 1rem;
        }

        /* Topbar */
        .topbar {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* .search-wrapper {
            flex: 1;
            max-width: 480px;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            width: 100%;
            border-radius: 999px;
            border: 1px solid #E5E7EB;
            padding: 0.6rem 1rem 0.6rem 2.3rem;
            font-size: 0.9rem;
            outline: none;
            background: white;
        }

        .search-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.9rem;
            color: #9CA3AF;
        } */

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-left: auto;
        }

        .language-switch {
            font-size: 0.85rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .language-switch span:first-child {
            font-size: 1rem;
        }

        .greeting {
            text-align: right;
            font-size: 0.8rem;
        }

        .greeting-main {
            font-weight: 600;
        }

        .greeting-sub {
            color: var(--text-muted);
            font-size: 0.78rem;
        }

        .btn {
            border-radius: 999px;
            border: 1px solid #E5E7EB;
            padding: 0.5rem 0.9rem;
            font-size: 0.82rem;
            background: white;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Heading */
        .page-header {
            margin-top: 0.25rem;
        }

        .page-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 0.1rem;
        }

        .page-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Top cards */
        .stats-grid {
            margin-top: 1rem;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .stat-card {
            border-radius: var(--card-radius);
            background: white;
            padding: 1rem 1rem 0.9rem;
            border: 1px solid #E5E7EB;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .stat-header {
            font-size: 0.78rem;
            color: var(--text-muted);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-main {
            font-size: 1rem;
            font-weight: 700;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .stat-footer {
            margin-top: 0.4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
        }

        .badge-soft {
            border-radius: 999px;
            padding: 0.25rem 0.6rem;
            font-size: 0.75rem;
        }

        .badge-success {
            background: #DCFCE7;
            color: #166534;
        }

        .card-green {
            border-top: 3px solid #10B981;
        }

        .card-yellow {
            border-top: 3px solid #FBBF24;
        }

        .card-blue {
            border-top: 3px solid var(--primary);
        }

        .card-red {
            border-top: 3px solid #F97373;
        }

        /* Bottom section */
        .bottom-grid {
            margin-top: 1rem;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .panel {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid #E5E7EB;
            padding: 1rem 1.1rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .panel-title {
            font-weight: 600;
        }

        .panel-link {
            font-size: 0.8rem;
            color: var(--primary);
            cursor: pointer;
        }

        .panel-body {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            font-size: 0.86rem;
        }

        .panel-metric-label {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .panel-metric-value {
            font-weight: 700;
            font-size: 1rem;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            border-radius: 999px;
            padding: 0.2rem 0.55rem;
            font-size: 0.75rem;
            background: var(--primary-soft);
            color: var(--primary);
        }

        /* Responsive */
        .sidebar-toggle {
            display: none;
        }

        /* Simple dropdown wrapper */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 110%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(15,23,42,0.25);
            min-width: 140px;
            font-size: 0.85rem;
            padding: 0.25rem 0;
            z-index: 40;
            display: none; /* default hidden */
        }

        .dropdown-menu a,
        .dropdown-menu button {
            width: 100%;
            padding: 0.5rem 0.9rem;
            text-align: left;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 0.85rem;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: #F3F4F6;
        }


        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .bottom-grid {
                grid-template-columns: 1fr;
            }

            .topbar-right {
                gap: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            body {
                background: white;
            }

            .sidebar {
                position: fixed;
                z-index: 20;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: inline-flex;
                border-radius: 999px;
                border: 1px solid #D1D5DB;
                padding: 0.4rem 0.65rem;
                font-size: 0.85rem;
                background: white;
                cursor: pointer;
            }

            .main {
                padding: 0.8rem 1rem 1.25rem;
            }

            .topbar {
                align-items: center;
            }

            .language-switch,
            .greeting {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

   <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('open');
        }

        function toggleProfileMenu(event) {
            event.stopPropagation();
            const menu = document.getElementById('profileMenu');
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';

            // tutup menu lain
            const reportMenu = document.getElementById('reportMenu');
            if (reportMenu) reportMenu.style.display = 'none';
        }

        function toggleReportMenu(event) {
            event.stopPropagation();
            const menu = document.getElementById('reportMenu');
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';

            // tutup menu profile
            const profileMenu = document.getElementById('profileMenu');
            if (profileMenu) profileMenu.style.display = 'none';
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function () {
            const profileMenu = document.getElementById('profileMenu');
            const reportMenu = document.getElementById('reportMenu');

            if (profileMenu) profileMenu.style.display = 'none';
            if (reportMenu) reportMenu.style.display = 'none';
        });
    </script>

</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-logo">P</div>
            <div class="brand-text">PharmaPlus</div>
        </div>

        @php
            $user = Auth::user();
        @endphp

        <div class="sidebar-profile">
            <div class="avatar">
                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
            </div>
            <div class="profile-info">
                <span class="profile-name">{{ $user->name ?? 'Unknown User' }}</span>
                <span class="profile-role">Admin</span>
            </div>

            {{-- dropdown toggle (titik tiga) --}}
            <div style="margin-left:auto; position:relative;">
                <button type="button"
                        onclick="toggleProfileMenu(event)"
                        style="background:none;border:none;color:#E5E7EB;font-size:1.1rem;cursor:pointer;">
                    ⋮
                </button>


                <div id="profileMenu"
                    style="display:none; position:absolute; right:0; top:120%; background:white; color:#111827;
                            border-radius:8px; box-shadow:0 10px 25px rgba(15,23,42,0.35); min-width:150px; font-size:0.85rem; z-index:30;">
                    <!-- <a href="{{ route('profile') }}"
                    style="display:block;padding:0.55rem 0.9rem;text-decoration:none;color:#111827;">
                        My Profile
                    </a> -->
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit"
                                style="width:100%;padding:0.55rem 0.9rem;text-align:left;border:none;background:none;
                                    cursor:pointer;color:#DC2626;">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section-title">Main</div>
           <a href="{{ route('admin.dashboard') }}"
                class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <span>Orders</span>
                @php
                    // Hitung order pending langsung di view (cara cepat)
                    $pendingCount = \App\Models\Order::where('status', 'pending')->count();
                @endphp

                @if($pendingCount > 0)
                    <span class="menu-badge" style="background: #F59E0B;">{{ $pendingCount }}</span>
                @endif
            </a>

           <a href="{{ route('admin.items.index') }}"
                class="menu-item {{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
                <span>Items</span>
            </a>


            <a href="#" class="menu-item">
                <span>Reports</span>
            </a>

            <!-- <a href="#" class="menu-item">
                <span>Configuration</span>
            </a>

            <div class="menu-section-title">Communication</div>
            <a href="#" class="menu-item">
                <span>Contact Management</span>
            </a>
            <a href="#" class="menu-item">
                <span>Notifications</span>
                <span class="menu-badge">1</span>
            </a>
            <a href="#" class="menu-item">
                <span>Chat with Visitors</span>
            </a>

            <div class="menu-section-title">System</div>
            <a href="#" class="menu-item">
                <span>Application Settings</span>
            </a>
            <a href="#" class="menu-item">
                <span>Covid-19</span>
            </a>
            <a href="#" class="menu-item">
                <span>Get Technical Help</span>
            </a> -->
        </nav>

        <div class="sidebar-footer">
            Powered by PharmaPlus © 2025<br>
            v1.0.0
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">
        <!-- Topbar -->
        <div class="topbar">
            <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

            {{-- <div class="search-wrapper">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" placeholder="Search for anything here...">
                </div>
            </div> --}}

            <div class="topbar-right">
                <div class="language-switch">
                    <span>🌐</span>
                    <span>English (US)</span>
                </div>
                @php
                    use Carbon\Carbon;
                    $now = Carbon::now('Asia/Jakarta'); // paksa Jakarta
                    $hour = $now->hour;
                    $greeting = $hour < 12 ? 'Good Morning'
                            : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
                @endphp

                <div class="greeting">
                    <div class="greeting-main">{{ $greeting }}, {{ Auth::user()->name }} </div>
                    <div class="greeting-sub">{{ $now->format('d F Y · H:i') }}</div>
                </div>

            {{-- <div class="dropdown">
                <button class="btn" onclick="toggleReportMenu(event)">
                    Download Report ▾
                </button>

                <div id="reportMenu" class="dropdown-menu">

                    <a href="#">
                        📊 <span>Excel</span>
                    </a>
                    <a href="#">
                        📄 <span>PDF</span>
                    </a>
                </div>
            </div> --}}

            </div>
        </div>

        <!-- Page header -->
        <div class="page-header">
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">A quick data overview of your pharmacy inventory.</p>
        </div>

        <!-- Top stats cards -->
        <section class="stats-grid">
            <div class="stat-card card-green">
                    <div class="stat-header">
                        <span>Inventory Status</span>
                        <span>✅</span>
                    </div>
                    <div class="stat-main">{{ $inventoryStatus }}</div>
                    <div class="stat-footer">
                        <span class="badge-soft badge-success">Up to date</span>
                        <a href="{{ route('admin.items.index') }}"
                        class="btn"
                        style="font-size:0.78rem;">
                            View Detailed Report →
                        </a>
                    </div>
            </div>


            <div class="stat-card card-yellow">
                <div class="stat-header">
                    <span>Revenue</span>
                    <span>Jan 2025 ▾</span>
                </div>
                <div class="stat-value">Rp 825.875.000</div>
                <div class="stat-footer">
                    <span class="panel-metric-label">This month</span>
                    <button class="btn" style="font-size:0.78rem;">View Detailed Report →</button>
                </div>
            </div>

            <div class="stat-card card-blue">
                <div class="stat-header">
                    <span>Medicines Available</span>
                </div>
                <div class="stat-value">{{ $totalMedicines }}</div>
                <div class="stat-footer">
                    <span class="panel-metric-label">In system</span>
                    <a href="{{ route('admin.items.index') }}"
                    class="btn"
                    style="font-size:0.78rem;">
                        Visit Inventory →
                    </a>
                </div>
            </div>

            <div class="stat-card card-red">
                <div class="stat-header">
                    <span>Medicine Shortage</span>
                </div>
                <div class="stat-value">
                    {{ $lowStock + $outOfStock }}
                </div>
                <div class="stat-footer">
                    <span class="panel-metric-label">Low / Out of stock</span>
                    <a href="{{ route('admin.items.index') }}"
                    class="btn"
                    style="font-size:0.78rem; color:#B91C1C; border-color:#FCA5A5;">
                        Resolve Now →
                    </a>
                </div>
            </div>

        </section>

        <!-- Bottom panels -->
        <section class="bottom-grid">
            <div class="panel">
    <div class="panel-header">
        <span class="panel-title">Inventory</span>
        <a href="{{ route('admin.items.index') }}" class="panel-link">
            Go to Inventory →
        </a>
            </div>
                <div class="panel-body">
                    <div>
                        <div class="panel-metric-label">Total no. of Medicines</div>
                        <div class="panel-metric-value">{{ $totalMedicines }}</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Medicine Groups</div>
                        <div class="panel-metric-value">{{ $medicineGroups }}</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Out of Stock</div>
                        <div class="panel-metric-value">{{ $outOfStock }}</div>
                    </div>
                </div>
            </div>


            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Quick Report</span>
                    <span class="chip">
                        January 2025 ▾
                    </span>
                </div>
                <div class="panel-body">
                    <div>
                        <div class="panel-metric-label">Qty of Medicines Sold</div>
                        <div class="panel-metric-value">70,856</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Invoices Generated</div>
                        <div class="panel-metric-value">5,288</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Average Order Value</div>
                        <div class="panel-metric-value">Rp 150k</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Refunds</div>
                        <div class="panel-metric-value">23</div>
                    </div>
                </div>
            </div>

            {{-- <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">My Pharmacy</span>
                    <span class="panel-link">Go to User Management →</span>
                </div>
                <div class="panel-body">
                    <div>
                        <div class="panel-metric-label">Total no. of Suppliers</div>
                        <div class="panel-metric-value">4</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Total no. of Users</div>
                        <div class="panel-metric-value">5</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Branches</div>
                        <div class="panel-metric-value">3</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Pending Approvals</div>
                        <div class="panel-metric-value">2</div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Customers</span>
                    <span class="panel-link">Go to Customers Page →</span>
                </div>
                <div class="panel-body">
                    <div>
                        <div class="panel-metric-label">Total no. of Customers</div>
                        <div class="panel-metric-value">845</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Frequently bought item</div>
                        <div class="panel-metric-value">Adalimumab</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">New Customers (this month)</div>
                        <div class="panel-metric-value">56</div>
                    </div>
                    <div>
                        <div class="panel-metric-label">Loyalty Members</div>
                        <div class="panel-metric-value">320</div>
                    </div>
                </div>
            </div> --}}
        </section>
    </main>
</div>

</body>
</html>
