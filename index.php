<?php
    $phone_number + $_POST['MSISDN'];   
    $sessionID = $_POST['sessionId'];  
    $servicecode = $_POST['serviceCode'];  
    $ussdString = $_POST['text'];


    $query = "SELECT * from farmers where phone_Number ='$phonenumber'";
	if ($result=mysqli_query($conn,$query)){
		$row = $result->fetch_assoc();
		if(mysqli_num_rows($result) > 0){

			//View my account menu			
			if ($level==0){
				displaymenu();
			}    
		    if ($level>0){  
			    switch ($ussdString_explode[0]) {  
					case 1:
						apply_fertilizer($ussdString_explode, $phone_number, $username, $conn);
				    case 2:
					    sell_produce($ussdString_explode,$phonenumber, $username, $conn);  
					    break;
				    case 0:
				    	die();
				    	break;
				    default:
				    	$ussd_text = "INVALID OPTION";
						ussd_proceed($ussd_text);
				    	break; 
				}  //End switch
			}  
			
		}
		else{
		  	//Registration menu
		  	 if ($level==0){  
			    	$ussd_text="CON \nWELCOME TO CORNCOB.\n1. REGISTER\n    ";  
			   		ussd_proceed($ussd_text);    
			    } 
				
				//First selection either registration or about
				if ($level>0){  
				    switch ($ussdString_explode[0])  
					    {  
						case 1:
						    register($ussdString_explode,$phonenumber, $conn);  
						    break;
						default:						
							$ussd_text = "INVALID CHOICE.";
							ussd_proceed($ussd_text);
				    }//End switch  
			    }  	
			}//End else
		}
		else{
		    $ussd_text = "Query failed";
			ussd_proceed($ussd_text);
		}


    function displayMenu(){
       $ussd_text="CON \n1: ASK FOR FERTILIZER\n2: SELL MAIZE\n00: EXIT";  
		ussd_proceed($ussd_text);  
    }

    function register($details,$phone, $conne, $isSwahili){      
		if (count($details)==1){   
				$ussd_text="CON \n ENTER YOUR NAMES:";
			ussd_proceed($ussd_text);
		}
		else if(count($details) == 2){  
			$name=$details[1];     
			
			//Validate and sanitize
			if(!filter_var($name, FILTER_SANITIZE_STRING) === TRUE){
				$name = NULL;
			}
			// //============   Tablename    ===================
			// $username = "lj".$phone;
			// //=================Write into database all the details=========================== 
			// $sql = "INSERT INTO subscribers (Name, phone_Number, id_Number, business_Type, username, registration_Platform, Swahili) 
			// 		VALUES ('$name', '$phone', '$id_number', '$business_type' , '$username', 'MOBILE', '$isSwahili')";
			
		}  
	}

?>