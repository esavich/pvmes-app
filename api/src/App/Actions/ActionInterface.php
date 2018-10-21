<?php


namespace App\Actions;

use App\Http\JsonResponse;
use App\Http\Request;

interface ActionInterface
{
    function run(Request $request): JsonResponse;
}