<?php

namespace App;

use InvalidArgumentException;

/**
 * Measures the execution time of a given process.
 *
 * @param string $label The label for the measurement.
 * @param callable $process The process to measure.
 */
function measure_execution_time(string $label, callable $process): void
{
    $logger = new Logger();

    $logger->log("--- " . $label . " ---");
    $start_time = microtime(true);

    $process();

    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    $logger->log("Execution Time: " . $execution_time . " seconds");
    $logger->log("");
}

/**
 * Calculates the expected execution time based on the number of trials and delay coefficient.
 *
 * @param 'sequential'|'parallel' $type The type of execution.
 * @param int $num_of_trials The number of trials.
 * @param float $delay_coefficient The delay coefficient.
 * @return float The expected execution time in seconds.
 */
function expected_execution_time(string $type, int $num_of_trials, float $delay_coefficient): float
{
    if ($type === 'parallel') {
        return $num_of_trials * $delay_coefficient;
    }
    if ($type === 'sequential') {
        $expected_time = 0;
        for ($i = 1; $i <= $num_of_trials; $i++) {
            $expected_time += $i * $delay_coefficient;
        }
        return $expected_time;
    }

    throw new InvalidArgumentException("Invalid type: $type. Expected 'sequential' or 'parallel'.");
}