<!DOCTYPE html>
<html>
<head>
    <title>Inquiry Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 6px;
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <h2>Inquiry Report</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $inquiry)
                <tr>
                    <td>{{ $inquiry->submissionDate }}</td>
                    <td>{{ $inquiry->submissionTitle }}</td>
                    <td>{{ $inquiry->submissionCategory }}</td>
                    <td>{{ $inquiry->submissionStatus }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>