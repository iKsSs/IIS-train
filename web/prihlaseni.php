<?php manageUser(); ?>

<h3>Přihlášení</h3>

<div id="login"> 
  <form action="" method="post">   
    <table>
      <tr>
        <td><span class="req">Přihlašovací jméno</span></td>
        <td><input type="text" name="login" placeholder="Přihlašovací jméno" required /></td>
      </tr>
      <tr>
		  <td><span class="req">Heslo</span></td>	
        <td><input type="password" name="password" placeholder="Heslo" required /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="loginEvent" value="true" />	
        <input type="submit" value="Přihlásit se" /></td>
      </tr>
    </table>
  </form> 
</div>

