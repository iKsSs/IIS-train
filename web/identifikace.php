<?php 
	$pom = manageTicket();
	if ( $pom != 5 ) {
?>
<div class="right back"><a href="javascript: history.go(-1);">Zpět</a></div>

<h3>Identifikace zákazníka</h3>

<div id="identifikace">    
  <form action="" method="post">
    <table>
    <tr>
      <td><span class="req">Jméno</span></td>
      <td><input type="text" name="name" placeholder="Jméno" required value="<?php if(isset($_POST["name"])) echo $_POST["name"];?>" /></td>
    </tr>
    <tr>
      <td><span class="req">Příjmení</span></td>
      <td><input type="text" name="surname" placeholder="Příjmení" required value="<?php if(isset($_POST["surname"])) echo $_POST["surname"];?>" /></td>	
    </tr>
    <tr>
      <td><span class="req">E-mail</span></td>
      <td><input type="text" name="mail" placeholder="E-mail" required value="<?php if(isset($_POST["mail"])) echo $_POST["mail"];?>" /></td>	
    </tr>
    <tr>
      <td><input type="hidden" name="buyEventUnregistred" value="true" />
      <input type="submit" value="Dokončit objednávku" /></td>
    </tr>
    </table>  
  </form>
</div>

<?php } ?>