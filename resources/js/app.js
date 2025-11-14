import './bootstrap';

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import 'chartjs-adapter-date-fns';

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();

// Chart.js default configuration
Chart.defaults.color = '#9ca3af'; // gray-400
Chart.defaults.borderColor = '#2a2a2a';
Chart.defaults.backgroundColor = 'rgba(156, 163, 175, 0.1)';

// Global function to initialize Mito-Age chart
window.initMitoAgeChart = function(labels, data) {
    const ctx = document.getElementById('mitoAgeChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Mito-Age Score',
                data: data,
                borderColor: '#d1d1d1',
                backgroundColor: 'rgba(209, 209, 209, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#d1d1d1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: '#141414',
                    borderColor: '#2a2a2a',
                    borderWidth: 1,
                    titleColor: '#d1d1d1',
                    bodyColor: '#9ca3af',
                    padding: 12,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 0,
                    max: 10,
                    ticks: {
                        stepSize: 1,
                        color: '#9ca3af'
                    },
                    grid: {
                        color: '#2a2a2a',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#9ca3af',
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
};

// Global function to initialize all metrics chart
window.initMetricsChart = function(labels, datasets) {
    const ctx = document.getElementById('metricsChart');
    if (!ctx) return;

    const colors = {
        energy: { border: '#4ade80', bg: 'rgba(74, 222, 128, 0.1)' },
        focus: { border: '#60a5fa', bg: 'rgba(96, 165, 250, 0.1)' },
        sleep: { border: '#c084fc', bg: 'rgba(192, 132, 252, 0.1)' },
        gut_health: { border: '#fb923c', bg: 'rgba(251, 146, 60, 0.1)' },
        skin_glow: { border: '#f472b6', bg: 'rgba(244, 114, 182, 0.1)' }
    };

    const chartDatasets = Object.keys(datasets).map(key => ({
        label: key.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' '),
        data: datasets[key],
        borderColor: colors[key].border,
        backgroundColor: colors[key].bg,
        borderWidth: 2,
        fill: false,
        tension: 0.4,
        pointRadius: 3,
        pointHoverRadius: 5,
        pointBackgroundColor: colors[key].border,
        pointBorderColor: '#fff',
        pointBorderWidth: 1,
    }));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: chartDatasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#9ca3af',
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: '#141414',
                    borderColor: '#2a2a2a',
                    borderWidth: 1,
                    titleColor: '#d1d1d1',
                    bodyColor: '#9ca3af',
                    padding: 12
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 0,
                    max: 10,
                    ticks: {
                        stepSize: 1,
                        color: '#9ca3af'
                    },
                    grid: {
                        color: '#2a2a2a',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#9ca3af',
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
};
