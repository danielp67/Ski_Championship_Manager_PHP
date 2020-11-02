<?php

namespace App\Dto;

final class TimeCalculation
{
    /**
     * Sum Time of each Stages
     * @param array $stages
     * @return string $averageTime
     */
    public static function calculationOfTotalTime(array $stages): string
    {
        if(! empty($stages)){
            $minutes = 0;
            $seconds = 0;
            $milliseconds = 0;
            foreach ($stages as $stage) {
                $minutes = $minutes + (int) $stage->getTime()->format('i');
                $seconds = $seconds + (int) $stage->getTime()->format('s');
                $milliseconds = $milliseconds + ((int) $stage->getTime()->format('u')) / 1000;

                if ($milliseconds > 999) {
                    $seconds = $seconds + 1;
                    $milliseconds = $milliseconds - 1000;
                }
                if ($seconds > 59) {
                    $minutes = $minutes + 1;
                    $seconds = $seconds - 60;
                }
                $minutes = ($minutes < 10) ? strval('0' . $minutes) : strval($minutes);
                $seconds = ($seconds < 10) ? strval('0' . $seconds) : strval($seconds);
            }
            $averageTime = strval($minutes . ':' . $seconds . '.' . $milliseconds);

        } else {
            $averageTime ="59:59.99";
        }
        return $averageTime;
    }
}
