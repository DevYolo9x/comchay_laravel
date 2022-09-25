<?php

namespace App\Components;

use Illuminate\Support\Facades\DB;

class Nestedsetbie
{
	function __construct($params = NULL)
	{
		$this->params = $params;
		$this->checked = NULL;
		$this->data = NULL;
		$this->count = 0;
		$this->count_level = 0;
		$this->lft = NULL;
		$this->rgt = NULL;
		$this->level = NULL;
	}

	public function Get()
	{
		$list = DB::table($this->params['table'])->where('alanguage', config('app.locale'))->orderBy('lft', 'asc')->orderBy('order', 'asc')->get();
		$this->data = $list;
	}
	public function GetNoneLft()
	{
		$list = DB::table($this->params['table'])->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
		$this->data = $list;
	}
	public function Set()
	{
		$arr = [];
		if (isset($this->data)) {

			foreach ($this->data as $key => $val) {
				$arr[$val->id][$val->parentid] = 1;
				$arr[$val->parentid][$val->id] = 1;
			}
			return $arr;
		}
	}

	public function Recursive($start = 0, $arr = NULL)
	{
		$this->lft[$start] = ++$this->count;
		$this->level[$start] = $this->count_level;
		if (isset($arr)) {
			foreach ($arr as $key => $val) {
				if ((isset($arr[$start][$key]) || isset($arr[$key][$start])) && (!isset($this->checked[$key][$start]) && !isset($this->checked[$start][$key]))) {
					$this->count_level++;
					$this->checked[$start][$key] = 1;
					$this->checked[$key][$start] = 1;
					$this->recursive($key, $arr);
					$this->count_level--;
				}
			}
		}
		$this->rgt[$start] = ++$this->count;
	}

	public function Action()
	{
		if (isset($this->level) && isset($this->lft) && isset($this->rgt)) {
			$data = NULL;
			foreach ($this->level as $key => $val) {
				$data[] = array(
					'id' => $key,
					'level' => $val,
					'lft' => $this->lft[$key],
					'rgt' => $this->rgt[$key],
				);
				DB::table($this->params['table'])->where('id', $key)->update([
					'level' => $val,
					'lft' => $this->lft[$key],
					'rgt' => $this->rgt[$key],
				]);
			}
			//DB::table($this->params['table'])->where('id')->update($data);
			// $this->CI->db->update_batch($this->params['table'], $data, 'id');
			// $this->CI->db->flush_cache();
		}
	}
	public function Dropdown($param = NULL)
	{
		$this->get();
		if (isset($this->data)) {
			$temp = NULL;

			$temp[0] = (isset($param->text) && !empty($param->text)) ? $param->text : '[Root]';
			foreach ($this->data as $val) {
				$temp[$val->id] = str_repeat('|-----', (($val->level > 0) ? ($val->level - 1) : 0)) . $val->title;
			}
			return $temp;
		}
	}
	public function DropdownCatalogue($array = [], $title = 'Chọn danh mục')
	{
		if (isset($array)) {
			$temp = NULL;
			$temp[0] = $title;
			foreach ($array as $val) {
				$temp[(int)$val->id] = $val->title;
			}
			return $temp;
		}
	}
}
