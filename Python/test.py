import json
print(json.dumps('Python test'))
#the script can be called from PHP:
#alert("<?php echo json_decode(shell_exec(escapeshellcmd('python3 test.py')))?>");
#AJAX calls can also be used
