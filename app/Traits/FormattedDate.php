<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormattedDate
{
    /**
     * @param string $field
     * @param string $format
     * @return string
     */
    public function getFormatedDate(string $field, string $format = 'd M Y'): string
    {
        if ($this->$field) {
            return Carbon::parse($this->$field)->format($format);
        }

        return '';
    }
}
