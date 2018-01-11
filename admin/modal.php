<?php

$photos = Photo::findAll();

?>

<div class="modal fade" id="photo-lib">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Gallery Library</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-9">
                    <div class="thumbnails row">

                        <?php foreach ($photos as $photo) : ?>

                            <div class="col-xs-2">
                                <a role="checkbox" aria-checked="false" tabindex="0" href="#" class="thumbnail">
                                    <img src="<?= $photo->photoPath(); ?>" alt=""
                                         class="modal-thumbnails img-responsive" data="<?= $photo->getId(); ?>">
                                </a>
                                <div class="photo-id hidden"></div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
                <div class="col-md-3">
                    <div id="modal-sidebar">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <button id="set_user_image" type="button" class="btn btn-primary" disabled="true"
                            data-dismiss="modal">Apply Selection
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>