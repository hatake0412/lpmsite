<p>Use the latest stable version for most users. It is just a single uncompressed file.</p>
<h3>Stable version</h3>
<p><a href="http://www.kasahara.ws/lpm/lpm">Version 1.26</a></p>
<h3>Development version</h3>
<p><a href="http://www.kasahara.ws/lpm/lpm-devel">Version 1.27alpha</a></p>
<p>You might see a dead link if there is no developmental version</p>
<h2>Prerequisites</h2>
<p style="display:block;">LPM requires the following packages:</p>
<ul>
 <li>Linux (it may not work with other OS. Mac OS support is experimental.)</li>
 <li>Perl (may work ver 5.6 or later; we tested with 5.10)
     <ul>
         <li>If you are using Ubuntu, you may need to do 'sudo apt-get libwww-perl' by root (If you cannot ask your administrator to do that, you may do almost the same without root, but the procedure is a bit complicated.).</li>
     </ul></li>
 <li>GNU tar </li>
 <li>gzip</li>
 <li>bzip2</li>
 <li>GNU make</li>
 <li>C/C++ compiler such as GCC. (You need both C and C++.)</li>
 <li>git (You do not need git if you do not install software hosted only by a git repository such as github.)</li>
</ul>
<p>We recommend to use the following packages with LPM, although they are not required:</p>
<ul>
 <li>md5sum (without this, LPM will not verify downloaded software)</li>
 <li>sha256sum (without this, LPM will not verify downloaded software)</li>
 <li>gpg (without this, LPM will not verify downloaded software)</li>
</ul>
<h2>Supported Shells</h2>
<p>bash, tcsh, and zsh are supported. If your favorite shell other than these has a syntax like bash/tcsh, you may be able to use LPM, although some of the features like automatic settings of environmental variables may not work properly.</p>
<h2>License</h2>
<p><a href="http://www.gnu.org/licenses/gpl.html">GPL v3</a> or later versions. Alternatively, you can use <a href="http://dev.perl.org/licenses/artistic.html">Artistic License</a> also. (Choose either one as you like.)
<p>If you submit a patch to the mailing list, we consider that you agreed to distribute your patch under these licenses.</p>
<h2>Acknowledgements</h2>
<p>LPM is developed in part on the supercomputer of Human Genome Center, Institute of Medical Science, University of Tokyo (http://sc.hgc.jp/shirokane.html).
   This work is in part supported by Grant-in-aid for Scientific Research on Innovative Areas 'Genome Science' (221S0002) from Ministry of education, culture, sports, science and technology (MEXT).
   We thank T. Nishiyama for bug reports, patches, and sugesstions.</p>
