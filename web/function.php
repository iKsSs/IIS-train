<?php
  $session_time = (60*60*24*30);
  session_set_cookie_params($session_time);
  session_cache_expire(ceil($session_time / 60));
  session_start();
  
  DB::connect();
  
  class DB 
  {	
  	private static $count;
  	private static $index;
  	private static $result;
    private static $dblink;
  	
  	public static function connect()
  	{
		
		$conf = parse_ini_file("config.ini", TRUE);
		
  		$SQL_HOST = 	$conf['database']['db_host'];
  		$SQL_USERNAME = $conf['database']['db_login'];
  		$SQL_PASSWORD = $conf['database']['db_password'];
  		$SQL_DBNAME = 	$conf['database']['db_name'];
  
  		self::$dblink = mysql_connect($SQL_HOST, $SQL_USERNAME, $SQL_PASSWORD);
  		mysql_select_db($SQL_DBNAME);
  			
  		mysql_query("SET character_set_client=UTF8", self::$dblink) or die (printError("Chyba SQL dotazu: ".mysql_error()));
  		mysql_query("SET character_set_connection=UTF8", self::$dblink) or die (printError("Chyba SQL dotazu: ".mysql_error()));
  		mysql_query("SET character_set_results=UTF8", self::$dblink) or die (printError("Chyba SQL dotazu: ".mysql_error()));
  	}
  		
  	public static function sqlInput($sql)
  	{
  		return mysql_real_escape_string(htmlspecialchars($sql));
  	}
  		
  	public static function setSelectQuery($sql)
  	{			
  		self::$result = mysql_query($sql, self::$dblink) or die(printError("Chyba SQL dotazu: ".mysql_error()." ".$sql));
  		self::$count = mysql_num_rows(self::$result);
  		self::$index = 0;
  	}
  	
  	public static function setQuery($sql)
  	{
  		self::$result = mysql_query($sql, self::$dblink) or die(printError("Chyba SQL dotazu: ".mysql_error()." ".$sql));
  	}
  		
  	public static function getItem()
  	{
  		return mysql_fetch_array(self::$result, MYSQL_ASSOC);
  	}
    
    public static function getCount()
    {
      return self::$count;
    }
  }
			
  function includeContent($page, $isAdmin = false)
  {
  	//$page = $_GET["page"];
  			
  	if ($page == null and $isAdmin == false)
  	{
  		$page = 'spojeni';
  	}
  	
  	if (file_exists(dirname(__FILE__).'/'.$page.'.php')) 
  	{
  		include $page.'.php';    
  	}
  }
    	
  function manageUser()
  {
    if(isset($_POST["registerEvent"]))
    {
      $name = DB::sqlInput($_POST["name"]);
      $surname = DB::sqlInput($_POST["surname"]);
      $password = DB::sqlInput($_POST["password"]);
      $mail = DB::sqlInput($_POST["mail"]);
      $login = DB::sqlInput($_POST["login"]);
      
      $hash = MD5(SHA1($password));
      
	  if ( $name == "" || $surname == "" || $password == "" || $mail == "" || $login == "" )
	  {
		  printError("V??echna pole mus?? b??t vypln??na");
	  }
	  else if (!is_string($name))
	  {
		  printError("Jm??no nesm?? b??t ????slo");
	  }
	  else if (!is_string($surname))
	  {
		  printError("P????jmen?? nesm?? b??t ????slo");
	  }
	  else if (!ereg("^.+@.+\..+$", $mail))
	  {
		  printError("E-mail m?? ??patn?? tvar");
	  }
	  else 
	  {	  
		DB::setSelectQuery("SELECT id FROM zakaznik WHERE login LIKE '$login'");

		if ( DB::getCount() == 0 )
		{
		  $sql = "INSERT INTO zakaznik VALUES(DEFAULT, '$name', '$surname', '$login', '$hash', '$mail', 1)";

		  DB::setQuery($sql);

		  unset($_POST);
		  printDone("Registrace prob??hla v po????dku.");
		}
		else
		{
		  printError("Chyba - $login login je ji?? obsazen");
		}
	  }
    }
    else if(isset($_POST["loginEvent"]))
    {
      $login = DB::sqlInput($_POST["login"]);
	  $password = DB::sqlInput($_POST["password"]);
      	
	  $hash = MD5(SHA1($password));
      
	  if ( $login == "" || $password == "" )
	  {
		  printError("Ob?? pole mus?? b??t vypln??na");
	  }
	  else
	  { 
		DB::setSelectQuery("SELECT id FROM zakaznik WHERE login LIKE '$login' AND heslo LIKE '$hash' AND aktivni = 1");

		$var = DB::getItem();

		if (DB::getCount())
		{						
			session_regenerate_id();
			$_SESSION["logged"] = true;
			$_SESSION["id"] = $var['id'];
			$_SESSION["role"] = "zakaznik";

			header("Location: /");
		}
		else 
		{
			printError("Chyba p??ihl????en??");
		}
	  }
    }
    else if(isset($_POST["registerAdminEvent"]))
    {
      $password = DB::sqlInput($_POST["password"]);
      $admin = DB::sqlInput($_POST["admin"]);
      $login = DB::sqlInput($_POST["login"]);
      
      $hash = MD5(SHA1($password));

	  if ( $login == "" )
	  {
		  printError("Pole login mus?? b??t vypln??no");
	  }
	  else if ( $password == "" )
	  {
		  printError("Pole heslo mus?? b??t vypln??no");
	  }
	  else 
	  {
		DB::setSelectQuery("SELECT id FROM spravce WHERE login LIKE '$login'");

		if ( DB::getCount() == 0 )
		{
		  $sql = "INSERT INTO spravce VALUES(DEFAULT, '$login', '$hash', '$admin', DEFAULT)";

		  DB::setQuery($sql);

		  unset($_POST);
		  printDone("Registrace prob??hla v po????dku.");
		}
		else
		{
		  printError("Chyba - $login login je ji?? obsazen");
		}
	  }
    }
    else if(isset($_POST["loginAdminEvent"]))
    {
      $login = DB::sqlInput($_POST["login"]);
	  $password = DB::sqlInput($_POST["password"]);	
      
	  $hash = MD5(SHA1($password));
      
	  if ( $login == "" || $password == "" )
	  {
		  printError("Ob?? pole mus?? b??t vypln??na");
	  }
	  else
	  { 
		DB::setSelectQuery("SELECT id, admin FROM spravce WHERE login LIKE '$login' AND heslo LIKE '$hash' AND aktivni = 1");

		$var = DB::getItem();

		if (DB::getCount())
		{						
			session_regenerate_id();
			$_SESSION["logged"] = true;
			$_SESSION["id"] = $var['id'];
			$_SESSION["role"] = $var['admin'] ? "admin" : "spravce";

			header("Location: /admin/");
		}
		else 
		{
			printError("Chyba p??ihl????en??");
		}
	  }
    }
    else if(isset($_POST['deleteUserEvent']))
    {
      $user_id = getSessionId();
      
      $sql = "UPDATE zakaznik SET aktivni = 0 WHERE id = '$user_id'"; 
                              
      DB::setQuery($sql);
      
      //a musi odhlasit
      
      session_unset();
	  session_destroy(); 
      
	  printDone("Registrace ??sp????n?? zru??ena");
	  
      header("Refresh: 3 /");
    }   
    else if(isset($_POST["editProfileEvent"]))  
    {
      $name = DB::sqlInput($_POST['name']);
      $surname = DB::sqlInput($_POST['surname']);
	  $password = DB::sqlInput($_POST["password"]);
      $mail = DB::sqlInput($_POST['mail']);
	  
      $hash = MD5(SHA1($password));
	  
      $id = DB::sqlInput(getSessionId());
 
	  if ( $name == "" || $surname == "" || $password == "" || $mail == "" )
	  {
		  printError("V??echna pole mus?? b??t vypln??na");
	  }
	  else if (!is_string($name))
	  {
		  printError("Jm??no nesm?? b??t ????slo");
	  }
	  else if (!is_string($surname))
	  {
		  printError("P????jmen?? nesm?? b??t ????slo");
	  }
	  else if (!ereg("^.+@.+\..+$", $mail))
	  {
		  printError("E-mail m?? ??patn?? tvar");
	  }
	  else 
	  {	   
		$sql = "SELECT heslo FROM zakaznik WHERE id = '$id'";
		DB::setQuery($sql);

		if ( DB::getItem()['heslo'] == $hash )
		{    
		  $sql = "UPDATE zakaznik SET jmeno = '$name', prijmeni = '$surname', email = '$mail' WHERE id = '$id'";

		  DB::setQuery($sql);
		  
		  unset($_POST);
		  printDone("Zm??na ??daj?? ??sp????n?? provedena");
		}
		else
		{
			printError("Chybn?? heslo");
		}
	  } 
	}
  }
  
  function logout()
  {
    if(isset($_POST['logoutEvent']))
    {
      session_unset();
      session_destroy();

      header("Location: /");
    }
  }
  
  function getProfileInfo()
  {
    $id = DB::sqlInput(getSessionId());
            
    $sql = "SELECT jmeno, prijmeni, email FROM zakaznik WHERE id = '$id'";
        
    DB::setSelectQuery($sql);
    
    return DB::getItem();
  }
  
  function getTrainComposition($a)
  {
    $result = array();
    
    $result = explode("+", $a);
        
    return $result;
  }
  
  function getTrainServices($train)
  {
    $result_array = array();
    
    $sql = "SELECT id, nazev, cena FROM sluzba WHERE vlak_cislo = '$train'";
    
    DB::setSelectQuery($sql);
    
    while (($row = DB::getItem()))
    {          
      array_push($result_array, $row);
    }
    
    return $result_array;
  }
  
  function getSearch()
  {
    $result_array = array(); 
    
    if (isset($_GET['search_event']))
    {
      $from = DB::sqlInput($_GET['from']);
      $to = DB::sqlInput($_GET['to']);
      $time = DB::sqlInput($_GET['time']);
  	
	  $col = strpos($time, ":");
	  $hour = substr($time, 0, $col);
	  $min = substr($time, $col+1);
	  
	  if ( $from == "" || $to == "" || $time == "" )
	  {
		  printError("V??echna pole mus?? b??t vypln??na");
	  }
	  else if ( !($col > 0 && $hour >= 0 && $hour < 24 && $min >= 0 && $min < 60) )
	  {
		  printError("??as mus?? b??t ve from??tu HH:MM v rozsahu 00:00 - 23:59");
	  }
	  else
	  {
		$sql =    
		  "SELECT vlak.razeni AS razeni, dopravce.nazev AS dopravce, id_0, id_1, nazev_0, nazev_1, km_0, km_1, vlak.kategorie AS kategorie, vlak.cislo AS vlak_cislo, 
		  TIME_FORMAT(odjezd, '%H:%i') AS odjezd, TIME_FORMAT(prijezd, '%H:%i') AS prijezd, 
		  TIME_FORMAT(TIMEDIFF(prijezd,odjezd), '%H:%i') AS doba_jizdy, km_1-km_0 AS vzdalenost, (km_1-km_0)*dopravce.cena_km AS cena, vlak.nazev AS vlak_nazev
		   FROM vlak, (
		  SELECT J.vlak_cislo AS vlak_0, J.staniceni AS km_0, J.odjezd AS odjezd, Z.nazev AS nazev_0, Z.id AS id_0
			FROM jizdni_rad J, zastavka Z 
			WHERE J.zastavka_id = Z.id AND Z.nazev LIKE '%".$from."%') 
		  AS start_stanice, 
		  (SELECT J.vlak_cislo AS vlak_1, J.staniceni AS km_1, J.prijezd AS prijezd, Z.nazev AS nazev_1, Z.id AS id_1 
			FROM jizdni_rad J, zastavka Z  
			WHERE J.zastavka_id = Z.id AND Z.nazev LIKE '%".$to."%') 
		  AS end_stanice, dopravce WHERE dopravce.ic = vlak.dopravce_ic AND vlak_0 = vlak_1 AND km_0 < km_1 AND vlak.cislo = vlak_0 AND 
		  odjezd >= STR_TO_DATE('".$time."', '%H:%i') 
		  ORDER BY odjezd LIMIT 10";

		 DB::setSelectQuery($sql);

		 while (($row = DB::getItem()))
		 {          
			array_push($result_array, $row);
		 }
		 
		 if (empty($result_array))
		 {
			 printDone("????dn?? spoj nenalezen");
		 }
	  }
    }
    
    return $result_array;
  }
  
  if (isset($_SESSION['BUY_ACTIVITY']) && (time() - $_SESSION['BUY_ACTIVITY'] > 300)) {
		// last request was more than 5 minutes ago
		unset($_SESSION['train']);
		unset($_SESSION['services']);
		unset($_SESSION['from']);
		unset($_SESSION['to']);
		unset($_SESSION['price']);
		unset($_SESSION['date']); 	
		unset($_SESSION['BUY_ACTIVITY']);
  }

  function manageTicket()
  {
    if(isset($_POST['buyEvent']))
    {     
      $services = array();
      
      $train = DB::sqlInput($_POST['train']);
      $services = $_POST['services'];   
      $from = DB::sqlInput($_POST['from']);
      $to = DB::sqlInput($_POST['to']);
      $price = DB::sqlInput($_POST['price']);
      $date = DB::sqlInput($_POST['date']);
      
      $id = getSessionId();

	  if ( !isset($id) || isAdmin() || isSpravce() ) 
	  {
		$_SESSION['train'] = $train;
		$_SESSION['services'] = $services;
		$_SESSION['from'] = $from;
		$_SESSION['to'] = $to;
		$_SESSION['price'] = $price;
		$_SESSION['date'] = $date; 
		
		$_SESSION['BUY_ACTIVITY'] = time();
		
		header("Location: /identifikace/");die;
	  }
	  	  
      $validity_to = $date;

	  $sum = 0;
	  
      foreach ($services as $service_id)
      {
        $sql = "SELECT cena FROM sluzba WHERE id = '".DB::sqlInput($service_id)."'";
                
        DB::setSelectQuery($sql); 
        
        $sum += DB::getItem()['cena']; 
      }
      
      $price += $sum;
            
      //vlozeni do jizdenky
      $sql = "INSERT INTO doklad VALUES(DEFAULT, '$price', DATE_ADD(STR_TO_DATE('$validity_to', '%d.%m.%Y'), INTERVAL 1 DAY), '$id', '$from', '$to', '$train', 'aktivni')";
      
      DB::setQuery($sql);
      
      //a sluzby
      $sql = "SELECT LAST_INSERT_ID() AS id";
      
      DB::setSelectQuery($sql);
      
      $ticket_id = DB::getItem()['id'];
            
      foreach ($services as $service_id)
      {
        $sql = "INSERT INTO zak_sluzba VALUES('$service_id', '$ticket_id')";
                
        DB::setQuery($sql); 
      }  
	  
	  unset($_POST);
	  printDone("Va??e objedn??vka byla zaregistrov??na");
    }
    else if(isset($_POST['buyEventUnregistred']))
    {     
      $services = array();
      
	  $jmeno = DB::sqlInput($_POST['name']);
	  $prijmeni = DB::sqlInput($_POST['surname']);
	  $email = DB::sqlInput($_POST['mail']);
	  
	  if (!isset($_SESSION['train']))
	  {
		  printError("Je n??m l??to, ale objedn??vka expirovala");
		  return 3;
	  }
	  else if ( $jmeno == "" || $prijmeni == "" || $email == "" )
	  {
		  printError("V??echna pole mus?? b??t vypln??na");
	  }
	  else if (!is_string($jmeno))
	  {
		  printError("Jm??no nesm?? b??t ????slo");
	  }
	  else if (!is_string($prijmeni))
	  {
		  printError("P????jmen?? nesm?? b??t ????slo");
	  }
	  else if (!ereg("^.+@.+\..+$", $email))
	  {
		  printError("E-mail m?? ??patn?? tvar");
	  }
	  else 
	  {
		$train = $_SESSION['train'];
		$services = $_SESSION['services'];   
		$from = $_SESSION['from'];
		$to = $_SESSION['to'];
		$price = $_SESSION['price'];
		$date = $_SESSION['date'];

		unset($_SESSION['train']);
		unset($_SESSION['services']);   
		unset($_SESSION['from']);
		unset($_SESSION['to']);
		unset($_SESSION['price']);
		unset($_SESSION['date']);

		$validity_to = date("d.m.Y", strtotime(date("d.m.Y", $date) . " +1 day"));

		$sum = 0;

		foreach ($services as $service_id)
		{
		  $sql = "SELECT cena FROM sluzba WHERE id = ".$service_id;

		  DB::setSelectQuery($sql); 

		  $sum += DB::getItem()['cena']; 
		}

		$price += $sum;

		$sql = "SELECT * FROM zakaznik WHERE jmeno = '$jmeno' AND prijmeni = '$prijmeni' AND email = '$email' AND ISNULL(login)";

		DB::setSelectQuery($sql);

		if ( DB::getCount() )
		{
			$id = DB::getItem()['id'];
		}
		else
		{
		  //vytvoreni noveho neregistrovaneho
		  $sql = "INSERT INTO zakaznik (id, jmeno, prijmeni, email, aktivni) VALUES(DEFAULT, '$jmeno', '$prijmeni', '$email', 0)";

		  DB::setQuery($sql);

		  $id = mysql_insert_id();
		}

		//vlozeni do jizdenky
		$sql = "INSERT INTO doklad VALUES(DEFAULT, '$price', STR_TO_DATE('$validity_to', '%d.%m.%Y'), '$id', '$from', '$to', '$train', 'aktivni')";

		DB::setQuery($sql);

		//a sluzby
		$sql = "SELECT LAST_INSERT_ID() AS id";

		DB::setSelectQuery($sql);

		$ticket_id = DB::getItem()['id'];

		foreach ($services as $service_id)
		{
		  $sql = "INSERT INTO zak_sluzba VALUES($service_id, $ticket_id)";

		  DB::setQuery($sql); 
		}  

		unset($_POST);
		printDone("Va??e objedn??vka byla zaregistrov??na");

		header("Refresh: 3 /");

		return 5;
	  }
    }
    else if(isset($_POST["refundTicketEvent"]))
    {
      $ticket_id = DB::sqlInput($_POST['ticket_id']);  
      
      $sql = "UPDATE doklad SET stav = 'neaktivni' WHERE id = '$ticket_id'";
                        
      DB::setQuery($sql);       
    }
	else if (isset($_POST["acceptComplaint"]))
    {
      $id = DB::sqlInput($_POST["id"]);
      
      $sql = "UPDATE doklad SET stav='zruseny' WHERE id = '$id'";
      
      DB::setQuery($sql);

      printDone("Reklamace provedena");
    }
	else if (isset($_POST["rejectComplaint"]))
    {
      $id = DB::sqlInput($_POST["id"]);
      
      $sql = "UPDATE doklad SET stav='aktivni' WHERE id = '$id'";
      
      DB::setQuery($sql);

      printDone("Reklamace zam??tnuta");
    }
  }
  
  function getAdminUsers()
  {
    $result_array = array();
    
    $sql = "SELECT * FROM spravce";
    
    DB::setSelectQuery($sql);
    
    while (($row = DB::getItem()))
    {          
      array_push($result_array, $row);
    }
    
    return $result_array;
  }

  function getUsers()
  {
    $result_array = array();
    
    $sql = "SELECT * FROM zakaznik";
    
    DB::setSelectQuery($sql);
    
    while (($row = DB::getItem()))
    {          
      array_push($result_array, $row);
    }
    
    return $result_array;
  }
  
  function isAdmin()
  { 
    $role = DB::sqlInput(getSessionRole());
    
    if ( $role == "admin" ) 
        return TRUE;
    else
        return FALSE;
  }
  
  function isSpravce()
  {
      $role = DB::sqlInput(getSessionRole());
      
      if ($role == "spravce")
          return TRUE;
      else
          return FALSE;
  }
  
  function isCustomer()
  {
      $role = DB::sqlInput(getSessionRole());
      
      if ($role == "zakaznik")
        return TRUE;
      else
		return FALSE;
  }
  
  function ticketActive($stav)
  {
    if($stav == 'aktivni') return "";
    else if($stav == 'neaktivni') return " | ??ek?? na vy????zen?? reklamace"; 
    else return " | doklad je stornov??n";  
  }
    
  function isLogged()
  {
    return isset($_SESSION['logged']);
  }
  
  function getSessionId()
  {
    return $_SESSION['id'];
  }
  
  function getSessionRole()
  {
    return $_SESSION['role'];
  }
   
  function getColEnum($table, $col)
  {
    $result_array = array();
    $sql = "SHOW COLUMNS FROM $table LIKE '$col'";
    
    DB::setSelectQuery($sql);
    
    $result = DB::getItem();
    
    $result_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $result['Type']));
    
    return $result_array;
  }
  
  function printError($msg)
  {
  	echo "<div class='error'>";
    echo $msg;
    echo "</div>";
  }                               
  
  function printDone($msg)
  {
  	echo "<div class='done'>";
    echo $msg;
    echo "</div>";	
  }
  
  function getCompany()
  {
    $result_array = array();
    $sql = "SELECT * FROM dopravce";
    
    DB::setSelectQuery($sql);
    
    while (($row = DB::getItem()))
    {          
      array_push($result_array, $row);
    }    
        
    return $result_array;
  }
  
  function getTrains()
  {
    $result_array = array();
    $sql = "SELECT cislo, vlak.nazev AS vlak_nazev, kategorie, razeni, dopravce.nazev AS dopravce_nazev FROM vlak, dopravce WHERE dopravce.ic = vlak.dopravce_ic";
    
    DB::setSelectQuery($sql);
        
    while (($row = DB::getItem()))
    {          
      array_push($result_array, $row);
    }    
        
    return $result_array;
  }
  
  function manageTrain()
  {
    if(isset($_POST["add_trainEvent"]))
    {
      $train = DB::sqlInput($_POST["train"]);
      $name = DB::sqlInput($_POST["name"]);
      $cat = DB::sqlInput($_POST["cat"]);
      $ic = DB::sqlInput($_POST["ic"]);
      $con = DB::sqlInput($_POST["con"]);
       
	  $sql = "SELECT * FROM vlak WHERE cislo = '$train'";
	  DB::setSelectQuery($sql);
	  
	  if(DB::getCount())
	  {
		  printError("????slo vlaku mus?? b??t unik??tn??");
	  }
	  else if(!is_numeric($train)) 
	  {
		  printError("????slo vlaku mus?? b??t ????slo");
	  }
	  else if($name != "")
	  {
		$sql = "SELECT * FROM vlak WHERE nazev LIKE '$name'";
		DB::setSelectQuery($sql);

		if(DB::getCount())
		{
			printError("N??zev vlaku mus?? b??t unik??tn??");
		}
	  }
	  else
	  {
		$sql = "INSERT INTO vlak VALUES('$train', '$name', '$cat', '$con', $ic)";

		DB::setQuery($sql);

		unset($_POST);
		printDone("Vlak byl ??sp????n?? ulo??en");
	  }
    }
	else if(isset($_POST["editaceVlaku"]))
    {       
      $id = DB::sqlInput($_POST["id"]);
      $nazev = DB::sqlInput($_POST["nazev"]);
      $kateg = DB::sqlInput($_POST["kateg"]);
      $razen = DB::sqlInput($_POST["razen"]);
      $dopra = DB::sqlInput($_POST["dopra"]);
  
      DB::setSelectQuery("SELECT ic FROM dopravce WHERE nazev LIKE '$dopra'");
      $dopra = DB::getItem()['ic'];

	  if($nazev != "")
	  {
		$sql = "SELECT * FROM vlak WHERE nazev LIKE '$nazev' AND cislo != '$id'";
		DB::setSelectQuery($sql);

		if(DB::getCount())
		{
			printError("N??zev vlaku mus?? b??t unik??tn??");
		}
	  }
	  	  
        $sql = "UPDATE vlak SET nazev='$nazev',
               kategorie='$kateg', razeni='$razen', dopravce_ic='$dopra' WHERE cislo='$id'";
			   
        DB::setQuery($sql);
  
		unset($_POST);
        printDone("Zm??na ??daj?? vlaku provedena.");
	  
    }
  }
  
  function getTickets()
  {
    $result_array = array();
    
    $sql = "SELECT stav, id, platnost_do, cena, cislo, nazev, kategorie, razeni, dopravce, 
    TIME_FORMAT(odjezd, '%H:%i') AS odjezd, TIME_FORMAT(prijezd, '%H:%i') AS prijezd, 
    prum_zpoz, TIME_FORMAT(TIMEDIFF(prijezd,odjezd), '%H:%i') AS doba_jizdy, km_1-km_0 AS vzdalenost, 
    (SELECT nazev FROM zastavka WHERE id = zastavka_z) AS zastavka_od, 
    (SELECT nazev FROM zastavka WHERE id = zastavka_do) AS zastavka_do 
    
    FROM doklad, 
    (SELECT cislo, nazev, kategorie, razeni,
             (SELECT nazev FROM dopravce WHERE ic = dopravce_ic) AS dopravce
        FROM vlak
    ) AS vlaka,
    (SELECT vlak_cislo, zastavka_id, odjezd, prum_zpoz, staniceni AS km_0
        FROM jizdni_rad
    ) AS jizda_z,
    (SELECT vlak_cislo, zastavka_id, prijezd, staniceni AS km_1
        FROM jizdni_rad
    ) AS jizda_do
    
    WHERE zakaznik_id = '" . getSessionId() . "' 
    AND pro_vlak = vlaka.cislo
    AND zastavka_z = jizda_z.zastavka_id AND pro_vlak = jizda_z.vlak_cislo 
    AND zastavka_do = jizda_do.zastavka_id AND pro_vlak = jizda_do.vlak_cislo
    ORDER BY platnost_do DESC";
   
    DB::setSelectQuery($sql);
    
	while (($row = DB::getItem()))
	{          
	   array_push($result_array, $row);
	}
    
    return $result_array;
  }
  
  function getAllTickets()
  {
    $result_array = array();
	
	$sql = "SELECT stav, id, platnost_do, cena, cislo, nazev, kategorie, razeni, dopravce, (SELECT login FROM zakaznik WHERE id = zakaznik_id) AS login,
    TIME_FORMAT(odjezd, '%H:%i') AS odjezd, TIME_FORMAT(prijezd, '%H:%i') AS prijezd, 
    prum_zpoz, TIME_FORMAT(TIMEDIFF(prijezd,odjezd), '%H:%i') AS doba_jizdy, km_1-km_0 AS vzdalenost, 
    (SELECT nazev FROM zastavka WHERE id = zastavka_z) AS zastavka_od, 
    (SELECT nazev FROM zastavka WHERE id = zastavka_do) AS zastavka_do 
    
    FROM doklad, 
    (SELECT cislo, nazev, kategorie, razeni,
             (SELECT nazev FROM dopravce WHERE ic = dopravce_ic) AS dopravce
        FROM vlak
    ) AS vlaka,
    (SELECT vlak_cislo, zastavka_id, odjezd, prum_zpoz, staniceni AS km_0
        FROM jizdni_rad
    ) AS jizda_z,
    (SELECT vlak_cislo, zastavka_id, prijezd, staniceni AS km_1
        FROM jizdni_rad
    ) AS jizda_do
    
    WHERE pro_vlak = vlaka.cislo
    AND zastavka_z = jizda_z.zastavka_id AND pro_vlak = jizda_z.vlak_cislo 
    AND zastavka_do = jizda_do.zastavka_id AND pro_vlak = jizda_do.vlak_cislo
	AND stav = 'neaktivni'
    ORDER BY platnost_do DESC";

    DB::setSelectQuery($sql);
    
	while (($row = DB::getItem()))
	{          
	   array_push($result_array, $row);
	}
	
	if (empty($result_array))
	{
		printDone("????dn?? j??zn?? doklad k reklamaci nenalezen");
	}
    
    return $result_array;
  }
  
  function getTicketServices($id)
  {
    $result_array = array();
    
    $sql = "SELECT nazev FROM zak_sluzba, sluzba WHERE sluzba.id = zak_sluzba.sluzba_id AND zak_sluzba.doklad_id = '$id'";
    
    DB::setSelectQuery($sql);
    
    while (($row = DB::getItem()))
    {          
      array_push($result_array, $row);
    }
    
    return $result_array;
  }
  
  function manageCompany()
  {
    if(isset($_POST['addCompanyEvent']))
    {
      $ic = DB::sqlInput($_POST['icd']);
      $name = DB::sqlInput($_POST['name']);
      $price = DB::sqlInput($_POST['price']);
      
      if (!isIcValid($ic))
      {
        printError("I?? nespl??uje po??adavky");
        return;
      }
	  
	  $sql = "SELECT * FROM dopravce WHERE ic = $ic";
	  DB::setSelectQuery($sql);
	  
	  if(DB::getCount())
	  {
		  printError("I?? dopravce mus?? b??t unik??tn??");
	  }
	  else if(!is_numeric($ic)) 
	  {
		  printError("I?? dopravce mus?? b??t ????slo");
	  }
	  else if(!is_numeric($price)) 
	  {
		  printError("Sazebn??k dopravce mus?? b??t ????slo");
	  }
      else
	  {
		$sql = "INSERT INTO dopravce VALUES('$ic', '$name', $price)";

		DB::setQuery($sql);

		unset($_POST);
		printDone("Dopravce ??sp????n?? vytvo??en");
	  }
    }
  }
    
  function getTimetable($id)
  {
    $result_array = array();
    
    $sql = "SELECT * FROM jizdni_rad WHERE vlak_cislo = '$id'";
    
    DB::setSelectQuery($sql);
    
    while (($row = DB::getItem()))
    {          
      array_push($result_array, $row);
    }
   
    $c = count($result_array);

    for ( $i = 0; $i < $c; $i++ ) 
    {                       
       $result_array[$i]['zastavka_id'] =  DB::getItem(DB::setSelectQuery("SELECT nazev FROM zastavka WHERE id = '" . $result_array[$i]['zastavka_id'] . "'"))['nazev'];    
    }  
    
    return $result_array;
  }
  
  function getServices($id)
  {
    $result_array = array();
    
    $sql = "SELECT * FROM sluzba WHERE vlak_cislo = '$id'";
    
    DB::setSelectQuery($sql);
    
    while (($row = DB::getItem()))
    {          
      array_push($result_array, $row);
    }
    
    return $result_array;
  }
  
  function manageStation()
  {
      if (isset($_POST['addStationEvent']))
      {
        $nazev = DB::sqlInput($_POST['nazev']);

		$sql = "SELECT * FROM zastavka WHERE nazev LIKE '$nazev'";
		DB::setSelectQuery($sql);

		if(DB::getCount())
		{
			printError("N??zev stanice mus?? b??t unik??tn??");
			return;
		}
		else 
	    {
			$sql = "INSERT INTO zastavka VALUES(DEFAULT, '$nazev', NULL, NULL)";

			DB::setQuery($sql);

			unset($_POST);
			printDone("Stanice ??sp????n?? vytvo??ena");
		}
	  }
  }
  
  function manageTimetable()
  {
    if(isset($_POST['deleteTimetableRowEvent']))
    {
        $id = DB::sqlInput($_POST['id']);
        
        $sql = "DELETE FROM jizdni_rad WHERE id = '$id'";

        DB::setQuery($sql);
		
		unset($_POST);
		printDone("Zast??vka byla ??sp????n?? odstran??na z j??zdn??ho ????du");
    }
    else if(isset($_POST["ulozRad"]))
  	{
  		$count = DB::sqlInput($_POST["count"]);
  		$vlak = DB::sqlInput($_POST["vlak"]);
  	
  		for ( $i=0; $i < $count; $i++) 
  		{
  			$time = DB::sqlInput($_POST["time$i"]);
  			$time2 = DB::sqlInput($_POST["times$i"]);
  			$zastavka = DB::sqlInput($_POST["zastavka$i"]);
  			$staniceni = DB::sqlInput($_POST["staniceni$i"]);
  
			$col = strpos($time, ":");
			$hour = substr($time, 0, $col);
			$min = substr($time, $col+1);
			
			$col2 = strpos($time2, ":");
			$hour2 = substr($time2, 0, $col2);
			$min2 = substr($time2, $col2+1);
			
			$exp = ($hour2 + 60/$min2) - ($hour + 60/$min);
			
			if ( $time == "" || $time2 == "" || $staniceni == "" )
			{
				printError("V??echna pole mus?? b??t vypln??na - ????dek ". $i+1);
				return;
			}
			else if ( !($col > 0 && $hour >= 0 && $hour < 24 && $min >= 0 && $min < 60) )
			{
				printError("??as p????jezdu mus?? b??t ve from??tu HH:MM v rozsahu 00:00 - 23:59 - ????dek ". $i+1);
				return;
			}
			else if ( !($col2 > 0 && $hour2 >= 0 && $hour2 < 24 && $min2 >= 0 && $min2 < 60) )
			{
				printError("??as odjezdu mus?? b??t ve from??tu HH:MM v rozsahu 00:00 - 23:59 - ????dek ". $i+1);
				return;
			}
			else if ( $exp < 0 )
			{
				printError("??as odjezdu mus?? b??t pozd??ji ne?? ??as p????jezdu - ????dek ". $i+1);
				return;
			}
			else if (!is_numeric($staniceni))
			{
				printError("Staniceni mus?? b??t ????slo - ????dek ". $i+1);
				return;
			}
			
  			$sql = "SELECT id FROM zastavka WHERE nazev LIKE '$zastavka'";
  			DB::setSelectQuery($sql);
  			$zastavka = DB::getItem()['id'];
  
  			$sql = "INSERT INTO jizdni_rad
  			VALUES(DEFAULT, '$time', '$time2', '0', '$vlak', '$zastavka', '$staniceni')";
  
            DB::setQuery($sql);	
  		}
		
		unset($_POST);
  		printDone("Zast??vky ??sp????n?? p??id??ny do j??zdn??ho ????du");	
	}
	else if (isset($_POST['addServiceEvent']))
    {
        $name = DB::sqlInput($_POST['name']);
		$price = DB::sqlInput($_POST['price']);
		$id = DB::sqlInput($_POST['id_vlak']);

		$sql = "SELECT * FROM sluzba WHERE vlak_cislo = '$id' AND nazev = '$name'";

		DB::setSelectQuery($sql);
		
		if (DB::getCount())
		{
			printError("Pro vlak ??. $id ji?? takov?? slu??ba existuje");
		}
		else if( $name == "" | $price == "" )
		{
			printError("Ob?? pole mus?? b??t vypln??na");
		}
		else if( !is_numeric($price) )
		{
			printError("Cena mus?? b??t ????slo");
		}
		else 
	    {
			$sql = "INSERT INTO sluzba VALUES(DEFAULT, '$name', '$price', '$id')";

			DB::setQuery($sql);

			unset($_POST);
			printDone("Slu??ba ??sp????n?? p??id??na");
		}
	}
  }
  
  function getTransporters()
  {
	$php_array = array();
	DB::setSelectQuery("SELECT nazev FROM dopravce");
	while ($row = DB::getItem()) {
		array_push($php_array, $row['nazev']);
	}
	return $php_array;
  }
  
  function getStations()
  {
	$php_array = array();
	DB::setSelectQuery("SELECT nazev FROM zastavka ORDER BY nazev");
	
	while ($row = DB::getItem()) {
		array_push($php_array, $row['nazev']);
	}
	return $php_array;
  }
  
  function getAllStations()
  {
	$php_array = array();
	DB::setSelectQuery("SELECT * FROM zastavka ORDER BY nazev");
	
	while ($row = DB::getItem()) {
		array_push($php_array, $row);
	}
	return $php_array;
  }
  
  function manageAdmin()
  {
    if(isset($_POST["aktivaceAdmina"]))
    {
      $login = DB::sqlInput($_POST["login"]);
      $akce = DB::sqlInput($_POST["akce"]) === "AKTIVOVAT" ? 1 : 0;
      
      $sql = "UPDATE spravce SET aktivni=$akce WHERE login = '$login'";
      
      DB::setQuery($sql);

	  unset($_POST);
      printDone("Zm??na aktivity admina/spr??vce provedena");
    }
    else if(isset($_POST["aktivaceUzivatele"]))
    {
      $login = DB::sqlInput($_POST["login"]);
      $akce = DB::sqlInput($_POST["akce"]) === "AKTIVOVAT" ? 1 : 0;
      
      $sql = "UPDATE zakaznik SET aktivni=$akce WHERE login = '$login'";
      
      DB::setQuery($sql);

	  unset($_POST);
      printDone("Zm??na aktivity z??kazn??ka provedena");
    }
    else if(isset($_POST["editaceAdmina"]))
    {       
      $id = DB::sqlInput($_POST["id"]);
      $login = DB::sqlInput($_POST["login"]);
      $admin = DB::sqlInput($_POST["admin"]);
      $adm = ($admin === "true") ? 1 : 0;

      $sql = "SELECT id FROM spravce WHERE login = '$login'";

      DB::setSelectQuery($sql);
    
	  if ( $login == "" )
	  {
		  printError("Login mus?? b??t vypln??n");
	  }
	  else if (DB::getCount() != 0 && $login != $id) 
      {
        printError("Chyba - dan?? login je ji?? obsazen");
      }
      else
      {  
        $sql = "UPDATE spravce SET login='$login', admin='$adm' WHERE login = '$id'";
  
        DB::setQuery($sql);
  
		unset($_POST);
        printDone("Zm??na ??daj?? admina/spr??vce provedena.");
      }
    }
    else if(isset($_POST["editaceUzivatele"]))
    {       
      $id = DB::sqlInput($_POST["id"]);
      $jmeno = DB::sqlInput($_POST["jmeno"]);
      $prijm = DB::sqlInput($_POST["prijm"]);
      $login = DB::sqlInput($_POST["login"]);
      $email = DB::sqlInput($_POST["email"]);

      $sql = "SELECT id FROM zakaznik WHERE login = '$login'";

      DB::setSelectQuery($sql);

      if ( $login == "" )
	  {
		  printError("Login mus?? b??t vypln??n");
	  }
	  else if (DB::getCount() != 0 && $login != $id) 
      {
        printError("Chyba - dan?? login je ji?? obsazen");
      }
	  else if (!is_string($jmeno))
	  {
		  printError("Jm??no nesm?? b??t ????slo");
	  }
	  else if (!is_string($prijm))
	  {
		  printError("P????jmen?? nesm?? b??t ????slo");
	  }
	  else if (!ereg("^.+@.+\..+$", $email))
	  {
		  printError("E-mail m?? ??patn?? tvar");
	  }
      else
      {
        $sql = "UPDATE zakaznik SET jmeno='$jmeno', prijmeni='$prijm',
                 login='$login', email='$email' WHERE login = '$id'";
  
        DB::setQuery($sql);
  
		unset($_POST);
        printDone("Zm??na ??daj?? u??ivatele provedena.");
      }
    } 
  }
  
  function isAdminAccess()
  {
      $role = getSessionRole();
      
      if ($role == "admin" || $role == "spravce")
          return TRUE;
      else
          return FALSE;
  }
  
  function isIcValid($ico)
  {
      $cifra8 = $ico / 10000000;
      $cifra7 = ($ico / 1000000) % 10;
      $cifra6 = ($ico / 100000) % 10;
      $cifra5 = ($ico / 10000) % 10;
      $cifra4 = ($ico / 1000) % 10;
      $cifra3 = ($ico / 100) % 10;
      $cifra2 = ($ico / 10) % 10;
      $cifra1 = $ico % 10;
      $suma = $cifra8 * 8 + $cifra7 * 7 + $cifra6 * 6 + $cifra5 * 5 + $cifra4 * 4 + $cifra3 * 3 + $cifra2 * 2;
      $mod1 = $suma % 11;
      $mod2 = (11 - $mod1) % 10;

      if($mod2 != $cifra1)
          return false;
        
      return true;
  }