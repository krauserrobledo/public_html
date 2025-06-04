<?php
namespace App\Http\Controllers\Web;
use Illuminate\Support\Facades\Http;
class AdminController extends Controller
{
    private $apiUrl;
    public function __construct()
    {
        $this->apiUrl = config('app.api_url');
    }
    public function indexAutocaravanas()
{
    $response = Http::withToken(session('access_token'))
        ->withQueryParameters(['per_page' => 10]) // ← Paginación
        ->get("{$this->apiUrl}/api/admin/autocaravanas");
    if ($response->failed()) {
        abort(500, 'Error al obtener autocaravanas');
    }
    return view('admin.autocaravanas', [
        'autocaravanas' => $response->json()['data'] ?? $response->json()
    ]);
}
    public function indexReservas()
    {
        $response = Http::withToken(session('access_token'))
            ->get("{$this->apiUrl}/api/admin/reservas");
        return view('admin.reservas', [
            'reservas' => $response->json()
        ]);
    }
}