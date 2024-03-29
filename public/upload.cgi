#!/usr/bin/python
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

now_debugging = True
log_filename = "/var/www/lpm/log/log"
alog_filename = "/var/www/lpm/log/alog"
tmp_dir = "/var/www/lpm/tmp"
db_dir = "/var/www/lpm/db"
repository_base_dir = "/var/www/lpm/repository"

# SqliteQueue class was developed by Armin Ronacher and declared to be public domain.
# The original file was taken from http://flask.pocoo.org/snippets/88/.
class SqliteQueue(object):

    _create = (
            'CREATE TABLE IF NOT EXISTS queue ' 
            '('
            '  id INTEGER PRIMARY KEY AUTOINCREMENT,'
            '  item BLOB'
            ')'
            )
    _count = 'SELECT COUNT(*) FROM queue'
    _iterate = 'SELECT id, item FROM queue'
    _append = 'INSERT INTO queue (item) VALUES (?)'
    _write_lock = 'BEGIN IMMEDIATE'
    _popleft_get = (
            'SELECT id, item FROM queue '
            'ORDER BY id LIMIT 1'
            )
    _popleft_del = 'DELETE FROM queue WHERE id = ?'
    _peek = (
            'SELECT item FROM queue '
            'ORDER BY id LIMIT 1'
            )

    def __init__(self, path):
        self.path = os.path.abspath(path)
        self._connection_cache = {}
        with self._get_conn() as conn:
            conn.execute(self._create)

    def __len__(self):
        with self._get_conn() as conn:
            l = conn.execute(self._count).next()[0]
        return l

    def __iter__(self):
        with self._get_conn() as conn:
            for id, obj_buffer in conn.execute(self._iterate):
                yield loads(str(obj_buffer))

    def _get_conn(self):
        id = get_ident()
        if id not in self._connection_cache:
            self._connection_cache[id] = sqlite3.Connection(self.path, timeout=60)
        return self._connection_cache[id]

    def append(self, obj):
        obj_buffer = buffer(dumps(obj, 2))
        with self._get_conn() as conn:
            conn.execute(self._append, (obj_buffer,)) 

    def popleft(self, sleep_wait=True):
        keep_pooling = True
        wait = 0.1
        max_wait = 2
        tries = 0
        with self._get_conn() as conn:
            id = None
            while keep_pooling:
                conn.execute(self._write_lock)
                cursor = conn.execute(self._popleft_get)
                try:
                    id, obj_buffer = cursor.next()
                    keep_pooling = False
                except StopIteration:
                    conn.commit() # unlock the database
                    if not sleep_wait:
                        keep_pooling = False
                        continue
                    tries += 1
                    sleep(wait)
                    wait = min(max_wait, tries/10 + wait)
            if id:
                conn.execute(self._popleft_del, (id,))
                return loads(str(obj_buffer))
        return None

    def peek(self):
        with self._get_conn() as conn:
            cursor = conn.execute(self._peek)
            try:
                return loads(str(cursor.next()[0]))
            except StopIteration:
                return None

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
  <div id="footer">Copyright 2012 Masahiro Kasahara, all rights reserved.</div>
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
<li><a href="/index.php">Home</a></li>
<li><a href="/introduction.php">Introduction</a></li>
<li><a href="/download.php">Download</a></li>
<li><a href="/quickstart.php">Quick Start</a></li>
<li><a href="/installation.php">Installation</a></li>
<li><a href="/document.php">Document</a></li>
<li><a href="/faq/index.php">Browse Packages</a></li>
<li><a href="/upload.cgi?la=en">Submit New Script</a></li>
<li><a href="/changelog.php">Change Log</a></li>
<li><a href="/discussion.php">Discussion</a></li>
</ul>
'''

navigation_ja = '''
<h2>Navigation</h2>
<ul>
<li><a href="/index.php">Home</a></li>
<li><a href="/introduction.php">Introduction</a></li>
<li><a href="/download.php">Download</a></li>
<li><a href="/quickstart.php">Quick Start</a></li>
<li><a href="/demomovie.php">Demo Movie</a></li>
<li><a href="/installation.php">Installation</a></li>
<li><a href="/document.php">Document</a></li>
<li><a href="/faq/index.php">Browse Packages</a></li>
<li><a href="/upload.cgi?la=ja">Submit New Script</a></li>
<li><a href="/changelog.php">Change Log</a></li>
<li><a href="/discussion.php">Discussion</a></li>
</ul>
'''

def write_log(fname, msg):
    try:
        f = file(fname, 'rb+')
        fcntl.flock(f.fileno(), fcntl.LOCK_EX)
        f.seek(0, os.SEEK_END)
        f.write(msg + "\n")
        fcntl.flock(f.fileno(), fcntl.LOCK_UN)
        f.close()
    except:
        pass

form = cgi.FieldStorage()
result = ''
write_log(alog_filename, "IP: %s" % os.environ["REMOTE_ADDR"])
if form.has_key('lpmscript'):
    item = form['lpmscript']
    if item.file:
        if item.filename.endswith(".asc") or item.filename.endswith(".lpm"):
            tmpfilename = os.path.join(tmp_dir, item.filename)
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
                        while True:
                            try:
                                write_log(log_filename, "%s was verified and deployed." % cgi.escape(item.filename))
                            except:
                                result = "Verification succeeded, but encountered an error during deploy process (wl)."
                                break
                            result = "Verification succeeded"
                            try:
                                p = item.filename.lower()
                                p = re.sub(r'\.lpm$', r'', p)
                                enqueue_sign_job(p, log_filename)
                                write_log(log_filename, "Queueing successful")
                            except Exception, i:
                                result = "Error during enqueueing" + str(i)
                            break
                except:
                    result = "An error occurred"
        else:
            if item.filename == "":
                result = "The file name was empty"
            else:
                result = 'The file name of the uploaded script does not look like an ASCII-armored GPG-signed LPM script (*.lpm)'

if form.getfirst('la', 'en') == 'ja':
    print html % (langsel_ja, result, plsupld_ja, gpgsigmsg_ja, navigation_ja)
else:
    print html % (langsel_en, result, plsupld_en, gpgsigmsg_en, navigation_en)
