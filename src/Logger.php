<?php

namespace App;

class Logger
{
    public function log(string $message): void
    {
        $datetime = \DateTime::createFromFormat('U.u', microtime(true));
        $datetime->setTimezone(new \DateTimeZone('Asia/Tokyo'));
        echo "[" . $datetime->format('Y-m-d\TH:i:s.vP') . "] [LOG] " . $message . "\n";
    }
}

