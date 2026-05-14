<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incoming Inquiry - Agency</title>
    <style>
        :root {
            --primary: #7d0606;
            --accent: #00396b;
            --danger: #960000;
            --danger-hover: #c0392b;
            --success: #216ba3;
            --bg: #f8f4ee;
            --border: #bfa292;
            --white: #fff;
            --shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        body {
            margin: 0;
            padding: 0;
            background: var(--bg);
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #2c2c2c;
            min-height: 100vh;
        }
        .header {
            width: 100%;
            height: 72px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
            padding: 0 2rem;
            box-sizing: border-box;
        }
        .header-title {
            display: flex;
            align-items: center;
            color: var(--white);
            font-size: 2rem;
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
            color: var(--white);
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
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255,255,255,0.3);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .avatar img { width: 40px; height: 40px; }
        .avatar:hover { transform: scale(1.05); border-color: rgba(255,255,255,0.6); }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: var(--primary);
            color: var(--white);
            position: fixed;
            top: 72px;
            left: 0;
            bottom: 0;
            box-sizing: border-box;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: stretch;
            min-height: calc(100vh - 72px);
            padding: 1.5rem 0;
            z-index: 99;
        }
        .sidebartitle {
            color: var(--white);
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
            color: var(--white);
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
            background-color: #a92424;
            color: #fff;
            font-weight: 700;
        }
        /* Main Content */
        .main-content {
            margin-left: 220px;
            padding: 6.5rem 2rem 2rem;
            background: var(--bg);
            min-height: 100vh;
            box-sizing: border-box;
        }
        .content-header {
            font-size: 1.7rem;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 2rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .content-header::before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 32px;
            background: var(--primary);
            border-radius: 3px;
        }
        .content-box {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            width: 100%;
            max-width: 1000px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            padding: 2.2rem 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }
        .inquiry-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }
        .info-section {
            margin-bottom: 2rem;
        }
        .info-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 0.8rem;
            gap: 0.5rem;
        }
        .info-label {
            font-weight: bold;
            min-width: 160px;
            color: #333;
        }
        .info-value {
            flex: 1;
        }
        .admin-comment-section {
            background: #fff7eb;
            border: 1px solid #e6c9a8;
            border-radius: 8px;
            padding: 1rem 1.2rem;
            margin-bottom: 2rem;
        }
        .admin-comment-label {
            font-weight: 600;
            color: #7d0606;
            margin-bottom: 0.5rem;
            display: block;
        }
        .admin-comment-content {
            color: #3c3c3c;
            font-size: 1.05rem;
            margin-bottom: 0.2rem;
        }
        .jurisdiction-section {
            margin: 2.5rem 0 2rem 0;
        }
        .jurisdiction-title {
            font-size: 1.15rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .form-field {
            margin-bottom: 1.2rem;
        }
        textarea {
            width: 100%;
            padding: 0.5rem;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
            resize: vertical;
        }
        .submit-btn, .accept-btn {
            padding: 0.6rem 1.5rem;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
        }
        .submit-btn {
            background: var(--danger);
            color: white;
            margin-right: 0.9rem;
        }
        .submit-btn:hover { background: var(--danger-hover); }
        .accept-btn {
            background: var(--accent);
            color: white;
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
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Coat_of_arms_of_Malaysia.svg" alt="avatar">
            </div>
        </div>
    </header>
    <nav class="sidebar" aria-label="Agency sidebar">
        <div class="sidebartitle">Agency</div>
        <ul class="menuitems">
            <li><a href="{{ route('Dashboard.agencyDashboard') }}" class="menuitem">Home</a></li>
            <li><a href="{{ route('InquirySubmission.agencyPreviousInquiry') }}" class="menuitem">List of Inquiry</a></li>
            <li><a href="{{ route('InquiryAssignment.agencyIncomingInquiry') }}" class="menuitem active">Incoming Inquiry</a></li>
            <li><a href="{{ route('InquiryProgress.agencyAssignedInquiry') }}" class="menuitem">Assigned Inquiry</a></li>
        </ul>
    </nav>
    <main class="main-content">
        <div class="content-header">Incoming Inquiry</div>
        <div class="content-box">
            <div class="info-section">
                <div class="inquiry-title">{{ $inquiry->submissionTitle }}</div>
                <div class="info-row">
                    <span class="info-label">Submission Date:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($inquiry->submissionDate)->format('Y-m-d') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">{{ $inquiry->submissionStatus }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Category:</span>
                    <span class="info-value">{{ $inquiry->submissionCategory }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Description:</span>
                    <span class="info-value">{{ $inquiry->submissionDescription }}</span>
                </div>
                @if($inquiry->submissionEvidence)
                <div class="info-row">
                    <span class="info-label">Evidence:</span>
                    <span class="info-value">
                        <a href="{{ Storage::url('uploads/' . $inquiry->submissionEvidence) }}" target="_blank">View File</a>
                    </span>
                </div>
                @endif
                @if($inquiry->sourceOfNews)
                <div class="info-row">
                    <span class="info-label">Source of News:</span>
                    <span class="info-value">
                        <a href="{{ $inquiry->sourceOfNews }}" target="_blank">{{ $inquiry->sourceOfNews }}</a>
                    </span>
                </div>
                @endif
            </div>

            @if(!empty($assignment->comment))
            <div class="admin-comment-section">
                <span class="admin-comment-label">MCMC Admin Comment:</span>
                <div class="admin-comment-content">{{ $assignment->comment }}</div>
            </div>
            @endif

            <div class="jurisdiction-section">
                <div class="jurisdiction-title">Jurisdiction Review</div>

                <form action="{{ route('InquiryAssignment.agencyRejectInquiry', ['assignmentID' => $assignment->assignmentID]) }}" method="POST" class="reject-form" style="margin-bottom:1.8rem;">
                    @csrf
                    <div class="form-field">
                        <label for="rejection_comment" class="info-label">Rejection Comment <span style="color:#960000;">*</span>:</label>
                        <textarea name="rejection_comment" id="rejection_comment" rows="3" required>{{ old('rejection_comment') }}</textarea>
                    </div>
                    <button type="submit" class="submit-btn">Reject & Notify MCMC</button>
                </form>

                <form method="POST" action="{{ route('InquiryAssignment.agencyAcceptInquiry', ['assignmentID' => $assignment->assignmentID]) }}">
                    @csrf
                    <div class="form-field">
                        <label for="accept_comment" class="info-label">Accept Comment (optional):</label>
                        <textarea name="accept_comment" id="accept_comment" rows="3">{{ old('accept_comment') }}</textarea>
                    </div>
                    <button type="submit" class="accept-btn">Accept & Proceed Verification</button>
                </form>
                <br>
                <a href="{{ route('InquiryAssignment.agencyIncomingInquiry') }}" class="back-btn" style="display:inline-block;margin-bottom:1.2rem;padding:0.2rem 1rem;font-size:0.96rem;border-radius:4px;background:#fff6f6;border:1px solid #e1a1a1;color:#7d0606;text-decoration:none;transition:background 0.2s;">&#8592; Back</a>
            </div>
        </div>
    </main>
</body>
</html>