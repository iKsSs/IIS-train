<?php if (isLogged() && isAdminAccess()) { ?>

<?php manageTicket(); ?>
<div id="result">
  <h3>Jízdní doklady s žádostí o reklamaci:</h3>  
<?php $array = getAllTickets(); ?> 
<?php foreach($array as $val) { ?>  
  <div class="item">  
	  <div class="head">
	  <div class="right">
		<form action="" method="post">
		   <input type="submit" name="accept" value="POTVRDIT" class="complaint" />
		   <input type="hidden" name="id" value="<?= $val['id'] ?>" />
		   <input type="hidden" name="acceptComplaint" value="true" />
		</form>
		<form action="" method="post">
			<input type="submit" name="reject" value="ZAMÍTNOUT" class="complaint" />
			<input type="hidden" name="id" value="<?= $val['id'] ?>" />
			<input type="hidden" name="rejectComplaint" value="true" />
		</form>
	</div>     
      <h3 class="left"><?= $val['login']." : "?><?php echo $val['zastavka_od'] . " - " . $val['zastavka_do']; ?> | <a href="/jizdni_rad/?vlak=<?php echo $val['cislo']; ?>"><?php echo $val['kategorie'] . " " . $val['cislo'] ." ". $val['vlak_nazev']; ?></a> 
      | Platnost do: <?php echo $val['platnost_do']; ?> </h3>  
    </div> 
    <div class="info"> 
      <div class="left"> 
        <table class="tickets"> 
          <tr> 
          <td>Odjezd:</td><td><?php echo $val['odjezd']; ?></td>
          <td>Příjezd:</td><td><?php echo $val['prijezd']; ?></td>    
          <td>Vzdálenost:</td><td><?php echo $val['vzdalenost']; ?> km</td> 
          <td>Dopravce:</td><td><?php echo $val['dopravce']; ?></td>
		  <td>Cena:</td><td><?= substr($val['cena'],0,strpos($val['cena'],".")) ?>,- Kč</td>
          </tr>
        </table>  
      </div>
    </div>  
  </div>  
<?php } ?>

<?php } else { ?>
<!-- prihlaseni -->

<h3>Přihlášení do administrace</h3>
<form action="" method="post">
    <table>
        <tr>
            <td><span class="req">Uživatelské jméno</span></td>
        <td><input type="text" name="login" placeholder="Uživatelské jméno" required /></td>
      </tr>
      <tr>
		  <td><span class="req">Heslo</span></td>	
        <td><input type="password" name="password" placeholder="Heslo" required /></td>
        </tr>
        <tr>
            <td><input type="hidden" name="loginAdminEvent" value="true" />
                <input type="submit" value="Přihlásit se" /></td>
        </tr>
    </table>
</form>

<?php } ?>