<?php

class dir_Core
{
    /**
     * Returns a recursive list of files in directory with full paths.
     *
     * @param str $dir The directory to traverse
     *
     * @return array
     */
    public static function list_files($dir)
    {
        $files = array();

        foreach (array_diff(scandir($dir), array('.', '..')) as $resource) {
            if (is_dir("$dir/$resource")) {
                $files = array_merge($files, self::list_files("$dir/$resource"));
            } else {
                $files[] = realpath("$dir/$resource");
            }
        }

        return $files;
    }
}
