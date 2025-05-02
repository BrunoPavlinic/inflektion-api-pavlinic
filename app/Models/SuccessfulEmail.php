<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        if (empty($this->email)) {
            return false;
        }

        // Parse the email content
        $rawEmail = $this->email;
        
        // Remove headers by finding the first empty line which separates headers from body
        $parts = explode("\r\n\r\n", $rawEmail, 2);
        $body = $parts[1] ?? '';
        
        // If we have a multipart message, extract just the plain text part
        if (strpos($rawEmail, 'Content-Type: multipart/') !== false) {
            $pattern = '/Content-Type: text\/plain.*?(?:\r\n\r\n|\n\n)(.*?)(?:(?:\r\n|\n)--[^\r\n]+|$)/s';
            if (preg_match($pattern, $rawEmail, $matches)) {
                $body = $matches[1];
            }
        }
        
        // Clean up the body text
        $body = trim($body);
        
        // Save the extracted plain text to the raw_text column
        $this->raw_text = $body;
        
        return $this->save();
    }
} 