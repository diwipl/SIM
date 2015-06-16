# Homomorphic Verification PHP Implementation


Usage:
-----------

**CLI**:

php -d memory_limit=512M run.php config_file.ini

**Web**:

Put project files and index.php to your web server directory. Then access it from a web browser.

Requirements:
-----------

**CLI**:  
- Memory limit must be set to 512M

**Web**:  
- Memory limit must be set to 512M  
- Script must be able to set 0 as time limit.  
- Zip PECL Library needed for ZIP packaging of result files.

Used External Libraries:
-----------
FFT class from http://www.phpclasses.org/package/6193-PHP-Compute-the-Fast-Fourier-Transform-of-sampled-data.html

Performance:
-----------
i2500k CPU, Mac OS X Yosemite, php 5.6 script executes for ~2,5 minutes  
i2500k CPU, Mac OS X Yosemite, php 7 (currently in development) script executes for ~1 minute  



