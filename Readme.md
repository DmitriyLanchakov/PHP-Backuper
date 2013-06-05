PHP Backuper	{#mainpage}
===
This is a framework which will help you making (incremental) backups of your site, pack them to archive (every format that PHAR supports) and save it into remote or local locations, such as different cloud storages, FTP servers, e-mail, file sharing services, etc...
Extremely useful for daily backup 
The framework is written in pure php an can be used on free hostings with supported PHP version ( 5.4+) and was designed as extensible.
Feel free to fork and modify it.

[Doxygen documentation](http://kolanich.github.com/PHP-Backuper/)


Requirements
---
PHP 5.4+

SQLite + its PDO driver

dBug - https://github.com/KOLANICH/dBug - for debug output

[PHAR](http://www.php.net/manual/en/phar.fileformat.php)

MySQL + its PDO driver for MySQLBackuper

SabreDAV - https://github.com/KOLANICH/SabreDAV - for WebDAVUploader

DropboxUploader - https://github.com/KOLANICH/DropboxUploader - for DropboxSimpleUploader

Modules folder structure
---
There is a folder, where we store the modules, somewhere in the server. Let's call it 'modules' for example.
Then the subtree will be such:
~~~
modules
   |
   |---Backuper_______
   |            |    |
   |           ...  Backuper.php
   |
   |---Sabre________
   |         |     |
   |         ...  Dav___
   |               |   |
   |              ...  Client.php
   |
   |---DropboxUploader______
   |                  |    |
   ...               ...  DropboxUploader.php
~~~

Backup main workflow
---

Look into example.php .
To make backup you'll need:
1. to create a Backuper instance
2. to call makeBackup() method

### Creating instance
~~~{.php}
	new Backuper(
		[
			'upload'=>[
				/*here should be a list of upload plugins (further uploaders)*/
			],
			'backup'=>[
				/*here should be a list of backup pluguns (further backupers)*/
			]
		]
	);
~~~



### Making backup
You need to call Backuper::makeBackup method.

Look example.php for details.

Backupers
---
Backupers are responsible for extracting data, packing them to archive and mantaining index.
Each backuper must implement IBackuper interface.

Uploaders
---
Uploaders are responsible for upload resulting archive to different services such as DropBox, SugarSync, Google Drive, Yandex.Disk, etc.
Each uploader must implement IUploader interface.

Implemented modules (most of them ;)
---
* WebDAVUploader - will help you with uploading to [Yandex.Disk](http://help.yandex.com/disk/webdav.xml), [Box.com](https://support.box.com/entries/20359428-Does-Box-support-WebDAV), [SkyDrive](https://skydrivesimpleviewer.codeplex.com/) and other [WebDAV](https://ru.wikipedia.org/wiki/Webdav) services.
Also you can use https://dav-pocket.appspot.com/ to access DropBox and http://otixo.com/ to access most of cloud storages through WebDAV.
* DropboxSimpleUploader - will help you with uploading to [DropBox](https://www.dropbox.com/) using login and password.
* FileTreeBackuper - makes incremental backup of file tree. Supports ignores. Every ignore is a regex in FileTreeBackuper_ignores.
* MySQLBackuper - makes backup of SQL database (structure + data), but there can be problems. Also, you can possible to use it to backup bases other than MySQL, which are MySQL compatible and have PDO interface.