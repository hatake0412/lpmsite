<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LPM: Local Package Manager</title>
<meta http-equiv="Content-Language" content="Japanese" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
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
<?php include ("include/navi.php"); ?>
</div>

<div class="middle">
      <h2>どんなツールですか</h2>
        <p>自分のホームディレクトリ以下にパッケージ(tar ball)をインストールする人のためのパッケージ管理ツールです。</p>
      <h2>どんなツールではありませんか</h2>
        <p>rpm や deb パッケージをそのまま使って自分のホームディレクトリ以下にインストールするツールではありません。tar ball ならいけます。</p>
      <h2>yum とか apt とか何が違うんですか</h2>
        <p>最終的な目的はあんまり違わないんですけど、root 権限が無いと yum とか apt とか基本的に使えないですよね。</p>
        <p>たとえば CentOS に libboost 1.33.1 が付いてくるけれども自分は libboost 1.41.0 を使いたいんだー、とかいうときに、
           root 権限がないと rpm ではどうしようもない。</p>
        <p>たとえ root 権限があったとしても自分で spec ファイル書かなきゃならないし、CentOS に入っている古いバージョンと自分の
           入れたい新しいバージョンが衝突したりすると、ホームディレクトリ以下に入れて他のユーザーには干渉させないから勘弁してよ！と
           言いたくなります。</p>
      <h2>tar ball を使ってホームディレクトリ以下にインストールすれば？</h2>
        <p>tar ball を自分でダウンロードして、./configure --prefix=$HOME/local &amp;&amp; make &amp;&amp; make install すれば確かに問題はだいたい解決するんですが、
           面倒なことがいろいろありまして
           </p><ul>
             <li>ソフト名で google 検索して最新版のホームページを探し、tar ball をダウンロードしてくる作業が面倒。
                 ５台も６台もマシンを使っていると URL をメモしておきたいですよね。</li>
             <li>tar ball をダウンロードする先のディレクトリもたいてい決まっているので、ブラウザのダイアログでいちいち指定するのも面倒。</li>
             <li>configure するときに --prefix をたまに付け忘れて悲しいことになり面倒。</li>
             <li>make install した後に PATH とか MAN_PATH とか LD_LIBRARY_PATH とか設定し忘れて、絶対PATH指定しないと動かなかったり man が出てこなかったりいろいろ面倒。</li>
             <li>.bash_profile に記述したら tcsh を使ったときに読み込まれなくて残念。</li>
             <li>アンインストールしたいときに面倒。GNU automake で作ったパッケージなら make uninstall で行けるんですけど、.bash_profile の PATH の指定とか MAN_PATH の指定とか消えません。
                 GNU式の configure を使っていない場合にはソフト自体のアンインストールも面倒。
                 paco とか使えばいいんですけど、paco のインストールも面倒だし、使い方を思い出すのも面倒。環境変数は消してくれないし。</li>
             <li>Perl とか Python のモジュールをホームディレクトリ以下にインストールしたい時とか、tar ball だとかなり面倒。</li><li>実験で一時的に違うバージョンのライブラリをインストールした状態で自分のソフトをテストし、テストが終わったら元に戻したい、などというときに面倒。</li>
           </ul>
        
      <h2>結局何をするツールなんですか</h2>
        <p>上で説明した状況で役に立つツールです。使い方を見た方がわかりやすいです。</p>
      <h2>使い方</h2>
        <h3>インストール方法</h3>
          <p>まず、Perl は入っているものと仮定します。gcc 等のコンパイラもあるものとします。無いと動きません。</p>
          <p>ダウンロードし実行権限を立てて lpm initlocaldir と実行して下さい。</p>
          <blockquote>
            $ wget http://www.kasahara.ws/lpm/lpm (wgetが無ければブラウザなどでダウンロードしてください)<br />
            $ chmod +x ./lpm<br />
            $ ./lpm initlocaldir<br />
            $ rm ./lpm (インストール終わったら消してもOK)<br />
          </blockquote>
        <h3>インストールすると何が走るか</h3>
          <p>Sourceforge に paco というパッケージ管理ソフトがあるのですが、
             こいつの最新版をダウンロードして ~/lcl 以下にインストールします。
             paco を使うとたいていのソフトのアンインストールが自動化できますが、
             lpm は paco の機能を使っています。</p>
          <p>.bash_profile や .bashrc (tcsh や zsh を使っている人は同等のファイル) に
             ~/lcl/.bash_profile や ~/lcl/.bashrc も参照するように source 命令を書き加えます。
             bash/csh/tcsh/zsh 以外のシェルのことは考えていません。</p>
          <p>~/lcl 以下の .bashrc などのスタートアップファイルに、
             ~/lcl/bin に PATH を通したり /lcl/lib に LD_LIBRARY_PATH を通したり、
             ~/lcl/man に MAN_PATH を通したりする設定を書き込みます。
             次回ログイン時にはこのへんの設定が読み込まれます。</p>
          <p>paco と lpm 自身を ~/lcl 以下にインストールします。</p>
        <h3>パッケージのインストール方法</h3>
          <p>デフォルトリポジトリに入っているソフトの場合（例: ttyrec）</p>
            <blockquote>
              $ lpm install ttyrec<br />
            </blockquote>
          <p>lpmスクリプトが存在するソフトの場合（架空の例: foo）</p>
            <blockquote>
              $ lpm install foo.lpm (foo.lpm がカレントにある場合)<br />
            </blockquote>
          <p>tar ball しかないソフトの場合</p>
            <blockquote>
              $ lpm install http://www.example.com/foo.tar.bz2 (ローカルファイルの場合には単にファイルのパスを書けばOK)<br />
            </blockquote>
        <h3>インストールしたパッケージのリスト取得</h3>
          <p>lpm list</p>
        <h3>パッケージのアンインストール</h3>
          <p>lpm uninstall パッケージ名</p>
        <h3>Perl のパッケージインストール</h3>
          <p>前準備として lpm initcpan する。Perl の CPAN は元々使える人が操作することを前提としている。</p>
          <p>後はお好きに普通にモジュールをインストール。lpm installcpan モジュール名 でもインストール可能。</p>
        <h3>Python のパッケージインストール</h3>
          <p>lpm install virtualenv をどうぞ。</p>
          <p>あとはお好きに普通にモジュールをインストールできる。元々 Python のモジュールインストール方法を知っていることが前提。</p>
      <h2>質問してほしい質問</h2>
        <h3>lpm スクリプトの仕様は？</h3>
          <p>下のコーナーを見て。</p>
        <h3>~/lclって何？私は~/○○○を使いたい。</h3>
          <p>~/hogehoge がよければ --local=hogehoge を lpm に付けて下さい。'lpm initlocaldir --local=hogehoge' といった要領。</p>
        <h3>リポジトリに○○○が入っていない。</h3>
          <p>趣味で作ったソフトなので作者が必要だったプログラムしかパッケージ化していません。</p>
          <p>パッケージをメンテしてくれる人が増えると楽なので是非プロジェクトに加わって下さい。メンテするパッケージは１つでもいいです。</p>
        <h3>長期的にメンテするのはイヤです。</h3>
          <p>長期的にやる気が無くても lpm ファイルを送ってくれればとりあえずデフォルトリポジトリに入れておきます。何も無いよりはマシだと考えましょう。</p>
        <h3>使えないので lpm 自体をアンインストールしたい。</h3>
          <p>lpm removelocaldir すると何も無かったかのごとく消え去ります。</p>
          <p>.bashrc 等のスタートアップスクリプトにコメントのゴミとかが多少残るかも。</p>
      <h2>lpm スクリプトの書き方</h2>
        <h3>基本</h3>
          <p># で始まる行はコメントです。空行は無視されます。</p>
        <h3>GNUスタイルのtar ball (./configure &amp;&amp; make &amp;&amp; make install でインストールできる tar ball) の場合</h3>
          <p>下記の source のところを埋めて下さい。</p>
          <blockquote>
            # Description: netcat<br />
            #<br />
            # source URL. It specifies where to download from.<br />
            source=http://internap.dl.sourceforge.net/sourceforge/netcat/netcat-0.7.1.tar.bz2<br />
            # URL. Just for information.<br />
            url=http://netcat.sourceforge.net/<br />
            # download the package<br />
            download<br />
            # extract files<br />
            extract<br />
            # configure<br />
            configure<br />
            # make<br />
            make<br />
            # make install<br />
            makeinstall<br />
          </blockquote>
          <p>source として指定する URL は原則として tarball の URL で、基本的には http://, ftp:// などをここには指定します。</p>
          <p>source には git や mercurial, subversion リポジトリを指定することもできます。リポジトリの種類は URL から自動的に判定されますが、http や https を用いる場合などは頭にリポジトリ名とカンマを付けて source=git,http://foo.example.com/reponame のように指定し、曖昧性を取り除いてください。
             リポジトリからダウンロードした場合には extract コマンドは不要になります。</p>
          <p>url=を書くと公開リポジトリに登録したときにパッケージリストのページからリンクが張られますので lpm スクリプトを他人と共有するときには役に立ちます。</p>
        <h3>Java アプリ等で make の必要はないんだけど</h3>
          <p>makeの行を外して下さい。</p>
        <h3>ソフト名やバージョン番号の認識が変です。</h3>
          <p>GNU style でないアーカイブ名を使った場合や、URL から推測できない(LPMは単純な正規表現で推測しています)ソフト名・バージョン番号の場合には lpm スクリプト内で記述してください
             (e.g., boost_1_49_0 はダメですが、boost-1.49.0 なら OKです。).</p>
          <blockquote>
            source=http://example.com/really-difficult-to-read-SoftwareName0.1.bin2.22fc.example.ver.zip<br />
            name=SoftwareName<br />
            ver=0.1.bin2.22fc<br />
          </blockquote>
          <p>また、バージョン番号は download コマンドを実行した直後にリポジトリのバージョン番号に書き換えられますので、必要な場合には download コマンドの後に ver コマンドを追加してください。</p>
        <h3>アーカイブ内のトップディレクトリが GNU 標準に従ってないので make && ./configure に失敗します。</h3>
          <p>hogehoge version 1.2.3 なら hogehoge-1.2.3.tar.gz （あるいは.tar.bz2）という tar ball のファイル名で、トップディレクトリ（アーカイブ中の最上位に含まれるディレクトリ）は hogehoge-1.2.3 でなくてはなりません。</p>
          <p>それ以外の場合には手動で設定してください。</p>
          <blockquote>
            topdirname=SoftwareName_0.1.bin2.22fc
          </blockquote>
        <h3>make install ではインストールできないんだけど</h3>
          <p>custominstall から EOC までの行でシェルスクリプトを書いて下さい。
             custominstall の次の行では、カレントディレクトリはトップディレクトリになっています。</p>
          <blockquote>
            # install<br />
            custominstall<br />
            cd FastQC<br />
            cp -r uk $LIB_DIR/java<br />
            mkdir $SHARE_DIR/FastQC<br />
            cp -r *.txt *.ico *.bat Help $SHARE_DIR/FastQC<br />
            EOC<br />
          </blockquote>
          <p>シェルスクリプト内で使える環境変数は、ローカルディレクトリを ~/lcl (--local オプションで設定できます)として、hogehoge-1.3.2.tar.gz をインストール中だとすると、
            </p><dl>
              <dt>$LOCAL_DIR</dt><dd>~/lcl</dd>
              <dt>$ARCHIVE_DIR</dt><dd>~/lcl/archive</dd>
              <dt>$BIN_DIR</dt><dd>~/lcl/bin</dd>
              <dt>$LIB_DIR</dt><dd>~/lcl/lib</dd>
              <dt>$VAR_DIR</dt><dd>~/lcl/var</dd>
              <dt>$OPT_DIR</dt><dd>~/lcl/var</dd>
              <dt>$SHARE_DIR</dt><dd>~/lcl/share</dd>
              <dt>$MAN_DIR</dt><dd>~/lcl/man</dd>
              <dt>$BUILD_DIR</dt><dd>~/lcl/build</dd>
              <dt>$INCLUDE_DIR</dt><dd>~/lcl/include</dd>
              <dt>$LPMLIB_DIR</dt><dd>~/lcl/lib/lpm</dd>
              <dt>$PACKAGE_NAME</dt><dd>hogehoge</dd>
              <dt>$PACKAGE_VER</dt><dd>1.3.2</dd>
              <dt>$ARCHIVE_FILE</dt><dd>~/lcl/archive/hogehoge-1.3.2.tar.gz</dd>
            </dl>
            です。--local=foo として LPM のローカルディレクトリを初期化した場合にはそれぞれ ~/foo/archive, ~/foo/bin, ... となります。
          
          <p>例では普通に cp コマンドを用いてファイルをインストールしていますが、
             全てのファイル生成は paco を用いて追跡されているので、どんなやり方でファイルを生成しても
             ちゃんとアンインストールできます。
             例外としては Java VM のように static compile されたソフトからファイルを生成する場合ですが、
             インストーラーで Java はまぁ、使わないので普通は問題ないでしょう。</p>
        <h3>最初に paco を取ってくるみたいに Sourceforge で最新版を取ってきたい</h3>
          <blockquote>
            getlatest=URL package<br />
          </blockquote>
          <p>URL にはダウンロードページを書いておいて下さい。
             packageにはパッケージ名を書いて下さい。HTMLを解析して最もバージョン番号が高いものをダウンロードします。
             source, name, ver は自動でセットされますが、GNU style でないファイル命名規則の場合には動かない場合もあります。
             </p>
        <h3>configure にオプションを付けたいです。</h3>
          <p>configure の後ろにはオプションが付けられます。</p>
          <blockquote>
            configure --disable=lib-foo<br />
          </blockquote>
        <h3>make の代わりに任意のシェルスクリプトを実行したいです。</h3>
          <p>shell と EOC で囲まれたスクリプトを実行できます。custominstall コマンドとほとんど同じですが、paco によるファイル追跡を行わないのが shell コマンドの特徴です。</p>
          <p>shell の次の行では常にトップディレクトリがカレントディレクトリです。shell ブロック内で cd しても次の shell/custominstall ブロックではカレントディレクトリはトップディレクトリに戻っています。</p>
        <h3>環境変数のセットアップを行いたいです。</h3>
          <p>ログインシェルに作用させたい場合</p>
          <blockquote>
            loadstartup<br />
            setlogin<br />
            export FOO=abc<br />
            ...<br />
            EOC<br />
            savestartup<br />
          </blockquote>
          <p>tcsh/csh 系のために、'export FOO=' を 'setenv FOO ' に自動で置き換えてくれますのでスクリプトは bash 用にだけ用意すればOKです。</p>
          <p>全てのシェルに作用させたい場合</p>
          <blockquote>
            loadstartup<br />
            setini<br />
            シェル起動時に実行したいスクリプト<br />
            EOC<br />
            savestartup<br />
          </blockquote>
        <h3>ダウンロードしたパッケージが壊れていないかチェックしたいです。</h3>
          <p>md5 か sha256 が使えます。</p>
          <blockquote>
            md5 9fcbe4fbb11f9168c675a9ab05879e7a<br />
            sha256 5baf33b4232d267acb1e1ef8c0606b0bad5866473837a3fd22f714fca29efcbf<br />
          </blockquote>
        <h3>インストールしたファイルの一部分をちょっと書き換えたいです。</h3>
          <p>ありますよねぇ。Makefile をちょっとだけいじりたいとか。</p>
          <blockquote>
            replaceregexp<br />
            ファイル名<br />
            サーチ正規表現<br />
            置き換え正規表現<br />
          </blockquote>
          <p>このコマンドは４行を消費します。横に並べる仕様でも良かったのですが、スペースをサーチしたい場合を考えるとエスケープが面倒になりすぎでやめました。</p>
          <p>ファイル名は解凍したアーカイブからの相対パスです。上からファイルを走査して、「サーチ正規表現」にヒットする行まで移動し、その行で「置き換え正規表現」を適用します。</p>
          <p>使い方がピンとこないって？以下の例では Makefile の中から CFLAGS を設定している行をサーチし、-fPIC オプションを追加します。</p>
          <blockquote>
            replaceregexp<br />
            Makefile<br />
            /CFLAGS/<br />
            s/CFLAGS=/CFLAGS=-fPIC /<br />
          </blockquote>
       <h3>並列 make したいんだけど</h3>
          <p>make に -j オプションを渡す方法もありますが、一般的には環境変数 LPM_MAKE_OPTION を使ってください。</p>
          <p>後者だとユーザーの環境にCPUコアがいくつあるかによってユーザーが使用する CPU コア数を変更することができてより柔軟です。</p>
          <blockquote>
            export LPM_MAKE_OPTION=-j8<br />
            lpm install hogehoge<br /><br />
          </blockquote>
       <h3>lpm をバージョンアップしたい</h3>
          <p>updatelpm コマンドでどうぞ</p>
          <blockquote>
            lpm updatelpm<br />
          </blockquote>
       <h3>複数のローカルディレクトリを使い分けたい</h3>
          <p>例えばいくつかのソフトについて、gcc と Intel C でスピードを測りたい、という状況を考えます。</p>
          <p>まず、gcc をコンパイラとして用いる状態で ~/gcc 以下にソフトを入れます。</p>
          <blockquote>
            $ export CC=gcc<br />
            $ lpm initlocaldir --local=gcc<br />
            $ exec $SHELL -l<br />
            $ export CC=gcc   (上のコマンドで再ログインしたので CC は消えているかもしれないので)<br />
            $ lpm install targetsoft1 --local=gcc<br />
            $ lpm install targetsoft2 --local=gcc<br />
            $ lpm install targetsoft3 --local=gcc<br />
          </blockquote>
          <p>ソフトを入れ終わったら ~/gcc ディレクトリは非アクティブにしてしまいましょう。</p>
          <blockquote>
            lpm ssconfig gcc off<br />
          </blockquote>          
          <p>非アクティブになったことを確認します。</p>
          <blockquote>
            lpm ssconfig<br />
          </blockquote>          
          <p>設定ファイル類を読み直して環境変数を正しい状態にするために一回再ログインします。</p>
          <p>つぎに、icc (Intel C compiler)をコンパイラとして用いる状態で ~/icc 以下にソフトを入れます。</p>
          <blockquote>
            $ export CC=icc<br />
            $ lpm initlocaldir --local=icc<br />
            $ exec $SHELL -l<br />
            $ export CC=icc   (上のコマンドで再ログインしたので CC は消えているかもしれないのを思い出して下さい)<br />
            $ lpm install targetsoft1 --local=icc<br />
            $ lpm install targetsoft2 --local=icc<br />
            $ lpm install targetsoft3 --local=icc<br />
          </blockquote>
          <p>この状態で targetsoft1,2,3 のベンチマークを取ります。終わったら今度は gcc を有効にします。</p>
          <blockquote>
            lpm ssconfig icc off<br />
            lpm ssconfig gcc on<br />
          </blockquote>
          <p>再ログインして下さい。今度は gcc で作った targetsoft1,2,3 が実行できるようになっています。</p>

</div>  <!-- end of main text -->
		
<div class="right">
		
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
		
</div> <!-- end of navigation -->

<div id="clear"></div>

</div>

<div id="bottom"></div>

</div>

<div id="footer">
Design by <a href="http://www.minimalistic-design.net">Minimalistic Design</a>
</div>

</body>
</html>
