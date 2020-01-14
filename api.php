<?php 
require "conexion.php";
$user=new ApptivaDB();

//accion mostar, insertar, editar y eliminar 
$accion="mostrar";
$res=array("error"=>false);
if(isset($_GET['accion'])) 
    $accion=$_GET['accion'];

switch($accion){
    case 'mostrar':
        $u=$user->buscar("alumnos","1");//se retornan todos los estudiantes
        if($u):
            $res['alumnos']=$u;
            $res['mensaje']="exito";
        else:
            $res['mensaje']="No existen Registros";
            $res['error']=true;
        endif;
        break;
    
    case 'insertar':
        $nombre     =   $_POST['nombre'];
        $apellido   =   $_POST['apellido'];
        $foto       =   $_FILES['foto']['name'];

        $target_dir="img/";
        $target_file=$target_dir.basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'],$target_file);

        $data="'".$nombre." ','".$apellido."','".$foto."'";
        $u  =   $user->insertar("alumnos",$data);
        if($u):
            $res['mensaje']="insercion exitosa";
        else:
            $res['mensaje']="Aun no hay registros";
            $res['error']=true;
        endif;
        break;
    
    case 'editar':
       
        $id     =   $_POST['eid'];
        $nombre     =   $_POST['enombre'];
        $apellido   =   $_POST['eapellido'];
        $foto="";
        if(isset($_FILES['efoto']['name'])):
            $foto       =   $_FILES['efoto']['name'];
            $target_dir="img/";
            $target_file=$target_dir.basename($foto);
            move_uploaded_file($_FILES['efoto']['tmp_name'],$target_file);
            $foto=", foto='".$_FILES['efoto']['name']."'";
        endif;

        $data="nombre='".$nombre."',apellido='".$apellido."'".$foto;
        $u  =   $user->actualizar("alumnos",$data,"id=".$id);
        if($u):
            $res['mensaje']="Edicion exitosa";
        else:
            $res['mensaje']="Aun no hay registros";
            $res['error']=true;
        endif;
        break;
    
    case 'eliminar':
        $id     =   $_POST['did'];
        $u  =   $user->borrar("alumnos","id=".$id);
        if($u):
            $res['mensaje']="Eliminacion exitosa";
        else:
            $res['mensaje']="Aun no hay registros";
            $res['error']=true;
        endif;
        break;    


    default:
    break;
}
//nos retorna json
echo json_encode($res);
die();
?>