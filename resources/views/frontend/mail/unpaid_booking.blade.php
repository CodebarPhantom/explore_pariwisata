<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Email Receipt</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
  /**
   * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
   */
  @media screen {
    @font-face {
      font-family: 'Source Sans Pro';
      font-style: normal;
      font-weight: 400;
      src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
    }

    @font-face {
      font-family: 'Source Sans Pro';
      font-style: normal;
      font-weight: 700;
      src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
    }
  }

  /**
   * Avoid browser level font resizing.
   * 1. Windows Mobile
   * 2. iOS / OSX
   */
  body,
  table,
  td,
  a {
    -ms-text-size-adjust: 100%; /* 1 */
    -webkit-text-size-adjust: 100%; /* 2 */
  }

  /**
   * Remove extra space added to tables and cells in Outlook.
   */
  table,
  td {
    mso-table-rspace: 0pt;
    mso-table-lspace: 0pt;
  }

  /**
   * Better fluid images in Internet Explorer.
   */
  img {
    -ms-interpolation-mode: bicubic;
  }

  /**
   * Remove blue links for iOS devices.
   */
  a[x-apple-data-detectors] {
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
    text-decoration: none !important;
  }

  /**
   * Fix centering issues in Android 4.4.
   */
  div[style*="margin: 16px 0;"] {
    margin: 0 !important;
  }

  body {
    width: 100% !important;
    height: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
  }

  /**
   * Collapse table borders to avoid space between cells.
   */
  table {
    border-collapse: collapse !important;
  }

  a {
    color: #1a82e2;
  }

  img {
    height: auto;
    line-height: 100%;
    text-decoration: none;
    border: 0;
    outline: none;
  }

  .button {
        display: block;
        width: 115px;
        height: 25px;
        background-color: #62a8ea;
        padding: .429rem 1rem;
        text-align: center;
        border: 1px solid transparent;
        border-color: #62a8ea;
        border-radius: .215rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.571429;
        cursor: pointer;
        vertical-align: middle;
        color: #fff !important;
        text-decoration: none;
    }
  </style>

</head>
<body style="background-color: #bdc3c7;">

  <!-- start preheader -->
  <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
   {{$detailReceipt['booking']->tourism_name}}
  </div>
  <!-- end preheader -->

  <!-- start body -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">

    <!-- start logo -->
    <tr>
      <td align="center" bgcolor="#bdc3c7">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="center" valign="top" style="padding: 36px 24px;">
              <a href="https://ulinyu.id" target="_blank" style="display: inline-block;">
                <img src="{{ ENV('APP_URL') }}/assets/images/assets/ulinyu.png" alt="Logo" border="0" width="150" style="display: block; width: 150px; max-width: 150px; min-width: 150px;">
              </a>
            </td>
          </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
    <!-- end logo -->

    <!-- start hero -->
    <tr>
      <td align="center" bgcolor="#bdc3c7">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">            
              <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;"> {{ $detailReceipt['booking']->tourism_name  }}</h1>
            </td>
          </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
    <!-- end hero -->

    <!-- start copy block -->
    <tr>
      <td align="center" bgcolor="#bdc3c7">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

          <!-- start copy -->
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
              <p style="margin: 0;">Terimakasih telah memesan tiket wisata di UlinYu berikut adalah rincian pemesananmu, silahkan lanjutkan pembayaranmu, jika belum login bisa dengan cara mencari kode unik sesuai dengan yang tertera dibawah ini</p>
            </td>
          </tr>
          <!-- end copy -->

          <!-- start receipt table -->
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td align="left" bgcolor="#bdc3c7" width="75%" style="padding: 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"><strong>CODE</strong></td>
                  <td align="left" bgcolor="#bdc3c7" width="25%" style="padding: 12px;font-family:helvetica, arial; font-size: 16px; line-height: 24px;"><strong>{{ $detailReceipt['booking']->code_unique }}</strong></td>
                </tr>
                @foreach ($detailReceipt['booking']->detail as $detailBooking)
                  <tr>
                    <td align="left" width="75%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">{{ $detailBooking->category_name.' - '.number_format($detailBooking->price).' X '.$detailBooking->qty  }}</td>
                    <td align="left" width="25%" style="padding: 6px 12px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">{{number_format($detailBooking->price*$detailBooking->qty) }}</td>
                  </tr>                
                @endforeach
                
                <tr>
                  <td align="left" width="75%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #bdc3c7; border-bottom: 2px dashed #bdc3c7;"><strong>Total</strong></td>
                  <td align="left" width="25%" style="padding: 12px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #bdc3c7; border-bottom: 2px dashed #bdc3c7;"><strong>{{ number_format($detailReceipt['booking']->grand_total) }}</strong></td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- end reeipt table -->

        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
    <!-- end copy block -->

    <!-- start receipt address block -->
    <tr>
      <td align="center" bgcolor="#bdc3c7" valign="top" width="100%">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
        <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="center" valign="top" style="font-size: 0; border-bottom: 3px solid #d4dadf">
              <!--[if (gte mso 9)|(IE)]>
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
              <tr>
              <td align="left" valign="top" width="300">
              <![endif]-->
              <div style="display: inline-block; width: 100%; max-width: 50%; min-width: 240px; vertical-align: top;">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 300px;">
                  <tr>
                    <td align="left" valign="top" style="padding-bottom: 36px; padding-left: 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                      <p><strong>Booking Details:</strong></p>
                      <p>{{$detailReceipt['booking']->name }}<br>
                       {{$detailReceipt['booking']->email}}<br>
                       {{$detailReceipt['booking']->code_unique }}<br>
                      </p>
                    </td>
                  </tr>
                </table>
              </div>
              <!--[if (gte mso 9)|(IE)]>
              </td>
              <td align="left" valign="top" width="300">
              <![endif]-->
              <div style="display: inline-block; width: 100%; max-width: 50%; min-width: 240px; vertical-align: top;">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 300px;">
                  <tr>
                    <td align="left" valign="top" style="padding-bottom: 36px; padding-left: 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                      
                    </td>
                  </tr>
                </table>
              </div>
              <!--[if (gte mso 9)|(IE)]>
              </td>
              </tr>
              </table>
              <![endif]-->
            </td>
          </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
    <!-- end receipt address block -->

    <!-- start footer -->
    
    <!-- end footer -->

  </table>
  <!-- end body -->

</body>
</html>