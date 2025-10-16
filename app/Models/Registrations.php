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
        'status',
        'cancel_reason',
    ];

    // แปลง event_type → text
    public function getEventTypeTextAttribute()
    {
        $map = [
            'onsite'   => 'Onsite Lecture',
            'online'   => 'Online Lecture',
            'workshop' => 'Full-Day Workshop',
        ];
        return $map[$this->event_type] ?? $this->event_type;
    }

    // แปลง registration_type → text
    public function getRegistrationTypeTextAttribute()
    {
        $map = [
            'rcopt'         => 'RCOPT Delegates',
            'nonrcopt'      => 'Non-RCOPT Thai Delegates',
            'international' => 'International Delegates',
        ];
        return $map[$this->registration_type] ?? $this->registration_type;
    }

    // แปลง payment channel → text
    public function getRegistrationPaymentTextAttribute()
    {
        $map = [
            'rcopt'         => 'Direct Bank Transfer',
            'nonrcopt'      => 'Direct Bank Transfer',
            'international' => 'Credit Card',
        ];
        return $map[$this->registration_type] ?? '';
    }

    // รวมราคา
    public function getPaymentTotalAttribute()
    {
        $pricing = [
            'onsite' => [
                'rcopt'         => 1000,
                'nonrcopt'      => 3000,
                'international' => 3000,
            ],
            'online' => [
                'rcopt'         => 0,
                'nonrcopt'      => 0,
                'international' => 1700,
            ],
            'workshop' => [
                'rcopt'         => 7500,
                'nonrcopt'      => 9000,
                'international' => 8500,
            ],
        ];

        return $pricing[$this->event_type][$this->registration_type] ?? 0;
    }

    public function getPaymentTotalTextAttribute()
    {
        return number_format($this->payment_total, 0, '.', ',') . ' THB';
    }

    // up selling
    public function getPaymentTotalNewAttribute()
    {
        $pricing = [
            'onsite' => [
                'rcopt'         => 1250,
                'nonrcopt'      => 3300,
                'international' => 3300,
            ],
            'online' => [
                'rcopt'         => 0,
                'nonrcopt'      => 0,
                'international' => 1900,
            ],
            'workshop' => [
                'rcopt'         => 8250,
                'nonrcopt'      => 9900,
                'international' => 9350,
            ],
        ];

        return $pricing[$this->event_type][$this->registration_type] ?? 0;
    }

    public function getPaymentTotalTextNewAttribute()
    {
        return number_format($this->payment_total_new, 0, '.', ',') . ' THB';
    }


    // pay_slip path
    public function getPaySlipPathAttribute()
    {
        return $this->pay_slip
            ? \Storage::url($this->pay_slip)
            : \Storage::url('uploads/default-slip.jpg');
    }

    // pay_time
    public function getPayTimeAttribute()
    {
        return ($this->pay_date && $this->pay_hour !== null && $this->pay_min !== null)
            ? $this->pay_date.' '.$this->pay_hour.':'.$this->pay_min
            : 'N/A';
    }
        
    public function getStatusTextAttribute()
    {
        $map = [
            'pending'   => 'ยังไม่ดำเนินการ',
            'reviewed'  => 'ตรวจสอบแล้ว',
            'cancelled' => 'ยกเลิก',
        ];

        return $map[$this->status] ?? $this->status;
    }

}
