<?php $array = getTimetable($_GET['vlak']); ?>  
<div id="jr">
<div class="right back"><a href="javascript: history.back();">Zpět</a></div>
<h3>Jízdní řád vlaku <?= $array[0]['vlak_cislo'] ?></h3>
	<div class="tab">
	<table>
	  <tr>
		<thead class="center">
		<td>Zastávka</td>
		<td>Příjezd</td>
		<td>Odjezd</td>
		<td>Zpoždění</td>
		<td>Km</td>
		</thead>
	  </tr>  
	  <?php foreach($array as $val) : ?>    
		<tr>
		  <td><?= $val['zastavka_id'] ?></td>
		  <td><?= $val['prijezd'] ?></td>
		  <td><?= $val['odjezd'] ?></td>
		  <td><?= $val['prum_zpoz'] ?></td>
		  <td><?= $val['staniceni'] ?></td>
		</tr>
	  <?php endforeach; ?>
	</table>
	</div>
	<br />

	<div class="comp">
		<?php 
		DB::setSelectQuery("SELECT * FROM vlak WHERE cislo = ".$array[0]['vlak_cislo']);
		
		  $array = getTrainComposition(DB::getItem()['razeni']);

		  foreach ($array as $item)
		  {
			 ?>
				<img src="<?php echo "/img/".$item.".gif"; ?>" alt="<?php echo $item; ?>" />
			 <?php
		  }
		?>
     </div>
</div>