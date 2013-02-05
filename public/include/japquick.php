  <h1 class="title">さっさと使ってみたい</h1>
  <div class="entry">
  <p>LPM 自身のインストール。</p>
  <div class="ex">
   $ cd<br />
   $ wget http://www.kasahara.ws/lpm/lpm<br />
   $ chmod +x lpm<br />
   $ ./lpm initlocaldir<br />
   $ rm ./lpm<br />
  </div>
  <p>インストールが終わったら再ログインしてください。面倒なら以下のコマンドを実行すれば良いでしょう。</p>
  <div class="ex">
   $ exec $SHELL -l
  </div>
  <p>さて、例えば ttyrec をインストールしてみましょう。</p>
  <div class="ex">
   $ ttyrec<br />
   bash: ttyrec: Command not found.<br />
   $ lpm install ttyrec<br />
   (いろいろ表示される)<br />
   $ $SHELL -l (あるいは再ログイン)<br />
   $ ttyrec -h<br />
   usage: ttyrec [-u] [-e command] [-a] [file]<br />
   $<br />
  </div>
  <p>インストールされているソフト一覧表示。</p>
  <div class="ex"><pre style="margin:0">$ lpm list
  2M    1  02-Feb-2010  lpm-1.0
 28M   13  06-Sep-2010  maven-2.0.11
 22M   13  02-Feb-2010  paco-2.0.7
 12M    6  06-Sep-2010  ttyrec-1.0.8</pre>
  </div>
  <p>特定パッケージのファイル一覧表示。</p>
  <div class="ex">
  $ lpm list maven<br />
  </div>
  <p>アンインストール。</p>
  <div class="ex">
  $ lpm uninstall maven<br />
  </div>
  <p>LPMも含めて根こそぎアンインストール。</p>
  <div class="ex">
  $ lpm removelocaldir<br />
  </div>
  <p>そもそも LPM 用のパッケージが無いので tarball からいきなりインストール</p>
  <div class="ex">
  $ lpm install http://tukaani.org/xz/xz-4.999.9beta.tar.bz2<br />
  </div>
  <p>データベースが古いよ、と警告メッセージがたまに</p>
  <div class="ex">
  $ paco -ua
  </div>
  <p>ほとんどの場合はここの説明の使い方で十分なはず。</p>
  </div>
