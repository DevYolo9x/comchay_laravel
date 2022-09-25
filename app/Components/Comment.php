<?php

namespace App\Components;

use App\Models\Comment as ModelsComment;

class Comment
{

	public function comment($param = [], $module = '')
	{
		/*
        thống kê bình luận và đánh giá
		đánh giá:
		+ totalComment
		+ arrayRate
		+ averagePoint
        */
		$data = $this->statistical_rating(array(
			'module_id' => $param['id'],
		), $module);
		$data['listComment'] = $this->comment_render($param['id'], $param['sort'], $module);
		return $data;
	}
	public function statistical_rating($param = [], $module)
	{
		/*tính tổng số bản ghi có trong chi tiết module*/
		$totalRows =  ModelsComment::select('id', 'module_id', 'rating')->where('module', $module)->where('module_id', $param['module_id'])->where('parentid', 0)->where('publish', 0)->get();
		$data = [];
		$data['totalComment'] = $totalRows->count(); /*đếm số bản ghi*/
		/*nếu có comment*/
		if ($data['totalComment'] > 0) {
			$data['arrayRate'] = $this->recursive_number($totalRows);
			$sum = 0;
			if (!empty($data['arrayRate'])) {
				foreach ($data['arrayRate'] as $key => $val) {
					$sum += $key * $val;
				}
				/*tính điểm TB = tổng điểm / số cmt*/
				$data['averagePoint'] = round($sum / $data['totalComment'], 1, PHP_ROUND_HALF_UP);
			}
		} else {
			/*không có cmt*/
			$data['arrayRate'] = array(
				5 => 0,
				4 => 0,
				3 => 0,
				2 => 0,
				1 => 0,
			);
			$data['averagePoint'] = 0;
		}
		return $data;
	}
	public function recursive_number($totalRows = [], $number = 5, $result = [])
	{
		/*đếm all các giá trị = $count*/
		$count = 0;
		if (!empty($totalRows)) {
			foreach ($totalRows as $key => $val) {
				if ($val->rating == $number) {
					$count++;
				}
			}
			$result[$number] = $count;
			if ($number > 1) {
				$result = $this->recursive_number($totalRows, $number - 1, $result);
			}
		}
		return $result;
	}
	public function comment_render($module_id = 0, $sort = 'id', $module)
	{
		/*lấy toàn bộ comment*/
		$listComment = ModelsComment::select('comments.*')->where('module', $module)->where('module_id', $module_id)->where('parentid', 0)->where('comments.publish', 0);
		$listComment = $listComment->orderBy('comments.id', 'desc');

		if ($sort == 'gallery') {
			$listComment = $listComment->where('images', '!=', '');
		}
		if ($sort == '5') {
			$listComment = $listComment->where('rating', 5);
		}
		if ($sort == '4') {
			$listComment = $listComment->where('rating', 4);
		}
		if ($sort == '3') {
			$listComment = $listComment->where('rating', 3);
		}
		if ($sort == '2') {
			$listComment = $listComment->where('rating', 2);
		}
		if ($sort == '1') {
			$listComment = $listComment->where('rating', 1);
		}
		if ($sort == 'payment') {
			$listComment = $listComment->join('orders', 'orders.customerid', '=', 'comments.customerid')->join('orders_item', 'orders_item.order_id', '=', 'orders.id')->groupBy('comments.id')->where('product_id', $module_id);
		}
		$listComment = $listComment->paginate(20);
		if ($listComment) {
			foreach ($listComment as $key => $val) {
				$orderCheck = $val->order->where('product_id', $val->module_id);
				if (!$orderCheck->isEmpty()) {
					$listComment[$key]['order'] = 1;
				} else {
					$listComment[$key]['order'] = 0;
				}
				$listComment[$key]['child'] =  ModelsComment::where('parentid', $val->id)->orderBy('id', 'desc')->where('publish', 0)->get();
			}
		}
		return $listComment;
	}
}
