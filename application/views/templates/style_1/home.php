
<?php if (empty($company->image)):?>
    <?php $bg_image = base_url('assets/front/img/vericla-cover.jpg'); ?>
<?php else: ?>
    <?php $bg_image = base_url($company->image);?>
<?php endif; ?>

<section class="py-md-10 bannerimg overlay overlay-black overlay-40"
    style="background-image: url(<?php echo html_escape($bg_image) ?>);">
    <div class="container pt-12 ">
        <div class="row align-items-center justify-content-center text-center min-height-lg-35vh">
            <div class="col-md-10 col-lg-7">
                <h1 class="display-5 mb-0 text-light font-weight-bold"><?php echo html_escape($company->name) ?></h1>
                <h1 class="display-7 mb-4 text-light font-weight-bold"><?php echo html_escape($company->title) ?></p></h1>
                <?php if(!empty($services)): ?>
                    <a href="<?php echo base_url('booking/'.$company->slug) ?>" class="btn btn-primary btn-md mt-4 rounded-pill "><i class="fas fa-calendar-alt"></i> <?php echo trans('book-now') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


<section class="pt-10">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6 mb-3 mb-lg-0">
                <h4 class="h4 mb-4"><?php echo trans('about') ?></h4>
                <p class="leads"><?php echo $company->details ?></p>

                <ul class="list-unstyled p-0 m-0">
                    <?php if(!empty($company->email)): ?>
                    <li class="py-1">
                        <div class="d-flex align-items-center home1-email">
                            <span class="list-style4 mr-3">
                                <i class="fas fa-paper-plane"></i>
                            </span> <a href="mailto:<?php echo html_escape($company->email) ?>"><?php echo html_escape($company->email) ?></a>
                        </div>
                    </li>
                    <?php endif; ?>
                    
                    <?php if(!empty($company->phone)): ?>
                    <li class="py-1">
                        <div class="d-flex align-items-center">
                            <span class="list-style4 mr-3">
                                <i class="fas fa-phone"></i>
                            </span> <?php echo html_escape($company->phone) ?>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if(!empty($company->address)): ?>
                    <li class="pt-1">
                        <div class="d-flex align-items-center">
                            <span class="list-style4 mr-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </span> <?php echo html_escape($company->address) ?>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>

                <ul class="list-unstyled social-icon3 mt-2">
                    <?php if (!empty($company->facebook)) : ?>
                        <li><a href="<?= prep_url($company->facebook) ?>"><i class="lni lni-facebook-original"></i></a></li>
                    <?php endif ?>

                    <?php if (!empty($company->twitter)) : ?>
                        <li><a href="<?= prep_url($company->twitter) ?>"><i class="lni lni-twitter"></i></a></li>
                    <?php endif ?>

                    <?php if (!empty($company->instagram)) : ?>
                        <li><a href="<?= prep_url($company->instagram) ?>"><i class="lni lni-instagram-original"></i></a></li>
                    <?php endif ?>

                    <?php if (!empty($company->whatsapp)) : ?>
                        <li><a href="https://wa.me/<?= $company->whatsapp ?>"><i class="lni lni-whatsapp"></i></a></li>
                    <?php endif ?>
                </ul>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="pl-0 pl-lg-5">
                    <h4 class="h5 mb-4"><?php echo trans('business-days') ?></h4>

                    <?php $days = get_days(); ?>
                    <ul class="list-unstyled mb-5 pb-0">
                        <?php if (empty($my_days)): ?>
                        <li class="py-1">
                            <div class="d-flex">
                                <span class="list-style9 mr-3">
                                    <i class="fas fa-times"></i>
                                </span> <?php echo trans('schedule-is-not-setted') ?>
                            </div>
                        </li>
                        <?php else: ?>
                        <?php  $i=1; foreach ($days as $day): ?>

                        <?php foreach ($my_days as $asnday): ?>
                        <?php if ($asnday['day'] == $i) {
                            $check = 'check';
                            break;
                        } else {
                            $check = 'times not';
                        }
                        ?>
                        <?php endforeach ?>
                        

                        <?php if($company->time_format == 'HH'){$mstart = $my_days[$i-1]['start'];}else{$mstart = date("h:i a", strtotime($my_days[$i-1]['start']));} ?>
                        <?php if($company->time_format == 'HH'){$mend = $my_days[$i-1]['end'];}else{$mend = date("h:i a", strtotime($my_days[$i-1]['end']));} ?>

                        <li class="py-1">
                            <div class="d-flex">
                                <span class="list-style<?php if($check == 'check'){echo 3;}else{echo 9;} ?> mr-3">
                                    <i class="fas fa-<?= $check; ?>"></i>
                                </span> <?php echo trans(strtolower($day)) ?>
                                <?php if ($check == 'check'): ?>
                                <?php if (!empty($my_days[$i-1]['start'])): ?>
                                <?= '&nbsp; ('.$mstart.'-'.$mend.')' ?>
                                <?php endif ?>
                                <span class="text-success small pt-1">&nbsp; - <?php echo trans('open') ?> </span>
                                <?php else: ?>
                                <span class="text-danger small pt-1">&nbsp; - <?php echo trans('close') ?> </span>
                                <?php endif ?>
                            </div>
                        </li>

                        <?php  $i++; endforeach ?>
                        <?php endif ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</section>



<!-- Services -->
<?php if(!empty($services)): ?>
<section class="bg-light">
    <div class="container">

        <div class="text-center mb-5 mb-lg-7 mt-0 mt-lg-5 mt-xl-0">
            <h3 class="h2 mb-1"><?php echo trans('services') ?></h3>
        </div>

        <!-- Services -->
        <div class="row">

            <?php $i=1; foreach ($services as $service): ?>
                <?php include APPPATH.'views/include/service_items_'.$template.'.php'; ?>
            <?php $i++; endforeach; ?>

        </div>
        <!-- End Services -->

    </div>
</section>
<?php endif; ?>



<?php if($company->enable_testimonial == 1 && !empty($testimonials)): ?>
<section class="bg-light bbm-1 border-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <p class="fs-14 font-weight-bold text-uppercase text-primary mb-1"><?php echo trans('testimonials') ?></p>
                <h1 class="text-dark font-weight-bold w-lg-40 mx-auto mb-5"><?php echo trans('what-our-client-says-about') ?><b class="text-primary"><?php echo $company->name ?></b></h1>
            </div>
            <div class="col-md-12">
                <div class="testimonial owl-carousel owl-theme testimonial-carousel">
                    
                    <?php foreach ($testimonials as $testimonial): ?>
                        <div class="card shadow-none border-1 h-100 bg-lights mr-2 brd-10 mb-8">
                            <div class="card-body testimonial-box">
                                <div class="text-center mb-3">
                                    <div class="text-center pt-3">
                                        <img src="<?php echo base_url($testimonial->thumb) ?>" class="rounded-circle md-avatar tes-img m-auto" alt="">
                                        <div class="mt-3">
                                            <h5 class="mb-0 text-dark"><?php echo html_escape($testimonial->name) ?></h5>
                                            <p class="text-muted mb-2"><?php echo html_escape($testimonial->designation) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="pl-4 pr-4 pt-0">
                                        <h6 class="text-dark font-weight-normal"><?php echo html_escape($testimonial->feedback) ?></h6>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<?php if($company->enable_brand == 1 && !empty($brands)): ?>
<section class="bg-white pt-10 pb-10">
    <div class="container">
        <div class="brand-carousel-5 owl-carousel owl-theme">
            <?php foreach ($brands as $brand): ?>
                <?php include APPPATH.'views/templates/common/brands.php'; ?>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif; ?>
