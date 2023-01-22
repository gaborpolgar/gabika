<?php
include("_kapcsolat.php");
$db = new kapcsolat();
$connection =  $db->getConnstring();

$request_method=$_SERVER["REQUEST_METHOD"];

switch($request_method)
{
  case 'GET':

   if(!empty($_GET["id"]))
   {
    $id=intval($_GET["id"]);
    get_toysid($id);
   }
   else
   {
     get_toys();
   }
   break;
 case 'POST':
  insert_toy();
  break;

 case 'PUT':

    $id=intval($_GET["id"]);
   #$id=intval($_PUT["id"]);
   update_toy($id);
   break;

 case 'DELETE':
 
   $id=intval($_GET["id"]);
   delete_toy($id);
   break;
 default:

    header("HTTP 405 Az eljárás nem engedélyezett");
    break;
} 

function get_via_php(){
    get_toys();
}


function get_toys()
{
  global $connection;
  $query="SELECT * FROM toys";
  $response=array();

  $result=mysqli_query($connection, $query);
  //print_r($result);
  $eredmeny = mysqli_fetch_all($result, MYSQLI_ASSOC);
  /*while($row=mysqli_fetch_assoc($result))
  {
    $eredmeny[]=$row;
  }*/

  header('Content-Type: application/json'); 
  echo json_encode($eredmeny);
}

function get_toysid($id=0)
{
  global $connection;
  $query="SELECT * FROM toys";
  if($id != 0)
  {
    $query.=" WHERE id=".$id." LIMIT 1";
  }
  $response=array();
  $result=mysqli_query($connection, $query);
  while($row=mysqli_fetch_array($result))
  {
    $response[]=$row;
  }
  header('Content-Type: application/json'); 
  echo json_encode($response); 
}

function insert_toy()
 {
  global $connection;
   
    $data = json_decode(file_get_contents('php://input'), true);
    $name=$data["name"]; 
    $hiba = "";
    if (empty($name)) {
        $hiba .= "Név megadása kötelező. ";
        echo $hiba;
        die;
    } else{

    $query="INSERT INTO toys SET name='".$name."'";
    }
    if(mysqli_query($connection, $query))
    {
       $response=array(
             'status' => 1,
             'status_message' =>'A játék sikeresen hozzáadva.'
              );
    }
    else
    {
       $response=array(
             'status' => 0,
             'status_message' =>'A játék hozzáadása sikertelen!'
             );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
                         }
function delete_toy($id)
{
   global $connection;
  $query="DELETE FROM toys WHERE id=".$id;
   if(mysqli_query($connection, $query))
   {
     $response=array(
      'status' => 1,
       'status_message' =>'A játék sikeresen törölve.'
      );
   }
   else
   {
      $response=array(
         'status' => 0,
         'status_message' =>'A játék törlése sikertelen.'
      );
   }
   header('Content-Type: application/json');
   echo json_encode($response);
}
                  

function update_toy($id)
 {
   global $connection;
   $post_vars = json_decode(file_get_contents("php://input"),true);
   $name=$post_vars["name"];
   $query="UPDATE toys SET name='".$name."' WHERE id=".$id;
   if(mysqli_query($connection, $query))
   {
      $response=array(
         'status' => 1,
         'status_message' =>'A játék adatainak a frissítése sikeres.'
      );
    }
    else
    {
        $response=array(
            'status' => 0,
           'status_message' =>'A játék adatainak a frissítése sikertelen.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    die();
}                  
         
?>