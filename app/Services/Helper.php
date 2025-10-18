<?php

use Illuminate\Support\Str;

if (!function_exists('slugify')) {
    /**
     * @param string|object|array|mixed $data
     * @return url
     */
    function slugify($text, string $divider = '-'){
        
        // replace non letter or digits by divider
	    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

	    // transliterate
	    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	    // remove unwanted characters
	    $text = preg_replace('~[^-\w]+~', '', $text);

	    // trim
	    $text = trim($text, $divider);

	    // remove duplicate divider
	    $text = preg_replace('~-+~', $divider, $text);

	    // lowercase
	    $text = strtolower($text);

	    if (empty($text)) {
	    return 'n-a';
	    }

	    return $text;
    }
}

if (!function_exists('getIndianCurrency')) {
	function getIndianCurrency(float $number)
	{
	    $decimal = round($number - ($no = floor($number)), 2) * 100;
	    $hundred = null;
	    $digits_length = strlen($no);
	    $i = 0;
	    $str = array();
	    $words = array(0 => '', 1 => 'one', 2 => 'two',
	        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
	        7 => 'seven', 8 => 'eight', 9 => 'nine',
	        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
	        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
	        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
	        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
	        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
	        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
	    $digits = array('', 'hundred','thousand','lakh', 'crore');
	    while( $i < $digits_length ) {
	        $divider = ($i == 2) ? 10 : 100;
	        $number = floor($no % $divider);
	        $no = floor($no / $divider);
	        $i += $divider == 10 ? 1 : 2;
	        if ($number) {
	            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
	            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
	            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
	        } else $str[] = null;
	    }
	    $Rupees = implode('', array_reverse($str));
	    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
	    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
	}
}


if (!function_exists('orderStatus')) {
    function orderStatus($data){
        
        $status = ['TEMPORARY' => 'Temporary','INPROCESS' => 'Inprogress','PARTIALLYCANCELLEDBYTHECUSTOMER' => 'Partially cancelled by the customer','PARTIALLYCANCELLEDBYTHEDESIGNER' => 'Partially cancelled  by the designer','FULLYCANCELLEDBYTHECUSTOMER' => 'Fully cancelled by the customer','FULLYCANCELLEDBYTHEDESIGNER' => 'Fully cancelled by the designer','CONFIRMEDBYTHEDESIGNER' => 'Confirmed by the designer','READYFORPICKUP' => 'Ready for pickup','INTRANSIT' => 'Intransit','OUTFORDELIVERY' => 'Out for delivery','CANCELLEDDUETONONPAYMENT' => 'Cancelled due to non payment','RETURNREQUESTPLACED' => 'Return request placed'];

        return $status[$data];
    }
}

if (!function_exists('generateInitials')) {
    function generateInitials($name){
        
        $words = explode(' ', $name);
	    if (count($words) >= 2) {
	        return mb_strtoupper(
	                mb_substr($words[0], 0, 1, 'UTF-8') . 
	                mb_substr(end($words), 0, 1, 'UTF-8'), 
	            'UTF-8');
	    }
    }
}

if (!function_exists('address')) {
    function address($addressId){
        
        $userAddress = App\Models\UserAddress::where('id',$addressId)->with(['state','country'])->first();

        $address = array();
        $address[] = $userAddress->street;
        $address[] = $userAddress->city;
        $address[] = $userAddress->pincode;
        $address[] = $userAddress->state->name;
        $address[] = $userAddress->country->name;

        return implode(', ',$address);
    }
}

if (!function_exists('generateUUID')) {
    function generateUUID(){
    	return Str::uuid()->toString();
    }
}

if (!function_exists('generateSpecification')) {
    function generateSpecification($product){
    	$spcs = array();

    	$spcs[] = ['key' => 'SKU','value' => $product->sku,'extra' => ''];
    	$spcs[] = ['key' => 'Seller', 'value' => $product->merchant->company_name,'extra' => route('merchantDetail',$product->merchant->slug)];

    	//if product type == JEWELLERY
    	if($product->type == 'JEWELLERY'){

    		$spcs[] = ['key' => 'Gender', 'value' => $product->gender,'extra' => ''];
    		$spcs[] = ['key' => 'Metal', 'value' => $product->metal->name,'extra' => ''];

    		if($product->gemstone == 'YES'){
				$spcs[] = ['key' => 'Gemstone type', 'value' => $product->stone->name,'extra' => ''];
				$spcs[] = ['key' => 'Gemstone carat', 'value' => $product->gemstone_carat,'extra' => ''];
				$spcs[] = ['key' => 'Gemstone clarity', 'value' => $product->gemclarity->name,'extra' => ''];
				$spcs[] = ['key' => 'Gemstone color', 'value' => $product->gemcolor->name,'extra' => ''];
				$spcs[] = ['key' => 'Gemstone cut', 'value' => $product->gemcut->name,'extra' => ''];
    		}

    		$occassion = array();
			if(!is_null($product->occassion)){
				foreach($product->occassion as $ok => $ov){
					$occassion[] = $ov->occassionName->name;
				}
			}

			$spcs[] = ['key' => 'Occassion', 'value' => $occassion > 0 ? implode(', ',$occassion) : '--','extra' => ''];
    	}


    	//product attribute
    	if(!is_null($product->attribute)){
			foreach($product->attribute as $ak => $av){

				$value = '';
				if(count($av->value) > 1){
					$strig = array();
					foreach($av->value as $vk => $vv){
						$string[] = $vv->option->option;	
					}
					$value = implode(', ',$string);
				} else {
					$value = !is_null($av->value[0]->option) ? $av->value[0]->option->option : $av->value[0]->value;
				}

				$spcs[] = [
					'key' => $av->attribute->name , 
					'value' => $value,
					'extra' => ''
				];
			}
		}

    	return $spcs;
    }
}

if (!function_exists('calculateDiscount')) {
    function calculateDiscount($productId,$productPrice){

        $discountProduct = \App\Models\DiscountProduct::where('product_id',$productId)
                                                ->whereHas('discount',function($q){ 
                                                    $date = date('Y-m-d'); 
                                                    $q->where('is_active',1); 
                                                    $q->where('is_delete',0); 
                                                    $q->where('valid_from','<=',$date); 
                                                    $q->where('valid_till','>=',$date);     
                                                })->with(['discount'])->first();

                
        $discount = !is_null($discountProduct) && !is_null($discountProduct->discount) ?  $discountProduct->discount->discount : 0.00;
        $discountId = !is_null($discountProduct) && !is_null($discountProduct->discount) ?  $discountProduct->discount_id : 0;
        $discountedPrice = 0.00;
        $amount = 0.00;

        if($discount != 0){
            $amount = $productPrice * $discount / 100;
            $discountedPrice = $productPrice - $amount;
        }

        $price['discount'] = $discount;
        $price['amount'] = $amount;
        $price['original_price'] = $productPrice;
        $price['discounted_price'] = $discountedPrice;   
        $price['discount_id'] = $discountId;   

        return $price;
    }
}

if (!function_exists('getTax')) {
    function getTax($countryId,$subcategoryId){
    	$tax = 0;
		$getTaxQuery = \App\Models\CategoryTax::where('country_id', $countryId);
		if ($subcategoryId != '') {
		    $getTaxQuery->where('subcategory_id', $subcategoryId);
		} else {
		    $getTaxQuery = \App\Models\TaxSetting::where('country_id', $countryId);
		}
		$getTax = $getTaxQuery->first();

		if (!is_null($getTax)) {
		    $tax = $getTax->tax;
		}

		return $tax;
    }
}

if (!function_exists('getFinYear')) {
    function getFinYear(){
    	$counter = date('Y') - 2022;
    	$currentYear = date('Y');
    	$currentMonth = date('m');

    	if ($currentMonth >= 4) {
            $financialYearStart = $currentYear;
        } else {
            $financialYearStart = $currentYear - 1;
        }

    	$financialYears = [];
    	for ($i = 0; $i < $counter; $i++) {
            $startYear = $financialYearStart - $i;
            $endYear = $startYear + 1;
            $financialYears[] = $startYear . '-' . $endYear;
        }

        return array_reverse($financialYears);
    }
}
