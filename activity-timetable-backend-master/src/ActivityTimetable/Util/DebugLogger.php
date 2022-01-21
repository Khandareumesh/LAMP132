<?php

namespace ActivityTimetable\Util;

use Doctrine\Common\Util\Debug;
use Psr\Log\LoggerInterface;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class DebugLogger
{
    protected static $logger;

    public static function init(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    public static function getLogger()
    {
        return self::$logger;
    }

    public static function dump($mixed)
    {
        ob_start();
        Debug::dump($mixed, 3);
        self::$logger->warn("<< dump >> ".ob_get_contents());
        ob_end_clean();
    }
}
