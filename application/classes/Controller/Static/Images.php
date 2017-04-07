<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Static_Images extends Controller
{
    /**
     * Метод ресайзит изображение
     * @param varchar $outfile - имя нового изображения с полным путем
     * @param varchar $infile - имя исходного изображения с полным путем
     * @param int $neww - максимальная ширина создаваемого изображения
     * @param int $newh - максимальная высота создаваемого изображения
     * @param int $quality - качество создаваемого изображения
     */
    public static function imageresize($outfile,$infile,$neww,$newh,$quality)
    {
        if (substr_count($infile, 'gif') !== 0 || substr_count($infile, 'GIF') !== 0 ) {
            $im=imagecreatefromgif($infile);
            $k1=$neww/imagesx($im);
            $k2=$newh/imagesy($im);
            $k=$k1>$k2?$k2:$k1;

            $w=intval(imagesx($im)*$k);
            $h=intval(imagesy($im)*$k);

            $im1=imagecreatefromgif($w,$h);
            imagecopyresampled($im1,$im,0,0,0,0,$w,$h,imagesx($im),imagesy($im));

            imagegif($im1,$outfile,$quality);
            imagedestroy($im);
            imagedestroy($im1);
        } elseif (substr_count($infile, 'jpg') !== 0 || substr_count($infile, 'jpeg') !== 0 || substr_count($infile, 'JPG') !== 0 || substr_count($infile, 'JPEG') !== 0) {
            $im=imagecreatefromjpeg($infile);
            $k1=$neww/imagesx($im);
            $k2=$newh/imagesy($im);
            $k=$k1>$k2?$k2:$k1;

            $w=intval(imagesx($im)*$k);
            $h=intval(imagesy($im)*$k);

            $im1=imagecreatetruecolor($w,$h);
            imagecopyresampled($im1,$im,0,0,0,0,$w,$h,imagesx($im),imagesy($im));

            imagejpeg($im1,$outfile,$quality);
            imagedestroy($im);
            imagedestroy($im1);
        } else {
            $im=imagecreatefrompng($infile);
            $k1=$neww/imagesx($im);
            $k2=$newh/imagesy($im);
            $k=$k1>$k2?$k2:$k1;

            $w=intval(imagesx($im)*$k);
            $h=intval(imagesy($im)*$k);

            //------------
            //открываем исходное изображение
            $src = ImageCreateFromPNG($infile); 

            //создаем дескриптор для уменьшенного изображения
            $dst = imagecreatetruecolor($w,$h); 

            //устанавливаем прозрачность
            self::setTransparency($dst, $src);
            
            //изменяем размер
            ImageCopyResampled($dst, $src, 0, 0, 0, 0, $w,$h, imagesx($im),imagesy($im)); 

            //сохраняем уменьшенное изображение в файл
            ImagePNG($dst, $outfile); 

            //закрываем дескрипторы исходного и уменьшенного изображений
            ImageDestroy($src);
            ImageDestroy($dst);
        }
    }
    
    public static function setTransparency($new_image, $image_source)
    {
        $transparencyIndex = imagecolortransparent($image_source);
        $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);

        if ($transparencyIndex >= 0)
            $transparencyColor = imagecolorsforindex($image_source, $transparencyIndex);   

        $transparencyIndex = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
        imagefill($new_image, 0, 0, $transparencyIndex);
        imagecolortransparent($new_image, $transparencyIndex);
    }
}