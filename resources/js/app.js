import './bootstrap';

// Add any additional JavaScript functionality here
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltips = document.querySelectorAll('.tooltip');
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', function() {
            this.querySelector('.tooltiptext').style.visibility = 'visible';
            this.querySelector('.tooltiptext').style.opacity = '1';
        });
        tooltip.addEventListener('mouseleave', function() {
            this.querySelector('.tooltiptext').style.visibility = 'hidden';
            this.querySelector('.tooltiptext').style.opacity = '0';
        });
    });

    // Handle form reset
    const form = document.getElementById('calculatorForm');
    const resetButton = form.querySelector('button[type="reset"]');
    const results = document.getElementById('results');

    resetButton.addEventListener('click', function() {
        results.classList.add('hidden');
        if (window.growthChart) {
            window.growthChart.destroy();
        }
    });

    // Add input validation
    const inputs = form.querySelectorAll('input[type="number"]');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    });
});
