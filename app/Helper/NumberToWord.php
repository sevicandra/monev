<?php

namespace App\Helper;

class NumberToWord
{
    public static function toWords($num)
    {
        $ones = array(
			0 =>"nol",
			1 => "satu",
			2 => "dua",
			3 => "tiga",
			4 => "empat",
			5 => "lima",
			6 => "enam",
			7 => "tujuh",
			8 => "delapan",
			9 => "sembilan",
			10 => "sepuluh",
			11 => "sebelas",
			12 => "dua belas",
			13 => "tiga belas",
			14 => "empat belas",
			15 => "lima belas",
			16 => "enam belas",
			17 => "tujuh belas",
			18 => "delapan belas",
			19 => "sembilan belas",
		);
		$tens = array( 
			0 => "nol",
			1 => "sepuluh",
			2 => "dua puluh",
			3 => "tiga puluh", 
			4 => "empat puluh", 
			5 => "lima puluh", 
			6 => "enam puluh", 
			7 => "tujuh puluh", 
			8 => "delapan puluh", 
			9 => "sembilan puluh" 
		); 
		$hundreds = array( 
			"ratus", 
			"ribu", 
			"juta", 
			"milyar", 
			"triliun", 
			"QUARDRILLION" 
		); /*limit t quadrillion */
		$num = number_format($num,2,".",","); 
		$num_arr = explode(".",$num); 
		$wholenum = $num_arr[0]; 
		$decnum = $num_arr[1]; 
		$whole_arr = array_reverse(explode(",",$wholenum)); 
		krsort($whole_arr,1); 
		$rettxt = ""; 
		foreach($whole_arr as $key => $i){
			while(substr($i,0,1)=="0")
				$i=substr($i,1,5);
			if($key == "0"){
				if($i){
					if($i < 20){ 
						/* echo "getting:".$i; */
						$rettxt .= $ones[$i]; 
					}elseif($i < 100){ 
						if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
						if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
					}else{
						if(substr($i,0,1)=="1") $rettxt .= "seratus";; 
						if(substr($i,0,1)!="0" && substr($i,0,1)!="1") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
						if(substr($i,1,1)=="1"){
							$rettxt .= " ".$ones[substr($i,1,2)];
						}else{
							if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
							if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
						} 
					} 
				}
			}

			if($key == "1"){
				if($i){
					if($i == "1"){
						$rettxt .= "seribu ";
					}elseif($i < 20 && $i>1){ 
						/* echo "getting:".$i; */
						$rettxt .= $ones[$i]; 
					}elseif($i < 100){ 
						if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
						if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
					}else{
						if(substr($i,0,1)=="1") $rettxt .= "seratus";; 
						if(substr($i,0,1)!="0" && substr($i,0,1)!="1") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
						if(substr($i,1,1)=="1"){
							$rettxt .= " ".$ones[substr($i,1,2)];
						}else{
							if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
							if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
						}  
					} 
					if($i > "1"){
						$rettxt .= " ".$hundreds[$key]." ";
					}
				}
			}

			if($key > "1"){
				if($i){
					if($i < 20	){ 
						/* echo "getting:".$i; */
						$rettxt .= $ones[$i]; 
					}elseif($i < 100){ 
						if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
						if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
					}else{
						if(substr($i,0,1)=="1") $rettxt .= "seratus";; 
						if(substr($i,0,1)!="0" && substr($i,0,1)!="1") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
						if(substr($i,1,1)=="1"){
							$rettxt .= " ".$ones[substr($i,1,2)];
						}else{
							if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
							if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
						}   
					} 
						$rettxt .= " ".$hundreds[$key]." ";
				}
				}
		}
		if($decnum > 0){
			$rettxt .= " and ";
			if($decnum < 20){
				$rettxt .= $ones[$decnum];
			}elseif($decnum < 100){
				$rettxt .= $tens[substr($decnum,0,1)];
				$rettxt .= " ".$ones[substr($decnum,1,1)];
			}
		}
		return $rettxt;
    }
}
