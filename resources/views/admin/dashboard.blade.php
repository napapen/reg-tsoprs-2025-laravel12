@extends('layouts.admin')

@section('content')

   <div class="container py-4">
    <h4 class="fw-bold mb-4 text-center">ภาพรวมผู้ลงทะเบียน APSOPRS Masterclass</h4>
    
    <!-- Summary Cards -->
    <div class="row g-3">
      <div class="col-md-6">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <p class="mb-1">ลงทะเบียนทั้งหมด</p>
                <h3 class="text-primary fw-bold mb-0">{{ $total }}</h3>
                <small>คน</small>
              </div>
              <div class="col-md-3">
                <p class="mb-1">ตรวจสอบแล้ว</p>
                <h3 class="text-primary fw-bold mb-0">{{ $reviewed }}</h3>
                <small>คน</small>
              </div>
              <div class="col-md-3">
                <p class="mb-1">รอการตรวจสอบ</p>
                <h3 class="text-primary fw-bold mb-0">{{ $pending }}</h3>
                <small>คน</small>
              </div>
              <div class="col-md-3">
                <p class="mb-1">ยกเลิก</p>
                <h3 class="text-primary fw-bold mb-0">{{ $cancelled }}</h3>
                <small>คน</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <p class="mb-1">Full-Day Workshop</p>
            <h3 class="text-success fw-bold  mb-0">{{ $workshop }}</h3>
            <small>คน</small>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <p class="mb-1">Onsite Lecture</p>
            <h3 class="text-danger fw-bold mb-0">{{ $onsite }}</h3>
            <small>คน</small>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <p class="mb-1">Online Lecture</p>
            <h3 class="text-primary fw-bold mb-0">{{ $online }}</h3>
            <small>คน</small>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-3 mt-4">
      <!-- Pie Chart -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="fw-bold mb-3">สัดส่วนการลงทะเบียน (เร็วๆนี้)</h6>
            <canvas id="budgetChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="fw-bold mb-3">หัวข้อ Workshop ที่ผู้ลงทะเบียนสนใจ (เร็วๆนี้)</h6>
            <table class="table table-bordered text-center">
              <thead class="table-light">
                <tr>
                  <th>ชื่อหัวข้อ</th>
                  <th>จำนวนที่เลือก</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Using a smartphone camera for clinical photography</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>DIY surgical video recording (smartphone or professional camera)</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Portrait photography for social media and professional websites</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Creating and editing educational videos</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Easy studio setup & lighting for clinical photography</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Using a professional camera for clinical photography</td>
                  <td>0</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Chart Script -->
  <script>
    const ctx = document.getElementById('budgetChart').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Full-Day Workshop', 'Onsite Lecture','Online Lecture'],
        datasets: [{
          data: [195000, 8805000,1000000],
          backgroundColor: ['#dc3545', '#28a745', '#0d6efd']
        }]
      },
      options: {
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  </script>

@endsection