<?php manageUser(); ?>
<h3>Registrace nového zákazníka:</h3>

<div id="registration">    
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
      <td><span class="req">Přihlašovací jméno</span></td>
      <td><input type="text" name="login" placeholder="Přihlašovací jméno" required value="<?php if(isset($_POST["login"])) echo $_POST["login"];?>" /></td>	
    </tr>
    <tr>
      <td><span class="req">Heslo</span></td>
      <td><input type="password" name="password" placeholder="Heslo" required /></td>	
    </tr>
    <tr>
      <td><span class="req">E-mail</span></td>
      <td><input type="text" name="mail" placeholder="E-mail" required value="<?php if(isset($_POST["mail"])) echo $_POST["mail"];?>" /></td>	
    </tr>
    <tr>
      <td><input type="hidden" name="registerEvent" value="true" />
      <input type="submit" value="Zaregistrovat se" /></td>
    </tr>
    </table>  
  </form>
</div>