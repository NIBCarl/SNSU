<?php

/**
 * Simple single submission test to diagnose issues
 */

$baseUrl = 'http://localhost:8000';

echo "Testing SNSU Student Form Submission\n";
echo "=====================================\n\n";

// Test 1: Check if server is running
echo "1. Checking if server is running... ";
$ch = curl_init($baseUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "✅ Server is running\n";
} else {
    echo "❌ Server is not responding (HTTP $httpCode)\n";
    exit(1);
}

// Test 2: Get CSRF token
echo "2. Getting CSRF token... ";
if (preg_match('/<meta name="csrf-token" content="(.+?)"/', $response, $matches)) {
    $csrfToken = $matches[1];
    echo "✅ Got token: " . substr($csrfToken, 0, 20) . "...\n";
} else {
    echo "❌ Could not find CSRF token\n";
    exit(1);
}

// Test 3: Submit a test student
echo "3. Submitting test student... ";
$testData = [
    'first_name' => 'Test',
    'middle_name' => 'Single',
    'last_name' => 'Student',
    'student_id' => 'SINGLE-TEST-001',
    'course' => 'BSIT',
    'year_level' => '1st Year',
    'gender' => 'Male',
    'birth_date' => '2000-01-15',
    'marital_status' => 'Single',
    'religion' => 'Catholic',
    'cellphone_number' => '09123456789',
    'address' => '123 Test Street',
    'barangay' => 'Test Barangay',
    'city' => 'Surigao City',
    'province' => 'Surigao del Norte',
    'postal_code' => '8400',
    'study_device' => 'Laptop',
    'is_solo_parent' => false,
    'solo_parent_id' => '',
    'has_part_time_job' => false,
    'daily_fare' => 50,
    'monthly_rental' => 0,
    'family_income_bracket' => '₱10,000 - ₱30,000',
    'household_size' => 5,
    'parents_education' => 'College',
    'transportation_mode' => 'Public Transport',
    'travel_time_minutes' => 30,
    'ethnicity' => 'Non-Indigenous',
    'pwd' => false,
    'housing_status' => 'Owned',
    'family_income' => 25000,
];

$ch = curl_init("$baseUrl/student");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($testData),
    CURLOPT_HTTPHEADER => [
        'X-CSRF-TOKEN: ' . $csrfToken,
        'Accept: application/json',
        'Content-Type: application/x-www-form-urlencoded',
    ],
    CURLOPT_FOLLOWLOCATION => false,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_VERBOSE => false,
]);

$startTime = microtime(true);
$response = curl_exec($ch);
$endTime = microtime(true);
$responseTime = ($endTime - $startTime) * 1000;

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "\n";
echo "   HTTP Code: $httpCode\n";
echo "   Response Time: " . number_format($responseTime, 2) . " ms\n";

if ($error) {
    echo "   Error: $error\n";
}

if (in_array($httpCode, [200, 201, 302])) {
    echo "   ✅ SUCCESS: Form submitted successfully!\n";
} else {
    echo "   ❌ FAILED: Form submission failed\n";
    echo "   Response:\n";
    echo "   " . substr($response, 0, 500) . "\n";
}

echo "\n";
echo "Test complete!\n";

