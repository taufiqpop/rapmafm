@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal'];
@endphp

@section('contents')
    <div class="container">
        <div class="row">
            <!-- Nominal data -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Jumlah Crew Aktif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $crew->count() }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Jumlah Pengurus Aktif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $pengurus->count() }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Jumlah Alumni
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $alumni->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="row mt-5">
            <div class="col-md-12">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let ctx = document.getElementById('myChart').getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Crew', 'Pengurus', 'Alumni'],
                datasets: [{
                    label: 'Data Count',
                    data: [{{ $crew->count() }}, {{ $pengurus->count() }}, {{ $alumni->count() }}],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
