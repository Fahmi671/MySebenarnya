<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Inquiry List - MCMC Staff</title>
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

        .header-actions .logout-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
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
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .header-actions .avatar:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.6);
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
            background: #393b3c;
            /* changed to match image */
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
        .inquiry-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .inquiry-card {
            border: 1px solid #ddd;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            border-radius: 10px;
            background: #fefefe;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: background 0.2s;
        }
        .inquiry-card:hover {
            background: #f0f8ff;
        }
        .inquiry-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .inquiry-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #00396b;
        }
        .inquiry-meta {
            font-size: 0.98rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        .inquiry-meta {
            font-size: 0.98rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        .rejected-label {
            color: #b90000;
            background: #ffeaea;
            font-size: 1.03rem;
            font-weight: 600;
            padding: 0.23em 0.9em;
            border-radius: 6px;
            margin-left: 0.9em;
            display: inline-block;
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
            <li><a href="{{ route('InquiryAssignment.mcmcAssignInquiry') }}" class="menuitem active">Assign Agency</a></li>
            <li><a href="{{ route('InquirySubmission.mcmcPreviousInquiry') }}" class="menuitem">List of Inquiry</a></li>
            <li><a href="{{ route('GenerateReport.mcmcReportPage') }}" class="menuitem">Report</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <div class="content-header">Assign Agency</div>
        <div class="content-box">
            @if($inquiries->isNotEmpty())
                @foreach($inquiries as $inquiry)
                    <a href="{{ route('InquirySubmission.mcmcAssignInquiryDetails', ['submissionID' => $inquiry->submissionID]) }}" class="inquiry-link">
                        <div class="inquiry-card">
                            <div class="inquiry-header">
                                <div class="inquiry-title">
                                    {{ $inquiry->submissionTitle }}
                                    @php
                                        // Check if all assignments for this inquiry are rejected (for union-ed query)
                                        $hasRejected = \App\Models\SubmissionAssignment::where('submissionID', $inquiry->submissionID)->count() > 0 &&
                                            \App\Models\SubmissionAssignment::where('submissionID', $inquiry->submissionID)
                                                ->where('jurisdictionStatus', '!=', 'Rejected')->count() === 0;
                                    @endphp
                                    @if($hasRejected)
                                        <span class="rejected-label">Rejected &ndash; please assign again</span>
                                    @endif
                                </div>
                            </div>
                            <div class="inquiry-meta">
                                Date: <strong>{{ \Carbon\Carbon::parse($inquiry->submissionDate)->format('Y-m-d') }}</strong>
                                &nbsp;|&nbsp;
                                Category: <strong>{{ $inquiry->submissionCategory }}</strong>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <p>No verified inquiries available for assignment.</p>
            @endif

        </div>
    </div>
</body>
</html>