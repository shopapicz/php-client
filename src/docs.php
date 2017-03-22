<?php
require '../vendor/autoload.php';

$dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR;

if(!file_exists($dir)) {
    mkdir($dir);
}

function writeMethods(ReflectionClass $class, $fp) {
    if($class->getParentClass()) {
        writeMethods($class->getParentClass(), $fp);
    }
    foreach ($class->getMethods() as $method) {
        if(!$method->isPublic() || $method->getName() === '__construct' || substr($method->getName(), 0, 3) === 'set' || substr($method->getName(), 0, 3) === 'add') {
            continue;
        }
        $return = '';
        $description = '';
        foreach (explode("\n", $method->getDocComment()) as $line) {
            $line = ltrim(trim(trim(trim($line), '*')), '/');
            if(strpos($line, '@return') === 0) {
                $return = trim(substr($line, 7));
                $return = addLinks($return);
                $return = str_replace('|', '&#124;', $return);
            } elseif(strpos($line, '@') !== 0 && !empty($line)) {
                $description = $line;
            }
        }
        if(!$return) {
            if($method->hasReturnType()) {
                $return = str_replace('ShopAPI\\Client\\Entity\\', '', $method->getReturnType());
                $return = addLinks($return);
                if($method->getReturnType()->allowsNull()) {
                    $return .= '&#124;null';
                }
            }
        }
        $parameters = [];
        foreach ($method->getParameters() as $parameter) {
            $parameters[] = $parameter->getName();
        }
        fwrite($fp, '| ' . $method->getName() . " | $return | " . implode(', ', $parameters) . "  | $description |\n");
    }
}

function addLinks(string $return) {
    return preg_replace_callback('~[A-Z][a-zA-Z]+~', function ($match) {
        if($match[0] === '\\DateTime' || $match[0] === 'DateTime') {
            return $match[0];
        }
        return '[' . $match[0] . '](#' . strtolower($match[0]) . ')';
    }, $return);
}

$fp = fopen($dir . 'api.md', 'w');
foreach (glob(__DIR__ . DIRECTORY_SEPARATOR . 'Entity/*.php') as $file) {
    $className = 'ShopAPI\\Client\\' . str_replace('/', '\\', substr(str_replace(__DIR__ . DIRECTORY_SEPARATOR, '', $file), 0, -4));

    $class = new ReflectionClass($className);
    if($class->isAbstract()) {
        continue;
    }

    fwrite($fp, "## " . $class->getShortName() . "\n");
    fwrite($fp, "| Method | Return type | Arguments |Description |\n");
    fwrite($fp, "| ------------- |-------------| -----| -----|\n");

    writeMethods($class, $fp);

}
