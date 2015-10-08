<?php
/**
*	==  How it work ?  =>	 SafelyUpload(Upload-Array,Destination,Quality);
*	require_once("SafelyUpload.php");
*	$upload	=	new	SafelyUpload($_FILES['image']['tmp_name'],"up/",100);
*	$upload->resize(600);	// optionnel
*	$upload->upload();
**/
class SafelyUpload{

	var 	$max_size		= 	1048576;	// Max size allowed
	private $extensions		= 	array("jpg","png","gif","jpeg","bmp","tif");	// valides extensions

###############################
##		Class construction
###############################
	public function __construct($photo, $destination, $quality = 100){
		if(file_exists($photo['tmp_name'])){
			$this->photo	=	$photo['tmp_name'];
			if($photo['size']	<=	$this->max_size){
				if(!is_dir($destination)){
					$this->error	=	"ERROR: The destination directory does not exists";
				}
				elseif(!is_writable($destination)){
					$this->error	=	"ERROR: The destination directory is not writable";
				}
				else{
					$this->ext		=	str_replace(".","",strtolower(substr($photo['name'], -4, 4))); // Get extension
					if(in_array($this->ext, $this->extensions)){
						list($width, $height, $type) = @getimagesize($this->photo); // Get image infos
						if(preg_match("/^[0-9]+$/",$width) AND preg_match("/^[0-9]+$/",$height) AND preg_match("/^[0-9]{1,2}$/",$type)){
							$this->width		=	$width;
							$this->height		=	$height;
							$this->type			=	$type;
							$this->quality		=	preg_match("/^[0-9]+$/",$quality) ?	$quality	:	100;
							$this->time			=	time();
							$this->destination	=	preg_match("/\/$/",$destination) ?	$destination   :  $destination."/";
							$this->new_name		=	$this->destination.$this->time.".".$this->ext;
						}
						else{
							$this->error	=	"ERROR: Impossible to fetch image informations";
						}
					}
					else{
						$this->error	=	"ERROR: Invalide file extension";
					}
				}
			}
			else{
				$this->error	=	"ERROR: File too large ! Maximum allowed ".$max_size;
			}
		}
		else{
			$this->error	=	"ERROR: The uploaded file does not exists !";
		}
	}
###############################
##		Resize infos
###############################
//	public function resize($size	=	null){
//		if(!isset($this->error)){
//			$size	=	preg_match("/^[0-9]+$/",$size) ?	$size	:	600;
//			if($this->width	>=	$this->height){
//
//				$this->new_width	=	($this->width	<=	$size) ? $this->width : $size;
//				$this->new_height	= 	($this->new_width	/	$this->width)	*	$this->height;
//
//			}
//			else{
//				$this->new_height	=	($this->height	<=	$size) ? $this->height : $size;
//				$this->new_width	=	($this->new_height	/	$this->height)	*	$this->width;
//			}
//		}
//	}
###############################
##		Uploading image
###############################
	public function upload(){
		if(!isset($this->error)){
			$this->new_width	=	isset($this->new_width)	?	$this->new_width	:	$this->width;
			$this->new_height	=	isset($this->new_height)	?	$this->new_height	:	$this->height;
			$this->this_photo	=	$this->create();
			$this->new_photo	=	ImageCreateTrueColor($this->new_width,$this->new_height);
			@imagecopyresized($this->new_photo, $this->this_photo, 0, 0, 0, 0, $this->new_width, $this->new_height, $this->width, $this->height);
			$this->move();
			ImageDestroy($this->new_photo);
			return true;
		}
	}
###############################
##		Create image by type
###############################
	private function create(){
		if(!isset($this->error) AND preg_match("/^[0-9]{1,2}$/",$this->type)){
			switch($this->type) {
				case 1:
					return ImageCreateFromGIF($this->photo);
					break;
				case 3:
					return ImageCreateFromPNG($this->photo);
					break;
				case 6:
				case 15:
					return ImageCreateFromWBMP($this->photo);
					break;
				default:
					return ImageCreateFromJPEG($this->photo);
			}
		}
	}
###############################
##		Copy image to directory by type
###############################
	private function move(){
		if(!isset($this->error)){
			switch($this->type) {
				case 1:
					return imageGIF($this->new_photo,$this->new_name);
					break;
				case 3:
					return imagePNG($this->new_photo,$this->new_name);
					break;
				case 6:
				case 15:
					return imageWBMP($this->new_photo,$this->new_name);
					break;
				default:
					return imageJPEG($this->new_photo,$this->new_name,$this->quality);
			}
		}
	}

}
?>