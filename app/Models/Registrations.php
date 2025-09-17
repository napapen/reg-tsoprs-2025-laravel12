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
        'registration_type',
        'pay_date',
        'pay_hour',
        'pay_min',
        'pay_slip',
        'full_name',
        'email',
        'mobile',
        'institution',
        'country',
        'specialty',
        'specialty_other',
        'camera_type',
        'camera_type_other',
        'camera_brand',
        'workshop_topics',
        'photography_experience',
        'other_topics',
        'equipment_questions',
    ];
}
