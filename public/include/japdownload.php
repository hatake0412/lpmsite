<p>基本的には安定版の最新バージョンを使ってください。簡単に使えることを重視したため、ファイルは１つだけでしかも未圧縮です。</p>
<h3>安定版(Stable)</h3>
<p><a href="http://www.kasahara.ws/lpm/lpm">Version 1.26</a></p>
<h3>開発版(Development)</h3>
<p><a href="http://www.kasahara.ws/lpm/lpm-devel">Version 1.27alpha</a></p>
<p>まだ変更が溜まっていないのでリンクが切れているかもしれません。</p>
<h2>前提となるソフト</h2>
<p style="display:block;">以下のソフトウェアが LPM の動作には必要です。</p>
<ul>
 <li>Linux (Mac OS サポートは試験運用です。BSD系のOSでは多分動かないです。)</li>
 <li>Perl  (5.6 以上ぐらいで動くと思います。作者は 5.10で動作確認。）
     <ul>
         <li>Ubuntu の人は root で sudo apt-get libwww-perl してもらってください。(root 無しの場合には少し面倒な手順が必要)</li>
     </ul></li>
 <li>GNU tar </li>
 <li>gzip</li>
 <li>bzip2</li>
 <li>GNU make</li>
 <li>GCC などの C/C++コンパイラ (C と C++ 両方必要です。)</li>
 <li>git (github 等から git clone してソフトウェアをインストールする場合に必要。)</li>
</ul>
<p>以下のソフトウェアは無くても動きますがあるとセキュリティ的に良いです。</p>
<ul>
 <li>md5sum （パッケージ検証しないなら不要）</li>
 <li>sha256sum （パッケージ検証しないなら不要）</li>
 <li>gpg （パッケージ検証しないなら不要）</li>
</ul>
<h2>サポートしているシェル</h2>
<p>bash, tcsh, zsh 以外のシェルはサポートしていません。
文法が bash/tcsh に似通っていれば多少不便（環境変数の自動設定は使えないかもしれない）ながらも使うことはできると思います。</p>
<h2>ライセンス</h2>
<p><a href="http://www.gnu.org/licenses/gpl.html">GPL v3</a> もしくはそれ以降のバージョン、あるいは<a href="http://dev.perl.org/licenses/artistic.html">Artistic License</a> で配布します。（どちらか好きな方をお選び下さい）
<p>メーリングリストにパッチを投稿する場合にはこのライセンスに従って配布することに同意したものと見なします。</p>
<h2>謝辞</h2>
<p>本ソフトウェアは東京大学医科学研究所ヒトゲノム解析センターのスーパーコンピュータを利用して開発されました。
   また、本ソフトウェアは文部科学省科学研究費(221S0002)の支援を受けました。深く感謝致します。
   西山智明氏には特にバグレポートやパッチ等を多く頂きました。</p>

