<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmprestaRequests;
use App\Http\Services\Api\EmprestaApiService;

class EmprestaApi extends Controller
{
    private $emprestaApiService;

    public function __construct(EmprestaApiService $emprestaApiService)
    {
        $this->emprestaApiService = $emprestaApiService;
    }

    public function instituicoes(Request $request)
    {
        try {
            $data = $this->emprestaApiService->instituicoesService();

            return Response()->json($data);
        } catch (\Exception $e) {
            return Response()->json([
                                      'success' => false,
                                      'message' => $e->getMessage(),
                                    ]);
        }
    }

    public function convenios(Request $request)
    {
        try {
            $data = $this->emprestaApiService->conveniosService();

            return Response()->json($data);
        } catch (\Exception $e) {
            return Response()->json([
                                      'success' => false,
                                      'message' => $e->getMessage(),
                                    ]);
        }
    }

    public function simuladorCredito(EmprestaRequests $request)
    {
        if ($request->validator->fails()) {
            return response()->json([
                'errors'    => $request->validator->errors()
            ]);
        }

        try {
            $data = $this->emprestaApiService->simuladorCreditoService($request->all());

            return Response()->json($data);
        } catch (\Exception $e) {
            return Response()->json([
                                      'success' => false,
                                      'message' => $e->getMessage(),
                                    ]);
        }
    }
}
