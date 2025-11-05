<?php
require 'config.php'; ensure_login(); $mysqli=db_connect();
$msg='';$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $nombre=trim($_POST['nombre']??'');$unidades=(int)($_POST['unidades']??0);
 $tipo=$_POST['tipo']??'';$bodega=$_POST['bodega']??'';
 if($_POST['action']==='add'){
  $stmt=$mysqli->prepare("INSERT INTO articulos (nombre,unidades,tipo,bodega) VALUES(?,?,?,?)");
  $stmt->bind_param('siss',$nombre,$unidades,$tipo,$bodega);
  $stmt->execute();$stmt->close();$msg='Agregado';
 }
 if($_POST['action']==='edit'){
  $id=(int)$_POST['id'];
  $stmt=$mysqli->prepare("UPDATE articulos SET nombre=?,unidades=?,tipo=?,bodega=? WHERE id=?");
  $stmt->bind_param('sissi',$nombre,$unidades,$tipo,$bodega,$id);
  $stmt->execute();$stmt->close();$msg='Actualizado';
 }
}
if(isset($_GET['delete'])){
 $id=(int)$_GET['delete'];
 $stmt=$mysqli->prepare("DELETE FROM articulos WHERE id=?");
 $stmt->bind_param('i',$id);$stmt->execute();$stmt->close();$msg='Eliminado';
}
$res=$mysqli->query("SELECT * FROM articulos ORDER BY creado_en DESC");
$arts=$res->fetch_all(1);
$edit=null;
if(isset($_GET['edit'])){
 $id=(int)$_GET['edit'];
 $stmt=$mysqli->prepare("SELECT * FROM articulos WHERE id=?");
 $stmt->bind_param('i',$id);$stmt->execute();$r=$stmt->get_result();$edit=$r->fetch_assoc();$stmt->close();
}
?>
<!doctype html><html><head><meta charset="utf-8"><link rel="stylesheet" href="styles.css"><title>Artículos</title>
<script>function delIt(id){if(confirm('Eliminar?'))location='articles.php?delete='+id;}</script>
</head><body><div class="container"><div class="card">
<h2><?php echo $edit?'Editar':'Agregar'; ?> artículo</h2>
<?php if($msg):?><div style="color:green"><?=$msg?></div><?php endif;?>
<form method="post">
<input type="hidden" name="action" value="<?php echo $edit?'edit':'add';?>">
<?php if($edit):?><input type="hidden" name="id" value="<?=$edit['id']?>"><?php endif;?>
<input class="input" name="nombre" placeholder="Nombre" value="<?=h($edit['nombre']??'')?>" required><br><br>
<input class="input" type="number" name="unidades" value="<?=h($edit['unidades']??0)?>" required><br><br>
<select class="input" name="tipo">
<?php foreach(['PC','teclado','disco duro','mouse'] as $t){
$sel=$edit&&$edit['tipo']==$t?'selected':'';echo "<option $sel>$t</option>";}?>
</select><br><br>
<select class="input" name="bodega">
<?php foreach(['norte','sur','oriente','occidente'] as $b){
$sel=$edit&&$edit['bodega']==$b?'selected':'';echo "<option $sel>$b</option>";}?>
</select><br><br>
<button class="button btn-primary">Guardar</button>
</form></div><br>
<div class="card"><h3>Lista</h3><table class="table"><tr><th>Nombre</th><th>Uni</th><th>Tipo</th><th>Bodega</th><th></th></tr>
<?php foreach($arts as $a):?>
<tr><td><?=h($a['nombre'])?></td><td><?=h($a['unidades'])?></td><td><?=h($a['tipo'])?></td><td><?=h($a['bodega'])?></td>
<td><a href="articles.php?edit=<?=$a['id']?>">Editar</a> | <a href="#" onclick="delIt(<?=$a['id']?>)">Eliminar</a></td></tr>
<?php endforeach;?>
</table></div></div></body></html>
