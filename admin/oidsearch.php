<?php 
	include('../connect.php'); 
	session_start();


if(isset($_POST['oid'])){
	$oid = trim($_POST['oid']);
	$oid = str_replace(" ", ",", $oid);

	$q= "SELECT `oid`,`order-date` ,food,price,quantity,total,status,`c-name`,`c-address`,`c-contact`,email from `order` where oid IN($oid)  ";

		$res = mysqli_query($con,$q);
		if(mysqli_num_rows($res)>0){
			$count=1;
			while($row = mysqli_fetch_assoc($res)){
				if($count==1){
					echo"<label> Order-Id : #".str_replace(',', '-', $oid)."</label>
			           <label> Order-Date : ".$row['order-date']."</label>
			           <label>Name : ".$row['c-name']."</label>
			           <label>Address : ".$row['c-address']."</label>
			           <label>Contact : ".$row['c-contact']."</label>
			           <label>Email : ".$row['email']."</label>
			           <label>  
			                <table>
			                    <tr>
			                        <th>Order-Id</th>
			                        <th>Food</th>
			                        <th>Quantity</th>
			                        <th>Price</th>
			                        <th>Total</th>
			                        <th>Status</th>
			                    </tr>
			                   
			                    ";
	                }

	                     echo"<tr>
	                     	<td>".$row['oid']."</td>
	                     	<td>".$row['food']."</td>
	                        <td>".$row['quantity']."</td>
	                        <td>Rs ".$row['price']."</td>
	                        <td>Rs ".$row['total']."</td>
	                        <td>".$row['status']."</td>
	                    </tr>
	                    ";

	                    $count++;
            }

	        echo"
		           </table>
	           </label>
	           ";
				
				
			
		}
		else{
			echo "<span class='norecord'> No records  found. </span>";
		}
	}
?>