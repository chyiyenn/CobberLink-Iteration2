<?php 
// use Elementor\Beta_Testers;
// use Elementor\Controls_Manager;
// use Elementor\Plugin;

/*******
 * @param string $result_data;
 * @return array
 */
function graphina_remote_csv_data_create($result_data){
    $data = $fields = [];

    $result_f = array_keys($result_data);
    $fields = [[ $result_f[0],$result_f[1] ]];

    foreach ($result_data['category'] as $key => $value) {
        $temp = [];
        array_push($temp, $value);
        array_push($data, $temp);
    }

    foreach ($result_data['series'] as $key => $value) {
        array_push($data[$key], $value);
    }

    $dataArray = array_merge($fields,$data);
    $pieData = json_encode($dataArray);

    return $pieData;
}

/*****
 * @param string $url
 * @return array
 */
function graphina_pro_get_google_chart_data_from_remote_csv($url){
    $result = [];
    $file = file_get_contents($url);
    $file = str_replace("\r\n", "\n", $file);
    $arr = explode("\n", $file);

    foreach($arr as $k){
        $result_data = explode(',',$k);
        array_push($result, $result_data);
    }   
    $result = json_encode($result);

    return $result;
}

function graphina_pro_google_chart_get_data_from_api($mainType, $settings, $type = '')
{
    $api_url = $settings['iq_' . $mainType . '_chart_import_from_api'];
    $result = ['series' => [], 'category' => [], 'total' => 0];
    if ($api_url === '') {
        return $result;
    }
    $args = [];
    if(isset($settings['iq_'.$mainType.'_authrization_token']) 
        && $settings['iq_'.$mainType.'_authrization_token'] == 'yes') {
        $args['headers'] = [];
        $args['headers'][$settings['iq_'.$mainType.'_header_key']] = $settings['iq_'.$mainType.'_header_token'];
    }
    $response = wp_remote_get($api_url, $args );
    
    if (is_array($response) && !is_wp_error($response)) {
        $res_body = $response['body']; // use the content
        $res_body = json_decode($res_body, true);
        if (gettype($res_body['data']) === 'array') {
            switch ($type) {
                case 'circle':
                    $result['series'] = $res_body['data'];
                    $result['category'] = $res_body['category'];
                    $result['total'] = array_sum($res_body['data']);
                    break;
            }
        }
    }
    return $result;
}

function graphina_pro_google_get_data_from_url($ele_type, $settings, $type, $mainId, $from_type = 'area')
{
    $data = ['series' => [], 'category' => [], 'total' => 0];

    $import_from = $type === 'remote-csv' ? 'iq_' . $ele_type . '_chart_import_from_url' : 'iq_' . $ele_type . '_chart_import_from_google_sheet';

    $val = graphina_get_dynamic_tag_data($settings, $import_from);
    $val = htmlspecialchars_decode($val);

    if ($val !== '') {
        $data = graphina_pro_google_get_data_from_remote_csv($val);
    }
     
    return $data;
}

function graphina_pro_google_get_data_from_remote_csv($url = '')
{
    $result = $category = [];
    $total = 0;
    if ($url === '') {
        return ["series" => $result, "category" => $category, 'total' => $total];
    }

    $file = file_get_contents($url);

    if (strpos($file, '<!DOCTYPE html>') !== false || strpos($file, '<html>') !== false || strpos($file, '</html>') !== false) {
        return ["series" => $result, "category" => $category, 'total' => $total, 'fail' => 'permission'];
    }
    $file = str_replace("\r\n", "\n", $file);
    $arr = explode("\n", $file);

    foreach ($arr as $i => $a) {
        if (!empty($a)) {
            $v =  str_getcsv($a,GRAPHINA_PRO_CSV_BY_SEPARATOR);;
            if ($i === 0) {
                $category = filter_var_array($v, FILTER_SANITIZE_STRING);;
            } else {
                $result = array_values(array_map(function ($d) {
                    return (float)$d;
                }, $v));
                $total = array_sum($result);
            }
        }
    }

    return ["series" => $result, "category" => array_values($category), 'total' => $total];
    
}

function graphina_pro_google_get_data_from_db($result_data){

    $fields_array = [];
    foreach ($result_data[0] as $key => $value) {
        $fields[] = $key;
    }

    $fields_array = [ 
        [
            $fields[1],
            $fields[2]
        ]
    ];
   
    /* Fields Value */
    $cat = $fields[1];
    $val = $fields[2]; 

    for ($i=0; $i < count($result_data); $i++) { 
        $category = (string)$result_data[$i]->$cat;
        $value = (int)$result_data[$i]->$val;
        $pieData = [
            $category,$value
        ];
        array_push( $fields_array, $pieData);
    }
    $pieData = json_encode($fields_array);

    return $pieData;
}

