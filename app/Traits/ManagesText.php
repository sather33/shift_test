<?php 
namespace App\Traits;

trait ManagesText
{
	protected function hyperlinksAnchored($text) 
	{
    	$pattern  = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';

    	// $pattern = '@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@';

		$callback = create_function('$matches', '
		   $url       = array_shift($matches);
		   $url_parts = parse_url($url);

		   $text = parse_url($url, PHP_URL_HOST) . parse_url($url, PHP_URL_PATH);
		   $text = preg_replace("/^www./", "", $text);

		   $last = -(strlen(strrchr($text, "/"))) + 1;
		   if ($last < 0) {
		       $text = substr($text, 0, $last) . "&hellip;";
		   }

		   return sprintf(\'<a target="blank" rel="nofollow" href="%s" style="color: #337ab7 !important;">%s</a>\', $url, $text);
		');

		return preg_replace_callback($pattern, $callback, $text);

	}

	protected function textWithoutImgTag($text)
	{
		return preg_replace("/<img[^>]+\>/i", "", $text);
	}
}