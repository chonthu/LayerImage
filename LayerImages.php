<?

define('IMG_LOCATION', __DIR__ . '/images/');

class LayerImages
{
    protected $background       = '';
    protected $layered_imgs     = array();

  public function __construct()
	{
		/**
		 * Varify image magic is installed
		 */
		if (TRUE !== extension_loaded('imagick') && TRUE !== class_exists('Imagick')) 
		{ 
		    throw new Exception('Imagick is not loaded.'); 
		}
	}

	public static function img($name)
	{
		return IMG_LOCATION . $name;
	}

	public function background($name)
	{
		$this->background = self::img($name);
		return $this;
	}

	public function add($name, $x=0, $y=0)
	{
		$this->layered_imgs[] = array( 'name' => self::img($name), 'x' => $x, 'y' => $y);
		return $this;
	}

	public function make($name)
	{
	    $bg = new Imagick(); 
	    if (FALSE === $bg->readImage($this->background)) 
	    { 
	        throw new Exception('Background image not found'); 
	    }

	    foreach ($this->layered_imgs as $key => $img)
	    {
		    $image = new Imagick(); 
		    if (FALSE === $image->readImage($img['name'])) 
		    { 
		        throw new Exception('Could not find '.$img['name']); 
		    }
		    $bg->compositeImage($image, Imagick::COMPOSITE_DEFAULT, $img['x'], $img['y']); 
	    }

	    // Let's merge all layers (it is not mandatory). 
	    $bg->flattenImages(); 
	    $bg->setImageFileName(self::img($name)); 

	    // Let's write the image. 
	    if  (FALSE == $bg->writeImage()) 
	    { 
	        throw new Exception('Could not write image to disk'); 
	    }
	}
}
