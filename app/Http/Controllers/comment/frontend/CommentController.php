<?php

namespace App\Http\Controllers\comment\frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Components\Comment as CommentHelper;

class CommentController extends Controller
{
    protected $comment;
    public function __construct()
    {
        $this->comment = new CommentHelper();
    }
    //list comment product
    public function getListComment(Request $request)
    {
        $sort = $request->sort;
        $module = 'products';
        $comment_view =  $this->comment->comment(array('id' => $request->module_id, 'sort' => $sort), $module);
        return view('product.frontend.product.comment.data', compact('comment_view', 'sort'))->render();
    }
    //list comment tour
    public function getListCommentTour(Request $request)
    {
        $sort = $request->sort;
        $module = 'tours';
        $comment_view =  $this->comment->comment(array('id' => $request->module_id, 'sort' => $sort), $module);
        return view('tour.frontend.tour.comment._data', compact('comment_view', 'sort'))->render();
    }
    //list comment article
    public function getListCommentArticle(Request $request)
    {
        $sort = $request->sort;
        $module = 'articles';
        $comment_view =  $this->comment->comment(array('id' => $request->module_id, 'sort' => $sort), $module);
        return view('article.frontend.article.comment._data', compact('comment_view', 'sort'))->render();
    }

    //postCmt products
    public function postCmt(Request $request)
    {
        $module_id = Product::find($request->module_id);
        if (empty($module_id)) {
            echo 500;
            die();
        }
        $request->validate([
            'fullname' => 'required',
            'message' => 'required',
        ]);
        $customerid = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : '';
        if ($request->images) {
            $images = explode('-+-', $request->images);
        }
        $id = Comment::insertGetId([
            'module_id' => $module_id->id,
            'customerid' => $customerid,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'message' => $request->message,
            'images' => !empty($images) ? json_encode($images) : '',
            'parentid' => !empty($request->parent_id) ? $request->parent_id : 0,
            'rating' => $request->rating,
            'created_at' => Carbon::now(),
            'publish' => 1,
            'module' => 'products',
            'type' => 'customer'

        ]);

        if ($id > 0) {
            echo 200;
        } else {
            echo 500;
        }
        die();
    }
    //post comment tour
    public function postCmtTour(Request $request)
    {

        $module_id = Tour::findOrFail($request->module_id);
        if (empty($module_id)) {
            echo 500;
            die();
        }
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'avatar' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'fullname.required' => 'The name field is required.',
            'message.required' => 'The review field is required.',
        ]);
        $customerid = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : '';
        if ($request->images) {
            $images = explode('-+-', $request->images);
        }
        if (!empty($request->file('avatar'))) {
            $image_url = uploadImageFrontend($request->file('avatar'), 'comment/avatar');
        }
        $id = Comment::insertGetId([
            'module_id' => $module_id->id,
            'customerid' => $customerid,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'message' => $request->message,
            'avatar' => $image_url,
            'parentid' => !empty($request->parent_id) ? $request->parent_id : 0,
            'rating' => $request->rating,
            'created_at' => Carbon::now(),
            'publish' => 1,
            'module' => 'tours',
            'type' => 'customer'

        ]);
        if ($id > 0) {
            //thực hiện update rate table tours
            $averagePoint =  $this->comment->comment(array('id' => $module_id->id, 'sort' => 'id'), 'tours')['averagePoint'];
            Tour::find($module_id->id)->update(['rate' => $averagePoint]);
            echo 200;
        } else {
            echo 500;
        }
        die();
    }
    //post comment Article
    public function postArticle(Request $request)
    {
        $module_id = \App\Models\Article::findOrFail($request->module_id);
        if (empty($module_id)) {
            echo 500;
            die();
        }
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'avatar' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'fullname.required' => 'The name field is required.',
            'message.required' => 'The review field is required.',
        ]);
        $customerid = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : '';
        if ($request->images) {
            $images = explode('-+-', $request->images);
        }
        if (!empty($request->file('avatar'))) {
            $image_url = uploadImageFrontend($request->file('avatar'), 'comment/avatar');
        }
        $id = Comment::insertGetId([
            'module_id' => $module_id->id,
            'customerid' => $customerid,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'message' => $request->message,
            'avatar' => $image_url,
            'parentid' => !empty($request->parent_id) ? $request->parent_id : 0,
            'created_at' => Carbon::now(),
            'publish' => 1,
            'module' => 'articles',
            'type' => 'customer'

        ]);
        if ($id > 0) {
            echo 200;
        } else {
            echo 500;
        }
        die();
    }
    public function reply_comment(Request $request)
    {

        $request->validate([
            'fullname' => 'required',
            // 'email' => 'required|email',
            'message' => 'required',
            // 'avatar' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

        ], [
            'fullname.required' => 'The name field is required.',
            'message.required' => 'The review field is required.',
        ]);
        $customerid = !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : '';
        /*
        if (!empty($request->file('avatar'))) {
            $image_url = uploadImageFrontend($request->file('avatar'), 'comment/avatar');
        }
        */
        $id = Comment::insertGetId([
            'customerid' => $customerid,
            'fullname' => $request->fullname,
            'email' => !empty($request->email) ? $request->email : '',
            'phone' => '',
            'message' => $request->message,
            // 'avatar' => $image_url,
            'parentid' => !empty($request->parent_id) ? $request->parent_id : 0,
            'created_at' => Carbon::now(),
            'publish' => 1,
            'type' => 'customer'
        ]);
        if ($id > 0) {
            echo 200;
        } else {
            echo 500;
        }
        die();
    }
    public function uploadImagesComment(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);
        if ($request->delete) {
            if (file_exists(base_path() . $request->file)) {
                unlink(base_path() . $request->file);
            }
        } else {
            $request->validate([
                'file.*' => 'mimes:jpeg,jpg,png,gif,webp'
            ]);
            if ($request->hasfile('file')) {
                foreach ($request->file('file') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move(base_path() . '/upload/comment/', $name);
                    $imgData[] = $name;
                }
                $image_return  = trim('/upload/comment/' . $name);
                echo json_encode(array(
                    'html' => '<div class="write-review__image">
                    <img src="' . $image_return . '" alt="upload images">
                    <div class="js_delete_image_cmt" data-file="' . $image_return . '">×</div>
                </div>',
                ));
                die();
            }
        }
    }
}
