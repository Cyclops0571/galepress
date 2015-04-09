@layout('layouts.master')

@section('content')
<?php
if (FALSE) {
	$cropSet = new Crop();
	$imageInfo = new imageInfoEx(null);
}

if (!$imageInfo->isValid() || count($cropSet) == 0) {
	//TODO: think for more respectfull way
	echo 'Resme ulaşılamıyor. Yüklediğiniz Resim Imaj Serverlara gönderilememiş.';
	exit;
}
$imageRatio = $imageInfo->width / $imageInfo->height;
$displayedWidth = 500;
$displayedHeight = $imageInfo->height * $displayedWidth / $imageInfo->width;
$crop = $cropSet[0];
//seçimde gösterilecek width ve heighti ayarlayalım...
$wantedRatio = $crop->Width / $crop->Height;
$cropImageWidth = $displayedWidth;
$cropImageHeight = $displayedHeight;

if ($wantedRatio > $imageRatio) {
	//wanted width is bigger than uploaded image width so width will be the max value and the shownImageHeight will be calculated respectively.
	$cropImageHeight = $cropImageWidth / $wantedRatio;
} else {
	$cropImageWidth = $cropImageHeight * $wantedRatio;
}
$i = 1; 
?>

{{ HTML::style('js/jcrop/jquery.Jcrop.css?v=' . APP_VER); }}
{{ HTML::script('js/jcrop/jquery.Jcrop.min.js?v=' . APP_VER); }}
<div class="col-md-12">
	<script type="text/javascript" language="Javascript">
        var api, current_id;
        var wantedWidth;

        window.onload = function () {
            api = $.Jcrop('#cropbox', {
                setSelect: [0, 0, 2000, 2000],
                onSelect: updateCoords,
                allowSelect: false
            });
			setSelection([0, 0, '<?php echo $cropImageWidth ?>', '<?php echo $cropImageHeight ?>'], '<?php echo $crop->CropID ?>', '<?php echo $i ?>', '<?php echo $crop->Width ?>');
			$("#saveBtn").removeClass('noTouch');
        };

        function setSelection(arr, cropID, id, wantedWidth2) {
            current_id = id;
            wantedWidth = wantedWidth2;
            $("#cropIDSet" + id).val(cropID);
            $("button").removeClass("active");
            $("#button" + id).addClass("active");
            $("#button" + id).removeClass("my-btn-success");
            $("#button" + id).addClass("btn-success");
            api.setOptions({
                keepRatio: true,
                aspectRatio: arr[2] / arr[3]
                        //minSize: [arr[2], arr[3]]
            });
            api.setSelect(arr);
            c = api.tellSelect();
            updateCoords(c);
        }

        function updateCoords(c) {
            $("#xCoordinateSet" + current_id).val(c.x);
            $("#yCoordinateSet" + current_id).val(c.y);
            $("#widthSet" + current_id).val(c.w);
            $("#heightSet" + current_id).val(c.h);
        }
        ;

        function reload_page() {
            if (confirm("Seçimleri sıfırlamak istediğinizden emin misiniz?"))
                window.location.reload();
        }
	</script>
	<?php

	?>
	<form onsubmit="return false" action="" method="post">
		<?php //burada resmin sınırlarının dışına hiç çıkılamasın....    ?>
		<div class="col-md-4" style="min-width: 500px; background: rgba(0,0,0,0.5);">
			<div class="row">
				<img width="<?php echo $displayedWidth ?>" src="<?php echo $imageInfo->webUrl . "?" . time(); ?>" id="cropbox" alt="" />
			</div>
		</div>
		<div class="col-md-3 ">
			<?php if (count($cropSet) == 1): ?>
				<div class="row">

					<input type="hidden" id="cropIDSet<?php echo $i ?>" name="cropIDSet[]" />
					<input type="hidden" id="xCoordinateSet<?php echo $i ?>" name="xCoordinateSet[]" />
					<input type="hidden" id="yCoordinateSet<?php echo $i ?>" name="yCoordinateSet[]" />
					<input type="hidden" id="widthSet<?php echo $i ?>" name="widthSet[]" />
					<input type="hidden" id="heightSet<?php echo $i ?>" name="heightSet[]" />
					<div class="col-md-6">
					</div>
					<div class="col-md-2">
						<div id="quality<?php echo $i ?>" class=""></div>
					</div>
					<?php if (@fopen($imageInfo->dir . "/" . IMAGE_CROPPED_2048, "r")): ?>
						<div class="col-md-4" >
							<img height="50px;" src="<?php echo $imageInfo->webDir . "/" . IMAGE_CROPPED_2048 . "?" . time(); ?>"/>
						</div>
					<?php endif; ?>
				</div>

			<?php else: ?>
				<?php $i = 0; ?>
				<?php foreach ($cropSet as $crop): ?>
					<?php if ($crop->ParentID == 0): ?>
						<div class="row">
							<?php
							//seçimde gösterilecek width ve heighti ayarlayalım...
							$wantedRatio = $crop->Width / $crop->Height;
							$cropImageWidth = $displayedWidth;
							$cropImageHeight = $displayedHeight;

							if ($wantedRatio > $imageRatio) {
								//wanted width is bigger than uploaded image width so width will be the max value and the shownImageHeight will be calculated respectively.
								$cropImageHeight = $cropImageWidth / $wantedRatio;
							} else {
								$cropImageWidth = $cropImageHeight * $wantedRatio;
							}
							?>
							<?php $i++; ?>
							<input type="hidden" id="cropIDSet<?php echo $i ?>" name="cropIDSet[]" />
							<input type="hidden" id="xCoordinateSet<?php echo $i ?>" name="xCoordinateSet[]" />
							<input type="hidden" id="yCoordinateSet<?php echo $i ?>" name="yCoordinateSet[]" />
							<input type="hidden" id="widthSet<?php echo $i ?>" name="widthSet[]" />
							<input type="hidden" id="heightSet<?php echo $i ?>" name="heightSet[]" />
							<div class="col-md-6">
								<button class="btn bmy-btn-success btn-block" id="button<?php echo $i ?>"
										onclick="setSelection([0, 0, '<?php echo $cropImageWidth ?>',
			                                        '<?php echo $cropImageHeight ?>'], '<?php echo $crop->CropID ?>',
			                                            '<?php echo $i ?>', '<?php echo $crop->Width ?>');
			                                    this.blur();" 
										>
											<?php echo $crop->Description; ?>
								</button>
							</div>
							<div class="col-md-2">
								<div id="quality<?php echo $i ?>" class=""></div>
							</div>
							<?php if (@fopen($imageInfo->dir . "/" . IMAGE_CROPPED_2048, "r")): ?>
								<div class="col-md-4" >
									<img height="50px;" src="<?php echo $imageInfo->webDir . "/" . IMAGE_CROPPED_2048 . "?" . time(); ?>"/>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-6">
					<input class="btn my-btn-success btn-block noTouch" id="saveBtn" type="submit" onclick="this.form.submit()" value="Kaydet" class="imageCropSaveButton" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<input class="btn my-btn-success btn-block" type="reset" onclick="reload_page()" value="Seçimleri Sıfırla" class="imageCropOtherButton" />
				</div>
			</div>
		</div>

	</form>
</div>
@endsection