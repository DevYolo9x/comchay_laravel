<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Components\Nestedsetbie;

class AjaxController extends Controller
{
    public function select2(Request $request)
    {
        $condition = $request->condition;
        $condition = (!empty($condition)) ? $condition : '';
        $value = !empty($request->value) ? $request->value : '';
        $key = !empty($request->value) ? $request->value : '';
        $catalogueid = json_decode($value, true);
        if (isset($catalogueid)) {
            $data =  DB::table($request->module)->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->whereIn('id', $catalogueid)->get();
        } else {
            $data =  DB::table($request->module)->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->where('catalogueid', $condition)->get();
        }
        $temp = [];
        if (isset($data)) {
            foreach ($data as $val) {
                $temp[] = array(
                    'id' => $val->id,
                    'text' => $val->title,
                );
            }
        }
        echo json_encode(array('items' => $temp));
        die();
    }
    public function pre_select2(Request $request)
    {
        $locationVal = $request->locationVal;
        $module =  $request->module;
        $select =  $request->select;
        $value =  $request->value;
        $condition =  $request->condition;
        $condition = (!empty($condition)) ? $condition : '';
        $catalogueid = json_decode($value, true);
        $key =  $request->key;
        if (empty($key)) {
            $key = 'id';
        }
        if (isset($catalogueid)) {
            $data =  DB::table($module)->select('id', 'title')->where('alanguage', config('app.locale'))->whereIn('id', $catalogueid)->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        }
        $temp = [];
        if (isset($data)) {
            foreach ($data as $val) {
                $temp[] = array(
                    'id' => $val->id,
                    'text' => $val->$select,
                );
            }
        }
        echo json_encode(array('items' => $temp));
        die();
    }
    public function get_select2(Request $request)
    {
        $condition = (!empty($request->condition)) ? $request->condition : '';
        $locationVal = (!empty($request->locationVal)) ? $request->locationVal : '';
        $module = (!empty($request->module)) ? $request->module : '';
        $select = (!empty($request->select)) ? $request->select : '';
        if (!empty($locationVal)) {
            $data =  DB::table($module)->where('alanguage', config('app.locale'))->select('id', 'title')->orderBy('order', 'asc')->orderBy('id', 'desc');
            $data =  $data->where('title', 'like', '%' . $locationVal . '%');
            $data = $data->get();
        } else {
            $data =  DB::table($module)->where('alanguage', config('app.locale'))->select('id', 'title')->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        }

        $temp = [];
        if (isset($data)) {
            foreach ($data as $val) {
                $temp[] = array(
                    'id' => $val->id,
                    'text' => $val->$select,
                );
            }
        }

        echo json_encode(array('items' => $temp));
        die();
    }
    public function ajax_create(Request $request)
    {

        $module = $request->module;
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:' . $module . '',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
        ]);
        $validator->validate();

        DB::table($module)->insert([
            'title' => $request->title,
            'slug' => slug($request->title),
            'userid_created' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'alanguage' => config('app.locale')
        ]);
        return response()->json([
            'code' => 200,
        ], 200);
    }
    public function ajax_delete_all(Request $request)
    {
        $post = $request->param;
        $module = $post['module'];
        if (isset($post['list']) && is_array($post['list']) && count($post['list'])) {
            foreach ($post['list'] as $id) {
                $this->delete_function($id, $module);
            }
        }
        return response()->json([
            'code' => 200,
        ], 200);
    }
    public function ajax_delete(Request $request)
    {
        $module = $request->module;
        $id = (int) $request->id;
        $child = (int) $request->child;
        $this->delete_function($id, $module, $child);
        return response()->json([
            'code' => 200,
        ], 200);
    }
    public function ajax_order(Request $request)
    {
        $module = $request->param['module'];
        $id = (int) $request->param['id'];
        DB::table($module)->where('id', $id)->update(['order' => (int) $request->param['order']]);
        return response()->json([
            'code' => 200,
        ], 200);
    }
    public function ajax_publish(Request $request)
    {
        $module = $request->param['module'];
        $id = (int) $request->param['id'];
        $title = $request->param['title'];
        $object = DB::table($module)->where('id', $id)->first();
        $_update['' . $title . ''] = (($object->$title == 1) ? 0 : 1);
        DB::table($module)->where('id', $id)->update($_update);
        return response()->json([
            'code' => 200,
        ], 200);
    }
    //delete function
    public function delete_function($id = 0, $module = '', $child = 0)
    {
        //Order
        if ($module  == 'orders') {
            Order::where('id', $id)->update(['deleted_at' => Carbon::now()]);
        } else if ($module  == 'coupons') {
            Coupon::where('id', $id)->update(['deleted_at' => Carbon::now()]);
        } else if ($module  == 'comments') {
            //lấy cmt cha
            $dataCmt =  DB::table($module)->select('id', 'images')->where('id', $id)->first();
            //lấy cmt con
            $dataCmtChild = DB::table($module)->select('id', 'images')->where('parentid', $dataCmt->id)->get();
            //nếu tồn tại cmt con thì xóa cmt và ảnh
            if (!$dataCmtChild->isEmpty()) {
                foreach ($dataCmtChild as $v) {
                    //xóa ảnh cmt child
                    $listImageCmtChild = json_decode($v->images, TRUE);
                    if (!empty($listImageCmtChild)) {
                        foreach ($listImageCmtChild as $image) {
                            if (file_exists(public_path() . $image)) {
                                unlink(public_path() . $image);
                            }
                        }
                    }
                    //xóa cmt child
                    DB::table($module)->where('id', $v->id)->delete();
                }
            }
            //xóa ảnh và cmt parentid = 0
            if (!empty($dataCmt->images)) {
                $listImageCmt = json_decode($dataCmt->images, TRUE);
                if (!empty($listImageCmt)) {
                    foreach ($listImageCmt as $image) {
                        if (file_exists(public_path() . $image)) {
                            unlink(public_path() . $image);
                        }
                    }
                }
            }
            DB::table($module)->where('id', $dataCmt->id)->delete();
        } else if ($module  == 'customers') {
            //xoa anh dai dien
            $dataCustomer =  DB::table($module)->select('image')->where('id', $id)->first();
            if (file_exists(base_path() . $dataCustomer->image)) {
                unlink(base_path() . $dataCustomer->image);
            }
            DB::table($module)->where('id', $id)->delete();
        } else {
            DB::table($module)->where('id', $id)->delete();
        }
        //xóa bảng menus_item
        if ($module == 'menus') {
            DB::table('menu_items')->where('menu_id', $id)->delete();
        }
        //xóa router
        DB::table('router')->where('moduleid', $id)->where('module', $module)->delete();
        //xóa bảng tag tags
        if ($module == 'tags') {
            DB::table('tags_relationships')->where('tagid', $id)->delete();
        }
        //brands
        if ($module == 'brands') {
            DB::table('brands_relationships')->where('brandid', $id)->delete();
        }
        //attributes
        if ($module == 'attributes') {
            DB::table('attributes_relationships')->where('attrid', $id)->delete();
        }
        //products
        if ($module == 'products') {
            //xóa brands_relationship
            DB::table('brands_relationships')->where('moduleid', $id)->where('module', $module)->delete();
            //xóa tags_relationship
            DB::table('tags_relationships')->where('moduleid', $id)->where('module', $module)->delete();
            //xóa attribute_relationship
            DB::table('attributes_relationships')->where('moduleid', $id)->delete();
            //Xóa  products_versions
            DB::table('products_versions')->where('productid', $id)->delete();
            //Xóa  products_colors
            DB::table('products_colors')->where('product_id', $id)->delete();
            DB::table('products_sizes')->where('product_id', $id)->delete();
        }
        //articles
        if ($module == 'articles' || $module == 'products') {
            //xóa catalogue_relationship
            DB::table('catalogues_relationships')->where('moduleid', $id)->where('module', $module)->delete();
            //xóa tags_relationship
            DB::table('tags_relationships')->where('moduleid', $id)->where('module', $module)->delete();
        }
        //tour
        if ($module == 'tours') {
            //xóa tags_relationship
            DB::table('tags_relationships')->where('moduleid', $id)->where('module', $module)->delete();
            //xóa tour_attribute_relationships
            DB::table('tour_attribute_relationships')->where('tour_id', $id)->delete();
            //xóa tour_service_relationships
            DB::table('tour_service_relationships')->where('tour_id', $id)->delete();
            //xóa tour_type_relationships
            DB::table('tour_type_relationships')->where('tour_id', $id)->delete();
        }
        //media
        if ($module == 'media') {
            //xóa catalogue_relationship
            DB::table('catalogues_relationships')->where('moduleid', $id)->where('module', $module)->delete();
        }
        if ($module == 'category_articles' || $module == 'category_products' || $module == 'category_media' || $module == 'tour_categories') {
            $nestedsetbie = new Nestedsetbie(array('table' => $module));
            $nestedsetbie->Get();
            $nestedsetbie->Recursive(0, $nestedsetbie->Set());
            $nestedsetbie->Action();
        }
        //briefings
        if ($module == 'briefings') {
            //xóa catalogue_relationship
            DB::table('briefing_category_relationships')->where('module_id', $id)->delete();
        }
        //xóa custom fields
        if ($module == 'category_articles' || $module == 'articles' || $module == 'products' || $module == 'category_products' || $module == 'media' || $module == 'category_media' || $module == 'attributes' || $module == 'category_attributes' || $module == 'brands' || $module == 'tags') {
            DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $module])->delete();
        }
        if ($child == 1) {
            $moduleExplode = explode('_', $module);
            DB::table($moduleExplode[1])->where('catalogueid', $id)->delete();
        }
    }
}
