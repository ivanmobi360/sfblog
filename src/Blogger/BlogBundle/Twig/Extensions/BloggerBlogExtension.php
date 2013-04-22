<?php
namespace Blogger\BlogBundle\Twig\Extensions;

class BloggerBlogExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
				'created_ago' => new \Twig_Filter_Method($this, 'createdAgo')
				);
	}
	
	public function createdAgo(\DateTime $dateTime)
	{
		$delta = time() - $dateTime->getTimestamp();
		
		if ($delta<0){
			throw \InvalidArgumentException("createdAgo is unable to handle dates in the future");
		}
		
		$duration = "";
		
		if($delta < 60){
			//seconds
			$time = $delta;
			$duration = $time . " second" . ($time >1 ? "s": ''). ' ago';
		}
		else if( $delta <= 3600){
			//mins
			$time = floor($delta/60);
			$duration = $time . " minute" . ($time >1 ? "s": ''). ' ago';
		}
		
		else if ($delta < 86400){
			//hours
			$time = floor($delta/3600);
			$duration = $time . " hour" . ($time >1 ? "s": ''). ' ago';
		}
		else{
			//days
			$time = floor($delta/86400);
			$duration = $time . " day" . ($time >1 ? "s": ''). ' ago';
		}
		
		return $duration;
		
	}
	
	public function getName(){
		return 'blogger_blog_extension';
	}
	
	
}