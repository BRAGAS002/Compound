# Compound Interest Calculator

A modern, user-friendly compound interest calculator built with Laravel. This application helps users calculate compound interest with various compounding frequencies and provides detailed breakdowns of their investments.

## Features

- 🎨 Modern, responsive design with dark mode support
- 🔢 Input fields for principal amount, interest rate, time duration, and compounding frequency
- 📊 Detailed results including final amount, total interest, and period-by-period breakdown
- 📈 Interactive growth chart visualization
- 💡 Tooltips and helpful examples
- 🔄 Reset functionality
- 📱 Mobile-friendly interface

## Requirements

- PHP >= 8.1
- Composer
- Node.js and NPM
- Laravel 10.x

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/compound-interest-calculator.git
cd compound-interest-calculator
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create a copy of the .env file:
```bash
cp .env.example .env
```

5. Generate an application key:
```bash
php artisan key:generate
```

6. Build the assets:
```bash
npm run build
```

7. Start the development server:
```bash
php artisan serve
```

## Usage

1. Open your browser and navigate to `http://localhost:8000`
2. Enter the principal amount
3. Input the annual interest rate
4. Specify the time duration in years
5. Select the compounding frequency
6. Click "Calculate" to see the results

## Features in Detail

### Input Fields
- **Principal Amount**: Enter the initial investment amount
- **Annual Interest Rate**: Input the yearly interest rate as a percentage
- **Time Duration**: Specify the investment period in years
- **Compounding Frequency**: Choose from various compounding options:
  - Annually
  - Semi-annually
  - Quarterly
  - Monthly
  - Weekly
  - Daily
  - Continuously

### Results Display
- Final Amount
- Total Interest Earned
- Formula Used
- Period-by-Period Breakdown
- Interactive Growth Chart

### Additional Features
- Dark Mode Toggle
- Responsive Design
- Input Validation
- Reset Functionality
- Tooltips with Examples

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the LICENSE file for details.
