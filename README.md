# 文件系统操作

文件系统组件用于对常用目录操作的实现

[TOC]
##开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require aweitian/filesystem
```

####创建目录
```
Filesystem::createDir($dir, $auth = 0755, $recursive = true)
```

####删除目录
```
Filesystem::delDir($dir, $delself = true);
```

####复制目录
```
Filesystem::copyDir($old, $new, $copyself = false);
```

####新建文件
```
copyDir("/aa/bb/c","/dd")  把c下所有的文件CP到/DD下
copyDir("/aa/bb/c","/dd",true)  把c下所有的文件CP到/DD/c下
Filesystem::touch($file);
```

####删除文件
```
Filesystem::delFile($file);
```

####目录大小
```
Filesystem::size('Home');
```

####复制文件
```

Filesystem::copyFile($file, $to, $force = true)
```