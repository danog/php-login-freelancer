<?php

ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
error_log( "Hello, errors!" );
include 'db_connect.php';
include 'functions.php';
include 'pages.php';

// Inserisci in questo punto il codice per la connessione al DB e l'utilizzo delle varie funzioni.
sec_session_start();
echo $headbase;
if(login_check($mysqli) == true) {
 $curuser = $_SESSION['username'];
 include 'pages.php';
 

 if ($curuser == "admin") {
  echo $admin;
  $space = "                                ";
  $fs = "    ";
  $tds = array("del", "passchange", "regolamento", "liberatoria", "corso", "email", "nome", "datadinascita", "luogodinascita", "residenza", "via", "cap", "n", "numero", "cf", "data", "printlib", "printiscr"); 


  $th = "$space$fs$fs<th><b>Nome utente</b></th>\n";
  $tddel = "$space$fs$fs<td><b>Elimina utente</b></td>\n";
  $tdpasschange = "$space$fs$fs<td><b>Cambia password</b></td>\n";
  $tdregolamento = "$space$fs$fs<td><b>Regolamento</b></td>\n";
  $tdnome = "$space$fs$fs<td><b>Nome e Cognome</b></td>\n";
  $tdemail = "$space$fs$fs<td><b>Email</b></td>\n";
  $tddatadinascita = "$space$fs$fs<td><b>Data di nascita</b></td>\n";
  $tdluogodinascita = "$space$fs$fs<td><b>Luogo di nascita</b></td>\n";
  $tdresidenza = "$space$fs$fs<td><b>Luogo di residenza</b></td>\n";
  $tdvia = "$space$fs$fs<td><b>Via</b></td>\n";
  $tdcap = "$space$fs$fs<td><b>C.A.P</b></td>\n";
  $tdn = "$space$fs$fs<td><b>Numero</b></td>\n";
  $tdnumero = "$space$fs$fs<td><b>Numero di telefono</b></td>\n";
  $tdcf = "$space$fs$fs<td><b>Codice fiscale</b></td>\n";
  $tddata = "$space$fs$fs<td><b>Data di iscrizione</b></td>\n";
  $tdcorso = "$space$fs$fs<td><b>Corso</b></td>\n";
  $tdliberatoria = "$space$fs$fs<td><b>Liberatoria</b></td>\n";
  $tdprintiscr = "$space$fs$fs<td><b>Stampa regolamento</b></td>\n";
  $tdprintlib = "$space$fs$fs<td><b>Stampa liberatoria</b></td>\n";

  $result = mysqli_query($mysqli,"SELECT * FROM `secure_login`.`members`");
  while($row = mysqli_fetch_array($result))
  {
  $user = $row['username'];
  if($user != "admin") {
   $del = "<input class=\"btn\"  type=\"button\" name=\"delete\" onClick=\"deleteuser('$user')\" value=\"Elimina\">\n";

   $passchange = "<input class=\"form-control\" type=\"password\" name=\"newname\" id=\"".$user."pass\" Placeholder=\"Nuova password\"><input type=\"button\" onClick=\"changeuserpass('$user')\" name=\"newname\" class=\"btn\" value=\"Cambia password\">";
   $regolamento = "";
   $nome = "";
   $email = "";
   $datadinascita = "";
   $luogodinascita = "";
   $residenza = "";
   $via = "";
   $cap = "";
   $n = "";
   $numero = "";
   $cf = "";
   $data = "";
   $corso = "";
   $liberatoria = "";
   $printlib = "";
   $printiscr = "";
   $u = $row['loggedin'] + $u;
   if($row['regolamento'] == "1") {
    
    $regolamento = "&#x2713;";
    $nome = $row['name'];
    $email = $row['email'];
    $datadinascita = $row['nascita'];
    $luogodinascita = $row['luogodinascita'];
    $residenza = $row['residenza'];
    $via = $row['via'];
    $cap = $row['cap'];
    $n = $row['numero'];
    $numero = $row['phone'];
    $cf = $row['cf'];
    $data = $row['date'];
    $printlib = "<input type=\"button\" class=\"btn\" id=\"$user\" onClick=\"printDiv('lib')\" name=\"newname\" value=\"Stampa liberatoria\">";
    $printiscr = "<input type=\"button\" class=\"btn\" onClick=\"printiscr('$user')\" name=\"newname\" value=\"Stampa modulo di iscrizione\">";
    if($row['corso'] == "1") {
     $corso = "base";
    } elseif($row['corso'] == "2") {
     $corso = "fantasy";
    };
    if($row['liberatoria'] == "1") {
     $liberatoria = "&#x2713;";
    } else {
     $liberatoria = "&#x2717;";
    };
   } else {
    $regolamento = "&#x2717;";
   };//End of regolamento exclusion

   $th = "$th$space$fs$fs<th>$user</th>\n";

   foreach ($tds as $value) {
    $td = "td$value";
    ${$td} = "${$td}$space$fs$fs<td id=\"$user$value\">${$value}</td>\n";
   };

  };//End of admin exclusion
  };//End of loop

  echo "$space$fs<tr>
$th
$space$fs</tr>
$space</thead>
$space<tbody>
";
  foreach ($tds as $value) {
   $td = "td$value";
   echo "$space$fs<tr>\n${$td}$space$fs</tr>\n";
  };
  if($u == "1"){
   $u = "Adesso c'&egrave 1 utente online.";
  } elseif($u == ""){
   $u = "Adesso ci sono 0 utenti online.";
  } else {
   $u = "Adesso ci sono $u utenti online.";
  };
  echo '                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="intro-text">
                        <h3><span class="eventi">Crea un nuovo utente</span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <form action="https://scuola.fantasiadanzarovigo.com/admin.php" method="post" name="login_form" id="login">
                         <div class="row control-group">
                             <fieldset id="inputs">
                                 <div class="form-group col-xs-12 floating-label-form-group controls">
                                     <input type="text" class="form-control" name="username"  placeholder="Nome utente" required data-validation-required-message="Prego inserire il nome utente"/><br />
                                     <p class="help-block text-danger"></p>
                                 </div>
                                 <div class="form-group col-xs-12 floating-label-form-group controls">
                                     <input type="password" class="form-control" name="p" id="password" placeholder="Password" required data-validation-required-message="Prego inserire la password"/><br />
                                     <p class="help-block text-danger"></p>
                                 </div>
                             </fieldset>
                         </div><br>
                         <div class="row">
                             <div class="form-group col-xs-12">
                                 <button type="button" value="Login" id="submitb" onclick="formhash(this.form, this.form.password);" class="btn btn-success btn-lg">Crea utente</button>
                             </div>
                         </div>
                     </form>
                 </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="intro-text">
                        <h3 class="eventi">'.$u.'</h3>
                    </div>
                </div>
            </div>
            <div class="row" id="regolamento" style="display:none">
                <div class="col-lg-12">
                    <img class="img-responsive img-centered" alt="AICS" src="img/aics.jpg">
                    <div class="intro-text">
                        <h3 class="eventi text-center"><b><i>Domanda di iscrizione</i></b></h3>
                        <p class="skills" style="text-align: right;" id="data"><b>Data</b> </p>
                        <p class="skills" id="nome"><b>Cognome e Nome</b> </p>
                        <p class="skills" style="display:inline-block;margin-right:10px;" id="datadinascita"><b>Data di nascita</b> </p>
                        <p class="skills" style="display:inline-block;" id="luogodinascita"><b>Luogo di nascita</b> </p><br>
                        <p class="skills" style="display:inline-block;margin-right:10px;" id="residenza"><b>Residente a</b> </p>
                        <p class="skills" style="display:inline-block;" id="cap"><b>C.A.P</b> </p><br>
                        <p class="skills" style="display:inline-block;margin-right:10px;" id="via"><b>Via</b> </p>
                        <p class="skills" style="display:inline-block;" id="n"><b>n^</b> </p>
                        <p class="skills" id="numero"><b>Tel - Cell</b> </p>
                        <p class="skills" id="email"><b>Email</b> </p>
                        <p class="skills" id="cf"><b>Codice Fiscale</b> </p>
                        <p class="skills" id="corso"><b>Corso</b> </p>
                        <h3 class="eventi text-center skills" style="font-style: italic;">Chiede</h3><p class="skills"><br>Di essere ammesso/a in qualit&agrave; di socio nel circolo Fantasia Danza Rovigo.<br>Dichiara di rispettare lo Statuto del Circolo e di essere stato invitato a prenderne visione.<br>Si impegna al pagamento della quota associativa annuale che da diritto alla partecipazione assembleare dei soci per l\'approvazione del bilancio entro il 30 Aprile di ogni anno.<br>A richiesta pu&ograve; ottenere copia dello Statuto.<br>Dichiara inoltre di accettare le norme assicurative previste nel tesseramento.<br></p><p class="skills" style="font-size:xx-small">Ai sensi della legge 196/03 consente il trattamento dei propri dati personali nella misura necessaria per il proseguimento degli scopi sintutari.</p><p class="skills text-center" style="font-size:larger"><br><br>Firma del richiedente ______________________________________________________________</p>
                    </div>
                </div>
            </div>
            <div class="row" style="display:none">
                <div class="col-lg-12">
                    <div class="intro-text">
                        '.$liberatoriatesto.'
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script data-cfasync="false">
    function printiscr(id) {
        var daniilarray = ["corso", "email", "nome", "datadinascita", "luogodinascita", "residenza", "via", "cap", "n", "numero", "cf", "data"];

        var arrayLength = daniilarray.length;
        for (var i = 0; i < arrayLength; i++) {
            cur = daniilarray[i];
            getin = "#"+id+cur;
            getout = "#"+cur;

            getin = $(getin).text();
            getout = $(getout).eq(0).html();
            getfull = getout+getin;
            document.getElementById(cur).innerHTML = getfull;
        }
        var printContents = document.getElementById("regolamento").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(true);

    }

    function printDiv(divName) {
         var printContents = document.getElementById(divName).innerHTML;
         var originalContents = document.body.innerHTML;
         document.body.innerHTML = printContents;
         window.print();
         document.body.innerHTML = originalContents;
    }
    </script>

';
 } else {
  if ($st = $mysqli->prepare("SELECT regolamento FROM members WHERE username=?")) {    
    $st->bind_param('s', $curuser); 
    // Esegui la query ottenuta.
    $st->execute();
    $st->bind_result($regol);
    $st->fetch();
  };
  error_log("regol for $curuser is $regol", 0);
  if($regol == "0") {
   $top = "$itop";
   $desc = "$idesc";
   $section = "$isection";
  } else {
   $top = "$normtop";
   $desc = "$normdesc";
   $section = "$normsection";
  };
  echo '
    <STYLE TYPE="text/css">
    <!--
    	@page { margin-left: 0.79in; margin-right: 0.79in; margin-top: 0.98in; margin-bottom: 0.79in }
    	P { margin-bottom: 0.08in; direction: ltr; widows: 2; orphans: 2 }
    -->
    </STYLE>
</head>
<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">Scuola Fantasia Danza</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>

'.$top.'


                    <li class="page-scroll">
                        <a href="https://scuola.fantasiadanzarovigo.com/logout.php">Esci</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" alt="" src="img/profile.png">
                    <div class="intro-text">
                        <span class="name">Scuola Fantasia Danza</span>
                        <hr class="star-light">
                        <span class="skills">Benvenuti nella sezione personale.</span><br>
                        <h4 class="skills">Azioni:</h4>
                        <br><span class="skills daniil page-scroll">'.$desc.'<br><br></span>
                        <img src="img/aics.jpg" alt="AICS" class="img-responsive img-centered">
                    </div>
                </div>
            </div>
        </div>
    </header>
'.$section.'

    <script>
    function showMe (box) {
        
        var chboxs = document.getElementsByName("regolamento");
        var vis = "none";
        for(var i=0;i<chboxs.length;i++) { 
            if(chboxs[i].checked){
             vis = "block";
                break;
            }
        }
        document.getElementById(box).style.display = vis;
    
    
    }
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
    </script>';

 };
 
} else {
 echo '
    <script type="text/javascript" src="sha512.js"></script>
    <script type="text/javascript" src="forms.js"></script>
    <style>
input, select, textarea{
    color: #ffffff;
}

textarea:focus, input:focus {
    color: #ffffff;
}
    </style>
</head>
<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">Login</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="http://fantasiadanzarovigo.com">Sito principale</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <img class="img-responsive" alt="" src="img/profile.png">
                    <div class="intro-text">
                        <span class="name">Effettua il login</span>
                        <hr class="star-light">
                        <form action="https://scuola.fantasiadanzarovigo.com/process_login.php" method="post" name="login_form" id="login">
                            <div class="row control-group">
                                <fieldset id="inputs">
                                    <div class="form-group col-xs-12 floating-label-form-group controls">
                                        <input type="text" class="form-control" name="username"  placeholder="Nome utente" required data-validation-required-message="Prego inserire il nome utente"/><br />
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group col-xs-12 floating-label-form-group controls">
                                        <input type="password" class="form-control" name="p" id="password" placeholder="Password" required data-validation-required-message="Prego inserire la password"/><br />
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </fieldset>
                            </div><br>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <button type="button" value="Login" id="submitb" onclick="formhash(this.form, this.form.password);" class="btn btn-success btn-lg">Login</button>
                                </div>
                            </div>
                        </form>
';
 if(isset($_GET['error'])) { 
  echo '
                        <h2 class="text-center corsi skills">ERRORE</h2>
';
 };
 echo '                    </div>
                </div>
            </div>
        </div>
    </header>
';
 
};
echo $footerbase;
?>
