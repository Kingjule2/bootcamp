<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
    {{-- Chart 1: Porsi Disalurkan --}}
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 0.875rem; font-weight: 700; margin: 0;">Total Porsi (Minggu Ini)</h3>
        </div>
        <div class="card-body">
            <canvas id="chartPorsi" style="max-height: 220px;"></canvas>
        </div>
    </div>

    {{-- Chart 2: Rating Kepuasan --}}
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 0.875rem; font-weight: 700; margin: 0;">Rating Kepuasan</h3>
        </div>
        <div class="card-body">
            <canvas id="chartRating" style="max-height: 220px;"></canvas>
        </div>
    </div>

    {{-- Chart 3: Food Waste --}}
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 0.875rem; font-weight: 700; margin: 0;">Persentase Food Waste</h3>
        </div>
        <div class="card-body">
            <canvas id="chartWaste" style="max-height: 220px;"></canvas>
        </div>
    </div>
</div>
