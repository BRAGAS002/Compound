<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Compound Interest Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Compound Interest Calculator</h1>
                <button id="darkModeToggle" class="p-3 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-moon dark:hidden text-xl"></i>
                    <i class="fas fa-sun hidden dark:block text-xl"></i>
                </button>
            </div>

            <!-- Tab Navigation -->
            <div class="mb-8">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button id="calculatorTab" class="tab-button active border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg">
                            Calculator
                        </button>
                        <button id="historyTab" class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg">
                            History
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Calculator Tab Content -->
            <div id="calculatorContent" class="tab-content">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-8">
                    <form id="calculatorForm" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Principal Amount
                                    <span class="text-gray-500 text-sm">(e.g., 1000)</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 text-lg">₱</span>
                                    <input type="number" name="principal" class="pl-12 w-full rounded-lg border-2 border-black shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white text-black text-lg p-4" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Annual Interest Rate (%)
                                    <span class="text-gray-500 text-sm">(e.g., 5)</span>
                                </label>
                                <input type="number" name="rate" step="0.01" class="w-full rounded-lg border-2 border-black shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white text-black text-lg p-4" required>
                            </div>

                            <div>
                                <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Time Duration (Years)
                                    <span class="text-gray-500 text-sm">(e.g., 2.5)</span>
                                </label>
                                <input type="number" name="time" step="0.01" class="w-full rounded-lg border-2 border-black shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white text-black text-lg p-4" required>
                            </div>

                            <div>
                                <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Compounding Frequency
                                </label>
                                <select name="compounding_frequency" class="w-full rounded-lg border-2 border-black shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white text-black text-lg p-4" required>
                                    <option value="annually">Annually</option>
                                    <option value="semi-annually">Semi-annually</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="daily">Daily</option>
                                    <option value="continuously">Continuously</option>
                                </select>
                            </div>

                            <div>
                                <div class="flex items-center mb-3">
                                    <input type="checkbox" id="enableDate" class="rounded border-2 border-black text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 h-5 w-5">
                                    <label for="enableDate" class="ml-3 block text-lg font-medium text-gray-700 dark:text-gray-300">
                                        Include Start Date
                                    </label>
                                </div>
                                <div id="dateInputContainer" class="hidden">
                                    <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        Start Date
                                    </label>
                                    <input type="date" name="start_date" class="w-full rounded-lg border-2 border-black shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white text-black text-lg p-4">
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 text-lg font-medium">
                                Calculate
                            </button>
                            <button type="reset" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-300 text-lg font-medium">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>

                <div id="results" class="hidden bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Results</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Final Amount</h3>
                            <p id="finalAmount" class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">₱0.00</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Total Interest Earned</h3>
                            <p id="totalInterest" class="text-4xl font-bold text-green-600 dark:text-green-400">₱0.00</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Formula Used</h3>
                        <p id="formula" class="text-gray-600 dark:text-gray-400 text-lg"></p>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Breakdown by Period</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-lg font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Period</th>
                                        <th class="px-6 py-4 text-left text-lg font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-4 text-left text-lg font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-4 text-left text-lg font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Interest</th>
                                    </tr>
                                </thead>
                                <tbody id="breakdownTable" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="h-96">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- History Tab Content -->
            <div id="historyContent" class="tab-content hidden">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Calculation History</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-lg font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-lg font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Final Amount</th>
                                    <th class="px-6 py-4 text-left text-lg font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($history as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-500 dark:text-gray-400">{{ $record->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-500 dark:text-gray-400">
                                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">₱{{ number_format($record->final_amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-500 dark:text-gray-400">
                                        <div class="flex space-x-4">
                                            <button onclick="showCalculationDetails({{ $record->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                <i class="fas fa-eye text-xl"></i>
                                            </button>
                                            <button onclick="deleteCalculation({{ $record->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <i class="fas fa-trash text-xl"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Calculation Details Modal -->
            <div id="calculationDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Calculation Details</h3>
                        <button onclick="closeCalculationDetails()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div id="calculationDetailsContent" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Principal</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-principal"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Start Date</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-start-date"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Rate</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-rate"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Time</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-time"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Compounding Frequency</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-frequency"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Final Amount</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-final-amount"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Interest</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-total-interest"></p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Formula Used</h4>
                            <p class="text-gray-900 dark:text-white" id="modal-formula"></p>
                        </div>
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Breakdown by Period</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Period</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Interest</th>
                                        </tr>
                                    </thead>
                                    <tbody id="breakdown-table" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form persistence
        const form = document.getElementById('calculatorForm');
        const formFields = ['principal', 'rate', 'time', 'compounding_frequency'];
        const enableDateCheckbox = document.getElementById('enableDate');
        const dateInputContainer = document.getElementById('dateInputContainer');
        const dateInput = document.querySelector('input[name="start_date"]');

        // Set today's date as default
        function setTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            dateInput.value = `${year}-${month}-${day}`;
        }

        // Toggle date input visibility
        function toggleDateInput() {
            if (enableDateCheckbox.checked) {
                dateInputContainer.classList.remove('hidden');
                setTodayDate();
                formFields.push('start_date');
            } else {
                dateInputContainer.classList.add('hidden');
                dateInput.value = '';
                formFields.pop(); // Remove start_date from formFields
            }
            saveFormData();
        }

        // Add event listener for date toggle
        enableDateCheckbox.addEventListener('change', toggleDateInput);

        // Save form data to localStorage
        function saveFormData() {
            const formData = {};
            formFields.forEach(field => {
                formData[field] = form[field].value;
            });
            formData['enableDate'] = enableDateCheckbox.checked;
            localStorage.setItem('calculatorFormData', JSON.stringify(formData));
        }

        // Load form data from localStorage
        function loadFormData() {
            const savedData = localStorage.getItem('calculatorFormData');
            if (savedData) {
                const formData = JSON.parse(savedData);
                formFields.forEach(field => {
                    if (formData[field]) {
                        form[field].value = formData[field];
                    }
                });
                if (formData['enableDate']) {
                    enableDateCheckbox.checked = true;
                    toggleDateInput();
                }
            }
        }

        // Clear form data from localStorage
        function clearFormData() {
            localStorage.removeItem('calculatorFormData');
            form.reset();
            enableDateCheckbox.checked = false;
            dateInputContainer.classList.add('hidden');
            formFields.length = 4; // Reset to original fields
        }

        // Add event listeners
        formFields.forEach(field => {
            form[field].addEventListener('input', saveFormData);
        });

        // Load saved data on page load
        document.addEventListener('DOMContentLoaded', loadFormData);

        // Clear form data when reset button is clicked
        document.querySelector('button[type="reset"]').addEventListener('click', clearFormData);

        // Dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;

        if (localStorage.getItem('darkMode') === 'true') {
            html.classList.add('dark');
        }

        darkModeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        });

        // Tab switching
        const calculatorTab = document.getElementById('calculatorTab');
        const historyTab = document.getElementById('historyTab');
        const calculatorContent = document.getElementById('calculatorContent');
        const historyContent = document.getElementById('historyContent');

        // Save and restore active tab
        function saveActiveTab(tab) {
            localStorage.setItem('activeTab', tab);
        }

        function loadActiveTab() {
            const activeTab = localStorage.getItem('activeTab') || 'calculator';
            if (activeTab === 'history') {
                historyTab.click();
            } else {
                calculatorTab.click();
            }
        }

        calculatorTab.addEventListener('click', () => {
            calculatorTab.classList.add('active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            calculatorTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            historyTab.classList.remove('active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            historyTab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            calculatorContent.classList.remove('hidden');
            historyContent.classList.add('hidden');
            saveActiveTab('calculator');
        });

        historyTab.addEventListener('click', () => {
            historyTab.classList.add('active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            historyTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            calculatorTab.classList.remove('active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            calculatorTab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            historyContent.classList.remove('hidden');
            calculatorContent.classList.add('hidden');
            saveActiveTab('history');
        });

        // Load active tab on page load
        document.addEventListener('DOMContentLoaded', loadActiveTab);

        // Form submission
        const results = document.getElementById('results');
        const finalAmount = document.getElementById('finalAmount');
        const totalInterest = document.getElementById('totalInterest');
        const formula = document.getElementById('formula');
        const breakdownTable = document.getElementById('breakdownTable');
        let growthChart = null;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Calculating...
            `;
            
            try {
                const response = await fetch('/calculate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        principal: parseFloat(form.principal.value),
                        rate: parseFloat(form.rate.value),
                        time: parseFloat(form.time.value),
                        compounding_frequency: form.compounding_frequency.value,
                        start_date: form.start_date.value || null
                    })
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'An error occurred while calculating');
                }

                // Update results
                finalAmount.textContent = `₱${data.finalAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                totalInterest.textContent = `₱${data.totalInterest.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                formula.textContent = data.formula;

                // Update breakdown table
                breakdownTable.innerHTML = data.breakdown.map(row => `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Year ${row.period}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${row.date || 'N/A'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">₱${row.amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">₱${row.interest.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    </tr>
                `).join('');

                // Update chart
                if (growthChart) {
                    growthChart.destroy();
                }

                const ctx = document.getElementById('growthChart').getContext('2d');
                growthChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.breakdown.map(row => `Year ${row.period}`),
                        datasets: [{
                            label: 'Total Amount',
                            data: data.breakdown.map(row => row.amount),
                            borderColor: 'rgb(79, 70, 229)',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: 'rgb(79, 70, 229)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14,
                                        family: "'Inter', sans-serif"
                                    },
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: {
                                    size: 14,
                                    family: "'Inter', sans-serif"
                                },
                                bodyFont: {
                                    size: 14,
                                    family: "'Inter', sans-serif"
                                },
                                callbacks: {
                                    label: function(context) {
                                        return `₱${context.parsed.y.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: true,
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        family: "'Inter', sans-serif"
                                    },
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        family: "'Inter', sans-serif"
                                    },
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151',
                                    callback: function(value) {
                                        return '₱' + value.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0});
                                    }
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });

                // Show results
                results.classList.remove('hidden');

                // Refresh history tab
                const historyResponse = await fetch('/');
                const historyHtml = await historyResponse.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(historyHtml, 'text/html');
                const newHistoryContent = doc.getElementById('historyContent');
                if (newHistoryContent) {
                    historyContent.innerHTML = newHistoryContent.innerHTML;
                }
            } catch (error) {
                showNotification(error.message, 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }
        });

        // Calculation details functions
        function showCalculationDetails(id) {
            fetch(`/calculation/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to load calculation details');
                    }

                    document.getElementById('modal-principal').textContent = `₱${data.principal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                    document.getElementById('modal-start-date').textContent = data.start_date ? new Date(data.start_date).toLocaleDateString('en-US', { 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    }) : 'N/A';
                    document.getElementById('modal-rate').textContent = `${parseFloat(data.rate).toFixed(2)}%`;
                    document.getElementById('modal-time').textContent = `${data.time} years`;
                    document.getElementById('modal-frequency').textContent = data.compounding_frequency;
                    document.getElementById('modal-final-amount').textContent = `₱${data.final_amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                    document.getElementById('modal-total-interest').textContent = `₱${data.total_interest.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                    document.getElementById('modal-formula').textContent = data.formula;
                    
                    const breakdownTable = document.getElementById('breakdown-table');
                    breakdownTable.innerHTML = '';
                    
                    data.breakdown.forEach(period => {
                        const row = breakdownTable.insertRow();
                        row.insertCell(0).textContent = period.period;
                        row.insertCell(1).textContent = period.date ? new Date(period.date).toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        }) : 'N/A';
                        row.insertCell(2).textContent = `₱${period.amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                        row.insertCell(3).textContent = `₱${period.interest.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                    });
                    
                    const modal = document.getElementById('calculationDetailsModal');
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    showNotification(error.message, 'error');
                });
        }

        function closeCalculationDetails() {
            const modal = document.getElementById('calculationDetailsModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Delete calculation
        async function deleteCalculation(id) {
            if (!confirm('Are you sure you want to delete this calculation?')) {
                return;
            }

            try {
                const response = await fetch(`/calculation/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'Failed to delete calculation');
                }

                // Refresh history tab
                const historyResponse = await fetch('/');
                const historyHtml = await historyResponse.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(historyHtml, 'text/html');
                const newHistoryContent = doc.getElementById('historyContent');
                if (newHistoryContent) {
                    historyContent.innerHTML = newHistoryContent.innerHTML;
                }

                // Show success message
                showNotification('Calculation deleted successfully', 'success');
            } catch (error) {
                showNotification(error.message, 'error');
            }
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                'bg-blue-500'
            } text-white`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Add hover effects to table rows
        document.addEventListener('DOMContentLoaded', () => {
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', () => {
                    row.classList.add('bg-gray-50', 'dark:bg-gray-700');
                });
                row.addEventListener('mouseleave', () => {
                    row.classList.remove('bg-gray-50', 'dark:bg-gray-700');
                });
            });
        });
    </script>
</body>
</html> 