
<h2><?php echo ($name) ?> &auml;r inloggad!</h2>
<p>Du var senast inloggad <?php echo ($time) ?> </p>
<h3> <?php echo ($account) ?> </h3>  
<p>
  Saldo: <?php echo ($balance . ' ' . $currency) ?>
</p>

<form action="?c=index&a=logout" method="POST"> 
  <input type="submit" name="logout" value="Logga ut!">
</form>