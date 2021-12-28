<?php if (isLogged() && isAdminAccess()) { ?>

<?php $cats = getColEnum("vlak", "kategorie"); ?>
<?php manageTrain(); ?>
<h3>Přidat vlak</h3>
<div id="trains">
  <div id="add_train">
  <form action="" method="post">
  <table>
    <tr>
		<td><span class="req">Číslo vlaku:</span></td>
		<td><input type="text" name="train" placeholder="Číslo vlaku" required value="<?php if(isset($_POST["train"])) echo $_POST["train"];?>" required /></td>
	</tr>
	<tr>
		<td>Název vlaku:</td>
		<td><input type="text" name="name" placeholder="Název vlaku" value="<?php if(isset($_POST["name"])) echo $_POST["name"];?>" /></td>
	</tr>
    <tr>
		<td><span class="req">Kategorie vlaku:</span></td>
		<td>
		<select name="cat">
       <?php 
          foreach($cats as $cat)
          { ?>
             <option value="<?php echo $cat ?>" <?php if(isset($_POST["cat"]) && $_POST["cat"] == $cat) echo "selected";?>><?php echo $cat; ?></option>
          <?php }
       ?>
		</select>
		</td>
	</tr>
	<tr>
		<td><span class="req">Dopravce:</span></td>
		<td><select name="ic">
		   <?php 
		   $array = getCompany();
		   foreach ($array as $val)
		  {
		  ?>
			 <option value="<?php echo $val['ic']; ?>" <?php if(isset($_POST["ic"]) && $_POST["ic"] == $val['ic']) echo "selected";?>><?php echo $val['nazev']; ?></option>
		  
		  <?php } ?>
		</select></td>
	</tr>
	<tr>
		<td>Řazení vlaku:</td>
		<td><input type="text" name="con" placeholder="Řazení vlaku" value="<?php if(isset($_POST["con"])) echo $_POST["con"];?>" /></td>
	</tr>
	<tr>
		<td><input type="hidden" name="add_trainEvent" value="true" />
		<input type="submit" value="Vložit" /></td>
	</tr>
  </table>
  </form>
  </div>
	
  <hr />
  <br />

  <h3>Seznam vlaků:</h3>
  <div class="tab">
  <table>
  <thead class="center">
  <tr>
        <td>Číslo vlaku</td>
        <td>Název vlaku</td>
        <td>Kategorie</td>
        <td>Řazení</td>
        <td>Dopravce</td>
        <td colspan="2">Akce</td>
      </tr>
  </thead>
  <?php
    $array = getTrains(); $i=0;
     
    foreach ($array as $val)
    {
      ?> 
      <tr>
      <form action="" method="post" id="ftr<?= $i ?>">
        <td id="tr<?= $i ?>a"><?= $val['cislo']; ?></td>
        <td id="tr<?= $i ?>b"><?= $val['vlak_nazev']; ?></td>
        <td id="tr<?= $i ?>c"><?= $val['kategorie']; ?></td>
        <td id="tr<?= $i ?>d"><?= $val['razeni']; ?></td>
        <td id="tr<?= $i ?>e"><?= $val['dopravce_nazev']; ?></td>
        <td><form method="post" action="">
          <input type="submit" id="tr<?= $i ?>" onClick="return editVlak('tr<?= $i ?>');" value="EDITOVAT" />
          <input type="hidden" name="editaceVlaku" value="true" />
        </form></td>
        <td><form method="get" action="/admin/novy_rad/">
          <input type="hidden" value="<?php echo $val['cislo']; ?>" name="train" />
          <input type="submit" value="Jízdní řád a služby" />
        </form></td>
      </tr>
      
      <?php
    $i++; }
  ?>
  
  </table>
  </div>
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