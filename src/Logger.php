<?php

namespace App;

class Logger
{
    public function log(string $message): void
    {
        $microtime = microtime(true);
        $datetime = new \DateTime();
        $datetime->setTimestamp(floor($microtime));
        $datetime->setTimezone(new \DateTimeZone('Asia/Tokyo'));
        $milliseconds = round(($microtime - floor($microtime)) * 1000);
        echo "[" . $datetime->format('Y-m-d\\TH:i:s.') . sprintf('%03d', $milliseconds) . "P] [LOG] " . $message . "\n";
    }
}