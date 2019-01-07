<?php

if (!function_exists('generate_csv')) {
  function generate_csv($header, $data, $separator = ';') {
    array_unshift($data, $header);

    $filePhp = fopen('php://memory', 'w');
    foreach ($data as $fields) {
      fputcsv($filePhp, $fields, $separator);
    }
    rewind($filePhp);
    $csv = stream_get_contents($filePhp);
    fclose($filePhp);
    return $csv;
  }
}

if (!function_exists('planning_csv')) {
  function planning_csv($paginateData, $dataFlatten) {
    return array_map(function($data) use($dataFlatten){

      foreach($data as $key => $value){
        if (isset($dataFlatten[$key])) {
          $data[$key] = $data[$key][$dataFlatten[$key]] ;
        }
      }

      return $data;
    },$paginateData);
  }
}

