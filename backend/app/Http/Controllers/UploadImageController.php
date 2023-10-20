<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class UploadImageController extends Controller
{
    protected $storage;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(env('FIREBASE_CREDENTIALS_PATH'));
        $this->storage = $factory->createStorage();
    }

    public function uploadImage(Request $request)
    {
        // Validación de la imagen
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Obtener la imagen
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $bucket = $this->storage->getBucket();
        $bucket->upload(
            file_get_contents($image),
            [
                'name' => 'profile_pics/' . $imageName
            ]
        );

        // Obtener la URL pública de la imagen
        $imageURL = $bucket->object('profile_pics/' . $imageName)->signedUrl(new \DateTime('tomorrow'));

        // Devolver respuesta
        return response()->json(['success' => true, 'imageUrl' => $imageURL]);
    }
}
