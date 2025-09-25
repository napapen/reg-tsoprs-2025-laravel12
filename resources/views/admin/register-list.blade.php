@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row mb-4 justify-content-between align-items-center">
        <div class="col-8">
            <h4 class="fw-bold">รายการลงทะเบียน</h4>
        </div>
        <div class="col-4">
            <form method="GET" action="{{ route('register.list') }}">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Search by TransID, Name, Email" class="form-control d-inline-block w-50">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>เลขอ้างอิง</th>
                <th>ชื่อ สกุล</th>
                <th>หัวข้อ</th>
                <th>ประเภทผู้ลงทะเบียน</th>
                <th>การชำระเงิน</th>
                <th>ยอดชำระ</th>
                <th>วันที่ลงทะเบียน</th>
                <th>ตรวจสอบการชำระ</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registrations as $reg)
                <tr>
                    <td class="text-center">{{ $reg->transid }}</td>
                    <td>
                        {{ $reg->full_name }}<br/>
                        <a href="mailto:{{ $reg->email }}" class="text-muted text-decoration-none">{{ $reg->email }}</a><br/>
                        <a href="tel:{{ $reg->mobile }}" class="text-muted text-decoration-none">{{ $reg->mobile }}</a>
                    </td>
                    <td class="text-center">{{ $reg->event_type_text }}</td>
                    <td class="text-center">{{ $reg->registration_type_text }}</td>
                    <td class="text-center">{{ $reg->registration_payment_text }}</td>
                    <td class="text-center">{{ $reg->payment_total_text }}</td>
                    <td class="text-center">{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        @if($reg->status === 'pending')
                            <span class="badge bg-warning text-dark">ยังไม่ดำเนินการ</span>
                        @elseif($reg->status === 'reviewed')
                            <span class="badge bg-success">ตรวจสอบแล้ว</span>
                        @elseif($reg->status === 'cancelled')
                            <span class="badge bg-danger">ยกเลิก</span><br/>
                            <div class="text-muted">{{ $reg->cancel_reason ? $reg->cancel_reason : '' }}</div>
                        @endif
                    </td>
                    <td class="text-center">
                         <button class="btn btn-sm btn-outline-primary" 
                                onclick="openStatusModal(
                                    {{ $reg->id }}, 
                                    '{{ $reg->status }}',
                                    '{{ $reg->transid }}',
                                    '{{ $reg->event_type_text }}',
                                    '{{ $reg->registration_type_text }}', 
                                    '{{ $reg->registration_payment_text }}',
                                    '{{ $reg->payment_total_text }}',
                                    '{{ $reg->full_name }}',
                                    '{{ $reg->created_at->format('d/m/Y H:i') }}',
                                    '{{ $reg->email }}',
                                    '{{ $reg->mobile }}',
                                    '{{ $reg->pay_slip_path }}',
                                    '{{ $reg->pay_time }}',
                                    '{{ $reg->registration_type }}', 
                                )">
                            ตรวจสอบ
                        </button>
                        <a href="{{ route('register.detail', $reg->id) }}" 
                        class="btn btn-sm btn-outline-info">
                            ดูข้อมูล
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No registrations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div>
        {{ $registrations->links('pagination::bootstrap-5') }}


    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="statusModalLabel">ตรวจสอบการชำระ</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            
          <input type="hidden" id="status_id">
          <div class="container-fluid">
            <div class="row bg-light pt-2 border pb-2">
                <div class="col-md-6"><strong>เลขอ้างอิง:</strong> <span id="modal_transid"></span></div>
                <div class="col-md-6"><strong>เวลาลงทะเบียน:</strong> <span id="modal_created_date"></span></div>
            </div>
            
            <div class="row pt-3">
                <div class="col-md-6"><strong class="mb-1">หลักฐานการชำระเงิน:</strong><br/>
                    <img id="modal_pay_slip" src="" alt="pay slip" style="max-width:100%;"/>
                </div>
                <div class="col-md-6 mt-4">
                    <div class="row bg-light pt-3">
                        <div class="col-md-4">
                            <strong>ชื่อ สกุล:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="modal_fullname"></span>
                        </div>
                    </div>
                    <div class="row bg-light pt-2">
                        <div class="col-md-4">
                            <strong>อีเมล์:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="modal_email"></span>
                        </div>
                    </div>
                    <div class="row bg-light pt-2 pb-3">
                        <div class="col-md-4">
                            <strong>โทร:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="modal_mobile"></span>
                        </div>
                    </div>
                    <div class="row mb-2 pt-2">
                        <div class="col-md-4">
                            <strong>หัวข้อ:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="modal_event_type"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <strong>ประเภท:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="modal_registration_type"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <strong>ชำระโดย:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="modal_registration_payment"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <strong>ยอดชำระ:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="modal_payment_total"></span>
                        </div>
                    </div>
                    <div id="panelShowInternation" class="row mb-2  d-none">
                        <div class="col-md-4">
                            <strong>เวลาชำระ:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="modal_pay_time"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 mb-2">
                            <strong>ตรวจสอบการชำระ:</strong>
                        </div>
                        <div class="col-md-12">
                            <select class="form-control" name="status" id="status_value" onchange="toggleReasonBox()">
                                <option value="pending">ยังไม่ดำเนินการ</option>
                                <option value="reviewed">ตรวจสอบแล้ว</option>
                                <option value="cancelled">ยกเลิก</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2" id="reason_box" style="display:none;">
                        <div class="col-md-12">
                            <label for="cancel_reason" class="form-label"><strong>เหตุผลการยกเลิก:</strong></label>
                            <textarea id="cancel_reason" name="cancel_reason" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    
                </div>
                
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
          <button type="button" class="btn btn-primary" onclick="submitStatus()">บันทึก</button>
        </div>
      </div>
  </div>
