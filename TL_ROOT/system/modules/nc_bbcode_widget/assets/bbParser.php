<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   NC BBCode Widgets
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2013
 * @website	  https://www.noltecomputer.com
 * @license   <marcel.nolte@noltecomputer.de> wrote this file. As long as you retain this notice you
 *            can do whatever you want with this stuff. If we meet some day, and you think this stuff 
 *            is worth it, you can buy me a beer in return. Meanwhile you can provide a link to my
 *            homepage, if you want, or send me a postcard. Be creative! Marcel Mathias Nolte
 */
 
/**
 * Class bbParser
 *
 * Provide bbcode to HTML decoding.
 */
class bbParser
{
	/**
	 * Decode bbcode to HTML code
	 * @param string
	 * @param array
	 * @return string
	 */
	public static function getHtml($str, $valid_tags = array('b','i','u','s','list','center','hr','url','img'))
	{
		if (in_array('b', $valid_tags))
		{
			$bb[] = "#\[b\](.*?)\[/b\]#si";
			$html[] = "<b>\\1</b>";
		}
		if (in_array('i', $valid_tags))
		{
			$bb[] = "#\[i\](.*?)\[/i\]#si";
			$html[] = "<i>\\1</i>";
		}
		if (in_array('u', $valid_tags))
		{
			$bb[] = "#\[u\](.*?)\[/u\]#si";
			$html[] = "<u>\\1</u>";
		}
		if (in_array('s', $valid_tags))
		{
			$bb[] = "#\[s\](.*?)\[/s\]#si";
			$html[] = "<s>\\1</s>";
		}
		if (in_array('list', $valid_tags))
		{
			$bb[] = "#\[list\](.*?)\[/list\]#si";
			$html[] = "<ul>\\1</ul>";
			$bb[] = "#\[\*\](.*?)\\n#si";
			$html[] = "<li>\\1</li>";
		}
		if (in_array('center', $valid_tags))
		{
			$bb[] = "#\[center\](.*?)\[/center\]#si";
			$html[] = "<center>\\1</center>";
		}
		if (in_array('hr', $valid_tags))
		{
			$bb[] = "#\[hr\]#si";
			$html[] = "<hr>";
		}
		$str = preg_replace ($bb, $html, $str);
		if (in_array('url', $valid_tags))
		{
			$patern="#\[url href=([^\]]*)\]([^\[]*)\[/url\]#i";
			$replace='<a href="\\1" target="_blank" rel="nofollow">\\2</a>';
			$str=preg_replace($patern, $replace, $str); 
		}
		if (in_array('img', $valid_tags))
		{
			$patern="#\[img\]([^\[]*)\[/img\]#i";
			$replace='<img src="\\1" alt=""/>';
			$str=preg_replace($patern, $replace, $str);  
		}
		$str = self::remove_br(nl2br($str), 'ul');
		return $str;
	}
	
	/**
	 * Remove line breaks between a given html tag
	 * @param string
	 * @param string
	 * @return string
	 */
	public static function remove_br($string, $insideTag) 
	{
		$elements = explode('<' . $insideTag . '>', $string);
		for ($i = 1; $i < count($elements); $i++)
		{
			list($before, $after) = explode('</' . $insideTag . '>', $elements[$i]);
			$before = strtr($before, array("<br />" => "", "<br/>" => "", "<br>" => ""));
			$elements[$i] = $before . '</' . $insideTag . '>' . $after;
		}
		return implode('<' . $insideTag . '>', $elements);
	}
}

if (isset($_GET["bbcode"]))
{
	echo isset($_GET['valid_tags']) ? bbParser::getHtml(htmlspecialchars($_GET["bbcode"]), explode(',', $_GET['valid_tags'])) : bbParser::getHtml(htmlspecialchars($_GET["bbcode"]));
}

?>