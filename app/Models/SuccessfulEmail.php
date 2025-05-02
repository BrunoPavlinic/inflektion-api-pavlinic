<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ZBateson\MailMimeParser\MailMimeParser;

class SuccessfulEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'successful_emails';
    
    public $timestamps = false;

    protected $fillable = [
        'affiliate_id',
        'envelope',
        'from',
        'subject',
        'dkim',
        'SPF',
        'spam_score',
        'email',
        'raw_text',
        'sender_ip',
        'to',
        'timestamp'
    ];

    protected $casts = [
        'spam_score' => 'float',
        'timestamp' => 'integer',
        'affiliate_id' => 'integer'
    ];

    /**
     * Parse the raw email content and extract the plain text body
     * 
     * @return bool
     */
    public function parseAndSaveRawText(): bool
    {
        if (empty($this->email) || ! empty($this->raw_text)) {
            return false;
        }

        $parser = new MailMimeParser();
        $message = $parser->parse($this->email, false);
        $this->raw_text = $message->getTextContent();

        if (empty($this->raw_text)) {
            $this->raw_text = "";
        }
        
        return $this->save();
    }
} 