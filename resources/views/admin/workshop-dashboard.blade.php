@extends('layouts.admin')
@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Full-Day Workshop</h4>
        {{-- <a href="{{ route('workshop.export') }}" class="btn btn-success">Export Excel</a> --}}
    </div>

    {{-- Section 1: Charts --}}
    <div class="row mb-4  justify-content-center">
        <div class="col-md-3">
            <h6>ประเภทผู้ลงทะเบียน</h6>
            <canvas id="registrationTypeChart"></canvas>
        </div>
        <div class="col-md-3">
            <h6>Country</h6>
            <canvas id="countryChart"></canvas>
        </div>
        <div class="col-md-3">
            <h6>Specialty / Subspecialty</h6>
            <canvas id="specialtyChart"></canvas>
        </div>
        <div class="col-md-3">
            <h6>Photography Experience</h6>
            <canvas id="photoExpChart"></canvas>
        </div>
    </div>

    {{-- Section 2: Workshop Topics & Camera Types --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <h6>หัวข้อ Workshop ที่ผู้ลงทะเบียนสนใจ</h6>
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อหัวข้อ</th>
                        <th>จำนวน</th>
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
        <div class="col-md-3">
            <h6>ประเภทกล้อง</h6>
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อกล้อง</th>
                        <th>จำนวน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cameraTypes as $camera => $count)
                    <tr>
                        <td class="text-start">{{ $camera }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <h6>แบรนด์ กล้อง/โทรศัพท์</h6>
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อแบรนด์</th>
                        <th>จำนวน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cameraBrandData  as $brand  => $count)
                    <tr>
                        <td class="text-start">{{ $brand  }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



</div>
{{-- Section 3: Detailed List --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h6>รายชื่อผู้ลงทะเบียน Full-Day Workshop</h6>
            <table class="table table-bordered table-striped">
                <thead class="table-light text-center">
                    <tr>
                        <th>เลขอ้างอิง</th>
                        <th>ชื่อ สกุล</th>
                        <th>ประเภทผู้ลงทะเบียน</th>
                        <th>Specialty</th>
                        <th>ประสบการณ์</th>
                        <th>ประเภทกล้อง</th>
                        <th>แบรนด์</th>
                        <th>Workshop Topics</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workshops as $reg)
                    <tr>
                        <td class="text-center">{{ $reg->transid }}</td>
                        <td>{{ $reg->full_name }}<br/>
                        <a href="mailto:{{ $reg->email }}" class="text-muted text-decoration-none">{{ $reg->email }}</a><br/>
                        <a href="tel:{{ $reg->mobile }}" class="text-muted text-decoration-none">{{ $reg->mobile }}</a></td>
                        <td>{!! $reg->registration_type_text  !!}</td>
                        <td>{!! $reg->specialty_text  !!}</td>
                        <td class="text-center">{!! $reg->photography_experience_text !!}</td>
                        <td>{!! $reg->camera_type_text  !!}</td>
                        <td class="text-center">{{ $reg->camera_brand  }}</td>
                        <td>{!! $reg->workshop_topics_text  !!}</td>
                        <td class="text-center">{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script>
function valueAndPercentFormatter(value, context) {
    const sum = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
    const percent = ((value / sum) * 100).toFixed(1);
    return `${value} ( ${percent}% )`;
}

// Registration Type (Doughnut)
const regTypeCtx = document.getElementById('registrationTypeChart').getContext('2d');
new Chart(regTypeCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($registrationTypes->keys()) !!},
        datasets: [{
            data: {!! json_encode($registrationTypes->values()) !!},
            backgroundColor: ['#B6D7A8', '#9FC5E8', '#F9CB9C'],
        }]
    },
    options: {
        plugins: {
            legend: { display: true, position: 'bottom' },
            datalabels: {
                color: '#000',
                font: { weight: 'bold', size: 14 },
                formatter: valueAndPercentFormatter
            }
        }
    },
    plugins: [ChartDataLabels]
});

// Country Doughnut Chart
const countryCtx = document.getElementById('countryChart').getContext('2d');
new Chart(countryCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($countries->keys()) !!}, // array ของ country
        datasets: [{
            data: {!! json_encode($countries->values()) !!}, // จำนวนผู้ลงทะเบียนแต่ละ country
            backgroundColor: [
                '#D2B4DE', '#F5B7B1', '#A3E4D7', '#F9E79F','#B6D7A8', '#9FC5E8', '#F9CB9C', '#EAD1DC', '#A9CCE3',
                '#F7DC6F', 
            ],
        }]
    },
    options: {
        plugins: {
            legend: { display: true, position: 'bottom' },
            datalabels: {
                color: '#000',
                font: { weight: 'bold', size: 14 },
                formatter: valueAndPercentFormatter
            }
        }
    },
    plugins: [ChartDataLabels]
});

// Specialty Pie
const specialtyCtx = document.getElementById('specialtyChart').getContext('2d');
new Chart(specialtyCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($specialties->keys()) !!},
        datasets: [{
            data: {!! json_encode($specialties->values()) !!},
            backgroundColor: ['#e8cf76','#a569b5', '#4dbf9f', '#5f8dce', '#94ba84', '#dba876', '#d65f5f','#6c757d'],
        }]
    },
    options: {
        plugins: {
            legend: { display: true, position: 'bottom' },
            datalabels: {
                color: '#000',
                font: { weight: 'bold', size: 14 },
                formatter: valueAndPercentFormatter
            }
        }
    },
    plugins: [ChartDataLabels]
});

// Photography Experience Pie
const photoExpCtx = document.getElementById('photoExpChart').getContext('2d');
new Chart(photoExpCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($photoExperiences->keys()) !!},
        datasets: [{
            data: {!! json_encode($photoExperiences->values()) !!},
            backgroundColor: ['#5f8dce', '#94ba84', '#dba876', '#d65f5f', '#a569b5', '#4dbf9f', '#f0c419', '#6c757d'],
        }]
    },
    options: {
        plugins: {
            legend: { display: true, position: 'bottom' },
            datalabels: {
                color: '#fff',
                font: { weight: 'bold', size: 14 },
                formatter: valueAndPercentFormatter
            }
        }
    },
    plugins: [ChartDataLabels]
});
</script>
@endsection
