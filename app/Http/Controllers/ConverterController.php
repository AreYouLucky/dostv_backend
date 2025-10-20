<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Helpers\EditorJsHelper;
use Illuminate\Support\Facades\DB;


class ConverterController extends Controller
{
    public function convert()
    {
        DB::beginTransaction();

        try {
            // Get all posts that still have Editor.js JSON content
            $posts = Post::select('post_id', 'content')->where('is_converted', 0)->get();

            foreach ($posts as $post) {
                // Skip empty or already-converted HTML
                if (empty($post->content)) {
                    continue;
                }

                // Convert JSON to HTML
                $converted = EditorJsHelper::toHtml($post->content);

                // Skip if conversion fails (invalid JSON or empty blocks)
                if (empty(trim($converted))) {
                    continue;
                }

                // Update the post content
                $post->update([
                    'content' => $converted,
                    'is_converted' => 1
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'All posts converted to HTML.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
