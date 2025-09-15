<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrations extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'transid',
        'event_type',
        'full_name',
        'email',
        'mobile',
        'country',
        'specialty',
        'cameratype',
        'registration_type',
        'institution',             // <-- เพิ่ม
        'camera_brand',            // <-- เพิ่ม
        'photography_experience',  // <-- เพิ่ม
        'workshop_topics',         // <-- เพิ่ม
        'other_topics',            // <-- เพิ่ม
        'equipment_questions',     // <-- เพิ่ม
        'photo_path',
    ];
}
