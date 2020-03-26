import logins
import smtplib
import sys

from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

# set up the SMTP server
s = smtplib.SMTP(host='smtp.gmail.com', port=587)
s.starttls()
s.login(logins.MY_ADDRESS, logins.PASSWORD)

msg = MIMEMultipart()       # create a message
message = ''

if(sys.argv[1] == '1'):
    msg['Subject'] = "Home Services - Confirm your mail address"
    message = 'Hi there !\nThanks for using Home-Services !\nClick right here to purshase your registration : \nhttp://localhost/user_registered.php?a=' + sys.argv[3]
elif(sys.argv[1] == '2'):
    msg['Subject'] = "Home Services - Subscription Confirmation"
    message = 'Hi there !\nThanks for using Home-Services !\nYour subscription is now effective, don\'t hesitate to contact us if you have any question !'

# setup the parameters of the message
msg['From'] = logins.MY_ADDRESS
msg['To'] = sys.argv[2]


# add in the message body
msg.attach(MIMEText(message, 'plain'))

# send the message via the server set up earlier.
s.send_message(msg)
s.quit()
