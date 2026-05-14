<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        /* Enhancing Filter Section */
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            justify-content: space-between;
        }

        form label {
            font-weight: 600;
            color: #393b3c;
        }

        form select,
        form input {
            padding: 0.6rem;
            border: 1px solid #bfa292;
            border-radius: 6px;
            font-size: 1rem;
        }

        button[type="submit"],
        button {
            padding: 0.8rem 1.5rem;
            background: #393b3c;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #2c2c2c;
        }

        .report-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .filter-section {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            justify-content: flex-start;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .report-layout {
            display: flex;
            gap: 2rem;
        }

        .report-table-section {
            margin-top: 2rem;
        }

        .chart-container {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            align-items: center;
            width: 100%;
            max-width: 900px; /* Adjust max width */
            margin: auto; /* Center charts */
            flex-wrap: wrap; /* Ensure responsiveness */
        }

        .chart-box {
            flex: 1;
            text-align: center;
        }

        .chart-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 800px;
            margin: 2rem auto;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th, .report-table td {
            padding: 0.8rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .report-table th {
            background: #393b3c;
            color: #fff;
        }

        .report-table tr:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .download-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .download-btn {
            padding: 0.6rem 1rem;
            background: #393b3c;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .download-btn:hover {
            background: #2c2c2c;
        }

        /* Chart Styling */
        canvas {
            width: 100% !important;
            max-width: 380px; /* Slightly smaller but visible */
            height: 250px !important; /* Prevent excessive shrinking */
            border-radius: 8px;
            background: #f5f5f5;
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
        <div class="content-header">Inquiry Report</div>
        <div class="content-box">
            <div class="report-container">
                <!-- Filtering Section -->
                <div class="filter-section">
                    <form method="GET" action="{{ route('GenerateReport.mcmcGenerateInquiryReport') }}">
                        <label>Category:</label>
                        <select name="category">
                            <option value="">All</option>
                            <option value="Verified Inquiry">Verified Inquiry</option>
                            <option value="Dismissed Inquiry">Dismissed Inquiry</option>
                        </select>

                        <label>Start Date:</label>
                        <input type="date" name="start_date">

                        <label>End Date:</label>
                        <input type="date" name="end_date">

                        <button type="submit">Filter</button>
                    </form>
                </div>

                <!-- Charts Section: Bar and Pie Chart Side by Side -->
                <div class="chart-container">
                    <div class="chart-box">
                        <h3>Inquiries by Category</h3>
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="chart-box">
                        <h3>Verified vs. Dismissed Inquiries</h3>
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>

                <!-- Inquiry Report Table -->
                <div class="report-table-section">
                    @if($inquiries->isEmpty())
                        <p>No inquiries found for the selected filters.</p>
                    @endif
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquiries as $inquiry)
                                <tr>
                                    <td>{{ $inquiry->submissionDate }}</td>
                                    <td>{{ $inquiry->submissionTitle }}</td>
                                    <td>{{ $inquiry->submissionCategory }}</td>
                                    <td>{{ $inquiry->submissionStatus }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Download Buttons -->
                    <div class="download-buttons">
                        <button id="downloadPDF">Download PDF</button>
                        <button id="downloadExcel">Download Excel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctxBar = document.getElementById("barChart").getContext("2d");
            var ctxPie = document.getElementById("pieChart").getContext("2d");

            fetch("{{ route('GenerateReport.chartData') }}")
                .then(response => response.json())
                .then(data => {
                    console.log("Chart Data:", data); // Debugging: Check fetched data

                    // Bar Chart: Display Submission Categories
                    new Chart(ctxBar, {
                        type: "bar",
                        data: {
                            labels: data.categories, // Fetch category names dynamically
                            datasets: [{
                                label: "Total Inquiries by Category",
                                data: data.categoryCounts, // Inquiry count per category
                                backgroundColor: ["#f4b400", "#34a853", "#ea4335", "#4285f4", "#ff6f61"],
                            }]
                        },
                    });

                    // Pie Chart: Display Submission Category Distribution
                    new Chart(ctxPie, {
                        type: "pie",
                        data: {
                            labels: data.categories, // Dynamic labels for submission categories
                            datasets: [{
                                data: data.categoryCounts, // Inquiry count per category
                                backgroundColor: ["#34a853", "#ea4335", "#f4b400", "#4285f4", "#ff6f61"],
                            }]
                        },
                    });
                })
                .catch(error => console.error("Error loading chart:", error));
        });

        document.getElementById("downloadPDF").addEventListener("click", function() {
            window.location.href = "{{ route('GenerateReport.exportPDFInquiry') }}";
        });

        document.getElementById("downloadExcel").addEventListener("click", function() {
            window.location.href = "{{ route('GenerateReport.exportExcel') }}";
        });
    </script>

</body>
</html>