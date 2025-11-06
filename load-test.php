<?php

/**
 * SNSU Student Form Load Testing Script
 * 
 * This script simulates multiple students submitting the form simultaneously
 * Run: php load-test.php
 */

// Configuration
$baseUrl = 'http://localhost:8000';
$totalRequests = 100;  // Total number of form submissions to test
$concurrentRequests = 10;  // Number of simultaneous submissions
$delay = 100000;  // Delay between batches in microseconds (100ms)

// Test data templates
$courses = ['BSIT', 'BSCS', 'BSIS', 'BSEd', 'BSBA', 'BSCrim', 'BSNursing'];
$yearLevels = ['1st Year', '2nd Year', '3rd Year', '4th Year', 'Others'];
$genders = ['Male', 'Female'];
$cities = ['Surigao City', 'Dapa', 'Del Carmen', 'Socorro', 'Burgos'];
$provinces = ['Surigao del Norte', 'Surigao del Sur'];

// Statistics
$stats = [
    'total' => 0,
    'success' => 0,
    'failed' => 0,
    'totalTime' => 0,
    'minTime' => PHP_FLOAT_MAX,
    'maxTime' => 0,
    'times' => [],
];

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║       SNSU Student Form - Load Testing Script            ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n";
echo "\n";
echo "Configuration:\n";
echo "  - Base URL: $baseUrl\n";
echo "  - Total Requests: $totalRequests\n";
echo "  - Concurrent Requests: $concurrentRequests\n";
echo "  - Delay between batches: " . ($delay/1000) . "ms\n";
echo "\n";

// Get CSRF token from the homepage
function getCsrfToken($baseUrl) {
    $html = file_get_contents($baseUrl);
    if (preg_match('/<meta name="csrf-token" content="(.+?)"/', $html, $matches)) {
        return $matches[1];
    }
    return null;
}

echo "Fetching CSRF token... ";
$csrfToken = getCsrfToken($baseUrl);
if (!$csrfToken) {
    die("❌ Failed to get CSRF token\n");
}
echo "✅ Got token\n\n";

// Generate random student data
function generateStudentData($i) {
    global $courses, $yearLevels, $genders, $cities, $provinces;
    
    return [
        'first_name' => 'LoadTest' . $i,
        'middle_name' => 'Test',
        'last_name' => 'Student' . $i,
        'student_id' => 'TEST' . str_pad($i, 6, '0', STR_PAD_LEFT),
        'course' => $courses[array_rand($courses)],
        'year_level' => $yearLevels[array_rand($yearLevels)],
        'gender' => $genders[array_rand($genders)],
        'birth_date' => '2000-01-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
        'marital_status' => 'Single',
        'religion' => 'Roman Catholic',
        'cellphone_number' => '09' . str_pad(rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
        'address' => rand(1, 100) . ' Test Street',
        'barangay' => 'Test Barangay ' . rand(1, 50),
        'city' => $cities[array_rand($cities)],
        'province' => $provinces[array_rand($provinces)],
        'postal_code' => str_pad(rand(8400, 8499), 4, '0', STR_PAD_LEFT),
        'study_device' => ['Laptop', 'Tablet', 'Desktop', 'Mobile Phone'][rand(0, 3)],
        'is_solo_parent' => false,
        'solo_parent_id' => '',
        'has_part_time_job' => (bool)rand(0, 1),
        'daily_fare' => rand(50, 200),
        'monthly_rental' => rand(1000, 5000),
        'family_income_bracket' => ['Below ₱10,000', '₱10,000 - ₱30,000', '₱30,000 - ₱50,000', 'Above ₱50,000'][rand(0, 3)],
        'household_size' => rand(3, 8),
        'parents_education' => ['Elementary', 'High School', 'College', 'Post Graduate'][rand(0, 3)],
        'transportation_mode' => ['Walking', 'Public Transport', 'Private Vehicle', 'School Bus'][rand(0, 3)],
        'travel_time_minutes' => rand(15, 120),
        'ethnicity' => ['Indigenous', 'Non-Indigenous'][rand(0, 1)],
        'pwd' => (bool)rand(0, 10) === 0, // 10% chance of PWD
        'housing_status' => ['Owned', 'Renting', 'Living with Relatives', 'Other'][rand(0, 3)],
        'family_income' => rand(10000, 100000),
    ];
}

// Submit student form
function submitStudentForm($baseUrl, $csrfToken, $data) {
    $ch = curl_init("$baseUrl/student");
    
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => [
            'X-CSRF-TOKEN: ' . $csrfToken,
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
        ],
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT => 30,
    ]);
    
    $startTime = microtime(true);
    $response = curl_exec($ch);
    $endTime = microtime(true);
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    return [
        'success' => in_array($httpCode, [200, 201, 302]),
        'httpCode' => $httpCode,
        'time' => ($endTime - $startTime) * 1000, // Convert to milliseconds
        'error' => $error,
    ];
}

// Progress bar
function showProgress($current, $total) {
    $percent = ($current / $total) * 100;
    $barLength = (int)($percent / 2);
    $barLength = max(0, min(50, $barLength)); // Ensure between 0 and 50
    $bar = str_repeat('█', $barLength);
    $space = str_repeat('░', 50 - $barLength);
    echo sprintf("\rProgress: [%s%s] %d%% (%d/%d)", $bar, $space, (int)$percent, $current, $total);
}

