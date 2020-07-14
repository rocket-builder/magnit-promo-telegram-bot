<?php
function get_int_lenght($value) {

  if(is_int($value)) {
      return $value !== 0 ? floor(log10($value) + 1) : 1;
  } else
      throw new Exception('Not Integer value.');
}


function isRegion($regions,$data)
{
  foreach ($regions as $region) {
    if($region['title'] == $data) return true;
  }
  return false;
}
function isRange($ranges, $data)
{
  foreach ($ranges as $range) {
    if($range['range'] == $data) return true;
  }
  return false;
}


function getRangedPromo($arr, $range_start, $range_end)
{
  $out = [];
  foreach ($arr as $promo) {
    if($promo->balance <= $range_end && $promo->balance >= $range_start)
    array_push($out, ['value' => $promo->value, 'balance' => $promo->balance]);
  }

  return $out;
}
function getRangedPromoArray($promo) {
  usort($promo, function($a, $b){
      return $b->balance <=> $a->balance;
  });

  $max = round($promo[0]->balance);
  $len = get_int_lenght((int)$max) -1;
  $max = round($max, -$len);

  $min = floor(end($promo)->balance);
  //echo $min.' '.$max;

  $ranged = [];
  for ($i=$min; $i < $max; $i+=100) {
    $prs = getRangedPromo($promo, $i, $i+100);

    if(count($prs) > 0) {
      $ind = $i; $t1 = $ind . "р - ";$t2 = $ind+100 . "р";
      $title = $t1.$t2.', '.count($prs).'шт.';
      array_push($ranged, [ 'range' => $title, 'content' => $prs]);
    }
  }

  return $ranged;
}



?>