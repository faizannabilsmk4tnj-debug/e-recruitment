<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Application;
use App\Models\Interview;
use App\Models\JobPosting;
use Illuminate\Support\Facades\DB;

echo "=== TEST 1: Profile Threshold (75%) ===\n";
$user = App\Models\User::where('email', 'nouzenshin@gmail.com')->first();
$pct = $user->getProfileCompletionPercentage();
echo "Profile: {$pct}% => " . ($pct >= 75 ? 'PASS (can apply)' : 'BLOCKED (below 75%)') . "\n\n";

echo "=== TEST 2: Withdraw Applicant Count Sync ===\n";
// Check App #7 (applied status, can be withdrawn)
$app7 = Application::find(7);
if ($app7) {
    $job = JobPosting::find($app7->job_id);
    echo "Before withdraw - App #{$app7->id}: status={$app7->status}\n";
    echo "Job '{$job->title}' applicant_count = {$job->applicant_count}\n";
    
    // We won't actually withdraw, just confirm the logic path exists
    echo "Logic check: withdrawApplication method exists in PelamarController? ";
    $rc = new ReflectionClass(App\Http\Controllers\PelamarController::class);
    echo ($rc->hasMethod('withdrawApplication') ? 'YES' : 'NO') . "\n";
    
    // Check if decrement code is in the method
    $method = $rc->getMethod('withdrawApplication');
    $filename = $method->getFileName();
    $startLine = $method->getStartLine();
    $endLine = $method->getEndLine();
    $source = implode('', array_slice(file($filename), $startLine - 1, $endLine - $startLine + 1));
    echo "Contains decrement logic? " . (str_contains($source, 'decrement') ? 'YES' : 'NO') . "\n\n";
}

echo "=== TEST 3: CV Source Options ===\n";
// Check VacancyController submitApplication accepts cv_source
$rc2 = new ReflectionClass(App\Http\Controllers\VacancyController::class);
$method2 = $rc2->getMethod('submitApplication');
$filename2 = $method2->getFileName();
$startLine2 = $method2->getStartLine();
$endLine2 = $method2->getEndLine();
$source2 = implode('', array_slice(file($filename2), $startLine2 - 1, $endLine2 - $startLine2 + 1));
echo "submitApplication accepts cv_source? " . (str_contains($source2, 'cv_source') ? 'YES' : 'NO') . "\n";
echo "file_cv is required_if cv_source=upload? " . (str_contains($source2, 'required_if:cv_source,upload') ? 'YES' : 'NO') . "\n\n";

echo "=== TEST 4: Interview Cancel Status Recovery ===\n";
// Check InterviewController has restorePreviousApplicationStatus
$rc3 = new ReflectionClass(App\Http\Controllers\HR\InterviewController::class);
echo "restorePreviousApplicationStatus method exists? " . ($rc3->hasMethod('restorePreviousApplicationStatus') ? 'YES' : 'NO') . "\n";

// Check that destroy calls it
$method3 = $rc3->getMethod('destroy');
$filename3 = $method3->getFileName();
$startLine3 = $method3->getStartLine();
$endLine3 = $method3->getEndLine();
$source3 = implode('', array_slice(file($filename3), $startLine3 - 1, $endLine3 - $startLine3 + 1));
echo "destroy() calls restorePreviousApplicationStatus? " . (str_contains($source3, 'restorePreviousApplicationStatus') ? 'YES' : 'NO') . "\n";

// Check that updateStatus calls it on cancel
$method4 = $rc3->getMethod('updateStatus');
$filename4 = $method4->getFileName();
$startLine4 = $method4->getStartLine();
$endLine4 = $method4->getEndLine();
$source4 = implode('', array_slice(file($filename4), $startLine4 - 1, $endLine4 - $startLine4 + 1));
echo "updateStatus() calls restorePreviousApplicationStatus on cancel? " . (str_contains($source4, 'restorePreviousApplicationStatus') ? 'YES' : 'NO') . "\n";

echo "\n=== TEST 5: Review Lamaran View has CV Source Options ===\n";
$viewFile = resource_path('views/pelamar/review-lamaran.blade.php');
$viewContent = file_get_contents($viewFile);
echo "Has CV Builder Internal radio? " . (str_contains($viewContent, 'cv_source') ? 'YES' : 'NO') . "\n";
echo "Has manual-upload-container? " . (str_contains($viewContent, 'manual-upload-container') ? 'YES' : 'NO') . "\n";

echo "\n=== TEST 6: HR CV Preview supports uploaded resume ===\n";
$detailView = resource_path('views/hr/pelamar-detail.blade.php');
$detailContent = file_get_contents($detailView);
echo "Has resume_url check? " . (str_contains($detailContent, 'resume_url') ? 'YES' : 'NO') . "\n";
echo "Has Download Uploaded CV link? " . (str_contains($detailContent, 'Download Uploaded CV') ? 'YES' : 'NO') . "\n";

echo "\n=== TEST 7: PelamarController uses User model method ===\n";
$pelamarFile = file_get_contents(app_path('Http/Controllers/PelamarController.php'));
echo "Uses getProfileCompletionPercentage()? " . (str_contains($pelamarFile, 'getProfileCompletionPercentage') ? 'YES' : 'NO') . "\n";
echo "Still has old hitungPersentaseProfil method? " . (str_contains($pelamarFile, 'function hitungPersentaseProfil') ? 'YES (BAD)' : 'NO (GOOD - removed)') . "\n";

echo "\n=== ALL TESTS COMPLETE ===\n";
