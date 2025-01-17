<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Resources\ResponseResource;
use App\Repositories\QuestionRepository;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function __construct(
        public ResponseRepository $responseRepository
    ) {}
    public function index()
    {
        return view('responses');
    }
    public function createResponse(Request $request, $id)
    {
        $this->responseRepository->createResponse($request, $id);
    }

    public function returnResponses()
    {
        return ResponseResource::collection($this->responseRepository->getAll());
    }
    
    public function deleteResponse($id){
        $this->responseRepository->deleteResponse($id);
    }

    public function responsePage($questionId, $slug, $responseId){
        return view('response');
    }

    public function returnResponse($id){
       $responseAndQuestion = $this->responseRepository->getResponse($id);
       return response()->json([
            'response' => new ResponseResource($responseAndQuestion),
            'question' => new QuestionResource($responseAndQuestion->question),
       ]);
    }
}
