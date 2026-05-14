<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report-Assignment - MCMC Staff</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #faf7ed;
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #2c2c2c;
        }
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .logout-btn {
            padding: 0.5rem 1rem;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            color: #f8f8f8;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }
        .logout-btn svg {
            width: 18px;
            height: 18px;
        }
        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .avatar img { width: 40px; height: 40px; }
        .avatar:hover { transform: scale(1.05); border-color: rgba(255,255,255,0.6); }
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
            background-color: rgba(255, 255, 255, 0.12);
            opacity: 1;
        }
        .menuitem.active {
            background-color: rgba(255, 255, 255, 0.22);
            color: #fff;
            font-weight: 700;
        }
        .menuitem::before,
        .menuitem.active::before {
            display: none;
        }
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
            background: #393b3c;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        .filter-form {margin-bottom:1.5rem;}
        .filter-form input, .filter-form select {margin-right:1rem;padding:0.3rem;}
        .download-btn {padding:0.5rem 1rem;margin-right:0.5rem;background:#337ab7;color:white;border:none;border-radius:5px;font-weight:500;cursor:pointer;}
        .download-btn:hover {background:#29547a;}
        .chart-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-items: flex-end;
            gap: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .chart-container {
            width: 100%;
            max-width: 600px;
            min-width: 280px;
            margin: 0;
        }
        .summary-box {
            min-width: 220px;
            padding: 1.4rem 2.2rem;
            background: #eaf5fc;
            border: 1.3px solid #b7d7ed;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,100,150,0.07);
            font-size: 1.16rem;
            font-weight: 600;
            color: #125b8f;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .summary-title {
            font-size: 1.01rem;
            font-weight: 500;
            color: #005078;
            margin-bottom: 0.2em;
            text-align: center;
        }
        .summary-value {
            font-size: 2.3rem;
            color: #165b91;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 2rem;
            background: #f7fafd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,60,120,0.07);
        }
        th, td {
            padding: 1rem 1.2rem;
            text-align: left;
        }
        th {
            color: #fff;
            font-weight: 600;
            font-size: 1.08rem;
            background: #393b3c;
            border-bottom: 2px solid #dde5ef;
            letter-spacing: 0.03rem;
        }
        tr:nth-child(even) td {
            background: #f2f7fb;
        }
        tr:nth-child(odd) td {
            background: #fafcff;
        }
        td {
            color: #333;
            font-size: 1.07rem;
            border-bottom: 1px solid #e6eaf3;
        }
        tr:last-child td {
            border-bottom: none;
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
            <div class="avatar">
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
        <div class="content-header">Total Inquiry Assigned to Agency</div>
        <div class="content-box">
            <form method="GET" class="filter-form" style="display: flex; flex-wrap: wrap; align-items: flex-end; gap: 1.2rem;">
                <label>Agency:
                    <select name="agency_id">
                        <option value="">All</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->agencyID }}" {{ (isset($agencyID) && $agencyID == $agency->agencyID) ? 'selected' : '' }}>
                                {{ $agency->user->name ?? 'No User Name' }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>Start Date:
                    <input type="date" name="start_date" value="{{ $start ?? '' }}">
                </label>
                <label>End Date:
                    <input type="date" name="end_date" value="{{ $end ?? '' }}">
                </label>
                <button type="submit" class="download-btn" style="background:#4caf50;min-width:100px;font-size:0.95rem;padding:0.3rem 0.7rem;">Filter</button>
                <!-- Download buttons smaller now -->
                <div style="display:flex; flex-direction:column; gap:0.35rem; margin-left:auto;">
                    <a href="{{ route('GenerateReport.mcmcAssignmentReportPdf', request()->query()) }}"
                    class="download-btn"
                    style="min-width:90px;text-align:center;font-size:0.95rem;padding:0.3rem 0.7rem;">
                        PDF
                    </a>
                    <a href="{{ route('GenerateReport.mcmcInquiryAssignmentReportExcel', request()->query()) }}"
                    class="download-btn"
                    style="background:#ff9800;min-width:90px;text-align:center;font-size:0.95rem;padding:0.3rem 0.7rem;">
                        Excel
                    </a>
                </div>
            </form>
            <div class="chart-row">
                <div class="chart-container">
                    <canvas id="assignmentChart"></canvas>
                </div>
                <div class="summary-box">
                    <div class="summary-title">
                        @if($agencyID)
                            Total Assignments for
                            <br>
                            <strong>
                                {{ optional($agencies->firstWhere('agencyID', $agencyID))->user->name ?? '-' }}
                            </strong>
                        @elseif($start || $end)
                            Total Assignments
                            <br>
                            <span style="font-size:0.97em;color:#444;">
                                (filtered by date)
                            </span>
                        @else
                            Total Assignments (All)
                        @endif
                    </div>
                    <div class="summary-value">
                        {{ $assignments->count() }}
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Assignment ID</th>
                        <th>Agency Name</th>
                        <th>Inquiry Title</th>
                        <th>Date Assigned</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $i => $assignment)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $assignment->assignmentID }}</td>
                            <td>{{ $assignment->agency->user->name ?? '-' }}</td>
                            <td>{{ $assignment->inquirySubmission->submissionTitle ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($assignment->assignmentDate)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('assignmentChart').getContext('2d');
        const chartLabels = @json($assignmentsByAgency->map(fn($a) => $a->agency && $a->agency->user ? $a->agency->user->name : '-')->values());
        const chartData = @json($assignmentsByAgency->pluck('total')->values());
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Total Assigned Inquiries',
                    data: chartData,
                    backgroundColor: 'rgba(33, 122, 183, 0.7)',
                    borderRadius: 7,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' assignment(s)';
                            }
                        }
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
</body>
</html>