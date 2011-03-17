/**
 * To control a jquery jCropper
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Tom Gallacher <tom.gallacher@clock.co.uk>
 * @version 1.0
 * @options <?php echo $imageDimension["height"];?>, <?php echo $imageDimension["width"];?>,
 * <?php echo $cropDimension["Image"]["width"];?>, <?php echo $cropDimension["Image"]["height"]?>
 */
(function($) {
	$.fn.cropImage = function(options) {

		return this.each(function() {
			var imageElementContainer = $(this);
			var cropImageHeightRaw =  options.realImageHeight / imageElementContainer.children().attr("height");
			var cropImageWidthRaw =  options.realImageWidth / imageElementContainer.children().attr("width");
			console.debug(imageElementContainer.children().attr("height"));
			console.debug(imageElementContainer.children().attr("width"));
			var jcrop_api;

			function showCoords(c)	{
				var cropImageWidth = Math.round(cropImageWidthRaw * c.w);
				var cropImageHeight = Math.round(cropImageHeightRaw * c.h);
				var cropImageY = Math.round(cropImageHeightRaw * c.y);
				var cropImageX = Math.round(cropImageWidthRaw * c.x);
				var cropImageY2 = Math.round(cropImageHeightRaw * c.y2);
				var cropImageX2 = Math.round(cropImageWidthRaw * c.x2);
				$('.crop-x').val(cropImageX);
				$('.crop-y').val(cropImageY);
				$('.crop-w').val(cropImageWidth);
				$('.crop-h').val(cropImageHeight);
				$('.crop-x2').val(cropImageX2);
				$('.crop-y2').val(cropImageY2);

			}

			initJcrop();

			function initJcrop() {
				var formContrustion = "";

				formContrustion += '<dt></dt><dd>';
				formContrustion += '<label>';
				formContrustion += '<input id="to-crop" type="checkbox"/>  Enable Cropping';
				formContrustion += '</label>';
				formContrustion += '<form id="tour-form" name="tour-form" action="" method="post" enctype="multipart/form-data">';
				formContrustion += '<input class="crop-x" name="Cropped[CropX]" type="hidden" value="' + options.CropX + '"/>';
				formContrustion += '<input class="crop-y" name="Cropped[CropY]" type="hidden" value="' + options.CropY + '" />';
				formContrustion += '<input class="crop-w" name="Cropped[CropW]" type="hidden" value="' + options.CropW + '" />';
				formContrustion += '<input class="crop-h" name="Cropped[CropH]" type="hidden" value="' + options.CropH + '" />';
				formContrustion += '<input class="crop-x2" name="Cropped[CropX2]" type="hidden" value="' + options.CropX2 + '" />';
				formContrustion += '<input class="crop-y2" name="Cropped[CropY2]" type="hidden" value="' + options.CropY2 + '" />';
				formContrustion += '<input name="Cropped[Id]" type="hidden" value="' + options.getCroppedId + '"/>';
				formContrustion += '<input name="TourDetail[ImageId]" type="hidden" value="' + options.getImageId + '" />';
				formContrustion += '<input name="TourDetail[ThumbnailId]" type="hidden" value="' + options.getThumbnailId + '" />';
				formContrustion += '<input name="TourDetail[Title]" type="hidden" value="' + options.getTitle + '" />';
				formContrustion += '<input name="TourDetail[DateCreated]" type="hidden" value="' + options.getDateCreated + '" />';
				formContrustion += '<input name="TourDetail[Id]" type="hidden" value="' + options.getId + '"/>';
				formContrustion += '<input name="Submit" type="submit" class="button" value="Save" accesskey="s" title="Save all changes and return to the last page" />';
				formContrustion += '</form>';
				formContrustion += '</dd>';
				imageElementContainer.parent().append(formContrustion);

				if (($(".crop-x").val() != 0) || ($(".crop-y").val() != 0) || ($(".crop-x2").val() != 0)
						|| ($(".crop-y2").val() != 0)) {
						jcrop_api = $.Jcrop(imageElementContainer.children(), {
						aspectRatio:  options.croppedWidth / options.croppedHeight,
						onSelect: showCoords,
						setSelect:   [ $(".crop-x").val()/cropImageWidthRaw,
						               $(".crop-y").val()/cropImageHeightRaw,
						               $(".crop-x2").val()/cropImageWidthRaw,
						               $(".crop-y2").val()/cropImageHeightRaw ]});
				}
				else {

						jcrop_api = $.Jcrop(imageElementContainer.children(), {
						aspectRatio:  options.croppedWidth / options.croppedHeight,
						onSelect: showCoords,
						setSelect:   [ 0, cropHeight(), imageElementContainer.children().attr("width"),
						imageElementContainer.children().attr("height") ]});
				}

				function cropHeight() {
					var aspectRatio = options.croppedWidth / options.croppedHeight;
					var centerPointX = (imageElementContainer.children().attr("width") / 2);
					var centerPointY = (imageElementContainer.children().attr("height") / 2);
					var croppedHeight = Math.round(imageElementContainer.children().attr("width") / aspectRatio);
					var halfCroppedHeight = croppedHeight / 2;
					var centerBox = centerPointY - halfCroppedHeight;
					return centerBox;
				}

				jcrop_api.setOptions({ allowSelect: false,
					allowMove: false,
					allowSelect: false,
					allowResize: false});

				$('#to-crop').change(function(e) {
				jcrop_api.setOptions({ allowMove: this.checked,
												allowSelect: this.checked,
												allowResize: this.checked,
												allowSelect: false });
				jcrop_api.focus();});
			}
		});
	};
})(jQuery);