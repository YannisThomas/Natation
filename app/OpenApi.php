<?php

namespace App;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="OpenAPI natation project backend documentation",
 *      description="backend is used by smartphone application and desktop front",
 *
 *      @OA\Contact(
 *          email="**"
 *      ),
 *
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 *  ),
 *
 * @OA\Response(
 *      response="UnprocessableEntity",
 *      description="Erreur de validation",
 *
 *      @OA\JsonContent(
 *
 *          @OA\Property(property="message", type="string", example="Erreur de validation"),
 *          @OA\Property(
 *              property="errors",
 *              type="object",
 *              additionalProperties=@OA\Property(type="array", @OA\Items(type="string"))
 *          )
 *      )
 * )
 */
class OpenApi {}
