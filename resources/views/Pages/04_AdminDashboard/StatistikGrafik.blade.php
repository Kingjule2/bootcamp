<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;"
     x-data="{ chartData: @js($chartData) }"
     x-init="
        $nextTick(() => {
            if (typeof Chart === 'undefined') return;

            // Destroy existing charts if any
            ['chartPorsi', 'chartRating', 'chartWaste'].forEach(id => {
                const existing = Chart.getChart(id);
                if (existing) existing.destroy();
            });

            const porsiEl = document.getElementById('chartPorsi');
            if (porsiEl) {
                new Chart(porsiEl, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Porsi',
                            data: chartData.porsi,
                            backgroundColor: 'rgba(16, 185, 129, 0.6)',
                            borderColor: 'rgb(5, 150, 105)',
                            borderWidth: 2,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
                    }
                });
            }

            const ratingEl = document.getElementById('chartRating');
            if (ratingEl) {
                new Chart(ratingEl, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Rating',
                            data: chartData.rating,
                            borderColor: 'rgb(245, 158, 11)',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(245, 158, 11)',
                            pointRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { display: false } },
                        scales: { y: { min: 0, max: 5, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
                    }
                });
            }

            const wasteEl = document.getElementById('chartWaste');
            if (wasteEl) {
                const totalWaste = chartData.waste.reduce((a, b) => a + b, 0);
                const avgWaste = chartData.waste.length > 0 ? (totalWaste / chartData.waste.filter(v => v > 0).length || 0) : 0;
                new Chart(wasteEl, {
                    type: 'doughnut',
                    data: {
                        labels: ['Food Waste', 'Terkonsumsi'],
                        datasets: [{
                            data: [avgWaste.toFixed(1), (100 - avgWaste).toFixed(1)],
                            backgroundColor: ['rgba(239, 68, 68, 0.6)', 'rgba(16, 185, 129, 0.6)'],
                            borderColor: ['rgb(220, 38, 38)', 'rgb(5, 150, 105)'],
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { position: 'bottom', labels: { font: { size: 11 } } }
                        },
                        cutout: '65%',
                    }
                });
            }
        });
     "
>
    {{-- Chart 1: Porsi Disalurkan --}}
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 0.875rem; font-weight: 700; margin: 0;">Total Porsi (Minggu Ini)</h3>
        </div>
        <div class="card-body" wire:ignore>
            <canvas id="chartPorsi" style="max-height: 220px;"></canvas>
        </div>
    </div>

    {{-- Chart 2: Rating Kepuasan --}}
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 0.875rem; font-weight: 700; margin: 0;">Rating Kepuasan</h3>
        </div>
        <div class="card-body" wire:ignore>
            <canvas id="chartRating" style="max-height: 220px;"></canvas>
        </div>
    </div>

    {{-- Chart 3: Food Waste --}}
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 0.875rem; font-weight: 700; margin: 0;">Persentase Food Waste</h3>
        </div>
        <div class="card-body" wire:ignore>
            <canvas id="chartWaste" style="max-height: 220px;"></canvas>
        </div>
    </div>
</div>
