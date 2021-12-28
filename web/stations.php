<?php if (isLogged() && isAdminAccess()) { ?>

<h3>Přidat stanici</h3>
<form action="" method="post">
<table>
    <tr>
        <td><span class="req">Název stanice</span></td>
        <td><input type="text" name="nazev" placeholder="Název stanice" required value="<?php if(isset($_POST["nazev"])) echo $_POST["nazev"];?>" /></td>
    </tr>
    <tr>
        <td><input type="hidden" name="addStationEvent" value="true" />
            <input type="submit" value="Vložit" /></td>
    </tr>
</table>
</form>

 <hr />
  <br />

  <h3>Seznam stanic:</h3>
  <div class="tab">
  <table>
  <thead class="center">
    <tr>
        <td>Název</td>
        <td>Provozní doba</td>
		<td>Telefon</td>
    </tr>
  </thead>
  <?php
    $array = getAllStations();

    foreach ($array as $val)
    { ?>     
      <tr>
        <td><?php echo $val['nazev']; ?></td>
        <td><?php echo $val['provoz_doba']; ?></td>
		<td><?php echo $val['telefon']; ?></td>
      </tr>
      
      <?php
    }
  ?>
  
  </table>
  </div>
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