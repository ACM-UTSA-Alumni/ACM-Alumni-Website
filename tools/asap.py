#!/usr/bin/python

import mechanize, re, time, sys

def add_time(time, days, schedule, people):
	""" Adds to a master schedule dict given a class meeting time
	
	The schedule dict is a two-dimensional dict with the following
	structure:

	schedule[day of week][time segment] -> # of people enrolled

	This function reads in a time string, days string, and the number
	of people enrolled in the class associated with the time info, and
	adds them to the master schedule list.

	Args:
		time: the meeting time of the class (e.g. 4:00-5:15pm)
		days: the days that the class meets (e.g. MWF, TR)
			the days are represented by single uppercase
			characters, like so:
			Monday => M, Tuesday => T, Wednesday => W, 
			Thursday => R, Friday => F
		schedule: the pre-built schedule dict
		people: the number of people enrolled in the class

	Returns:
	"""
	# We need to know if the time is AM or PM
	if 'pm' in time >= 0: ispm = True
	else: ispm = False

	split = time[:-2].split('-')
	start = split[0]
	end = split[1]

	start = start.split(':')
	end = end.split(':')

	start = int(start[0]) * 100 + int(start[1])
	end = int(end[0]) * 100 + int(end[1])

	if ispm and end < 1200:
		start += 1200
		end += 1200

	for day in schedule:
		if day in days:
			for key in schedule[day]:
				if key >= start and key < end:
					schedule[day][key] += int(people)

# URL of the asap view schedule page
url_asap = 'https://asap.utsa.edu/pls/prod/xwskschd.P_UTSA_OpenSch'

# Emulate a person using Firefox on ubuntu
br = mechanize.Browser()
br.set_handle_robots(False)
br.insertheaders = [("User-agent","Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:42.0) Gecko/20100101 Firefox/42.0")]

page1 = br.open(url_asap)

# Select options: Fall 2016, CS
br.select_form(nr = 0)
br.form['term'] = ['201720']
item = br.find_control(name="sel_subj", type="select").get("CS")
item.selected = True
response = br.submit()

# Put all the html into a string
data = response.read()
rows = data.split('<TR>')

# Build initial schedule dict (see add_time())
schedule = {}
for s in ['M', 'T', 'W', 'R', 'F']:
	schedule[s] = {}
	for i in range(24):
		for j in range(0, 60, 15):
			schedule[s][i * 100 + j] = 0

for row in rows:
	if row.strip().startswith('<TD ALIGN="left"'):
		# Read TD elements into a list
		if row.find('>TBA<') < row.find('Main Camp'): continue
		cells = row.split('</TD>')
		try:
			# Parse subject
			m = re.search('SMALL>(\w+)</SMALL', cells[1])
			subj = m.group(1)
			if subj != 'CS': continue
			# Parse course number
			m = re.search('>(\d+)<', cells[2])
			course = m.group(1)
			if int(course) > 4999 or int(course) < 1083 or int(course) == 1173: continue
			# Parse days
			m = re.search('SMALL>(.*)</SMALL', cells[7])
			days = m.group(1)
			# Parse time
			m = re.search('SMALL>(.*)</SMALL', cells[8])
			timev = m.group(1)
			# Parse # of enrolled
			m = re.search('>(\d+)<', cells[15])
			enr = m.group(1)
			add_time(timev, days, schedule, enr)
		except AttributeError:
			continue

# Prints a proper HTML table with all data
print '<table><thead><tr>'

# Print top row
for day in ['', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']:
	print '<th>'
	print day
	print '</th>'
print '</thead><tbody>'

# Print remaining rows, from 8:00am to (exclusive) 10:00pm
for i in range(8, 22):
	for j in range(0, 60, 15):
		time = str(i * 100 + j)
		if len(time) == 1:
			timep = time + ":00"
		elif len(time) < 3:
			timep = "0:" + time
		elif len(time) == 3:
			timep = time[0:1] + ":" + time[1:3]
		else:
			timep = time[0:2] + ":" + time[2:4]
		# Print a row
		print '<tr>'
		# Print time cell
		print '<td>' + timep + '</td>'
		time = int(time)
		# Print remaining cells for that time
		for day in ['M', 'T', 'W', 'R', 'F']:
			print '<td>' + str(schedule[day][time]) + '</td>'
		print '</tr>'

print '</tbody></table>'
