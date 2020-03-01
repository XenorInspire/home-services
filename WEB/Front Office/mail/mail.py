import logins
import smtplib
import sys

from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

# set up the SMTP server
s = smtplib.SMTP(host='smtp.gmail.com', port=587)
s.starttls()
s.login(logins.MY_ADDRESS, logins.PASSWORD)

# For each contact, send the email:

msg = MIMEMultipart()       # create a message

# add in the actual person name to the message template
message = 'Hi there !\nThanks for using Home-Services !\nClick right here to purshase your registration : \nhttp://localhost/user_registered.php?a=' + sys.argv[2]

# setup the parameters of the message
msg['From']=logins.MY_ADDRESS
msg['To']= sys.argv[1]
msg['Subject']="Home Services - Confirm your mail address"

# add in the message body
msg.attach(MIMEText(message, 'plain'))

# send the message via the server set up earlier.
s.send_message(msg)
s.quit()
