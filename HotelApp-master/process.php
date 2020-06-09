<?php session_start();?>

<!DOCTYPE html>
<html lang="en-US">
<head>

<link href="https://fonts.googleapis.com/css?family=Baloo+2&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/process.css" type="text/css">
</head>
<body>
<div id="container">
<?php
    /*
     * process.php handles the processing of all user inputs, thats retrieving 
     * data and sending out data and throws certain responses
     * 
     * @version php v7.1
     * @auther Le-Roy
     * 
     */

         $userObject = new User($_SESSION['name_s'],  $_SESSION['surname_s'], $_SESSION['email_s'], $_SESSION['checkIn_s'], $_SESSION['checkOut_s'], $_SESSION['hotels']);
         
		 $year = $userObject -> getYears();
		 $_SESSION['year'] = $year;
		 $month = $userObject -> getMonths();
		 $_SESSION['month'] = $month;
		 $day = $userObject -> getDays();
		 $_SESSION['day'] = $day;
		 $_SESSION['nod'] = $userObject -> getNum_of_days($month, $day, $year);
         echo $userObject -> getUser();
         echo $userObject -> getCheckInDate();
         echo $userObject -> getCheckOutDate();
         
         echo $userObject -> getHotels();
         
         
		 
        
         
         
        
         $_SESSION['ci'] = $userObject -> getCheckInDate();
         $_SESSION['co'] = $userObject -> getCheckOutDate();
		
		 $_SESSION['hotel_cost'] = $userObject -> hotel_cost;
		 $_SESSION['array'] = $userObject -> hotelInfo_array;
		 
    


    class User
    {
        public $name, $surname, $email, $checkInDate, $checkOutDate, $non, $hotelInfo_array, $hotel_cost, $hotel_array, $cim, $cid, $ciy ,$com, $cod, $coy= '';
        
        //class User constructor, with params
        function __construct($name, $surname, $email, $cid, $cod, $hotel_array)
        {
            $this -> name = $name;
            $this -> surname = $surname;
            $this -> email = $email;
            $this -> checkInDate = $cid;
            $this -> checkOutDate = $cod;
            $this -> hotel_array = $hotel_array;
            
        }
        
        
        //getUser returns name, surname, and email
        function getUser()
        {
            return "<div id=\"user\"><ul><li>Name: ".$this -> name."</li><li>Surname: ".$this -> surname."</li><li>Email: ".$this -> email."</li></ul>";
        }
        
        //getCheckInDate returns the check in date
        function getCheckInDate()
        {
            $checkIn = date('l-d-F', $this -> checkInDate);
            return "Check In Date: ".$checkIn."<br>";
        }
        
        //getCheckOutDate returns the check out date
        function getCheckOutDate()
        {
            $checkOut = date('l-d-F', $this -> checkOutDate);
            return "Check Out Date: ".$checkOut."<br></div>";
        }
        
        function getDays()
        {
            $this -> cid = date('d', $this -> checkInDate);
            $this -> cod = date('d', $this -> checkOutDate);
            
            if($this -> cid > $this -> cod)
            {
                $new_cid =  $this -> cid - $this -> cod;
                return (($this -> cod + $new_cid) - $new_cid);
            }else{
                return ($this -> cod - $this -> cid);
            }
        }
        
        function getMonths()
        {
            $this -> cim = date('m', $this -> checkInDate);
            $this -> com = date('m', $this -> checkOutDate);
            
            if($this -> cim > $this -> com)
            {
                $new_cim =  $this -> cim - $this -> com;
                return (($this -> com + $new_cim) - $new_cim);
            }else{
                return ($this -> com - $this -> cim);
            }
        }
        
        
        function getYears()
        {
            $this -> ciy = date('Y', $this -> checkInDate);
            $this -> coy = date('Y', $this -> checkOutDate);
            return ($this -> coy - $this -> ciy);
            
        }
        
        function getNum_of_days($m, $d, $y)
        {
            if($y > 0 && $m > 0 && $d > 0)
            {
                return $y. " year(s) ".$m." month(s), ".$d." day(s)";
            }
            
            else if($y <= 0 && $m > 0 && $d > 0)
            {
                return $m." month(s), ".$d." day(s)";
            }
            
            else if($y <= 0 && $m <= 0 && $d > 0)
            {
                return $d;
            }
            else {
                return "invalid date was submitted";
            }
        }
        
        function getHotels()
        {
            $this -> hotel_cost = array( 
                'Park Inn by Radisson Cape Town Foreshore' => array(
                    'total' => 2222
                ),
                
                'Mandela Rhodes Place Hotel' => array(
                    'total'  => 2428
                ),
				
                'Icon Luxury Apartments' => array(
                    'total' => 2552 
                ),
				
                'Taj Cape Town' => array(
                    'total' => 5646
                ),
				
                'City Lodge Hotel Victoria And Alfred Waterfront' => array(
                    'total' => 3474
                ),
				
                'Southern Sun Cape Sun' => array(
                    'total' => 4590
                )
            );
			
			foreach($this -> hotel_cost as $key => $array)
			{
				foreach( $array as $second_key => $value)
				{
					if($_SESSION['year'] > 1)
					{
						$_SESSION['money'] = (365 +  $_SESSION['month'] + $_SESSION['day'])* $value;
					}else
					{
						$_SESSION['money'] = ($_SESSION['month'] + $_SESSION['day'] )* $value;  
					}
				}
			}
		
			
            $this -> hotelInfo_array = array( 
                'Park Inn by Radisson Cape Town Foreshore' => array(
                    '<div class="div_hotel"><table cellspacing="10"><tr><th scope="row">Hotel Name: </th>' => "<td>Park Inn by Radisson Cape Town Foreshore</tr></td>",
                    '<tr><th scope="row">Parking: </th>' => "<td>Yes</td></tr>",
                    '<tr><th scope="row">Pool: </th>' => "<td>Yes</td></tr>",
                    '<tr><th scope="row">Gym: </th>' => "<td>Yes</td></tr>",
                    '<tr><th scope="row">Kitchen: </th>' => "<td>No</td></tr>",
                    '<tr><th scope="row">Wifi: </th>' => "<td>No</td></tr>",
                    '<tr><th scope="row">Breakfast: </th>' => "<td>No</td></tr>",
                    '<tr><th scope="row">Air conditioning: </th>' => "<td>yes</td></tr>",
					'<tr><th scope="row">Number Of Days: </th>' => "<td>".$_SESSION['nod']."</td></tr>",
                    '<tr><th scope="row">Daily Rate</th>' => "<td> R2222 </td></tr>",
					'<tr><th scope="row">Total</th>' => "<td>".$_SESSION['money']."</td></tr></table></div>"
                ),
                
                'Mandela Rhodes Place Hotel' => array(
                    '<div class="div_hotel"><table cellspacing="10"><tr><th scope="row">Hotel Name: </th>' => "<td>Mandela Rhodes Place Hotel</td></tr>",
                    '<tr><th scope="row">parking: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">pool: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">gym: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">kitchen: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">breakfast: </th>' => "<td>no</td></tr>", 
                    '<tr><th scope="row">wifi: </th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">air conditioning: </th>' => "<td>yes</td></tr>",
					'<tr><th scope="row">Number Of Days: </th>' => "<td>".$_SESSION['nod']."</td></tr>",
                    '<tr><th scope="row"> Daily Rate </th>' => "<td> R2428 </td></tr></table></div>"
                ),
                'Icon Luxury Apartments' => array(
                    '<div class="div_hotel"><table cellspacing="10"><tr><td>Hotel Name: </td>' => "<td>Icon Luxury Apartments</td></tr>",
                    '<tr><th scope="row">parking</th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">pool</th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">gym</th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">kitchen</th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">wifi</th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">breakfast</th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">air conditioning</th>' => "<td>yes</td></tr>",
					'<tr><th scope="row">Number Of Days: </th>' => "<td>".$_SESSION['nod']."</td></tr>",
                    '<tr><th scope="row"> Daily Rate </th>' => "<td> R2552 </td></tr></table></div>"
                ),
                'Taj Cape Town' => array(
                    '<div class="div_hotel"><table cellspacing="10"><tr><td>Hotel Name: </td>' => "<td>Taj Cape Town</td></tr>",
                    '<tr><th scope="row">parking</th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">pool</th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">gym</th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">kitchen</th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">wifi</th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">breakfast</th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">air conditioning</th>' => "<td>yes</td></tr>",
					'<tr><th scope="row">Number Of Days: </th>' => "<td>".$_SESSION['nod']."</td></tr>",
                    '<tr><th scope="row">Daily Rate</th>' => "<td>R5646</td></tr></table></div>"
                ),
                'City Lodge Hotel Victoria And Alfred Waterfront' => array(
                    '<div class="div_hotel"><table cellspacing="10"><tr><td>Hotel Name: </td>' => "<td>City Lodge Hotel Victoria And Alfred Waterfront</td></tr>",
                    '<tr><th scope="row">parking: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">pool: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">gym: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">kitchen: </th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">wifi: </th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">breakfast: </th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">air conditioning: </th>' => "<td>yes</td></tr>",
					'<tr><th scope="row">Number Of Days: </th>' => "<td>".$_SESSION['nod']."</td></tr>",
                    '<tr><th scope="row">Daily Rate</th>' => "<td>R3474</td></tr></table></div>"
                ),
                'Southern Sun Cape Sun' => array(
                    '<div class="div_hotel"><table cellspacing="10"><tr><td>Hotel Name: </td>' => "<td>Southern Sun Cape Sun</td></tr>",
                    '<tr><th scope="row">parking: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">pool: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">gym: </th>' => "<td>yes</td></tr>",
                    '<tr><th scope="row">kitchen: </th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">wifi: </th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">breakfast: </th>' => "<td>no</td></tr>",
                    '<tr><th scope="row">air conditioning: </th>' => "<td>yes</td></tr>",
					'<tr><th scope="row">Number Of Days: </th>' => "<td>".$_SESSION['nod']."</td></tr>",
                    '<tr><th scope="row">Daily Rate</th>' => "<td>R4590</td></tr></table></div>"
                )
            );
            
           $temp = implode(',', $this -> hotel_array);
           $this -> hotel_array = explode(',', $temp);
           
           foreach($this -> hotelInfo_array as $hotel_key => $value)
           {
               
               foreach($this -> hotel_array as $hotel_value_j)
               {
                   
                   if($hotel_key == $hotel_value_j)
                    {
                        foreach($value as $value_key => $this_val)
                        {
                            
 echo <<<_END
<div>
<ul><li>$value_key $this_val</li></ul>
</div>
 
_END;
                            
                        }
                    }
                    
               }
           }
        }
        
    }
?>

<div id="form">
<p>
<form action="success.php" method="POST">

<select name="hotel" size="1" >
<?php 
    


foreach ($_SESSION['hotels'] as $val)
{
    
?>
<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
<?php 
}
?>
</select>
</p>
<p>
<input type="submit" value="Book Now">

</p>
</form>
</div>
 <footer class="footer_area">
            
            <div class="footer_bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <p>© 2020 BookitApp. All rights reserved</p>
                        </div>
                        <div class="col-sm-8">
                            <nav class="footer_menu">
                                <ul>
                                    
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="accommodation.php">Accommodation</a></li>
                                    <li><a href="Facilities&Services.php">Facilities</a></li>
                                    <li><a href="Location&ContactUs.php">ContactUs</a></li>
                                    <li><a href="Reservation.php">Reservation</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
        </footer>
</div>
</body>
</html>  