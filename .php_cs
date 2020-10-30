<?php

//list of fixers: https://github.com/FriendsOfPHP/PHP-CS-Fixer

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'array_indentation' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'phpdoc_align' => false,
        'return_type_declaration' => [
            'space_before' => 'none',
        ],
        'phpdoc_no_empty_return' => false,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'yoda_style' => false,
        'no_empty_phpdoc' => true,
        'native_function_invocation' => true,
        'fully_qualified_strict_types' => true,
        'single_blank_line_before_namespace' => true,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'static'],
        'visibility_required' => true,
        'blank_line_before_statement' => [
            'statements' => [
            'break',
            'continue',
            'die',
            'do',
            'exit',
            'goto',
            'if',
            'switch',
            'throw',
            'try',
            'yield',
            'declare',
            'return',
            'foreach',
            ]
        ],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
    ])
    ->setFinder($finder);
