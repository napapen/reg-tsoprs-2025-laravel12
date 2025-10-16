@extends('layouts.admin')

@section('content')
@php
    use Carbon\Carbon;

    // กำหนดเวลาที่ต้องการเปรียบเทียบ (16 ต.ค. 2025 เวลา 14:00)
    $deadline = Carbon::create(2025, 10, 16, 14, 0, 0, 'Asia/Bangkok');
    $currentTotalText = "0 THB";
@endphp
<div class="container">
    <div class="row mb-4 justify-content-between align-items-center">
        <div class="col-8">
            <h4 class="fw-bold">รายละเอียดการลงทะเบียน #{{ $registration->transid }}</h4>
        </div>
        <div class="col-4 text-end">
            <a href="{{ route('register.list') }}" class="btn btn-secondary"><< กลับไปหน้ารายการ</a>
        </div>
    </div>

    <div class="row">
        <div class="col-5">
            <table class="table table-bordered">
                <tr>
                    <th class="w-25">เลขอ้างอิง</th>
                    <td>{{ $registration->transid }}</td>
                </tr>
                <tr>
                    <th>หัวข้อ</th>
                    <td>{{ $registration->event_type_text }}</td>
                </tr>
                <tr>
                    <th>ประเภท</th>
                    <td>{{ $registration->registration_type_text }}</td>
                </tr>
                <tr>
                    <th>การชำระเงิน</th>
                    <td>{{ $registration->registration_payment_text }}
                    </td>
                </tr>
                <tr>
                    <th>ยอดชำระ</th>
                    <td>
                        @if (Carbon::parse($registration->created_at)->greaterThan($deadline))
                            <p class="mb-0">
                                {{ $registration->payment_total_text_new }}
                            </span>
                        @else
                            <p class="mb-0 lh-1">
                                <span class="text-muted text-decoration-line-through" style="font-size:80%">{{ $registration->payment_total_text_new }}</span>  {{ $registration->payment_total_text }}<br/>
                                <span class="text-muted" style="font-size:80%">Early Bird</span>
                            </p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>สถานะ</th>
                    <td>
                        @if($registration->status === 'pending')
                            <span class="badge bg-warning text-dark">ยังไม่ดำเนินการ</span>
                        @elseif($registration->status === 'reviewed')
                            <span class="badge bg-success">ตรวจสอบแล้ว</span>
                        @elseif($registration->status === 'cancelled')
                            <span class="badge bg-danger">ยกเลิก</span><br/>
                            <div class="text-muted">{{ $registration->cancel_reason ? $registration->cancel_reason : '' }}</div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>วันเวลาลงทะเบียน</th>
                    <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>

            <div class="row">
                <div class="col-9">
                    <h5 class="fw-bold">หลักฐานการชำระเงิน</h5>
                    @if($registration->pay_slip_path)
                        <img src="{{ asset($registration->pay_slip_path) }}" 
                        alt="Payment Proof" class="img-fluid border"/>
                    @else
                        <p class="text-muted">ไม่มีหลักฐานการชำระเงิน</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-7">
            <table class="table table-bordered">
                <tr>
                    <th class="w-25">ชื่อ-สกุล</th>
                    <td>{{ $registration->full_name }}</td>
                </tr>
                <tr>
                    <th>อีเมล</th>
                    <td>{{ $registration->email }}</td>
                </tr>
                <tr>
                    <th>โทรศัพท์</th>
                    <td>{{ $registration->mobile ? $registration->mobile : '-' }}</td>
                </tr>
                <tr>
                    <th>Institution</th>
                    <td>{{ $registration->institution }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ $registration->country }}</td>
                </tr>
                <tr>
                    <th>Specialty</th>
                    <td>
                         {{ $registration->specialty_text }}
                    </td>
                </tr>
                <tr>
                    <th>Experience</th>
                    <td>{{ ucfirst($registration->photography_experience) }}</td>
                </tr>
                <tr>
                    <th>Smartphone/Camera Brand</th>
                    <td>{{ $registration->camera_brand ? $registration->camera_brand : '-' }}</td>
                </tr>

                @if($registration->event_type === 'workshop')
                <tr>
                    <th>Topic Most Interest</th>
                    <td>
                        @if(is_array($registration->workshop_topics_text_array))
                            <ul class="mb-0">
                                @foreach($registration->workshop_topics_text_array as $topic)
                                    <li>{{ $topic }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Camera Type</th>
                    <td>
                        @if(is_array($registration->camera_type_text_array))
                            <ul class="mb-0">
                                @foreach($registration->camera_type_text_array as $camera)
                                    <li>{{ $camera }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>

                @endif



            </table>
        </div>
    </div>

    
</div>
@endsection
