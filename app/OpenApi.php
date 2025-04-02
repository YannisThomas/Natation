<?php

namespace App;

use OpenApi\Annotations as OA;
use Illuminate\Http\Request;
use App\Http\controllers\Controllers;

/**
 *  @purpose La classe OpenApi est vide. Ce fichier est utilisé pour
 *                  définir les éléments généraux utilisés par l'API
 *
 * @OA\OpenApi(
 *
 *  @OA\Info(
 *      version="1.0.0",
 *      title="Lery OpenApi Mobility Education with Dashcam Documentation",
 *
 *     @OA\Contact(
 *          url="https://lery.cc/contact",
 *          email="admin@lery.cc"
 *      ),
 *
 *     @OA\License(
 *          name="copyright Lery Technologies",
 *          url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 *  ),
 *
 *  @OA\Server(
 *      url="http://localhost:8000",
 *      description="development API endpoints"
 *  ),
 *  @OA\Server(
 *      url="http://med.lery.cc",
 *      description="integration API endpoints"
 *  ),
 *
 *  @OA\Components(
 *
 *     @OA\Schema(
 *          title="BaseModel",
 *          schema="BaseModel",
 *          description="Should not be used and hidden but mandatory for documentation",
 *
 *          @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly=true),
 *          @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly=true),
 *     ),
 *
 *      @OA\Schema(
 *          title="DashcamResponse",
 *          schema="DashcamResponse",
 *
 *          @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="dashcam successfully registered",
 *              ),
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *                  @OA\Property(
 *                      property="token",
 *                      type="string",
 *                      example="1|gKoGuAJOqCWDxVQqQwUFJUvlSrzfMoed4NoU2abk"
 *                  ),
 *              )
 *       ),
 *
 *     @OA\Response(
 *         response="FailedAuthentication",
 *         description="Failed Authentication",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 description="Error Message",
 *                 example="Authentication failed"
 *             ),
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 description="may be more informations about errors",
 *                 example="No authentication token provided"
 *             ),
 *         ),
 *     ),
 *
 *     @OA\Response(
 *          response="FailedValidation",
 *          description="Unprocessable entity. The information sent does not allow server to provide a response",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="message", type="string", description="What went wrong", example="Incorrect data sent"),
 *              @OA\Property(
 *                  property="errors",
 *                  description="Validation errors.",
 *                  type="object",
 *                  example={
 *                      "messageId": {"The message ID field is required."},
 *                      "mail": {"Invalid mail format"}
 *                  },
 *              ),
 *          ),
 *     ),
 *
 *     @OA\SecurityScheme(
 *          type="apiKey",
 *          in="header",
 *          securityScheme="api_token",
 *          name="Authorization"
 *      )
 * ),
 *
 * @OA\Get(
 *     path="/api/user",
 *     tags={"General"},
 *     summary="Authentication test",
 *     description="Allow API user to test there authentication through API Token. There is no specific abilities required to access this endpoint. Every user should be allowed to get a 200 response with a valid API Token",
 *     operationId="userTest",
 *
 *     @OA\Response(
 *         response="200",
 *         description="User is successfully authenticated",
 *
 *         
 *     ),
 *
 *     @OA\Response(response="401", ref="#/components/responses/FailedAuthentication"),
 *
 *    security={{"api_token":{}}}
 * )
 * )
 **/
class OpenApi {}
