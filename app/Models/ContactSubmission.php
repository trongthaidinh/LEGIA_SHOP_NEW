<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'email', 
        'message', 
        'locale', 
        'status', 
        'ip_address'
    ];

    public static function validateSubmission($data)
    {
        return Validator::make($data, [
            'name' => [
                'required', 
                'string', 
                'max:255'
            ],
            'email' => [
                'required', 
                'email', 
                'max:255'
            ],
            'message' => [
                'required', 
                'string', 
                'max:1000'
            ]
        ], [
            'name.required' => __('Please enter a valid name'),
            'name.max' => __('Name is too long'),
            'email.required' => __('Please enter a valid email'),
            'email.email' => __('Invalid email address'),
            'email.max' => __('Email address is too long'),
            'message.required' => __('Please enter your message'),
            'message.max' => __('Message is too long')
        ]);
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    public function markAsRead()
    {
        $this->status = 'read';
        $this->save();
    }

    public function markAsReplied()
    {
        $this->status = 'replied';
        $this->save();
    }
}
