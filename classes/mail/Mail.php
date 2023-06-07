<?php

require_once $baseUrl.'/settings/db.php';
require_once $baseUrl.'/settings/config.php';

// Set up the PHPMailer object
require_once $baseUrl.'/libs/PHPMailer/src/PHPMailer.php';
require_once $baseUrl.'/libs/PHPMailer/src/SMTP.php';
require_once $baseUrl.'/libs/PHPMailer/src/Exception.php';

class Mail
{
    private string  $smtp_server;
    private string  $smtp_username;
    private string  $smtp_password;
    private bool    $smtp_auth;
    private string  $smtp_secure;
    private int     $smtp_port;

    function __construct() {
        $this->get_smtp_settings();
    }

    private function get_smtp_settings(): void
    {
        global $conn;
        $query = "SELECT * FROM smtp_settings";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_assoc();

        // store SMTP settings
        $this->smtp_server = $results['smtp_server'];
        $this->smtp_username = $results['smtp_username'];
        $this->smtp_password = $results['smtp_password'];
        $this->smtp_auth = $results['smtp_auth'];
        $this->smtp_secure = $results['smtp_secure'];
        $this->smtp_port = $results['smtp_port'];
    }

    public function send_2fa_code(string $_recipientEmail, int $_twoFactorCode): void
    {
        global $conn;
        global $appName;

        // Recipient email address
        $to = $_recipientEmail;

        // Sender email address
        $from = $this->smtp_username;

        // Subject of the email
        $subject = "Your Code";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Body of the email
//        $body = "Your 2FA authentication code.";
        $body = "<html lang='en'><head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content='viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.'>
    <meta name='keywords' content='admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app'>
    <meta name='author' content='pixelstrap'>
    <link rel='icon' href='../assets/images/favicon.png' type='image/x-icon'>
    <link rel='shortcut icon' href='../assets/images/favicon.png' type='image/x-icon'>
    <title>viho - Premium Admin Template</title>
    <link href='https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
    <style>
      body{
      width: 650px;
      font-family: work-Sans, sans-serif;
      background-color: #f6f7fb;
      display: block;
      }
      a{
      text-decoration: none;
      }
      span {
      font-size: 14px;
      }
      p {
          font-size: 13px;
         line-height: 1.7;
         letter-spacing: 0.7px;
         margin-top: 0;
      }
      .text-center{
      text-align: center
      }
      h6 {
      font-size: 16px;
      margin: 0 0 18px 0;
      }
    </style>
  </head>
  <body style='margin: 30px auto;' data-new-gr-c-s-check-loaded='14.1097.0' data-gr-ext-installed=''>
    <table style='width: 100%'>
      <tbody>
        <tr>
          <td>
            <table style='width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px'>
              <tbody>
                <tr>
                  <td style='padding: 30px'> 
                    <h6 style='font-weight: 600'>Two Factor Code</h6>
                    <p>To ensure the security of your account, we have sent you a two-factor authentication (2FA) for your account. As part of this process, you will need to enter the following code when prompted during login:</p>
                    <p style='text-align: center'><a href='javascript:void(0)' style='padding: 10px; background-color: #24695c; color: #fff; display: inline-block; border-radius: 4px;font-weight:600;'>$_twoFactorCode</a></p>
                    <p>Please keep this code secure and do not share it with anyone. If you did not request this code, please ignore this email.</p>
                    <p>If you have any questions or concerns, please do not hesitate to contact us.</p>
                    <p style='margin-bottom: 0'>
                      Best regards,<br>".$appName."</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  
</body><grammarly-desktop-integration data-grammarly-shadow-root='true'></grammarly-desktop-integration></html>";

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->SMTPDebug = 0; // Set to 2 to see more detailed debug output
        $mail->isSMTP();
        $mail->Host = $this->smtp_server;
        $mail->SMTPAuth = $this->smtp_auth;
        $mail->Username = $this->smtp_username;
        $mail->Password = $this->smtp_password;
        $mail->SMTPSecure = $this->smtp_secure;
        $mail->Port = $this->smtp_port;

        // Set the sender, recipient, subject, and body of the email
        $mail->setFrom($from, $appName);
        $mail->addAddress($to, 'Recipient Name');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        // Send the email and check for errors
        if (!$mail->send()) {
//            echo "Error sending email: " . $mail->ErrorInfo;
        }
        else {
//            echo "Email sent successfully.";
        }
    }

