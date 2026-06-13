<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Past Inquiry - Public User</title>
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
            background: #00396b;
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
        .sidebar {
            width: 220px;
            background-color: #00396b;
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
            background: #00396b;
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
        .history-table { width: 100%; border-collapse: collapse; background: #fff; }
        .history-table th, .history-table td { padding: 0.8em 1em; text-align: left; font-size: 1.1rem; vertical-align: middle; }
        .history-table thead tr { background: #f5f5f5; }
        .history-table tbody tr:nth-child(even) { background: #f9f9f9; }
        .badge { padding: 0.22em 0.9em; border-radius: 14px; font-size: 1.05rem; font-weight: 600; display: inline-block;}
        .badge-submitted { background: #e4e4e4; color: #324; }
        .badge-accepted { background: #e3f2fd; color: #1976d2; }
        .badge-rejected { background: #f9d6d5; color: #c0392b; }
        .badge-true { background: #d4ffe7; color: #249a5a; }
        .badge-fake { background: #ffd6d6; color: #d83333; }
        .badge-investigate { background: #fff8e1; color: #f9a825; }
        .back-btn {
            padding: 0.5rem 1.4rem;
            background: #00396b;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.05rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            margin-top: 1.5em;
            display: inline-block;
            transition: background 0.2s;
            min-width: 0;
            width: auto;
            align-self: flex-start;
        }
        .back-btn:hover {
            background: #1959a6;
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
        <div class="sidebartitle">Public User</div>
        <ul class="menuitems">
            <li><a href="{{ route('InquiryProgress.publicInquiryTracking') }}" class="menuitem">Home</a></li>
            <li><a href="{{ route('InquirySubmission.publicAddInquiry') }}" class="menuitem">Add New Inquiry</a></li>
            <li><a href="{{ route('InquirySubmission.publicViewInquiry') }}" class="menuitem">View Inquiry</a></li>
            <li><a href="{{ route('InquirySubmission.publicPublicInquiry') }}" class="menuitem">Public Inquiry</a></li>
            <li><a href="{{ route('InquiryProgress.publicHistory') }}" class="menuitem active">History</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <div class="content-header">History of Inquiry</div>
        <div class="content-box">
            <h3 style="margin-top:0;">{{ $inquiry->submissionTitle }}</h3>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Status</th>
                        <th>Date/Time</th>
                        <th>By/Agency</th>
                        <th>Details</th> </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <span class="badge badge-submitted">{{ $inquiry->submissionStatus }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($inquiry->submissionDate)->format('d M Y H:i') }}</td>
                        <td>MCMC</td>
                        <td>-</td> </tr>
                    @php $row = 2; @endphp

                    @foreach($inquiry->assignments as $assignment)
                        <tr>
                            <td>{{ $row++ }}</td>
                            <td>
                                @php
                                    $jStatus = $assignment->jurisdictionStatus;
                                    $jClass = '';
                                    if($jStatus === 'Accepted') $jClass = 'badge-accepted';
                                    elseif($jStatus === 'Rejected') $jClass = 'badge-rejected';
                                    else $jClass = 'badge-investigate';
                                @endphp
                                <span class="badge {{ $jClass }}">{{ $jStatus }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($assignment->assignmentDate)->format('d M Y H:i') }}</td>
                            <td>{{ $assignment->agency->user->username ?? 'Agency' }}</td>
                            <td>{{ !empty($assignment->comment) ? $assignment->comment : '-' }}</td>
                        </tr>
                    @endforeach

                    @foreach($inquiry->assignments as $assignment)
                        @if($assignment->progress)
                        <tr>
                            <td>{{ $row++ }}</td>
                            <td>
                                @php
                                    $vStatus = $assignment->progress->verificationStatus;
                                    $vClass = '';
                                    if($vStatus === 'Verified as True') $vClass = 'badge-true';
                                    elseif($vStatus === 'Identified as Fake') $vClass = 'badge-fake';
                                    elseif($vStatus === 'Under Investigation') $vClass = 'badge-investigate';
                                    else $vClass = 'badge';
                                @endphp
                                <span class="badge {{ $vClass }}">{{ $vStatus }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($assignment->progress->verificationDate)->format('d M Y H:i') }}</td>
                            <td>{{ $assignment->agency->user->username ?? 'Agency' }}</td>
                            <td>{{ !empty($assignment->progress->investigationDetails) ? $assignment->progress->investigationDetails : '-' }}</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('InquiryProgress.publicHistory') }}" class="back-btn">&larr; Back</a>
        </div>
    </div>
</body>
</html>