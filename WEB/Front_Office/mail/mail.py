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

if(sys.argv[1] == '1'):  # Mail confirmation
    msg['Subject'] = "Home Services - Confirm your mail address"
    message = 'Hi there !\nThanks for using Home-Services !\nClick right here to purchase your registration : \n' + logins.IP + 'user_registered.php?a=' + \
        sys.argv[3]
elif(sys.argv[1] == '2'):  # Subscription
    msg['Subject'] = "Home Services - Subscription confirmation"
    message = 'Hi there !\nThanks for using Home-Services !\nYour subscription is now effective, don\'t hesitate to contact us if you have any question !'
elif(sys.argv[1] == '3'):  # Personal information update
    msg['Subject'] = "Home Services - Personal information update"
    message = 'Hi there !\nThanks for using Home-Services !\nYour personal informations have been updated.'
elif(sys.argv[1] == '4'):  # Password updated
    msg['Subject'] = "Home Services - Password changed"
    message = 'Hi there !\nThanks for using Home-Services !\nYour password has been updated.'
elif(sys.argv[1] == '5'):  # Password forgotten
    msg['Subject'] = "Home Services - Password forgotten"
    message = 'Hi there !\nThanks for using Home-Services !\nYou can now connect to Homes-Services with this password : ' + \
        sys.argv[3]
elif(sys.argv[1] == '6'):  # Booked service
    msg['Subject'] = "Home Services - Booked service"
    message = 'Hi there !\nThanks for using Home-Services !\nYour order has been taken into account for the service : ' + \
        sys.argv[3] + '\nIf you want more informations about your orders, don\'t hesitate to check them on our platform !'
elif(sys.argv[1] == '7'):  # Service provided paid
    msg['Subject'] = "Home Services - Service provided paid"
    message = 'Hi there !\nThanks for using Home-Services !\nThe service has been paid, don\'t hesitate to download your invoice in your orders page'

# setup the parameters of the message
msg['From'] = logins.MY_ADDRESS
msg['To'] = sys.argv[2]

# add in the message body
msg.attach(MIMEText(message, 'plain'))

# send the message via the server set up earlier.
s.send_message(msg)
s.quit()
