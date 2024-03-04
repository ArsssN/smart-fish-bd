<?php

namespace App\Imports;

use App\Models\Invitee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InviteeImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    use Importable;

    /**
     * @param array $row
     *
     * @return Model|Invitee|null
     */
    public function model(array $row): Model|Invitee|null
    {
        return new Invitee([
            'name'    => $row['name'],
            'email'   => $row['email'],
            'phone'   => $row['phone'],
            'address' => $row['address'],
            'slug'    => Str::slug($row['name']),
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
