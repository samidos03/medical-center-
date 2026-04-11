<?php
namespace App\Http\Controllers;
use App\Models\Ordonnance;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdonnanceController extends Controller
{
    public function pdf(Ordonnance $ordonnance)
    {
        $ordonnance->load([
            'consultation.patient.user',
            'consultation.medecin.user',
            'consultation.medecin.specialite',
        ]);
        $pdf = Pdf::loadView('pdf.ordonnance', compact('ordonnance'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('ordonnance-' . $ordonnance->id . '.pdf');
    }
}
