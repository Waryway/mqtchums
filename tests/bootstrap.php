<?php
while(!file_exists(getcwd() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'))
{
    chdir('../');
}
chdir('src');
?>