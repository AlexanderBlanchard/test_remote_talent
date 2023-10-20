<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Services\EmailService;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{

    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function procesarInformacion(Request $request)
    {
        $data = $request->only(['nombre', 'apellidos', 'telefono', 'correo', 'imagen']);
        $data = $request->validate([
            'nombre' => 'nullable|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:50',
            'imagen' => 'nullable|string|string'
        ]);
        // Comprobar si estos datos ya existen en la base de datos
        $exists = UserProfile::where($data)->exists();

        if (!$exists) {
            UserProfile::create($data);
            $this->emailService->sendEmail($data['correo']);
        }

        #crear url
        $baseURL = url('/profile?');
        $baseURL = str_replace(':8001', ':8080', $baseURL);
        $params = http_build_query($data);
        $generatedURL = $baseURL . $params;

        return response()->json(['success' => true, 'url' => $generatedURL]);
    }
}
