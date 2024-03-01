<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Form;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Resources\ApiResource;
use App\Models\Prodi;
use App\Models\Wave;
use App\Models\Payment;
use App\Models\Health;
use App\Models\Interviews;

class DashboardController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function index(): ApiResource
    {

        $startDate = Carbon::now()->subMonth()->startOfMonth();

        $endDate = Carbon::now()->endOfMonth();

        $dataForm = Form::select(
            DB::raw('MONTH(is_paid_registration) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('is_paid_registration', [$startDate, $endDate])
            ->groupBy(DB::raw('MONTH(is_paid_registration)'))
            ->get();

        $dataUserRaw = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        $bulanArray = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $labels = [];
        $data = [];
        $dataUser = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulan = $bulanArray[$i];
            $total = 0;

            foreach ($dataForm as $pembayaran) {
                if ($pembayaran->month == $i) {
                    $total = $pembayaran->total;
                    break;
                }
            }

            $totalUser = 0;

            foreach ($dataUserRaw as $user) {
                if ($user->month == $i) {
                    $totalUser = $user->total;
                    break;
                }
            }

            $labels[] = $bulan;
            $data[] = $total;
            $dataUser[] = $totalUser;
        }

        $output = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'label' => 'Pembelian Formulir',
                    'backgroundColor' => '#3182CE',
                ],
                [
                    'data' => $dataUser,
                    'label' => 'Pendaftar',
                    'backgroundColor' => '#9F7AEA',
                ],
            ]
        ];
        return new ApiResource(200, 'OK', [
            'chart' => $output,
            'count' => [
                'forms' => Form::count(),
                'users' => User::count(),
                'prodi' => Prodi::where('status', 1)->count(),
                'wave' => Wave::getActiveData()->count(),
                'validation' => [
                    'forms' => Form::where('status', 'submitted')->count(),
                    'graduation' => Form::where('end_status', 'submitted')->count(),
                    'payment' => Payment::where('status', 'pending')->count(),
                    'medical_check' => Health::where('status', 'waiting')->count(),
                    'interview' => Interviews::where('status', 'pending')->count(),
                ]
            ]
        ]);
    }
}
