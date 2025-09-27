@extends('layouts.admin')

@section('content')

   <div class="container">
    <h3 class="fw-bold mb-4 text-center">ภาพรวมผู้ลงทะเบียน APSOPRS Masterclass</h3>
    
    <!-- Summary Cards -->
    <div class="row g-3">
      <div class="col-md-6">
        <h4 class="mb-3"><i class="fa-regular fa-circle-user h5 fw-normal"></i> สรุปการลงทะเบียน</h4>
        <div class="row">
        <div class="col-md-3">
              <div class="card text-white bg-primary shadow">
                  <div class="card-body text-center">
                      <h3 class="fw-bold">{{ $total }}</h3>
                      <p class="mb-0">ผู้ลงทะเบียน</p>
                  </div>
              </div>
          </div>
          <!-- Reviewed -->
          <div class="col-md-3">
              <div class="card text-white bg-success shadow">
                  <div class="card-body text-center">
                      <h3 class="fw-bold">{{ $reviewed }}</h3>
                      <p class="mb-0">ตรวจสอบแล้ว</p>
                  </div>
              </div>
          </div>
          <!-- Pending -->
          <div class="col-md-3">
              <div class="card text-dark bg-warning shadow">
                  <div class="card-body text-center">
                      <h3 class="fw-bold">{{ $pending }}</h3>
                      <p class="mb-0">รอการตรวจสอบ</p>
                  </div>
              </div>
          </div>
          <!-- Cancelled -->
          <div class="col-md-3">
              <div class="card text-white bg-danger shadow">
                  <div class="card-body text-center">
                      <h3 class="fw-bold">{{ $cancelled }}</h3>
                      <p class="mb-0">ยกเลิก</p>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
          <h4 class="mb-3"><i class="fa-solid fa-pen h5 fw-normal"></i> สรุปตามประเภทการลงทะเบียน <span class="text-muted" style="font-size: 80%;">(นับเฉพาะตรวจสอบแล้ว)</span></h4>
          <div class="row">
        <div class="col-md-4">
            <div class="card shadow" style="background:#B6D7A8">
                <div class="card-body text-center">
                    <h3 class="fw-bold">{{ $workshop }}</h3>
                    <p class="mb-0">Full-Day Workshop</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow" style="background: #9FC5E8">
                <div class="card-body text-center">
                    <h3 class="fw-bold">{{ $onsite }}</h3>
                    <p class="mb-0">Onsite Lecture</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow" style="background: #F9CB9C">
                <div class="card-body text-center">
                    <h3 class="fw-bold">{{ $online }}</h3>
                    <p class="mb-0">Online Lecture</p>
                </div>
            </div>
        </div>
          


            
          </div>
      </div>
    </div>

    <div class="row g-3 mt-4">
      <!-- Pie Chart -->
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="fw-bold mb-3">สัดส่วนประเภทการลงทะเบียน <span class="text-muted" style="font-size: 80%;">(นับเฉพาะตรวจสอบแล้ว)</span></h6>
            <canvas id="budgetChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="fw-bold mb-3">สัดส่วน Specialty/Subspecialty <span class="text-muted" style="font-size: 80%;">(นับเฉพาะตรวจสอบแล้ว)</span></h6>
            <canvas id="specialtyChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="fw-bold mb-3">สัดส่วน Photography Experience <span class="text-muted" style="font-size: 80%;">(นับเฉพาะตรวจสอบแล้ว)</span></h6>
            <canvas id="photoExpChart"></canvas>
          </div>
        </div>
      </div>

    </div>
    <div class="row g-3 mt-4">
      <!-- Table -->
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-body">

            <h6 class="fw-bold mb-3">หัวข้อ Workshop ที่ผู้ลงทะเบียน Full-Day Workshop สนใจ <span class="text-muted" style="font-size: 80%;">(นับเฉพาะตรวจสอบแล้ว)</span></h6>
            <table class="table table-bordered text-center">
              <thead class="table-light">
                <tr>
                  <th>ชื่อหัวข้อ</th>
                  <th>จำนวนที่เลือก</th>
                </tr>
              </thead>
              <tbody>
                @foreach($topicCounts as $topic => $count)
                <tr>
                  <td class="text-start">{{ $topic }}</td>
                  <td>{{ $count }}</td>
                </tr>
                @endforeach
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
    labels: ['Full-Day Workshop', 'Onsite Lecture', 'Online Lecture'],
    datasets: [{
      data: [{{ $workshop }}, {{ $onsite }}, {{ $online }}],
      backgroundColor: ['#B6D7A8', '#9FC5E8', '#F9CB9C']
    }]
  },
  options: {
    plugins: {
      legend: {
        position: 'bottom'
      },
      datalabels: {
        color: '#000',
        formatter: (value, context) => {
          let dataset = context.chart.data.datasets[0].data;
          let total = dataset.reduce((a, b) => a + b, 0);
          let percentage = (value / total * 100).toFixed(1) + "%";
          return percentage;
        }
      }
    }
  },
  plugins: [ChartDataLabels]
});

  
// Specialty Chart
const specialtyLabels = @json($specialtyCounts->keys());
const specialtyData = @json($specialtyCounts->values());

new Chart(document.getElementById('specialtyChart'), {
    type: 'pie',
    data: {
        labels: specialtyLabels,
        datasets: [{
            data: specialtyData,
            backgroundColor: [  '#e8cf76','#a569b5', '#4dbf9f', '#5f8dce', '#94ba84', '#dba876', '#d65f5f','#6c757d']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            },
            datalabels: {
                color: '#fff',
                font: {
                    weight: 'bold',
                    size: 14
                },
                formatter: (value, context) => {
                    return value; // แสดงตัวเลข
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});

// Photography Experience Chart
const photoExpLabels = @json($photoExperienceCounts->keys());
const photoExpData = @json($photoExperienceCounts->values());

new Chart(document.getElementById('photoExpChart'), {
    type: 'pie',
    data: {
        labels: photoExpLabels,
        datasets: [{
            data: photoExpData,
            backgroundColor: ['#5f8dce', '#94ba84', '#dba876', '#d65f5f', '#a569b5', '#4dbf9f', '#f0c419', '#6c757d']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            datalabels: {
                color: '#fff',
                font: { weight: 'bold', size: 14 },
                formatter: (value, context) => value
            }
        }
    },
    plugins: [ChartDataLabels]
});
</script>

@endsection