<?php

namespace App\Http\Controllers;

use App\Models\CalculationHistory;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        $history = CalculationHistory::orderBy('created_at', 'desc')->get();
        return view('calculator.index', compact('history'));
    }

    public function calculate(Request $request)
    {
        try {
            $validated = $request->validate([
                'principal' => 'required|numeric|min:0',
                'rate' => 'required|numeric|min:0',
                'time' => 'required|numeric|min:0',
                'compounding_frequency' => 'required|in:annually,semi-annually,quarterly,monthly,weekly,daily,continuously',
                'start_date' => 'nullable|date'
            ]);

            $principal = $validated['principal'];
            $rate = $validated['rate'];
            $time = $validated['time'];
            $frequency = $validated['compounding_frequency'];
            $startDate = isset($validated['start_date']) ? $validated['start_date'] : null;

            $periods = $this->getCompoundingPeriods($frequency);
            $formula = $this->getFormula($frequency);
            
            // Calculate final amount
            $r = $rate / 100;
            if ($frequency === 'continuously') {
                $finalAmount = $principal * exp($r * $time);
            } else {
                $finalAmount = $principal * pow(1 + ($r / $periods), $periods * $time);
            }

            $totalInterest = $finalAmount - $principal;
            $breakdown = $this->calculateBreakdown($principal, $rate, $time, $frequency, $startDate);

            // Save calculation history
            $calculation = CalculationHistory::create([
                'principal' => $principal,
                'rate' => $rate,
                'time' => $time,
                'compounding_frequency' => $frequency,
                'start_date' => $startDate,
                'final_amount' => $finalAmount,
                'total_interest' => $totalInterest
            ]);

            return response()->json([
                'success' => true,
                'finalAmount' => $finalAmount,
                'totalInterest' => $totalInterest,
                'formula' => $formula,
                'breakdown' => $breakdown,
                'start_date' => $startDate
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show($id)
    {
        try {
            $calculation = CalculationHistory::findOrFail($id);
            
            $principal = $calculation->principal;
            $rate = $calculation->rate / 100;
            $time = $calculation->time;
            $frequency = $calculation->compounding_frequency;
            
            $periods = $this->getCompoundingPeriods($frequency);
            $formula = $this->getFormula($frequency);
            $breakdown = $this->calculateBreakdown($principal, $rate, $time, $frequency, $calculation->start_date);
            
            return response()->json([
                'success' => true,
                'principal' => $calculation->principal,
                'rate' => $calculation->rate,
                'time' => $calculation->time,
                'compounding_frequency' => $calculation->compounding_frequency,
                'start_date' => $calculation->start_date,
                'final_amount' => $calculation->final_amount,
                'total_interest' => $calculation->total_interest,
                'formula' => $formula,
                'breakdown' => $breakdown
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $calculation = CalculationHistory::findOrFail($id);
            $calculation->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Calculation deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    private function getCompoundingPeriods($frequency)
    {
        return match ($frequency) {
            'annually' => 1,
            'semi-annually' => 2,
            'quarterly' => 4,
            'monthly' => 12,
            'weekly' => 52,
            'daily' => 365,
            'continuously' => null,
        };
    }

    private function getFormula($frequency)
    {
        if ($frequency === 'continuously') {
            return 'A = P × e^(rt)';
        }
        return 'A = P × (1 + r/n)^(nt)';
    }

    private function calculateBreakdown($principal, $rate, $time, $compounding_frequency, $startDate = null)
    {
        $breakdown = [];
        $n = $this->getCompoundingPeriods($compounding_frequency);
        $r = $rate / 100;
        $currentDate = $startDate ? new \DateTime($startDate) : null;

        // Calculate amount for each year
        for ($year = 1; $year <= $time; $year++) {
            // Calculate amount at the end of this year
            if ($compounding_frequency === 'continuously') {
                $amount = $principal * exp($r * $year);
                $previousAmount = $principal * exp($r * ($year - 1));
            } else {
                $amount = $principal * pow(1 + ($r / $n), $n * $year);
                $previousAmount = $principal * pow(1 + ($r / $n), $n * ($year - 1));
            }

            // Calculate interest earned this year
            $interest = $amount - $previousAmount;

            $date = null;
            if ($currentDate) {
                $date = clone $currentDate;
                $date->add(new \DateInterval("P" . ($year * 365) . "D"));
            }

            $breakdown[] = [
                'period' => $year,
                'amount' => $amount,
                'interest' => $interest,
                'date' => $date ? $date->format('Y-m-d') : null
            ];
        }

        return $breakdown;
    }
} 