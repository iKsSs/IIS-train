<?php if(isLogged() && isCustomer()) { ?>

<?php manageTicket(); ?>
<div id="result">
	<h3>Zakoupené jízdenky</h3>	
  <?php $array = getTickets(); ?> 
  <?php foreach($array as $val) { ?>  
  <div class="item">    
    <div class="head">      
      <h3 class="left"> <?php echo $val['zastavka_od'] . " - " . $val['zastavka_do']; ?> | <a href="/jizdni_rad/?vlak=<?php echo $val['cislo']; ?>"><?php echo $val['kategorie'] . " " . $val['cislo'] ." ". $val['vlak_nazev']; ?></a> 
      <?php echo ticketActive($val['stav']); ?> </h3>       
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
          <td>Odjezd:</td><td> <?php echo $val['odjezd']; ?></td>
          </tr>
          <tr>
          <td>Příjezd:</td><td> <?php echo $val['prijezd']; ?></td>
          </tr>
          <tr>      
          <td>Platnost do:</td><td> <?php echo $val['platnost_do']; ?></td> 
          </tr>
          <tr>     
          <td>Vzdálenost:</td><td> <?php echo $val['vzdalenost']; ?> km</td> 
          </tr>
          <tr>
          <td>Dopravce:</td><td> <?php echo $val['dopravce']; ?></td>
          </tr>
          <tr>
          <td>Služby k dokladu:</td><td>
            <?php foreach(getTicketServices($val['id']) as $val2)  { ?>
            <?php echo $val2['nazev']; ?> <br />
            <?php } ?>
          </tr>
        </table>    
      </div>
      <div class="right">
        
        <form action="" method="post">
          <input type="hidden" name="ticket_id" value="<?php echo $val['id']; ?>" />
          <input type="hidden" name="refundTicketEvent" value="true" />
          <input type="submit" value="Reklamovat" <?php if($val['stav'] != 'aktivni') echo "disabled"; ?> />
        </form>
      </div>
    </div>  
  </div>  
  <?php 
	} 
	if ( empty($array) ) {
  ?>
	<br />
	<h2>Litujeme, ale nemáte žádné zakoupené jízdenky.</h2>
  <?php
	}
  ?>
</div>  

 <?php } else { printError("Musíte být registrován a přihlášen"); } ?>  