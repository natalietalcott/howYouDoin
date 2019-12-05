# howYouDoin

For Email to work:
need to modify php.ini (change to respective values for your xampp location and email server):
    [mail function]
    ; For Win32 only.
    ; http://php.net/smtp
    SMTP=smtp.gmail.com
    ; http://php.net/smtp-port
    smtp_port=587

    ; For Win32 only.
    ; http://php.net/sendmail-from
    sendmail_from = your-email@gmail.com

    ; For Unix only. You may supply arguments as well (default: "sendmail -t -i").
    ; http://php.net/sendmail-path
    sendmail_path = "C:\xampp\sendmail\sendmail.exe -t"

need to modify sendmail.ini (again change to respective values for your server):
    smtp_server=smtp.gmail.com

    ; smtp port (normally 25)

    smtp_port=587

    ; SMTPS (SSL) support
    ;   auto = use SSL for port 465, otherwise try to use TLS
    ;   ssl  = alway use SSL
    ;   tls  = always use TLS
    ;   none = never try to use SSL

    smtp_ssl=tls

    ; the default domain for this server will be read from the registry
    ; this will be appended to email addresses when one isn't provided
    ; if you want to override the value in the registry, uncomment and modify

    ;default_domain=mydomain.com

    ; log smtp errors to error.log (defaults to same directory as sendmail.exe)
    ; uncomment to enable logging

    error_logfile=error.log

    ; create debug log as debug.log (defaults to same directory as sendmail.exe)
    ; uncomment to enable debugging

    ;debug_logfile=debug.log

    ; if your smtp server requires authentication, modify the following two lines

    auth_username=your-email@gmail.com
    auth_password=your-password
NOTE: for gmail you will likely need to have 2FA and generate an app password for this
Additionally, you will need to change the "$headers .= "From: gabbybmeow@gmail.com" . "\r\n";" to whatever email you wish to use in a few locations