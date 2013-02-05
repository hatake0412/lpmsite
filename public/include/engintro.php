<p>Most software packages for Linux are provided as rpm/deb packages.
If you have a root access, rpm and deb (with managing tool like yum) are easiest way to install a package.
However, suppose you are using a supercomputer center and you are just a non-privileged user.
In such a case, you need to download a source code usually provided as a tar ball.
You would first have to choose a right decompressor (gzip/bzip2/unzip/etc.), a working directory that will be used for build.
You open README file in the tar ball, run a configure script with prefix option, type 'make && make install.'
You may have to set PATH, LD_LIBRARY_PATH and possibly other application-specific environmental variables.
You repeat this cycle every time you install a new package.
When you want to update the existing packages, you do the same.
When you migrate to a new supercomputer center, you do this again.
What a frustrating process!
LPM automates this process.</p>
<p>OK, we have to warn you a bit first.
If you are using only one machine and you are the first user that installs some package under home directory, LPM would not make your life easier.
If someone creates a small script called LPM script that describes how to install that software under home directory, you can easily install that software.
If you are installing the same software on different machines, you can create an LPM script once and then you can save time by applying it to all the machines.
We are accepting contributions from users, and hope that such LPM scripts can be shared among users world-wide.
(We review contributed scripts before publishing them on the default public repository for security reason.)
</p>
