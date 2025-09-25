@extends('layouts.admin')

@section('content')

   <div class="container py-4">
    <h4 class="fw-bold mb-4 text-center">ภาพรวมงบประมาณ ปีการศึกษา 2568</h4>
    
    <!-- Summary Cards -->
    <div class="row g-3">
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <p class="mb-1">งบประมาณที่ได้รับจัดสรร</p>
            <h4 class="text-primary fw-bold">9,000,000</h4>
            <small>บาท</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <p class="mb-1">งบประมาณคงเหลือ</p>
            <h4 class="text-success fw-bold">8,805,000</h4>
            <small>บาท</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <p class="mb-1">งบประมาณที่ใช้ไปทั้งหมด</p>
            <h4 class="text-danger fw-bold">195,000</h4>
            <small>บาท</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <p class="mb-1">จำนวนโครงการในระบบ</p>
            <h4 class="text-primary fw-bold">5</h4>
            <small>โครงการ</small>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-3 mt-4">
      <!-- Pie Chart -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="fw-bold mb-3">สัดส่วนการใช้งบประมาณ</h6>
            <canvas id="budgetChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="fw-bold mb-3">โครงการที่เบิกจ่ายล่าสุด 5 อันดับ</h6>
            <table class="table table-bordered text-center">
              <thead class="table-light">
                <tr>
                  <th>ชื่อโครงการ</th>
                  <th>เบิกจ่ายแล้ว</th>
                  <th>สถานะ</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>FFFFF</td>
                  <td>0</td>
                  <td><span class="badge bg-warning text-dark">ยังไม่ดำเนินการ</span></td>
                </tr>
                <tr>
                  <td>โครงการเสริมสร้างทักษะทางวิชาการให้นักเรียน</td>
                  <td>25,000</td>
                  <td><span class="badge bg-success">ดำเนินการแล้ว</span></td>
                </tr>
                <tr>
                  <td>โครงการพัฒนาบุคลากร</td>
                  <td>0</td>
                  <td><span class="badge bg-warning text-dark">ยังไม่ดำเนินการ</span></td>
                </tr>
                <tr>
                  <td>ปรับปรุงซ่อมแซมบริบท</td>
                  <td>150,000</td>
                  <td><span class="badge bg-warning text-dark">ยังไม่ดำเนินการ</span></td>
                </tr>
                <tr>
                  <td>ปรับปรุงซ่อมแซมบริบท</td>
                  <td>20,000</td>
                  <td><span class="badge bg-success">ดำเนินการแล้ว</span></td>
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
        labels: ['งบประมาณที่ใช้ไป', 'งบประมาณคงเหลือ'],
        datasets: [{
          data: [195000, 8805000],
          backgroundColor: ['#dc3545', '#28a745']
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