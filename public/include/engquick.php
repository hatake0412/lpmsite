  <div class="entry">
  <p>Let's install LPM.</p>
  <div class="ex">
   $ cd<br />
   $ wget http://www.kasahara.ws/lpm/lpm<br />
   $ chmod +x lpm<br />
   $ ./lpm initlocaldir<br />
   $ rm ./lpm<br />
  </div>
  <p>Next we relogin. Alternatively you can use the following command:</p>
  <div class="ex">
   $ exec $SHELL -l
  </div>
  <p>Let's install a new package. For exmaple, you can type as the following to install ttyrec:</p>
  <div class="ex">
   $ ttyrec<br />
   bash: ttyrec: Command not found.<br />
   $ lpm install ttyrec<br />
   (you see lots of messages here)<br />
   $ exec $SHELL -l (or you relogin here)<br />
   $ ttyrec -h<br />
   usage: ttyrec [-u] [-e command] [-a] [file]<br />
   $<br />
   <p>Wow, it's easy as yum and it doesn't need root!</p>
  </div>
  <p>To show the installed packages, do 'lpm list':</p>
  <div class="ex"><pre style="margin:0">$ lpm list
  2M    1  02-Feb-2010  lpm-1.0
 28M   13  06-Sep-2010  maven-2.0.11
 22M   13  02-Feb-2010  paco-2.0.7
 12M    6  06-Sep-2010  ttyrec-1.0.8</pre>
  </div>
  <p>'lpm list (package name)' shows the list of installed files for a specified package (e.g., maven).</p>
  <div class="ex">
  $ lpm list maven<br />
  </div>
  <p>Uninstall a package (e.g., maven).</p>
  <div class="ex">
  $ lpm uninstall maven<br />
  </div>
  <p>Uninstall everything including LPM itself.</p>
  <div class="ex">
  $ lpm removelocaldir<br />
  </div>
  <p>Install a package from URL. (You need to write an LPM script if the given package does not follow the GNU-style installation process. (i.e., ./configure && make && make install))</p>
  <div class="ex">
  $ lpm install http://tukaani.org/xz/xz-4.999.9beta.tar.bz2<br />
  </div>
  <p>Sometimes you may see a warning message that complains old database. You can type 'paco -ua' to scan the files.</p>
  <div class="ex">
  $ paco -ua
  </div>
  <p>We think most users do not use other features.</p>
  </div>
