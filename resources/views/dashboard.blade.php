<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Start card data --}}
            @if (Auth::user()->hasRole('super-admin'))
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 mb-5">
                <div class="px-4 py-5 bg-yellow-600 text-white rounded">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-2xl">{{$totalProducts}}</p>
                            Products
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 bg-blue-600 text-white rounded">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-2xl">{{ $totalTransactions }}</p>
                            Transactions
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 bg-indigo-600 text-white rounded">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-2xl">{{ $totalShops }}</p>
                            Shops
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-store fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 bg-purple-600 text-white rounded">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-2xl">{{ $totalCustomers }}</p>
                            Customers
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (Auth::user()->hasRole('seller'))
            <div class="grid grid-cols-4 lg:grid-cols-6 gap-2 mb-5">
                <div class="px-4 py-5 col-start-3 grid-cols-2 bg-yellow-600 text-white rounded">
                    <div class="flex">
                        <div>
                            <p class="text-2xl">{{$totalProducts}}</p>
                            Products
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 grid-cols-2 bg-blue-600 text-white rounded">
                    <div class="flex">
                        <div>
                            <p class="text-2xl">{{ $totalTransactions }}</p>
                            Transactions
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- End card data --}}

        </div>
    </div>
    @push('js')
    <!-- chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.min.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                datasets: [{
                    label: 'Income ($)',
                    data: [120, 82, 55, 72, 50, 99, 181],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
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

        var ctx = document.getElementById('doughnutChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
            labels: [
                'Red',
                'Blue',
                'Yellow'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
            }
        });

        var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Edge', 'Mozilla', 'Chrome'],
                datasets: [{
                    label: 'Income',
                    data: [5, 10, 15],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
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
</x-app-layout>