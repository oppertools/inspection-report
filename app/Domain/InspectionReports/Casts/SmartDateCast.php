<?php

namespace App\Domain\InspectionReports\Casts;

use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class SmartDateCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): ?Carbon
    {
        if ($value === null || $value === '' || ! is_string($value) && ! is_numeric($value)) {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value;
        }

        $dateString = (string) $value;

        try {
            $dateString = $this->cleanDateString($dateString);

            $carbon = $this->trySpecificFormats($dateString);
            if ($carbon) {
                return $carbon;
            }

            return Carbon::parse($dateString);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function cleanDateString(string $dateString): string
    {

        $dateString = preg_replace('/\s+T/', 'T', $dateString);

        $dateString = trim($dateString, "\x00..\x1F,;: ");

        return $dateString;
    }

    private function trySpecificFormats(string $dateString): ?Carbon
    {

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) {
            return Carbon::createFromFormat('Y-m-d', $dateString);
        }

        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dateString)) {
            return Carbon::createFromFormat('d/m/Y', $dateString);
        }

        if (preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', $dateString)) {
            return Carbon::createFromFormat('d-m-Y', $dateString);
        }

        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dateString)) {
            try {
                return Carbon::createFromFormat('m/d/Y', $dateString);
            } catch (\Exception $e) {

                try {
                    return Carbon::createFromFormat('d/m/Y', $dateString);
                } catch (\Exception $e2) {

                }
            }
        }

        if (str_contains($dateString, 'T')) {
            return Carbon::parse($dateString);
        }

        if (is_numeric($dateString) && strlen($dateString) >= 10) {
            try {

                if (strlen($dateString) >= 13) {
                    return Carbon::createFromTimestampMs((int) $dateString);
                }

                return Carbon::createFromTimestamp((int) $dateString);
            } catch (\Exception $e) {

            }
        }

        if (preg_match('/\d+\s+[a-zéûôâêîùàèìòù]+\s+\d{4}/i', $dateString)) {
            Carbon::setLocale('fr');
            try {
                return Carbon::parse($dateString);
            } catch (\Exception $e) {

            }
        }

        if (preg_match('/[a-z]+\s+\d{1,2},?\s+\d{4}/i', $dateString)) {
            try {
                return Carbon::parse($dateString);
            } catch (\Exception $e) {

            }
        }

        if (preg_match('/^\d{4}\/\d{1,2}\/\d{1,2}$/', $dateString)) {
            return Carbon::createFromFormat('Y/m/d', $dateString);
        }

        if (preg_match('/[a-z]+,\s+[a-z]+\s+\d{1,2},?\s+\d{4}/i', $dateString)) {
            try {
                return Carbon::parse($dateString);
            } catch (\Exception $e) {
            }
        }

        return null;
    }
}
