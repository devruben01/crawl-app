<?php

namespace App\Http\Controllers\Api;

use App\Constants\Constants;
use App\Exceptions\UploadFileException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSampleRequest;
use App\Http\Requests\UpdateSampleRequest;
use App\Http\Resources\SampleResource;
use App\Services\SampleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SampleController extends Controller
{
    public function __construct(private SampleService $sampleService)
    {
    }

    /**
     * @OA\Get(
     *      path="/samples",
     *      operationId="index",
     *      tags={"Samples"},
     *      security={{ "apiAuth": {} }},
     *      summary="Get list of samples",
     *      description="Returns list of samples",
     *      @OA\Parameter(
     *          name="page",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="keyword",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="order_by",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             @OA\Property(property="data",  type="array",  @OA\Items(ref="#/components/schemas/Sample")),
     *             @OA\Property(property="meta",  type="object",
     *                         @OA\Property(property="total", type="integer", example=20),
     *                         @OA\Property(property="per_page", type="integer", example=2),
     *                         @OA\Property(property="current_page", type="string", example=1),
     *             ),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Get resources successfully")
     *          ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="NULL", example=null),
     *              @OA\Property(property="code", type="integer", example=403),
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Forbidden"),
     *         ),
     *      )
     *      )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $orderBy = $request['order_by'] == Constants::DEFAULT_ORDER_DESC ? Constants::DEFAULT_ORDER_DESC : Constants::DEFAULT_ORDER_ASC;
        $keyword = $request['keyword'] ?? null;

        $sampleCollection = $this->sampleService->all($keyword, $orderBy);

        $sampleResources = sampleResource::collection($sampleCollection)->response()->getData(true);

        $response = [
            'data' =>  $sampleResources['data'],
            'meta' => [
                'total' => $sampleCollection->total(),
                'per_page' => $sampleCollection->perPage(),
                'current_page' => $sampleCollection->currentPage(),
            ],
            'code' => ResponseAlias::HTTP_OK,
            'status' => true,
            'message' => 'Get resources successfully',
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/samples",
     *      operationId="storeSample",
     *      tags={"Samples"},
     *      security={{ "apiAuth": {} }},
     *      summary="Store new sample",
     *      description="Returns sample data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(ref="#components/schemas/StoreSampleRequest")
     *                 }
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Sample"),
     *             @OA\Property(property="code", type="integer", example=201),
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Created resource Successfully"),
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=400),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Bad request"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="NULL", example=null),
     *              @OA\Property(property="code", type="integer", example=403),
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Forbidden"),
     *         )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The title field is required.")
     *         )
     *      )
     * )
     * @param StoreSampleRequest $request
     * @return SampleResource
     * @throws UploadFileException
     */
    public function store(StoreSampleRequest $request): SampleResource
    {
        $sample = $this->sampleService->create($request);
        $response = [
            'code' => ResponseAlias::HTTP_CREATED,
            'status' => true,
            'message' => 'Created resource Successfully',
        ];

        return (new SampleResource($sample))->additional($response);
    }

    /**
     * @OA\Get(
     *      path="/samples/{id}",
     *      operationId="show",
     *      tags={"Samples"},
     *      security={{ "apiAuth": {} }},
     *      summary="Get sample information",
     *      description="Returns sample data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Sample id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Sample"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Get resource Successfully"),
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=400),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Bad request"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="NULL", example=null),
     *              @OA\Property(property="code", type="integer", example=403),
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Forbidden"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Record not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="NULL", example=null),
     *              @OA\Property(property="code", type="integer", example=404),
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Resource not found"),
     *         ),
     *      )
     * )
     * @param int $id
     * @return SampleResource
     */
    public function show(int $id): SampleResource
    {
        $sample = $this->sampleService->find($id);
        $code = ResponseAlias::HTTP_OK;
        if (!$sample) {
            $code = ResponseAlias::HTTP_NOT_FOUND;
        }

        $response = [
            'code' => $code,
            'status' => true,
            'message' => 'Get resource Successfully',
        ];

        return (new SampleResource($sample))->additional($response);
    }

    /**
     * @OA\Put(
     *      path="/samples/{id}",
     *      operationId="update",
     *      tags={"Samples"},
     *      security={{ "apiAuth": {} }},
     *      summary="Update existing sample",
     *      description="Returns updated sample data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Sample id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(ref="#components/schemas/UpdateSampleRequest")
     *                 }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Sample"),
     *             @OA\Property(property="code", type="integer", example=202),
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Updated resource successfully"),
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=400),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Bad request"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="NULL", example=null),
     *              @OA\Property(property="code", type="integer", example=403),
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Forbidden"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Record not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="NULL", example=null),
     *              @OA\Property(property="code", type="integer", example=404),
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Resource not found"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The title field is required."),
     *         ),
     *      ),
     * )
     * @param UpdateSampleRequest $request
     * @param int $id
     * @return SampleResource
     */
    public function update(UpdateSampleRequest $request, int $id): SampleResource
    {
        $data = $request->all();
        if ($request->file('image')) {
            $file = $request->file('image');
            $filepath = $file->store('public/images');
            $data['image'] = str_replace('public/', 'storage/', $filepath);
        }

        $sample = $this->sampleService->update($id, $data);
        $code = ResponseAlias::HTTP_OK;
        if (!$sample) {
            $code = ResponseAlias::HTTP_NOT_FOUND;
        }

        $response = [
            'code' => $code,
            'status' => true,
            'message' => 'Updated resource successfully',
        ];

        return (new SampleResource($sample))->additional($response);
    }

    /**
     * @OA\Delete(
     *      path="/samples/{id}",
     *      operationId="delete",
     *      tags={"Samples"},
     *      security={{ "apiAuth": {} }},
     *      summary="Delete existing sample",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Sample id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=204),
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Delete resource Successfully"),
     *         ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="NULL", example=null),
     *              @OA\Property(property="code", type="integer", example=403),
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Forbidden"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Record not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="NULL", example=null),
     *              @OA\Property(property="code", type="integer", example=404),
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Resource not found"),
     *         ),
     *      )
     * )
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->sampleService->deleteFile($id);
        $response = [
            'data' => null,
            'code' => ResponseAlias::HTTP_NO_CONTENT,
            'status' => true,
            'message' => 'Delete resource Successfully',
        ];

        return response()->json($response);
    }
}
