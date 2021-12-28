<?php if (isLogged() && isAdminAccess()) { ?>

<h3>Přidat dopravce</h3>

<div id="company">
  <form action="" method="post">
    <table>
      <tr>
		<td><span class="req">Identifikační číslo</span></td>
        <td><input type="text" name="icd" required placeholder="Identifikační číslo" value="<?php if(isset($_POST["icd"])) echo $_POST["icd"];?>" /></td>
      </tr>
      <tr>
        <td><span class="req">Název dopravce</span></td>
        <td><input type="text" name="name" required placeholder="Název dopravce" value="<?php if(isset($_POST["name"])) echo $_POST["name"];?>" /></td>
      </tr>
      <tr>
        <td><span class="req">Sazebník za kilometr</span></td>
        <td><input type="text" name="price" required placeholder="Sazebník za kilometr" value="<?php if(isset($_POST["price"])) echo $_POST["price"];?>" /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="addCompanyEvent" value="true" />
        <input type="submit" value="Vložit" /></td>
      </tr>
    </table>
  </form>

 <hr />
  <br />
	
  <h3>Seznam dopravců:</h3>
  <div class="tab">
  <table>
  <thead class="center">
    <tr>
        <td>Název</td>
        <td>IČ</td>
		<td>Sazebník [Kč/km]</td>
    </tr>
  </thead>
  <?php
    $array = getCompany();
     
    foreach ($array as $val)
    { ?>     
      <tr>
        <td><?php echo $val['nazev']; ?></td>
        <td><?php echo $val['ic']; ?></td>
		<td><?php echo $val['cena_km']; ?></td>
      </tr>
      
      <?php
    }
  ?>
  
  </table>
  </div>
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
