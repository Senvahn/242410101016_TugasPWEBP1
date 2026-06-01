import urllib.request
import re
html = urllib.request.urlopen('http://localhost:8000/checkout').read().decode('utf-8', errors='ignore')
match = re.search(r'<meta name="csrf-token" content="([^"]+)"', html)
if match:
    print(match.group(1))
else:
    print('NO_TOKEN')
