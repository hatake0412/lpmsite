        <p>LPM is a package manager that installs packages (e.g., tar ball) under your home directory. You do not need root privilege.</p>
        <p>LPM does not take rpm/deb packages. It basically takes GNU-style tar balls. It can take other types of files if you write an LPM script that describes how to install it.</p>
      <h2>What is the difference with yum or apt?</h2>
        <p>If you do not have root, you cannot use yum or apt. LPM does not need root.</p>
      <h2>I can install a package (tar ball) to my home directory.</h2>
        <p>Yes, you may not need LPM if you can manually download a tar ball and can do './configure --prefix=$HOME/local &amp;&amp; make &amp;&amp; make install'.
           I was doing that but got much frustrated so I developed LPM. Suppose if you have accounts on several supercomputer centers:</p>
           <ul>
             <li>You google the name of the software you want to install and download the latest version of the software.
                 You may not want to copy-and-paste the URL from browser to your terminal more than once.</li>
             <li>You have to specify to which directory you download the tar ball.
                 You have your convention so you always specify the same directory (e.g., ~/archives) but you do not want to do that more than once.</li>
             <li>You sometimes miss --prefix for configure, and get frustrated.</li>
             <li>Some packages require us to set environmental variables after doing 'make install'.
                 You may have to set PATH, MAN_PATH, LD_LIBRARY_PATH, or FOO_ROOT, etc., but you may believe that the process can be automated.</li>
             <li>You like tcsh but most packages set only .bash_profile and it does not work.</li>
             <li>You sometimes find that no uninstaller comes with the package. Packages created by using GNU automake can be uninstalled by 'make uninstall', but still with this case, you have to remove settings in .bash_profile or equivalent.
                 Non-GNU-style packages are harder to uninstall.</li>
             <li>You want to install modules of Perl, Python, or Ruby. LPM sets appropriate environmental variables, so you can easily install modules without root.</li>
             <li>You want to install different verions of the same library (or program). You can switch between different sets of programs.</li>
           </ul>
      <h2>Usage</h2>
        <h3>How to install a new package</h3>
          <p>When the target software has an LPM script in the default public repository (e.g., ttyrec):</p>
            <blockquote>
              $ lpm install ttyrec<br />
            </blockquote>
          <p>When You wrote an LPM script for some software,</p>
            <blockquote>
              $ lpm install foo.lpm (Specify the absolute path if it is not in the current directory)<br />
            </blockquote>
          <p>Install from GNU-style tar ball:</p>
            <blockquote>
              $ lpm install http://www.example.com/foo.tar.bz2 (You can specify the path of a local file instead of URL)<br />
            </blockquote>
        <h3>How to get the list of the installed packages.</h3>
          <p>lpm list</p>
        <h3>How to Uninstall a package (e.g., foo).</h3>
          <p>lpm uninstall foo</p>
        <h3>How to install a Perl module.</h3>
          <p>Do 'lpm initcpan' first. You need to do it just once; you can skip it when installing second module or later. We assume that you can use Perl CPAN, so we omit how to setup CPAN.</p>
          <p>Install any module as usual. Alternatively, you can use 'lpm installcpan module_name'.</p>
        <h3>How to install Python package.</h3>
          <p>Do 'lpm install virtualenv'</p>
          <p>Install any module as usual. We assume that you know how to use vertualenv.</p>
      <h2>Questions we want you to ask.</h2>
        <h3>How do I write a new LPM script?</h3>
          <p>See below.</p>
        <h3>Why LPM use '~/lcl'? I want to use ~/foo instaed.</h3>
          <p>Add '--local=foo'. For example, 'lpm initlocaldir --local=foo'.</p>
        <h3>ABC is missing in the default public repository. ABC should be there!</h3>
          <p>We cannot maintain all packages in the world.</p>
          <p>We would be happy if you maintain an LPM script for some program and share it with people in the world!</p>
        <h3>I wrote an LPM script, but do not want to maintain it.</h3>
          <p>Something is better than nothing. If you send it to us, we put it on the public repository, and we are still happy with that. Someone in the future may write a better script based on your (old) script.</p>
        <h3>I tried LPM but it was not my taste. How do I unintall LPM?</h3>
          <p>Do 'lpm removelocaldir', and everything related to LPM will disappear.</p>
          <p>Things that might be are comments in start-up scripts like .bashrc (the author is lazy and have not written a code for removing the comments).</p>
      <h2>How to write an LPM script</h2>
        <h3>Basics</h3>
          <p>Lines that start with '#' (without quotes) are considered as comments. Empty lines are just ignored.</p>
        <h3>If the target application is a GNU-style tar ball, (i.e., you can do './configure &amp;&amp; make &amp;&amp; make install' to install it)</h3>
          <p>Fill the URL in the line that contains 'source='.</p>
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
          <p>source is a URL from which you can download a tar ball. It usually starts with http:// or ftp://.</p>
          <p>source can also be a git/hg/svn repository URL.
             If you download the source tree from a git repository, then you can specify the git path (git://...) as source.
             LPM infers the repository type (git, mercurial, subversion are) from the URL, but you may explicitly prepend the repository type and a comma to the URL in order to disambiguate (e.g., source=git,http://foo.example.com/reponame).
             You do not need extract command when you downloaded things from a repository.</p>
          <p>Please specify the URL in 'url=...' if you want to share the script with others in the public repository. You will see the link in the package list page.</p>
        <h3>I am installing a Java application, so I don't need to make it.</h3>
          <p>Comment out the line that starts with 'make' in the above example.</p>
        <h3>LPM does not recognize the name of the program and/or the version number.</h3>
          <p>If the file name of the tar ball does not follow the GNU style, specify them manually. LPM uses a simple regular expression to extract them, so it may fail with complex names.</p>
          <p>The most common pattern is the version number and the package name are separated by underscore, not by hyphen (e.g., boost_1_49_0. boost-1.49.0 is okay.).
          <blockquote>
            source=http://example.com/really-difficult-to-read-SoftwareName0.1.bin2.22fc.example.ver.zip<br />
            name=SoftwareName<br />
            ver=0.1.bin2.22fc<br />
          </blockquote>
          <p>If you download files from a repository, the version number is automatically set to the repository revision just after the repository is cloned (or checked out by subversion). You may overwrite the version number by adding ver command after download.</p>
        <h3>The top directory in the tar ball does not follow the GNU style, so 'make && ./configure' fails.</h3>
          <p>foo-1.2.3.tar.gz (or .tar.bz2) is the correct file name for foo version 1.2.3.
             The name of the top directory (the top-most directory in the tar ball) must be 'foo-1.2.3'.</p>
          <p>For tar balls with other naming convention, you must set the top directory manually.</p>
          <blockquote>
            topdirname=SoftwareName_0.1.bin2.22fc
          </blockquote>
        <h3>Package foo cannot be intalled by just 'make install'. We need to do something more complex.</h3>
          <p>Write a shell script for installation, and put it between 'custominstall' and 'EOC' in LPM script.
             You can assume that the current directory is the top directory when you execute the first line of the custominstall section.</p>
          <blockquote>
            # install<br />
            custominstall<br />
            cd FastQC<br />
            cp -r uk $LIB_DIR/java<br />
            mkdir $SHARE_DIR/FastQC<br />
            cp -r *.txt *.ico *.bat Help $SHARE_DIR/FastQC<br />
            EOC<br />
          </blockquote>
          <p>You can use the following environmental variables in 'custominstall' or 'shell' blocks.
             Here we assume that the local directory is ~/lcl (you can specify it by --local option) and that the file name of the tar ball is 'hogehoge-1.3.2.tar.gz'.
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
            If you give --local=foo to initialize the LPM local directory, these values become ~/foo/archive, ~/foo/bin, ..., respectively.
          
          <p>In the example above (custominstall), we are using normal cp command.
             However, all the files generated in custominstall block are automatically tracked by paco, so you can uninstall it even if an uninstall script does not come with the package.
             The only exception is that paco fails to track generated files when the installer uses statically linked binaries such as Oracle's Java VM to create files.
             paco depends on dynamically linked glibc to track files, so kernel calls cannot be monitored when you use statically linked binaries.
             Don't worry. We usually do not see such installers.</p>
        <h3>I want to add configure options.</h3>
          <p>You can add options just after 'configure'.</p>
          <blockquote>
            configure --disable=lib-foo<br />
          </blockquote>
        <h3>Instaed of doing 'make', I want to execute more complex commands.</h3>
          <p>A block surrounded by 'shell' and 'EOC' are executed instead of just doing 'make'.
             It look much like 'custominstall'/'EOC' block, but 'shell' does not trace created files.</p>
          <p>The current directory is always the top directory when you execute the first line of a 'shell' block.
             Even if you do 'cd' in a shell block, it does not affect to other 'shell'/'custominstall' blocks.</p>
        <h3>I want to set up environmental variables.</h3>
          <p>If you want to setup some environmental variables when you login, write like this:</p>
          <blockquote>
            loadstartup<br />
            setlogin<br />
            export FOO=abc<br />
            ...<br />
            EOC<br />
            savestartup<br />
          </blockquote>
          <p>'export FOO=' is replaced with 'setenv FOO ' for tcsh/csh, all you have to prepare is a bash script.</p>
          <p>If you want to setup some environmental variables for all shells (interactive/non-interactive), write like this:</p>
          <blockquote>
            loadstartup<br />
            setini<br />
            export FOO=abc<br />
            ...<br />
            EOC<br />
            savestartup<br />
          </blockquote>
        <h3>I want to check the hash of a tar ball.</h3>
          <p>You can use either md5 or sha256.</p>
          <blockquote>
            md5 9fcbe4fbb11f9168c675a9ab05879e7a<br />
            sha256 5baf33b4232d267acb1e1ef8c0606b0bad5866473837a3fd22f714fca29efcbf<br />
          </blockquote>
        <h3>A tar ball in my hand is bogus. I want to modify a bit of some file in the tar ball.</h3>
          <p>We often see that situation, such as 'I want to add -fPIC to this line of Makefile!'.</p>
          <blockquote>
            replaceregexp<br />
            file_name<br />
            search_regular_expression<br />
            replace_regular_expression<br />
          </blockquote>
          <p>replaceregexp command uses four lines. Differnt syntaxes that occupy only one line might be possible, but you might get frustrated when you replace strings with spaces.</p>
          <p>file_name is the relative path to be modified (remind that the current directory is the top directory).
             LPM searches the file from the beginning, and when it finds a line that matches search_regular_expression, it applies replace_regular_expression</p>
          <p>Do you get it? The example below finds a line of CFLAGS setting in Makefile, and add '-fPIC' option.</p>
          <blockquote>
            replaceregexp<br />
            Makefile<br />
            /CFLAGS/<br />
            s/CFLAGS=/CFLAGS=-fPIC /<br />
          </blockquote>
       <h3>I want to do 'make' in parallel.</h3>
          <p>Use LPM_MAKE_OPTION.</p>
          <p>Users can set the number of CPU cores used for build.</p>
          <blockquote>
            export LPM_MAKE_OPTION=-j8<br />
            lpm install foo     (make runs with 8 threads)<br /><br />
          </blockquote>
       <h3>I want to update LPM.</h3>
          <p>Do 'lpm updatelpm'</p>
          <blockquote>
            lpm updatelpm<br />
          </blockquote>
       <h3>I want to use several local directories.</h3>
          <p>Suppose that you are going to try a set of programs with gcc and Intel C to see the difference in performance.</p>
          <p>First, you install the programs to ~/gcc, using gcc.</p>
          <blockquote>
            $ export CC=gcc<br />
            $ lpm initlocaldir --local=gcc<br />
            $ exec $SHELL -l<br />
            $ export CC=gcc   (CC might be reset at this point)<br />
            $ lpm install targetsoft1 --local=gcc<br />
            $ lpm install targetsoft2 --local=gcc<br />
            $ lpm install targetsoft3 --local=gcc<br />
          </blockquote>
          <p>Let's turn off ~/gcc directory.</p>
          <blockquote>
            lpm ssconfig gcc off<br />
          </blockquote>          
          <p>Make sure that ~/gcc is inactive</p>
          <blockquote>
            lpm ssconfig<br />
          </blockquote>          
          <p>Relogin to reset environmental variables.</p>
          <p>Next, we use icc (Intel C compiler) and install the programs into ~/icc.</p>
          <blockquote>
            $ export CC=icc<br />
            $ lpm initlocaldir --local=icc<br />
            $ exec $SHELL -l<br />
            $ export CC=icc   (Again, CC might be reset at this point)<br />
            $ lpm install targetsoft1 --local=icc<br />
            $ lpm install targetsoft2 --local=icc<br />
            $ lpm install targetsoft3 --local=icc<br />
          </blockquote>
          <p>You can do benchmarks with targetsoft1,2,3 compiled by icc. Once the benchmarks with the icc binaries finish, you turn on gcc instead.</p>
          <blockquote>
            $ lpm ssconfig icc off<br />
            $ lpm ssconfig gcc on<br />
          </blockquote>
          <p>Please relogin to reset environmental variables.</p>
          <p>Next you can do benchmarks with the gcc binaries.</p>
		
