<?php
App::uses('Component', 'Controller');
class ThumbnailComponent extends Component {

  private $defaults = array(
      'folder' => 'thumbnails',
      'width' => 150,
      'height' => 225,
      'quality' => 80,
      'resize' => 'auto',
      'cachePath' => '',
      'srcImage' => '',
      'srcHeight' => '',
      'srcWidth' => '',
      'openedImage' => '',
      'imageResized' => '',
      'folderRelative' => '',
      'basename' => '',
  );
  
  public $settings = array();

  public function __construct($Component, $settings = array()) {
      parent::__construct($Component, $settings);
      $this->defaults = array_merge($this->defaults, $settings);
  }

  public function render($image, $params, $options = array()) {
      $result = null;
      $this->setup($image, $params);
      if (file_exists($this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $this->settings['basename'])) {
         $result = str_replace("\\", "/", $this->settings['folder']) . '/' . $this->settings['cachePath'] . '/' . $this->settings['basename'];
      } elseif ($this->openSrcImage()) {
         $this->resizeImage();
         $this->saveImgCache();
         $result = 'img/' . $this->settings['folderRelative'] . '/' . $this->settings['cachePath'] . '/' . $this->settings['basename'];
      }
      $this->settings = array();
      return $result;
  }

  private function setup($image, $params) {
      $this->settings = array_merge($this->defaults, $params);

      $this->settings['basename'] = basename($image);
      if (strpos($image, '/') === 0) {
          $this->settings['srcImage'] = substr($image, 1);
      } else {
          $this->settings['srcImage'] = 'img' . DS . $image;
      }
      $this->settings['folderRelative'] = $this->settings['folder'];
      if (strpos($this->settings['folder'], '/') === 0) {
          $this->settings['folder'] = substr($this->settings['folder'], 1);
      } else {
          $this->settings['folder'] = 'img' . DS . $this->settings['folder'];
      }

      if ($this->settings['cachePath']) {
          $this->settings['cachePath'] .= DS;
      }
      $this->settings['cachePath'] .= $this->settings['width'] . 'x' . $this->settings['height'];
  }

  private function openCachedImage() {
      return $this->settings['cachePath'] . DS . $this->settings['srcImage'];
  }

  private function openSrcImage() {
    $image_path = WWW_ROOT . $this->settings['srcImage'];
    if (is_file($image_path)) {
        list($width, $heigth) = getimagesize($image_path);

        $this->settings['srcWidth'] = $width;
        $this->settings['srcHeight'] = $heigth;

        $this->settings['openedImage'] = $this->openImage($image_path);
        return true;
    } else {
        return false;
    }
  }

  private function saveImgCache() {
      $extension = strtolower(strrchr($this->settings['folder'] . $this->settings['srcImage'], '.'));
      if (!file_exists($this->settings['folder'] . DS . $this->settings['cachePath']))
          mkdir($this->settings['folder'] . DS . $this->settings['cachePath'], 0777, true);
      $filename = $this->settings['basename'];
      switch ($extension) {
          case '.jpg':
          case '.jpeg':
              if (imagetypes() & IMG_JPG) {
                  imagejpeg($this->settings['imageResized'], $this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename, $this->settings['quality']);
              }
              break;

          case '.gif':
              if (imagetypes() & IMG_GIF) {
                  imagegif($this->settings['imageResized'], $this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename);
              }
              break;
          case '.png':
              $scaleQuality = round(($this->settings['quality'] / 100) * 9);

              $invertScaleQuality = 9 - $scaleQuality;

              if (imagetypes() & IMG_PNG) {
                  imagepng($this->settings['imageResized'], $this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename, $invertScaleQuality);
              }

              break;
          default:
              break;
      }
      imagedestroy($this->settings['imageResized']);
  }

  private function resizeImage() {
      $options = $this->getDimensions();

      $optimalWidth = $options['optimalWidth'];
      $optimalHeight = $options['optimalHeight'];

      if($optimalWidth > $this->settings['srcWidth'])
      {
          $optimalWidth = $this->settings['srcWidth'];
      }

      if($optimalHeight > $this->settings['srcHeight'])
      {
          $optimalHeight = $this->settings['srcHeight'];
      }

      // generate new w/h if not provided
      if($optimalWidth && !$optimalHeight)
      {
          $optimalHeight = $this->settings['srcHeight'] * ($optimalHeight / $this->settings['srcWidth']);
      }
      elseif($optimalHeight && !$optimalWidth)
      {
          $optimalWidth = $this->settings['srcWidth'] * ($optimalHeight / $this->settings['srcHeight']);
      }
      elseif(!$optimalWidth && !$optimalHeight)
      {
          $optimalWidth = $this->settings['srcWidth'];
          $optimalHeight = $this->settings['srcHeight'];
      }

      $this->settings['imageResized'] = imagecreatetruecolor($optimalWidth, $optimalHeight);

      $info = getimagesize(WWW_ROOT . $this->settings['srcImage']);

      if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
        $trnprt_indx = imagecolortransparent($this->settings['openedImage']);

        // If we have a specific transparent color
        if ($trnprt_indx >= 0) {

          // Get the original image's transparent color's RGB values
          $trnprt_color    = imagecolorsforindex($this->settings['openedImage'], $trnprt_indx);

          // Allocate the same color in the new image resource
          $trnprt_indx    = imagecolorallocate($this->settings['imageResized'], $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

          // Completely fill the background of the new image with allocated color.
          imagefill($this->settings['imageResized'], 0, 0, $trnprt_indx);

          // Set the background color for new image to transparent
          imagecolortransparent($this->settings['imageResized'], $trnprt_indx);


        }
        // Always make a transparent background color for PNGs that don't have one allocated already
        elseif ($info[2] == IMAGETYPE_PNG) {

          // Turn off transparency blending (temporarily)
          imagealphablending($this->settings['imageResized'], false);

          // Create a new transparent color for image
          $color = imagecolorallocatealpha($this->settings['imageResized'], 0, 0, 0, 127);

          // Completely fill the background of the new image with allocated color.
          imagefill($this->settings['imageResized'], 0, 0, $color);

          // Restore transparency blending
          imagesavealpha($this->settings['imageResized'], true);
        }
      }

      imagecopyresampled($this->settings['imageResized'], $this->settings['openedImage'], 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->settings['srcWidth'], $this->settings['srcHeight']);

      if ($this->settings['resize'] == 'crop') {
          $this->crop($optimalWidth, $optimalHeight);
      }
  }

