<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Agency - MCMC Staff</title>
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
        .info-row { margin-bottom: 1rem; }
        .info-label { font-weight: bold; }
        .assign-form { margin-top: 2rem; }
        .form-field { margin-bottom: 1.2rem; }
        .submit-btn {
            padding: 0.6rem 1.5rem;
            font-size: 1rem;
            background: #00396b;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
        }
        .submit-btn:hover { background: #216ba3; }
        .back-btn {
            display: inline-block;
            margin-bottom: 1.5rem;
            padding: 0.3rem 1.1rem;
            font-size: 0.97rem;
            border-radius: 4px;
            background: #f6f6f6;
            border: 1px solid #bfa292;
            color: #393b3c;
            text-decoration: none;
            transition: background 0.2s, color 0.2s, border 0.2s;
            font-weight: 500;
        }
        .back-btn:hover {
            background: #393b3c;
            color: #fff;
            border-color: #393b3c;
        }
        .details-section {
            margin-bottom: 2.2rem;
            padding-bottom: 1.2rem;
            border-bottom: 1px solid #eee;
        }
        .info-row {
            margin-bottom: 0.9rem;
            display: flex;
            flex-wrap: wrap;
        }
        .info-label {
            font-weight: bold;
            width: 180px;
            color: #393b3c;
            display: inline-block;
        }
        .info-value {
            flex: 1 1 0%;
        }
        .assign-form {
            margin-top: 1.8rem;
            max-width: 500px;
        }
        .form-field {
            margin-bottom: 1.25rem;
        }
        .suggestion-box {
            background: #f4fbff;
            border: 1px solid #b7d6f2;
            border-radius: 12px;
            padding: 1.1rem 1.2rem;
            margin-bottom: 1.5rem;
        }
        .suggestion-title {
            font-weight: 700;
            color: #173c5f;
            margin-bottom: 0.75rem;
        }
        .suggestion-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin-bottom: 0.75rem;
        }
        .suggestion-pill {
            border: 1px solid #5a92c8;
            background: #eaf4ff;
            color: #114273;
            padding: 0.55rem 0.95rem;
            border-radius: 999px;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .suggestion-pill:hover {
            background: #d5e8ff;
            transform: translateY(-1px);
        }
        select, textarea, input {
            width: 100%;
            padding: 0.45rem 0.7rem;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        textarea { min-height: 75px; }
        label { margin-bottom: 0.3rem; display: block; }
        .rejected-comment-section {
            background: #ffeaea;
            border: 1px solid #ffbdbd;
            border-radius: 8px;
            padding: 1.1rem 1.25rem;
            margin-bottom: 1.9rem;
        }
        .rejected-comment-label {
            font-weight: 600;
            color: #b90000;
            margin-bottom: 0.4rem;
            display: block;
            font-size: 1.07rem;
        }
        .rejected-comment-content {
            color: #2c2c2c;
            font-size: 1.02rem;
            font-style: italic;
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
            <!-- Back Button -->
            <a href="{{ route('InquiryAssignment.mcmcAssignInquiry') }}" class="back-btn">&larr; Back to List</a>
            
            <div class="details-section">
                <h2 style="margin-top:0;">{{ $inquiry->submissionTitle }}</h2>
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

            {{-- Show agency rejection comment if inquiry has been rejected --}}
            @php
                $rejectedAssignment = \App\Models\SubmissionAssignment::where('submissionID', $inquiry->submissionID)
                    ->where('jurisdictionStatus', 'Rejected')
                    ->latest('assignmentDate')
                    ->first();
            @endphp

            @if($rejectedAssignment)
                <div class="rejected-comment-section">
                    <span class="rejected-comment-label">Agency Rejection Comment:</span>
                    <div class="rejected-comment-content">{{ $rejectedAssignment->comment ?? '-' }}</div>
                </div>
            @endif

            @if(!empty($suggestedAgencies) && $suggestedAgencies->isNotEmpty())
                <div class="suggestion-box">
                    <div class="suggestion-title">Recommended agencies for this inquiry</div>
                    <div class="suggestion-list">
                        @foreach($suggestedAgencies as $agency)
                            <button type="button" class="suggestion-pill" data-agency-id="{{ $agency->agencyID }}">
                                {{ $agency->user->name ?? 'No User' }}
                            </button>
                        @endforeach
                    </div>
                    <div>Click a recommendation to auto-select it in the assignment dropdown.</div>
                </div>
            @endif

            <form action="{{ route('InquiryAssignment.storeAssignment', ['submissionID' => $inquiry->submissionID]) }}" method="POST" class="assign-form">
                @csrf
                <div class="form-field">
                    <label for="agencyID" class="info-label">Assign to Agency:</label>
                    <select name="agencyID" id="agencyID" required>
                        <option value="">-- Select Agency --</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->agencyID }}">
                                {{ $agency->user->name ?? 'No User' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-field">
                    <label for="comment">Staff Comment (optional):</label>
                    <textarea name="comment" id="comment" rows="3">{{ old('comment') }}</textarea>
                </div>
                <button type="submit" class="submit-btn">Assign Agency</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const agencySelect = document.getElementById('agencyID');

            document.querySelectorAll('.suggestion-pill').forEach(button => {
                button.addEventListener('click', function () {
                    const agencyId = this.dataset.agencyId;
                    if (!agencyId) {
                        return;
                    }

                    agencySelect.value = agencyId;
                    agencySelect.focus();
                });
            });
        });
    </script>
</body>
</html>