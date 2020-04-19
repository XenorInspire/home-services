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

if(sys.argv[1] == 'create_proposal'):
    msg['Subject'] = "Home Services - You have recieved a reservation"
    message = 'Hi there !\nThanks for using Home-Services !\nYou have received a reservation from a customer\nClick right here to see the reservation : \nhttp://176.139.121.149:7766/associate_proposal_accept.php?associateId=' + \
        sys.argv[3] + '&serviceProvidedId=' + sys.argv[4]
elif(sys.argv[1] == 'cancel_proposal'):
    msg['Subject'] = "Home Services - Reservation canceled"
    message = 'Hi there !\nSorry but your reservation have been canceled.'
elif(sys.argv[1] == 'first_connect'):
    msg['Subject'] = "Home Services - First connection"
    message = 'Hi there !\nThanks for using Home-Services !\nYou can now connect to Homes-Services with this password : ' + \
        sys.argv[3] + '\nTo activate your account, please use this link : http://localhost/first_connect.php?i=' + \
        sys.argv[4] + '&p=' + sys.argv[5]
elif(sys.argv[1] == 'delete_subscription'):
    msg['Subject'] = "Home Services - Subscription finished"
    message = 'Hi there !\nYour subscription is now finished, don\'t hesitate to subscribe again in our shop :D'
elif(sys.argv[1] == 'subscription_30_days'):
    msg['Subject'] = "Home Services - Subscription : less than 30 days remaining"
    message = 'Hi there !\nBe careful your subscription will end in less 30 days !\nDon\'t hesitate to visit our shop again !'

# setup the parameters of the message
msg['From'] = logins.MY_ADDRESS
msg['To'] = sys.argv[2]

# add in the message body
msg.attach(MIMEText(message, 'plain'))

# send the message via the server set up earlier.
s.send_message(msg)
s.quit()
