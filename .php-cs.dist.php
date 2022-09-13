<?php
$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'bootstrap/cache',
        'vendor',
    ])
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setRules([
        // If you want to overwrite default rules
        // add rules here.
        'declare_strict_types' => false,
//・・・
    ])
    ->setUsingCache(false)
    ->setFinder($finder);
