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
        'institution',             
        'camera_brand',            
        'photography_experience',  
        'workshop_topics',         
        'other_topics',            
        'equipment_questions',     
        'photo_path',
    ];
}
