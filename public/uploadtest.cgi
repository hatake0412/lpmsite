#!/usr/local/bin/python
# -*- coding: utf-8 -*-

import cgi
import os,sys,re
import subprocess,shutil,fcntl,sqlite3
from cPickle import loads, dumps
from time import sleep
try:
    from thread import get_ident
except ImportError:
    from dummy_thread import get_ident

now_debugging = False
log_filename = "/var/www/lpm/log"
alog_filename = "/var/www/lpm/alog"
tmp_dir = "/var/www/lpm/tmp"
db_dir = "/var/www/lpm/db"
repository_base_dir = "/var/www/lpm/repository"

# SqliteQueue class was developed by Armin Ronacher and declared to be public domain.
# The original file was taken from http://flask.pocoo.org/snippets/88/.

def enqueue_sign_job(package_name, log_fn):
    if package_name.find("/") != -1: return
    if package_name.find("..") != -1: return
    if package_name.find(" ") != -1: return
    queue_file = 'wq.sqlite'
    log_file = 'wqe.log'

    log = open(os.path.join(db_dir, log_file), "a+")
    queue_file = os.path.join(db_dir, queue_file)
    queue = SqliteQueue(queue_file)
    obj = {}
    obj['args'] = ['/var/www/lpm/script/sign_package', package_name]
    queue.append(obj)
    log.write("Enqueued " + (" ".join(obj['args'])) + "\n")
    try:
        os.chmod(queue_file, 0777)
    except:
        log.write("Chmod error\n")
    log.close()

print "Content-type: text/html"
print ""

html = '''
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>LPM: Local Package Manager: Uploader</title>
  <link rel="stylesheet" type="text/css" href="./style.css" media="screen" />
  <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16079961-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  </script>
 </head>
 <body>
  <div id="wrap">
   <div id="top"></div>
   <div id="content">
    <div class="header">
     <h1><a href="#">LPM: Local Package Manager</a></h1>
     <h2>Want to install software without root?</h2>
    </div>
    <div class="breadcrumbs">
     <a href="#">Submit New Script</a><div class="langsel">%s</div>
    </div>
    <div class="middle">
     <p>%s</p>
     <h1>Upload LPM script</h1>
     <p>%s</p>
     <form action="./upload.cgi" method="post" enctype="multipart/form-data">
        <input type="file" name="lpmscript" />
        <input type="submit" />
     </form>
     %s
    </div> <!-- end of main test -->
    <div class="right">
     %s
    </div>
    <div id="clear"></div>
   </div>
   <div id="bottom"></div>
  </div>
  <div id="footer">Design by <a href="http://www.minimalistic-design.net">Minimalistic Design</a></div>
 </body>
</html>
'''

langsel_en = 'English | <a href="./upload.cgi?la=ja">Japanese</a>'
langsel_ja = '<a href="./upload.cgi?la=en">English</a> | Japanese'

plsupld_en = 'We welcome any submissions regardless regular maintainance. Please upload an LPM script from the form below.'
plsupld_ja = 'LPMスクリプトの投稿は今後のメンテナンスの有無に関わらず大歓迎です. 下のフォームから LPM スクリプトをアップロードしてください.'

gpgsigmsg_en = '''
  <p>If you are a comitter, the uploaded LPM script must have a GPG signature. Add GPG signature by 'gpg --clearsign'.</p>
  <p>All LPM scripts without a valid GPG signature registered in our database requires a review by a committer for security reason.</p>
'''
gpgsigmsg_ja = '''
  <p>コミッタ－が LPM スクリプトをアップロードする場合には GPG の署名が必要です。gpg --clearsign で GPG 署名を付加してください。</p>
  <p>セキュリティ上の理由により、有効な署名が付加されていない LPM スクリプトは承認されるまで公開されません。</p>
'''

navigation_en = '''
<h2>Navigation</h2>
<ul>
<li><a href="./index.html">Home</a></li>
<li><a href="./introduction.html">Introduction</a></li>
<li><a href="./download.html">Download</a></li>
<li><a href="./quickstart.html">Quick Start</a></li>
<li><a href="./installation.html">Installation</a></li>
<li><a href="./document.html">Document</a></li>
<li><a href="./browse.html">Browse Packages</a></li>
<li><a href="./upload.cgi?la=en">Submit New Script</a></li>
<li><a href="./changelog.html">Change Log</a></li>
<li><a href="./discussion.html">Discussion</a></li>
</ul>
'''

