<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <!-- utf-8  -->
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <!-- Keine initiale Skalierung oder Beschränkung -->
   <meta name="viewport" content="width=device-width">
   <!-- Edge-Engine erzwingen, wie geht es mit der neuesten Version auf Chromium-Basis weiter? -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Kein auto-scale in iOS  -->
   <meta name="x-apple-disable-message-reformatting">
   <!-- TITEL / [%if anrede = 'i' or lastname=''], keine Anrede/kein Nachname![%elseif anrede='hr'], Herr [lastname]![%elseif anrede='fr'], Frau [lastname]![%endif]  -->
   <title>TODO: Titel eintragen! </title>

   <style>
      body,
      #bodyTable {
         height: 100% !important;
         width: 100% !important;
         margin: 0;
         padding: 0;
      }

      /*  Webkit, IE: Keine Änderung der Textgröße 
            Outlook: Regel für Zeilenabstände
            Webkit: Besseres Font-Rendering
        */
      * {
         -ms-text-size-adjust: 100%;
         -webkit-text-size-adjust: 100%;
         /*        -webkit-font-smoothing: antialiased !important; */
         mso-line-height-rule: exactly;
      }

      /* Yahoo: volle Fensterbreite. */
      .thread-item.expanded .thread-body .body,
      .msg-body {
         width: 100% !important;
         display: block !important;
         background-color: #f4f4f4;
      }

      /* Yahoo: entfernt Link-Styling */
      .yshortcuts a {
         border-bottom: none !important;
      }

      /* Hotmail: volle Fensterbreite. */
      .ReadMsgBody,
      .ExternalClass {
         width: 100%;
         background-color: #f4f4f4;
      }

      /* Hotmail: "richtige" Zeilenabstände. */
      .ExternalClass,
      .ExternalClass p,
      .ExternalClass span,
      .ExternalClass font,
      .ExternalClass td,
      .ExternalClass div {
         line-height: 100%;
      }

      /* Webkit: korrigiert Padding */
      table {
         border-spacing: 0 !important;
         border-collapse: collapse !important;
      }

      /* Outlook 2007, 2010, Gmail: korrigert Padding und entfernt Abstände um die Tabelle. */
      table,
      td {
         border-collapse: collapse;
         mso-table-lspace: 0pt;
         mso-table-rspace: 0pt;
      }

      /* Internet Explorer: ändert den Algo beim Rendern skalierter Bilder. */
      img {
         -ms-interpolation-mode: bicubic;
      }

      /* Entfernt Rahmen und Textdekorationen in Bildern. 
           Zur Sicherheit teilweise auch als inline-Attribute angegeben. */
      img,
      a img {
         border: 0;
         outline: none;
         text-decoration: none;
      }

      /* iOS: kein Link-Styling */
      *[x-apple-data-detectors] {
         border-bottom: 0 !important;
         cursor: default !important;
         color: inherit !important;
         text-decoration: none !important;
         font-size: inherit !important;
         font-family: inherit !important;
         font-weight: inherit !important;
         line-height: inherit !important;
      }

      /* Style für Trademarks-, Registered-Symbole im Text. */
      sup {
         vertical-align: top;
         position: relative;
         top: -3px;
      }

      #logo {
         width: 100% !important;
         max-width: 80px !important;
         height: auto !important;
         padding: 0px;
      }


      /* MEDIA QUERIES */

      /*** 0 bis 600px ******/

      @media screen and (max-device-width: 600px),
      screen and (max-width: 600px) {

         /* Tabelle nimmt die gesamte Breite des Fensters ein 
                Inline im Markup: Breite 600px.
                Wirkung: Skalierung, wenn Fenster unter 600px, Maximale Breite 600px, wenn über 600px */
         table[class="content-container"] {
            width: 100% !important;
         }

         /* Tabelle nimmt die gesamte Breite des Fensters ein */
         table[class="fluid"] {
            width: 100% !important;
         }

         /* Bilder mit dieser Klasse skalieren proportional auf 100% der Zellenbreite */
         img[class="fit-in"] {
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
         }

         /* Zwingt Tabellenspalten auf 100% Tabellenbreite
                Aus Tabellenspalten werden Zeilenartige */
         td[class="force-col-to-row"] {
            display: block !important;
            width: 100% !important;
            clear: both;
         }

      }


      /* DARK- UND LIGHTMODE */

      :root {
         color-scheme: light dark;
         supported-color-schemes: light dark;
      }

      @media (prefers-color-scheme: light) {

         /* Shows Light Mode-Only Content */
         .light {
            background-color: #fff !important;
            color: #000 !important;
         }

         .menu {
            background-color: #00752E !important;
            color: #fff !important;
         }
      }

      @media (prefers-color-scheme: dark) {

         /* Shows Light Mode-Only Content */
         .light {
            background-color: #fff !important;
            color: #000 !important;
         }

         .menu {
            background-color: #00752E !important;
            color: #fff !important;
         }

      }

      /* Dark Mode for support in Outlook App */
      [data-ogsc] .light {
         background-color: #fff !important;
         color: #000 !important;
      }

      [data-ogsc] .menu {
         background-color: #00752E !important;
         color: #fff !important;
      }

      /* Light Mode for support in Outlook App */
      [data-ogsb] .light {
         background-color: #fff !important;
         color: #000 !important;
      }

      [data-ogsc] .menu {
         background-color: #00752E !important;
         color: #fff !important;
      }




      table[class="content-container"] {
         border: 0px solid #0f0;

      }

      body {
         margin: 0px;
         font-family: Arial, Helvetica;
         line-height: 20px;
         font-size: 16px;
         font-weight: normal;
         color: #333;
      }

      h1 {
         font-family: Arial, Helvetica;
         line-height: 34px;
         font-size: 24px;
         font-weight: 500;
         margin: 0;
         padding: 0;
      }

      .text,
      p {
         font-family: Arial, Helvetica;
         line-height: 20px;
         font-size: 16px;
         font-weight: normal;
         color: #333;
      }

      .label {
         line-height: 20px;
         font-size: 16px;
         font-weight: 500;
         color: #333;
      }

      .trenner_gruen {
         font-family: Arial, Helvetica;
         line-height: 20px;
         font-size: 18px;
         font-weight: 500;
         color: #00752e;
      }

      .trenner_gruen>.trennlinie {
         height: 2px;
         background-color: #00752e;
         width: 100%;
         margin: 0 0 5px 0;
      }

      .spalte-links {
         vertical-align: top;
         width: 50%;
      }

      .spalte-rechts {
         vertical-align: top;
         width: 50%;
      }

      .trenner_grau {
         width: 100%;
         height: 1px;
      }

      .trenner_grau>.trennlinie {
         height: 2px;
         background-color: #333;
         width: 100%;
      }

      .textarea {
         font-family: Arial, Helvetica;
         line-height: 20px; /* 4.23mm converted to pixels */
         font-size: 16px; /* 10pt converted to pixels */
         font-weight: normal;
         color: #333;
      }

      .leerzeile {
         height: 20px;
         width: 100%;
      }

      .schreiblinie {
         height: 1px;
         background-color: #999;
         width: 100%;
      }

      .zeile {
          height: 20px;
         width: 100%;
         background-color: #79B51C;
         margin: 0;
         padding: 0;
      }
   </style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#fff" style="background: #CCC; margin:0; padding:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;">

   <!-- PREHEADER: BEGIN -->
   <div style="display: none !important; mso-hide:all; font-size:0; max-height:0; line-height:0; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0">
      <p style="font-family: sans-serif; font-size: 14px; line-height: 18px;  color: #444444;">
         {{ $titel ?? '' }}
      </p>
   </div>
   <!-- PREHEADER: ENDE -->

   <!-- BODY TABLE: BEGIN -->
   <table id="bodyTable" height="100%" width="100%" bgcolor="#fff" style="border-collapse: collapse; table-layout: fixed; margin:0 auto; background: #fff;" cellpadding="0" cellspacing="0" border="0">
      <tbody>
         <tr>
            <td>
               <table width="600" class="content-container" style="margin: auto;" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" border="0">
                     <tbody>
                        <tr>
                           <td style="padding: 10px 10px 10px 20px; width: 90px">
                              <a href="" style="text-decoration: none; color: #fff" target="_blank">
                                 <img id="logo" src="https://drc.de/sites/all/themes/drc/logo.png" width="80px" alt="DRC Logo" style="width: 80px">
                              </a>
                           </td>
                           </tr>
                     </tbody>
               </table>
               <table width="600" class="content-container" style="margin: auto;" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" border="0">
                     <tbody>
                        <tr>
                           <td>