</div>

<script>
function openStatusModal(id, status, transId, eventType ,registrationTypeText, registrationPayment, paymentTotal, regFullName, createdDate, regEmail,regMobile, paySlipPath,payTime,registrationType) {
    document.getElementById('status_id').value = id;
    document.getElementById('status_value').value = status;

    // set text into modal
    document.getElementById('modal_transid').innerText = transId;
    document.getElementById('modal_registration_type').innerText = registrationTypeText;
    document.getElementById('modal_registration_payment').innerText = registrationPayment;
    document.getElementById('modal_event_type').innerText = eventType;
    document.getElementById('modal_payment_total').innerText = paymentTotal;
    document.getElementById('modal_fullname').innerText = regFullName;
    document.getElementById('modal_created_date').innerText = createdDate;
    document.getElementById('modal_email').innerText = regEmail;
    document.getElementById('modal_mobile').innerText = regMobile;
    document.getElementById('modal_pay_slip').src = paySlipPath;
    document.getElementById('modal_pay_time').innerText = payTime;

    const showPayTime = document.getElementById('panelShowInternation');
    if (registrationType === 'international') {
         showPayTime.classList.remove('d-none');
    }else{
        showPayTime.classList.add('d-none');
    }

    toggleReasonBox();

    var myModal = new bootstrap.Modal(document.getElementById('statusModal'));
    myModal.show();
}

function toggleReasonBox() {
    const selectedStatus = document.getElementById('status_value').value; 
    const reasonBox = document.getElementById('reason_box');
    if (selectedStatus === 'cancelled') {
        reasonBox.style.display = 'block';
    } else {
        reasonBox.style.display = 'none';
        document.getElementById('cancel_reason').value = ''; // เคลียร์ค่า
    }
}

function submitStatus() {
    const id = document.getElementById('status_id').value;
    const status = document.getElementById('status_value').value;
    const reason = document.getElementById('cancel_reason') ? document.getElementById('cancel_reason').value : null;

    fetch("{{ route('register.updateStatus') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ id, status, reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //alert(data.message); // หรือใช้ toast
            location.reload();   // <-- reload หน้าเพจหลังอัปเดต
        } else {
            alert('Failed to update status');
        }
    })
    .catch(err => console.error(err));
}
</script>

@endsection