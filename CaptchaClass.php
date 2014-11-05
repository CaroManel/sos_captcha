<?php
/**
 * Captcha class
 */
session_start();

class CaptchaClass {
	
	var $font = 'font/Momt___.ttf';
	var $setting;
	
	/**
	 * Construct, initializing settings: lenght, width, height
	 * 
	 * @access public
	 * @param array $settings
	 * @return void
	 */
	public function __construct($settings) {
		$this->setting['length'] = $settings['length'];
		$this->setting['width']  = $settings['width'];
		$this->setting['height'] = $settings['height'];
	}
	
	/**
	 * Set captcha random string in session
	 * 
	 * @access private
	 * @param void
	 * @return void
	 */
	private function getCaptchaString() {
		// I don't use 0,o, O, 1, I, i because they could be confusing for the user,
		// but you can customize your allowed characteres here
		$allowedChars = 'QWERTYUPASDFGHJKLZXCVBNM23456789'; 
		$allowedChars = $allowedChars . strtolower($allowedChars);
		
		$captcha = '';
		for ($i = 0; $i < $this->setting['length']; $i++)  {
			$captcha .= $allowedChars[rand(0, strlen($allowedChars) - 1)];
		}
		
		//**SESSION**
		$_SESSION['captcha'] = $captcha;
	}
	
	/**
	 * Generate captcha image
	 * 
	 * @access private
	 * @param void
	 * @return void
	 */
	private function generateImage() {
		
		//everything begis with this $img
    	$img = @imagecreate($this->setting['width'], $this->setting['height']) or die('Sorry, Cannot Initialize new GD image stream'); 
		
		//seeting colors
		$bg = mt_rand(200, 255); $bgG = mt_rand(200, 255); $bgB = mt_rand(200, 255); 
		$color1 = imagecolorallocate($img, $bg, $bgG, $bgB); 
		$color2 = imagecolorallocate($img, abs(100 - $bg), abs(100 - $bgG), abs(100 - $bgB));
		$textcolor = imagecolorallocate($img, abs(255 - $bg), abs(255 - $bgG), abs(255 - $bgB));
		$dotscolor = imagecolorallocate($img, abs(50 - $bg), abs(50 - $bgG), abs(50 - $bgB)); 
	
		//Dots in the background
	    for($i = 0; $i < ($this->setting['width']*$this->setting['height']) / 3; $i++) { 
	      imagefilledellipse($img, mt_rand(0,$this->setting['width']), mt_rand(0,$this->setting['height']), 1, 1, $dotscolor); 
	    }

		//Draw curved lines using arcs
		for ($i = 0; $i < 70; $i++) {
		    
		    imagearc( $img,
		        rand(1, 300), 
		        rand(1, 300), 
		        rand(1, 300), 
		        rand(1, 300), 
		        rand(1, 300), 
		        rand(1, 300), 
		        (rand(0, 1) ? $color1 : $color2) 
		    );
		}
		
		//font size
		$fontsize = $this->setting['height'] * 0.40;
		$textbox = imagettfbbox($fontsize, 0, $this->font, $_SESSION['captcha']) or die('Sorry, could not find/open font'); 
    	$x = ($this->setting['width'] - $textbox[4])/2; 
    	$y = ($this->setting['height'] - $textbox[5])/2; 
		imagettftext ($img, $fontsize, 0, $x, $y, $textcolor, $this->font, $_SESSION['captcha']) or die('Sorry, could not set the captcha text'); ;	
	
	 	//Draw a cross across the text 
	 	$w = imagecolorallocate($img, abs(100 - $bg), abs(100 - $bgG), abs(100 - $bgB)); 
	    $r = imagecolorallocate($img, abs(100 - $bg), abs(100 - $bgG), abs(100 - $bgB));
		
		//stlyting image
	    $style = array($r, $r, $r, $r, $r, $w, $w, $w, $w, $w); 
	    imagesetstyle($img, $style); 
	    imageline($img, 0, 10, $this->setting['width'], $this->setting['height']-10, IMG_COLOR_STYLED); 
	    imageline($img, $this->setting['width'], 10, 0, $this->setting['height']-10, IMG_COLOR_STYLED);
		
		//displaying captcha image
		//header("Cache-Control: no-cache, must-revalidate");
		header('Content-type: image/jpeg');
		imagejpeg($img);
		imagedestroy($img);
	}
	
	/**
	 * This is the one we should call to begin captcha generation
	 * 
	 * @access public
	 * @param void
	 * @return void
	 */
	public function getCaptcha() {
		$this->getCaptchaString();
		$this->generateImage();
	}

}

$captcha = new CaptchaClass(
	array(
		"length"=>5,
		"width"=>200,
		"height"=>50
	)
);

$captcha->getCaptcha();
?>