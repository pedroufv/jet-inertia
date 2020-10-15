<?php

namespace App\Jobs;

use App\Models\Estate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportEstatesFromCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private string $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reader = Excel::load($this->path);
        foreach ($reader->toArray() as $row) {
           $this->loadEstateFromRow($row)->save();
        }
    }

    /**
     * @param array $row
     * @return Estate|\Illuminate\Database\Eloquent\Model
     */
    private function loadEstateFromRow(array $row)
    {
        $row = array_values($row);

        $attributes['state'] = $row[0];
        $attributes['city'] = $row[1];
        $attributes['neighborhood'] = $row[2];
        $attributes['street'] = $row[3];
        $attributes['number'] = $row[4];
        $attributes['details'] = $row[5];

        return new Estate($attributes);
    }
}
