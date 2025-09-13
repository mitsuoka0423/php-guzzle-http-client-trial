<?php

/**
 * Measures the execution time of a given process.
 *
 * @param string $label The label for the measurement.
 * @param callable $process The process to measure.
 */
function measure_execution_time(string $label, callable $process): void
{
    echo "--- " . $label . " ---" . PHP_EOL;
    $start_time = microtime(true);

    $process();

    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    echo "Execution Time: " . $execution_time . " seconds" . PHP_EOL . PHP_EOL;
}
