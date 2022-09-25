<?php

namespace App\Http\Controllers\address\frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\VNDistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Components\System;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->system = new System();
    }
    public function index()
    {
        /* $district_html =  VNDistrict::where('cityid',29)->where('lat','=','')->get();

        foreach($district_html as $v){
            $title =  $v->name.', '.$v->city->name.', Việt Nam';
            $title = str_replace(' ','%20',$title);

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://google-maps-geocoding-plus.p.rapidapi.com/geocode?address='.$title.'&language=en',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: google-maps-geocoding-plus.p.rapidapi.com",
                    "x-rapidapi-key: d66b194fadmshf55a09bbf9ba51cp1ab42cjsn50b53bd6778d"
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($response);

                DB::table('vn_district')->where('id',$v->id)->update(['lat' => $data->response->place->latitude,'long' => $data->response->place->longitude]);
            }
        }
        die;
        */
        $Liststores = Address::where('publish', 0)->select('*')->get();
        $groupValue = [];
        if (isset($Liststores)) {
            $groupValue = groupValue($Liststores, 'cityid');
        }
        $listCity = DB::table('vn_province')->whereIn('provinceid', array_keys($groupValue))->orderBy('name', 'asc')->get();

        $seo['canonical'] = route('addressFrontend.index');
        $seo['meta_title'] = 'Hệ thống cửa hàng';
        $seo['meta_description'] = 'Hệ thống cửa hàng Mẹ Bầu và Em Bé Kids Plaza cung cấp hơn 30.000 sản phẩm an toàn, chính hãng, chất lượng tốt, giá cả cạnh tranh.';
        $seo['meta_image'] = $fcSystem['seo_meta_images'];
        $seo['og_type'] = 'home';
        $fcSystem = $this->system->fcSystem();
        return view('address.frontend.index', compact('seo', 'Liststores', 'groupValue', 'listCity', 'fcSystem'));
    }
    public function getLocationFrontend(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $district_html = '<option value="0">-- Quận / Huyện --</option>';
        if (!empty($id)) {
            if ($type == 'city') {
                $getDistrict = Address::where('cityid', $id)->select('districtid')->groupBy('districtid')->get();
                $valueDistrict = [];
                if (isset($getDistrict)) {
                    foreach ($getDistrict as $v) {
                        $valueDistrict[] = $v->districtid;
                    }
                }
                $listDistrict = DB::table('vn_district')->whereIn('districtid', $valueDistrict)->orderBy('name', 'asc')->get();
                if (isset($listDistrict)) {
                    foreach ($listDistrict as $k => $val) {
                        $district_html .= ' <option label="' . $val->name . '" value="' . $k . '" lat-city="' . $val->lat . '" long-city="' . $val->long . '" data-id="' . $val->districtid . '">' . $val->name . '
                        </option>';
                    }
                }
                $row = 'cityid';
            } else {
                $row = 'districtid';
            }

            $dataAddress = Address::where($row, $id)->get();
        } else {
            $dataAddress = Address::get();
        }
        echo json_encode(array(
            'district_html' => $district_html,
            'html' => htmlAddress($dataAddress),
            'count' => count($dataAddress)
        ));
    }
    public function getAddressFrontend(Request $request)
    {
        $fcSystem = $this->system->fcSystem();
        $cityID = $request->cityID;
        $districtID = $request->districtID;
        $html = '';
        if (!empty($cityID)) {
            $address = \App\Models\Address::select('vn_district.name', 'vn_district.districtid')
                ->where('publish', 0)
                ->where('cityid', $cityID)
                ->groupBY('addresses.districtid')
                ->join('vn_district', 'vn_district.districtid', '=', 'addresses.districtid')
                ->get();
            $html .= '<option value="0">' . $fcSystem['title_9'] . '</option>';
            if (isset($address)) {
                foreach ($address as $k => $val) {
                    $html .= ' <option  value="' . $val->districtid . '">' . $val->name . '
                            </option>';
                }
            }
        } else if (!empty($districtID)) {
            $address = \App\Models\Address::select('addresses.title', 'addresses.address', 'addresses.hotline', 'addresses.time')
                ->where('publish', 0)
                ->where('districtid', $districtID)
                ->get();
            if (count($address) > 0) {
                $html .= '<h4>' . $fcSystem['title_10'] . '</h4><div style="margin-top:10px">';
                foreach ($address as $item) {
                    $html .= '<div class="item" style="margin-bottom:20px;line-height:15px">
                        <h5 class="uppercase text-f12">' . $item->title . '</h5>
                        <p>' . $item->address . '</p>
                        <p>' . $item->hotline . '</p>
                        <p>' . $item->time . '</p>
                    </div>';
                }
                $html .= '</div>';
            }
        }
        echo json_encode(array(
            'html' => $html,
        ));
    }
}
