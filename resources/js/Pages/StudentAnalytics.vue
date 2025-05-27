<template>
    <Head title="Student Analytics" />
    <div class="analytics-container">
        <!-- Summary Cards -->
        <div class="stats-grid">
            <div v-for="(stat, index) in summaryStats" :key="index" class="stat-card">
                <h3>{{ stat.title }}</h3>
                <p class="stat-number">{{ stat.value }}</p>
                <p v-if="stat.percentage" class="stat-percentage">{{ stat.percentage }}%</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <div class="chart-card">
                <h3>Socio Demographic</h3>
                <div class="total-label">
                    <span class="total-number">{{ stats.total }}</span>
                    <span class="total-text">Total</span>
                </div>
                <canvas ref="socioChart"></canvas>
            </div>
            <div class="chart-card">
                <h3>Location Distribution</h3>
                <canvas ref="locationChart"></canvas>
            </div>
            <div class="chart-card">
                <h3>Transportation Mode</h3>
                <canvas ref="transportChart"></canvas>
            </div>
            <div class="chart-card">
                <h3>Family Income Distribution</h3>
                <canvas ref="incomeChart"></canvas>
            </div>
        </div>

        <!-- Location Stats Table -->
        <div class="data-table">
            <h3>Location Statistics</h3>
            <table>
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Total Students</th>
                        <th>Avg. Income Bracket</th>
                        <th>Avg. Household Size</th>
                        <th>Avg. Travel Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="stat in locationStats" :key="stat.city">
                        <td>{{ stat.city }}</td>
                        <td>{{ stat.total }}</td>
                        <td>{{ stat.avgIncomeBracket }}</td>
                        <td>{{ stat.avgHouseholdSize }}</td>
                        <td>{{ stat.avgTravelTime }} mins</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import Chart from 'chart.js/auto';

const props = defineProps({
    stats: Object,
    locationStats: Array
});

// Chart references
const socioChart = ref(null);
const locationChart = ref(null);
const transportChart = ref(null);
const incomeChart = ref(null);

// Stats data
const stats = ref({
    total: 0,
    byGender: { male: 0, female: 0, other: 0 },
    byTransport: {},
    byIncome: {},
    socioDemo: {
        indigenous: 0,
        pwd: 0,
        renting: 0,
        regular: 0
    }
});

// Computed properties
const summaryStats = computed(() => [
    { title: 'Total Students', value: stats.value.total },
    { 
        title: 'Male Students', 
        value: stats.value.byGender.male,
        percentage: ((stats.value.byGender.male / stats.value.total) * 100).toFixed(1)
    },
    { 
        title: 'Female Students', 
        value: stats.value.byGender.female,
        percentage: ((stats.value.byGender.female / stats.value.total) * 100).toFixed(1)
    },
    { 
        title: 'Avg Travel Time', 
        value: stats.value.avgTravelTime + ' mins'
    }
]);

onMounted(async () => {
    try {
        const response = await fetch('/analytics/demographics');
        const data = await response.json();
        
        // Update stats
        stats.value = {
            total: data.totalStudents,
            byGender: data.genderStats,
            byTransport: data.transportStats,
            byIncome: data.incomeStats,
            avgTravelTime: data.avgTravelTime,
            socioDemo: {
                indigenous: data.indigenousCount || 0,
                pwd: data.pwdCount || 0,
                renting: data.rentingCount || 0,
                regular: data.totalStudents - (data.indigenousCount + data.pwdCount + data.rentingCount)
            }
        };

        // Initialize socio-demographic chart
        new Chart(socioChart.value, {
            type: 'doughnut',
            data: {
                labels: ['Indigenous', 'PWD', 'Renting', 'Regular'],
                datasets: [{
                    data: [
                        stats.value.socioDemo.indigenous,
                        stats.value.socioDemo.pwd,
                        stats.value.socioDemo.renting,
                        stats.value.socioDemo.regular
                    ],
                    backgroundColor: [
                        '#4CAF50',  // Green for Indigenous
                        '#2196F3',  // Blue for PWD
                        '#FFC107',  // Yellow for Renting
                        '#64B5F6'   // Light blue for Regular
                    ],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });

        // Initialize location chart
        new Chart(locationChart.value, {
            type: 'pie',
            data: {
                labels: data.locationStats.map(stat => stat.city),
                datasets: [{
                    data: data.locationStats.map(stat => stat.total),
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Initialize transportation chart
        new Chart(transportChart.value, {
            type: 'doughnut',
            data: {
                labels: Object.keys(data.transportStats),
                datasets: [{
                    data: Object.values(data.transportStats),
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Initialize income chart
        new Chart(incomeChart.value, {
            type: 'bar',
            data: {
                labels: Object.keys(data.incomeStats),
                datasets: [{
                    label: 'Number of Students',
                    data: Object.values(data.incomeStats),
                    backgroundColor: '#4e73df',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    } catch (error) {
        console.error('Error fetching analytics data:', error);
    }
});
</script>

<style scoped>
.analytics-container { padding: 20px; }
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card, .chart-card, .data-table {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.stat-number {
    font-size: 24px;
    font-weight: bold;
    color: #4e73df;
    margin: 10px 0;
}
.stat-percentage { color: #858796; font-size: 14px; }
.data-table { overflow-x: auto; }
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e3e6f0;
}
th { background-color: #f8f9fc; font-weight: bold; }
tr:hover { background-color: #f8f9fc; }
.total-label {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    pointer-events: none;
}
.total-number {
    display: block;
    font-size: 24px;
    font-weight: bold;
    color: #2D3748;
}
.total-text {
    display: block;
    font-size: 14px;
    color: #718096;
}
.chart-card {
    position: relative;
}
</style>
