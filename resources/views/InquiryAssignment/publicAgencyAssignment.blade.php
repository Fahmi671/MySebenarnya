<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assigned Agency - PublicUser</title>
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
        /* Sidebar */
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
            font-size: 1.5rem;
            font-weight: 700;
            color: #00396b;
            margin-bottom: 1.7rem;
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
            border-radius: 18px;
            width: 100%;
            min-height: 220px;
            max-width: 900px;
            margin: 0 auto 2rem auto;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            padding: 2.2rem 1.5rem 2rem 1.5rem;
            box-shadow: 0 6px 20px rgba(0,60,120,0.05), 0 1.5px 4px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 1.3rem;
            background: #f7fafd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,60,120,0.07);
        }
        thead tr {
            background: #00396b;
        }
        th, td {
            padding: 1rem 1.2rem;
            text-align: left;
        }
        th {
            color: #fff;
            font-weight: 600;
            font-size: 1.08rem;
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
        .no-data {
            padding: 2.1rem 1.2rem;
            text-align: center;
            color: #888;
            font-size: 1.13rem;
            background: #f6f6f9;
            border-radius: 8px;
            margin-bottom: 1.3rem;
        }
        .btn-back {
            display: inline-block;
            margin-top: 0.7rem;
            padding: 0.45rem 1.2rem;
            background: #fff;
            color: #00396b;
            border: 1px solid #dee6f0;
            border-radius: 5px;
            font-weight: 500;
            font-size: 1.03rem;
            text-decoration: none;
            transition: background 0.17s, color 0.17s, border 0.17s;
            box-shadow: 0 1px 3px rgba(0,60,120,0.04);
        }
        .btn-back:hover {
            background: #00396b;
            color: #fff;
            border-color: #00396b;
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
            <li><a href="{{ route('InquirySubmission.publicViewInquiry') }}" class="menuitem active">View Inquiry</a></li>
            <li><a href="{{ route('InquirySubmission.publicPublicInquiry') }}" class="menuitem">Public Inquiry</a></li>
            <li><a href="{{ route('InquiryProgress.publicHistory') }}" class="menuitem">History</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <div class="content-header">Assign Agency</div>
        <div class="content-box">
            @if($assignments->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Agency Name</th>
                        <th>Assigned Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($assignments as $assignment)
                    <tr>
                        <td>
                            {{ $assignment->agency && $assignment->agency->user ? $assignment->agency->user->name : '-' }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($assignment->assignmentDate)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
                <div class="no-data">Not assigned to any agency yet.</div>
            @endif

            <a href="{{ route('InquirySubmission.publicViewInquiryDetails', ['id' => $inquiry->submissionID]) }}" class="btn-back">&larr; Back to Inquiry Details</a>
        </div>
    </div>
</body>
</html>