import urllib2, json, smtplib
from urllib2 import URLError

email = "example@gmail.com"
password = "123456"
mailServer = "smtp.example.com"
mailPort = 587
to = ['youremail@yourprovider.com']
subject = "IP Changed"

def checkIp():
	try:
		jsonip = json.loads(urllib2.urlopen("http://jsonip.com/").read())
		f = open('mylastip', 'a+')
		f.seek(0)
		lastIp = f.read()
		print lastIp
		print jsonip['ip']

		if lastIp != jsonip['ip'] :
			sendMail("Hello, my ip Changed to: " + jsonip['ip'])
			f.seek(0)
			f.truncate()
			f.write(jsonip['ip'])

		f.close()
	except URLError, e:
		return
	

def sendMail(message):
	try:
	    server = smtplib.SMTP(mailServer, mailPort)
	    server.ehlo()
	    server.starttls()
	    server.login(email, password)
	    server.sendmail(email, to, message)
	    server.close()
	    print 'successfully sent the mail'
	except:
	    print "failed to send mail"

checkIp()