<?php manageTicket(); ?>
  <div id="search">	 
	  <h3>Vyhledání spoje</h3>
    <form method="get" action="#">
      <table>		
        <tr>
          <td>Odkud</td>
          <td><input type="text" name="from" id="from" placeholder="Odkud" required value="<?php echo $_GET['from']; ?>" tabindex="1" /></td>
          <td rowspan="2"><input class="swap" type="button" title="Prohodit výchozí a cílovou stanici" value="" onClick="ToSwapFrom();" /></td>
		  <td></td>
        </tr>
        <tr>
          <td>Kam</td>		
          <td><input type="text" name="to" id="to" placeholder="Kam" required value="<?php echo $_GET['to']; ?>" tabindex="2" /></td>
		  <td></td>
        </tr>
        <tr>
          <td>Datum a čas</td>	
          <td><input type="text" name="date" id="date" placeholder="Kdy (např. 10.12.2015)" required value="<?php echo $_GET['date']; ?>" tabindex="3" /></td>	
          <td><input type="text" name="time" id="time" placeholder="V kolik (např. 13:25)" required value="<?php echo $_GET['time']; ?>" tabindex="4" /></td>				
          <td><input class="today" type="button" title="Vložit aktuální datum a čas" value="" onClick="today();" /></td>
        </tr>
        <tr>
          <td><input type="hidden" name="search_event" value="true" />
          <input type="submit" value="Vyhledat" tabindex="5" /></td>
		  <td></td>
		  <td></td>
		  <td></td>
        </tr>
      </table>	  
    </form>	
  </div>
<div id="result">
  <?php $array = getSearch(); ?> 
  <?php foreach($array as $val) { ?>  
  <div class="item">    
    <div class="head">      
      <h3 class="left"> <?php echo $val['odjezd']; ?> | 
		  <a href="/jizdni_rad/?vlak=<?php echo $val['vlak_cislo']; ?>"><?php echo $val['kategorie'] . " " . $val['vlak_cislo'] ." ". $val['vlak_nazev']; ?></a>  
	  </h3>      
      <h3 class="right">
      ,- Kč
      </h3>
      <h3 class="right">        
        <?php echo $val['cena']; ?>     
      </h3>    
    </div>    
    <div class="info"> 
      <div class="left"> 
        <table> 
          <tr> 
          <td>Odjezd:</td><td> <?php echo $val['odjezd']; ?> (<?php echo $val['nazev_0']; ?>)</td>
          </tr>
          <tr>
          <td>Příjezd:</td><td> <?php echo $val['prijezd']; ?> (<?php echo $val['nazev_1']; ?>)</td>
          </tr>
          <tr>      
          <td>Doba jizdy:</td><td> <?php echo $val['doba_jizdy']; ?></td> 
          </tr>
          <tr>     
          <td>Vzdálenost:</td><td> <?php echo $val['vzdalenost']; ?> km</td> 
          </tr>
          <tr>
          <td>Dopravce:</td><td> <?php echo $val['dopravce']; ?></td>
          </tr>
        </table>      
      </div>
      <div class="right">
      <form method="post" action="">
      <?php foreach(getTrainServices($val['vlak_cislo']) as $val2) { ?>
          <label>
            <?php echo $val2['nazev'] ?>: 
            <span><?php echo $val2['cena'] ?></span>,- Kč
            <input type="checkbox" name="services[]" onChange="changePrice(this)" value="<?php echo $val2['id'] ?>" />
          </label> <br />
      <?php } ?>
        <input type="hidden" name="train" value="<?php echo $val['vlak_cislo']; ?>" />
        <input type="hidden" name="from" value="<?php echo $val['id_0']; ?>" />
        <input type="hidden" name="to" value="<?php echo $val['id_1']; ?>" />
        <input type="hidden" name="price" value="<?php echo $val['cena']; ?>" />
        <input type="hidden" name="date" value="<?php echo $_GET['date']; ?>" />
        <input type="hidden" name="buyEvent" value="true" />
        <input type="submit" value="Koupit" />
      </form>
       </div>
		
	<div class="comp">
		<?php 
		  $array = getTrainComposition($val['razeni']);

		  foreach ($array as $item)
		  {
			 ?>
				<img src="<?php echo "/img/".$item.".gif"; ?>" alt="<?php echo $item; ?>" />
			 <?php
		  }
		?>
     </div>
    </div>  
  </div>  
  <?php } ?>
</div>