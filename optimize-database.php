<?php

/**
 * SNSU - Database Optimization Script
 * Adds indexes to improve query performance
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║        SNSU - Database Optimization Script               ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n";
echo "\n";

echo "This script will add performance indexes to the students table.\n\n";

// List of indexes to create
$indexes = [
    [
        'name' => 'idx_student_id',
        'column' => 'student_id',
        'reason' => 'Speeds up searches by student ID',
    ],
    [
        'name' => 'idx_created_at',
        'column' => 'created_at',
        'reason' => 'Improves ordering by creation date',
    ],
    [
        'name' => 'idx_course',
        'column' => 'course',
        'reason' => 'Faster filtering by course',
    ],
    [
        'name' => 'idx_year_level',
        'column' => 'year_level',
        'reason' => 'Faster filtering by year level',
    ],
    [
        'name' => 'idx_city',
        'column' => 'city',
        'reason' => 'Speeds up location-based queries',
    ],
    [
        'name' => 'idx_ethnicity',
        'column' => 'ethnicity',
        'reason' => 'Faster filtering by ethnicity',
    ],
    [
        'name' => 'idx_pwd',
        'column' => 'pwd',
        'reason' => 'Quick filtering for PWD students',
    ],
    [
        'name' => 'idx_deleted_at',
        'column' => 'deleted_at',
        'reason' => 'Improves soft delete queries',
    ],
];

// Composite indexes
$compositeIndexes = [
    [
        'name' => 'idx_course_year',
        'columns' => ['course', 'year_level'],
        'reason' => 'Optimizes filtering by both course and year',
    ],
];

echo "Indexes to create:\n";
foreach ($indexes as $i => $index) {
    echo "  " . ($i + 1) . ". {$index['name']} on '{$index['column']}'\n";
    echo "     → {$index['reason']}\n";
}

foreach ($compositeIndexes as $i => $index) {
    $num = count($indexes) + $i + 1;
    echo "  $num. {$index['name']} on (" . implode(', ', $index['columns']) . ")\n";
    echo "     → {$index['reason']}\n";
}

echo "\n";

// Check if indexes already exist
function indexExists($tableName, $indexName) {
    try {
        $indexes = DB::select("SHOW INDEX FROM $tableName WHERE Key_name = ?", [$indexName]);
        return count($indexes) > 0;
    } catch (\Exception $e) {
        return false;
    }
}

// Create single-column indexes
echo "Creating indexes...\n\n";
$created = 0;
$skipped = 0;
$failed = 0;

foreach ($indexes as $index) {
    echo "  • {$index['name']}... ";
    
    if (indexExists('students', $index['name'])) {
        echo "⏭️  Already exists\n";
        $skipped++;
        continue;
    }
    
    try {
        DB::statement("ALTER TABLE students ADD INDEX {$index['name']} ({$index['column']})");
        echo "✅ Created\n";
        $created++;
    } catch (\Exception $e) {
        echo "❌ Failed: " . $e->getMessage() . "\n";
        $failed++;
    }
}

// Create composite indexes
foreach ($compositeIndexes as $index) {
    echo "  • {$index['name']}... ";
    
    if (indexExists('students', $index['name'])) {
        echo "⏭️  Already exists\n";
        $skipped++;
        continue;
    }
    
    try {
        $columns = implode(', ', $index['columns']);
        DB::statement("ALTER TABLE students ADD INDEX {$index['name']} ($columns)");
        echo "✅ Created\n";
        $created++;
    } catch (\Exception $e) {
        echo "❌ Failed: " . $e->getMessage() . "\n";
        $failed++;
    }
}

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║                       SUMMARY                             ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n";
echo "\n";
echo "  Indexes Created:  $created\n";
echo "  Already Existed:  $skipped\n";
echo "  Failed:           $failed\n";
echo "\n";

if ($created > 0) {
    echo "✅ Database optimization complete!\n";
    echo "   Your queries should now be faster.\n";
} elseif ($skipped > 0 && $failed === 0) {
    echo "✅ All indexes already exist!\n";
    echo "   Database is already optimized.\n";
} else {
    echo "⚠️  Some indexes could not be created.\n";
    echo "   Check the errors above and try manually if needed.\n";
}

echo "\n";
echo "Performance Tips:\n";
echo "  - Run 'php artisan config:cache' to cache configuration\n";
echo "  - Run 'php artisan route:cache' to cache routes\n";
echo "  - Run 'php artisan view:cache' to cache views\n";
echo "\n";

