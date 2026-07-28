<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('db:reset-records', function () {
    $this->info('Resetting bookings, customers, feedbacks, job records, and notifications...');

    Schema::disableForeignKeyConstraints();

    DB::table('job_records')->truncate();
    DB::table('feedbacks')->truncate();
    DB::table('bookings')->truncate();
    DB::table('customers')->truncate();
    DB::table('notifications')->truncate();

    Schema::enableForeignKeyConstraints();

    $this->info('Successfully deleted all records and reset all auto-increment IDs to 1.');
})->purpose('Remove all bookings, customers, job records, feedbacks, and notifications, and reset auto-increment IDs to 1');

