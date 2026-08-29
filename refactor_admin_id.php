<?php

$dir = __DIR__ . '/app/Http/Controllers/Admin';
$files = glob($dir . '/*.php');

$apiController = __DIR__ . '/app/Http/Controllers/Api/Customer/CustomerController.php';
$files[] = $apiController;

$valuePatterns = [
    '\$this->getAdminId\(\)',
    '\$this->getCurrentAdminId\(\)',
    '\$adminId',
    '\$admin->id',
    'Auth::guard\([\'"]admin[\'"]\)->id\(\)',
    '\$customer->admin_id'
];

$valueRegex = '(?:' . implode('|', $valuePatterns) . ')';

foreach ($files as $file) {
    $content = file_get_contents($file);
    $original = $content;

    // 1. Remove ->where('admin_id', $value)
    $content = preg_replace('/->where\(\s*[\'"]admin_id[\'"]\s*,\s*' . $valueRegex . '\s*\)/i', '', $content);
    
    // 2. Remove ::where('admin_id', $value)->
    $content = preg_replace('/::where\(\s*[\'"]admin_id[\'"]\s*,\s*' . $valueRegex . '\s*\)->/i', '::', $content);

    // 3. Remove ::where('admin_id', $value) completely and replace with ::query()
    $content = preg_replace('/::where\(\s*[\'"]admin_id[\'"]\s*,\s*' . $valueRegex . '\s*\)/i', '::query()', $content);

    // 4. Remove authorization blocks: if ($model->admin_id !== $value) { abort(403); }
    // Match block starting with if ( ... admin_id !== ... ) { ... }
    // We match the opening brace and find the corresponding closing brace.
    // We'll use a regex that handles typical simple bodies (abort, redirect, comment).
    $content = preg_replace('/if\s*\([^)]*admin_id\s*(?:!==|!=)\s*' . $valueRegex . '\s*\)\s*\{\s*(?:abort\([^;]+;(?:\s*return\s+[^;]+;)?|return\s+redirect[^;]+;)(?:\s*\/\/[^\n]+)*\s*\}/is', '', $content);
    
    if ($original !== $content) {
        file_put_contents($file, $content);
        echo "Refactored: " . basename($file) . "\n";
    }
}

echo "Done refactoring.\n";
