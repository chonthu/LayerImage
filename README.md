LayerImage
==========

PHP Layer Images Class for Imagick

try
{
  $shareImage = new LayerImages();
	$shareImage->background('map_venice.jpg');
	$shareImage->add('push_pin.png',100,10);
	$shareImage->add('push_pin.png',50,50);
	$shareImage->make('test.jpg');
}
catch (Exception $e)
{
	echo '<pre>';
	print_r($e);
}


echo '<pre>';
print_r($shareImage);