echo "Starting load test...\n\n";
$startTestTime = microtime(true);

// Run tests in batches
for ($i = 0; $i < $totalRequests; $i += $concurrentRequests) {
    $batchSize = min($concurrentRequests, $totalRequests - $i);
    $batchStartTime = microtime(true);
    
    // Simulate concurrent requests using multi-curl
    $multiHandle = curl_multi_init();
    $curlHandles = [];
    $batchData = [];
    
    for ($j = 0; $j < $batchSize; $j++) {
        $index = $i + $j;
        $data = generateStudentData($index);
        $batchData[$j] = $data;
        
        $ch = curl_init("$baseUrl/student");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                'X-CSRF-TOKEN: ' . $csrfToken,
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
            ],
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_TIMEOUT => 30,
        ]);
        
        curl_multi_add_handle($multiHandle, $ch);
        $curlHandles[$j] = $ch;
    }
    
    // Execute all requests
    $running = null;
    do {
        curl_multi_exec($multiHandle, $running);
        curl_multi_select($multiHandle);
    } while ($running > 0);
    
    // Collect results
    foreach ($curlHandles as $j => $ch) {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        $stats['total']++;
        
        if (in_array($httpCode, [200, 201, 302])) {
            $stats['success']++;
        } else {
            $stats['failed']++;
        }
        
        curl_multi_remove_handle($multiHandle, $ch);
        curl_close($ch);
    }
    
    curl_multi_close($multiHandle);
    
    $batchTime = (microtime(true) - $batchStartTime) * 1000;
    $stats['times'][] = $batchTime;
    $stats['totalTime'] += $batchTime;
    $stats['minTime'] = min($stats['minTime'], $batchTime);
    $stats['maxTime'] = max($stats['maxTime'], $batchTime);
    
    showProgress($i + $batchSize, $totalRequests);
    
    // Small delay between batches to avoid overwhelming the server
    usleep($delay);
}

$totalTestTime = microtime(true) - $startTestTime;

// Calculate statistics
$avgTime = $stats['totalTime'] / count($stats['times']);
sort($stats['times']);
$medianTime = $stats['times'][count($stats['times']) / 2];
$p95Index = (int)(count($stats['times']) * 0.95);
$p95Time = $stats['times'][$p95Index];

// Display results
echo "\n\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║                    TEST RESULTS                           ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n";
echo "\n";
echo "Summary:\n";
echo "  Total Requests:     {$stats['total']}\n";
echo "  Successful:         {$stats['success']} (" . number_format(($stats['success'] / $stats['total']) * 100, 2) . "%)\n";
echo "  Failed:             {$stats['failed']} (" . number_format(($stats['failed'] / $stats['total']) * 100, 2) . "%)\n";
echo "\n";
echo "Performance:\n";
echo "  Total Test Time:    " . number_format($totalTestTime, 2) . " seconds\n";
echo "  Requests/Second:    " . number_format($stats['total'] / $totalTestTime, 2) . "\n";
echo "  Avg Response Time:  " . number_format($avgTime, 2) . " ms\n";
echo "  Median Response:    " . number_format($medianTime, 2) . " ms\n";
echo "  95th Percentile:    " . number_format($p95Time, 2) . " ms\n";
echo "  Min Response:       " . number_format($stats['minTime'], 2) . " ms\n";
echo "  Max Response:       " . number_format($stats['maxTime'], 2) . " ms\n";
echo "\n";

// Performance evaluation
echo "Evaluation:\n";
if ($avgTime < 200) {
    echo "  ✅ EXCELLENT: Average response time is very fast\n";
} elseif ($avgTime < 500) {
    echo "  ✅ GOOD: Average response time is acceptable\n";
} elseif ($avgTime < 1000) {
    echo "  ⚠️  FAIR: Response time could be improved\n";
} else {
    echo "  ❌ SLOW: Response time needs optimization\n";
}

if ($stats['success'] / $stats['total'] > 0.99) {
    echo "  ✅ EXCELLENT: Very high success rate\n";
} elseif ($stats['success'] / $stats['total'] > 0.95) {
    echo "  ✅ GOOD: Good success rate\n";
} else {
    echo "  ❌ PROBLEM: Success rate is too low\n";
}

echo "\n";
echo "Recommendation:\n";
if ($avgTime < 500 && $stats['success'] / $stats['total'] > 0.99) {
    echo "  ✅ System is performing well and ready for deployment!\n";
} elseif ($avgTime < 1000 && $stats['success'] / $stats['total'] > 0.95) {
    echo "  ⚠️  System is acceptable but could benefit from optimization.\n";
} else {
    echo "  ❌ System needs optimization before deployment.\n";
    echo "     - Consider adding database indexes\n";
    echo "     - Enable query caching\n";
    echo "     - Optimize validation logic\n";
    echo "     - Check server resources\n";
}

echo "\n";
echo "Note: Test data created with prefix 'TEST' can be cleaned up.\n";
echo "To clean test data, run:\n";
echo "  php artisan tinker\n";
echo "  Student::where('student_id', 'like', 'TEST%')->forceDelete();\n";
echo "\n";

