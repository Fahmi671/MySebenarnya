<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MCMC Staff</title>
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        
        .contextbox {
        background: #f4f7f7;
        border-radius: 16px;
        padding: 2.5rem 2.5rem 2rem 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        max-width: 900px; 
        min-height: 350px; 
        margin-left: auto;
        margin-right: auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .contextbox-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        letter-spacing: 0.02em;
        color: #222;
        text-align: left;
    }
    .progress-row {
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
        margin-bottom: 2rem;
    }
    .progress-label {
        font-weight: 600;
        color: #393b3c;
        min-width: 160px;
        display: inline-block;
        margin-right: 10px;
    }
    .progress-value {
        font-weight: 400;
        color: #222;
    }
    .progress-badge {
        display: inline-block;
        padding: 0.45em 1.3em;
        border-radius: 18px;
        font-size: 1.05rem;
        font-weight: 600;
        vertical-align: middle;
        margin-right: 8px;
    }
    .progress-badge.verified { background: #d4ffe7; color: #249a5a; }
    .progress-badge.fake { background: #ffd6d6; color: #d83333; }
    .progress-badge.investigate { background: #fff8e1; color: #f9a825; }
    .progress-badge.rejected { background: #f9d6d5; color: #c0392b; }
    .progress-notes-label {
        font-weight: 600;
        margin-top: 10px;
        display: block;
        color: #393b3c;
    }
    .progress-notes-box {
        background: #fff;
        border-radius: 7px;
        border: 1px solid #eee;
        margin-top: 7px;
        padding: 1.15rem;
        font-size: 1.12rem;
        color: #333;
        min-height: 48px;
    }
    .contextbox hr {
        margin: 2.2rem 0 1.2rem 0;
        border: 0;
        border-top: 1px solid #ddd;
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
            <li><a href="{{ route('InquirySubmission.mcmcPreviousInquiry') }}" class="menuitem active">List of Inquiry</a></li>
            <li><a href="{{ route('GenerateReport.mcmcReportPage') }}" class="menuitem">Report</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <div class="content-header">List of Inquiry</div>
        <div class="content-box">
            <div class="contextbox">
                <div class="contextbox-title">Investigation Progress</div>
                @foreach($inquiry->assignments as $assignment)
                    <div class="progress-row">
                        <div>
                            <span class="progress-label">Agency:</span>
                            <span class="progress-value">{{ $assignment->agency->user->username ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="progress-label">Person in Charge:</span>
                            <span class="progress-value">{{ $assignment->agency->PIC ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="progress-label">Status:</span>
                            @php
                                $status = '';
                                $badge = '';
                                if($assignment->jurisdictionStatus === 'Rejected') {
                                    $status = 'Rejected';
                                    $badge = 'rejected';
                                } elseif($assignment->jurisdictionStatus === 'Accepted') {
                                    if($assignment->progress) {
                                        if($assignment->progress->verificationStatus === 'Verified as True') {
                                            $status = 'Verified as True';
                                            $badge = 'verified';
                                        } elseif($assignment->progress->verificationStatus === 'Identified as Fake') {
                                            $status = 'Identified as Fake';
                                            $badge = 'fake';
                                        } elseif($assignment->progress->verificationStatus === 'Under Investigation') {
                                            $status = 'Under Investigation';
                                            $badge = 'investigate';
                                        } else {
                                            $status = 'Under Investigation';
                                            $badge = 'investigate';
                                        }
                                    } else {
                                        $status = 'Under Investigation';
                                        $badge = 'investigate';
                                    }
                                } else {
                                    $status = 'Pending';
                                    $badge = '';
                                }
                            @endphp
                            @if($badge)
                                <span class="progress-badge {{ $badge }}">{{ $status }}</span>
                            @else
                                <span class="progress-value">{{ $status }}</span>
                            @endif
                        </div>
                        <div>
                            <span class="progress-notes-label">Progress Notes:</span>
                            <div class="progress-notes-box">
    @if(
        $assignment->progress
        && $assignment->progress->verificationStatus !== 'Under Investigation'
        && !empty($assignment->progress->investigationDetails)
    )
        {{ $assignment->progress->investigationDetails }}
    @elseif(!empty($assignment->comment))
        {{ $assignment->comment }}
    @else
        <span>-</span>
    @endif
</div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>