<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\Utilities\ArrayHelper;


$params  = $displayData->params;
$images  = json_decode($displayData->images);

/* Comment this part */

//if (empty($images->image_intro))
//{
//	return;
//}

$imgclass  = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro;
$extraAttr = '';
$img       = HTMLHelper::cleanImageURL($images->image_intro);
$alt       = empty($images->image_intro_alt) && empty($images->image_intro_alt_empty) ? '' : 'alt="' . htmlspecialchars($images->image_intro_alt, ENT_COMPAT, 'UTF-8') . '"';

/* Added by Eoin */
$default_image = 'https://i.picsum.photos/id/604/485/162.jpg?hmac=J6YtAZRSioPymZLFqGwTdw8rSHI41uZZQ6pLq-AHqr4';

if(!empty($images->image_intro))
{
    $myNewImage = htmlspecialchars($img->url, ENT_COMPAT, 'UTF-8');
}
else
{
    $myNewImage = htmlspecialchars($default_image, ENT_COMPAT, 'UTF-8');
}


// Set lazyloading only for images which have width and height attributes
if ((isset($img->attributes['width']) && (int) $img->attributes['width'] > 0)
&& (isset($img->attributes['height']) && (int) $img->attributes['height'] > 0))
{
	$extraAttr = ArrayHelper::toString($img->attributes) . ' loading="lazy"';
}
?>


<figure class="<?php echo htmlspecialchars($imgclass, ENT_COMPAT, 'UTF-8'); ?> item-image">
	<?php if ($params->get('link_intro_image') && ($params->get('access-view') || $params->get('show_noauth', '0') == '1')) : ?>
		<a href="<?php echo Route::_(RouteHelper::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>"
			itemprop="url" title="<?php echo $this->escape($displayData->title); ?>">
                <!-- Original image -->
<!--			<img src="--><?php //echo htmlspecialchars($img->url, ENT_COMPAT, 'UTF-8'); ?><!--"-->
            <img src="<?php echo $myNewImage; ?>"
					 <?php echo $alt; ?>
					 itemprop="thumbnailUrl"
					 <?php echo $extraAttr; ?>
			/>
		</a>
	<?php else : ?>
<!--		<img src="--><?php //echo htmlspecialchars($img->url, ENT_COMPAT, 'UTF-8'); ?><!--"-->
        <img src="<?php echo $myNewImage; ?>"
				 <?php echo $alt; ?>
				 itemprop="thumbnail"
				 <?php echo $extraAttr; ?>
		/>
	<?php endif; ?>
	<?php if (isset($images->image_intro_caption) && $images->image_intro_caption !== '') : ?>
		<figcaption class="caption"><?php echo htmlspecialchars($images->image_intro_caption, ENT_COMPAT, 'UTF-8'); ?></figcaption>
	<?php endif; ?>
</figure>