navigation_ja = '''
<h2>Navigation</h2>
<ul>
<li><a href="./index_ja.html">Home</a></li>
<li><a href="./introduction_ja.html">Introduction</a></li>
<li><a href="./download_ja.html">Download</a></li>
<li><a href="./quickstart_ja.html">Quick Start</a></li>
<li><a href="./demomovie_ja.html">Demo Movie</a></li>
<li><a href="./installation_ja.html">Installation</a></li>
<li><a href="./document_ja.html">Document</a></li>
<li><a href="./browse_ja.html">Browse Packages</a></li>
<li><a href="./upload.cgi?la=ja">Submit New Script</a></li>
<li><a href="./changelog_ja.html">Change Log</a></li>
<li><a href="./discussion_ja.html">Discussion</a></li>
</ul>
'''

form = cgi.FieldStorage()
result = ''
write_log(alog_filename, "IP: %s" % os.environ["REMOTE_ADDR"])
if form.has_key('lpmscript'):
    item = form['lpmscript']
    if item.file:
        if item.filename.endswith(".asc") or item.filename.endswith(".lpm"):
            tmpfilename = os.path.join(tmp_dir, item.filename)
            print u"tmpfilename=%s" % tmpfilename
            fout = file(tmpfilename, 'wb')
            nbytes = 0
            while True:
                chunk = item.file.read(16777216)
                if not chunk: break
                nbytes += len(chunk)
                fout.write(chunk)
            fout.close()
            result = 'Uploaded %d bytes' % nbytes
            try:
                os.chmod(tmpfilename, 0777)
            except:
                result = "Internal error (%d)" % nbytes
                nbytes = -1
            if nbytes > 0:
                try:
                    proc = subprocess.Popen(["gpg", "--homedir=/var/www/lpm/publickey", "--lock-never", "--verify", tmpfilename],
                                            shell=False,
                                            stdin=subprocess.PIPE,
                                            stdout=subprocess.PIPE,
                                            stderr=subprocess.PIPE)
                    so, se = proc.communicate('tsts')
                    errors = '<br />'
                    for c in se:
                        if c == "\n":
                            errors += "<br />"
                        else:
                            errors += c
                    retcode = proc.wait()
                    if retcode == 0:
                        # new_filename = os.path.join(repository_base_dir, item.filename)
                        while True:
                            try:
                                write_log(log_filename, "%s was verified and deployed." % cgi.escape(item.filename))
                            except:
                                result = "Verification succeeded, but encountered an error during deploy process (wl)."
                                break
                            result = "Verification succeeded"
                            try:
                                p = item.filename.lower()
                                p = re.sub(r'\.asc$', r'', p)
                                p = re.sub(r'\.lpm$', r'', p)
                                enqueue_sign_job(p, log_filename)
                                write_log(log_filename, "Queueing successful")
                            except Exception, i:
                                result = "Error during enqueueing" + str(i)
                            break
                    else:
                        if retcode == 1:
                            result = "GPG key verification failed (you may see this error when you did not sign your script.). Wait for committers' review"
                            write_log(log_filename, "%s is waiting for review." % cgi.escape(item.filename))
                        else:
                            if now_debugging:
                                result = ("GPG error (%d)" % retcode) + errors
                            else:
                                result = ("GPG error (%d)" % retcode)
                            write_log(log_filename, "%s was uploaded but encountered an error (IP: %s)." % (item.filename, os.environ["REMOTE_ADDR"]))
                except:
                    result = "An error occurred"
        else:
            if item.filename == "":
                result = "The file name was empty"
            else:
                result = 'The file name of the uploaded script does not look like an ASCII-armored GPG-signed LPM script (*.lpm.asc)'

if form.getfirst('la', 'en') == 'ja':
    print html % (langsel_ja, result, plsupld_ja, gpgsigmsg_ja, navigation_ja)
else:
    print html % (langsel_en, result, plsupld_en, gpgsigmsg_en, navigation_en)
