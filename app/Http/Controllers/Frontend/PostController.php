<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\Post;
use App\Events\PostReaded;

class PostController extends Controller
{
    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {

        $posts = $this->model::where('status', 1)
            ->with(['logs', 'user'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        $posts->map(function ($post) {
            if ($logs = $post->logs) {
                $showCnts = $logs->filter(function ($log) {
                    return $log->action === 'show';
                })->count() ?: 0;
            }

            $post->counts = $showCnts ?? 0;
        });

        return view('frontend.post.index', compact('posts'));
    }

    public function show(Request $request, int $id)
    {
        $user = Auth::user();
        $post = $this->model::with('user')->where('id', $id)->first();
        
        event(new PostReaded($post, $user, 'show'));

        return view('frontend.post.show', compact('post'));
    }

    public function edit(Request $request, int $id)
    {
        $action = 'edit';
        $user = Auth::user();
        $post = $this->model::with('user')->where('id', $id)->first();
        
        return view('frontend.post.edit', compact('post', 'action'));
    }

    public function update(Request $request, int $id)
    {
        $ret = [
            'success' => false,
            'message' => '',
        ];

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $updateDatas = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        $ret['success'] = $status = $this->model::where('id', $id)->update($updateDatas);
        $ret['message'] = $status ? 'Update success' : 'Update fail';
        

        return response()->json($ret);
    }
}