    /**
     * send normal email to user saying that a login has been done to his account without 2FA being enabled in user's account
     * @param string $_recipientEmail
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send_no_2fa_login_alert(string $_recipientEmail): void
    {
        global $conn;
        global $appName;

        // Recipient email address
        $to = $_recipientEmail;

        // Sender email address
        $from = $this->smtp_username;

        // Subject of the email
        $subject = "New Login";

        // Body of the email
        $body = "
            <html lang='en'><head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta name='description' content='viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.'>
            <meta name='keywords' content='admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app'>
            <meta name='author' content='pixelstrap'>
            <link rel='icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <link rel='shortcut icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <title>viho - Premium Admin Template</title>
            <link href='https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <style>
              body{
              width: 650px;
              font-family: work-Sans, sans-serif;
              background-color: #f6f7fb;
              display: block;
              }
              a{
              text-decoration: none;
              }
              span {
              font-size: 14px;
              }
              p {
                  font-size: 13px;
                 line-height: 1.7;
                 letter-spacing: 0.7px;
                 margin-top: 0;
              }
              .text-center{
              text-align: center
              }
            </style>
          </head>
          <body style='margin: 30px auto;' data-new-gr-c-s-check-loaded='14.1097.0' data-gr-ext-installed=''>
            <table style='width: 100%'>
              <tbody>
                <tr>
                  <td>
                    <table style='background-color: #f6f7fb; width: 100%'>
                      <tbody>
                        <tr>
                          <td>
                            <table style='width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px'>
                              <tbody>
                                <tr>
                                  <td style='padding: 30px'> 
                                    <p>Dear User,</p>
                                    <p>We wanted to alert you that we've noticed a login to your account, If this was you, you can safely ignore this email.</p>
                                    <p>Please note that 2FA authentication is not enabled on your account, consider enabling it for extra security.</p>
                                    <p>Here is the device information for the login:</p>
                                    <ul>
                                        <li>IP address: ".$_SERVER['REMOTE_ADDR']."</li>
                                        <li>Date and time:: ".date('Y-m-d H:i:s')."</li>
                                    </ul>
                                    <p>However, if you did not authorize this login, we highly recommend that you take action to protect your account. Please log into your account and review your recent activity to make sure everything looks correct. If you see any unauthorized activity, please change your password immediately and contact our support team for further assistance.</p>
                                    <p style='margin-bottom: 0'>Best regards,<br>PassHub</p>
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
        </body></html>
        ";

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->SMTPDebug = 0; // Set to 2 to see more detailed debug output
        $mail->isSMTP();
        $mail->Host = $this->smtp_server;
        $mail->SMTPAuth = $this->smtp_auth;
        $mail->Username = $this->smtp_username;
        $mail->Password = $this->smtp_password;
        $mail->SMTPSecure = $this->smtp_secure;
        $mail->Port = $this->smtp_port;

        // Set the sender, recipient, subject, and body of the email
        $mail->setFrom($from, $appName);
        $mail->addAddress($to, 'Recipient Name');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        // Send the email and check for errors
        if (!$mail->send()) {
//            echo "Error sending email: " . $mail->ErrorInfo;
        } else {
//            echo "Email sent successfully.";
        }
    }


    /**
     * send email to user saying that the account password has been changed
     * @param string $_recipientEmail
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send_password_change_alert(string $_recipientEmail): void
    {
        global $conn;
        global $appName;

        // Recipient email address
        $to = $_recipientEmail;

        // Sender email address
        $from = $this->smtp_username;

        // Subject of the email
        $subject = "Password Change";

        // Body of the email
        $body = "
            <html lang='en'><head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta name='description' content='viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.'>
            <meta name='keywords' content='admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app'>
            <meta name='author' content='pixelstrap'>
            <link rel='icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <link rel='shortcut icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <title>PassHub</title>
            <link href='https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <style>
              body{
              width: 650px;
              font-family: work-Sans, sans-serif;
              background-color: #f6f7fb;
              display: block;
              }
              a{
              text-decoration: none;
              }
              span {
              font-size: 14px;
              }
              p {
                  font-size: 13px;
                 line-height: 1.7;
                 letter-spacing: 0.7px;
                 margin-top: 0;
              }
              .text-center{
              text-align: center
              }
            </style>
          </head>
          <body style='margin: 30px auto;' data-new-gr-c-s-check-loaded='14.1097.0' data-gr-ext-installed=''>
            <table style='width: 100%'>
              <tbody>
                <tr>
                  <td>
                    <table style='background-color: #f6f7fb; width: 100%'>
                      <tbody>
                        <tr>
                          <td>
                            <table style='width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px'>
                              <tbody>
                                <tr>
                                  <td style='padding: 30px'> 
                                    <p>Dear User,</p>
                                    <p>We wanted to alert you that your account password has been changed, If you did this you can safely ignore this email.</p>
                                    <p>Here is the device information about this change:</p>
                                    <ul>
                                        <li>IP address: ".$_SERVER['REMOTE_ADDR']."</li>
                                        <li>Date and time:: ".date('Y-m-d H:i:s')."</li>
                                    </ul>
                                    <p>However, if you did not authorize this change, we highly recommend that you take action to protect your account. Please log into your account and review your recent activity to make sure everything looks correct. If you see any unauthorized activity, please change your password immediately and contact our support team for further assistance.</p>
                                    <p style='margin-bottom: 0'>Best regards,<br>PassHub</p>
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
        </body></html>
        ";

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->SMTPDebug = 0; // Set to 2 to see more detailed debug output
        $mail->isSMTP();
        $mail->Host = $this->smtp_server;
        $mail->SMTPAuth = $this->smtp_auth;
        $mail->Username = $this->smtp_username;
        $mail->Password = $this->smtp_password;
        $mail->SMTPSecure = $this->smtp_secure;
        $mail->Port = $this->smtp_port;

        // Set the sender, recipient, subject, and body of the email
        $mail->setFrom($from, $appName);
        $mail->addAddress($to, 'Recipient Name');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        // Send the email and check for errors
        if (!$mail->send()) {
//            echo "Error sending email: " . $mail->ErrorInfo;
        } else {
//            echo "Email sent successfully.";
        }
    }

    /**
     * send email to user saying that the account password has been changed
     * @param string $_recipientEmail
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send_pin_code_change_alert(string $_recipientEmail): void
    {
        global $conn;
        global $appName;

        // Recipient email address
        $to = $_recipientEmail;

        // Sender email address
        $from = $this->smtp_username;

        // Subject of the email
        $subject = "Pin Code Change";

        // Body of the email
        $body = "
            <html lang='en'><head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta name='description' content='viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.'>
            <meta name='keywords' content='admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app'>
            <meta name='author' content='pixelstrap'>
            <link rel='icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <link rel='shortcut icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <title>PassHub</title>
            <link href='https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <style>
              body{
              width: 650px;
              font-family: work-Sans, sans-serif;
              background-color: #f6f7fb;
              display: block;
              }
              a{
              text-decoration: none;
              }
              span {
              font-size: 14px;
              }
              p {
                  font-size: 13px;
                 line-height: 1.7;
                 letter-spacing: 0.7px;
                 margin-top: 0;
              }
              .text-center{
              text-align: center
              }
            </style>
          </head>
          <body style='margin: 30px auto;' data-new-gr-c-s-check-loaded='14.1097.0' data-gr-ext-installed=''>
            <table style='width: 100%'>
              <tbody>
                <tr>
                  <td>
                    <table style='background-color: #f6f7fb; width: 100%'>
                      <tbody>
                        <tr>
                          <td>
                            <table style='width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px'>
                              <tbody>
                                <tr>
                                  <td style='padding: 30px'> 
                                    <p>Dear User,</p>
                                    <p>We wanted to alert you that your account Pin Code has been changed, If you did this you can safely ignore this email.</p>
                                    <p>Here is the device information about this change:</p>
                                    <ul>
                                        <li>IP address: ".$_SERVER['REMOTE_ADDR']."</li>
                                        <li>Date and time:: ".date('Y-m-d H:i:s')."</li>
                                    </ul>
                                    <p>However, if you did not authorize this change, we highly recommend that you take action to protect your account. Please log into your account and review your recent activity to make sure everything looks correct. If you see any unauthorized activity, please change your password immediately and contact our support team for further assistance.</p>
                                    <p style='margin-bottom: 0'>Best regards,<br>PassHub</p>
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
        </body></html>
        ";

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->SMTPDebug = 0; // Set to 2 to see more detailed debug output
        $mail->isSMTP();
        $mail->Host = $this->smtp_server;
        $mail->SMTPAuth = $this->smtp_auth;
        $mail->Username = $this->smtp_username;
        $mail->Password = $this->smtp_password;
        $mail->SMTPSecure = $this->smtp_secure;
        $mail->Port = $this->smtp_port;

        // Set the sender, recipient, subject, and body of the email
        $mail->setFrom($from, $appName);
        $mail->addAddress($to, 'Recipient Name');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        // Send the email and check for errors
        if (!$mail->send()) {
//            echo "Error sending email: " . $mail->ErrorInfo;
        } else {
//            echo "Email sent successfully.";
        }
    }

    /**
     * send email to user saying that a incomplete login has been done while 2FA is enabled in user's account
     * @param string $_recipientEmail
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send_with_2fa_incomplete_login_alert(string $_recipientEmail): void
    {
        global $conn;
        global $appName;

        // Recipient email address
        $to = $_recipientEmail;

        // Sender email address
        $from = $this->smtp_username;

        // Subject of the email
        $subject = "Incomplete New Login";

        // Body of the email
        $body = "
            <html lang='en'><head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta name='description' content='viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.'>
            <meta name='keywords' content='admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app'>
            <meta name='author' content='pixelstrap'>
            <link rel='icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <link rel='shortcut icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <title>viho - Premium Admin Template</title>
            <link href='https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <style>
              body{
              width: 650px;
              font-family: work-Sans, sans-serif;
              background-color: #f6f7fb;
              display: block;
              }
              a{
              text-decoration: none;
              }
              span {
              font-size: 14px;
              }
              p {
                  font-size: 13px;
                 line-height: 1.7;
                 letter-spacing: 0.7px;
                 margin-top: 0;
              }
              .text-center{
              text-align: center
              }
            </style>
          </head>
          <body style='margin: 30px auto;' data-new-gr-c-s-check-loaded='14.1097.0' data-gr-ext-installed=''>
            <table style='width: 100%'>
              <tbody>
                <tr>
                  <td>
                    <table style='background-color: #f6f7fb; width: 100%'>
                      <tbody>
                        <tr>
                          <td>
                            <table style='width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px'>
                              <tbody>
                                <tr>
                                  <td style='padding: 30px'> 
                                    <p>Dear User,</p>
                                    <p>We wanted to alert you that we've noticed a login to your account, If this was you, you can safely ignore this email.</p>
                                    <p>Currently, 2FA authentication is enabled on your account, You'll receive another email when someone logins using 2FA code.</p>
                                    <p>Here is the device information for the login:</p>
                                    <ul>
                                        <li>IP address: ".$_SERVER['REMOTE_ADDR']."</li>
                                        <li>Date and time:: ".date('Y-m-d H:i:s')."</li>
                                    </ul>
                                    <p>However, if you did not authorize this login, we highly recommend that you take action to protect your account. Please log into your account and review your recent activity to make sure everything looks correct. If you see any unauthorized activity, please change your password immediately and contact our support team for further assistance.</p>
                                    <p style='margin-bottom: 0'>Best regards,<br>PassHub</p>
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
        </body></html>
        ";

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->SMTPDebug = 0; // Set to 2 to see more detailed debug output
        $mail->isSMTP();
        $mail->Host = $this->smtp_server;
        $mail->SMTPAuth = $this->smtp_auth;
        $mail->Username = $this->smtp_username;
        $mail->Password = $this->smtp_password;
        $mail->SMTPSecure = $this->smtp_secure;
        $mail->Port = $this->smtp_port;

        // Set the sender, recipient, subject, and body of the email
        $mail->setFrom($from, $appName);
        $mail->addAddress($to, 'Recipient Name');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        // Send the email and check for errors
        if (!$mail->send()) {
//            echo "Error sending email: " . $mail->ErrorInfo;
        } else {
//            echo "Email sent successfully.";
        }
    }

    /**
     * send email to user saying that a completed login has be done using 2FA code
     * @param string $_recipientEmail
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send_with_2fa_completed_login_alert(string $_recipientEmail): void
    {
        global $conn;
        global $appName;

        // Recipient email address
        $to = $_recipientEmail;

        // Sender email address
        $from = $this->smtp_username;

        // Subject of the email
        $subject = "2FA Complete Login";

        // Body of the email
        $body = "
            <html lang='en'><head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta name='description' content='viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.'>
            <meta name='keywords' content='admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app'>
            <meta name='author' content='pixelstrap'>
            <link rel='icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <link rel='shortcut icon' href='../assets/images/favicon.png' type='image/x-icon'>
            <title>viho - Premium Admin Template</title>
            <link href='https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
            <style>
              body{
              width: 650px;
              font-family: work-Sans, sans-serif;
              background-color: #f6f7fb;
              display: block;
              }
              a{
              text-decoration: none;
              }
              span {
              font-size: 14px;
              }
              p {
                  font-size: 13px;
                 line-height: 1.7;
                 letter-spacing: 0.7px;
                 margin-top: 0;
              }
              .text-center{
              text-align: center
              }
            </style>
          </head>
          <body style='margin: 30px auto;' data-new-gr-c-s-check-loaded='14.1097.0' data-gr-ext-installed=''>
            <table style='width: 100%'>
              <tbody>
                <tr>
                  <td>
                    <table style='background-color: #f6f7fb; width: 100%'>
                      <tbody>
                        <tr>
                          <td>
                            <table style='width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px'>
                              <tbody>
                                <tr>
                                  <td style='padding: 30px'> 
                                    <p>Dear User,</p>
                                    <p>We wanted to alert you that we've noticed a login to your account using 2FA code, If this was you, you can safely ignore this email.</p>
                                    <p>Here is the device information for the login:</p>
                                    <ul>
                                        <li>IP address: ".$_SERVER['REMOTE_ADDR']."</li>
                                        <li>Date and time:: ".date('Y-m-d H:i:s')."</li>
                                    </ul>
                                    <p>However, if you did not authorize this login, we highly recommend that you take action to protect your account. Please log into your account and review your recent activity to make sure everything looks correct. If you see any unauthorized activity, please change your password immediately and contact our support team for further assistance.</p>
                                    <p style='margin-bottom: 0'>Best regards,<br>PassHub</p>
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
        </body></html>
        ";

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->SMTPDebug = 0; // Set to 2 to see more detailed debug output
        $mail->isSMTP();
        $mail->Host = $this->smtp_server;
        $mail->SMTPAuth = $this->smtp_auth;
        $mail->Username = $this->smtp_username;
        $mail->Password = $this->smtp_password;
        $mail->SMTPSecure = $this->smtp_secure;
        $mail->Port = $this->smtp_port;

        // Set the sender, recipient, subject, and body of the email
        $mail->setFrom($from, $appName);
        $mail->addAddress($to, 'Recipient Name');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        // Send the email and check for errors
        if (!$mail->send()) {
//            echo "Error sending email: " . $mail->ErrorInfo;
        } else {
//            echo "Email sent successfully.";
        }
    }

}