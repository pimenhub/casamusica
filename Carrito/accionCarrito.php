<?php
//date_default_timezone_set("America/Lima");
// Iniciamos la clase de la carta
include_once("funcionesCarrito.php");
$cart = new Cart;

// include database configuration file
include_once("../Conexion/conexion.php");
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id_articulo'])){
        $idArticulo = $_REQUEST['id_articulo'];
        $usuario = $_REQUEST['u'];
        $cod = $_REQUEST['cod'];
        // get product details
        $query = $conexion->query("SELECT id_articulo, 
        nombre_articulo, 
        precio_articulo, 
        costo_articulo, 
        cantidad_articulo, 
        descripcion_articulo
FROM articulo WHERE id_estado_articulo_fk = 1
              AND id_articulo =".$idArticulo);
        $row = $query->fetch_assoc();
        $itemData = array(
            'id_articulo' => $row['id_articulo'],
            'nombre_articulo' => $row['nombre_articulo'],
            'precio_articulo' => $row['precio_articulo'],
            'cantidad_articulo' => 1
        );
        
        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem?'verCarrito.php?u='.$usuario.'&cod='.$cod:'../index.php';
        header("Location: ".$redirectLoc);

    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id_articulo'])){
        $itemData = array(
            'rowid' => $_REQUEST['id_articulo'],
            'cantidad_articulo' => $_REQUEST['cantidad_articulo']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem?'ok':'err';die;

    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id_articulo'])){
        $deleteItem = $cart->remove($_REQUEST['id_articulo']);
        $usuario = $_REQUEST['u'];
        $cod = $_REQUEST['cod'];
        header("Location: verCarrito.php?u=".$usuario.'&cod='.$cod);

    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['sessCustomerID'])){
        // insert order details into database
        //en este apartado condicionar la compra anonima
        //tambien definir el registro del cliente anonimo
        $insertOrder = $conexion->query("INSERT INTO compra (total_compra, id_cliente_fk) VALUES ('".$cart->total()."', '".$_SESSION['sessCustomerID']."')");
        
        if($insertOrder){
            $compraID = $conexion->insert_id;
            $sql = '';
            // get cart items
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
                $sql .= "INSERT INTO carrito (id_articulo_fk, id_compra_fk, cantidad) VALUES (".$item['id_articulo'].", ".$compraID.", ".$item['cantidad_articulo'].");";
            }
            // insert order items into database
            $insertOrderItems = $conexion->multi_query($sql);
            
            if($insertOrderItems){
                $cart->destroy();
                header("Location: ordenRealizada.php?id_compra=$compraID");
            }else{
                header("Location: Pagos.php");
            }
        }else{
            header("Location: Pagos.php");
        }
    }
    else{
        header("Location: ../index.php");
    }
}
else{
    header("Location: ../index.php");
}