  private function crop($optimalWidth, $optimalHeight) {

      $cropStartX = ( $optimalWidth / 2) - ( $this->settings['width'] / 2 );
      $cropStartY = ( $optimalHeight / 2) - ( $this->settings['height'] / 2 );

      $crop = $this->settings['imageResized'];
      $this->settings['imageResized'] = @imagecreatetruecolor($this->settings['width'], $this->settings['height']);
      @imagecopyresampled($this->settings['imageResized'], $crop, 0, 0, $cropStartX, $cropStartY, $this->settings['width'], $this->settings['height'], $this->settings['width'], $this->settings['height']);
  }

  private function openImage($file) {
      $extension = strtolower(strrchr($file, '.'));

      switch ($extension) {
          case '.jpg':
          case '.jpeg':
              $img = imagecreatefromjpeg($file);
              break;
          case '.gif':
              $img = imagecreatefromgif($file);
              $transparent_index = imagecolortransparent($img);
              break;
          case '.png':
              $img = imagecreatefrompng($file);
              break;
          default:
              $img = false;
              break;
      }
      return $img;
  }

  private function getDimensions() {

      switch ($this->settings['resize']) {
          case 'exact':
              $optimalWidth = $this->settings['width'];
              $optimalHeight = $this->settings['height'];
              break;
          case 'portrait':
              $optimalWidth = $this->getSizeByFixedHeight($this->settings['height']);
              $optimalHeight = $this->settings['height'];
              break;
          case 'landscape':
              $optimalWidth = $this->settings['width'];
              $optimalHeight = $this->getSizeByFixedWidth($this->settings['width']);
              break;
          case 'auto':
              $optionArray = $this->getSizeByAuto($this->settings['width'], $this->settings['height']);
              $optimalWidth = $optionArray['optimalWidth'];
              $optimalHeight = $optionArray['optimalHeight'];
              break;
          case 'crop':
              $optionArray = $this->getOptimalCrop($this->settings['width'], $this->settings['height']);
              $optimalWidth = $optionArray['optimalWidth'];
              $optimalHeight = $optionArray['optimalHeight'];
              break;
      }
      return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }

  private function getSizeByFixedHeight($newHeight) {
      $ratio = $this->settings['srcWidth'] / $this->settings['srcHeight'];
      $newWidth = $newHeight * $ratio;
      return $newWidth;
  }

  private function getSizeByFixedWidth($newWidth) {
      $ratio = $this->settings['srcHeight'] / $this->settings['srcWidth'];
      $newHeight = $newWidth * $ratio;
      return $newHeight;
  }

  private function getSizeByAuto($newWidth, $newHeight) {
      if ($this->settings['srcHeight'] < $this->settings['srcWidth']) {
          $optimalWidth = $newWidth;
          $optimalHeight = $this->getSizeByFixedWidth($newWidth);
      } elseif ($this->settings['srcHeight'] > $this->settings['srcWidth']) {
          $optimalWidth = $this->getSizeByFixedHeight($newHeight);
          $optimalHeight = $newHeight;
      } else {
          if ($newHeight < $newWidth) {
              $optimalWidth = $newWidth;
              $optimalHeight = $this->getSizeByFixedWidth($newWidth);
          } else if ($newHeight > $newWidth) {
              $optimalWidth = $this->getSizeByFixedHeight($newHeight);
              $optimalHeight = $newHeight;
          } else {
              $optimalWidth = $newWidth;
              $optimalHeight = $newHeight;
          }
      }

      return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }

  private function getOptimalCrop($newWidth, $newHeight) {

      $heightRatio = $this->settings['srcHeight'] / $newHeight;
      $widthRatio = $this->settings['srcWidth'] / $newWidth;

      if ($heightRatio < $widthRatio) {
          $optimalRatio = $heightRatio;
      } else {
          $optimalRatio = $widthRatio;
      }

      $optimalHeight = $this->settings['srcHeight'] / $optimalRatio;
      $optimalWidth = $this->settings['srcWidth'] / $optimalRatio;

      return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }

}

