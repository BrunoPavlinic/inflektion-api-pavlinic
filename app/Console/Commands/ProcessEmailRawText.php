<?php

namespace App\Console\Commands;

use App\Models\SuccessfulEmail;
use Illuminate\Console\Command;

class ProcessEmailRawText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:process-raw-text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process raw text from emails that have not been processed yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to process emails...');

        // Get all emails where raw_text is empty or null
        $emails = SuccessfulEmail::whereNull('raw_text')
            ->orWhere('raw_text', '')
            ->get();

        $processed = 0;
        foreach ($emails as $email) {
            if ($email->parseAndSaveRawText()) {
                $processed++;
            }
        }

        $this->info("Processed {$processed} emails successfully.");
    }
} 