<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List Export</title>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #235F23;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .print-button:hover {
            background-color: #1a4a1a;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }
        
        .print-instructions {
            position: fixed;
            top: 80px;
            right: 20px;
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 8px;
            max-width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }
        
        .print-instructions h4 {
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        
        .print-instructions ol {
            margin: 0;
            padding-left: 20px;
            font-size: 12px;
        }
        
        .print-instructions li {
            margin: 5px 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #235F23;
        }
        
        .header h1 {
            color: #235F23;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 12px;
        }
        
        .export-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #235F23;
        }
        
        .export-info p {
            margin: 3px 0;
            font-size: 11px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        thead {
            background-color: #235F23;
            color: white;
        }
        
        th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 700;
            font-size: 10px;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 9px;
            vertical-align: top;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tbody tr:hover {
            background-color: #e9ecef;
        }
        
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            font-size: 9px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Student List Export</h1>
        <p>SNSU Student Information System</p>
    </div>
    
    <div class="export-info">
        <p><strong>Export Date:</strong> {{ date('F d, Y h:i A') }}</p>
        <p><strong>Total Records:</strong> {{ count($students) }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Marital Status</th>
                <th>Religion</th>
                <th>Family Income</th>
                <th>Study Device</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td>{{ $student->student_id }}</td>
                <td>{{ trim($student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name) }}</td>
                <td>{{ $student->course }}</td>
                <td>{{ $student->year_level }}</td>
                <td>{{ $student->address }}, {{ $student->barangay }}, {{ $student->city }}, {{ $student->province }}</td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->marital_status }}</td>
                <td>{{ $student->religion }}</td>
                <td>{{ $student->family_income_bracket }}</td>
                <td>{{ $student->study_device ?? 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 20px;">No students found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Generated by SNSU Student Information System | Confidential Document</p>
    </div>
    
    <!-- Print Button and Instructions (hidden when printing) -->
    <button onclick="window.print()" class="print-button no-print">
        📄 Save as PDF
    </button>
    
    <div class="print-instructions no-print">
        <h4>💡 How to Save as PDF:</h4>
        <ol>
            <li>Click the "Save as PDF" button above</li>
            <li>In the print dialog, select "Save as PDF" or "Microsoft Print to PDF"</li>
            <li>Choose where to save the file</li>
            <li>Click "Save"</li>
        </ol>
        <p style="margin-top: 10px; font-size: 11px; font-style: italic;">
            Or press <strong>Ctrl+P</strong> (Windows) / <strong>Cmd+P</strong> (Mac)
        </p>
    </div>
    
    <script>
        // Auto-trigger print dialog after page loads
        window.addEventListener('load', function() {
            // Wait a moment for content to render
            setTimeout(function() {
                // Uncomment the line below if you want automatic print dialog
                // window.print();
            }, 500);
        });
    </script>
</body>
</html>

