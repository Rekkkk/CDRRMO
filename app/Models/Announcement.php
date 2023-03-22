<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'admin_announcement';

    protected $primaryKey = 'announcement_id';

    protected $fillable = [
        'announcement_description',
        'announcement_content',
        'announcement_video',
        'announcement_image',
    ];  
}
