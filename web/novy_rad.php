<?php manageTimetable(); ?>
<?php manageStation(); ?>

<?php 
	$vlak = $_GET['train']; 

	$php_array = getStations(); 
	$sel = "";

	foreach( $php_array as $val ) 
	{
		$sel .= "<option>".$val."</option>"; 
	}

?>

<div id="txtSearch"></div>
<div class="right back"><a href="javascript: history.back();">Zpět</a></div>
<h3>Jízdní řád</h3>
<h4>Číslo vlaku: <span id="n_vlak"><?= $vlak ?></span></h4>
<hr />
<br />
<form id="ns" action="" method="post">
<table>
  <tr>
    <td>Příjezd (HH:MM)</td><td>Odjezd (HH:MM)</td><td>Zastávka</td><td>Staniceni [km]</td>
	<td><button onclick="return false;" class="add_new">+</button></td>
  </tr>  
      <tr>
          <td><input type="text" name="time" class="n_time" /></td>	
          <td><input type="text" name="time2" class="n_time2" /></td>				
          <td><select name="zastavka" class="n_zastavka"><?= $sel ?></select></td>	
		  <td><input type="text" name="staniceni" class="n_staniceni" /></td>	
		  <td>
			<button onclick="return false;" class="add_new">+</button><button onclick="return false;" class="sub_new">-</button>
		  </td>	
      </tr>
	  <tr>
		  <input type="hidden" name="ulozRad" value="true" />
          <td><input type="submit" id="sav_new" value="Vložit" /></td>
      </tr> 
</table>
</form>

<?php $array = getTimetable($vlak); ?> 
<?php if (!empty($array)) : ?>
<div class="tab">
<table>
	<thead class="center">
  <tr>
    <td>Zastávka</td>
    <td>Příjezd</td>
    <td>Odjezd</td>
    <td>Km</td>
	<td></td>
  </tr>  
	</thead>
  <?php foreach($array as $val) : ?>
    <tr>
      <td><?= $val['zastavka_id'] ?></td>
      <td><?= $val['prijezd'] ?></td>
      <td><?= $val['odjezd'] ?></td>
      <td><?= $val['staniceni'] ?></td>
      
      <td><form action="" method="post"><input type="hidden" name="deleteTimetableRowEvent" value="true" />
          <input type="hidden" name="id" value="<?= $val['id'] ?>" />
          <input type="submit" value="-" /></form></td>
    </tr>
  <?php endforeach; ?>
</table>
</div>
<?php endif; ?>

<br />

<h3>Služby</h3>
<?php $array = getServices($vlak); ?> 
<?php if (!empty($array)) : ?>
<table>
	<thead class="center">
	<tr>
	  <td>Název</td>
	  <td>Cena</td>
	</tr>  
	</thead>
  <?php foreach($array as $val) : ?>
    <tr>
      <td><?= $val['nazev'] ?></td>
      <td><?= $val['cena'] ?></td>
    </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>

<br />

<h4>Přidat službu</h4>

<form action="" method="post">
    <table>
        <tr>
            <td><span class="req">Název služby</span></td>
            <td><input type="text" name="name" required="" value="<?php echo $_POST['name']; ?>" />
        </tr>
        <tr>
            <td><span class="req">Cena služby</span></td>
            <td><input type="text" name="price" required="" value="<?php echo $_POST['price']; ?>" />
        </tr>
		<tr>
		  <input type="hidden" name="id_vlak" value="<?= $vlak ?>" />
		  <input type="hidden" name="addServiceEvent" value="true" />
          <td><input type="submit" value="Vložit" /></td>
		</tr>
    </table>
</form>
