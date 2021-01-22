<?php
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	
	function Descending($a, $b) {   
		if ($a == $b) {        
			return 0;
		}   
			return ($a > $b) ? -1 : 1; 
	}  
	
	function get_access_time_count($input_file_name, $output_file_name){
		
		$access_time_array = array();
		
		$handle = fopen($input_file_name, "r");
		if ($handle) {
			
			$search = "2021";
			
			while (($line = fgets($handle)) !== false) {
				
				$pattern = "/2021:[0-9][0-9]:[0-9][0-9]:[0-9][0-9]/i";
				preg_match($pattern, $line, $matches, PREG_OFFSET_CAPTURE);	
				
				if($matches[0][1]>0){
					
					$access_time = explode('2021:', $matches[0][0])[1];
				
					if(!isset($access_time_array[$access_time])){
						
						$access_time_array[$access_time] = 0;
						
					}
					else{
						
						$access_time_array[$access_time]++;
						
					}
					
				}
			}
			fclose($handle);
			
			uasort($access_time_array,"Descending");
			
			echo "<pre>";
			print_r($access_time_array);
			echo "</pre>";
			
			$output_file = fopen($output_file_name, "w");
			fwrite($output_file, print_r($access_time_array, TRUE));
			fclose($output_file);
			
		} else {
			echo "Couldn't open file";
		} 
	}
	
	function get_access_ip_count($input_file_name, $output_file_name){
		
		$access_ip_array = array();
		
		$overall_count = 0;
		
		$handle = fopen($input_file_name, "r");
		if ($handle) {
			
			while (($line = fgets($handle)) !== false) {
				
				preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $line, $matches);
				#print_r($matches);
				if($matches[0]>0){
					
					#print_r($matches);
					
					$ip = $matches[0];
					#echo "ip: $ip";
					if(!isset($access_ip_array[$ip])){
						
						$access_ip_array[$ip] = 1;
						$overall_count++;
						
					}
					else{
						
						$access_ip_array[$ip]++;
						$overall_count++;
						
					}
					
				}
			}
			fclose($handle);
			
			uasort($access_ip_array,"Descending");
			
			echo "<pre>";
			print_r($access_ip_array);
			echo "</pre>";
			
			$output_file = fopen($output_file_name, "w");
			fwrite($output_file, print_r($access_ip_array, TRUE));
			fclose($output_file);
			
			echo "overall_count: $overall_count";
			
		} else {
			echo "Couldn't open file";
		} 
	}
	
	get_access_time_count("input_file","output_time.txt");
	get_access_ip_count("input_file","output_ip.txt");

?>
