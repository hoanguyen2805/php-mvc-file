<?php

class File
{

    /**
     *
     * Hoa
     * Created at 22-04-2021 09h30
     * save data into txt file
     *
     */
    static function writeFile($url, $data)
    {
        $file = fopen($url, "a+") or die("Unable to open file!");
        if (filesize($url) < 16 && empty(trim(file_get_contents($url)))) {
            fwrite($file, $data);
        } else {
            fwrite($file, "\r\n$data");
        }
        fclose($file);
    }

    /**
     *
     * Hoa
     * Created at 23-04-2021 13h40
     * delete a line from txt file
     *
     */
    static function deleteLine($url, $data, $index, $size)
    {
        //biến mảng thành chuỗi, phân tách các phần tử bằng dấu ,
        $line = trim(implode(",", $data));
        //lấy nội dung file
        $content = file_get_contents($url);
        if ($index == 0) {
            //xóa phần tử đâu tiên
            if ($size == 1) {
                //trường hợp: còn duy nhất 1 phần tử
                $content = str_replace($line, '', $content);
            } else {
                //trường hợp: còn nhiều phần tử, xóa phần tử dầu
                $content = str_replace($line . PHP_EOL, '', $content);
            }
        } else {
            //xóa phần tử không phải phần tử đầu tiên
            $content = str_replace(PHP_EOL . $line, '', $content);
        }
        file_put_contents($url, $content);
    }

    /**
     *
     * Hoa
     * Created at 23-04-2021 10h00
     * get all content of file
     *
     */
    static function getList($url)
    {
        if (file_exists($url)) {
            if (filesize($url) < 16 && empty(trim(file_get_contents($url)))) {
                return null;
            } else {
                $file = fopen($url, "r");
                $list = array();
                while (!feof($file)) {
                    $arr = explode(",", fgets($file));
                    array_push($list, $arr);
                }
                fclose($file);
                return $list;
            }
        } else {
            return null;
        }
    }

    /**
     *
     * Hoa
     * Created at 23-04-2021 10h:30
     * update a line in file txt
     *
     */
    static function updateLine($url, $oldData, $newData)
    {
        $oldLine = trim(implode(",", $oldData));
        $newLine = trim(implode(",", $newData));
        $content = file_get_contents($url);
        $content = str_replace($oldLine, $newLine, $content);
        file_put_contents($url, $content);
    }

    /**
     *
     * Hoa
     * Created at 27-04-2021 09h00
     * delete file (image)
     *
     */
    static function deleteImage($path)
    {
        if (file_exists($path)) {
            unlink($path);
//            echo 'File ' . $path . ' has been deleted';
        } else {
//            echo 'Could not delete ' . $path . ', file does not exist';
        }
    }
}