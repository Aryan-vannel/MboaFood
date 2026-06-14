<?php

namespace Config;

/**
 * Paths configuration for CI4 4.7.x
 * systemDirectory doit pointer vers vendor/codeigniter4/framework/system
 */
class Paths
{
    /**
     * The path to the "system" folder.
     */
    public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /**
     * The path to the "application" folder.
     */
    public string $appDirectory = __DIR__ . '/..';

    /**
     * The path to the "writable" folder.
     */
    public string $writableDirectory = __DIR__ . '/../../writable';

    /**
     * The path to the "tests" folder.
     */
    public string $testsDirectory = __DIR__ . '/../../tests';

    /**
     * The path to the "views" folder.
     */
    public string $viewDirectory = __DIR__ . '/../Views';
}
