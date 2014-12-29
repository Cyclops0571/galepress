@echo off
::--------------------------------------------------------
::-- Configuration
::--------------------------------------------------------

::TEST SERVER
::set "host=www.galetest.com"
::set "username=galetest@galetest.com"
::set "password=cZzC49V4"

::PRODUCTION SERVER
set "host=www.galepress.com"
set "username=site@galepress.com"
set "password=cJAyuu1r"

set "directoryToUpload=D:\Projects\galepress"
set "root=/public_html"
set "ignored=.git .vagrant application\config bundles laravel public\files\customer_ public\files\temp storage db.sql"
::--------------------------------------------------------
::-- Main
::--------------------------------------------------------
echo open %host%> upload.dat
echo %username%>> upload.dat
echo %password%>> upload.dat
echo binary>> upload.dat
echo prompt>> upload.dat
echo mkdir %root%>> upload.dat
call:upload %directoryToUpload%
echo disconnect>> upload.dat
echo quit>> upload.dat
ftp -s:upload.dat
del upload.dat
goto:eof
::--------------------------------------------------------
::-- Functions
::--------------------------------------------------------
:upload
for /f "delims=" %%a in ('dir /b /a /o /s %directoryToUpload%') do call:checkIfExistsInIgnored %%a
goto:eof

:checkIfExistsInIgnored
set "found=false"
for %%a in (%ignored%) do call:checkIfExistsInIgnored_If %~1 %%a
if "%found%"=="false" call:checkIfDirectory %~1
goto:eof

:checkIfExistsInIgnored_If
set "var=%~1"
set "search=%~2"
call set "test=%%var:%search%=%%"
if NOT "%test%"=="%var%" set "found=true"
goto:eof

:checkIfDirectory
if exist %~1\* goto:checkIfDirectoryTrue
set "currentFile=%~1"
call set "remoteFile=%%currentFile:%directoryToUpload%=%%"
set "remoteFile=%remoteFile:\=/%"
echo put %~1 %root%%remoteFile%>> upload.dat
goto:eof

:checkIfDirectoryTrue
set "currentFile=%~1"
call set "remoteFile=%%currentFile:%directoryToUpload%=%%"
set "remoteFile=%remoteFile:\=/%"
echo mkdir %root%%remoteFile%>> upload.dat
goto:eof
::--------------------------------------------------------
::-- Related Documents
::--------------------------------------------------------
::http://www.computerhope.com/dirhlp.htm
::http://www.dostips.com/DtTipsFtpBatchScript.php
::http://www.dostips.com/DtTipsStringManipulation.php
::http://stackoverflow.com/questions/17602659/batch-file-find-if-substring-is-in-string-not-in-a-file-part-2-using-variab
::http://stackoverflow.com/questions/5816178/how-to-replace-string-inside-a-bat-file-with-command-line-parameter-string
::http://scripts.dragon-it.co.uk/scripts.nsf/docs/batch-search-replace-substitute!OpenDocument&ExpandSection=3&BaseTarget=East&AutoFramed
::http://superuser.com/questions/358099/how-do-i-ftp-multiple-files-from-the-command-line
::http://superuser.com/questions/358099/how-do-i-ftp-multiple-files-from-the-command-line
::http://forum.raymond.cc/threads/automate-ftp-uploads-using-commandline.11013/
::http://forum.raymond.cc/threads/automate-ftp-uploads-using-commandline.11013/
::http://www.computerhope.com/forum/index.php?topic=100255.0
::http://www.biterscripting.com/helppages/SS_FTPUpload.html
::http://stackoverflow.com/questions/138981/how-do-i-test-if-a-file-is-a-directory-in-a-batch-script
::http://www.robvanderwoude.com/for.php
::http://www.robvanderwoude.com/if.php
::http://www.dostips.com/DtTutoFunctions.php
::http://superuser.com/questions/15214/command-line-batch-file-to-list-all-the-jar-files
::http://stackoverflow.com/questions/7005951/batch-file-find-if-substring-is-in-string-not-in-a-file
::http://stackoverflow.com/questions/5626879/how-to-find-if-a-file-contains-a-given-string-using-dos-command-line