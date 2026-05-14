<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Government Assignment Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px 40px 60px 40px;
            font-size: 12pt;
            color: #222;
        }
        .report-header {
            text-align: center;
            border-bottom: 2px solid #4a6fdc;
            padding-bottom: 12px;
            margin-bottom: 30px;
        }
        .report-header .logo {
            float: left;
            width: 70px;
            height: 70px;
            margin-right: 15px;
        }
        .report-title {
            font-size: 22pt;
            font-weight: bold;
            color: #2c3e50;
            margin: 0;
        }
        .report-meta {
            font-size: 11pt;
            color: #4a6fdc;
            margin-bottom: 5px;
        }
        .assignment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 11pt;
        }
        .assignment-table th, .assignment-table td {
            border: 1px solid #333;
            padding: 8px 10px;
        }
        .assignment-table th {
            background-color: #4a6fdc;
            color: white;
            text-align: left;
            font-weight: bold;
        }
        .assignment-table tr:nth-child(even) td {
            background: #f7f8fa;
        }
        .footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: -40px;
            height: 40px;
            text-align: right;
            font-size: 10pt;
            color: #888;
            border-top: 1px solid #ddd;
            padding: 10px 40px 0 0;
        }

    </style>
</head>
<body>
    <div class="report-header">
        <div>
            <div class="report-title">Official Report</div>
            <div class="report-meta">
                {{ \Carbon\Carbon::now()->format('F d, Y') }}
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <table class="assignment-table">
        <thead>
            <tr>
                <th>Assignment ID</th>
                <th>Agency</th>
                <th>Inquiry Title</th>
                <th>Date Assigned</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAssignments = 0; @endphp
            @foreach($assignments as $assignment)
                @php $totalAssignments++; @endphp
                <tr>
                    <td>{{ $assignment->assignmentID }}</td>
                    <td>{{ $assignment->agency->user->name ?? '-' }}</td>
                    <td>{{ $assignment->inquirySubmission->submissionTitle ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($assignment->assignmentDate)->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align:right; font-weight:bold;">Total Assignments:</td>
                <td style="font-weight:bold;">{{ $totalAssignments }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Generated on {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} &nbsp;&nbsp;|&nbsp;&nbsp; Page <span class="pagenum"></span>
    </div>
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script("if (\$PAGE_COUNT > 1) { \$font = \$fontMetrics->get_font('Arial', 'normal'); \$size = 10; \$pdf->text(500, 820, \"Page \" . \$PAGE_NUM . \" of \" . \$PAGE_COUNT, \$font, \$size); } ");
        }
    </script>
</body>
</html>