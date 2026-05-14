<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public User Homepage</title>
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
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .logout-btn {
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
        .logout-btn:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.5);
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
            border: 2px solid rgba(255,255,255,0.3);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .avatar:hover {
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
        .inquiries-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        .inquiries-table th,
        .inquiries-table td {
            padding: 0.75em;
            text-align: left;
        }
        .inquiries-table thead tr {
            background: #f5f5f5;
        }
        .inquiries-table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-title">MySebenarnya</div>
        <div class="header-actions">
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">Log Out</button>
            </form>
            <div class="avatar">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Coat_of_arms_of_Malaysia.svg" alt="avatar" style="width:40px;height:40px;">
            </div>
        </div>
    </header>
    <nav class="sidebar" aria-label="Agency sidebar">
        <div class="sidebartitle">Public User</div>
        <ul class="menuitems">
            <li><a href="{{ route('InquiryProgress.publicInquiryTracking') }}" class="menuitem active">Home</a></li>
            <li><a href="{{ route('InquirySubmission.publicAddInquiry') }}" class="menuitem">Add New Inquiry</a></li>
            <li><a href="{{ route('InquirySubmission.publicViewInquiry') }}" class="menuitem">View Inquiry</a></li>
            <li><a href="{{ route('InquirySubmission.publicPublicInquiry') }}" class="menuitem">Public Inquiry</a></li>
            <li><a href="{{ route('InquiryProgress.publicHistory') }}" class="menuitem">History</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <div class="content-header">Inquiry Tracking</div>
        <div class="content-box">
            <!-- Filter/Search Form -->
            <form method="GET" action="{{ route('InquiryProgress.publicInquiryTracking') }}" style="margin-bottom:1.5rem; display:flex; gap:1rem; align-items:center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search inquiries..." style="padding:0.5em; border-radius:4px; border:1px solid #bfa292;">
                <select name="status" style="padding:0.5em; border-radius:4px; border:1px solid #bfa292;">
                    <option value="">All Statuses</option>
                    <option value="Under Investigation" {{ request('status')=='Under Investigation'?'selected':'' }}>Under Investigation</option>
                    <option value="Verified as True" {{ request('status')=='Verified as True'?'selected':'' }}>Verified as True</option>
                    <option value="Identified as Fake" {{ request('status')=='Identified as Fake'?'selected':'' }}>Identified as Fake</option>
                    <option value="Rejected" {{ request('status')=='Rejected'?'selected':'' }}>Rejected</option>
                    <option value="Accepted" {{ request('status')=='Accepted'?'selected':'' }}>Accepted</option>
                    <option value="Submitted" {{ request('status')=='Submitted'?'selected':'' }}>Submitted</option>
                </select>
                <button type="submit" style="padding:0.5em 1em; border-radius:4px; background:#00396b; color:white; border:none;">Filter</button>
            </form>
            <!-- Inquiries Table -->
            <table class="inquiries-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($inquiries as $i => $inquiry)
                    <tr>
                        <td>{{ ($inquiries->currentPage()-1)*$inquiries->perPage()+$i+1 }}</td>
                        <td>{{ $inquiry->submissionTitle }}</td>
                        <td>
                            @php
                                $status = null;
                                // 1. Use progress.verificationStatus if exists
                                if($inquiry->progress && $inquiry->progress->verificationStatus){
                                    $status = $inquiry->progress->verificationStatus;
                                }
                                // 2. Else use latestAssignment.jurisdictionStatus if exists
                                elseif($inquiry->latestAssignment && $inquiry->latestAssignment->jurisdictionStatus){
                                    $status = $inquiry->latestAssignment->jurisdictionStatus;
                                }
                                // 3. Else use submissionStatus
                                else{
                                    $status = $inquiry->submissionStatus ?? 'Not started';
                                }
                            @endphp

                            @if($status === "Under Investigation")
                                <span style="color:#007bff; font-weight:bold;">Under Investigation</span>
                            @elseif($status === "Verified as True")
                                <span style="color:green; font-weight:bold;">Verified as True</span>
                            @elseif($status === "Identified as Fake")
                                <span style="color:orange; font-weight:bold;">Identified as Fake</span>
                            @elseif($status === "Rejected")
                                <span style="color:red; font-weight:bold;">Rejected</span>
                            @elseif($status === "Accepted")
                                <span style="color:#00396b; font-weight:bold;">Accepted</span>
                            @elseif($status === "Submitted")
                                <span style="color:gray; font-weight:bold;">Submitted</span>
                            @else
                                <span style="color:gray;">{{ $status }}</span>
                            @endif
                        </td>
                        <td>
                            @if($inquiry->progress && $inquiry->progress->verificationDate)
                                {{ \Carbon\Carbon::parse($inquiry->progress->verificationDate)->format('d M Y') }}
                            @elseif($inquiry->latestAssignment && $inquiry->latestAssignment->assignmentDate)
                                {{ \Carbon\Carbon::parse($inquiry->latestAssignment->assignmentDate)->format('d M Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($inquiry->submissionDate)->format('d M Y') }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:2em;">No inquiries found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <!-- Pagination -->
            <div style="margin-top:1.5em;">
                {{ $inquiries->withQueryString()->links() }}
            </div>
        </div>
    </div>
</body>
</html>