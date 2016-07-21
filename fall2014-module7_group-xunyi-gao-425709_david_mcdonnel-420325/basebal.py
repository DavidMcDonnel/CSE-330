import sys, os
import re
from math import ceil

batted = {}
hits = {}    
if len(sys.argv)<2:
    sys.exit("Usage: %s filename" % sys.argv[0])
    
filename = sys.argv[1]

if not os.path.exists(filename):
    sys.exit("Error: File '%s' not found" % sys.argv[1])
    
f = open (filename)
for line in f:
    	string = line.rstrip()
	
    	pattern = re.compile(r"\b([A-Z][a-z].*? [A-Z][a-z].*?) batted ([0-9].*?) times with ([0-9].*?) hits and ([0-9].*?) runs\b")
	player = pattern.match(string)
	if player is not None:
		name = player.group(1)

		if name in batted:
			batted [name] += int(player.group(2))
		else:
			batted [name] = int(player.group(2))
		if name in hits:
			hits [name] += int(player.group(3))
		else:
			hits [name] = int(player.group(3))
	
batAvg = []

for name in batted:
	batAvg.append((name, round((float(hits[name])/batted[name]), 3)))
	#batAvg.append((name, ceil(10000*hits[name]/batted[name])/10000.0))

batAvg.sort(key=lambda x:x[1], reverse=True)
for name, average in batAvg:
	print name +":"+str(average)

f.close()
