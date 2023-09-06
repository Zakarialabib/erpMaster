<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->file('image')) {
            if (is_array($request->image)) {
                $path = collect($request->image)->map->store('tmp-editor-uploads');
            } else {
                $path = $request->image->store('tmp-editor-uploads');
            }

            return response()->json([
                'url' => $path,
            ], 200);
        }

        return;
    }
}
