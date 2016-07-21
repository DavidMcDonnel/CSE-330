import re
import operator
import sys, os

if len(sys.argv)<2:
    sys.exit("Usage: %s filename" % sys.argv[0])
filename = sys.argv[1]
if not os.path.exists(filename):
    sys.exit("Error: File '%s' not found" % sys.argv[1])

f= open(filename)
file_contents=f.read()
f.close()
regex=re.compile("([A-Z]{1}[A-Za-z'-]+[\s][A-Z][A-Za-z'-]+)[\s]\\bbatted\\b[\s]([0-9]+)[\s]\\btimes with\\b[\s]([0-9]+)[\s]\\bhits and\\b[\s]([0-9]+)[\s]\\bruns\\b")
player_stats=re.findall(regex,file_contents)
 
player_hits={} 
player_bats={}
player_average={}
for player_stat in player_stats:
    if player_stat[0] not in player_hits:
        player_hits[player_stat[0]]=float(player_stat[2])
        player_bats[player_stat[0]]=float(player_stat[1])
    else:
        player_hits[player_stat[0]]+=float(player_stat[2])
        player_bats[player_stat[0]]+=float(player_stat[1])
        
        
for player_hit in player_hits:
    player_average[player_hit]=player_hits[player_hit]/player_bats[player_hit]
    
sorted_player_average=sorted(player_average.items(), key=operator.itemgetter(1))

for sorted_player_average in reversed(sorted_player_average):    
    print sorted_player_average[0]+": "+ str('{0:.3f}'.format(round(sorted_player_average[1]*1000)/1000))