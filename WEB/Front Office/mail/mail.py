import logins
import smtplib

from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

# set up the SMTP server
s = smtplib.SMTP(host='smtp.gmail.com', port=587)
s.starttls()
s.login(logins.MY_ADDRESS, logins.PASSWORD)

# For each contact, send the email:

msg = MIMEMultipart()       # create a message

# add in the actual person name to the message template
message = 'This is a test in python'

# setup the parameters of the message
msg['From']=logins.MY_ADDRESS
msg['To']= 'nicolas.fouchard94370@gmail.com'
msg['Subject']="This is TEST"

# add in the message body
msg.attach(MIMEText(message, 'plain'))

# send the message via the server set up earlier.
s.send_message(msg)
s.quit()
