// public/js/admin-dashboard.js

document.addEventListener('DOMContentLoaded', function () {

    const revenue = document.getElementById('revenueChart');

    if (revenue) {

        new Chart(revenue, {
            type: 'bar',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [20000,35000,50000,42000,61000,37000],
                    borderWidth: 1
                }]
            }
        });

    }

    const category = document.getElementById('categoryChart');

    if (category) {

        new Chart(category, {
            type: 'doughnut',
            data: {
                labels: ['Fashion','Travel','Office','Luxury'],
                datasets: [{
                    data: [45,25,18,12]
                }]
            }
        });

    }

});