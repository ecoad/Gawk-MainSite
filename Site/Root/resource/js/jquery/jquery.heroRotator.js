/**
 * A hero rotator.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Ben Gourley <ben.gourley@clock.co.uk>
 * @version 1.0
 */
(function($) {
	
	
	$.fn.heroRotate = function(userConfig) {

		var self = this;
		
		// Default options
		var config = {
				scale : 0.95,
				transitionTime : 600,
				slideTime : 10000
		};

		// Merge default and user configs
		if (userConfig) {
			$.extend(true, config, userConfig);
		}
		
		// Set vars and cache DOM elements
		var $hero = $(this),
				$container = $("#hero-stack"),
				$images = $container.find('.hero-image'),
				
				curImage = 0,
				numImages = $images.length,
				imageHeight = $hero.innerHeight(),
				imageWidth = $hero.innerWidth(),
				isPaused = false,
				pauseProgress,
				loadedImages=0;
		
		
		/*
		 *	Create progress bar
		 */
		function createProgressBar() {
			
			this.$progressDiv = $("<div/>", {
														"id" : "progress-container"
													}).appendTo($hero);
			this.$progressBar = $("<div/>", {
														"id" : "progress-bar"
													}).appendTo($progressDiv);
													
			$progressDiv.click(function() {
				
				if (isPaused) {
					resume();
				} else {
					pause();
				}
				
			});
													
		}
		
		/*
		 *	Create prev/next navigation
		 */
		function createNavigation() {
			
			$("<span/>", {
				"id" : "hero-prev",
				"text" : "←"
			})
			.css({ display : "none" })
			.click(function () { pause(); prev(true); }) 
			.appendTo($hero);
			
			$("<span/>", {
				"id" : "hero-next",
				"text" : "→"
			})
			.css({ display : "none" })
			.click(function () { pause(); next(true); }) 
			.appendTo($hero);
			
		}
		
		/*
		 *	Moves the rotator to the image at index i,
		 * 	must supply a callback. Set scale to false if the slide shouldn't scale when animating.
		 */								
		function goToImage(i,callback,scale) {
			
			$progressBar.css({ width : 0 });
			$progressDiv.css({ display : "none" });
			
			$('#hero-next, #hero-prev').fadeOut(100);
			
			curImage = i;
			
			if (scale) {
				$images.animate({ width : config.scale * imageWidth,
								  				height : config.scale * imageHeight,
								  				opacity : 0.5
								 				}, config.transitionTime / 2)
		 				  	.animate({ width : imageWidth,
			 										height : imageHeight,
			 										opacity : 1
			 									}, config.transitionTime / 2);
		 	}
		 	
			$container.animate({ top : - (curImage * imageHeight) }, config.transitionTime, function() {
				
				
				$progressDiv.css({ display : "block" });
				$('#hero-next, #hero-prev').delay(500).fadeIn();
				
				if (!isPaused) {
					$progressBar.animate({ width : imageWidth }, config.slideTime, "linear", callback);
				} else {
					pauseProgress = 0;
				}
				
			});
		
		}
		
		/*
		 *	Adds the progress bar and navigation, then starts the hero rotation
		 */
		function startRotate() {
			createProgressBar();
			createNavigation();
			goToImage(0,next,false);
		}
		
		/*
		 * Goes to the next image in sequence
		 */
		function next() {
			goToImage((curImage+1 > numImages-1 ? 0 : curImage+1), next, true);
		}
		
		/*
		 *	Goes to the previous img in sequence
		 */
		function prev() {
			goToImage((curImage-1 < 0 ? numImages-1 : curImage-1), next ,true);
		}
		
		/*
		 * Pauses the rotation and logs the progress on current slide
		 */
		function pause() {
			$progressBar.stop();
			isPaused = true;
			pauseProgress = $progressBar.innerWidth() / imageWidth;
		}
		
		/*
		 * Resumes a paused rotation from logged progress.
		 */
		function resume() {
			
			isPaused = false;
			$progressBar.animate({ width : imageWidth }, (1 - pauseProgress) * config.slideTime, "linear", function() {
					
					$(this).css({ width : 0 });
					$progressDiv.css({ display : "none" });
					
					next();
				
			});
			
		}
		
		return this.each(function() {
			
			$(window).load(function() {
					startRotate();	
			});
			
		});
		
	};
	
	
})(jQuery);