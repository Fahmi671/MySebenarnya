<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Inquiry Report - MCMC Staff</title>
    <style>
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #faf7ed;
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #2c2c2c;
        }
        /* Header */
        .header {
            width: 100%;
            height: 80px;
            background: #393b3c;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 0 2.5rem;
            box-sizing: border-box;
        }
        .header .header-title {
            display: flex;
            align-items: center;
            color: #f8f8f8;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .header .header-title::before {
            content: "";
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-right: 12px;
        }
        .header .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .header-actions .logout-btn {
            padding: 0.5rem 1rem;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 6px;
            color: #f8f8f8;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .header-actions .logout-btn:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.5);
        }
        .header-actions .logout-btn svg {
            width: 18px;
            height: 18px;
        }
        .header-actions .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255,255,255,0.3);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .header-actions .avatar:hover {
            transform: scale(1.05);
            border-color: rgba(255,255,255,0.6);
        }
        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #393b3c;
            color: white;
            position: fixed;
            top: 80px;
            left: 0;
            bottom: 0;
            box-sizing: border-box;
            border-right: 1px solid #bfa292;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            min-height: calc(100vh - 80px);
            padding: 1.5rem 0;
            z-index: 99;
        }
        .sidebartitle {
            color: #f8f8f8;
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding: 0 1.5rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            opacity: 0.85;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .menuitems {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 0;
            margin: 0;
            list-style: none;
            box-sizing: border-box;
        }
        .menuitem {
            font-size: 1.1rem;
            font-weight: 500;
            background-color: transparent;
            border-radius: 8px;
            padding: 0.85rem 1.5rem;
            color: #f8f8f8;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, font-weight 0.2s;
            display: block;
            text-decoration: none;
            border: none;
            outline: none;
            opacity: 0.95;
            width: 100%;
            box-sizing: border-box;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: left;
        }
        .menuitem:hover,
        .menuitem:focus {
            background-color: rgba(255,255,255,0.12);
            opacity: 1;
        }
        .menuitem.active {
            background-color: rgba(255,255,255,0.22);
            color: #fff;
            font-weight: 700;
        }
        .menuitem::before,
        .menuitem.active::before {
            display: none;
        }
        /* Main Content */
        .main-content {
            margin-left: 220px;
            padding: 6rem 2.5rem 2rem;
            background: #faf7ed;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s;
        }
        .content-header {
            font-size: 1.7rem;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .content-header::before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 28px;
            background: #393b3c; /* changed to match image */
            border-radius: 3px;
        }
        .content-box {
            background: #fff;
            border: 1px solid #bfa292;
            border-radius: 14px;
            width: 100%;
            min-height: 300px;
            max-width: 1200px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }


    </style>
</head>
<body>
    <header class="header">
        <div class="header-title">MySebenarnya</div>
        <div class="header-actions">
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"></path>
                    </svg>
                    Log Out
                </button>
            </form>
            <div class="avatar" tabindex="0">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Coat_of_arms_of_Malaysia.svg" alt="avatar" style="width:40px;height:40px;">
            </div>
        </div>
    </header>
    <nav class="sidebar" aria-label="Agency sidebar">
        <div class="sidebartitle">MCMC Staff</div>
        <ul class="menuitems">
            <li><a href="{{ route('Dashboard.mcmcDashboard') }}" class="menuitem">Home</a></li>
            <li><a href="{{ route('InquirySubmission.mcmcNewInquiry') }}" class="menuitem">New Inquiry</a></li>
            <li><a href="{{ route('InquiryAssignment.mcmcAssignInquiry') }}" class="menuitem">Assign Agency</a></li>
            <li><a href="{{ route('InquirySubmission.mcmcPreviousInquiry') }}" class="menuitem">List of Inquiry</a></li>
            <li><a href="{{ route('GenerateReport.mcmcReportPage') }}" class="menuitem active">Report</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <div class="content-header">Agency Performance Report</div>
        <div class="content-box">
    <h2 style="margin-top:0; margin-bottom:1.5rem;">Agency Performance Report</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('ReportController.viewPerformanceReport') }}" style="display:flex; flex-wrap:wrap; gap:1.2rem; align-items:center; margin-bottom:2rem;">
        <div>
            <label for="agency_id">Agency:</label>
            <select name="agency_id" id="agency_id">
    <option value="">All</option>
    @foreach($agencies as $agency)
        <option value="{{ $agency->username }}" {{ request('agency_id') == $agency->username ? 'selected' : '' }}>
            {{ $agency->username }}
        </option>
    @endforeach
</select>
        </div>
        <div>
            <label for="category">Category:</label>
            <select name="submissionCategory" id="submissionCategory">
    <option value="">All</option>
    @foreach($categories as $category)
        <option value="{{ $category }}" {{ request('submissionCategory') == $category ? 'selected' : '' }}>
            {{ $category }}
        </option>
    @endforeach
</select>
        </div>
        <div>
            <label for="start_date">From:</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">
        </div>
        <div>
            <label for="end_date">To:</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">
        </div>
        <button type="submit" style="padding:0.45em 1.4em; background:#393b3c; color:#fff; border:none; border-radius:6px; cursor:pointer;">Filter</button>
        <a href="{{ route('ReportController.viewPerformanceReport') }}" style="color:#393b3c; text-decoration:underline; margin-left:1em;">Reset</a>
    </form>

    <!-- Export buttons -->
    <div style="margin-bottom:1.5rem;">
        <a href="{{ route('ReportController.exportPerformancePdf', request()->all()) }}" style="padding:0.45em 1.4em; background:#e74c3c; color:#fff; border-radius:6px; text-decoration:none; margin-right:0.5em;">Export PDF</a>
        <a href="{{ route('ReportController.exportPerformanceExcel', request()->all()) }}" style="padding:0.45em 1.4em; background:#27ae60; color:#fff; border-radius:6px; text-decoration:none;">Export Excel</a>
    </div>

    <!-- Performance Table -->
    <div style="overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse; background:#fff;">
        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:0.75em 1em;">Agency</th>
                <th style="padding:0.75em 1em;">Assigned</th>
                <th style="padding:0.75em 1em;">Resolved</th>
                <th style="padding:0.75em 1em;">Pending</th>
               
            </tr>
        </thead>
        <tbody>
            @forelse($performanceData ?? [] as $agency)
                <tr>
                    <td style="padding:0.7em 1em;">{{ $agency['agency_name'] }}</td>
                    <td style="padding:0.7em 1em;">{{ $agency['assigned'] }}</td>
                    <td style="padding:0.7em 1em;">{{ $agency['resolved'] }}</td>
                    <td style="padding:0.7em 1em;">{{ $agency['pending'] }}</td>
              
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:2em;">No data found for selected filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <!-- Visual Analytics (Charts) -->
    <div style="margin-top:2.5rem;">
        <canvas id="performanceChart" height="90"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(collect($performanceData ?? [])->pluck('agency_name')) !!},
                datasets: [
                    {
                        label: 'Assigned',
                        backgroundColor: '#3498db',
                        data: {!! json_encode(collect($performanceData ?? [])->pluck('assigned')) !!}
                    },
                    {
                        label: 'Resolved',
                        backgroundColor: '#27ae60',
                        data: {!! json_encode(collect($performanceData ?? [])->pluck('resolved')) !!}
                    },
                    {
                        label: 'Pending',
                        backgroundColor: '#e67e22',
                        data: {!! json_encode(collect($performanceData ?? [])->pluck('pending')) !!}
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Agency Inquiry Assignment & Resolution'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
   
</div>
</body>
</html>