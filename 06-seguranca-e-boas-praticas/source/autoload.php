<?php

require __DIR__ . '/Support/Config.php';

spl_autoload_register(
    function(string $instanceClass): void {
        $appVendorPrefix = "Source\\";
        $baseDir = __DIR__ . "/";
        $appVendorLength = strlen($appVendorPrefix);

        if (strncmp($appVendorPrefix, $instanceClass, $appVendorLength) !== 0) {
            return;
        }

        $namespaceClass = substr($instanceClass, $appVendorLength);
        #          root.../src/      Namespace/Other/Etc/ClassFileName     .php
        $classFile = $baseDir . str_replace("\\", "/", $namespaceClass) . ".php";

        if (file_exists($classFile)) {
            require $classFile;
        }
    }
);