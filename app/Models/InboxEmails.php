<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboxEmails extends Model
{
    use HasFactory;
    protected $fillable = ['from', 'subject', 'message', 'category'];
}
